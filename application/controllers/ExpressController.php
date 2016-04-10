<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ExpressController extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index(){
        $data = array();
        $data['title'] = '物流查询';
        
        if($this->input->is_ajax_request()){
            $com = $this->input->post('com');
            $nu = $this->input->post('nu');
            
            if(!$com){
                $this->json($this->error['express_lack_of_com_error']);
            }
            
            if(!$nu){
                $this->json($this->error['express_lack_of_nu_error']);
            }
            
            $this->load->model('KuaidiModel');
            $rt = $this->KuaidiModel->kdniao($com, $nu);

            if(strlen($rt['Reason']) > 0){
                $data = array();
                $data['rtn'] = 1;
                $data['errmsg'] = $rt['Reason'];
                
                $this->json($data);
                return false;
            }
            
            
            $_trace = "";
            foreach($rt['Traces'] as $_v){
                $_trace .= '    时间:'. date('m月d日 H:i:s', strtotime($_v['AcceptTime'])) ."\n";
                $_trace .= '    信息:'. $_v['AcceptStation'] ."\n";
            }

            $data = array();
            $data['rtn'] = 0;
            $data['msg'] = $_trace;
            
            $this->json($data);
            return true;
        }
        
        $this->load->helper('include');
        $data['expressList'] = include_config('kdniao');
        $this->layout->setLayout('weui');
        $this->layout->view('Express/index', $data);
    }
}
