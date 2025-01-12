<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Add jQuery -->
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

    <!-- Navbar Section -->
    <nav class="bg-gradient-to-r from-green-600 to-green-800 text-white shadow-md">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="/" class="text-2xl font-bold text-white hover:text-yellow-300 transition duration-300">Dashboard</a>
            <a href="logout" class="hover:text-yellow-300 transition duration-300">Logout</a>
        </div>
    </nav>

    <!-- Header Section -->
    <header class="bg-green-800 text-white p-12 text-center">
        <h1 class="text-5xl font-extrabold mb-4">Manage Users</h1>
        <p class="text-lg text-gray-200">Create users from this page.</p>
    </header>

    <!-- Manage Users Section -->
    <main class="container mx-auto p-8">
        <!-- User Table -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold text-green-800">User List</h2>
                <button id="add-user-btn" class="bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 transition">Add User</button>
            </div>

            <table class="w-full table-auto border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-2 border">ID</th>
                        <th class="px-4 py-2 border">Name</th>
                        <th class="px-4 py-2 border">Email</th>
                        <th class="px-4 py-2 border">Role</th>
                    </tr>
                </thead>
                <tbody id="user-table-body">
                    <!-- Rows will be dynamically added here -->
                </tbody>
            </table>
        </div>
    </main>

    <!-- User Modal -->
    <div id="user-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden justify-center items-center">
        <div class="bg-white rounded-lg shadow-lg p-8 max-w-sm w-full">
            <h3 id="modal-title" class="text-2xl font-bold text-green-800 mb-6">Add User</h3>
            <form id="user-form">
                <input type="hidden" id="user-id">
                
                <div class="mb-4">
                    <label for="user-name" class="block text-sm font-semibold text-gray-700">Name:</label>
                    <input type="text" id="user-name" required class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <div class="mb-4">
                    <label for="user-email" class="block text-sm font-semibold text-gray-700">Email:</label>
                    <input type="email" id="user-email" required class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <div class="mb-4">
                    <label for="user-password" class="block text-sm font-semibold text-gray-700">Password:</label>
                    <input type="password" id="user-password" required class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <div class="mb-4">
                    <label for="user-role" class="block text-sm font-semibold text-gray-700">Role:</label>
                    <select id="user-role" required class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select>
                </div>

                <div class="flex justify-end space-x-4">
                    <button type="button" id="close-modal-btn" class="py-2 px-4 bg-gray-300 rounded-md hover:bg-gray-400 transition">Cancel</button>
                    <button type="submit" class="py-2 px-4 bg-green-600 text-white rounded-md hover:bg-green-700 transition">Save</button>
                </div>
            </form>
        </div>
    </div>


    <script>
        $(document).ready(function () {
        const userTableBody = $('#user-table-body');
        const userModal = $('#user-modal');
        const modalTitle = $('#modal-title');
        const userForm = $('#user-form');
        const userIdInput = $('#user-id');
        const userNameInput = $('#user-name');
        const userEmailInput = $('#user-email');
        const userPasswordInput = $('#user-password');
        const userRoleInput = $('#user-role');

        // Fetch users from the database
        function fetchUsers() {
            $.ajax({
                url: '/api/users',  // Update with your actual API endpoint
                method: 'GET',
                success: function (data) {
                    const users = JSON.parse(data);  // Ensure that the data is in the expected format
                    renderUsers(users);
                },
                error: function (error) {
                    console.error('Error fetching users:', error);
                }
            });
        }

        // Render user table
        function renderUsers(users) {
            userTableBody.empty();
            users.forEach(user => {
                userTableBody.append(`
                    <tr>
                        <td class="px-4 py-2 border">${user.id}</td>
                        <td class="px-4 py-2 border">${user.name}</td>
                        <td class="px-4 py-2 border">${user.email}</td>
                        <td class="px-4 py-2 border">${user.role}</td>
                    </tr>
                `);
            });
        }

        // Open modal
        function openModal(title, user = null) {
            modalTitle.text(title);
            if (user) {
                userIdInput.val(user.id);
                userNameInput.val(user.name);
                userEmailInput.val(user.email);
                userPasswordInput.val('');
                userRoleInput.val(user.role);
            } else {
                userIdInput.val('');
                userNameInput.val('');
                userEmailInput.val('');
                userPasswordInput.val('');
                userRoleInput.val('user');
            }
            userModal.show();
        }

        // Close modal
        $('#close-modal-btn').click(function () {
            userModal.hide();
        });

        // Add User
        $('#add-user-btn').click(function () {
            openModal('Add User');
        });

        // Handle form submission
        userForm.submit(function (e) {
            e.preventDefault();
            const id = parseInt(userIdInput.val());
            const name = userNameInput.val();
            const email = userEmailInput.val();
            const password = userPasswordInput.val();
            const role = userRoleInput.val();

            const userData = { name, email, password, role };

            if (id) {
                // Edit user (not needed for your requirement)
                // Uncomment and implement if needed
            } else {
                // Add new user
                $.ajax({
                    url: '/api/add_users',  // Update with your actual API endpoint
                    method: 'POST',
                    data: userData,
                    success: function () {
                        userModal.hide();
                        fetchUsers();
                    },
                    error: function (error) {
                        console.error('Error adding user:', error);
                    }
                });
            }
        });

        // Initial fetch
        fetchUsers();
    });

    </script>

</body>
</html>
