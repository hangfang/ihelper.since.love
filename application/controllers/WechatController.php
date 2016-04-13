<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WechatController extends MY_Controller {
    
    /**
     *  Content     文本消息内容
     *  CreateTime	消息创建时间 （整型）
     *  Description 消息描述
     *  Format      语音格式，如amr，speex等
     *  FromUserName发送方帐号（一个OpenID）
     *  Label       地理位置信息
     *  Location_X	地理位置维度
     *  Location_Y	地理位置经度
     *  MediaId     视频消息媒体id，可以调用多媒体文件下载接口拉取数据。
     *  MsgId       消息id，64位整型
     *  MsgType     消息类型: 文本、图片、语音、视频、小视频、位置、链接 
     *  PicUrl      图片链接
     *  Recognition 语音识别结果，UTF8编码
     *  Scale       地图缩放大小
     *  ThumbMediaId视频消息缩略图的媒体id，可以调用多媒体文件下载接口拉取数据。
     *  Title       消息标题
     *  ToUserName	开发者微信号
     * @var array
     */
    public $_receive_format = array(
            'text' => array('ToUserName', 'FromUserName', 'CreateTime', 'MsgType', 'Content', 'MsgId'),
            'image' => array('ToUserName', 'FromUserName', 'CreateTime', 'MsgType', 'PicUrl', 'MediaId', 'MsgId'),
            'voice' => array('ToUserName', 'FromUserName', 'CreateTime', 'MsgType', 'MediaId', 'Format', 'MsgId', 'Recognition'),
            'video' => array('ToUserName', 'FromUserName', 'CreateTime', 'MsgType', 'MediaId', 'ThumbMediaId', 'MsgId'),
            'shortvideo' => array('ToUserName', 'FromUserName', 'CreateTime', 'MsgType', 'MediaId', 'ThumbMediaId', 'MsgId'),
            'location' => array('ToUserName', 'FromUserName', 'CreateTime', 'MsgType', 'Location_X', 'Location_Y', 'Scale', 'Label', 'MsgId'),
            'link' => array('ToUserName', 'FromUserName', 'CreateTime', 'MsgType', 'Title', 'Description', 'Url', 'MsgId'),
            'event' => array('ToUserName', 'FromUserName', 'CreateTime', 'MsgType', 'Event', 'EventKey', 'Latitude', 'Longitude', 'Precision', 'Ticket', 'MsgId'),
        );
    
    public $_send_format = array(
            'text' => array('touser'=>'', 'msgtype'=>'text', 'text'=>array('content'=>'')),
            'image' => array('touser'=>'', 'msgtype'=>'image', 'image'=>array('media_id'=>'')),
            'voice' => array('touser'=>'', 'msgtype'=>'voice', 'voice'=>array('media_id'=>'')),
            'video' => array('touser'=>'', 'msgtype'=>'video', 'video'=>array('media_id'=>'', 'thumb_media_id'=>'', 'title'=>'', 'description'=>'')),
            'music' => array('touser'=>'', 'msgtype'=>'music', 'music'=>array('title'=>'', 'description'=>'', 'musicurl'=>'', 'hqmusicurl'=>'', 'thumb_media_id'=>'')),
            'news' => array('touser'=>'', 'msgtype'=>'news', 'news'=>array('articles'=>array('title'=>'', 'description'=>'', 'url'=>'', 'picurl'=>''))),
        );
    
    public $_unrecognized_msg = <<<EOF
咦，您是说“%s”吗？
可小i尚小，未能处理ㄒoㄒ

1、发送如“北京”<a href="http://ihelper.since.love/#/weather">查询</a>天气
2、发送如“申通，xx”<a href="http://ihelper.since.love/#/express">查询</a>物流
3、发送如“600000”<a href="http://ihelper.since.love/#/stock">查询</a>股票数据
4、发送如“美容”等，搜索周边
5、更多隐藏功能由您发掘…
        
感谢关注
EOF;
        
    public $_msg_to_large = <<<EOF
额，信息量太大
请说重点(*≧▽≦*)

1、发送如“北京”<a href="http://ihelper.since.love/#/weather">查询</a>天气
2、发送如“申通，xx”<a href="http://ihelper.since.love/#/express">查询</a>物流
3、发送如“600000”<a href="http://ihelper.since.love/#/stock">查询</a>股票数据
4、发送如“美容”等，搜索周边
5、更多隐藏功能由您发掘…
        
感谢关注
EOF;

    public $_msg_welcome_back = <<<EOF
热烈欢迎老伙伴回归！

1、发送如“北京”<a href="http://ihelper.since.love/#/weather">查询</a>天气
2、发送如“申通，xx”<a href="http://ihelper.since.love/#/express">查询</a>物流
3、发送如“600000”<a href="http://ihelper.since.love/#/stock">查询</a>股票数据
4、发送如“美容”等，搜索周边
5、更多隐藏功能由您发掘…
        
感谢关注
EOF;

    public $_msg_welcome_newbeing = <<<EOF
撒花欢迎新朋友到来！

1、发送如“北京”<a href="http://ihelper.since.love/#/weather">查询</a>天气
2、发送如“申通，xx”<a href="http://ihelper.since.love/#/express">查询</a>物流
3、发送如“600000”<a href="http://ihelper.since.love/#/stock">查询</a>股票数据
4、发送如“美容”等，搜索周边
5、更多隐藏功能由您发掘…
        
感谢关注
EOF;
       
    public $_msg_position = <<<EOF
OK，我记住了
您在%s！
试试搜索周边？如酒店、美食...
EOF;
    
        public $_msg_position_expired = <<<EOF
您的位置信息已很久远
于[%s]定位
为精确搜索周边，请重新发送位置
EOF;
       
    public function __construct() {
        parent::__construct();
        $this->load->model('KuaidiModel');
        $this->load->model('PositionModel');
        $this->load->model('BaiduModel');
        $this->load->model('WechatModel');
        $this->load->helper('include');
    }
    
    public function index(){
        header('location: /');
    }
    
    public function message(){
        $data = file_get_contents('php://input');
        /**
         * 微信消息结构
         * <xml>
         *       <ToUserName><![CDATA[%s]]></ToUserName>
         *       <FromUserName><![CDATA[%s]]></FromUserName>
         *       <CreateTime>%s</CreateTime>
         *       <MsgType><![CDATA[%s]]></MsgType>
         *       <Content><![CDATA[%s]]></Content>
         *       <FuncFlag>0</FuncFlag>
         *   </xml>
         */
      	//extract xml data
		if (!empty($data)){
            libxml_disable_entity_loader(true);
            $msgXml = json_decode(json_encode(simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
            
            $msg = array();
            foreach($this->_receive_format[$msgXml['MsgType']] as $_v){
                if($msgXml['MsgType']==='event'){
                    if(in_array($_v, array('EventKey', 'Latitude', 'Longitude', 'Precision'))){
                        empty($msgXml[$_v]) && $msg[$_v] = $msgXml[$_v] = '';
                    }
                }
                $msg[$_v] = isset($msgXml[$_v]) ? $msgXml[$_v] : '';
            }

            $suc = $this->WechatModel->saveMessage($msg);
            
            $msgtype = $msgXml['MsgType']==='event' ? $msgXml['MsgType'].Ucfirst(strtolower($msgXml['Event'])) : $msgXml['MsgType'];
            $this->$msgtype($msgXml);
        }
    }
    
    private function text($msgXml){
        
        $contents = $msgXml['Content'];
        
        $contents = trim(str_replace(array('，', ','), array(' ', ' '), $contents));
        $contents = explode(' ', $contents);

        switch(count($contents)){
            case 1:
                if(($kdniao = include_config('kdniao')) && in_array($contents[0], array_keys($kdniao))){//快递公司
                    $this->getExpressCom($contents[0], $msgXml);
                }else if(($weather = include_config('weather')) && in_array($contents[0], array_keys($weather))){//天气
                    $this->getWeather($weather[$contents[0]], $msgXml);
                }else if(($wechat = include_config('wechat')) && in_array($contents[0], $wechat['daigou'])){//图文广告
                    $this->daigou();
                }else if(in_array($contents[0], $wechat['at'])){//关注微信号
                    $this->hopeSubscribe($msgXml);
                }elseif(in_array($contents[0], $wechat['position'])){//提示发送位置信息
                    $this->tellMeYourPosition($msgXml);
                }elseif(preg_match('/^[\d]{6}$/i', $contents[0]) === 1){//股票代码
                    $this->getStock($stockid, $msgXml);
                }elseif(in_array($contents[0], $wechat['around'])){//上一条是位置信息
                    $this->searchAround($contents[0], $msgXml);
                }elseif($contents[0]==='快递'){
                    $this->getRecentExpress($msgXml);
                }elseif($contents[0]==='天气'){
                    $this->getRecentWeather($msgXml);
                }else{
                    $this->unrecognize($msg, $msgXml);
                }
            case 2:
                if(($kdniao = include_config('kdniao')) && in_array($contents[0], array_keys($kdniao))){
                    $this->getExpress($kdniao[$contents[0]], $contents[1], $msgXml);
                }
            default :
                $this->complexedMessage($msgXml);
        }
    }
    
    private function image($msgXml){
        $data = $this->_send_format['text'];
        $data['touser'] = $msgXml['FromUserName'];
        $data['fromuser'] = $msgXml['ToUserName'];
        $data['text']['content'] = '抱歉，图片处理comming soon...';
        $this->WechatModel->sendMessage($data);
    }
    
    private function voice($msgXml){
        $msgXml['Content'] = trim($msgXml['Recognition'], '？！');
        if(strlen($msgXml['Content'])>0){
            $this->text($msgXml);
        }
        
        //
        $data = $this->_send_format['text'];
        $data['touser'] = $msgXml['FromUserName'];
        $data['fromuser'] = $msgXml['ToUserName'];
        $data['text']['content'] = '正在接入语音机器人...';
        $this->WechatModel->sendMessage($data);
    }
    
    private function video($msgXml){
        
        $data = $this->_send_format['text'];
        $data['touser'] = $msgXml['FromUserName'];
        $data['fromuser'] = $msgXml['ToUserName'];
        $data['text']['content'] = '分享视频真的好吗？';
        $this->WechatModel->sendMessage($data);
    }
    
    private function shortvideo($msgXml){
        
        $data = $this->_send_format['text'];
        $data['touser'] = $msgXml['FromUserName'];
        $data['fromuser'] = $msgXml['ToUserName'];
        $data['text']['content'] = 'Oh, I like it';
        $this->WechatModel->sendMessage($data);
    }
    
    private function location($msgXml){
//        
//        //查询腾讯地图
//        $rt = $this->PositionModel->getLocation($msgXml['Location_X'], $msgXml['Location_Y']);
//
//        if($rt['status'] === 0){
//
//            $data = $this->_send_format['text'];
//            $data['touser'] = $msgXml['FromUserName'];
//            $data['fromuser'] = $msgXml['ToUserName'];
//            $data['text']['content'] = sprintf($this->_msg_position, $rt['result']['address']);
//            $this->WechatModel->sendMessage($data);
//
//        }
        $data = $this->_send_format['text'];
        $data['touser'] = $msgXml['FromUserName'];
        $data['fromuser'] = $msgXml['ToUserName'];
        $data['text']['content'] = sprintf($this->_msg_position, $msgXml['Label']);
        //$data['text']['content'] = $rt['message'];
        $this->WechatModel->sendMessage($data);
    }
    
    private function link($msgXml){
        
        $data = $this->_send_format['text'];
        $data['touser'] = $msgXml['FromUserName'];
        $data['fromuser'] = $msgXml['ToUserName'];
        $data['text']['content'] = '等等，对，这链接有毒！';
        $this->WechatModel->sendMessage($data);
    }

    private function event($msgXml){
        $this->$msgXml['Event']($msgXml);
    }

    /**
    * @todo 订阅的事件推送
    */
    private function eventSubscribe($msgXml){
        $rt = $this->WechatModel->subscribe($msgXml['FromUserName']);

        $data = $this->_send_format['text'];
        $data['touser'] = $msgXml['FromUserName'];
        $data['fromuser'] = $msgXml['ToUserName'];
        $data['text']['content'] = $rt==='new' ? $this->_msg_welcome_newbeing : $this->_msg_welcome_back;
        $this->WechatModel->sendMessage($data);
    }

    /**
    * @todo 取消订阅的事件推送
    */
    private function eventUnsubscribe($msgXml){
        $rt = $this->WechatModel->unsubscribe($msgXml['FromUserName']);
    }

    /**
    * @todo 扫描二维码的事件推送
    */
    private function eventScan($msgXml){
        $data = $this->_send_format['text'];
        $data['touser'] = $msgXml['FromUserName'];
        $data['fromuser'] = $msgXml['ToUserName'];
        $data['text']['content'] = '扫描结果：'. $msgXml['EventKey'];
        $this->WechatModel->sendMessage($data);
    }

    /**
    * @todo 地理位置上报的事件推送（订阅号不支持）
    */
    private function eventLocation($msgXml){
        //$rt = $this->WechatModel->location($msgXml);

        $data = $this->_send_format['text'];
        $data['touser'] = $msgXml['FromUserName'];
        $data['fromuser'] = $msgXml['ToUserName'];
        $data['text']['content'] = $msgXml['FromUserName'] .'上报位置';
        $this->WechatModel->sendMessage($data);
    }

    /**
    * @todo 点击菜单拉取消息的事件推送
    */
    private function eventClick($msgXml){

        $data = $this->_send_format['text'];
        $data['touser'] = $msgXml['FromUserName'];
        $data['fromuser'] = $msgXml['ToUserName'];
        $data['text']['content'] = $msgXml['FromUserName'] .'点击菜单';
        $this->WechatModel->sendMessage($data);
    }

    /**
    * @todo 点击菜单跳转链接时的事件推送
    */
    private function eventView($msgXml){

        $data = $this->_send_format['text'];
        $data['touser'] = $msgXml['FromUserName'];
        $data['fromuser'] = $msgXml['ToUserName'];
        $data['text']['content'] = $msgXml['FromUserName'] .'菜单跳转';
        $this->WechatModel->sendMessage($data);
    }
    
    public function daigou($msgXml){
        $data = $this->_send_format['news'];
        $data['touser'] = $msgXml['FromUserName'];
        $data['fromuser'] = $msgXml['ToUserName'];

        $data['news'] = $tmp = array();
        $tmp['title'] = '香港代购';
        $tmp['description'] = '#4月5日#今天才是小胖妹真正意义上的生日，也因为她，妈咪才走上#香港代购#这条不归路[偷笑]';
        $tmp['picurl'] = 'https://mmbiz.qlogo.cn/mmbiz/vacvmEeokHY8vfIeqTeF3rR8gGria7u8m0rzD2EoVDCpo64IjyDwkkxicN0pKNUwfHzjKmShsNBGMLicnPwTUAbJA/0?wx_fmt=jpeg';
        $tmp['url'] = 'http://mp.weixin.qq.com/s?__biz=MzI4NzIyMjQwNw==&mid=100000006&idx=1&sn=2f99b09162bba5902ac99acf99ef9659#rd';
        $data['news'][] = $tmp;

        $data['article_count'] = count($data['news']);

        $this->WechatModel->sendMessage($data);
    }
    
    public function getExpressCom($msg, $msgXml){
        $data = $this->_send_format['text'];
        $data['touser'] = $msgXml['FromUserName'];
        $data['fromuser'] = $msgXml['ToUserName'];
        $data['text']['content'] = '咳，终于找到“'. $msg .'”公司...';
        $this->WechatModel->sendMessage($data);
    }
    
    public function getStock($stockid, $msgXml){
        if(preg_match('/^6[\d]{5}$/i', $stockid) === 1){
            $stockid = 'sh'. $stockid;//上海
        }elseif(preg_match('/^0[\d]{5}|3[\d]{5}$/i', $stockid) === 1){
            $stockid = 'sz'. $stockid;//深圳
        }else{
            $stockid = $stockid;
        }


        $data = $this->BaiduModel->getStock($stockid, $msgXml);
        $this->WechatModel->sendMessage($data);
    }
    
    public function unrecognize($msg, $msgXml){
        $data = $this->_send_format['text'];
        $data['touser'] = $msgXml['FromUserName'];
        $data['fromuser'] = $msgXml['ToUserName'];
        $data['text']['content'] = sprintf($this->_unrecognized_msg, $msg);
        $this->WechatModel->sendMessage($data);
    }
    
    public function hopeSubscribe($msgXml){
        $data = $this->_send_format['text'];
        $data['touser'] = $msgXml['FromUserName'];
        $data['fromuser'] = $msgXml['ToUserName'];
        $data['text']['content'] = '搜索“'. WX_HK_ACCOUNT .'”吧'."\n".'期待您的关注n(*≧▽≦*)n';
        $this->WechatModel->sendMessage($data);
    }
    
    public function tellMeYourPosition($msgXml){
        $data = $this->_send_format['text'];
        $data['touser'] = $msgXml['FromUserName'];
        $data['fromuser'] = $msgXml['ToUserName'];
        $data['text']['content'] = '爽快点，告诉我你的位置吧？';
        $this->WechatModel->sendMessage($data);
    }
    
    public function searchAround($msg, $msgXml){
        $lastMsg = $this->WechatModel->getLastReceiveMsg($msgXml, array('MsgType'=>'location'));
        if(empty($lastMsg)){
            $data = $this->_send_format['text'];
            $data['touser'] = $msgXml['FromUserName'];
            $data['fromuser'] = $msgXml['ToUserName'];
            $data['text']['content'] = '请发送您的位置，以精准定位';
            $this->WechatModel->sendMessage($data);
        }elseif(time()-strtotime($lastMsg['CreateTime']) > 300){
            $this->load->library('friendlydate');
            $data = $this->_send_format['text'];
            $data['touser'] = $msgXml['FromUserName'];
            $data['fromuser'] = $msgXml['ToUserName'];
            $data['text']['content'] = sprintf($this->_msg_position_expired, $this->friendlydate->timeDiff($lastMsg['CreateTime']));
            $this->WechatModel->sendMessage($data);
        }

        $data = $this->PositionModel->searchAround($lastMsg, $msgXml);
        $this->WechatModel->sendMessage($data);
    }
    
    public function getRecentExpress($msgXml){
        $lastMessage = $this->WechatModel->getLastSendMsg($msgXml, array('msgtype'=>'text'), array('content'=>array('value'=>'公司名称', 'side'=>'after')));
                    
        if(!empty($lastMessage)){

            $com_nu = explode('物流信息', $lastMessage['content']);
            $com_nu = explode("\n", $com_nu[0]);

            list($tmp, $com) = explode('：', $com_nu[0]);
            list($tmp, $nu) = explode('：', $com_nu[1]);
            $data = $this->KuaidiModel->kdniao($kdniao[$com], $nu, $msgXml);
            $this->WechatModel->sendMessage($data);
        }
    }
    
    public function getRecentWeather($msgXml){
        $lastMessage = $this->WechatModel->getLastSendMsg($msgXml, array('msgtype'=>'text'), array('content'=>array('value'=>'天气', 'side'=>'after')));    
        if(!empty($lastMessage)){

            $city = explode("\n", $lastMessage['content']);

            preg_match_all('/\((.+)\)/', $city[0], $match);
            $weather = include_config('weather');
            $data = $this->BaiduModel->getWeather($weather[$match[1][0]], $msgXml);
            $this->WechatModel->sendMessage($data);
        }
    }
    
    public function getWeather($msg, $msgXml){
        $data = $this->BaiduModel->getWeather($msg, $msgXml);
        $this->WechatModel->sendMessage($data);
    }
    
    public function getExpress($com, $nu, $msgXml){
        $data = $this->KuaidiModel->kdniao($com, $nu, $msgXml);
        $this->WechatModel->sendMessage($data);
    }
    
    public function complexedMessage($msgXml){
        $data = $this->_send_format['text'];
        $data['touser'] = $msgXml['FromUserName'];
        $data['fromuser'] = $msgXml['ToUserName'];
        $data['text']['content'] = $this->_msg_to_large;
        $this->WechatModel->sendMessage($data);
    }
}
