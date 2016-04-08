<?php
defined('BASEPATH') OR exit('No direct script access allowed');

define('WX_CGI_ADDR', 'https://api.weixin.qq.com/cgi-bin');
define('WX_APP_ID', 'wxd7739816540194cb');
define('WX_APP_SECRET', '82c0a8cdfc3daf060ceccd96016d43ed');

define('WX_TOKEN', 'fanghang2015ieg926400');
define('WX_ENCODING_AES_KEY', 'QC5CPFmTl06C7j3UYK4YuOdYaz4lBZTJjOywAbDnZwX');

define('WX_HK_ACCOUNT', 'WangLin-ling');
define('WX_JSAPI_DEBUG', true);

/*快递100*/
define('KUAIDI_100_APP_ID', 'b653f3a448ef4540');
define('KUAIDI_100_API_URL', 'http://api.kuaidi100.com/api?id='. KUAIDI_100_APP_ID .'&com=%s&nu=%s&show=%s&muti=%s&order=%s');

/*新浪ip查询*/
define('SINA_IP_LOOKUP_API_URL', 'http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json&ip=%s');

/*天气查询*/
define('BAIDU_WEATHER_API_URL', 'http://apis.baidu.com/apistore/weatherservice/cityid?cityid=%s');
/*股票查询*/
define('BAIDU_STOCK_API_URL', 'http://apis.baidu.com/apistore/stockservice/stock?stockid=%s&list=1');
define('BAIDU_API_KEY', 'babdf9f16f7b77baaa806eb302210ce9');

/*快递鸟*/
define('KD_NIAO_APP_ID', '1256662');
define('KD_NIAO_APP_KEY', '998e72f8-d8f2-4b56-9b55-4c3510d23275');
define('KD_NIAO_API_URL', 'http://api.kdniao.cc/Ebusiness/EbusinessOrderHandle.aspx');

/*腾讯地图*/
define('TENCENT_MAP_APP_KEY', 'J7CBZ-YV43X-PVS4E-ZGYVP-KF2T3-A3BQZ');
define('TENCENT_MAP_APP_URL', 'http://apis.map.qq.com/ws');