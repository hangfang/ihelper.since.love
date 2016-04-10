<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo $title; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 新 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="/static/bootstrap/css/bootstrap.min.css">

    <!-- 可选的Bootstrap主题文件（一般不用引入） -->
    <link rel="stylesheet" href="/static/bootstrap/css/bootstrap-theme.min.css">

    <!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
    <script src="/static/public/js/jquery.min.js"></script>

    <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
    <script src="/static/bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/static/public/css/common.css"/>
</head>
<body>
    <div class="container" id="container">
        <?php echo $content_for_layout?>
    </div>
</body>
</html>