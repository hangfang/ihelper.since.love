function initCity(res){
    
    bdmap.local = new BMap.LocalSearch(bdmap, {
        renderOptions:{map: bdmap, panel: 'search-panel'}
    });
    bdmap.local.enableAutoViewport();
    bdmap.local.setPageCapacity(5);
    bdmap.local.setLocation(res.name);
    bdmap.local.setResultsHtmlSetCallback(searchHtmlComplete);
    bdmap.local.setInfoHtmlSetCallback(searchInfoComplete);
    bdmap.setCenter(res.name);
    bdmap.city = res;
}

function searchHtmlComplete(panel){
    var div = $(panel).find('div');
    div.find('li a').remove();
    div.eq(div.length-2).find('a:first').remove();
}

function searchInfoComplete(poi){
    $('#search-panel').hide();
    $('.BMap_bubble_title a').remove();  
}


var bdmap = new BMap.Map("container");
bdmap.init = function(){
    bdmap.point = new BMap.Point( '114.0595370000', '22.5428234337');
    bdmap.centerAndZoom(bdmap.point, 14);
    bdmap.enableScrollWheelZoom();
    bdmap.enableInertialDragging();

    bdmap.enableContinuousZoom();

    bdmap.addControl(new BMap.CityListControl({
        anchor: BMAP_ANCHOR_TOP_LEFT,
        offset: new BMap.Size(10, 20),
        // 切换城市之间事件
        // onChangeBefore: function(){
        //    alert('before');
        // },
        // 切换城市之后事件
        // onChangeAfter:function(){
        //   alert('after');
        // }
    }));

    bdmap.navigationControl = new BMap.NavigationControl({
        // 靠左上角位置
        anchor: BMAP_ANCHOR_BOTTOM_LEFT,
        // LARGE类型
        type: BMAP_NAVIGATION_CONTROL_LARGE,
        // 启用显示定位
        enableGeolocation: true
        });
    bdmap.addControl(bdmap.navigationControl);
    // 添加定位控件

    bdmap.geolocationControl = new BMap.GeolocationControl({
        anchor: BMAP_ANCHOR_BOTTOM_RIGHT,
        enableAutoLocation: true, 
        offset: new BMap.Size(0, 0),
        localIcon:new BMap.Icon("position.png",new BMap.Size(74,74))
    });

    bdmap.geolocationControl.addEventListener("locationSuccess", function(point, AddressComponent){
        // 定位成功事件
    });
    bdmap.geolocationControl.addEventListener("locationError",function(e){
        $('#loadingToast').find('.weui_toast_content').html('定位失败').end().show();
        setTimeout(function(){
            $('#loadingToast').hide();
        }, 1000);
    });
    bdmap.addControl(bdmap.geolocationControl);


    // 覆盖区域图层测试
    //bdmap.addTileLayer(new BMap.PanoramaCoverageLayer());

    bdmap.panoramaControl = new BMap.PanoramaControl({
        anchor: BMAP_ANCHOR_TOP_RIGHT,
        indoorSceneSwitchControl: true,//配置全景室内景切换控件显示
        offset: new BMap.Size(20, 20),
        albumsControlOptions: {
            anchor: BMAP_ANCHOR_TOP_RIGHT,
            offset: new BMap.Size(100, 15),
            maxWidth: '60%',
            imageHeight: 80
        },

    }); //构造全景控件
    bdmap.addControl(bdmap.panoramaControl);//添加全景控件

    bdmap.addMarker = function(point, index){  // 创建图标对象   
        var myIcon = new BMap.Icon("markers.png", new BMap.Size(23, 25), {    
            // 指定定位位置。   
            // 当标注显示在地图上时，其所指向的地理位置距离图标左上    
            // 角各偏移10像素和25像素。您可以看到在本例中该位置即是     
           // 图标中央下端的尖角位置。    
           offset: new BMap.Size(10, 25),    
           // 设置图片偏移。   
           // 当您需要从一幅较大的图片中截取某部分作为标注图标时，您   
           // 需要指定大图的偏移位置，此做法与css sprites技术类似。    
           imageOffset: new BMap.Size(0, 0 - index * 25)   // 设置图片偏移    
        });      
        // 创建标注对象并添加到地图   
        var marker = new BMap.Marker(point, {icon: myIcon});
        marker.setAnimation(BMAP_ANIMATION_BOUNCE);
        bdmap.addOverlay(marker);    
    };
    
    bdmap.addEventListener('click', function(e){
        bdmap.clearOverlays();
        var searchInfoWindow = null;
	searchInfoWindow = new BMapLib.SearchInfoWindow(bdmap, 'test', {
            title  : "百度大厦",      //标题
            width  : 290,             //宽度
            height : 105,              //高度
            panel  : "panel",         //检索结果面板
            enableAutoPan : true,     //自动平移
            searchTypes   :[
                    BMAPLIB_TAB_SEARCH,   //周边检索
                    BMAPLIB_TAB_TO_HERE,  //到这里去
                    BMAPLIB_TAB_FROM_HERE //从这里出发
            ]
            });
        var marker = new BMap.Marker(e.point); //创建marker对象
        marker.enableDragging(); //marker可拖拽
        searchInfoWindow.open(marker);
        bdmap.addOverlay(marker); //在地图中添加marker
        bdmap.centerAndZoom(e.point, 14);
    });
 };
 
$(function(){
    bdmap.init();
    bdmap.localCity = new BMap.LocalCity();      
    bdmap.localCity.get(initCity);
    
    $('body').on('input', '#keyword', function(e){
        bdmap.clearOverlays();
//        var circle = new BMap.Circle(bdmap.latLng,10000,{fillColor:"blue", strokeWeight: 1 ,fillOpacity: 0.3, strokeOpacity: 0.3});
//        bdmap.addOverlay(circle);
//        
//	bdmap.local.searchNearby($('#keyword').val(), bdmap.latLng, 10000); 
        //bdmap.local.search($('#keyword').val());
        
        bdmap.local.searchInBounds($('#keyword').val().split(' '), bdmap.getBounds());
    }).on('focus', '#keyword', function(e){
        $('#search-panel').show();
    });

    bdmap.intervalId = setInterval(function(){
        if($('.anchorBL a').length > 0){
            $('.anchorBL a').remove();
            clearInterval(bdmap.intervalId);
        }
    }, 20);
    
    setTimeout(function(){
        $('.BMap_geolocationIcon').click();
    }, 500);
    
    setInterval(function(){
        $('.BMap_geolocationIcon').click();
    }, 60000);
});