<?php
require_once('vendor/autoload.php');

class CheckoutController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        \Stripe\Stripe::setApiKey(getenv('STRIPE_SECRET_KEY')); // Set your secret key
    }

    // This method handles the creation of the Stripe checkout session
    public function process() {
        // Read raw input stream and decode the cart data
        $raw_input = $this->input->raw_input_stream;
        log_message('debug', 'Raw Input Stream: ' . $raw_input);  // Log the raw input for debugging
        $inputData = json_decode($raw_input, true);

        // Check if the cart is valid
        if (!isset($inputData['cart']) || !is_array($inputData['cart']) || empty($inputData['cart'])) {
            echo json_encode(['error' => 'Invalid cart data']);
            return;
        }

        $cart = $inputData['cart']; // Access cart data

        // Validate cart items
        foreach ($cart as $item) {
            // Ensure each item has the required fields
            if (!isset($item['price']) || !isset($item['quantity']) || !isset($item['name']) ||
                !is_numeric($item['price']) || !is_numeric($item['quantity'])) {
                echo json_encode(['error' => 'Invalid item data']);
                return;
            }
        }

        // Calculate the total amount in cents
        $totalAmount = array_reduce($cart, function($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);
        $totalAmountCents = $totalAmount * 100;

        try {
            // Create a new Checkout session
            $checkoutSession = \Stripe\Checkout\Session::create([
                'line_items' => array_map(function($item) {
                    return [
                        'price_data' => [
                            'currency' => 'usd',
                            'product_data' => [
                                'name' => $item['name'],
                            ],
                            'unit_amount' => $item['price'] * 100, // Stripe uses cents
                        ],
                        'quantity' => $item['quantity'],
                    ];
                }, $cart),
                'mode' => 'payment',
                'success_url' => site_url('checkout/success'), // Redirect on success
                'cancel_url' => site_url('checkout/cancel'), // Redirect on cancel
            ]);

            // Send the session ID back as a JSON response
            header('Content-Type: application/json');
            echo json_encode(['sessionId' => $checkoutSession->id]);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Return error message if Stripe API call fails
            header('Content-Type: application/json');
            echo json_encode(['error' => 'An error occurred: ' . $e->getMessage()]);
        }
    }

    public function complete()
    {
        \Stripe\Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));;

        // Check for valid POST request
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['status' => 'error', 'message' => 'Method Not Allowed']);
            exit;
        }

        // Retrieve POST parameters
        $sessionId = $_POST['session_id'] ?? null;
        $customerEmail = $_POST['customer_email'] ?? null;
        $orderId = $_POST['order_id'] ?? null;
        $amount = $_POST['amount'] ?? null;
        $userId = $_POST['user_id'] ?? null;

        // Validate inputs
        if (empty($sessionId) || empty($orderId) || empty($amount) || empty($userId)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid input data']);
            exit;
        }

        try {
            // Retrieve session data from Stripe
            $session = \Stripe\Checkout\Session::retrieve($sessionId);
            $totalAmount = $session->amount_total / 100; // Convert from cents to dollars
            $transactionDate = date("Y-m-d H:i:s");

            // Validate transaction_date if provided
            if (isset($_POST['transaction_date']) && !strtotime($_POST['transaction_date'])) {
                echo json_encode(['status' => 'error', 'message' => 'Invalid datetime value']);
                exit;
            }

            // Database connection
            $conn = new mysqli('localhost', 'root', '', 'shop');
            if ($conn->connect_error) {
                throw new Exception("Database connection failed: " . $conn->connect_error);
            }

            // Prepare and execute SQL query
            $stmt = $conn->prepare(
                "INSERT INTO transactions (session_id, customer_email, amount, order_id, transaction_date, user_id) 
                VALUES (?, ?, ?, ?, ?, ?)"
            );
            $stmt->bind_param("sssisi", $sessionId, $customerEmail, $totalAmount, $orderId, $transactionDate, $userId);

            if (!$stmt->execute()) {
                throw new Exception("Failed to log transaction: " . $stmt->error);
            }

            // Close statement and connection
            $stmt->close();
            $conn->close();

            $invoiceId = $this->generateInvoice($userId, $amount);
            $receiptId = $this->generateReceipt($invoiceId, $orderId, $userId);

            // Send success response
            echo json_encode([
                'status' => 'success',
                'message' => 'Transaction, invoice, and receipt created successfully',
                'transaction' => [
                    'session_id' => $sessionId,
                    'customer_email' => $customerEmail,
                    'amount' => $totalAmount,
                    'order_id' => $orderId,
                    'transaction_date' => $transactionDate,
                ],
                'invoice_id' => $invoiceId,
                'receipt_id' => $receiptId,
            ]);

        } catch (\Stripe\Exception\ApiErrorException $e) {
            echo json_encode(['status' => 'error', 'message' => 'Stripe API error: ' . $e->getMessage()]);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    // Ensure this method exists only once in the class
    public function generateInvoice($userId, $totalAmount)
    {
        $this->load->model('Invoice_model');
        $invoiceId = $this->Invoice_model->create_invoice($userId, $totalAmount);
        if (!$invoiceId) {
            throw new Exception("Failed to generate invoice");
        }
        return $invoiceId;
    }

    // Ensure this method exists only once in the class
    public function generateReceipt($invoiceId, $orderId, $userId)
    {
        $this->load->model('Receipt_model');
        $receiptId = $this->Receipt_model->create_receipt($invoiceId, $orderId, $userId);
        if (!$receiptId) {
            throw new Exception("Failed to generate receipt");
        }
        return $receiptId;
    }

    // Success page
    public function success() {
        $this->load->view('checkout/success');
    }

    // Cancel page
    public function cancel() {
        echo 'Checkout was canceled!';
        $this->load->view('users/dashboard');
    }
}