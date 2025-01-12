<?php
class Receipt_model extends CI_Model {

    public function get_all_receipts() {
        // Query to get all the receipts from the database
        $query = $this->db->get('receipts');
        return $query->result_array(); // Return all the receipts as an associative array
    }

    // Fetch receipts by user ID
    public function get_receipts_by_user($user_id) {
        // Query to fetch receipts for a specific user
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('receipts');
        return $query->result_array(); // Return receipts as an associative array
    }

    public function create_receipt($invoiceId, $orderId, $userId) {
        // Insert receipt data into the "receipts" table
        $this->db->insert('receipts', [
            'invoice_id' => $invoiceId,
            'receipt_data' => $orderId,  // Store order ID related to the receipt
            'user_id' => $userId,    // User associated with the receipt
            'created_at' => date('Y-m-d H:i:s') // Timestamp for the receipt creation
        ]);
    
        // Return the inserted receipt ID
        return $this->db->insert_id();
    }
}
