<div class="panel">
    <div class="hd">
        <h1 class="page_title">物流查询</h1>
    </div>
    <div class="bd">
        <form class="form-horizontal" action="/express/index" method="post" target="_self">
            <div class="form-group has-success has-feedback">
                <label class="control-label col-sm-3" for="com">快递公司</label>
                <div class="col-sm-9">
                    <select class="form-control" name="com" id="com" aria-describedby="com_success">
                <?php
                        foreach($expressList as $_k=>$_v){
                            echo <<<EOF
<option value="{$_k}">{$_k}</optoin>
EOF;
                        }
                    ?>
                    </select>
                    <span class="glyphicon glyphicon-ok form-control-feedback hide" aria-hidden="true"></span>
                    <span id="com_success" class="sr-only hide">(success)</span>
                </div>
            </div>
            <div class="form-group has-success has-feedback">
                <label class="control-label col-sm-3" for="nu">快递单号</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="nu" name="nu" aria-describedby="nu_success">
                    <span class="glyphicon glyphicon-ok form-control-feedback hide" aria-hidden="true"></span>
                    <span id="nu_success" class="sr-only hide">(success)</span>
                </div>
            </div>
            <div class="form-group" style="width: 50px; margin: 0 auto;">
                <div>
                    <button class="form-control btn btn-default" type="submit" id="submit">查询</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="/static/public/js/express/index.js?d=20160110"></script>