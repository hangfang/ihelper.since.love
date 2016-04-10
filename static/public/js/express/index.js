$(function(){
    $('form').submit(function(e){

        if($('#com').val().length === 0){
            $('#com').parents('.form-group').removeClass('has-success').addClass('has-error').end().next('span').removeClass('glyphicon-ok hide').addClass('glyphicon-remove');
            return false;
        }else{
            $('#com').parents('.form-group').removeClass('has-error').addClass('has-success').end().next('span').removeClass('glyphicon-remove hide').addClass('glyphicon-ok');
        }
        
        if($('#nu').val().length === 0){
            $('#nu').parents('.form-group').removeClass('has-success').addClass('has-error').end().next('span').removeClass('glyphicon-ok hide').addClass('glyphicon-remove');
            return false;
        }else{
            $('#nu').parents('.form-group').removeClass('has-error').addClass('has-success').end().next('span').removeClass('glyphicon-remove hide').addClass('glyphicon-ok');
        }
        
        var data = $(this).serialize();
        $('#loadingToast').show();
        $.ajax({
            url : '/express/index',
            data : data,
            type : 'post',
            dataType : 'json',
            success : function(data, textStatus, xhr){
                $('#loadingToast').hide();
                if(data.rtn > 0){
                    $('#toast').find('.weui_toast_content').html(data.errmsg).end().show();
                    setTimeout(function(){;
                        $('#toast').hide();
                    }, 2000);
                    return false;
                }
                
                
            }
        });
        
        return false;
    });
});