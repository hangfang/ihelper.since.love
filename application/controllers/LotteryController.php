<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LotteryController extends MY_Controller {
    
    public $_msg_lottery = <<<EOF
<p class="weui_media_desc">彩种：%s</p>
<p class="weui_media_desc">期号：%s</p>
<p class="weui_media_desc">时间：%s</p>
<p class="weui_media_desc">号码：%s</p>
%s
EOF;
    
    public $_msg_lottery_extra = <<<EOF
<p class="weui_media_desc">销量：%s</p>
<p class="weui_media_desc">奖池：%s</p>
%s
EOF;
    
    public $_ssq_pride = <<<EOF
<p class="weui_media_desc">一等奖：奖金%s&nbsp;&nbsp;共%s注</p>
<p class="weui_media_desc">二等奖：奖金%s&nbsp;&nbsp;共%s注</p>
<p class="weui_media_desc">三等奖：奖金%s&nbsp;&nbsp;共%s注</p>
<p class="weui_media_desc">四等奖：奖金%s&nbsp;&nbsp;共%s注</p>
<p class="weui_media_desc">五等奖：奖金%s&nbsp;&nbsp;共%s注</p>
<p class="weui_media_desc">六等奖：奖金%s&nbsp;&nbsp;共%s注</p>
EOF;
    
    public $_dlt_pride = <<<EOF
<p class="weui_media_desc">一等奖追加：奖金%s&nbsp;&nbsp;共%s注</p>
<p class="weui_media_desc">一&nbsp;&nbsp;&nbsp;等&nbsp;&nbsp;&nbsp;奖：奖金%s&nbsp;&nbsp;共%s注</p>
<p class="weui_media_desc">二等奖追加：奖金%s&nbsp;&nbsp;共%s注</p>
<p class="weui_media_desc">二&nbsp;&nbsp;&nbsp;等&nbsp;&nbsp;&nbsp;奖：奖金%s&nbsp;&nbsp;共%s注</p>
<p class="weui_media_desc">三等奖追加：奖金%s&nbsp;&nbsp;共%s注</p>
<p class="weui_media_desc">三&nbsp;&nbsp;&nbsp;等&nbsp;&nbsp;&nbsp;奖：奖金%s&nbsp;&nbsp;共%s注</p>
<p class="weui_media_desc">四等奖追加：奖金%s&nbsp;&nbsp;共%s注</p>
<p class="weui_media_desc">四&nbsp;&nbsp;&nbsp;等&nbsp;&nbsp;&nbsp;奖：奖金%s&nbsp;&nbsp;共%s注</p>
<p class="weui_media_desc">五等奖追加：奖金%s&nbsp;&nbsp;共%s注</p>
<p class="weui_media_desc">五&nbsp;&nbsp;&nbsp;等&nbsp;&nbsp;&nbsp;奖：奖金%s&nbsp;&nbsp;共%s注</p>
<p class="weui_media_desc">六&nbsp;&nbsp;&nbsp;等&nbsp;&nbsp;&nbsp;奖：奖金%s&nbsp;&nbsp;共%s注</p>
EOF;
    
    public $_fc3d_pride = <<<EOF
<p class="weui_media_desc">直选：奖金%s&nbsp;&nbsp;共%s注</p>
<p class="weui_media_desc">%s：奖金%s&nbsp;&nbsp;共%s注</p>
EOF;
        
    public $_pl3_pride = <<<EOF
<p class="weui_media_desc">直选：奖金%s&nbsp;&nbsp;共%s注</p>
<p class="weui_media_desc">%s：奖金%s&nbsp;&nbsp;共%s注</p>
EOF;
    
    public $_pl5_pride = <<<EOF
<p class="weui_media_desc">直选：奖金%s&nbsp;&nbsp;共%s注</p>
EOF;
    
    public $_qxc_pride = <<<EOF
<p class="weui_media_desc">一等奖：奖金%s&nbsp;&nbsp;共%s注</p>  
<p class="weui_media_desc">二等奖：奖金%s&nbsp;&nbsp;共%s注</p>
<p class="weui_media_desc">三等奖：奖金%s&nbsp;&nbsp;共%s注</p>
<p class="weui_media_desc">四等奖：奖金%s&nbsp;&nbsp;共%s注</p>
<p class="weui_media_desc">五等奖：奖金%s&nbsp;&nbsp;共%s注</p>
<p class="weui_media_desc">六等奖：奖金%s&nbsp;&nbsp;共%s注</p>
EOF;
   
    public function __construct() {
        parent::__construct();
        $this->load->model('WechatModel');
    }
    
    
    public function index(){
        $data = array();
        $data['title'] = '彩票查询';
        
        
        $this->load->helper('include');
        $lottery = include_config('lottery');
        
        if($this->input->is_ajax_request()){
            $data = array();
            $data['lotterycode'] = $this->input->get('lottery_code');
            $data['lotterycode'] = $data['lotterycode'] ? $data['lotterycode'] : '';

            $data['recordcnt'] = $this->input->get('record_cnt');
            $data['recordcnt'] = $data['recordcnt'] ? $data['recordcnt'] : 1;
            
            if(!$data['lotterycode']){
                $this->json($this->error['lottery_lack_of_lotterycode_error']);
            }
            
            $this->load->model('LotteryModel');
            $rt = $this->LotteryModel->getLottery($data);

            if(empty($rt)){
                $data = array();
                $data['rtn'] = $this->error['get_lottery_no_result_found']['errcode'];
                $data['errmsg'] = $this->error['get_lottery_no_result_found']['errmsg'];
                
                $this->json($data);
                return false;
            }
            
            $lottery = array_flip($lottery);
            foreach($rt as $_v){
                $code = array();
                isset($_v['a']) && $code[] = in_array($data['lotterycode'], array('ssq', 'dlt', 'qlc')) ? str_pad($_v['a'], 2, 0, STR_PAD_LEFT) : $_v['a'];
                isset($_v['b']) && $code[] = in_array($data['lotterycode'], array('ssq', 'dlt', 'qlc')) ? str_pad($_v['b'], 2, 0, STR_PAD_LEFT) : $_v['b'];
                isset($_v['c']) && $code[] = in_array($data['lotterycode'], array('ssq', 'dlt', 'qlc')) ? str_pad($_v['c'], 2, 0, STR_PAD_LEFT) : $_v['c'];
                isset($_v['d']) && $code[] = in_array($data['lotterycode'], array('ssq', 'dlt', 'qlc')) ? str_pad($_v['d'], 2, 0, STR_PAD_LEFT) : $_v['d'];
                isset($_v['e']) && $code[] = in_array($data['lotterycode'], array('ssq', 'dlt', 'qlc')) ? str_pad($_v['e'], 2, 0, STR_PAD_LEFT) : $_v['e'];
                isset($_v['f']) && $code[] = in_array($data['lotterycode'], array('ssq', 'dlt', 'qlc')) ? str_pad($_v['f'], 2, 0, STR_PAD_LEFT) : $_v['f'];
                isset($_v['g']) && $code[] = in_array($data['lotterycode'], array('ssq', 'dlt', 'qlc')) ? str_pad($_v['g'], 2, 0, STR_PAD_LEFT) : $_v['g'];
                
                $prideInfo = '';
                switch($data['lotterycode']){
                    case 'ssq':
                        $prideInfo = sprintf($this->_ssq_pride, $_v['first'], $_v['first_num'], $_v['second'], $_v['second_num'], $_v['third'], $_v['third_num'], $_v['forth'], $_v['forth_num'], $_v['fivth'], $_v['fivth_num'], $_v['sixth'], $_v['sixth_num']);
                        $openCode = '<span class="ballbg_red">'.implode('</span><span class="ballbg_red">', array_slice($code, 0, 6)).'</span><span class="ballbg_blue">'.$code[6].'</span>';
                        break;
                    case 'dlt':
                        $prideInfo = sprintf($this->_dlt_pride, $_v['first_add'], $_v['first_add_num'], $_v['first'], $_v['first_num'], $_v['second_add'], $_v['second_add_num'], $_v['second'], $_v['second_num'], $_v['third_add'], $_v['third_add_num'], $_v['third'], $_v['third_num'], $_v['forth_add'], $_v['forth_add_num'], $_v['forth'], $_v['forth_num'], $_v['fivth_add'], $_v['fivth_add_num'], $_v['fivth'], $_v['fivth_num'], $_v['sixth'], $_v['sixth_num']);
                        $openCode = '<span class="ballbg_red">'.implode('</span><span class="ballbg_red">', array_slice($code, 0, 5)).'</span><span class="ballbg_blue">'.implode('</span><span class="ballbg_blue">', array_slice($code, 5, 2)).'</span>';
                        break;
                    case 'fc3d':
                        $prideInfo = sprintf($this->_fc3d_pride, $_v['first'], $_v['first_num'], $_v['second']>200?'组三':'组六', $_v['second'], $_v['second_num']);
                        $openCode = '<span class="ballbg_red">'.implode('</span><span class="ballbg_red">', $code).'</span>';
                        break;
                    case 'pl3':
                        $prideInfo = sprintf($this->_pl3_pride, $_v['first'], $_v['first_num'], $_v['second']>200?'组三':'组六', $_v['second'], $_v['second_num']);
                        $openCode = '<span class="ballbg_red">'.implode('</span><span class="ballbg_red">', $code).'</span>';
                        break;
                    case 'pl5':
                        $prideInfo = sprintf($this->_pl5_pride, $_v['first'], $_v['first_num']);
                        $openCode = '<span class="ballbg_red">'.implode('</span><span class="ballbg_red">', $code).'</span>';
                        break;
                    case 'qxc':
                        $prideInfo = sprintf($this->_qxc_pride, $_v['first'], $_v['first_num'], $_v['second'], $_v['second_num'], $_v['third'], $_v['third_num'], $_v['forth'], $_v['forth_num'], $_v['fivth'], $_v['fivth_num'], $_v['sixth'], $_v['sixth_num']);
                        $openCode = '<span class="ballbg_red">'.implode('</span><span class="ballbg_red">', $code).'</span>';
                        break;
                }
                
                $extra = sprintf($this->_msg_lottery_extra, number_format($_v['remain'], 0, '', ','), number_format($_v['sell'], 0, '', ','), $prideInfo);
                $msg = sprintf($this->_msg_lottery, $lottery[$data['lotterycode']], $_v['expect'], substr($_v['insert_time'], 0, 10), $openCode, $extra);
            }
                        
            $data = array();
            $data['rtn'] = 0;
            $data['msg'] = $msg;
            
            $this->json($data);
            return true;
        }
        
        $lottery = array_flip(array_unique(array_flip($lottery)));
        
        $data['lotteryList'] = $lottery;
        
        $this->layout->setLayout('weui');
        $this->layout->view('Lottery/index', $data);
    }
    
    public function checkLottery(){
        
        $lottery_type = ucfirst($this->input->get('lottery_type'));
        $funcName = 'check'.$lottery_type;
        $this->$funcName();
    }
    
    public function checkSsq(){
        $data = array();
        $data['a'] = str_pad(intval($this->input->get('a')), 2, 0, STR_PAD_LEFT);
        $data['b'] = str_pad(intval($this->input->get('b')), 2, 0, STR_PAD_LEFT);
        $data['c'] = str_pad(intval($this->input->get('c')), 2, 0, STR_PAD_LEFT);
        $data['d'] = str_pad(intval($this->input->get('d')), 2, 0, STR_PAD_LEFT);
        $data['e'] = str_pad(intval($this->input->get('e')), 2, 0, STR_PAD_LEFT);
        $data['f'] = str_pad(intval($this->input->get('f')), 2, 0, STR_PAD_LEFT);
        $data['g'] = str_pad(intval($this->input->get('g')), 2, 0, STR_PAD_LEFT);
        
        $this->load->model('LotteryModel');
        $rt = $this->LotteryModel->checkSsq($data);
        
        if(empty($rt)){
            $rt = array();
            $rt['rtn'] = 0;
            foreach($data as &$_v){
                $_v = str_pad($_v, 2, '0', STR_PAD_LEFT);
            }
            $rt['msg'] = '<p class="weui_media_desc">很遗憾，<span class="text-primary">'.implode('</span>,<span class="text-primary">', array_slice($data, 0, 6)).'</span>+<span class="text-danger">'. $data['g'] .'</span>未中奖...</p>';
            $this->json($rt);
            return true;
        }
        
        
        
        $str = '';
        foreach($rt as $_k=>$_v){
            if($_k==='二等奖' || $_k==='一等奖'){
                foreach($_v as $_vv){
                    $str .= '<p class="weui_media_desc">'.date('Y-m-d', strtotime($_vv['insert_time'])).'&nbsp;&nbsp;中'. $_k .'，奖金<span class="text-danger">￥'. number_format($_vv['pride_value'], 0, '', ',') .'元</span></p>';
                }
            }else{
                $str .= '<p class="weui_media_desc">中'. $_k .'<span class="text-danger">'. $_v .'次</span></p>';
            }
        }
        
        $rt = array();
        $rt['rtn'] = 0;
        $rt['msg'] = '<p class="weui_media_desc">恭喜你，<span class="text-primary">'.implode('</span>,<span class="text-primary">', array_slice($data, 0, 6)).'</span>+<span class="text-danger">'. $data['g'] .'</span></p>'. $str;
        $this->json($rt);
        return true;
    }
    
    public function checkFc3d(){
        $data = array();
        $data['a'] = intval($this->input->get('a'));
        $data['b'] = intval($this->input->get('b'));
        $data['c'] = intval($this->input->get('c'));
        
        $this->load->model('LotteryModel');
        $rt = $this->LotteryModel->checkFc3d($data);
        
        if(empty($rt)){
            $rt = array();
            $rt['rtn'] = 0;
            $rt['msg'] = '<p class="weui_media_desc">很遗憾，<span class="text-primary">'.implode('</span>,<span class="text-primary">', $data).'</span>未中奖...</p>';
            $this->json($rt);
            return true;
        }
        
        
        
        $str = '';
        foreach($rt as $_k=>$_v){
            $str .= '<p class="weui_media_desc">'. $_k .'<span class="text-danger">'. $_v .'次</span></p>';
        }
        
        $rt = array();
        $rt['rtn'] = 0;
        $rt['msg'] = '<p class="weui_media_desc">恭喜你，<span class="text-primary">'.implode('</span>,<span class="text-primary">', $data).'</span></p>'. $str;
        $this->json($rt);
        return true;
    }
    
    public function checkDlt(){
        $data = array();
        $data['a'] = intval($this->input->get('a'));
        $data['b'] = intval($this->input->get('b'));
        $data['c'] = intval($this->input->get('c'));
        $data['d'] = intval($this->input->get('d'));
        $data['e'] = intval($this->input->get('e'));
        $data['f'] = intval($this->input->get('f'));
        $data['g'] = intval($this->input->get('g'));
        
        $rt = array();
        $rt['rtn'] = 0;
        foreach($data as &$_v){
            $_v = str_pad($_v, 2, '0', STR_PAD_LEFT);
        }
        $rt['msg'] = '很遗憾，<span class="text-primary">'.implode('</span>,<span class="text-primary">', array_slice($data, 0, 5)).'</span>+<span class="text-danger">'. implode('</span>&nbsp;&nbsp;<span class="text-danger">', array_slice($data, 5, 2)) .'</span>未中奖...';
        $this->json($rt);
        return true;
    }
    
    public function checkPl5(){
        $data = array();
        $data['a'] = intval($this->input->get('a'));
        $data['b'] = intval($this->input->get('b'));
        $data['c'] = intval($this->input->get('c'));
        $data['d'] = intval($this->input->get('d'));
        $data['e'] = intval($this->input->get('e'));
        
        $rt = array();
        $rt['rtn'] = 0;
        $rt['msg'] = '很遗憾，<span class="text-primary">'.implode('</span>,<span class="text-primary">', $data).'</span>未中奖...';
        $this->json($rt);
        return true;
    }
    
    public function checkPl3(){
        $data = array();
        $data['a'] = intval($this->input->get('a'));
        $data['b'] = intval($this->input->get('b'));
        $data['c'] = intval($this->input->get('c'));
        
        $rt = array();
        $rt['rtn'] = 0;
        $rt['msg'] = '很遗憾，<span class="text-primary">'.implode('</span>,<span class="text-primary">', $data).'</span>未中奖...';
        $this->json($rt);
        return true;
    }
    
    public function checkQxc(){
        $data = array();
        $data['a'] = intval($this->input->get('a'));
        $data['b'] = intval($this->input->get('b'));
        $data['c'] = intval($this->input->get('c'));
        $data['d'] = intval($this->input->get('d'));
        $data['e'] = intval($this->input->get('e'));
        $data['f'] = intval($this->input->get('f'));
        $data['g'] = intval($this->input->get('g'));
        
        $rt = array();
        $rt['rtn'] = 0;
        $rt['msg'] = '很遗憾，<span class="text-primary">'.implode('</span>,<span class="text-primary">', $data).'</span>未中奖...';
        $this->json($rt);
        return true;
    }
}