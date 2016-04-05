<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require "BaseController.php";
class Express extends BaseController {

	public function index()
	{
        $this->load->library('WeChat', '', 'wechat');
        print_r($this->wechat->getAccessToken());exit;
        if($this->input->is_ajax_request()){
            
            
        }
        $data['title'] = '物流查询';
		$this->layout->view('index', $data);
	}
}
