<style>
    body {background-color: rgb(235,235,235);}
    .banner {position:absolute; bottom:0; color:#fff; width:100%; background:rgba(0,0,0,.7);}
    .txt {display:table-cell; vertical-align:middle; height:50px;}
    .no-new-line {overflow: hidden;white-space: nowrap;text-overflow: ellipsis;}
    .img {height:50px;}
    .font16 {font-size:16px;}
    .bg-wrapper {position:relative;}
    .container-fluid {margin-top:15px; padding: 0; border-radius: 5px;}
    .list-group {margin-bottom: 0px;}
    .list-group-item{border-color: rgb(197,197,197);}
    .list-group-item a {display:block; color: #000;}
    .img-responsive {width:403px; height:268px;}
    .pull-right {width:50px; height:50px;}
</style>
<?php echo $msg;?>
<script>
    var news = {};
    news.page = 2;
</script>
<script src="/static/public/js/app/news.js?d=20160110"></script>