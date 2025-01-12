<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function authenticate_user($email, $password) {
        $query = $this->db->get_where('users', ['email' => $email, 'password' => md5($password)]);
        return $query->row_array();
    }

    public function authenticate_admin($email, $password) {
        $query = $this->db->get_where('admins', ['email' => $email, 'password' => md5($password)]);
        return $query->row_array();
    }
}
