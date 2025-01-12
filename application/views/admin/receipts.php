<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipts</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans max-w-3xl mx-auto my-5 p-5 border border-gray-300 rounded-lg shadow-lg">
    <h1 class="text-center text-2xl font-bold text-gray-800">Receipts List</h1>

    <!-- Receipts Table -->
    <table class="w-full mt-5 border-collapse">
        <thead>
            <tr>
                <th class="py-2 px-4 border border-gray-300 bg-gray-100 text-left text-gray-700">Receipt ID</th>
                <th class="py-2 px-4 border border-gray-300 bg-gray-100 text-left text-gray-700">Invoice ID</th>
                <th class="py-2 px-4 border border-gray-300 bg-gray-100 text-left text-gray-700">Date & Time</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($receipts as $receipt): ?>
                <tr>
                    <td class="py-2 px-4 border border-gray-300"><?php echo $receipt['id']; ?></td>
                    <td class="py-2 px-4 border border-gray-300"><?php echo $receipt['invoice_id']; ?></td>
                    <td class="py-2 px-4 border border-gray-300"><?php echo $receipt['created_at']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="mt-8 text-center text-gray-600">
        <p class="text-base">Thank you for your business!</p>
    </div>
</body>
</html>
