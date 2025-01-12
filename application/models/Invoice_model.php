<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice_model extends CI_Model {

    // Method to get all invoices (admin view)
    public function get_invoices() {
        $query = $this->db->get('invoices');
        return $query->result_array(); // Return invoices as an array
    }

    // Method to get invoices by user_id (user view)
    public function get_invoices_by_user($user_id) {
        $this->db->where('user_id', $user_id);  // Filter invoices by user_id
        $query = $this->db->get('invoices');
        return $query->result_array(); // Return invoices for the specified user
    }

    public function create_invoice($userId, $totalAmount) {
        // Logic to create an invoice for the user
        // For example, inserting into an "invoices" table
        $this->db->insert('invoices', [
            'user_id' => $userId,
            'total_amount' => $totalAmount,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return $this->db->insert_id(); // Return the inserted invoice ID
    }
}