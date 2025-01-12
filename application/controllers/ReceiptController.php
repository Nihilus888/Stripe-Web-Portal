<?php

class ReceiptController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Receipt_model'); // Load the Receipt model
    }

    public function index() {
        // Fetch all receipts
        $data['receipts'] = $this->Receipt_model->get_all_receipts();
        
        // Load the view and pass the receipts data to it
        $this->load->view('admin/receipts', $data); // View name can be adjusted if necessary
    }

    public function user_index($user_id = null) {
        // Check if the user_id is provided in the URL
            if ($user_id === null) {
                // Handle error or redirect if no user_id is passed
                echo json_encode(['success' => false, 'message' => 'User ID is missing.']);
                return;
            }
    
            // Fetch invoices for the specific user using the user_id
            $invoices = $this->Receipt_model->get_receipts_by_user($user_id);
    
            // Prepare the response
            if ($invoices) {
                echo json_encode(['success' => true, 'invoices' => $invoices]);
            } else {
                echo json_encode(['success' => false, 'invoices' => []]);
            }
        }
}

