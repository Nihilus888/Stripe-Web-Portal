<!DOCTYPE html>
<html lang="en">
<!-- View Invoices Section -->
<div class="p-4 bg-green-100 rounded-lg shadow-lg">
    <h3 class="text-xl font-semibold mb-4 text-gray-800">View Invoices</h3>
    <p class="text-gray-600">Look at all invoices.</p>
    <a href="<?= base_url('admin/invoices') ?>" class="mt-4 inline-block px-6 py-3 bg-green-800 text-white rounded-md hover:bg-green-900 transition duration-300">
        View invoices
    </a>
</div>

<!-- Display the List of Invoices -->
<?php if (!empty($invoices)): ?>
    <div class="overflow-x-auto mt-6">
        <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
            <thead>
                <tr class="bg-gray-200 text-gray-800">
                    <th class="px-6 py-3 text-left font-medium">ID</th>
                    <th class="px-6 py-3 text-left font-medium">User ID</th>
                    <th class="px-6 py-3 text-left font-medium">Total Amount</th>
                    <th class="px-6 py-3 text-left font-medium">Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($invoices as $invoice): ?>
                    <tr class="hover:bg-gray-100 border-t">
                        <td class="px-6 py-4"><?= $invoice->id ?></td>
                        <td class="px-6 py-4"><?= $invoice->user_id ?></td>
                        <td class="px-6 py-4"><?= number_format($invoice->total_amount, 2) ?></td>
                        <td class="px-6 py-4"><?= date('M d, Y H:i', strtotime($invoice->created_at)) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <p class="mt-4 text-gray-600">No invoices found.</p>
<?php endif; ?>
</html>
