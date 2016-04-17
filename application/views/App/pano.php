<style>
    #container {height:95%; margin: 0;}
    #top-panel {position: absolute; top: 1.5%; left: 0; width: 100%;}
    #top-panel .weui_cells {background: transparent;}
    #top-panel .weui_input {width: 70%; margin-left:6%; padding-bottom: 2px; background-color: rgb(223, 223, 223);}
    #top-panel .weui_btn {width: 20%;}
    #right-menu {position: absolute;}
    
    .weui_actionsheet_cell {cursor: pointer;}
</style>
</div>
<div id="top-panel">
    <div class="weui_cells">
        <div class="weui_cell_bd weui_cell_primary">
            <input class="weui_input" type="text" placeholder="搜地点、查公交、找线路" maxlength="256">
            <input type="button" value="搜索" class="weui_btn weui_btn_mini weui_btn_primary" id="search">
        </div>
    </div>
    <div class="weui_panel weui_panel_access" style="display:none;">
        <div class="weui_panel_hd">文字组合列表</div>
        <div class="weui_panel_bd">
            <div class="weui_media_box weui_media_text">
                <p class="weui_media_desc">由各种物质组成的巨型球状天体，叫做星球。星球有一定的形状，有自己的运行轨道。</p>
            </div>
        </div>
        <a href="javascript:void(0);" class="weui_panel_ft">查看更多</a>
    </div>
