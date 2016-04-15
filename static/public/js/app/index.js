$(function () {

    var router = new Router({
        container: '#container',
        enterTimeout: 250,
        leaveTimeout: 250
    });
    
    var home = {
        url: '/',
        className: 'home',
        render: function () {
            return $('#tpl_home').html();
        }
    };
    
    // express
    var express = {
        url: '/express',
        className: 'express',
        render: function () {
            if(typeof $('#com').selectpicker === 'undefined'){
                $.getScript("/static/bootstrap/js/bootstrap-select.js?d=20160411", function(){

                    $('#com').selectpicker({
                        'mobile': true
                    });
                    $('head').append('<link rel="stylesheet" href="/static/bootstrap/css/bootstrap-select.min.css"/>');

                });
            }
            return $('#tpl_express').html();
        },
        bind: function(){
            /*---start-快递查询-start---*/
            $('#container').on('blur', '#nu', function(e){
                $('#submit_express').click();
            });

            $('#container').on('submit', '#form_express', function(e){

                if($('#com').val().length === 0){
                    $('#com').parents('.form-group').removeClass('has-success').addClass('has-error').end().next('span').removeClass('glyphicon-ok').addClass('glyphicon-remove').show();
                    return false;
                }else{
                    $('#com').parents('.form-group').removeClass('has-error').addClass('has-success').end().next('span').removeClass('glyphicon-remove').addClass('glyphicon-ok').show();
                }

                if($('#nu').val().length === 0){
                    $('#nu').parents('.form-group').removeClass('has-success').addClass('has-error').end().next('span').removeClass('glyphicon-ok').addClass('glyphicon-remove').show();
                    return false;
                }else{
                    $('#nu').parents('.form-group').removeClass('has-error').addClass('has-success').end().next('span').removeClass('glyphicon-remove').addClass('glyphicon-ok').show();
                }

                var data = $(this).serialize();
                $('#loadingToast').show();
                $.ajax({
                    url : '/app/express',
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

                        $('#express_result').find('.weui_media_text').html(data.msg).end().show();
                        return true;
                    }
                });

                return false;
            });
            /*---end--快递查询--end---*/
        }
    };

    // weather
    var weather = {
        url: '/weather',
        className: 'weather',
        render: function () {
            if(typeof $('#cityid').selectpicker === 'undefined'){
                $.getScript("/static/bootstrap/js/bootstrap-select.js?d=20160411", function(){

                    $('#cityid').selectpicker({
                        'mobile': true
                    });
                    $('head').append('<link rel="stylesheet" href="/static/bootstrap/css/bootstrap-select.min.css"/>');

                });
            }
            return $('#tpl_weather').html();
        },
        bind: function(){
            /*---start-天气查询-start---*/
            $('#container').on('submit', '#form_weather', function(e){

                if($('#cityid').val().length === 0){
                    $('#cityid').parents('.form-group').removeClass('has-success').addClass('has-error').end().next('span').removeClass('glyphicon-ok').addClass('glyphicon-remove').show();
                    return false;
                }else{
                    $('#cityid').parents('.form-group').removeClass('has-error').addClass('has-success').end().next('span').removeClass('glyphicon-remove').addClass('glyphicon-ok').show();
                }

                var data = $(this).serialize();
                $('#loadingToast').show();
                $.ajax({
                    url : '/app/weather',
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

                        $('#weather_result').find('.weui_media_text').html(data.msg).end().show();
                        return true;
                    }
                });

                return false;
            });
            /*---end--天气查询--end---*/
        }
    };

    // stock
    var stock = {
        url: '/stock',
        className: 'stock',
        render: function () {
            return $('#tpl_stock').html();
        },
        bind: function(){
            /*---start-股票查询-start---*/
            $('#container').on('blur', '#stockid', function(e){
                $('#submit_stock').click();
            });

            $('#container').on('submit', '#form_stock', function(e){

                if($('#stockid').val().length === 0){
                    $('#stockid').parents('.form-group').removeClass('has-success').addClass('has-error').end().next('span').removeClass('glyphicon-ok').addClass('glyphicon-remove').show();
                    return false;
                }else{
                    $('#stockid').parents('.form-group').removeClass('has-error').addClass('has-success').end().next('span').removeClass('glyphicon-remove').addClass('glyphicon-ok').show();
                }

                var data = $(this).serialize();
                $('#loadingToast').show();
                $.ajax({
                    url : '/app/stock',
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

                        $('#stock_result').find('.weui_media_text').html(data.msg).end().show();
                        return true;
                    }
                });

                return false;
            });
            /*---end--股票查询--end---*/
        }
    };

    // music
    var music = {
        page: 1,
        size: 5,
        url: '/music',
        className: 'music',
        render: function () {
            return $('#tpl_music').html();
        },
        bind: function () {
            /*---start-在线音乐-start---*/
            
            if(typeof audiojs === 'undefined'){
                $('body').append('<script src="/static/audiojs/audio.min.js?d=20160411"></script>');
            }
            
            music.audio = audiojs.createAll({
                trackEnded: function() {
                    if($('#play_list li').length===0){
                        music.audio.stop();
                    }
                    var next = $('#play_list li.playing').next();
                    if (!next.length){
                        next = $('#play_list li:first-child');
                    }
                    next.addClass('playing').siblings().removeClass('playing');
                    music.audio.load($('a', next).attr('data-src'));
                    music.audio.play();               
                }
            }).pop();
            
            $('#container').on('focus', '#search_input', function (e) {
                $('#search_show').show();
                var $weuiSearchBar = $('#search_bar');
                $weuiSearchBar.addClass('weui_search_focusing');
            }).on('blur', '#search_input', function (e) {
                var $weuiSearchBar = $('#search_bar');
                $weuiSearchBar.removeClass('weui_search_focusing');
                if ($(this).val()) {
                    $('#search_text').hide();
                } else {
                    $('#search_text').show();
                }
            }).on('input', '#search_input', function (e) {

                var name = $('#search_input').val();
                var $searchShow = $("#search_show");
                if (name.length>0) {
                    var data = {name: name, page: music.page, size: music.size};
                    music.getMusic(data);
                } else {
                    $searchShow.hide();
                }
            }).on('click touchend', '#search_cancel', function (e) {
                $("#search_show").hide();
                $('#search_input').val('');
            }).on('click touchend', '#search_clear', function (e) {
                $("#search_show").hide();
                $('#search_input').val('');
            }).on('click touched', '.weui_cell', function(e){
                var _this = this;
                $(this).addClass('add').siblings().removeClass('add');
                var filename = $(this).attr('filename');
                var hash = $(this).attr('hash');

                $('#loadingToast').show();
                var data = {hash: hash};
                $.ajax({
                    url: '/app/getMusicPlayInfo',
                    data: data,
                    dataType: 'json',
                    type: 'get',
                    success: function(data, textStatus, xhr){
                        $('#loadingToast').hide();
                        if(data.rtn > 0){
                            $('#toast').find('.weui_toast_content').html(data.errmsg).end().show();
                            setTimeout(function(){;
                                $('#toast').hide();
                            }, 2000);
                            return false;
                        }

                        var li = $('<li><a href="#" data-src="'+data.msg.url+'">'+filename+'</a></li>');
                        li.appendTo($('#play_list'));

                        $('#toast').find('.weui_toast_content').html(filename).end().show();
                        setTimeout(function(){;
                            $('#toast').hide();
                        }, 2000);

                        if($('#play_list li').length === 1){
                            li.click();
                        }
                    }
                });
            }).on('touchstart', '#search_show', function(e){
                music.touchstart = event.changedTouches[0].clientY;
            }).on('touchend', '#search_show', function(e){
                music.touchend = event.changedTouches[0].clientY;
                if(music.total_page < music.page){
                    $('#toast').find('.weui_toast_content').html('已加载完毕...').end().show();
                    setTimeout(function(){;
                        $('#toast').hide();
                    }, 2000);
                    return false;
                }

                if(music.touchstart-music.touchend > 200){
                    var data = {name: $('#search_input').val(), page: music.page, size: music.size};
                    music.getMusic(data);
                }
            }).on('click', function(e){
                if($(e.target).parents('#search_show').length == 0 && $(e.target).parents('#search_bar').length ===0){
                    $('#search_show').hide();
                }
            });

            

            // Load in the first track
            if($('#play_list li').length > 0){
                music.audio.load($('#play_list li:first-child').addClass('playing').find('a').attr('data-src'));
                music.audio.play();
            }

            // Load in a track on click
            $('#play_list').on('touchend click', function(e) {
                if($('#play_list li').length === 0){
                    return false;
                }
                if(music.delay > 0){
                    $('#toast').find('.weui_toast_content').html('心好累，请勿操作太快。').end().show();
                    setTimeout(function(){;
                        $('#toast').hide();
                    }, 2000);
                    return false;
                }

                music.delay = 5;
                music.intervalId = setInterval(function(){
                    music.delay--;
                    if(music.delay===0){
                        clearInterval(music.intervalId);
                    }
                });

                e.preventDefault();
                if(e.target.nodeName.toLowerCase()==='li'){
                    $(e.target).addClass('playing').siblings().removeClass('playing');
                    music.audio.load($(e.target).find('a').attr('data-src'));
                    music.audio.play();
                    return true;
                }
                $(e.target).parents('li').addClass('playing').siblings().removeClass('playing');
                music.audio.load($(e.target).attr('data-src'));
                music.audio.play();
            });
            // Keyboard shortcuts
            $(document).keydown(function(e) {
                var unicode = e.charCode ? e.charCode : e.keyCode;
                // right arrow
                if (unicode == 39) {
                    var next = $('#play_list li.playing').next();
                    if (!next.length) next = $('#play_list li:first-child');
                    next.click();
                    // back arrow
                } else if (unicode == 37) {
                    var prev = $('#play_list li.playing').prev();
                    if (!prev.length) prev = $('#play_list li:last-child');
                    prev.click();
                    // spacebar
                } else if (unicode == 32) {
                    music.audio.playPause();
                }
            })

            music.getMusic = function(data){
                if(music.xhr){
                    music.xhr.abort();
                    $('#loadingToast').hide();
                }
                $('#loadingToast').show();
                music.xhr = $.ajax({
                    url: '/app/music',
                    data: data,
                    dataType: 'json',
                    type: 'get',
                    success : function(data, textStatus, xhr){
                        $('#loadingToast').hide();
                        if(data.rtn > 0){
                            $('#toast').find('.weui_toast_content').html(data.errmsg).end().show();
                            setTimeout(function(){;
                                $('#toast').hide();
                            }, 2000);
                            return false;
                        }

                        var tmp = data.msg;
                        music.page = tmp.current_page-0+1;
                        music.total_rows = tmp.total_rows;
                        music.total_page = tmp.total_page;

                        var html = '';
                        tmp = data.msg.data;
                        for(var i in tmp){
                            html += '<div class="weui_cell" hash="'+tmp[i]['hash']+'" filename="'+tmp[i]['filename']+'"><div class="weui_cell_bd weui_cell_primary"><p>'+tmp[i]['filename']+'</p><p>时长:'+tmp[i]['duration']+'秒\t格式:'+tmp[i]['extname']+'\t码率:'+tmp[i]['bitrate']+'\t尺寸:'+new Number(tmp[i]['filesize']/1024/1024).toFixed(0)+'M</p></div></div>';
                        }

                        $('#search_show').html(html).show();
                        return true;
                    }
                });
            };
            /*---end--在线音乐--end---*/
        }
    };
    
    // lottery
    var lottery = {
        url: '/lottery',
        className: 'lottery',
        render: function () {
            if(typeof $('#lottery_code').selectpicker === 'undefined'){
                $.getScript("/static/bootstrap/js/bootstrap-select.js?d=20160411", function(){

                    $('#lottery_code').selectpicker({
                        'mobile': true
                    });
                    $('head').append('<link rel="stylesheet" href="/static/bootstrap/css/bootstrap-select.min.css"/>');

                });
            }
            return $('#tpl_lottery').html();
        },
        bind: function(){
            /*---start-股票查询-start---*/
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
            /*---end--股票查询--end---*/
        }
    };
    
    router.push(home)
        .push(express)
        .push(weather)
        .push(stock)
        .push(music)
        //.push(lottery)
        .setDefault('/')
        .init();


    // .container 设置了 overflow 属性, 导致 Android 手机下输入框获取焦点时, 输入法挡住输入框的 bug
    // 相关 issue: https://github.com/weui/weui/issues/15
    // 解决方法:
    // 0. .container 去掉 overflow 属性, 但此 demo 下会引发别的问题
    // 1. 参考 http://stackoverflow.com/questions/23757345/android-does-not-correctly-scroll-on-input-focus-if-not-body-element
    //    Android 手机下, input 或 textarea 元素聚焦时, 主动滚一把
    if (/Android/gi.test(navigator.userAgent)) {
        window.addEventListener('resize', function () {
            if (document.activeElement.tagName == 'INPUT' || document.activeElement.tagName == 'TEXTAREA') {
                window.setTimeout(function () {
                    document.activeElement.scrollIntoViewIfNeeded();
                }, 0);
            }
        })
    }
    
    $('#contact').click(function(e){
        $('#container').hide();
        $('#msg').show();
    });
});