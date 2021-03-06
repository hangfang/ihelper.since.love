<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class KuaidiModel extends MY_Model{
    
    public $_msg_kuaidi = <<<EOF
公司名称：%s
快递单号：%s
物流信息：%s
EOF;
    
    public function kdniao($com, $nu, $msgXml=array()){
        $queryData = array();
        $queryData['ShipperCode'] = $com;
        $queryData['LogisticCode'] = $nu;
        
        $param = array();
        $param['RequestData'] = json_encode($queryData);
        $param['EBusinessID'] = KD_NIAO_APP_ID;
        $param['RequestType'] = 1002;
        $param['DataSign'] = base64_encode(md5($param['RequestData'].KD_NIAO_APP_KEY));
        $param['DataType'] = 2;
        
        
        $data = array();
        $data['data'] = $param;
        $data['url'] = KD_NIAO_API_URL;
        
        $rt = $this->http($data);
        
        if(empty($msgXml)){
            return $rt;
        }
        $this->load->helper('include');
        $kdniao = array_flip(include_config('kdniao'));

        if($rt['Success'] === false){
                        
            $data = $this->_send_format['text'];
            $data['touser'] = $msgXml['FromUserName'];
            $data['fromuser'] = $msgXml['ToUserName'];
            
            $data['text']['content'] = sprintf($this->_msg_kuaidi, $kdniao[$rt['ShipperCode']], $rt['LogisticCode'], $rt['Reason']);
            return $data;
        }
        $data = $this->_send_format['text'];
        $data['touser'] = $msgXml['FromUserName'];
        $data['fromuser'] = $msgXml['ToUserName'];

        $_trace = "\n";
        foreach($rt['Traces'] as $_v){

            $_trace .= '    时间:'. date('m月d日 H:i:s', strtotime($_v['AcceptTime'])) ."\n";
            $_trace .= '    信息:'. $_v['AcceptStation'] ."\n";
        }
        $data['text']['content'] = sprintf($this->_msg_kuaidi, $kdniao[$rt['ShipperCode']], $rt['LogisticCode'], strlen($_trace)>10 ? $_trace : $rt['Reason']);
        return $data;
    }
}