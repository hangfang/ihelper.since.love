<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class KuaidiModel extends MY_Model{
    
    /**
     *  请求参数说明：
     *  名称     类型	 是否必需	　　描述
     *   id     String      是      身份授权key，请 快递查询接口 进行申请（大小写敏感）
     *   com	String      是      要查询的快递公司代码，不支持中文，对应的公司代码见 《API URL 所支持的快递公司及参数说明》和《支持的国际类快递及参数说明》。 如果找不到您所需的公司，请发邮件至 kuaidi@kingdee.com 咨询（大小写不敏感）
     *   nu     String      是      要查询的快递单号，请勿带特殊符号，不支持中文（大小写不敏感）
     *   valicode	String	是      已弃用字段，无意义，请忽略。
     *   show	String      是      返回类型： 0：返回json字符串， 1：返回xml对象， 2：返回html对象， 3：返回text文本。 如果不填，默认返回json字符串。
     *   muti	String      是      返回信息数量： 1:返回多行完整的信息， 0:只返回一行信息。 不填默认返回多行。 
     *   order	String      是      排序： desc：按时间由新到旧排列， asc：按时间由旧到新排列。 不填默认返回倒序（大小写不敏感）
     * 
     * 
     * 返回数据说明：
     * com	物流公司编号
     * nu	物流单号
     * time	每条跟踪信息的时间
     * context	每条跟综信息的描述
     * state	快递单当前的状态 ：　 0：在途，即货物处于运输过程中；1：揽件，货物已由快递公司揽收并且产生了第一条跟踪信息；2：疑难，货物寄送过程出了问题；3：签收，收件人已签收；4：退签，即货物由于用户拒签、超区等原因退回，而且发件人已经签收；5：派件，即快递正在进行同城派件；6：退回，货物正处于退回发件人的途中
     * status	查询结果状态： 0：物流单暂无结果， 1：查询成功， 2：接口出现异常，
     * message	无意义，请忽略
     * condition	无意义，请忽略
     * ischeck	无意义，请忽略
     */
    public function query($com, $nu){
        $data = array();
        $data['method'] = 'get';
        $data['url'] = sprintf(KUAIDI_100_API_URL, $com, $nu, 0, 1, 'asc');
        return $this->http($data);
    }
}