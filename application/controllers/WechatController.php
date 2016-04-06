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
    
    public $text = <<<EOF
<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[%s]]></Content>
</xml>
EOF;
    
    public $image = <<<EOF
<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[image]]></MsgType>
<Image>
<MediaId><![CDATA[%s]]></MediaId>
</Image>
</xml>
EOF;
    
    public $voice = <<<EOF
<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[voice]]></MsgType>
<Voice>
<MediaId><![CDATA[%s]]></MediaId>
</Voice>
</xml>
EOF;
    public $video = <<<EOF
<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[video]]></MsgType>
<Video>
<MediaId><![CDATA[%s]]></MediaId>
<Title><![CDATA[%s]]></Title>
<Description><![CDATA[%s]]></Description>
</Video> 
</xml>
EOF;

    public $music = <<<EOF
<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[music]]></MsgType>
<Music>
<Title><![CDATA[%s]]></Title>
<Description><![CDATA[%s]]></Description>
<MusicUrl><![CDATA[%s]]></MusicUrl>
<HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
<ThumbMediaId><![CDATA[%s]]></ThumbMediaId>
</Music>
</xml>
EOF;
    
    public $news = <<<EOF
<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[news]]></MsgType>
<ArticleCount>%s</ArticleCount>
<Articles>
<item>
<Title><![CDATA[%s]]></Title> 
<Description><![CDATA[%s]]></Description>
<PicUrl><![CDATA[%s]]></PicUrl>
<Url><![CDATA[%s]]></Url>
</item>
<item>
</Articles>
</xml> 
EOF;
    
    public $_msg = array();

	public function index()
	{
        header('location: /');
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
            
            foreach($this->_receive_format[$msgXml['MsgType']] as $_v){
                $this->_msg[$_v] = $msgXml[$_v];
            }
            
            $this->load->model('WechatModel');
            $suc = $this->WechatModel->saveMessage($this->_msg);
            
            if($msgXml['MsgType'] === 'text'){
                $contents = explode(' ', $msgXml['Content']);
                if(count($contents) === 1){
                    $expressCompanyName = array_keys($this->config->item('express_list'));
                    if(in_array($contents[0], $expressCompanyName)){
                        $data = $this->_send_format['text'];
                        $data['touser'] = $msgXml['FromUserName'];
                        $data['text']['content'] = '抱歉，查无名为“'. $contents[0] .'”的快递公司...';
                        $this->WechatModel->sendMessage($data);
                        
                        $msg = sprintf($this->text, $msgXml['FromUserName'], $msgXml['ToUserName'], time(), '抱歉，查无名为“'. $contents[0] .'”的快递公司...');
                    }elseif(in_array($contents[0], $this->config->item('province_city'))){
                        $data = $this->_send_format['text'];
                        $data['touser'] = $msgXml['FromUserName'];
                        $data['text']['content'] = '抱歉，查无名为“'. $contents[0] .'”的地区...';
                        $this->WechatModel->sendMessage($data);
                        
                        $msg = sprintf($this->text, $msgXml['FromUserName'], $msgXml['ToUserName'], time(), '抱歉，查无名为“'. $contents[0] .'”的地区...');
                    }else{
                        $data = $this->_send_format['text'];
                        $data['touser'] = $msgXml['FromUserName'];
                        $data['text']['content'] = '您是说“'. $contents[0] .'”吗？';
                        $this->WechatModel->sendMessage($data);
                        
                        $msg = sprintf($this->text, $msgXml['FromUserName'], $msgXml['ToUserName'], time(), '您是说“'. $contents[0] .'”吗？');
                    }
                    
                    header('Content-Type: text/xml;');
                    echo $msg;
                }
            }
        }else {
        	log_message('error', 'get message from weixin failed');
        	exit;
        }
    }
}
