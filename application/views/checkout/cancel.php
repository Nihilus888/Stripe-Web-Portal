<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failed</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.3/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="flex justify-center items-center min-h-screen bg-red-100">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full sm:w-1/2 md:w-1/3">
            <h1 class="text-2xl font-bold text-center text-red-600">Payment Failed</h1>

            <div class="mt-6 text-center">
                <p class="text-gray-700 text-lg">Unfortunately, there was an issue processing your payment. Please try again later or use a different payment method.</p>
                <p class="mt-2 text-gray-500">If you continue to experience issues, feel free to contact our support team.</p>
            </div>

            <!-- Optional: Show Error Message -->
            <div class="mt-6 border-t pt-4">
                <h2 class="text-xl font-semibold text-gray-700">Error Details</h2>
                <p class="text-gray-600">Payment could not be processed at this time. Please check your payment details and try again.</p>
            </div>

            <div class="mt-6 text-center">
                <a href="<?= site_url('checkout'); ?>" class="text-white bg-yellow-500 hover:bg-yellow-600 py-2 px-4 rounded-lg">Try Again</a>
                <a href="<?= site_url('home'); ?>" class="text-white bg-blue-500 hover:bg-blue-600 py-2 px-4 rounded-lg ml-4">Back to Home</a>
            </div>
        </div>
    </div>
</body>
</html>