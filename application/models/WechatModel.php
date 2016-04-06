<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WechatModel extends MY_Model{
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
            $data = array();
            $data['method'] = 'get';
            $data['url'] = sprintf('%s/token?grant_type=client_credential&appid=%s&secret=%s', WX_CGI_ADDR, WX_APP_ID, WX_APP_SECRET);
            $rt = $this->http($data);
            
            if(!$rt || isset($rt['errcode'])){
                error_log('get access_token from wechat error, msg: '. json_encode($rt));
                return '';
            }
            
            $token = $rt['access_token'];
            if(strlen($token) > 100){
                if(!$this->db->insert('wechat_token', array('token'=>$token))){
                    error_log('insert into access_token error, sql: '. $this->db->last_query());
                }
            }
        }
        
        return $token;
    }
    
    /**
     * @todo 存储用户发过来的微信消息
     * @param array $msg
     * @return boolean
     */
    public function saveMessage($msg){
        
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
        $data['data'] = $msg;
        $data['url'] = sprintf('%s/message/custom/send?access_token=%s', WX_CGI_ADDR, $this->getAccessToken());
        $data['method'] = 'post';
        $rt = $this->http($data);

        if(!$rt || isset($rt['errcode'])){
            if($rt['errcode'] == 42001){
                $this->accessTokenExpired();
                return call_user_func_array(array($this, 'sendMessage'), $msg);
            }
            error_log('send wechat message, msg: '. json_encode($rt));
            return false;
        }
        
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
        
        return true;
    }
    
    private function http($args = array()){
       $ch = curl_init();

       $args = array_merge(array(
           'data' => array(),
           'method' => 'get',
       ) ,$args);
       if(strtolower($args['method']) === 'post'){
           curl_setopt($ch, CURLOPT_POST, true);
           curl_setopt($ch ,CURLOPT_POSTFIELDS, http_build_query($args['data']));
       }else{
           $data = array();
           foreach ($args['data'] as $key => $value) {
               $data[] = urlencode($key).'='.urlencode($value);
           }
           $data = implode('&', $data);
           $args['url'] .=(strpos($args['url'] ,'?')==false?'?':'&').$data;
           $args['url'] = trim($args['url'], '&');
       }
       
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查 
       curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); // 从证书中检查SSL加密算法是否存在 
       curl_setopt($ch, CURLOPT_URL, $args['url']);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
       curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
       $result = curl_exec($ch);

       if($result === false){
           return array(
               'errcode' => 1,
               'errmsg' => 'request interface fatal'
           );
       }

       curl_close($ch);

       $return = json_decode($result ,true);

       if(!$return){
           $return = array();
           $return['errcode'] = 2;
           $return['errmsg'] = '微信返回数据非json格式';
           return $return;
       }
       
       return $return;
   }
}