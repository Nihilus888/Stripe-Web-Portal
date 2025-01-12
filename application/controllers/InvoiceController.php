<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class InvoiceController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Invoice_model'); // Load the Invoice model
    }

    // Method to display the invoice page
    public function index() {
        $data['invoices'] = $this->Invoice_model->get_invoices(); // Get all invoices
        $this->load->view('admin/invoice', $data); // Load the view (keep it in admin folder)
    }

    // User method to display only the invoices for a specific user
    public function user_index($user_id = null) {
    // Check if the user_id is provided in the URL
        if ($user_id === null) {
            // Handle error or redirect if no user_id is passed
            echo json_encode(['success' => false, 'message' => 'User ID is missing.']);
            return;
        }

        // Fetch invoices for the specific user using the user_id
        $invoices = $this->Invoice_model->get_invoices_by_user($user_id);

        // Prepare the response
        if ($invoices) {
            echo json_encode(['success' => true, 'invoices' => $invoices]);
        } else {
            echo json_encode(['success' => false, 'invoices' => []]);
        }
    }
}