<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Add Stripe.js -->
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">Checkout</h1>
        <p class="text-gray-600 mb-4 text-center">
            Click the button below to process your checkout.
        </p>
        <button 
            id="checkout-btn" 
            class="w-full py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition">
            Process Checkout
        </button>
        <div class="message mt-4 text-center"></div>
    </div>

    <script>
        $(document).ready(function() {
            const stripe = Stripe('pk_test_51Qfe7mBI9uJZT9E1cqUnzvJ2RgrejhOacPOxg6TuCLQYvN1MwXQMcupxKOoyy2vVfXPn0XGMlTvdPuTjWsBSXMz300opsKygo8'); // Your Stripe public key

            $('#checkout-btn').on('click', function(e) {
                e.preventDefault();

                const userId = localStorage.getItem('user_id');

                if (!userId) {
                    $('.message').html('<p class="text-red-600">User not logged in. Please log in to continue.</p>');
                    return;
                }

                // AJAX call to process checkout
                $.ajax({
                    url: '<?= base_url("checkout/process_checkout") ?>', // URL to your controller's method
                    method: 'POST',
                    data: {
                        user_id: userId, // Only the user ID is needed
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.sessionId) {
                            // Redirect to Stripe Checkout
                            stripe.redirectToCheckout({ sessionId: response.sessionId });
                        } else {
                            // Handle failure
                            $('.message').html('<p class="text-red-600">There was an issue with the checkout process.</p>');
                        }
                    },
                    error: function() {
                        // Handle error
                        $('.message').html('<p class="text-red-600">An error occurred. Please try again later.</p>');
                    }
                });
            });
        });
    </script>
</body>
</html>
