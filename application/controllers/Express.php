<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require "Base.php";
class Express extends Base {

	public function index()
	{
        $this->load->model('wechat', 'wechat_model');
        $accessToken = $this->wechat_model->getAccessToken();
        if($accessToken===''){
            $this->load->library('wx', array('db'=>$this->db), 'wx_library');
            $accessToken = $this->wx_library->getAccessToken();
        }
        
        var_dump($accessToken);exit;
        if($this->input->is_ajax_request()){
            
            
        }
        $data['title'] = '物流查询';
		$this->layout->view('index', $data);
	}
}
