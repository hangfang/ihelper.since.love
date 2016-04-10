<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PhotoController extends MY_Controller {
    
    public function index(){
        
        $data = array();
        $data['title'] = 'web图像处理—简约版';
        $this->layout->setLayout('photo');
        $this->layout->view('Photo/index', $data);
    }
    
    public function pro(){
        $data = array();
        $data['title'] = 'web图像处理—专业版';
        $this->layout->setLayout('photo');
        $this->layout->view('Photo/pro', $data);
    }
}