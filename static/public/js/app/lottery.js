$(function(){
    $('#lottery_code').selectpicker({
        'mobile': true
    });
    
    $('#lottery_code').blur(function(e){
        $('#submit_lottery').click();
    });
    
    $('#form_lottery').submit(function(e){

        if($('#lottery_code').val().length === 0){
            $('#lottery_code').parents('.form-group').removeClass('has-success').addClass('has-error').end().next('span').removeClass('glyphicon-ok').addClass('glyphicon-remove').show();
            return false;
        }else{
            $('#lottery_code').parents('.form-group').removeClass('has-error').addClass('has-success').end().next('span').removeClass('glyphicon-remove').addClass('glyphicon-ok').show();
        }
        
        var data = $(this).serialize();
        $('#loadingToast').show();
        $.ajax({
            url : '/app/lottery',
            data : data,
            type : 'get',
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
                
                $('#lottery_result').find('.weui_media_text').html(data.msg).end().show();
                return true;
            }
        });
        
        return false;
    });
});