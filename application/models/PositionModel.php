<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PositionModel extends MY_Model{
    
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
        $data['url'] = sprinf(TENCENT_MAP_APP_URL.'/geocoder/v1/?location=%s,%s&key=%s&get_poi=1', $lat, $lng, TENCENT_MAP_APP_KEY);
        
        return $this->http($data);
    }
}