<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Success</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.3/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="flex justify-center items-center min-h-screen bg-green-100">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full sm:w-1/2 md:w-1/3">
            <h1 class="text-2xl font-bold text-center text-green-600">Payment Successful!</h1>

            <div class="mt-6 text-center">
                <p class="text-gray-700 text-lg">Thank you for your purchase. Your payment has been successfully processed.</p>
                <p class="mt-2 text-gray-500">You will receive a confirmation email shortly with your order details.</p>
            </div>

            <!-- Optional: Show Order Summary -->
            <div class="mt-6 border-t pt-4">
                <h2 class="text-xl font-semibold text-gray-700">Order Details</h2>
                <p class="text-gray-600">Order ID: <span class="font-bold" id="order-id"></span></p>
            </div>

            <div class="mt-6 text-center">
                <a href="<?= site_url('user/dashboard'); ?>" class="text-white bg-blue-500 hover:bg-blue-600 py-2 px-4 rounded-lg">Back to dashboard</a>
            </div>
        </div>
    </div>

    <!-- Include JavaScript for handling the session ID and sending to backend -->
    <script>
        // Extract the session_id from the URL
        const urlParams = new URLSearchParams(window.location.search);
        const sessionId = urlParams.get('session_id');

        // Display session_id as the order ID
        if (sessionId) {
            document.getElementById('order-id').innerText = sessionId;

            // Send the session_id to the backend for transaction logging
            fetch('<?php echo base_url("checkout/complete"); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    session_id: sessionId,
                    amount: document.getElementById('amount').innerText,
                    order_id: sessionId, // Use session_id as the order_id
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    console.log('Transaction logged successfully.');
                } else {
                    console.error('Error logging transaction:', data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

    </script>
</body>
</html>
