<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ExpressController extends MY_Controller {

	public function index()
	{
        $this->load->model('WeChatModel');
        $accessToken = $this->WeChatModel->getAccessToken();
        if($accessToken===''){
            $this->load->library('WeChat', array('db'=>$this->db));
            $accessToken = $this->WeChat->getAccessToken();
        }
        
        var_dump($accessToken);exit;
        if($this->input->is_ajax_request()){
            
            
        }
        $data['title'] = '物流查询';
		$this->layout->view('index', $data);
	}
}
