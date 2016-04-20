$(function(){
    $('#container').on('touchstart', '.container-fluid', function(e){
        event.stopPropagation();
        news.touchstart = event.changedTouches[0].clientY;
    }).on('touchend', '.container-fluid:last', function(e){
        event.stopPropagation();
        news.touchend = event.changedTouches[0].clientY;
        if(news.touchstart-news.touchend > 100){
            var match = location.search.match(/page=(\d+)/);
            page = match ? match[1]-0+1 :2;
            location.href = '/app/news?page='+page;
            return false;
        }
    }).on('touchend', '.container-fluid:first', function(e){
        event.stopPropagation();
        news.touchend = event.changedTouches[0].clientY;
        if(news.touchstart-news.touchend < -100){
            var match = location.search.match(/page=(\d+)/);
            page = match ? match[1]-0-1 :1;
            if(page == 0){
                $('#dialog2').find('.weui_dialog_bd').html('已是第一页！').end().show();
                $('#dialog2').one('click', '.weui_btn_dialog', function(e){
                    $('#dialog2').hide();
                })
                
                setTimeout(function(){
                    $('#dialog2').hide();
                }, 1000);
                return false;
            }
            
            location.href = '/app/news?page='+page;
            return false;
        }
    });
});