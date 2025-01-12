<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function dashboard() {
        $this->load->view('admin/dashboard');
    }
    public function users() {
        // Logic for the admin/users page
        $this->load->view('admin/users');
    }

    public function products() {
        $this->load->view('admin/products');
    }
}