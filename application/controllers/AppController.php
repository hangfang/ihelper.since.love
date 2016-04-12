<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AppController extends MY_Controller {
    public $_msg_stock = <<<EOF
<p class="weui_media_desc blue">%s</p>
<p class="weui_media_desc">股票代码: %s</p>
<p class="weui_media_desc">日期: %s</p>
<p class="weui_media_desc">时间: %s</p>
<p class="weui_media_desc">开盘价: %s元</p>
<p class="weui_media_desc">收盘价: %s元</p>
<p class="weui_media_desc">当前价格: %s元</p>
<p class="weui_media_desc">最高价: %s元</p>
<p class="weui_media_desc">最低价: %s元</p>
<p class="weui_media_desc">买一报价: %s元</p>
<p class="weui_media_desc">卖一报价: %s元</p>
<p class="weui_media_desc">成交量: %s万手</p>
<p class="weui_media_desc">成交额: %s亿</p>
<p class="weui_media_desc">涨幅: %s</p>
<p class="weui_media_desc">买一: %s股  %s元</p>
<p class="weui_media_desc">买二: %s股  %s元</p>
<p class="weui_media_desc">买三: %s股  %s元</p>
<p class="weui_media_desc">买四: %s股  %s元</p>
<p class="weui_media_desc">买五: %s股  %s元</p>
<p class="weui_media_desc">卖一: %s股  %s元</p>
<p class="weui_media_desc">卖二: %s股  %s元</p>
<p class="weui_media_desc">卖三: %s股  %s元</p>
<p class="weui_media_desc">卖四: %s股  %s元</p>
<p class="weui_media_desc">卖五: %s股  %s元</p>
<p class="weui_media_desc">分时图: <img src="%s"/></p>
<p class="weui_media_desc">日K线: <img src="%s"/></p>
<p class="weui_media_desc">周K线: <img src="%s"/></p>
<p class="weui_media_desc">月K线: <img src="%s"/></p>

<p class="weui_media_desc blue">仅供参考，非投资依据。</p>
EOF;
    
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
        $this->load->model('WechatModel');
    }
    
    public function express(){
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

            if(isset($rt['Reason']) && strlen($rt['Reason']) > 0){
                $data = array();
                $data['rtn'] = 1;
                $data['errmsg'] = $rt['Reason'];
                
                $this->json($data);
                return false;
            }
            
            
            $_trace = "";
            foreach($rt['Traces'] as $_v){
                $_trace .= '<p class="weui_media_desc">'. date('m月d日 H:i:s', strtotime($_v['AcceptTime'])) .'<br/>'. $_v['AcceptStation'] .'</p>';
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
        $this->layout->view('App/express', $data);
    }
    
    public function index(){
        
        $data = array();
        $data['title'] = '微信jsapi测试';
        $sigObj = $this->WechatModel->getJsApiSigObj();
        
        $data = array_merge($data, $sigObj);
        $this->layout->setLayout('weui');
        $this->layout->view('App/index', $data);
    }
    
    public function location(){
        
        $data = array();
        $data['title'] = '微信app测试';
        $sigObj = $this->WechatModel->getJsApiSigObj();

        $data = array_merge($data, $sigObj);
        $this->layout->setLayout('weui');
        $this->layout->view('App/location', $data);
    }
    
    public function photo(){
        
        $data = array();
        $data['title'] = 'web图像处理—简约版';
        $this->layout->setLayout('photo');
        $this->layout->view('App/photo', $data);
    }
    
    public function photopro(){
        $data = array();
        $data['title'] = 'web图像处理—专业版';
        $this->layout->setLayout('photo');
        $this->layout->view('App/photopro', $data);
    }
    
    public function stock(){
        $data = array();
        $data['title'] = '股票查询';

        if($this->input->is_ajax_request()){
            $stockid = $this->input->post('stockid');

            if(!$stockid){
                $this->json($this->error['stock_lack_of_stockid_error']);
            }

            if(preg_match('/^6[\d]{5}$/i', $stockid) === 1){
                $stockid = 'sh'. $stockid;//上海
            }elseif(preg_match('/^0[\d]{5}|3[\d]{5}$/i', $stockid) === 1){
                $stockid = 'sz'. $stockid;//深圳
            }else{
                $stockid = $stockid;
            }

            $this->load->model('BaiduModel');
            $rt = $this->BaiduModel->getStock($stockid);

            if(isset($rt['errNum']) && $rt['errNum']-0 > 0){
                $data = array();
                $data['rtn'] = 1;
                $data['errmsg'] = $rt['errMsg'];

                $this->json($data);
                return false;
            }

            $stockInfo = $rt['retData']['stockinfo'][0];
            $msg = sprintf($this->_msg_stock, $stockInfo['name'], $stockInfo['code'], $stockInfo['date'], $stockInfo['time'], $stockInfo['OpenningPrice'], $stockInfo['closingPrice'], $stockInfo['currentPrice'], $stockInfo['hPrice'], $stockInfo['lPrice'], $stockInfo['competitivePrice'], $stockInfo['auctionPrice'], number_format($stockInfo['totalNumber']/1000000, 1), number_format($stockInfo['turnover']/100000000, 2), number_format($stockInfo['increase']-0, 2).'%', $stockInfo['buyOne'], $stockInfo['buyOnePrice'], $stockInfo['buyTwo'], $stockInfo['buyTwoPrice'], $stockInfo['buyThree'], $stockInfo['buyThreePrice'], $stockInfo['buyFour'], $stockInfo['buyFourPrice'], $stockInfo['buyFive'], $stockInfo['buyFivePrice'], $stockInfo['sellOne'], $stockInfo['sellOnePrice'], $stockInfo['sellTwo'], $stockInfo['sellTwoPrice'], $stockInfo['sellThree'], $stockInfo['sellThreePrice'], $stockInfo['sellFour'], $stockInfo['sellFourPrice'], $stockInfo['sellFive'], $stockInfo['sellFivePrice'], $stockInfo['minurl'], $stockInfo['dayurl'], $stockInfo['weekurl'], $stockInfo['monthurl']);

            $data = array();
            $data['rtn'] = 0;
            $data['msg'] = $msg;

            $this->json($data);
            return true;
        }

        $this->layout->setLayout('weui');
        $this->layout->view('App/stock', $data);
    }
    
    public function weather(){
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
        $this->layout->view('App/weather', $data);
    }
}