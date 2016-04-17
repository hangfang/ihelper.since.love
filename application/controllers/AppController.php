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
<p class="weui_media_desc">买一: %s手  %s元</p>
<p class="weui_media_desc">买二: %s手  %s元</p>
<p class="weui_media_desc">买三: %s手  %s元</p>
<p class="weui_media_desc">买四: %s手  %s元</p>
<p class="weui_media_desc">买五: %s手  %s元</p>
<p class="weui_media_desc">卖一: %s手  %s元</p>
<p class="weui_media_desc">卖二: %s手  %s元</p>
<p class="weui_media_desc">卖三: %s手  %s元</p>
<p class="weui_media_desc">卖四: %s手  %s元</p>
<p class="weui_media_desc">卖五: %s手  %s元</p>
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
    
    public $_msg_lottery = <<<EOF
<p class="weui_media_desc">彩种：%s</p>
<p class="weui_media_desc">期号：%s</p>
<p class="weui_media_desc">时间：%s</p>
<p class="weui_media_desc">号码：%s</p>
%s
EOF;
    
    public $_msg_lottery_extra = <<<EOF
<p class="weui_media_desc">销量：%s</p>
<p class="weui_media_desc">奖池：%s</p>
%s
EOF;
    
    public $_msg_news = <<<EOF
<div class="container-fluid">
<!--<div class="hd">
<h1 class="page_title">资讯</h1>
</div>-->
<div class="bd">
<ul class="list-group">%s%s</ul>
</div>
</div>
EOF;

    public $_msg_news_banner = <<<EOF
<li class="list-group-item">
<a class="bg-wrapper" href="%s">
<img src="%s" class="carousel-inner img-responsive" />
<div class="banner">
<h5 class="font16">%s</h5>
</div>
</a>
</li>    
EOF;
    
    public $_msg_news_list = <<<EOF
<li class="list-group-item">
<a class="row" href="%s">
<div class="col-xs-9 no-new-line">
<div class="txt"><span>%s</span></div>
</div>
<div class="col-xs-3"><img src="%s" class="pull-right img"/></div>
</a>
</li>    
EOF;
    
    public $_ssq_pride = <<<EOF
<p class="weui_media_desc">一等奖：奖金%s&nbsp;&nbsp;共%s注</p>
<p class="weui_media_desc">二等奖：奖金%s&nbsp;&nbsp;共%s注</p>
<p class="weui_media_desc">三等奖：奖金%s&nbsp;&nbsp;共%s注</p>
<p class="weui_media_desc">四等奖：奖金%s&nbsp;&nbsp;共%s注</p>
<p class="weui_media_desc">五等奖：奖金%s&nbsp;&nbsp;共%s注</p>
<p class="weui_media_desc">六等奖：奖金%s&nbsp;&nbsp;共%s注</p>
EOF;
    
    public $_dlt_pride = <<<EOF
<p class="weui_media_desc">一等奖追加：奖金%s&nbsp;&nbsp;共%s注</p>
<p class="weui_media_desc">一&nbsp;&nbsp;&nbsp;等&nbsp;&nbsp;&nbsp;奖：奖金%s&nbsp;&nbsp;共%s注</p>
<p class="weui_media_desc">二等奖追加：奖金%s&nbsp;&nbsp;共%s注</p>
<p class="weui_media_desc">二&nbsp;&nbsp;&nbsp;等&nbsp;&nbsp;&nbsp;奖：奖金%s&nbsp;&nbsp;共%s注</p>
<p class="weui_media_desc">三等奖追加：奖金%s&nbsp;&nbsp;共%s注</p>
<p class="weui_media_desc">三&nbsp;&nbsp;&nbsp;等&nbsp;&nbsp;&nbsp;奖：奖金%s&nbsp;&nbsp;共%s注</p>
<p class="weui_media_desc">四等奖追加：奖金%s&nbsp;&nbsp;共%s注</p>
<p class="weui_media_desc">四&nbsp;&nbsp;&nbsp;等&nbsp;&nbsp;&nbsp;奖：奖金%s&nbsp;&nbsp;共%s注</p>
<p class="weui_media_desc">五等奖追加：奖金%s&nbsp;&nbsp;共%s注</p>
<p class="weui_media_desc">五&nbsp;&nbsp;&nbsp;等&nbsp;&nbsp;&nbsp;奖：奖金%s&nbsp;&nbsp;共%s注</p>
<p class="weui_media_desc">六&nbsp;&nbsp;&nbsp;等&nbsp;&nbsp;&nbsp;奖：奖金%s&nbsp;&nbsp;共%s注</p>
EOF;
    
    public $_fc3d_pride = <<<EOF
