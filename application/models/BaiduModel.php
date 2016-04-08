<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BaiduModel extends MY_Model{
    
    public $_msg_weather = <<<EOF
%s天气：
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
    
    public $_send_format = array(
            'text' => array('touser'=>'', 'msgtype'=>'text', 'text'=>array('content'=>'')),
            'image' => array('touser'=>'', 'msgtype'=>'image', 'image'=>array('media_id'=>'')),
            'voice' => array('touser'=>'', 'msgtype'=>'voice', 'voice'=>array('media_id'=>'')),
            'video' => array('touser'=>'', 'msgtype'=>'video', 'video'=>array('media_id'=>'', 'thumb_media_id'=>'', 'title'=>'', 'description'=>'')),
            'music' => array('touser'=>'', 'msgtype'=>'music', 'music'=>array('title'=>'', 'description'=>'', 'musicurl'=>'', 'hqmusicurl'=>'', 'thumb_media_id'=>'')),
            'news' => array('touser'=>'', 'msgtype'=>'news', 'news'=>array('articles'=>array('title'=>'', 'description'=>'', 'url'=>'', 'picurl'=>''))),
        );
    
    public function getWeather($cityid, $msgXml){
        $data = array();
        $data['method'] = 'get';
        $data['header'] = array('apikey: '. BAIDU_WEATHER_API_KEY);
        $data['url'] = sprintf(BAIDU_API_URL, $cityid);
        $rt = $this->http($data);
        
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
}