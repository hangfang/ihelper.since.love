<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Base extends CI_Controller{
    public function __construct(){
        
        parent::__construct();
        $this->load->library('layout');
        $this->load->helper('cookie');
        $this->load->database();
    }
}