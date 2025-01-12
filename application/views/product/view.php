<!-- Product Page (product/view.php) -->
<div class="container mx-auto p-4">
    <h2 class="text-4xl font-semibold text-center mb-8">Our Products</h2>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        <?php foreach ($products as $product): ?>
        <div class="product bg-white shadow-lg rounded-lg overflow-hidden transform hover:scale-105 transition duration-300">
            <div class="p-4">
                <h3 class="text-xl font-semibold text-gray-800"><?php echo $product['name']; ?></h3>
                <p class="text-gray-600 mt-2"><?php echo $product['description']; ?></p>
                <p class="text-lg font-bold text-gray-800 mt-2"><?php echo "$" . number_format($product['price'], 2); ?></p>
                <button class="add-to-cart mt-4 w-full py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200" 
                        data-id="<?php echo $product['id']; ?>" 
                        data-name="<?php echo $product['name']; ?>" 
                        data-price="<?php echo $product['price']; ?>">
                    Add to Cart
                </button>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div id="cart" class="mt-8 p-6 bg-gray-50 rounded-lg shadow-md">
        <h3 class="text-2xl font-semibold text-gray-800 mb-4">Your Cart</h3>
        <ul id="cart-items" class="space-y-3 text-gray-600"></ul>
        <p id="total-price" class="text-xl font-bold text-gray-800 mt-4"></p>
        <button id="checkout" class="w-full py-2 mt-4 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200">
            Proceed to Checkout
        </button>
    </div>
</div>

<script>
    // Initialize cart from localStorage
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    // Calculate total price of cart
    function calculateTotal() {
        return cart.reduce((total, item) => total + item.price * item.quantity, 0);
    }

    // Update cart view with items
    function updateCart() {
        let cartItems = document.getElementById('cart-items');
        let totalPriceElement = document.getElementById('total-price');
        cartItems.innerHTML = '';

        cart.forEach(item => {
            let li = document.createElement('li');
            li.textContent = `${item.name} - ${item.quantity} x $${item.price.toFixed(2)}`;
            cartItems.appendChild(li);
        });

        let total = calculateTotal();
        totalPriceElement.textContent = `Total: $${total.toFixed(2)}`;
    }

    // Add item to cart
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function() {
            let product = {
                id: this.getAttribute('data-id'),
                name: this.getAttribute('data-name'),
                price: parseFloat(this.getAttribute('data-price')),
                quantity: 1
            };

            let existingProduct = cart.find(item => item.id === product.id);
            if (existingProduct) {
                existingProduct.quantity++;
            } else {
                cart.push(product);
            }

            localStorage.setItem('cart', JSON.stringify(cart));
            updateCart();
        });
    });

    // Checkout process
    document.getElementById('checkout').addEventListener('click', function() {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        console.log(cart);
        if (cart.length > 0) {
            let total = calculateTotal();

            // Log cart data to verify it
            console.log('Cart data:', cart);
            console.log('Cart being sent to backend:', cart);

            // Send cart details to backend for processing
            fetch('<?php echo base_url("checkout/process"); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    cart: cart,
                    total: total
                })
            })
            .then(response => {
                // Log the raw response to see what the server is sending back
                console.log('Raw Response:', response);

                // If the response is JSON, parse it and log the parsed data
                return response.json();
            })
            .then(data => {
                console.log('Parsed Data:', data); // Log the parsed JSON response

                if (data.sessionId) {
                    // Redirect to Stripe Checkout
                    const stripe = Stripe('pk_test_51Qfe7mBI9uJZT9E1DKeRNTxpaNE5Y04pcs4UZj6B00IQHZglxmA9NsKtyqxw8bokPqvEmTIwD5Wp4mpEbtcySrcL00PhzbBMcC');  // Replace with your actual Stripe public key
                    stripe.redirectToCheckout({ sessionId: data.sessionId });
                } else {
                    alert('Checkout failed: ' + data.message);
                }
            })
            .catch(error => {
                alert('An error occurred during checkout.');
                console.error(error);
            });
        }
    });

    // Initialize the cart view on page load
    updateCart();
</script>

<!-- Include Stripe.js -->
<script src="https://js.stripe.com/v3/"></script>
