<style>
    body {background-color: #efeff4; font-size:14px;}
    .weui_panel_hd {text-align: center;}
    .panel1 .weui_panel_bd {background:url(/static/public/img/user/bg.png) no-repeat; height: 115px}
    .head-img {position: absolute; top: 1.65rem; left: 4.62rem; width: 75px; height: 75px; border-radius: 39px; background-color: #fff;}
    .head-dsb {position: absolute; top: 2.85rem; left: 12.78rem;}
    .head-dsb p { font-size: 0.28rem;color: #fff;}
    .dsb-id { margin-top: 0.08rem;}
    
    .panel2 {width: 100%; height: 12%; margin-top: 0.26rem; background-color: #fff;}
    .panel2 ul {list-style: none;}
    .panel2 ul li { position: relative; float: left; width: 30%; height: 28px; font-size: 14px; text-align: center; margin-left: 10px;}
    .idt {display: block; position: absolute; left: 0.68rem; float: left; width: 20px; height: 18px; background: url(/static/public/img/user/indent.png) no-repeat; background-size: 20px 18px;}
    .clt {display: block; position: absolute; left: 0.68rem; float: left; width: 20px; height: 18px; background: url(/static/public/img/user/clt.png) no-repeat; background-size: 20px 18px;}
    .rcm {display: block; position: absolute; left: 0.68rem; float: left; width: 20px; height: 18px; background: url(/static/public/img/user/rcm.png) no-repeat; background-size: 20px 18px;}
    
    .panel3, .panel4, .panel5 {padding: 0px;}
    .panel3 .bd, .panel4 .bd, .panel5 .bd {width: 100%;}
    .panel3 .weui_cell, .panel4 .weui_cell, .panel5 .weui_cell {text-decoration: none;}
    .panel3 .weui_cell_bd p, .panel4 .weui_cell_bd p, .panel5 .weui_cell_bd p {margin: 0px; font-size: 0.24rem; color: #838383;}
    
    .panel4 .weui_switch { height: 22px;}
    .panel4 .weui_switch:before { height: 20px;}
    .panel4 .weui_switch:after { height: 20px;}
    .panel4 .weui_cell_ft:after {display: none;}
    .panel4 .weui_cell {padding-top: 5px; padding-bottom: 5px;}
</style>
<div class="weui_panel panel1" style="margin-top: 0;">
<!--    <div class="weui_panel_hd">个人中心</div>-->
    <div class="weui_panel_bd">
        <div class="weui_media_box weui_media_text">
            <div class="head-img">
                <img src="/static/public/img/user/head-img.png" width="75" height="75">
            </div>
            <div class="head-dsb">
                <p class="dsb-name">--凌乱</p>
                <p class="dsb-id">ID  1271543621</p>
            </div>
        </div>
    </div>
</div>
<div class="weui_panel panel2">
    <div class="weui_panel_bd">
        <div class="weui_media_box weui_media_text">
            <ul>
                <li>
                    <i class="idt"></i>
                    <p>签到</p>
                </li>
                <li class="pt-line">
                    <i class="clt"></i>
                    <p>关心</p>
                </li>
                <li>
                    <i class="rcm"></i>
                    <p>推荐</p>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="weui_cell panel3">
    <div class="bd">
        <div class="weui_cells weui_cells_access">
            <a class="weui_cell" href="javascript:;">
                <div class="weui_cell_bd weui_cell_primary">
                    <p>修改个人资料</p>
                </div>
                <div class="weui_cell_ft">
                </div>
            </a>
            <a class="weui_cell" href="javascript:;">
                <div class="weui_cell_bd weui_cell_primary">
                    <p>修改密码</p>
                </div>
                <div class="weui_cell_ft">
                </div>
            </a>
        </div>
    </div>
</div>

<div class="weui_cell panel4">
    <div class="bd">
        <div class="weui_cells weui_cells_access">
            <a class="weui_cell" href="javascript:;">
                <div class="weui_cell_bd weui_cell_primary">
                    <p>推送通知</p>
                </div>
                <div class="weui_cell_ft">
                    <input class="weui_switch" type="checkbox" id="switch" checked="">
                </div>
            </a>
        </div>
    </div>
</div>

<div class="weui_cell panel5">
    <div class="bd">
        <div class="weui_cells weui_cells_access">
            <a class="weui_cell" href="javascript:;">
                <div class="weui_cell_bd weui_cell_primary">
                    <p>猜你喜欢</p>
                </div>
                <div class="weui_cell_ft">
                </div>
            </a>
            <a class="weui_cell" href="javascript:;">
                <div class="weui_cell_bd weui_cell_primary">
                    <p>附近热门</p>
                </div>
                <div class="weui_cell_ft">
                </div>
            </a>
            <a class="weui_cell" href="javascript:;">
                <div class="weui_cell_bd weui_cell_primary">
                    <p>周边推荐</p>
                </div>
                <div class="weui_cell_ft">
                </div>
            </a>
            <a class="weui_cell" href="javascript:;">
                <div class="weui_cell_bd weui_cell_primary">
                    <p>设置</p>
                </div>
                <div class="weui_cell_ft">
                </div>
            </a>
        </div>
    </div>
</div>
<script src="/static/public/js/user/index.js?v=20160420"></script>