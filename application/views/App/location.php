<div class="container">

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">测试按钮</h3>
        </div>
        <div class="panel-body">
            <ul class='list-inline'>
                <li><a href="javascript:void(0)" class='btn btn-primary' id='select_pic'>选图</a></li>
                <li><a href="javascript:void(0)" class='btn btn-primary' id='start_record'>开始录音</a></li>
                <li><a href="javascript:void(0)" class='btn btn-primary' id='stop_record'>停止录音</a></li>
                <li><a href="javascript:void(0)" class='btn btn-primary' id='play_voice'>播放录音</a></li>
                <li><a href="javascript:void(0)" class='btn btn-primary' id='pause_voice'>暂停播放</a></li>
                <li><a href="javascript:void(0)" class='btn btn-primary' id='stop_voice'>停止播放</a></li>
            </ul>
        </div>
    </div>
    
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">友情链接</h3>
        </div>
        <div class="panel-body">
            <ul class='list-inline'>
                <li><a href="//m.kuaidi100.com" target="_blank">快递查询</a></li>
            </ul>
        </div>
    </div>
</div>
<script src="/static/weui/js/jweixin-1.1.0.js?v=2016-04-07"></script>
<script>
    wx.config({
        debug: <?php echo $debug; ?>, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
        appId: '<?php echo $appid; ?>', // 必填，公众号的唯一标识
        timestamp: <?php echo $timestamp; ?>, // 必填，生成签名的时间戳
        nonceStr: '<?php echo $nonceStr; ?>', // 必填，生成签名的随机串
        signature: '<?php echo $signature; ?>', // 必填，签名，见附录1
        jsApiList: ['chooseImage','startRecord','stopRecord','playVoice','pauseVoice','stopVoice'] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
    });


    wx.ready(function () {

        $('#select_pic').click(function(e){
            wx.chooseImage({
                 count: 1, // 默认9
                 sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
                 sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
                 success: function (res) {
                     var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
                     $('<img src="'+localIds+'"/>').appendTo($('body'));
                 }
             });
        });
        
        $('#start_record').click(function(e){
            wx.startRecord();
        });
        
        $('#stop_record').click(function(e){
            wx.stopRecord({
                success: function (res) {
                    wx.localId = res.localId;
                    alert(wx.localId+'停止录音');
                }
            });
        });
        
        wx.onVoiceRecordEnd({
            // 录音时间超过一分钟没有停止的时候会执行 complete 回调
            complete: function (res) {
                wx.localId = res.localId; 
                alert(wx.localId+'因超时，录音自动完毕');
            }
        });
        
        $('#play_voice').click(function(e){
            wx.playVoice({localId: wx.localId});
        });
        
        $('#pause_voice').click(function(e){
            wx.pauseVoice({localId: wx.localId});
        });
        
        $('#stop_voice').click(function(e){
            wx.stopVoice({localId: wx.localId});
        });
        
        wx.onVoicePlayEnd({
            success: function (res) {
                wx.localId = res.localId; // 返回音频的本地ID
                alert(wx.localId+'播放完毕');
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