<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PositionModel extends MY_Model{
    public $_msg_around = <<<EOF
搜索周边：%s
%s

注：以%s的位置计算
EOF;
    
    public $_send_format = array(
            'text' => array('touser'=>'', 'msgtype'=>'text', 'text'=>array('content'=>'')),
            'image' => array('touser'=>'', 'msgtype'=>'image', 'image'=>array('media_id'=>'')),
            'voice' => array('touser'=>'', 'msgtype'=>'voice', 'voice'=>array('media_id'=>'')),
            'video' => array('touser'=>'', 'msgtype'=>'video', 'video'=>array('media_id'=>'', 'thumb_media_id'=>'', 'title'=>'', 'description'=>'')),
            'music' => array('touser'=>'', 'msgtype'=>'music', 'music'=>array('title'=>'', 'description'=>'', 'musicurl'=>'', 'hqmusicurl'=>'', 'thumb_media_id'=>'')),
            'news' => array('touser'=>'', 'msgtype'=>'news', 'news'=>array('articles'=>array('title'=>'', 'description'=>'', 'url'=>'', 'picurl'=>''))),
        );
    /**
     * @todo ip查询城市
     */
    public function getPosition(){
        $data = array();
        $data['method'] = 'get';
        $data['url'] = sprintf(SINA_IP_LOOKUP_API_URL, $this->input->ip_address());
        return $this->http($data);
    }
    
    /**
     * @todo 经纬度查询位置
     * @param float $lat 纬度
     * @param float $lng 经度
     */
    public function getLocation($lat, $lng){
        $data = array();
        $data['method'] = 'get';
        $data['url'] = sprintf(TENCENT_MAP_APP_URL.'/geocoder/v1/?location=%s,%s&key=%s&get_poi=1', $lat, $lng, TENCENT_MAP_APP_KEY);
        
        return $this->http($data);
    }

    public function searchAround($lastMsg, $msgXml){
        
        $data = array();
        $data['method'] = 'get';
        $data['url'] = sprintf(TENCENT_MAP_APP_URL.'/place/v1/search?boundary=nearby(%s,%s,1000)&keyword=%s&page_size=5&page_index=1&orderby=_distance&key=%s', $lastMsg['Location_X'], $lastMsg['Location_Y'], $msgXml['Content'], TENCENT_MAP_APP_KEY);
        
        $rt = $this->http($data);
        
        if($rt['status'] === 0){
            $around_text = '';
            
            foreach($rt['data'] as $v){
                $tmp = <<<EOF
                    
    名称：{$v['title']}
    地址：{$v['address']}
    电话：{$v['tel']}
    距离：{$v['_distance']}米

EOF;
                $around_text .= $tmp;
            }
            $data = $this->_send_format['text'];
            $data['touser'] = $msgXml['FromUserName'];
            $data['fromuser'] = $msgXml['ToUserName'];
            
            $this->load->library('friendlydate');
            $data['text']['content'] = sprintf($this->_msg_around, $msgXml['Content'], $around_text, $this->friendlydate->timeDiff($lastMsg['CreateTime']));
            return $data;
        }
        
        $data = $this->_send_format['text'];
        $data['touser'] = $msgXml['FromUserName'];
        $data['fromuser'] = $msgXml['ToUserName'];
        $data['text']['content'] = $rt['message'];
        return $data;
    }
}