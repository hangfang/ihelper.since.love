<script type="text/javascript" src="/static/bootstrap/js/bootstrap-select.js"></script>
<link rel="stylesheet" type="text/css" href="/static/bootstrap/css/bootstrap-select.min.css">
<style>
    body { color: #666; font-family: sans-serif; line-height: 1.4; }
    h1 { color: #444; font-size: 1.2em; padding: 14px 2px 12px; margin: 0px; }
    h1 em { font-style: normal; color: #999; }
    a { color: #888; text-decoration: none; }
    #wrapper { width: 400px; margin: 40px auto; }

    #play_list { padding: 0px; margin: 0px; list-style: decimal-leading-zero inside; color: #ccc; border-top: 1px solid #ccc; font-size: 0.9em; }
    #play_list li { position: relative; margin: 0px; padding: 9px 2px 10px; border-bottom: 1px solid #ccc; cursor: pointer; }
    #play_list li a { display: block; text-indent: .3ex; padding: 0px 0px 0px 20px; }
    #play_list li.playing { color: #aaa; text-shadow: 1px 1px 0px rgba(255, 255, 255, 0.3); }
    #play_list li.playing a { color: #000; }
    #play_list li.playing:before{ content: '♬'; width: 14px; height: 14px; padding: 3px; line-height: 14px; margin: 0px; position: absolute; top: 9px; color: #000; font-size: 13px; text-shadow: 1px 1px 0px rgba(0, 0, 0, 0.2); }
    #search_show .add { background-color: blanchedalmond;text-shadow: 1px 1px 0px rgba(0, 0, 0, 0.2); }

    #shortcuts { position: fixed; bottom: 0px; width: 100%; color: #666; font-size: 0.9em; margin: 60px 0px 0px; padding: 20px 20px 15px; background: #f3f3f3; background: rgba(240, 240, 240, 0.7); }
    #shortcuts div { width: 460px; margin: 0px auto; }
    #shortcuts h1 { margin: 0px 0px 6px; }
    #shortcuts p { margin: 0px 0px 18px; }
    #shortcuts em { font-style: normal; background: #d3d3d3; padding: 3px 9px; position: relative; left: -3px;
      -webkit-border-radius: 4px; -moz-border-radius: 4px; -o-border-radius: 4px; border-radius: 4px;
      -webkit-box-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1); -moz-box-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1); -o-box-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1); box-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1); }

    @media screen and (max-device-width: 480px) {
      #wrapper { position: relative; left: -3%; }
      #shortcuts { display: none; }
    }
    
    .audiojs {margin-bottom:15px; width:100% !important;}
    .audiojs .play-pause {padding: 4px 0px;}
    
    .weui_cell_primary p {height: 20px; overflow: hidden;}
    
    .weui_toast_content {overflow : hidden; text-overflow: ellipsis; display: -webkit-box;-webkit-line-clamp: 2;-webkit-box-orient: vertical;}
</style>
<div class="panel">
    <div class="searchbar">
        <div class="hd">
            <h1 class="page_title">在线音乐</h1>
        </div>
        <div class="bd">
            <audio preload="none" class="bd-12"></audio>
            <!--<a href="javascript:;" class="weui_btn weui_btn_primary">点击展现searchBar</a>-->
            <div class="weui_search_bar" id="search_bar">
                <form class="weui_search_outer">
                    <div class="weui_search_inner">
                        <i class="weui_icon_search"></i>
                        <input type="search" class="weui_search_input" id="search_input" placeholder="搜索" required="">
                        <a href="javascript:" class="weui_icon_clear" id="search_clear"></a>
                    </div>
                    <label for="search_input" class="weui_search_text" id="search_text" style="display: none;">
                        <i class="weui_icon_search"></i>
                        <span>搜索</span>
                    </label>
                </form>
                <a href="javascript:" class="weui_search_cancel" id="search_cancel">取消</a>
            </div>
            <div class="weui_cells weui_cells_access search_show" id="search_show" style="display: none;">
            </div>
            <ol id="play_list">
            </ol>
        </div>
    </div>
</div>
<div id="shortcuts">
    <div>
        <h1>Keyboard shortcuts:</h1>
        <p><em>&rarr;</em> Next track</p>
        <p><em>&larr;</em> Previous track</p>
        <p><em>Space</em> Play/pause</p>
    </div>
</div>
<script>
    var music = {};
    music.page = 1;
    music.total_rows = 0;
    music.total_page = 0;
    music.size = 5;
</script>
<script src="/static/audiojs/audio.min.js?d=20160110"></script>
<script src="/static/public/js/app/music.js?d=20160110"></script>