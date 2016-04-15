$(function(){
    $('#lottery_type').on('change', function(e){
        $('#loadingToast').show();
        $.ajax({
            url : '/app/lottery',
            data : {lottery_code: $('#lottery_type').val()},
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
                
                $('.weui_panel_hd').find('.text-danger').text('old').removeClass('text-danger');
                var html = $('<div class="weui_panel" id="lottery_result" style=""><div class="weui_panel_hd">查询结果(<span class="text-danger">new</span>)</div><div class="weui_panel_bd"><div class="weui_media_box weui_media_text">'+data.msg+'</div></div></div>');
                $('form:last').after(html);
                return true;
            }
        });
        
        $('#form_check .weui_cell_primary').hide();
        $('#'+$(this).val()).show();
        $('#'+$(this).val()).find('input:first').focus();
    });
    
    $('#form_check').on('input', '#ssq input', function(e){
        var val = $(this).val();
        var rule = /[^\d]+/ig;
        var isLast = $(this).next().length==0;
        var max = isLast ? 16 : 33;
        if(val-0>max || rule.test(val)){
            $(this).val('');
            return false;
        }
        
        if(val.length===2){
            if(isLast){
                $('#form_check').find('input[type=submit]').click();
                return true;
            }
            $(this).next().focus();
        }
        
    }).on('blur', '#ssq input', function(e){
        var val = $(this).val();
        var _this = this;
        var dumplicate = false;
        $(this).siblings().each(function(index, el){
            if($(_this).attr('name')!=='g' && $(el).val().length>0 && $(el).val()===val){
                dumplicate = true;
                return false;
            }
        });

        if(dumplicate){
            $(this).val('').focus();
            return false;
        }
        
    });
    
    $('#form_check').on('input', '#pl3 input, #pl5 input, #qxc input, #fc3d input', function(e){
        var val = $(this).val();
        var rule = /[^\d]+/ig;
        var isLast = $(this).next().length==0;

        if(val-0>9 || rule.test(val)){
            $(this).val('');
            return false;
        }
        
        if(val.length===1){
            if(isLast){
                $('#form_check').find('input[type=submit]').click();
                return true;
            }
            $(this).next().focus();
        }
        
    });
    
    $('#form_check').on('submit', function(e){
        var lottery_type = $('#lottery_type').val();
        var data = {lottery_type: lottery_type};
        var isCompleted = true;
        $('#'+lottery_type).find('input').each(function(index, el){
            if($(el).val().length==0){
                $(el).focus();
                isCompleted = false;
                return false;
            }
            data[$(el).attr('name')] = $(el).val();
        });
        
        if(isCompleted===false){
            return false;
        }

        $('#loadingToast').show();
        $.ajax({
            url : '/app/checkLottery',
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
                
                $('.weui_panel_hd').find('.text-danger').text('old').removeClass('text-danger');
                var html = $('<div class="weui_panel" style=""><div class="weui_panel_hd">查询结果(<span class="text-danger">new</span>)</div><div class="weui_panel_bd"><div class="weui_media_box weui_media_text">'+data.msg+'</div></div></div>');
                $('form:last').after(html);
                return true;
            }
        });
        
        return false;
    });
});