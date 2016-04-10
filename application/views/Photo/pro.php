<link media="all" rel="stylesheet" href="/static/public/css/photo/main1.css" type="text/css" />
<link media="all" rel="stylesheet" href="/static/public/css/photo/flash.css" type="text/css" />
<script type="text/javascript" src="/static/public/js/photo/jquery.js"></script>
<script type="text/javascript" src="/static/public/js/photo/alloyimage.js"></script>
<div class="wrapper">
    <div class="title">web图片处理-专业版</div>
    <div class="panel">
        <div class="pItem" id="new"><img src='/static/public/css/photo/image/open.png' /><br />新建</div>
        <div class="pItem" id="open"><img src='/static/public/css/photo/image/open.png' /><br />打开图片</div>
        <div class="pItem" id="modify"><img src='/static/public/css/photo/image/modify.png' /><br />调整</div>
        <div class="pItem" id="lj"><img src='/static/public/css/photo/image/lvjing.png' /><br />滤镜</div>
        <div class="pItem" id="saveFile"><img src='/static/public/css/photo/image/save.png' /><br />保存图片</div>
        <div class="modifyItem subItem" id="modi_b">亮度/对比度调节</div>
        <div class="modifyItem subItem" id="modi_HSI">饱和度调节</div>
        <div class="modifyItem subItem" id="curve">曲线</div>
        <div class="ljItem subItem">反色</div>
        <div class="ljItem subItem">灰度处理</div>
        <div class="ljItem subItem">灰度阈值</div>
        <div class="ljItem subItem">高斯模糊</div>
        <div class="ljItem subItem">锐化</div>
        <div class="ljItem subItem">浮雕效果</div>
        <div class="ljItem subItem">查找边缘</div>
        <div class="ljItem subItem">马赛克</div>
        <div class="ljItem subItem">腐蚀</div>
        <!--<div class="ljItem subItem">油画</div>-->
        <div class="ljItem subItem">添加杂色</div>
        <div class="ljItem subItem">暗角</div>
        <div class="ljItem subItem">喷点</div>
        <img src="/static/public/css/photo/image/back.png" alt="" class="back" />
    </div>
    <div class="left">
        <div class="openFile">
            打开一张图片<br />
            <span style="font-size:12px;">tips:按ctrl键可移动图层、支持图层的多选操作</span>
        </div>
        <div class="painting">
        </div>
    </div>
    <div class="right">
        直方图
        <div class="rect">
            <canvas id="imgRect" width="214" height="91"></canvas>
        </div>
        图层
        <div class="edit">
            <img src="/static/public/css/photo/image/copy.png" id="copy" width="30" alt="复制图层" title="复制图层" class="eItem" />
            <img src="/static/public/css/photo/image/up.png" id="up" width="30" alt="上移图层" title="上移图层" class="eItem" />
            <img src="/static/public/css/photo/image/down.png" width="30" id="down" alt="下移图层" title="下移图层" class="eItem" />
            <img src="/static/public/css/photo/image/delete.png" width="30" id="delete" alt="删除图层" title="删除图层" class="eItem" />
        </div>
        <div class="layer">
        </div>
    </div>
</div>
<script type="text/javascript" src="/static/public/js/photo/main.js"></script>