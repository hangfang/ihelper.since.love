<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MapController extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('WechatModel');
    }
    public function txmap(){
        
        $data = array();
        $data['clientIP'] = $this->input->ip_address();
        $data['title'] = '当前位置';
        $sigObj = $this->WechatModel->getJsApiSigObj();

        $data = array_merge($data, $sigObj);
        $this->layout->setLayout('weui');
        $this->layout->view('Map/txmap', $data);
    }
    
    public function index(){
        
        $data = array();
        $data['clientIP'] = $this->input->ip_address();
        $data['title'] = '当前位置';
        $sigObj = $this->WechatModel->getJsApiSigObj();

        $data = array_merge($data, $sigObj);
        $this->layout->setLayout('weui');
        $this->layout->view('Map/index', $data);
    }
}