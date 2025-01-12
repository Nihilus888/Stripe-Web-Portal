<h1>Your Receipts</h1>
<table id="receipt-table">
    <tr>
        <th>Invoice ID</th>
        <th>Receipt Data</th>
        <th>Date</th>
    </tr>
    <!-- The receipts will be dynamically loaded here -->
</table>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Get the user_id from localStorage
        var userId = localStorage.getItem('user_id');
        
        // Check if the user_id is available
        if (userId) {
            // Make an AJAX request to get receipts for the specific user
            $.ajax({
                url: '<?= base_url("ReceiptController/user_index") ?>',  // Correct URL to call the user-specific receipts method
                method: 'GET',
                data: { user_id: userId },  // Send the user_id in the request data
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Populate the receipt table with the fetched data
                        var receipts = response.receipts;
                        var tableContent = '';

                        // Loop through each receipt and add a table row for each
                        $.each(receipts, function(index, receipt) {
                            tableContent += '<tr>';
                            tableContent += '<td>' + receipt.invoice_id + '</td>';
                            tableContent += '<td>' + receipt.receipt_data + '</td>';
                            tableContent += '<td>' + receipt.created_at + '</td>';
                            tableContent += '</tr>';
                        });

                        // Insert the table rows into the receipt table
                        $('#receipt-table').append(tableContent);
                    } else {
                        // If no receipts are found, show a message
                        $('#receipt-table').append('<tr><td colspan="3">No receipts found</td></tr>');
                    }
                },
                error: function() {
                    // Handle error during AJAX request
                    $('#receipt-table').append('<tr><td colspan="3">Error fetching receipts</td></tr>');
                }
            });
        } else {
            // Handle case where user_id is not found in localStorage
            $('#receipt-table').append('<tr><td colspan="3">User not logged in</td></tr>');
        }
    });
</script>
