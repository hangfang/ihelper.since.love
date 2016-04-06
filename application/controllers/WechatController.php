<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WechatController extends MY_Controller {
    
    /**
     *  Content	文本消息内容
     *  CreateTime	消息创建时间 （整型）
     *  Description 消息描述
     *  Format	语音格式，如amr，speex等
     *  FromUserName	发送方帐号（一个OpenID）
     *  Label	地理位置信息
     *  Location_X	地理位置维度
     *  Location_Y	地理位置经度
     *  MediaId	视频消息媒体id，可以调用多媒体文件下载接口拉取数据。
     *  MsgId	消息id，64位整型
     *  MsgType	消息类型: 文本、图片、语音、视频、小视频、位置、链接 
     *  PicUrl	图片链接
     *  Scale	地图缩放大小
     *  ThumbMediaId	视频消息缩略图的媒体id，可以调用多媒体文件下载接口拉取数据。
     *  Title   消息标题
     *  ToUserName	开发者微信号
     * @var array
     */
    public $_format = array(
            'text' => array('ToUserName', 'FromUserName', 'CreateTime', 'MsgType', 'Content', 'MsgId'),
            'image' => array('ToUserName', 'FromUserName', 'CreateTime', 'MsgType', 'PicUrl', 'MediaId', 'MsgId'),
            'voice' => array('ToUserName', 'FromUserName', 'CreateTime', 'MsgType', 'MediaId', 'Format', 'MsgId'),
            'video' => array('ToUserName', 'FromUserName', 'CreateTime', 'MsgType', 'MediaId', 'ThumbMediaId', 'MsgId'),
            'shortvideo' => array('ToUserName', 'FromUserName', 'CreateTime', 'MsgType', 'MediaId', 'ThumbMediaId', 'MsgId'),
            'location' => array('ToUserName', 'FromUserName', 'CreateTime', 'MsgType', 'Location_X', 'Location_Y', 'Scale', 'Label', 'MsgId'),
            'link' => array('ToUserName', 'FromUserName', 'CreateTime', 'MsgType', 'Title', 'Description', 'Url', 'MsgId'),
        );
    
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
            $msgXml = simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA);
            
            foreach($_format[$msgXml->MsgType] as $_v){
                $this->_msg[$_v] = $msgXml->$_v;
            }
            
            $this->load->model('WechatModel');
            $suc = $this->WechatModel->saveMsg($this->_msg);
            
            
            
        }else {
        	log_message('error', 'get message from weixin failed');
        	exit;
        }
    }
}
