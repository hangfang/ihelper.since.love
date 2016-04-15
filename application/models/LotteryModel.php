<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LotteryModel extends MY_Model{
    
    public function genSsq($num, $msgXml){
        $blue = array();
        for($i=1; $i<34; $i++){
            $blue[] = str_pad($i, 2, '0', STR_PAD_LEFT);
        }
        
        $red = array();
        for($i=1; $i<17; $i++){
            $red[] = str_pad($i, 2, '0', STR_PAD_LEFT);
        }
        
        $lottery = array();
        for($i=0; $i<$num; $i++){
            $rand = array_rand($blue, 6);
            $blues = array($blue[$rand[0]], $blue[$rand[1]], $blue[$rand[2]], $blue[$rand[3]], $blue[$rand[4]], $blue[$rand[5]]);
            $rand = array_rand($red, 1);
            $reds = $red[$rand];
            
            $lottery[] = implode(' ', $blues) . '+' . $reds;
        }
        
        if(empty($msgXml)){
            $rt = array();
            $rt['rtn'] = 0;
            $rt['msg'] = $lottery;
            return $rt;
        }
        
        
        $num2ch = array(1=>'一', 2=>'二', 2=>'两', 3=>'三', 4=>'四', 5=>'五');
        
        $data = $this->_send_format['text'];
        $data['touser'] = $msgXml['FromUserName'];
        $data['fromuser'] = $msgXml['ToUserName'];
        $data['text']['content'] = '随机双色球'.$num2ch[$num].'注'."\n".implode("\n", $lottery);
        return $data;
    }
    
    public function checkSsq($data){
        $num2price = array('', 'first', 'second', 'third', 'forth', 'fivth', 'sixth');
        $num2info = array('', '一等奖', '二等奖', '三等奖', '四等奖', '五等奖', '六等奖');
        $query = $this->db->get('app_ssq');
        $result = $query && $query->num_rows()>0 ? $query->result_array() : array();
        
        $rt = array();
        foreach($result as $_v){
            $hitBlue = array($_v['a'],$_v['b'],$_v['c'],$_v['d'],$_v['e'],$_v['f']);
            $hitRed = $_v['g'];
            $price = 1;
            if($hitRed!=$data['g']){
                $price++;
            }
            
            foreach($data as $_index=>$_num){
                if($_index!='g' && !in_array($_num, $hitBlue)){
                    $price++;
                }
            }
            
            if($price<7){
                $tmp = $_v;
                $tmp['price_info'] = $num2info[$price];
                $tmp['price_value'] = $_v[$num2price[$price]];
                $rt[] = $tmp;
            }
        }

        return $rt;
    }
    
    public function check3D($data){
        return array();
    }
    
    public function checkDlt($data){
        return array();
    }
    
    public function checkPlw($data){
        return array();
    }
    
    public function checkPls($data){
        return array();
    }
    
    public function checkQxc($data){
        return array();
    }
}