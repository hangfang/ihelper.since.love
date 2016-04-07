<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PositionModel extends MY_Model{
    
    
    public function getPosition(){
        $data = array();
        $data['method'] = 'get';
        $data['url'] = sprintf(SINA_IP_LOOKUP_API_URL, $this->input->ip_address());
        return $this->http($data);
    }
}