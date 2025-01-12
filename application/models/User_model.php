<?php

class User_model extends CI_Model {

    public function validate_user($email, $password) {
        $this->db->where('email', $email);
        $user = $this->db->get('users')->row();

        if ($user && password_verify($password, $user->password)) {
            return $user; // Valid user
        }

        return false; // Invalid user
    }

    public function get_users() {
        return $this->db->get('users')->result_array();  // Assuming 'users' is your table
    }

    public function get_user_by_id($id) {
        $query = $this->db->get_where('users', ['id' => $id]);
        return $query->row_array();  // Return users as an associative array
    }

    public function add_user($data) {
        return $this->db->insert('users', $data); // Assuming you have a 'users' table in your database
    }

}