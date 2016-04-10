<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller{
    public $error = array();
    
    public function __construct(){
        
        parent::__construct();
        $this->load->library('layout');
        $this->load->helper('cookie');
        $this->load->helper('include');
        $this->error = include_config('error');
    }
    
    public function json($data){
        $data = json_encode($data);
        if($data===false){
            $data = array();
            $data['rtn'] = json_last_error();
            $data['errmsg'] = json_last_error_msg();
            $this->output->set_content_type('json')->set_output(json_encode($data));
        }
        $this->output->set_content_type('json')->set_output($data);
    }
}