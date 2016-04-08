<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WechatModel extends MY_Model{
    
    public $access_token = '';
    public $jsapi_ticket = '';
    
    public $text = <<<EOF
<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[%s]]></Content>
</xml>
EOF;
    
    public $image = <<<EOF
<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[image]]></MsgType>
<Image>
<MediaId><![CDATA[%s]]></MediaId>
</Image>
</xml>
EOF;
    
    public $voice = <<<EOF
<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[voice]]></MsgType>
<Voice>
<MediaId><![CDATA[%s]]></MediaId>
</Voice>
</xml>
EOF;
    public $video = <<<EOF
<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[video]]></MsgType>
<Video>
<MediaId><![CDATA[%s]]></MediaId>
<Title><![CDATA[%s]]></Title>
<Description><![CDATA[%s]]></Description>
</Video> 
</xml>
EOF;

    public $music = <<<EOF
<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[music]]></MsgType>
<Music>
<Title><![CDATA[%s]]></Title>
<Description><![CDATA[%s]]></Description>
<MusicUrl><![CDATA[%s]]></MusicUrl>
<HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
<ThumbMediaId><![CDATA[%s]]></ThumbMediaId>
</Music>
</xml>
EOF;
    
    public $news = <<<EOF
<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[news]]></MsgType>
<ArticleCount>%s</ArticleCount>
<Articles>%s</Articles>
</xml> 
EOF;
    
    public function __construct(){
        $this->access_token = $this->getAccessToken();
        $this->jsapi_ticket = $this->getJsApiTicket();
    }
    
    public function accessTokenExpired(){
        return $this->db->truncate('wechat_token');
    }
    
    /**
     * @todo 从微信获取access_token，并存储于数据库
     * @return string
     */
    public function getAccessToken(){
        $this->db->select('token');
        $this->db->where('insert_time > ', time()-2*3600);
        $this->db->order_by('insert_time', 'desc');
        $this->db->limit(1, 0);
        $query = $this->db->get('wechat_token');
        
        $token = $query && $query->num_rows()>0 ? $query->row()->token : '';
        
        if($token === ''){
            $this->accessTokenExpired();//清除token记录表
            
            $data = array();
            $data['method'] = 'get';
            $data['url'] = sprintf('%s/token?grant_type=client_credential&appid=%s&secret=%s', WX_CGI_ADDR, WX_APP_ID, WX_APP_SECRET);
            $rt = $this->http($data);
            
            if(isset($rt['errcode'])){
                error_log('get access_token from wechat error, msg: '. json_encode($rt));
                return '';
            }
            
            $token = $rt['access_token'];
            if(strlen($token)){
                if(!$this->db->insert('wechat_token', array('token'=>$token))){
                    error_log('insert into access_token error, sql: '. $this->db->last_query());
                }
            }
        }
        
        return $this->access_token = $token;
    }
    
    public function getJsApiSigObj(){
        
        $data = array();
        $data['debug'] = WX_JSAPI_DEBUG;
        $data['appid'] = WX_APP_ID;
        $data['timestamp'] = time();
        $data['nonceStr'] = md5($data['timestamp']);
        
        
        $data2gen = array();
        $data2gen['jsapi_ticket'] = $this->jsapi_ticket;
        $data2gen['noncestr'] = $data['nonceStr'];
        $data2gen['timestamp'] = $data['timestamp'];
        $data2gen['url'] = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].$_SERVER['QUERY_STRING'];
        
        $string1 = '';
        foreach($data2gen as $_k=>$_v){
            $string1 .= $_k.'='.$_v.'&';
        }
        unset($data2gen, $_k, $_v);
        
        $string1 = trim($string1, '&');
        
        $data['signature'] = sha1($string1);
        
        return $data;
    }
    
    
    public function getJsApiTicket(){
        $this->db->select('jsapi_ticket');
        $this->db->where('insert_time > ', time()-2*3600);
        $this->db->order_by('insert_time', 'desc');
        $this->db->limit(1, 0);
        $query = $this->db->get('wechat_token');
        
        $jsapi_ticket = $query && $query->num_rows()>0 ? $query->row()->jsapi_ticket : '';
        
        if($jsapi_ticket === ''){
            $data = array();
            $data['method'] = 'get';
            $data['url'] = sprintf('%s/ticket/getticket?access_token=%s&type=jsapi', WX_CGI_ADDR, $this->access_token);
            $rt = $this->http($data);
            
            if(isset($rt['errcode'])){
                error_log('get jsapi_ticket from wechat error, msg: '. json_encode($rt));
                if($rt['errcode'] === 42001){//access_token过期
                    $this->accessTokenExpired();
                    return call_user_func_array(array($this, 'getJsApiTicket'), array());
                }
            }
            
            $jsapi_ticket = $rt['ticket'];
            if(strlen($jsapi_ticket)){
                if(!$this->db->update('wechat_token', array('jsapi_ticket'=>$jsapi_ticket))){
                    error_log('update jsapi_ticket error, sql: '. $this->db->last_query());
                }
            }
        }
        
        return $this->jsapi_ticket = $jsapi_ticket;
    }
    
    /**
     * @todo 查询上一条记录(5分钟之内)
     * @param array $msgXml
     * @return array
     */
    public function getLastMsg($msgXml, $MsgType=''){
        $this->db->where('FromUserName', $msgXml['FromUserName']);
        $this->db->where('CreateTime > ', time()-300);//
        $MsgType && $this->db->where('MsgType', $MsgType);
        $this->db->order_by('CreateTime', 'desc');
        $this->db->limit(1, 0);
        $query = $this->db->get('wechat_receive_message');
        log_message('error', $this->db->last_query());
        return $query && $query->num_rows()===1 ? $query->row_array() : array();
    }
    
    /**
     * @todo 存储用户发过来的微信消息
     * @param array $msg
     * @return boolean
     */
    public function saveMessage($msg){
        
        unset($msg['CreateTime']);
        if(!$this->db->insert('wechat_receive_message', $msg)){
            error_log('save wechat message error, sql:'. $this->db->last_query());
            return false;
        }
        
        return true;
    }
    
    /**
     * @todo 回复用户信息
     * @param array $msg
     * @return boolean
     */
    public function sendMessage($msg){
//        没权限发消息/(ㄒoㄒ)/~~
//        $data['data'] = $msg;
//        $data['url'] = sprintf('%s/message/custom/send?access_token=%s', WX_CGI_ADDR, $this->access_token);
//        $data['method'] = 'post';
//        $rt = $this->http($data);
//
//        if(!$rt || isset($rt['errcode'])){
//            if($rt['errcode'] == 42001){//access_token过期
//                $this->accessTokenExpired();
//                return call_user_func_array(array($this, 'sendMessage'), array($msg));
//            }
//            error_log('send wechat message, msg: '. json_encode($rt));
//            return false;
//        }
        
        $data = array();
        foreach($msg as $_msg_name=>$_msg_value){
            if(is_array($_msg_value)){
                foreach($_msg_value as $_k=>$_v){
                    if($_k === 'articles'){
                        $data['articles'] = json_encode($_msg_value);
                        break;
                    }
                    
                    $data[$_k] = $_v;
                }
                
                continue;
            }
            
            $data[$_msg_name] = $_msg_value;
        }
        

        if(!$this->db->insert('wechat_send_message', $data)){
            error_log('save wechat_send_message error, sql:'. $this->db->last_query());
        }
        
        $this->autoAnwserWxMessage($msg);
        return true;
    }
    
    public function autoAnwserWxMessage($msg){
        switch($msg['msgtype']){
            case 'image':
                $msg = sprintf($this->image, $msg['touser'], $msg['fromuser'], time(), $msg['image']['media_id']);
                break;
            case 'video':
                $msg = sprintf($this->video, $msg['touser'], $msg['fromuser'], time(), $msg['video']['media_id']);
                break;
            case 'music':
                $msg = sprintf($this->music, $msg['touser'], $msg['fromuser'], time(), $msg['music']['title'], $msg['music']['description'], $msg['music']['musicurl'], $msg['music']['hqmusicurl'], $msg['music']['hqmusicurl'], $msg['music']['thumbmediaid']);
                break;
            case 'news':
                $article_template = <<<EOF
<item>
<Title><![CDATA[%s]]></Title> 
<Description><![CDATA[%s]]></Description>
<PicUrl><![CDATA[%s]]></PicUrl>
<Url><![CDATA[%s]]></Url>
</item>
EOF;
                $articles = '';
                foreach($msg['news'] as $news){
                    $articles .= sprintf($article_template, $news['title'], $news['description'], $news['picurl'], $news['url']);
                }
                $msg = sprintf($this->news, $msg['touser'], $msg['fromuser'], time(), $msg['article_count'], $articles);
                break;
            default:
                $msg = sprintf($this->text, $msg['touser'], $msg['fromuser'], time(), $msg['text']['content']);
                break;
            
        }
        
        
        header('Content-Type: text/xml');
        echo $msg;
        exit;
    }
}