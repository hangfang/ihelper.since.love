$(function(){
    $('#container').on('touchstart', '.container-fluid:last', function(e){
        news.touchstart = event.changedTouches[0].clientY;
    }).on('touchend', '.container-fluid:last', function(e){
        news.touchend = event.changedTouches[0].clientY;
        if(news.touchstart-news.touchend > 100){
            var match = location.search.match(/page=(\d+)/);
            page = match ? match[1]-0+1 :2;
            location.href = '/app/news?page='+page;
            return false;
        }
    });
});