</div>
<script src="http://map.qq.com/api/js?v=2.exp&key=J7CBZ-YV43X-PVS4E-ZGYVP-KF2T3-A3BQZ"></script>
<script src="/static/weui/js/jweixin-1.1.0.js?v=2016-04-07"></script>
<script>
    wx.config({
        debug: <?php echo $debug; ?>, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
        appId: '<?php echo $appid; ?>', // 必填，公众号的唯一标识
        timestamp: <?php echo $timestamp; ?>, // 必填，生成签名的时间戳
        nonceStr: '<?php echo $nonceStr; ?>', // 必填，生成签名的随机串
        signature: '<?php echo $signature; ?>', // 必填，签名，见附录1
        jsApiList: ['chooseImage','startRecord','stopRecord','playVoice','pauseVoice','stopVoice','hideMenuItems','showAllNonBaseMenuItem','hideAllNonBaseMenuItem','showOptionMenu','hideOptionMenu','scanQRCode','closeWindow', 'getNetworkType', 'openLocation', 'getLocation','translateVoice'] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
    });
    
    var txmap = {};
    txmap.latLong = {
                        latitude: 22.5428234337,// 纬度，浮点数，范围为90 ~ -90
                        longitude: 114.0595370000// 经度，浮点数，范围为180 ~ -180。
                    }
    wx.getLocation({
        type: 'wgs84', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
        success: function (res) {
            txmap.latLong = {
                                latitude: res.latitude,// 纬度，浮点数，范围为90 ~ -90
                                longitude: res.longitude// 经度，浮点数，范围为180 ~ -180。
                            }
            txmap.speed = res.speed; // 速度，以米/每秒计
            txmap.accuracy = res.accuracy; // 位置精度
        }
    });
    
    txmap.init = function() {
//        try{
//            wx.getLocation({
//                type: 'wgs84', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
//                success: function (res) {
//                    txmap.latLong = {
//                                        latitude: res.latitude,// 纬度，浮点数，范围为90 ~ -90
//                                        longitude: res.longitude// 经度，浮点数，范围为180 ~ -180。
//                                    }
//                    txmap.speed = res.speed; // 速度，以米/每秒计
//                    txmap.accuracy = res.accuracy; // 位置精度
//
//    /*--start---创建街景--start---*/
//    //                pano = new qq.maps.Panorama(document.getElementById('container'), {
//    //                      pano: '10011501120802180635300',    //场景ID
//    //                      pov:{   //视角
//    //                              heading:1,  //偏航角
//    //                              pitch:0     //俯仰角
//    //                          },
//    //                      zoom:1      //缩放
//    //                  })
//    //                pano_service = new qq.maps.PanoramaService();
//    //                var point = {lat: latitude, lng: longitude};
//    //                var radius;
//    //                pano_service.getPano(point, radius, function (result){
//    //                    pano.setPano(result.svid);
//    //                });
//    /*---end----创建街景---end----*/
//                }
//            });
//        }catch(e){
//            throw 'open in wechat';
//        }

        //var sw = new qq.maps.LatLng(txmap.latLong.latitude-0.03949, txmap.latLong.latitude-0.03949); //西南角坐标
        //var ne = new qq.maps.LatLng(txmap.latLong.latitude+0.03949, txmap.latLong.latitude+0.03949); //东北角坐标
        //var latlngBounds = new qq.maps.LatLngBounds(ne, sw); //矩形的地理坐标范围

        //div容器
        var container = document.getElementById("container");

        //初始化地图
        var map = new qq.maps.Map(container, {
            // 地图的中心地理坐标。
            center: new qq.maps.LatLng(txmap.latLong.latitude, txmap.latLong.longitude),
            zoom: 13
        });

        qq.maps.event.addListener(map, 'click', function(e){
            map.panTo(new qq.maps.LatLng(e.latLng.lat, e.latLng.lng));
        });
        
        qq.maps.event.addListener(map, 'rightclick', function(e){
            $('.weui_actionsheet_cell').data(e);

            var mask = $('#mask');
            var weuiActionsheet = $('#weui_actionsheet');
            weuiActionsheet.addClass('weui_actionsheet_toggle');
            mask.show().addClass('weui_fade_toggle').one('click', function () {
                hideActionSheet(weuiActionsheet, mask);
            });
            $('#actionsheet_cancel').one('click', function () {
                hideActionSheet(weuiActionsheet, mask);
            });
            weuiActionsheet.unbind('transitionend').unbind('webkitTransitionEnd');

            function hideActionSheet(weuiActionsheet, mask) {
                weuiActionsheet.removeClass('weui_actionsheet_toggle');
                mask.removeClass('weui_fade_toggle');
                weuiActionsheet.on('transitionend', function () {
                    mask.hide();
                }).on('webkitTransitionEnd', function () {
                    mask.hide();
                })
            }
        });
        
        //根据指定的范围调整地图视野。
        //map.fitBounds(latlngBounds);
        qq.maps.event.addListener(map, 'bounds_changed', function () {
            //console.log("地图的可视范围为：" + map.getBounds());
        });


        qq.maps.event.addListener(map, 'center_changed', function () {
            //console.log("地图中心为：" + map.getCenter());
        });


        //当地图缩放级别更改时会触发此事件。
        qq.maps.event.addListener(map, 'zoom_changed', function () {
            //console.log("地图缩放级别为：" + map.getZoom());
        });

        qq.maps.event.addListener(map, 'maptypeid_changed', function () {
            //console.log("地图类型ID为：" + map.getMapTypeId());
        });
        
        $('body').on('click', '.weui_actionsheet_cell:eq(0)', function(e){
            /*--start---创建街景--start---*/
            var latLng = $(this).data().latLng
            pano_service = new qq.maps.PanoramaService();
            var point = {lat: latLng.lat, lng: latLng.lng};
            var radius;
            pano_service.getPano(point, radius, function (result){
                pano = new qq.maps.Panorama(document.getElementById('container'), {
                    //pano: '10011501120802180635300',    //场景ID
                    pov:{   //视角
                            heading:1,  //偏航角
                            pitch:0     //俯仰角
                        },
                    zoom:1      //缩放
                })
                pano.setPano(result.svid);
            });
            
            $('#mask').click();
            /*---end----创建街景---end----*/
        });
        
        $('body').on('click', '.weui_actionsheet_cell:eq(1)', function(e){
            $('#loadingToast').find('.weui_toast_content').html('敬请期待').end().show();
        });
        
        $('body').on('click', '.weui_actionsheet_cell:eq(2)', function(e){
            $('#loadingToast').find('.weui_toast_content').html('敬请期待').end().show();
        });
        
        $('body').on('click', '.weui_actionsheet_cell:eq(3)', function(e){
            $('#loadingToast').find('.weui_toast_content').html('敬请期待').end().show();
        });

//        var times = 0;
//        var oInterval = setInterval(function () {
//
//            //panBy()将地图中心移动一段指定的距离（以像素为单位）。
//            map.panBy(-100, 100);
//
//            //zoomBy()将地图缩放到指定的缩放比例（每次所增加的数值）。
//            map.zoomBy(5);
//            times++;
//            if (times >= 1) {
//                clearInterval(oInterval)
//            }
//        }, 3 * 1000);
//
//
//        setTimeout(function () {
//
//            //panTo()将地图中心移动到指定的经纬度坐标。
//            map.panTo(new qq.maps.LatLng(39.9, 116.4));
//
//            //zoomTo()将地图缩放到指定的级别。
//            map.zoomTo(15);
//
//        }, 8 * 1000);
//
//
//        setTimeout(function () {
//            //setCenter()设置地图中心点坐标。
//            map.setCenter(new qq.maps.LatLng(30, 117));
//
//            //setZoom()设置地图缩放级别。
//            map.setZoom(6);
//
//            //setMapTypeId()设置地图类型。
//            map.setMapTypeId(qq.maps.MapTypeId.HYBRID);
//
//        }, 15 * 1000);
//
//
//        setTimeout(function () {
//
//            //设置地图参数。
//            map.setOptions({
//                keyboardShortcuts: false,
//                scrollwheel: false
//            });
//
//        }, 30 * 1000);
    };
    
    txmap.init();
</script>