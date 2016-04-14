<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo $title; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <!-- 新 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="/static/bootstrap/css/bootstrap.min.css">

    <!-- 可选的Bootstrap主题文件（一般不用引入） -->
    <link rel="stylesheet" href="/static/bootstrap/css/bootstrap-theme.min.css">

    <!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
    <script src="/static/public/js/jquery.min.js"></script>

    <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
    <script src="/static/bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/static/public/css/common.css"/>
    <?php if($environment==='production'){ ?>
    <script>
        window.onerror = function(){return true;};
    </script>
    <?php }?>
</head>
<body>
    <div class="container" id="container">
        <ul class="nav nav-tabs">
            <li role="presentation" class="<?php if($this->uri->segment(2)==='index' && $this->uri->segment(1)==='welcome'){echo 'active';}?>"><a href="javascript:void(0)">首页</a></li>
            <li role="presentation" class=""><a href="/weather/">查询天气</a></li>
            <li role="presentation" class=""><a href="/express/">查询物流</a></li>
            <li role="presentation" class=""><a href="/stock/">查询股票</a></li>
            <li role="presentation" class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                图像处理 <span class="caret"></span>
              </a>
              <ul class="dropdown-menu">
               <li role="presentation" class=""><a href="/photo/">web图片处理-简约版</a></li>
               <li role="presentation" class=""><a href="/photo/pro">web图片处理-专业版</a></li>
              </ul>
            </li>
      </ul>
        <?php echo $content_for_layout?>
    </div>
</body>
</html>
<script type="text/javascript" src="http://tajs.qq.com/stats?sId=55520872" charset="UTF-8"></script>	