<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WX{
    private $db = null;
    public function __construct($params){
        $this->db = $params['db'];
    }
    
    public function getAccessToken(){
        $data = array();
        $data['method'] = 'get';
        $data['url'] = sprintf('%s/token?grant_type=client_credential&appid=%s&secret=%s', WX_CGI_ADDR, WX_APP_ID, WX_APP_SECRET);
        $rt = $this->http($data);

        if(!$rt || isset($rt['errorcode'])){
            return '';
        }
        
        if(strlen($rt['access_token']) > 100){
            if(!$this->db->insert('wechat_token', array('token'=>$rt['access_token']))){
                error_log('insert into access_token error');
            }
        }
        
        return $rt['access_token'];
    }
    

    /**
    * 内部请求
    * @author hangfang
    * @param  array  $args [description]
    * @param url => {String} ,{required}
    * @param data => {array} ,{default} array(),
    * @param header => {array} ,{default} array()
    * @param method => {String} ,{default} 'post'
    * @param cookie => {Boolean} ,{default} true
    * @return [type]       [description]
    */
   public function http($args = array()){
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
