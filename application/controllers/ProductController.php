<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProductController extends CI_Controller {

    // Constructor to load needed resources
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Product_model'); // Load Product model
    }

    // Display product page with all products
    public function index() {
        $data['products'] = $this->Product_model->get_all_products(); // Fetch products from the database
        $this->load->view('product/view', $data); // Load view with products data
    }

    // Fetch products for API call
    public function fetch_products() {
        $products = $this->Product_model->get_products(); // Fetch products
        echo json_encode($products); // Return as JSON
    }

    // Add a new product
    public function add_products() {
        // Get product data from the POST request
        $data = array(
            'name' => $this->input->post('name'),
            'description' => $this->input->post('description'),
            'price' => $this->input->post('price'),
            'stock_quantity' => $this->input->post('stock_quantity'),
            'created_at' => date('Y-m-d H:i:s'), // Assuming you're inserting the current timestamp
            'updated_at' => date('Y-m-d H:i:s'), // Initial value same as created_at
        );
    
        // Call the model method to insert the product
        if ($this->Product_model->add_products($data)) {
            echo json_encode(array('status' => 'success', 'message' => 'Product added successfully'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Failed to add product'));
        }
    }
}
