<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WeatherModel extends MY_Model{
    
    
    public function getWeather($cityid){
        $data = array();
        $data['method'] = 'get';
        $data['header'] = 'apikey: '. BAIDU_WEATHER_API_KEY;
        $data['url'] = sprintf(BAIDU_WEATHER_API_URL, $cityid);
        return $this->http($data);
    }
}