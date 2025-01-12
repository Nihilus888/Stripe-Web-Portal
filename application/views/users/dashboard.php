<div class="container mx-auto p-6">
    <h2 class="text-3xl font-semibold mb-6">User Dashboard</h2>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- View Products -->
        <div class="p-6 bg-blue-50 border border-blue-200 rounded-lg shadow-md">
            <h3 class="text-xl font-bold text-blue-800 mb-3">View Products</h3>
            <p class="text-gray-700 mb-4">Browse through the products available for purchase.</p>
            <a href="<?= base_url('products') ?>" class="px-5 py-2 bg-blue-700 text-white font-medium rounded-lg hover:bg-blue-800 transition">
                View Products
            </a>
        </div>

        <!-- View Transactions -->
        <div class="p-6 bg-purple-50 border border-purple-200 rounded-lg shadow-md">
            <h3 class="text-xl font-bold text-purple-800 mb-3">View Transactions</h3>
            <p class="text-gray-700 mb-4">Check the status of your previous transactions.</p>
            <a href="/transactions" class="px-5 py-2 bg-purple-700 text-white font-medium rounded-lg hover:bg-purple-800 transition">
                View Transactions
            </a>
        </div>

        <!-- View Invoices -->
        <div class="p-6 bg-green-50 border border-green-200 rounded-lg shadow-md">
            <h3 class="text-xl font-bold text-green-800 mb-3">View Invoices</h3>
            <p class="text-gray-700 mb-4">Access your invoices for completed orders.</p>
            <a href="#" id="view-invoices" class="px-5 py-2 bg-green-700 text-white font-medium rounded-lg hover:bg-green-800 transition">
                View Invoices
            </a>
        </div>

        <!-- View Receipts -->
        <div class="p-6 bg-green-50 border border-green-200 rounded-lg shadow-md">
            <h3 class="text-xl font-bold text-green-800 mb-3">View Receipts</h3>
            <p class="text-gray-700 mb-4">Access your receipts for completed orders.</p>
            <a href="#" id="view-receipts" class="px-5 py-2 bg-green-700 text-white font-medium rounded-lg hover:bg-green-800 transition">
                View Receipts
            </a>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const userId = localStorage.getItem('user_id'); // Get user_id from local storage
        const invoicesLink = document.getElementById('view-invoices');
        
        if (userId) {
            // Dynamically set the href with the user_id
            invoicesLink.href = '<?= base_url("user/invoices/") ?>' + userId;
        } else {
            // Handle case where user_id is not available
            console.log('User not logged in');
            invoicesLink.href = '<?= base_url("user/invoices/") ?>';  // Optional fallback URL if user not logged in
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        const userId = localStorage.getItem('user_id'); // Get user_id from local storage
        const receiptsLink = document.getElementById('view-receipts');
        
        if (userId) {
            // Dynamically set the href with the user_id
            receiptsLink.href = '<?= base_url("user/receipts/") ?>' + userId;
        } else {
            // Handle case where user_id is not available
            console.log('User not logged in');
            receiptsLink.href = '<?= base_url("user/receipts/") ?>';  // Optional fallback URL if user not logged in
        }
    });
</script>