<p class="weui_media_desc">直选：奖金%s&nbsp;&nbsp;共%s注</p>
<p class="weui_media_desc">%s：奖金%s&nbsp;&nbsp;共%s注</p>
EOF;
        
    public $_pl3_pride = <<<EOF
<p class="weui_media_desc">直选：奖金%s&nbsp;&nbsp;共%s注</p>
<p class="weui_media_desc">%s：奖金%s&nbsp;&nbsp;共%s注</p>
EOF;
    
    public $_pl5_pride = <<<EOF
<p class="weui_media_desc">直选：奖金%s&nbsp;&nbsp;共%s注</p>
EOF;
    
    public $_qxc_pride = <<<EOF
<p class="weui_media_desc">一等奖：奖金%s&nbsp;&nbsp;共%s注</p>  
<p class="weui_media_desc">二等奖：奖金%s&nbsp;&nbsp;共%s注</p>
<p class="weui_media_desc">三等奖：奖金%s&nbsp;&nbsp;共%s注</p>
<p class="weui_media_desc">四等奖：奖金%s&nbsp;&nbsp;共%s注</p>
<p class="weui_media_desc">五等奖：奖金%s&nbsp;&nbsp;共%s注</p>
<p class="weui_media_desc">六等奖：奖金%s&nbsp;&nbsp;共%s注</p>
EOF;
   
    public function __construct() {
        parent::__construct();
        $this->load->model('WechatModel');
    }
    
    public function demo(){
        
        $data = array();
        $data['title'] = '页面样例';
        $sigObj = $this->WechatModel->getJsApiSigObj();
        
        $data = array_merge($data, $sigObj);
        $this->layout->setLayout('weui');
        $this->layout->view('App/demo', $data);
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
    
    public function getMusicPlayInfo(){
        
        $data = array();
        $data['hash'] = $this->input->get('hash');

        if(!$data['hash']){
            $this->json($this->error['music_lack_of_hash_error']);
        }

        $this->load->model('BaiduModel');
        $rt = $this->BaiduModel->getMusicPlayInfo($data);

        if(isset($rt['code']) && $rt['code']-0 > 0){
            $data = array();
            $data['rtn'] = $rt['code'];
            $data['errmsg'] = $rt['msg'];

            $this->json($data);
            return false;
        }

        $data = array();
        $data['rtn'] = 0;
        $data['msg'] = $rt['data'];

        $this->json($data);
        return true;
    }
    
    public function index(){
        
        $data = array();
        $data['title'] = 'App首页';
        $sigObj = $this->WechatModel->getJsApiSigObj();
        
        $data = array_merge($data, $sigObj);
        
        $this->load->helper('include');
        $data['cityList'] = include_config('weather');
        
        $this->load->helper('include');
        $data['expressList'] = include_config('kdniao');
        
        $this->load->helper('include');
        $data['lotteryList'] = array_flip(array_unique(array_flip(include_config('lottery'))));
        
        $this->layout->setLayout('weui');
        $this->layout->view('App/index', $data);
    }
    
    public function lottery(){
        $data = array();
        $data['title'] = '彩票查询';
        
        
        $this->load->helper('include');
        $lottery = include_config('lottery');
        
        if($this->input->is_ajax_request()){
            $data = array();
            $data['lotterycode'] = $this->input->get('lottery_code');
            $data['lotterycode'] = $data['lotterycode'] ? $data['lotterycode'] : '';

            $data['recordcnt'] = $this->input->get('record_cnt');
            $data['recordcnt'] = $data['recordcnt'] ? $data['recordcnt'] : 1;
            
            if(!$data['lotterycode']){
                $this->json($this->error['lottery_lack_of_lotterycode_error']);
            }
            
            $this->load->model('LotteryModel');
            $rt = $this->LotteryModel->getLottery($data);

            if(empty($rt)){
                $data = array();
                $data['rtn'] = $this->error['get_lottery_no_result_found']['errcode'];
                $data['errmsg'] = $this->error['get_lottery_no_result_found']['errmsg'];
                
                $this->json($data);
                return false;
            }
            
            $lottery = array_flip($lottery);
            foreach($rt as $_v){
                $code = array();
                isset($_v['a']) && $code[] = $_v['a'];
                isset($_v['b']) && $code[] = $_v['b'];
                isset($_v['c']) && $code[] = $_v['c'];
                isset($_v['d']) && $code[] = $_v['d'];
                isset($_v['e']) && $code[] = $_v['e'];
                isset($_v['f']) && $code[] = $_v['f'];
                isset($_v['g']) && $code[] = $_v['g'];
                
                $pride_info = '';
                switch($data['lotterycode']){
                    case 'ssq':
                        $pride_info = sprintf($this->_ssq_pride, $_v['first'], $_v['first_num'], $_v['second'], $_v['second_num'], $_v['third'], $_v['third_num'], $_v['forth'], $_v['forth_num'], $_v['fivth'], $_v['fivth_num'], $_v['sixth'], $_v['sixth_num']);
                        break;
                    case 'dlt':
                        $pride_info = sprintf($this->_dlt_pride, $_v['first_add'], $_v['first_add_num'], $_v['first'], $_v['first_num'], $_v['second_add'], $_v['second_add_num'], $_v['second'], $_v['second_num'], $_v['third_add'], $_v['third_add_num'], $_v['third'], $_v['third_num'], $_v['forth_add'], $_v['forth_add_num'], $_v['forth'], $_v['forth_num'], $_v['fivth_add'], $_v['fivth_add_num'], $_v['fivth'], $_v['fivth_num'], $_v['sixth'], $_v['sixth_num']);
                        break;
                    case 'fc3d':
                        $pride_info = sprintf($this->_fc3d_pride, $_v['first'], $_v['first_num'], $_v['second']>200?'组三':'组六', $_v['second'], $_v['second_num']);
                        break;
                    case 'pl3':
                        $pride_info = sprintf($this->_pl3_pride, $_v['first'], $_v['first_num'], $_v['second']>200?'组三':'组六', $_v['second'], $_v['second_num']);
                        break;
                    case 'pl5':
                        $pride_info = sprintf($this->_pl5_pride, $_v['first'], $_v['first_num']);
                        break;
                    case 'qxc':
                        $pride_info = sprintf($this->_qxc_pride, $_v['first'], $_v['first_num'], $_v['second'], $_v['second_num'], $_v['third'], $_v['third_num'], $_v['forth'], $_v['forth_num'], $_v['fivth'], $_v['fivth_num'], $_v['sixth'], $_v['sixth_num']);
                        break;
                }
                
                $extra = sprintf($this->_msg_lottery_extra, number_format($_v['remain'], 0, '', ','), number_format($_v['sell'], 0, '', ','), $pride_info);
                $msg = sprintf($this->_msg_lottery, $lottery[$data['lotterycode']], $_v['expect'], substr($_v['insert_time'], 0, 10), implode(',', $code), $extra);
            }
                        
            $data = array();
            $data['rtn'] = 0;
            $data['msg'] = $msg;
            
            $this->json($data);
            return true;
        }
        
        $lottery = array_flip(array_unique(array_flip($lottery)));
        
        $data['lotteryList'] = $lottery;
        
        $sigObj = $this->WechatModel->getJsApiSigObj();

        $data = array_merge($data, $sigObj);
        $this->layout->setLayout('weui');
        $this->layout->view('App/lottery', $data);
    }
    
    public function location(){
        
        $data = array();
        $data['title'] = '微信app测试';
        $sigObj = $this->WechatModel->getJsApiSigObj();

        $data = array_merge($data, $sigObj);
        $this->layout->setLayout('weui');
        $this->layout->view('App/location', $data);
    }
    
    public function missing(){
        
        $data = array();
        $data['title'] = '页面丢失...';
        $this->layout->setLayout('empty');
        $this->layout->view('App/missing', $data);
    }
    
    public function music(){
        
        $data = array();
        $data['title'] = '在线音乐';
        
        if($this->input->is_ajax_request()){
            $data = array();
            $data['s'] = $this->input->get('name');
            $data['s'] = $data['s'] ? $data['s'] : '';
            
            $data['page'] = $this->input->get('page');
            $data['page'] = $data['page'] ? $data['page'] : 1;
            
            $data['size'] = $this->input->get('size');
            $data['size'] = $data['size'] ? $data['size'] : 10;
            
            if(!$data['s']){
                $this->json($this->error['music_lack_of_name_error']);
            }
            
            $this->load->model('BaiduModel');
            $rt = $this->BaiduModel->getMusic($data);

            if(isset($rt['code']) && $rt['code']-0 > 0){
                $data = array();
                $data['rtn'] = $rt['code'];
                $data['errmsg'] = $rt['msg'];
                
                $this->json($data);
                return false;
            }
            
            $music = $rt['data'];

            $data = array();
            $data['rtn'] = 0;
            $data['msg'] = $music;
            
            $this->json($data);
            return true;
        }
        
        $sigObj = $this->WechatModel->getJsApiSigObj();

        $data = array_merge($data, $sigObj);
        $this->layout->setLayout('weui');
        $this->layout->view('App/music', $data);
    }
    
    public function photo(){
        
        $data = array();
        $data['title'] = 'web图像处理—简约版';
        $this->layout->setLayout('empty');
        $this->layout->view('App/photo', $data);
    }
    
    public function photopro(){
        $data = array();
        $data['title'] = 'web图像处理—专业版';
        $this->layout->setLayout('empty');
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
            $msg = sprintf($this->_msg_stock, $stockInfo['name'], $stockInfo['code'], $stockInfo['date'], $stockInfo['time'], $stockInfo['OpenningPrice'], $stockInfo['closingPrice'], $stockInfo['currentPrice'], $stockInfo['hPrice'], $stockInfo['lPrice'], $stockInfo['competitivePrice'], $stockInfo['auctionPrice'], number_format($stockInfo['totalNumber']/1000000, 1), number_format($stockInfo['turnover']/100000000, 2), number_format($stockInfo['increase']-0, 2).'%', number_format($stockInfo['buyOne']/100, 0), $stockInfo['buyOnePrice'], number_format($stockInfo['buyTwo']/100, 0), $stockInfo['buyTwoPrice'], number_format($stockInfo['buyThree']/100, 0), $stockInfo['buyThreePrice'], number_format($stockInfo['buyFour']/100, 0), $stockInfo['buyFourPrice'], number_format($stockInfo['buyFive']/100, 0), $stockInfo['buyFivePrice'], number_format($stockInfo['sellOne']/100, 0), $stockInfo['sellOnePrice'], number_format($stockInfo['sellTwo']/100, 0), $stockInfo['sellTwoPrice'], number_format($stockInfo['sellThree']/100, 0), $stockInfo['sellThreePrice'], number_format($stockInfo['sellFour']/100, 0), $stockInfo['sellFourPrice'], number_format($stockInfo['sellFive']/100, 0), $stockInfo['sellFivePrice'], $stockInfo['minurl'], $stockInfo['dayurl'], $stockInfo['weekurl'], $stockInfo['monthurl']);

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
                $this->json($this->error['weather_lack_of_cityid_error']);
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
    
    public function news(){
        
        $data = array();
        $this->input->get('keyword') && $data['word'] = $this->input->get('keyword');
        
        $data['page'] = $this->input->get('page') ? $this->input->get('page') : rand(1,9999);
        
        $data['rand'] = 1;
        $data['num'] = 8;
        
        $this->load->model('BaiduModel');
        $rt = $this->BaiduModel->getNews($data);
        
        
        $data = array();
        $data['rtn'] = 0;
        $msg_news_list = $msg_news_banner = '';
        if($rt['code']!==200){
            $msg_news_banner = sprintf($this->_msg_news_banner, '/static/public/images/app/1.jpg', '新闻飞走了');
            $data['msg'] = sprintf($this->_msg_news, $msg_news_banner, '');
        }else{
            foreach($rt['newslist'] as $_k=>$_v){
                if($_k==0){
                    $msg_news_banner = sprintf($this->_msg_news_banner, $_v['url'], $_v['picUrl'], $_v['title']);
                }else{
                    $msg_news_list .= sprintf($this->_msg_news_list, $_v['url'], $_v['title'], $_v['picUrl']);
                }
            }
            
             $data['msg'] = sprintf($this->_msg_news, $msg_news_banner, $msg_news_list);
        }
        
        if($this->input->is_ajax_request()){
            $this->json($data);
            return true;
        }
        
        $data['title'] = 'WeApp-资讯';
        $this->layout->setLayout('weui');
        $this->layout->view('App/news', $data);
    }
    
    public function pano(){
        
        $data = array();
        $data['title'] = '当前位置街景';
        $sigObj = $this->WechatModel->getJsApiSigObj();

        $data = array_merge($data, $sigObj);
        $this->layout->setLayout('weui');
        $this->layout->view('App/pano', $data);
    }
    
    public function checkLottery(){
        
        $lottery_type = ucfirst($this->input->get('lottery_type'));
        $funcName = 'check'.$lottery_type;
        $this->$funcName();
    }
    
    public function checkSsq(){
        $data = array();
        $data['a'] = str_pad(intval($this->input->get('a')), 2, 0, STR_PAD_LEFT);
        $data['b'] = str_pad(intval($this->input->get('b')), 2, 0, STR_PAD_LEFT);
        $data['c'] = str_pad(intval($this->input->get('c')), 2, 0, STR_PAD_LEFT);
        $data['d'] = str_pad(intval($this->input->get('d')), 2, 0, STR_PAD_LEFT);
        $data['e'] = str_pad(intval($this->input->get('e')), 2, 0, STR_PAD_LEFT);
        $data['f'] = str_pad(intval($this->input->get('f')), 2, 0, STR_PAD_LEFT);
        $data['g'] = str_pad(intval($this->input->get('g')), 2, 0, STR_PAD_LEFT);
        
        $this->load->model('LotteryModel');
        $rt = $this->LotteryModel->checkSsq($data);
        
        if(empty($rt)){
            $rt = array();
            $rt['rtn'] = 0;
            foreach($data as &$_v){
                $_v = str_pad($_v, 2, '0', STR_PAD_LEFT);
            }
            $rt['msg'] = '<p class="weui_media_desc">很遗憾，<span class="text-primary">'.implode('</span>,<span class="text-primary">', array_slice($data, 0, 6)).'</span>+<span class="text-danger">'. $data['g'] .'</span>未中奖...</p>';
            $this->json($rt);
            return true;
        }
        
        
        
        $str = '';
        foreach($rt as $_k=>$_v){
            if($_k==='二等奖' || $_k==='一等奖'){
                foreach($_v as $_vv){
                    $str .= '<p class="weui_media_desc">'.date('Y-m-d', strtotime($_vv['insert_time'])).'&nbsp;&nbsp;中'. $_k .'，奖金<span class="text-danger">￥'. number_format($_vv['pride_value'], 0, '', ',') .'元</span></p>';
                }
            }else{
                $str .= '<p class="weui_media_desc">中'. $_k .'<span class="text-danger">'. $_v .'次</span></p>';
            }
        }
        
        $rt = array();
        $rt['rtn'] = 0;
        $rt['msg'] = '<p class="weui_media_desc">恭喜你，<span class="text-primary">'.implode('</span>,<span class="text-primary">', array_slice($data, 0, 6)).'</span>+<span class="text-danger">'. $data['g'] .'</span></p>'. $str;
        $this->json($rt);
        return true;
    }
    
    public function checkFc3d(){
        $data = array();
        $data['a'] = intval($this->input->get('a'));
        $data['b'] = intval($this->input->get('b'));
        $data['c'] = intval($this->input->get('c'));
        
        $this->load->model('LotteryModel');
        $rt = $this->LotteryModel->checkFc3d($data);
        
        if(empty($rt)){
            $rt = array();
            $rt['rtn'] = 0;
            $rt['msg'] = '<p class="weui_media_desc">很遗憾，<span class="text-primary">'.implode('</span>,<span class="text-primary">', $data).'</span>未中奖...</p>';
            $this->json($rt);
            return true;
        }
        
        
        
        $str = '';
        foreach($rt as $_k=>$_v){
            $str .= '<p class="weui_media_desc">'. $_k .'<span class="text-danger">'. $_v .'次</span></p>';
        }
        
        $rt = array();
        $rt['rtn'] = 0;
        $rt['msg'] = '<p class="weui_media_desc">恭喜你，<span class="text-primary">'.implode('</span>,<span class="text-primary">', $data).'</span></p>'. $str;
        $this->json($rt);
        return true;
    }
    
    public function checkDlt(){
        $data = array();
        $data['a'] = intval($this->input->get('a'));
        $data['b'] = intval($this->input->get('b'));
        $data['c'] = intval($this->input->get('c'));
        $data['d'] = intval($this->input->get('d'));
        $data['e'] = intval($this->input->get('e'));
        $data['f'] = intval($this->input->get('f'));
        $data['g'] = intval($this->input->get('g'));
        
        $rt = array();
        $rt['rtn'] = 0;
        foreach($data as &$_v){
            $_v = str_pad($_v, 2, '0', STR_PAD_LEFT);
        }
        $rt['msg'] = '很遗憾，<span class="text-primary">'.implode('</span>,<span class="text-primary">', array_slice($data, 0, 5)).'</span>+<span class="text-danger">'. implode('</span>&nbsp;&nbsp;<span class="text-danger">', array_slice($data, 5, 2)) .'</span>未中奖...';
        $this->json($rt);
        return true;
    }
    
    public function checkPl5(){
        $data = array();
        $data['a'] = intval($this->input->get('a'));
        $data['b'] = intval($this->input->get('b'));
        $data['c'] = intval($this->input->get('c'));
        $data['d'] = intval($this->input->get('d'));
        $data['e'] = intval($this->input->get('e'));
        
        $rt = array();
        $rt['rtn'] = 0;
        $rt['msg'] = '很遗憾，<span class="text-primary">'.implode('</span>,<span class="text-primary">', $data).'</span>未中奖...';
        $this->json($rt);
        return true;
    }
    
    public function checkPl3(){
        $data = array();
        $data['a'] = intval($this->input->get('a'));
        $data['b'] = intval($this->input->get('b'));
        $data['c'] = intval($this->input->get('c'));
        
        $rt = array();
        $rt['rtn'] = 0;
        $rt['msg'] = '很遗憾，<span class="text-primary">'.implode('</span>,<span class="text-primary">', $data).'</span>未中奖...';
        $this->json($rt);
        return true;
    }
    
    public function checkQxc(){
        $data = array();
        $data['a'] = intval($this->input->get('a'));
        $data['b'] = intval($this->input->get('b'));
        $data['c'] = intval($this->input->get('c'));
        $data['d'] = intval($this->input->get('d'));
        $data['e'] = intval($this->input->get('e'));
        $data['f'] = intval($this->input->get('f'));
        $data['g'] = intval($this->input->get('g'));
        
        $rt = array();
        $rt['rtn'] = 0;
        $rt['msg'] = '很遗憾，<span class="text-primary">'.implode('</span>,<span class="text-primary">', $data).'</span>未中奖...';
        $this->json($rt);
        return true;
    }
}