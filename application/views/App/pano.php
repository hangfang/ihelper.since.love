</div>
<script src="http://map.qq.com/api/js?v=2.exp&key=J7CBZ-YV43X-PVS4E-ZGYVP-KF2T3-A3BQZ"></script>
<script src="/static/weui/js/jweixin-1.1.0.js?v=2016-04-07"></script>
<script>
    pano = new qq.maps.Panorama(document.getElementById('container'), {
        pano: '10011501120802180635300',    //场景ID
        pov:{   //视角
                heading:1,  //偏航角
                pitch:0     //俯仰角
            },
        zoom:1      //缩放
    })
    
    wx.config({
        debug: <?php echo $debug; ?>, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
        appId: '<?php echo $appid; ?>', // 必填，公众号的唯一标识
        timestamp: <?php echo $timestamp; ?>, // 必填，生成签名的时间戳
        nonceStr: '<?php echo $nonceStr; ?>', // 必填，生成签名的随机串
        signature: '<?php echo $signature; ?>', // 必填，签名，见附录1
        jsApiList: ['chooseImage','startRecord','stopRecord','playVoice','pauseVoice','stopVoice','hideMenuItems','showAllNonBaseMenuItem','hideAllNonBaseMenuItem','showOptionMenu','hideOptionMenu','scanQRCode','closeWindow', 'getNetworkType', 'openLocation', 'getLocation','translateVoice'] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
    });


    wx.ready(function () {
        wx.getLocation({
            type: 'wgs84', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
            success: function (res) {
                var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
                var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
                var speed = res.speed; // 速度，以米/每秒计
                var accuracy = res.accuracy; // 位置精度



                pano_service = new qq.maps.PanoramaService();
                var point = {lat: latitude, lng: longitude};
                var radius;
                pano_service.getPano(point, radius, function (result){
                    pano.setPano(result.svid);
                });
//                    wx.openLocation({
//                        latitude: latitude, // 纬度，浮点数，范围为90 ~ -90
//                        longitude: longitude, // 经度，浮点数，范围为180 ~ -180。
//                        name: '', // 位置名
//                        address: '', // 地址详情说明
//                        scale: 28, // 地图缩放级别,整形值,范围从1~28。默认为最大
//                        infoUrl: '' // 在查看位置界面底部显示的超链接,可点击跳转
//                    });
            }
        });
        // config信息验证后会执行ready方法，所有接口调用都必须在config接口获得结果之后，config是一个客户端的异步操作，所以如果需要在页面加载时就调用相关接口，则须把相关接口放在ready函数中调用来确保正确执行。对于用户触发时才调用的接口，则可以直接调用，不需要放在ready函数中。
    });

    wx.error(function(res){
        alert('error');
        //console.log(res);
        // config信息验证失败会执行error函数，如签名过期导致验证失败，具体错误信息可以打开config的debug模式查看，也可以在返回的res参数中查看，对于SPA可以在这里更新签名。

    });
    
    
</script>