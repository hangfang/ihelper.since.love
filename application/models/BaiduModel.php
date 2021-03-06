<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BaiduModel extends MY_Model{
    
    public $_msg_weather = <<<EOF
天气(%s)
    日期：%s
    发布时间：%s
    天气：%s
    当前气温：%s℃
    最高：%s℃
    最低：%s℃
    风向：%s
    风力：%s
    日出时间：%s
    日落时间：%s        
EOF;
    
    public $_msg_stock = <<<EOF
%s:
    股票代码: %s
    日期: %s
    时间: %s
    开盘价: %s元
    收盘价: %s元
    当前价格: %s元
    最高价: %s元
    最低价: %s元
    买一报价: %s元
    卖一报价: %s元
    成交量: %s万手
    成交额: %s亿
    涨幅: %s
    买一: %s股  %s元
    买二: %s股  %s元
    买三: %s股  %s元
    买四: %s股  %s元
    买五: %s股  %s元
    卖一: %s股  %s元
    卖二: %s股  %s元
    卖三: %s股  %s元
    卖四: %s股  %s元
    卖五: %s股  %s元
    分时图: %s
    日K线: %s
    周K线: %s
    月K线: %s
    
仅供参考，非投资依据。
EOF;
    
    public $_msg_lottery = <<<EOF
彩种：%s
期号：%s
时间：%s
号码：%s
EOF;
    
        public $_msg_joke = <<<EOF
标题：%s
            
%s
EOF;
        
    public $_send_format = array(
            'text' => array('touser'=>'', 'msgtype'=>'text', 'text'=>array('content'=>'')),
            'image' => array('touser'=>'', 'msgtype'=>'image', 'image'=>array('media_id'=>'')),
            'voice' => array('touser'=>'', 'msgtype'=>'voice', 'voice'=>array('media_id'=>'')),
            'video' => array('touser'=>'', 'msgtype'=>'video', 'video'=>array('media_id'=>'', 'thumb_media_id'=>'', 'title'=>'', 'description'=>'')),
            'music' => array('touser'=>'', 'msgtype'=>'music', 'music'=>array('title'=>'', 'description'=>'', 'musicurl'=>'', 'hqmusicurl'=>'', 'thumb_media_id'=>'')),
            'news' => array('touser'=>'', 'msgtype'=>'news', 'articles'=>array(array('title'=>'', 'description'=>'', 'url'=>'', 'picurl'=>''))),
        );
    
    public function getMusic($param, $msgXml=array()){
        $data = array();
        $data['method'] = 'get';
        $data['header'] = array('apikey: '. BAIDU_API_KEY);
        $data['url'] = sprintf(BAIDU_MUSIC_SEARCH_API_URL);
        $data['data'] = $param;
        $rt = $this->http($data);
        
        if(empty($msgXml)){
            return $rt;
        }
        
        return $rt;
    }
    
    public function getMusicPlayInfo($param, $msgXml=array()){
        $data = array();
        $data['method'] = 'get';
        $data['header'] = array('apikey: '. BAIDU_API_KEY);
        $data['url'] = sprintf(BAIDU_MUSIC_PLAYINFO_API_URL);
        $data['data'] = $param;
        $rt = $this->http($data);
        
        if(empty($msgXml)){
            return $rt;
        }
        
        return $rt;
    }
    
    public function getStock($stockid, $msgXml=array()){
        
        $data = array();
        $data['method'] = 'get';
        $data['header'] = array('apikey: '. BAIDU_API_KEY);
        $data['url'] = sprintf(BAIDU_STOCK_API_URL, $stockid);
        $rt = $this->http($data);
        
        if(empty($msgXml)){
            return $rt;
        }
        
        if($rt['errNum'] === 0){
                        
            $data = $this->_send_format['text'];
            $data['touser'] = $msgXml['FromUserName'];
            $data['fromuser'] = $msgXml['ToUserName'];
            
            $stockInfo = $rt['retData']['stockinfo'][0];
            $data['text']['content'] = sprintf($this->_msg_stock, $stockInfo['name'], $stockInfo['code'], $stockInfo['date'], $stockInfo['time'], $stockInfo['OpenningPrice'], $stockInfo['closingPrice'], $stockInfo['currentPrice'], $stockInfo['hPrice'], $stockInfo['lPrice'], $stockInfo['competitivePrice'], $stockInfo['auctionPrice'], number_format($stockInfo['totalNumber']/1000000, 1), number_format($stockInfo['turnover']/100000000, 2), number_format($stockInfo['increase'], 2).'%', $stockInfo['buyOne'], $stockInfo['buyOnePrice'], $stockInfo['buyTwo'], $stockInfo['buyTwoPrice'], $stockInfo['buyThree'], $stockInfo['buyThreePrice'], $stockInfo['buyFour'], $stockInfo['buyFourPrice'], $stockInfo['buyFive'], $stockInfo['buyFivePrice'], $stockInfo['sellOne'], $stockInfo['sellOnePrice'], $stockInfo['sellTwo'], $stockInfo['sellTwoPrice'], $stockInfo['sellThree'], $stockInfo['sellThreePrice'], $stockInfo['sellFour'], $stockInfo['sellFourPrice'], $stockInfo['sellFive'], $stockInfo['sellFivePrice'], $stockInfo['minurl'], $stockInfo['dayurl'], $stockInfo['weekurl'], $stockInfo['monthurl']);
            return $data;
        }
        $data = $this->_send_format['text'];
        $data['touser'] = $msgXml['FromUserName'];
        $data['fromuser'] = $msgXml['ToUserName'];
        $data['text']['content'] = '糟糕，未查到“'. $stockid .'”';
        return $data;
    }
    
    public function getWeather($cityid, $msgXml=array()){
        $data = array();
        $data['method'] = 'get';
        $data['header'] = array('apikey: '. BAIDU_API_KEY);
        $data['url'] = sprintf(BAIDU_WEATHER_API_URL, $cityid);
        $rt = $this->http($data);
        
        if(empty($msgXml)){
            return $rt;
        }
        
        if($rt['errNum'] === 0){

            $data = $this->_send_format['text'];
            $data['touser'] = $msgXml['FromUserName'];
            $data['fromuser'] = $msgXml['ToUserName'];

            $weather = $rt['retData'];

            $data['text']['content'] = sprintf($this->_msg_weather, $weather['city'], $weather['date'], $weather['time'], $weather['weather'], $weather['temp'], $weather['h_tmp'], $weather['l_tmp'], $weather['WD'], $weather['WS'], $weather['sunrise'], $weather['sunset']);
            return $data;
        }
        $data = $this->_send_format['text'];
        $data['touser'] = $msgXml['FromUserName'];
        $data['fromuser'] = $msgXml['ToUserName'];
        $data['text']['content'] = '咦，你很关心“'. $contents[0] .'”地区？';
        return $data;
    }
    
    
    public function getGirls($param, $msgXml=array()){
        $data = array();
        $data['method'] = 'get';
        $data['header'] = array('apikey: '. BAIDU_API_KEY);
        $data['url'] = sprintf(BAIDU_GIRLS_API_URL);
        $data['data'] = $param;
        $rt = $this->http($data);
        
        if(empty($msgXml)){
            return $rt;
        }
        
        if($rt['code'] === 200){

            $data = $this->_send_format['news'];
            $data['touser'] = $msgXml['FromUserName'];
            $data['fromuser'] = $msgXml['ToUserName'];
            
            $girls = array();
            foreach($rt['newslist'] as $_v){
                $tmp = array();
                $tmp['title'] = $_v['title'];
                $tmp['description'] = $_v['description'];
                $tmp['picurl'] = $_v['picUrl'];
                $tmp['url'] = $_v['url'];
                $girls[] = $tmp;
            }
            
            $data['articles'] = $girls;
            return $data;
        }
        
        $data = $this->_send_format['text'];
        $data['touser'] = $msgXml['FromUserName'];
        $data['fromuser'] = $msgXml['ToUserName'];
        $data['text']['content'] = '悲剧，美女都表示不约...';
        return $data;
    }
    
    public function getNews($param, $msgXml=array()){
        $data = array();
        $data['method'] = 'get';
        $data['header'] = array('apikey: '. BAIDU_API_KEY);
        $data['url'] = BAIDU_NEWS_API_URL;
        $data['data'] = $param;
        $rt = $this->http($data);
        
        if(empty($msgXml)){
            return $rt;
        }
        
        if($rt['code'] === 200){

            $data = $this->_send_format['news'];
            $data['touser'] = $msgXml['FromUserName'];
            $data['fromuser'] = $msgXml['ToUserName'];

            $news = array();
            foreach($rt['newslist'] as $_k=>$_v){
                $tmp = array();
                $tmp['title'] = $_v['title'];
                $tmp['description'] = $_v['description'];
                $tmp['picurl'] = $_v['picUrl'];
                $tmp['url'] = $_v['url'];
                $news[] = $tmp;
            }
            $data['articles'] = $news;
            return $data;
        }
        
        return false;
    }
    
    public function getSocials($param, $msgXml=array()){
        $data = array();
        $data['method'] = 'get';
        $data['header'] = array('apikey: '. BAIDU_API_KEY);
        $data['url'] = BAIDU_SOCIALS_API_URL;
        $data['data'] = $param;
        $rt = $this->http($data);
        
        if(empty($msgXml)){
            return $rt;
        }
        
        if($rt['code'] === 200){

            $data = $this->_send_format['news'];
            $data['touser'] = $msgXml['FromUserName'];
            $data['fromuser'] = $msgXml['ToUserName'];

            $news = array();
            foreach($rt['newslist'] as $_k=>$_v){
                $tmp = array();
                $tmp['title'] = $_v['title'];
                $tmp['description'] = $_v['description'];
                $tmp['picurl'] = $_v['picUrl'];
                $tmp['url'] = $_v['url'];
                $news[] = $tmp;
            }
            $data['articles'] = $news;
            return $data;
        }
        
        return false;
    }
    
    /**
     * @todo 查询彩票开奖信息
     * @param array $data
     * @param array $msgXml
     * @return string
     */
    public function getLottery($param, $msgXml=array()){
        $data = array();
        $data['method'] = 'get';
        $data['header'] = array('apikey: '. BAIDU_API_KEY);
        $data['data'] = $param;
        $data['url'] = BAIDU_LOTTERY_API_URL;
        $rt = $this->http($data);
        
        if(empty($msgXml)){
            return $rt;
        }
        
        if($rt['errNum'] === 0){
            $tmp = $rt['retData']['data'][0];
            
            $data = $this->_send_format['text'];
            $data['touser'] = $msgXml['FromUserName'];
            $data['fromuser'] = $msgXml['ToUserName'];
            
            $this->load->helper('include');
            $lottery = array_flip(include_config('lottery'));
            $data['text']['content'] = sprintf($this->_msg_lottery, $lottery[$rt['retData']['lotteryCode']], $tmp['expect'], $tmp['openTime'], $tmp['openCode']);
            return $data;
        }
        
        $data = $this->_send_format['text'];
        $data['touser'] = $msgXml['FromUserName'];
        $data['fromuser'] = $msgXml['ToUserName'];
        $data['text']['content'] = '别着急，还未开奖...';
        return $data;
    }
    
    public function getJoke($param, $msgXml=array()){
        
        $data = array();
        $data['method'] = 'post';
        $data['header'] = array('apikey: '. BAIDU_API_KEY);
        $data['data'] = $param;
        $data['url'] = BAIDU_JOKE_API_URL;
        $rt = $this->http($data);
        
        if(empty($msgXml)){
            return $rt;
        }
        
        if($rt['res_code'] === 0){
            $tmp = $rt['res_body']['JokeList'][rand(0,19)];
            
            $data = $this->_send_format['text'];
            $data['touser'] = $msgXml['FromUserName'];
            $data['fromuser'] = $msgXml['ToUserName'];
            
            $data['text']['content'] = sprintf($this->_msg_joke, $tmp['JokeTitle'], $tmp['JokeContent']);
            return $data;
        }
        
        $data = $this->_send_format['text'];
        $data['touser'] = $msgXml['FromUserName'];
        $data['fromuser'] = $msgXml['ToUserName'];
        $data['text']['content'] = '准备好，段子即将开讲...';
        return $data;
    }
}