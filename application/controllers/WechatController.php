<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require "BaseController.php";
class WechatController extends BaseController {

	public function index()
	{
        header('location: /');
	}
    
    public function message(){
        
        print_r($this->input->post());
    }
}
