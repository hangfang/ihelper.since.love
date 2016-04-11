<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AppController extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('WechatModel');
    }
    
    public function index(){
        
        $data = array();
        $data['title'] = '微信app测试';
        $sigObj = $this->WechatModel->getJsApiSigObj();
        
        $data = array_merge($data, $sigObj);
        $this->layout->view('Wechat/index', $data);
    }
}