<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">

    <!-- Navbar Section -->
    <nav class="bg-gradient-to-r from-blue-600 to-blue-800 text-white shadow-md">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="/" class="text-2xl font-bold text-white hover:text-yellow-300 transition duration-300">Home</a>
            <div class="space-x-6">
                <a href="/auth/admin-login" class="hover:text-yellow-300 transition duration-300">Admin</a>
                <a href="/auth/login" class="hover:text-yellow-300 transition duration-300">User</a>
            </div>
        </div>
    </nav>

    <!-- Header Section -->
    <header class="bg-blue-800 text-white p-12 text-center">
        <h1 class="text-5xl font-extrabold mb-4">Welcome to Our Website</h1>
        <p class="text-lg text-gray-200">A modern platform where admins can manage users, products, and payments, while users can browse and make purchases.</p>
    </header>

    <!-- Main Content Section -->
    <main class="p-8 flex-grow">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-semibold mb-4">Build your business with ease</h2>
            <p class="text-xl text-gray-700 mb-6">Explore the features and sections in the navbar above to get started with managing your products, users, and processing payments.</p>
            <p class="text-lg text-gray-600">Our system is designed to simplify your experience and offer powerful tools for managing transactions and more.</p>
        </div>
    </main>

    <!-- Footer Section -->
    <footer class="bg-blue-600 text-white text-center p-6 mt-12">
        <p>&copy; 2025 Your Company. All Rights Reserved.</p>
    </footer>

</body>
</html>


