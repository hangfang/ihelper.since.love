<script type="text/javascript" src="/static/bootstrap/js/bootstrap-select.js"></script>
<link rel="stylesheet" type="text/css" href="/static/bootstrap/css/bootstrap-select.min.css">
<div class="panel">
    <div class="hd">
        <h1 class="page_title">彩票查询</h1>
    </div>
    <div class="bd">
        <form class="form-horizontal" action="/app/lottery" method="post" target="_self" id="form_lottery">
            <div class="form-group has-success has-feedback">
                <label class="control-label col-sm-3" for="lottery_code">选择彩种</label>
                <div class="col-sm-9">
                    <select name="lottery_code" id="lottery_code" class="show-tick form-control" data-live-search="true" autocomplete="on">
                    <?php
                        foreach($lotteryList as $_k=>$_v){
                            echo <<<EOF
<option value="{$_v}">{$_k}</optoin>
EOF;
                        }
                    ?>
                    </select>
                    <span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true" style="display:none;"></span>
                    <span id="lottery_code_success" class="sr-only" style="display: none;">(success)</span>
                </div>
            </div>
            <div class="form-group" style="width: 50px; margin: 0 auto;">
                <div>
                    <button class="form-control btn btn-default" type="submit" id="submit_lottery">查询</button>
                </div>
            </div>
        </form>
        
        <div class="weui_panel" id="lottery_result" style="display: none;">
            <div class="weui_panel_hd">查询结果</div>
            <div class="weui_panel_bd">
                <div class="weui_media_box weui_media_text">
                    <p class="weui_media_desc"></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/static/public/js/app/lottery.js?d=20160110"></script>