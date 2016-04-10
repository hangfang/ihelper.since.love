<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WeatherController extends MY_Controller {
        public $_msg_weather = <<<EOF
<p class="weui_media_desc">%s天气：</p>
<p class="weui_media_desc">    日期：%s</p>
<p class="weui_media_desc">    发布时间：%s</p>
<p class="weui_media_desc">    天气：%s</p>
<p class="weui_media_desc">    当前气温：%s℃</p>
<p class="weui_media_desc">    最高：%s℃</p>
<p class="weui_media_desc">    最低：%s℃</p>
<p class="weui_media_desc">    风向：%s</p>
<p class="weui_media_desc">    风力：%s</p>
<p class="weui_media_desc">    日出时间：%s</p>
<p class="weui_media_desc">    日落时间：%s</p>      
EOF;
        
    public function __construct() {
        parent::__construct();
    }
    
    public function index(){
        $data = array();
        $data['title'] = '天气查询';
        
        if($this->input->is_ajax_request()){
            $cityid = $this->input->post('cityid');
            
            if(!$cityid){
                $this->json($this->error['weatherlack_of_cityid_error']);
            }
            
            $this->load->model('BaiduModel');
            $rt = $this->BaiduModel->getWeather($cityid);

            if(isset($rt['Reason']) && strlen($rt['Reason']) > 0){
                $data = array();
                $data['rtn'] = 1;
                $data['errmsg'] = $rt['Reason'];
                
                $this->json($data);
                return false;
            }
            
            $weather = $rt['retData'];
            $msg = sprintf($this->_msg_weather, $weather['city'], $weather['date'], $weather['time'], $weather['weather'], $weather['temp'], $weather['h_tmp'], $weather['l_tmp'], $weather['WD'], $weather['WS'], $weather['sunrise'], $weather['sunset']);

            $data = array();
            $data['rtn'] = 0;
            $data['msg'] = $msg;
            
            $this->json($data);
            return true;
        }
        
        $this->load->helper('include');
        $data['cityList'] = include_config('weather');
        $this->layout->setLayout('weui');
        $this->layout->view('Weather/index', $data);
    }
}
