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
可是小i还小，未能理解ㄒoㄒ

1、输入“城市中文名”查询天气
2、输入“快递公司名称，单号”查询物流
3、其他功能期待您的发掘(⊙o⊙)…
        
再次感谢您的关注
EOF;
        
        public $_msg_to_large = <<<EOF
额，信息量太大？
请说重点吧(*≧▽≦*)

1、输入“城市中文名”查询天气
2、输入“快递公司名称，单号”查询物流
3、其他功能期待您的发掘(⊙o⊙)…
        
再次感谢您的关注
EOF;
        
    public function __construct() {
        parent::__construct();
        $this->load->model('WechatModel');
        $this->load->model('KuaidiModel');
    }
    
	public function index()
	{
        
        $data = array();
        $data['title'] = '微信jsapi测试';
        $sigObj = $this->WechatModel->getJsApiSigObj();
        
        $data = array_merge($data, $sigObj);
        $this->layout->view('Wechat/index', $data);
	}
    
    public function message(){
        $data = file_get_contents('php://input');
        /**
         * 微信消息结构
         * <xml>
                <ToUserName><![CDATA[%s]]></ToUserName>
                <FromUserName><![CDATA[%s]]></FromUserName>
                <CreateTime>%s</CreateTime>
                <MsgType><![CDATA[%s]]></MsgType>
                <Content><![CDATA[%s]]></Content>
                <FuncFlag>0</FuncFlag>
            </xml>
         */
      	//extract xml data
		if (!empty($data)){
            libxml_disable_entity_loader(true);
            $msgXml = json_decode(json_encode(simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
            
            $msg = array();
            foreach($this->_receive_format[$msgXml['MsgType']] as $_v){
                $msg[$_v] = $msgXml[$_v];
            }
            
            $suc = $this->WechatModel->saveMessage($msg);
            
            $msgtype = $msgXml['MsgType'];
            $this->$msgtype($msgXml);
        }
    }
    
    private function text($msgXml){
        
        $contents = $msgXml['MsgType'] === 'text' ? $msgXml['Content'] : trim($msgXml['Recognition'], '？');
        $contents = trim(trim($contents, ','), ' ');
        $contents = count(explode(',', $contents)) === 2 ? explode(',', $contents) : explode(' ', $contents);
        
        if(empty($contents)){
            $data = $this->_send_format['text'];
            $data['touser'] = $msgXml['FromUserName'];
            $data['fromuser'] = $msgXml['ToUserName'];
            $data['text']['content'] = '不知所云...';
            $this->WechatModel->sendMessage($data, 'text');
        }

        switch(count($contents)){
            case 1:
                $expressCompanyName = array_keys($this->config->item('express_list'));
                if(in_array($contents[0], $expressCompanyName)){
                    $data = $this->_send_format['text'];
                    $data['touser'] = $msgXml['FromUserName'];
                    $data['fromuser'] = $msgXml['ToUserName'];
                    $data['text']['content'] = '咳，终于找到“'. $contents[0] .'”公司...';
                    $this->WechatModel->sendMessage($data);

                }else if(in_array($contents[0], array_keys($this->config->item('city')))){
                    $data = $this->_send_format['text'];
                    $data['touser'] = $msgXml['FromUserName'];
                    $data['fromuser'] = $msgXml['ToUserName'];
                    $data['text']['content'] = '咦，你很关心“'. $contents[0] .'”地区？';
                    $this->WechatModel->sendMessage($data);

                }else if(strpos($this->config->item('daigou'), $contents[0])!== false){
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

                }else if(strpos($this->config->item('at'), $contents[0])!== false){
                    $data = $this->_send_format['text'];
                    $data['touser'] = $msgXml['FromUserName'];
                    $data['fromuser'] = $msgXml['ToUserName'];
                    $data['text']['content'] = '搜索“'. WX_HK_ACCOUNT .'”吧'."\n".'期待您的关注n(*≧▽≦*)n';
                    $this->WechatModel->sendMessage($data);

                }else{
                    $data = $this->_send_format['text'];
                    $data['touser'] = $msgXml['FromUserName'];
                    $data['fromuser'] = $msgXml['ToUserName'];
                    $data['text']['content'] = sprintf($this->_unrecognized_msg, $contents[0]);
                    $this->WechatModel->sendMessage($data);
                }
                
                break;
            case 2:
                $expressCompanyName = array_search($contents[0], array_keys($this->config->item('express_list')));
                if($expressCompanyName){
                    
                    $rt = $this->KuaidiModel->query($this->config->item('express_list')[$contents[0]], $contents[1]);
                    
                    $data = $this->_send_format['text'];
                    $data['touser'] = $msgXml['FromUserName'];
                    $data['fromuser'] = $msgXml['ToUserName'];
                    $data['text']['content'] = '咳，终于找到“'. $contents[0] .'”公司...';
                    $this->WechatModel->sendMessage($data);
                    break;
                }
            default :
                $data = $this->_send_format['text'];
                $data['touser'] = $msgXml['FromUserName'];
                $data['fromuser'] = $msgXml['ToUserName'];
                $data['text']['content'] = sprintf($this->_msg_to_large, $contents[0]);
                $this->WechatModel->sendMessage($data);
                break;
        }
    }
    
    private function image($msgXml){
        $data = $this->_send_format['text'];
        $data['touser'] = $msgXml['FromUserName'];
        $data['fromuser'] = $msgXml['ToUserName'];
        $data['text']['content'] = '抱歉，图片处理comming soon...';
        $this->WechatModel->sendMessage($data);
    }
    
    public function voice($msgXml){
        
        $data = $this->_send_format['text'];
        $data['touser'] = $msgXml['FromUserName'];
        $data['fromuser'] = $msgXml['ToUserName'];
        $data['text']['content'] = '正在接入语音机器人...';
        $this->WechatModel->sendMessage($data);
    }
    
    public function video($msgXml){
        
        $data = $this->_send_format['text'];
        $data['touser'] = $msgXml['FromUserName'];
        $data['fromuser'] = $msgXml['ToUserName'];
        $data['text']['content'] = '分享视频真的好吗？';
        $this->WechatModel->sendMessage($data);
    }
    
    public function shortvideo($msgXml){
        
        $data = $this->_send_format['text'];
        $data['touser'] = $msgXml['FromUserName'];
        $data['fromuser'] = $msgXml['ToUserName'];
        $data['text']['content'] = 'Oh, I like it';
        $this->WechatModel->sendMessage($data);
    }
    
    public function location($msgXml){
        
        $data = $this->_send_format['text'];
        $data['touser'] = $msgXml['FromUserName'];
        $data['fromuser'] = $msgXml['ToUserName'];
        $data['text']['content'] = '我可不想窥探你的隐私';
        $this->WechatModel->sendMessage($data);
    }
    
    public function link($msgXml){
        
        $data = $this->_send_format['text'];
        $data['touser'] = $msgXml['FromUserName'];
        $data['fromuser'] = $msgXml['ToUserName'];
        $data['text']['content'] = '稍等，我点开看看';
        $this->WechatModel->sendMessage($data);
    }
}
