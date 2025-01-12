<?php
// Checkout_model.php (should extend CI_Model, not CI_Controller)

class Checkout_model extends CI_Model {

    public function process_checkout($user_id) {
        if (!$user_id) {
            return ['success' => false, 'message' => 'User ID is required'];
        }

        // Generate invoice and receipt (example logic)
        $this->load->model('Invoice_model');
        $this->load->model('Receipt_model');

        // Generate invoice
        $invoice_id = $this->Invoice_model->create_invoice($user_id);

        if (!$invoice_id) {
            return ['success' => false, 'message' => 'Failed to generate invoice'];
        }

        // Generate receipt
        $receipt_id = $this->Receipt_model->create_receipt($user_id, $invoice_id);

        if (!$receipt_id) {
            return ['success' => false, 'message' => 'Failed to generate receipt'];
        }

        // Return success response
        return ['success' => true];
    }
}
