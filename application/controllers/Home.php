<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    // Constructor to load needed resources
    public function __construct() {
        parent::__construct();
        // Load the URL helper if not loaded yet
        $this->load->helper('url');
    }

    // Default function for the home page
    public function index() {
        $this->load->view('home');
    }
}