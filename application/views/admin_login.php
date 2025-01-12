<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Add jQuery -->
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">

    <!-- Navbar Section -->
    <nav class="bg-gradient-to-r from-blue-600 to-blue-800 text-white shadow-md">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="/" class="text-2xl font-bold text-white hover:text-yellow-300 transition duration-300">Home</a>
            <div class="space-x-6">
                <a href="auth/admin-login" class="hover:text-yellow-300 transition duration-300">Admin</a>
                <a href="auth/login" class="hover:text-yellow-300 transition duration-300">User</a>
            </div>
        </div>
    </nav>

    <!-- Header Section -->
    <header class="bg-blue-800 text-white p-12 text-center">
        <h1 class="text-5xl font-extrabold mb-4">Admin Login</h1>
        <p class="text-lg text-gray-200">Please enter your credentials to log in to the admin portal.</p>
    </header>

    <!-- Login Form Section -->
    <main class="flex-grow p-8">
        <div class="container mx-auto max-w-md bg-white rounded-lg shadow-md p-8">
            <h2 class="text-3xl font-semibold text-center text-blue-800 mb-6">Admin Access</h2>

            <!-- Error Message -->
            <div id="error-message" class="bg-red-500 text-white p-3 mb-6 rounded-md text-center" style="display:none;"></div>

            <!-- Login Form -->
            <form id="admin-login-form" method="POST">
                <div class="mb-6">
                    <label for="email" class="block text-sm font-semibold text-gray-700">Email:</label>
                    <input type="email" name="email" id="email" required class="w-full p-3 border-2 border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="mb-6">
                    <label for="password" class="block text-sm font-semibold text-gray-700">Password:</label>
                    <input type="password" name="password" id="password" required class="w-full p-3 border-2 border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <button type="submit" class="w-full py-3 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 transition duration-300">Login</button>
            </form>
        </div>
    </main>

    <!-- Footer Section -->
    <footer class="bg-blue-600 text-white text-center p-6 mt-12">
        <p>&copy; 2025 Your Company. All Rights Reserved.</p>
    </footer>

    <script>
        // Handle admin login form submission via AJAX
        $('#admin-login-form').submit(function(e) {
            e.preventDefault(); // Prevent normal form submission

            var email = $('#email').val();
            var password = $('#password').val();

            // Clear previous error message
            $('#error-message').hide().text('');

            // Send AJAX request to the backend
            $.ajax({
                url: '<?= base_url("auth/login_action") ?>',  // Adjust this URL if needed
                method: 'POST',
                data: { email: email, password: password },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Redirect admin after successful login
                        window.location.href = response.redirect_url;
                    } else {
                        // Show error message
                        $('#error-message').text(response.error).show();
                    }
                },
                error: function() {
                    // Show a generic error message
                    $('#error-message').text('Something went wrong. Please try again.').show();
                }
            });
        });
    </script>

</body>
</html>
