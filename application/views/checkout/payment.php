<div class="container mx-auto p-4">
    <h2 class="text-3xl font-semibold mb-6">Complete Your Payment</h2>
    <div id="payment-form"></div>
    <p id="payment-result" class="mt-4"></p>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('pk_test_your_publishable_key_here'); // Replace with your Stripe Publishable Key

    // Get the cart from localStorage
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    console.log('cart', cart);

    // Check if cart is empty and show an error message
    if (cart.length === 0) {
        document.getElementById('payment-result').textContent = "Your cart is empty!";
        return;
    }

    // Send cart data to the backend to create a PaymentIntent
    fetch('<?php echo base_url("checkout/process"); ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ cart: cart }) // Send the cart data to the backend
    })
    .then(response => response.json()) // Parse JSON response
    .then(data => {
        // Check if the backend returned the client secret
        if (data.clientSecret) {
            const clientSecret = data.clientSecret;

            // Initialize Stripe Elements to handle payment method input
            const elements = stripe.elements();
            const card = elements.create('card');
            card.mount('#payment-form'); // Attach the card element to the DOM

            // Create and handle form submission for the payment
            const form = document.createElement('form');
            form.addEventListener('submit', async (e) => {
                e.preventDefault();

                // Confirm the payment with the provided clientSecret and card details
                const { paymentIntent, error } = await stripe.confirmCardPayment(clientSecret, {
                    payment_method: { card: card }
                });

                const resultEl = document.getElementById('payment-result');
                if (error) {
                    // If payment fails, show an error message
                    resultEl.textContent = `Payment failed: ${error.message}`;
                } else if (paymentIntent.status === 'succeeded') {
                    // If payment is successful, show a success message
                    resultEl.textContent = 'Payment successful!';
                    // Redirect to success page
                    window.location.href = '<?php echo site_url("checkout/success"); ?>';
                }
            });

            document.body.appendChild(form); // Append the form to the DOM
            form.appendChild(card); // Append the card element to the form
        } else {
            // Handle case where clientSecret is not returned from the backend
            document.getElementById('payment-result').textContent = "Error generating payment information.";
        }
    })
    .catch(error => {
        // Catch any error during the fetch request and show an error message
        console.error('Error:', error);
        document.getElementById('payment-result').textContent = "Error processing payment.";
    });
</script>
