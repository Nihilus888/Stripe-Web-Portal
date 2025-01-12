<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

    <!-- Navbar Section -->
    <nav class="bg-gradient-to-r from-blue-600 to-blue-800 text-white shadow-md">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="/" class="text-2xl font-bold text-white hover:text-yellow-300 transition duration-300">Dashboard</a>
            <a href="logout" class="hover:text-yellow-300 transition duration-300">Logout</a>
        </div>
    </nav>

    <!-- Header Section -->
    <header class="bg-blue-800 text-white p-12 text-center">
        <h1 class="text-5xl font-extrabold mb-4">Manage Products</h1>
        <p class="text-lg text-gray-200">Create products from this page.</p>
    </header>

    <!-- Manage Products Section -->
    <main class="container mx-auto p-8">
        <!-- Product Table -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold text-blue-800">Product List</h2>
                <button id="add-product-btn" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition">Add Product</button>
            </div>

            <table class="w-full table-auto border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-2 border">ID</th>
                        <th class="px-4 py-2 border">Name</th>
                        <th class="px-4 py-2 border">Description</th>
                        <th class="px-4 py-2 border">Price</th>
                        <th class="px-4 py-2 border">Stock Quantity</th>
                        <th class="px-4 py-2 border">Created At</th>
                        <th class="px-4 py-2 border">Updated At</th>
                    </tr>
                </thead>
                <tbody id="product-table-body">
                    <!-- Rows will be dynamically added here -->
                </tbody>
            </table>
        </div>
    </main>

    <!-- Product Modal -->
    <div id="product-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden justify-center items-center">
        <div class="bg-white rounded-lg shadow-lg p-8 max-w-sm w-full">
            <h3 id="modal-title" class="text-2xl font-bold text-blue-800 mb-6">Add Product</h3>
            <form id="product-form">
                <input type="hidden" id="product-id">
                <div class="mb-4">
                    <label for="product-name" class="block text-sm font-semibold text-gray-700">Name:</label>
                    <input type="text" id="product-name" required class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="mb-4">
                    <label for="product-description" class="block text-sm font-semibold text-gray-700">Description:</label>
                    <textarea id="product-description" required class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>
                <div class="mb-4">
                    <label for="product-price" class="block text-sm font-semibold text-gray-700">Price:</label>
                    <input type="number" id="product-price" required class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="mb-4">
                    <label for="product-stock" class="block text-sm font-semibold text-gray-700">Stock Quantity:</label>
                    <input type="number" id="product-stock" required class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="flex justify-end space-x-4">
                    <button type="button" id="close-modal-btn" class="py-2 px-4 bg-gray-300 rounded-md hover:bg-gray-400 transition">Cancel</button>
                    <button type="submit" class="py-2 px-4 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">Save</button>
                </div>
            </form>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function () {
        const productTableBody = $('#product-table-body');
        const productModal = $('#product-modal');
        const modalTitle = $('#modal-title');
        const productForm = $('#product-form');
        const productIdInput = $('#product-id');
        const productNameInput = $('#product-name');
        const productDescriptionInput = $('#product-description');
        const productPriceInput = $('#product-price');
        const productStockInput = $('#product-stock');

        // Add Product Button Click
        $('#add-product-btn').click(function () {
            modalTitle.text('Add Product');
            productModal.removeClass('hidden');
            productForm[0].reset();
            productIdInput.val('');
        });

        // Close Modal
        $('#close-modal-btn').click(function () {
            productModal.addClass('hidden');
        });

        // Handle form submit to add a new product
        productForm.submit(function (event) {
            event.preventDefault();

            const productData = {
                name: productNameInput.val(),
                description: productDescriptionInput.val(),
                price: productPriceInput.val(),
                stock_quantity: productStockInput.val()
            };

            $.ajax({
                url: '/api/add_products',
                method: 'POST',
                data: productData,  // sending data as form fields
                contentType: 'application/x-www-form-urlencoded',
                success: function (response) {
                    console.log(response);
                    productModal.addClass('hidden');
                    fetchProducts();  // Refresh the product list
                },
                error: function (error) {
                    console.error('Error adding product:', error);
                }
            });
        });

        // Fetch products from the database
        function fetchProducts() {
            $.ajax({
                url: '/api/products', // Endpoint defined in CodeIgniter
                method: 'GET',
                success: function (data) {
                    const products = JSON.parse(data);
                    renderProducts(products);
                },
                error: function (error) {
                    console.error('Error fetching products:', error);
                }
            });
        }

        // Render product table
        function renderProducts(products) {
            productTableBody.empty();
            products.forEach(product => {
                productTableBody.append(`
                    <tr>
                        <td class="px-4 py-2 border">${product.id}</td>
                        <td class="px-4 py-2 border">${product.name}</td>
                        <td class="px-4 py-2 border">${product.description}</td>
                        <td class="px-4 py-2 border">${product.price}</td>
                        <td class="px-4 py-2 border">${product.stock_quantity}</td>
                        <td class="px-4 py-2 border">${product.created_at}</td>
                        <td class="px-4 py-2 border">${product.updated_at}</td>
                    </tr>
                `);
            });
        }

        // Initial fetch
        fetchProducts();
    });
    </script>

</body>
</html>
