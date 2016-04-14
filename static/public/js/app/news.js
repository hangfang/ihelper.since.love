$(function(){
    $('#container').on('touchstart', '.container-fluid:last', function(e){
        e.stopPropagation();
        news.touchstart = event.changedTouches[0].clientY;
    }).on('touchend', '.container-fluid:last', function(e){
        e.stopPropagation();
        news.touchsend = event.changedTouches[0].clientY;
        if(news.touchstart-news.touchsend > 200){
            var data = {page: news.page};
            $('#loadingToast').show();
            $.ajax({
                url : '/app/news',
                data : data,
                type : 'get',
                dataType : 'json',
                success : function(data, textStatus, xhr){
                    $('#loadingToast').hide();
                    news.page++;
                    $('#container').append(data.msg);
                    return true;
                }
            });
        }
        return false;
    });
});