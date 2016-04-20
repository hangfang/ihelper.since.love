<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends MY_Controller {
   
    public function __construct() {
        parent::__construct();
        $this->load->model('WechatModel');
    }
    
    
    public function index(){
        $data = array();
        $data['title'] = '个人中心';
        
        $sigObj = $this->WechatModel->getJsApiSigObj();

        $data = array_merge($data, $sigObj);
        $this->layout->setLayout('weui');
        $this->layout->view('User/index', $data);
    }
}
