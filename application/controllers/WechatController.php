<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WechatController extends MY_Controller {

	public function index()
	{
        header('location: /');
	}
    
    public function message(){
        
        print_r($this->input->post());
    }
}
