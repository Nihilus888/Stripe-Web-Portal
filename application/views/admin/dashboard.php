<!DOCTYPE html>
<html lang="en">
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Manage Users -->
    <div class="p-4 bg-blue-100 rounded shadow">
        <h3 class="text-lg font-semibold mb-2">Manage Users</h3>
        <p>Add, edit, or remove users from the system.</p>
        <a href="<?= base_url('admin/users') ?>" class="mt-2 inline-block px-4 py-2 bg-blue-800 text-white rounded hover:bg-blue-900">
            Manage Users
        </a>
    </div>
    
    <!-- Manage Products -->
    <div class="p-4 bg-purple-100 rounded shadow">
        <h3 class="text-lg font-semibold mb-2">Manage Products</h3>
        <p>Create, update, or delete products available for purchase.</p>
        <a href="<?= base_url('admin/products') ?>" class="mt-2 inline-block px-4 py-2 bg-purple-800 text-white rounded hover:bg-purple-900">
            Manage Products
        </a>
    </div>
    
    <!-- View Invoices -->
    <div class="p-4 bg-green-100 rounded shadow">
        <h3 class="text-lg font-semibold mb-2">View Invoices</h3>
        <p>Look at all invoices.</p>
        <a href="<?= base_url('admin/invoices') ?>" class="mt-2 inline-block px-4 py-2 bg-green-800 text-white rounded hover:bg-green-900">
            View invoices
        </a>
    </div>

    <!-- View Receipts -->
    <div class="p-4 bg-green-100 rounded shadow">
        <h3 class="text-lg font-semibold mb-2">View Receipts</h3>
        <p>Look at all receipts</p>
        <a href="<?= base_url('admin/receipts') ?>" class="mt-2 inline-block px-4 py-2 bg-green-800 text-white rounded hover:bg-green-900">
            View receipts
        </a>
    </div>
    
    <!-- Transaction Logs -->
    <div class="p-4 bg-red-100 rounded shadow">
        <h3 class="text-lg font-semibold mb-2">Transaction Logs</h3>
        <p>View and manage payment logs from Stripe.</p>
        <a href="<?= base_url('admin/stripe') ?>" class="mt-2 inline-block px-4 py-2 bg-red-800 text-white rounded hover:bg-red-900">
            View Logs
        </a>
    </div>
</div>
</html>
