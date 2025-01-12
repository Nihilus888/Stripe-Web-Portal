<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session'); // Load session library
    }

    public function login_view() {
        // Redirect if the user is already logged in
        if ($this->session->userdata('user_id')) {
            redirect('users/dashboard'); // or 'admin/dashboard' based on role
        }
        $this->load->view('user_login'); // Render the login view
    }

    public function admin_login_view() {
        $this->load->view('admin_login'); // Load admin login view
    }

    // Method to handle the login form submission
    public function login_action() {
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        
        // Validate inputs
        if (empty($email) || empty($password)) {
            $error_message = 'Email and password are required';
            log_message('error', $error_message); // Log the error
            echo json_encode(['success' => false, 'error' => $error_message]);
            return;
        }
        
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        
        if ($query->num_rows() == 1) {
            $user = $query->row(); 
            
            if (password_verify($password, $user->password)) {
                // Set session data
                $this->session->set_userdata('user_id', $user->id);
                $this->session->set_userdata('email', $user->email);
                $this->session->set_userdata('role', $user->role);
        
                // Return success with redirect URL based on role
                if ($user->role == 'admin') {
                    echo json_encode(['success' => true, 'redirect_url' => base_url('admin/dashboard'), 'user_id' => $user->id]);
                } else {
                    echo json_encode(['success' => true, 'redirect_url' => base_url('user/dashboard'), 'user_id' => $user->id]);
                }
            } else {
                $error_message = 'Incorrect password for email: ' . $email;
                log_message('error', $error_message); // Log the error
                echo json_encode(['success' => false, 'error' => $error_message]);
            }
        } else {
            $error_message = 'Email not registered: ' . $email;
            log_message('error', $error_message); // Log the error
            echo json_encode(['success' => false, 'error' => $error_message]);
        }
    }
    

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth/login_view');
    }
}
