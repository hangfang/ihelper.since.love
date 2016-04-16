<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class JobController extends MY_Controller {
    
    public function get3D($expect=''){
        if($expect){
            $this->keep3D($expect);
        }else{
            $this->load->database();
            
            $query = $this->db->order_by('id', 'desc')->get('app_3d');
            $row = $query->num_rows()>0 ? $query->row_array() : array();
            if(!$row){
                for($i=2004; $i<=ltrim(date('Y')); $i++){
                    for($j=1; $j<=360; $j++){
                        $expect = str_pad($i, 4, 0, STR_PAD_LEFT).str_pad($j, 3, 0, STR_PAD_LEFT);
                        $this->keep3D($expect);
                    }
                }
            }else{
                $this->keep3D($row['expect']+1);
            }
        }
    }
    
    public function keep3D($expect){
        $url = sprintf('http://kaijiang.500.com/shtml/sd/%s.shtml', $expect);
        $content = @file_get_contents($url);
        if(!$content){
            echo $url .' error'."\n";
            return false;
        }
        $content = mb_convert_encoding($content, 'UTF-8', 'GBK');
            
        
        $lottery = array();
        $content = explode('开奖日期', $content);

        $content = explode('开奖号码', $content[1]);
        list($lottery['insert_time'], $_) = explode('--', preg_replace(array('/年|月|日/', '/[^\d-]/'), array('-', ''), $content[0]));
        $lottery['insert_time'] = date('Y-m-d H:i:s', strtotime($lottery['insert_time']));
            
        $content = explode('本期销量', $content[1]);
        preg_match_all('/>(\d+)</', $content[0], $haoma);
        
        if(!isset($haoma[1][0])){
            echo $url .' not selled'."\n";
            return false;
        }
        $lottery['expect'] = $expect;
        $lottery['a'] = $haoma[1][0];
        $lottery['b'] = $haoma[1][1];
        $lottery['c'] = $haoma[1][2];


        $content = explode('开奖详情', $content[1]);
        preg_match_all('/>([\d,]+)元/', $content[0], $lottery['sell']);
        $lottery['sell'] = str_replace(',', '', $lottery['sell'][1][0]);
        $lottery['remain'] = 0;

        $content = explode('上一期', $content[1]);
        $content = explode('单选', $content[0]);
        $keyword = strpos($content[1], '组三')!==false ? '组三' : '组六';
        $content = explode($keyword, $content[1]);

        list($_, $_, $lottery['first_num'], $_, $lottery['first']) = explode('<td>', preg_replace('/\/|\s+/', '', $content[0]));
        $lottery['first'] = str_replace(',', '', $lottery['first']);

        list($_, $_, $lottery['second_num'], $_, $lottery['second']) = explode('<td>', preg_replace('/\/|\s+/', '', $content[1]));
        $lottery['second'] = str_replace(',', '', $lottery['second']);

        $this->load->database();
        
        if($this->db->where('expect', $lottery['expect'])->get('app_3d')->num_rows()>0){
            echo $expect . ' exists' . "\n";
            return false;
        }
        
        if($this->db->insert('app_3d', $lottery)){
            echo $expect . ' keep ok'. "\n";
        }
    }
    
    public function getSsq($expect=''){
        if($expect){
            $this->keepSsq($expect);
        }else{
            $this->load->database();
            
            $query = $this->db->order_by('id', 'desc')->get('app_ssq');
            $row = $query->num_rows()>0 ? $query->row_array() : array();
            if(!$row){
                for($i=3; $i<=ltrim(date('Y'), '20'); $i++){
                    for($j=1; $j<=154; $j++){
                        $expect = str_pad($i, 2, 0, STR_PAD_LEFT).str_pad($j, 3, 0, STR_PAD_LEFT);
                        $this->keepSsq($expect);
                    }
                }
            }else{
                $this->keepSsq($row['expect']+1);
            }
        }
    }
    
    public function keepSsq($expect){
        $url = sprintf('http://kaijiang.500.com/shtml/ssq/%s.shtml', $expect);
        $content = @file_get_contents($url);
        if(!$content){
            echo $url .' error'."\n";
            return false;
        }
        $content = mb_convert_encoding($content, 'UTF-8', 'GBK');
            
        
        $lottery = array();
        $content = explode('开奖日期', $content);

        $content = explode('开奖号码', $content[1]);
        list($lottery['insert_time'], $_) = explode('--', preg_replace(array('/年|月|日/', '/[^\d-]/'), array('-', ''), $content[0]));
        $lottery['insert_time'] = date('Y-m-d H:i:s', strtotime($lottery['insert_time']));
            
        $content = explode('本期销量', $content[1]);
        preg_match_all('/>(\d+)</', $content[0], $haoma);
        
        if(!isset($haoma[1][0])){
            echo $url .' not selled'."\n";
            return false;
        }
        $lottery['expect'] = $expect;
        
        $lottery['a'] = $haoma[1][0];
        $lottery['b'] = $haoma[1][1];
        $lottery['c'] = $haoma[1][2];
        $lottery['d'] = $haoma[1][3];
        $lottery['e'] = $haoma[1][4];
        $lottery['f'] = $haoma[1][5];
        $lottery['g'] = $haoma[1][6];

        $content = explode('奖池滚存', $content[1]);
        preg_match_all('/>([\d,]+)元/', $content[0], $lottery['sell']);
        $lottery['sell'] = str_replace(',', '', $lottery['sell'][1][0]);

        $content = explode('开奖详情', $content[1]);
        preg_match_all('/>([\d,]+)元/', $content[0], $lottery['remain']);
        $lottery['remain'] = str_replace(',', '', $lottery['remain'][1][0]);

        $content = explode('上一期', $content[1]);
        $content = explode('一等奖', $content[0]);
        $content = explode('二等奖', $content[1]);

        list($_, $_, $lottery['first_num'], $_, $lottery['first']) = explode('<td>', preg_replace('/\/|\s+/', '', $content[0]));
        $lottery['first'] = str_replace(',', '', $lottery['first']);

        $content = explode('三等奖', $content[1]);
        list($_, $_, $lottery['second_num'], $_, $lottery['second']) = explode('<td>', preg_replace('/\/|\s+/', '', $content[0]));
        $lottery['second'] = str_replace(',', '', $lottery['second']);

        $content = explode('四等奖', $content[1]);
        list($_, $_, $lottery['third_num'], $_, $lottery['third']) = explode('<td>', preg_replace('/\/|\s+/', '', $content[0]));
        $lottery['third'] = str_replace(',', '', $lottery['third']);

        $content = explode('五等奖', $content[1]);
        list($_, $_, $lottery['forth_num'], $_, $lottery['forth']) = explode('<td>', preg_replace('/\/|\s+/', '', $content[0]));
        $lottery['forth'] = str_replace(',', '', $lottery['forth']);

        $content = explode('六等奖', $content[1]);
        list($_, $_, $lottery['fivth_num'], $_, $lottery['fivth']) = explode('<td>', preg_replace('/\/|\s+/', '', $content[0]));
        $lottery['fivth'] = str_replace(',', '', $lottery['fivth']);
        
        list($_, $_, $lottery['sixth_num'], $_, $lottery['sixth']) = explode('<td>', preg_replace('/\/|\s+/', '', $content[1]));
        $lottery['sixth'] = str_replace(',', '', $lottery['sixth']);
        
        $this->load->database();
        
        if($this->db->where('expect', $lottery['expect'])->get('app_ssq')->num_rows()>0){
            echo $expect . ' exists' . "\n";
            return false;
        }
        
        if($this->db->insert('app_ssq', $lottery)){
            echo $expect . ' keep ok'. "\n";
        }
    }
}