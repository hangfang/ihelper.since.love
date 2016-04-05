<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require 'Base.php';
class WeChat extends BaseModel{
    public function getAccessToken(){
        $this->db->select('token');
        $this->db->order_by('insert_time', 'desc');
        $this->db->limit(1, 0);
        $query = $this->db->get('wechat_token');
        
        return $query && $query->num_rows()>0 ? $query->row()->token : '';
    }
    
    public function saveAccessToken($token){
        if(!$this->db->insert('wechat_token', array('token'=>$token))){
            error_log('insert into access_token error');
            return false;
        }
        
        return true;
    }
}