<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {

    // Constructor to load database
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Fetch all products
    public function get_all_products() {
        $query = $this->db->get('products'); // 'products' is your table name
        return $query->result_array(); // Returns results as an associative array
    }

    public function get_products() {
        $query = $this->db->get('products'); // Ensure 'products' is the correct table name
        if ($query) {
            return $query->result_array();
        } else {
            // Add debugging to log the error
            log_message('error', 'Failed to fetch products: ' . $this->db->last_query());
            return false;
        }
    }
    

    // Add a new product
    public function add_products($data) {
        return $this->db->insert('products', $data); // Insert new product into the table
    }
}
