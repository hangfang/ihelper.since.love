<div class="navbar">
    <div class="bd" style="height: 100%;">
        <div class="weui_tab">
            <div class="weui_navbar">
                <a class="weui_navbar_item" href="/app/news">
                    资讯
                </a>
                <a class="weui_navbar_item" href="/app/girls">
                    美图
                </a>
                <a class="weui_navbar_item weui_bar_item_on" href="/app/hots">
                    热搜
                </a>
            </div>
            <div class="weui_tab_bd">

            </div>
        </div>
    </div>
</div>
<style>
    body {background-color: rgb(235,235,235);}
    #container {margin-bottom: 65px;}
    .banner {position:absolute; bottom:0; color:#fff; width:100%; background:rgba(0,0,0,.7);}
    .txt {display:table-cell; vertical-align:middle; height:40px;}
    .no-new-line {overflow: hidden;white-space: nowrap;text-overflow: ellipsis;}
    .img {height:40px;}
    .font16 {font-size:16px;}
    .bg-wrapper {position:relative;}
    #container .container-fluid:nth-child(3) {margin-top:55px;}
    #container .container-fluid:nth-child(7) {margin-bottom:47px;}
    .container-fluid {margin-top:9px; padding: 0 5px; border-radius: 5px;}
    .list-group {margin-bottom: 0px;}
    .list-group-item{border-color: rgb(197,197,197); padding-top:2px; padding-bottom:2px;}
    .list-group-item a {display:block; color: #000;}
    .img-responsive {width:403px; height:268px;}
    .pull-right {width:43px; height:43px;}
    
    .navbar {position: fixed;top: -1px;display: block;width: 100%; z-index:1;}
    .navbar a { color:#888; text-decoration: none;}
    .weui_navbar_item {padding:10px 0 !important;}
    
    .weui_cell_ft {position: fixed; bottom: 48px; right: 5px;}
    .weui_cells_form {position: fixed; bottom: 48px; left:-999px; width: 81%; border: 1px solid rgb(197,197,197);}
    
</style>
<?php echo $msg;?>
<div class="weui_cell_ft">
    <input class="weui_switch" type="checkbox" id="switch">
</div>
<div class="weui_cells weui_cells_form" id="search" style="display: none;">
    <div class="weui_cell">
<!--        <div class="weui_cell_hd">
            <label class="weui_label">QQ</label>
        </div>-->
        <div class="weui_cell_bd weui_cell_primary">
            <input class="weui_input" type="text" maxlength=10 placeholder="热搜关键字">
        </div>
    </div>
</div>
<script src="/static/public/js/app/news.js?d=20160110"></script>