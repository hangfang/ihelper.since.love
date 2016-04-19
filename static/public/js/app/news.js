$(function(){
    $('#container').on('touchstart', '.container-fluid:last', function(e){
        news.touchstart = event.changedTouches[0].clientY;
    }).on('touchend', '.container-fluid:last', function(e){
        news.touchsend = event.changedTouches[0].clientY;
        var match = location.search.match(/page=(\d+)/);
        page = match ? match[1]-0+1 : 1;
        location.href = '/app/news?page='+page;
        return false;
    });
});