<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('User_model');
    }

    public function dashboard() {
        // Load the user dashboard view
        $this->load->view('users/dashboard');
    }

    public function fetch_users() {
        // Logic to fetch products from the database
        $this->load->model('User_model');
        $users = $this->User_model->get_users();
        echo json_encode($users);
    }

     // Add a new user
     public function add_user($data) {
        return $this->db->insert('users', $data); // Insert new product into the table
    }
    public function add_users() {
        // Get user data from the POST request
        $data = array(
            'email' => $this->input->post('email'),
            'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT), // Hash the password before saving
            'role' => $this->input->post('role'),
            'name' => $this->input->post('name'),
            'created_at' => date('Y-m-d H:i:s'), // Insert current timestamp
            'updated_at' => date('Y-m-d H:i:s'), // Initial value same as created_at
        );
    
        // Call the model method to insert the user
        if ($this->User_model->add_user($data)) {
            echo json_encode(array('status' => 'success', 'message' => 'User added successfully'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Failed to add user'));
        }
    }    
    

}