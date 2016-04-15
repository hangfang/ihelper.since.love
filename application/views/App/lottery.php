<div class="panel">
    <div class="hd">
        <h1 class="page_title">彩票查询</h1>
    </div>
    <div class="bd">
        <form class="form-horizontal row" action="/app/lottery" method="post" target="_self" id="form_lottery">
            <div class="weui_cell weui_cell_select weui_select_after">
<!--                <div class="weui_cell_hd">
                    彩种
                </div>-->
                <div class="weui_cell_bd weui_cell_primary">
                    <select class="weui_select" id="lottery_code" name="lottery_code">
                        <?php
                            foreach($lotteryList as $_k=>$_v){
                                echo <<<EOF
<option value="{$_v}">{$_k}</optoin>
EOF;
                            }
                        ?>
                    </select>
                </div>
            </div>
            <input type="submit" class="weui_btn weui_btn_primary" value="开奖信息">
        </form>
        <form class="form-horizontal row" action="/app/checkLottery" method="post" target="_self" id="form_check">
<!--            <div class="weui_cells_title">彩种</div>-->
            <div class="weui_cells">
                <div class="weui_cell weui_cell_select weui_select_before">
                    <div class="weui_cell_hd">
                        <select class="weui_select" name="lottery_type" id="lottery_type">
                            <option value="Ssq">双色球</option>
                            <option value="3D">福彩3D</option>
                            <option value="dlt">大乐透</option>
                            <option value="plw">排列五</option>
                            <option value="pls">排列三</option>
                            <option value="qxc">七星彩</option>
                        </select>
                    </div>
                    <div class="weui_cell_bd weui_cell_primary" id="Ssq">
                        <input class="weui_input" type="tel" placeholder="1号" maxlength="2" name="a" style="width:12.5%; margin:15px 0; border-bottom: 1px solid #04BE02; text-align: center;"/>
                        <input class="weui_input" type="tel" placeholder="2号" maxlength="2" name="b" style="width:12.5%; margin:15px 0; border-bottom: 1px solid #04BE02; text-align: center;"/>
                        <input class="weui_input" type="tel" placeholder="3号" maxlength="2" name="c" style="width:12.5%; margin:15px 0; border-bottom: 1px solid #04BE02; text-align: center;"/>
                        <input class="weui_input" type="tel" placeholder="4号" maxlength="2" name="d" style="width:12.5%; margin:15px 0; border-bottom: 1px solid #04BE02; text-align: center;"/>
                        <input class="weui_input" type="tel" placeholder="5号" maxlength="2" name="e" style="width:12.5%; margin:15px 0; border-bottom: 1px solid #04BE02; text-align: center;"/>
                        <input class="weui_input" type="tel" placeholder="6号" maxlength="2" name="f" style="width:12.5%; margin:15px 0; border-bottom: 1px solid #04BE02; text-align: center;"/>
                        <input class="weui_input" type="tel" placeholder="红球" maxlength="2" name="g" style="width:12.5%; margin:15px 0; border-bottom: 1px solid #04BE02; text-align: center;"/>
                    </div>
                    <div class="weui_cell_bd weui_cell_primary" id="3D" style="display:none;">
                        <input class="weui_input" type="tel" placeholder="1号" maxlength="1" name="a" style="width:12.5%; margin:15px 0; border-bottom: 1px solid #04BE02; text-align: center;"/>
                        <input class="weui_input" type="tel" placeholder="2号" maxlength="1" name="b" style="width:12.5%; margin:15px 0; border-bottom: 1px solid #04BE02; text-align: center;"/>
                        <input class="weui_input" type="tel" placeholder="3号" maxlength="1" name="c" style="width:12.5%; margin:15px 0; border-bottom: 1px solid #04BE02; text-align: center;"/>
                    </div>
                    <div class="weui_cell_bd weui_cell_primary" id="dlt" style="display:none;">
                        <input class="weui_input" type="tel" placeholder="1号" maxlength="2" name="a" style="width:12.5%; margin:15px 0; border-bottom: 1px solid #04BE02; text-align: center;" />
                        <input class="weui_input" type="tel" placeholder="2号" maxlength="2" name="b" style="width:12.5%; margin:15px 0; border-bottom: 1px solid #04BE02; text-align: center;" />
                        <input class="weui_input" type="tel" placeholder="3号" maxlength="2" name="c" style="width:12.5%; margin:15px 0; border-bottom: 1px solid #04BE02; text-align: center;" />
                        <input class="weui_input" type="tel" placeholder="4号" maxlength="2" name="d" style="width:12.5%; margin:15px 0; border-bottom: 1px solid #04BE02; text-align: center;" />
                        <input class="weui_input" type="tel" placeholder="5号" maxlength="2" name="e" style="width:12.5%; margin:15px 0; border-bottom: 1px solid #04BE02; text-align: center;" />
                        <input class="weui_input" type="tel" placeholder="特1" maxlength="2" name="f" style="width:12.5%; margin:15px 0; border-bottom: 1px solid #04BE02; text-align: center;" />
                        <input class="weui_input" type="tel" placeholder="特2" maxlength="2" name="g" style="width:12.5%; margin:15px 0; border-bottom: 1px solid #04BE02; text-align: center;" />
                    </div>
                    <div class="weui_cell_bd weui_cell_primary" id="plw" style="display:none;">
                        <input class="weui_input" type="tel" placeholder="1号" maxlength="1" name="a" style="width:12.5%; margin:15px 0; border-bottom: 1px solid #04BE02; text-align: center;"/>
                        <input class="weui_input" type="tel" placeholder="2号" maxlength="1" name="b" style="width:12.5%; margin:15px 0; border-bottom: 1px solid #04BE02; text-align: center;"/>
                        <input class="weui_input" type="tel" placeholder="3号" maxlength="1" name="c" style="width:12.5%; margin:15px 0; border-bottom: 1px solid #04BE02; text-align: center;"/>
                        <input class="weui_input" type="tel" placeholder="4号" maxlength="1" name="d" style="width:12.5%; margin:15px 0; border-bottom: 1px solid #04BE02; text-align: center;"/>
                        <input class="weui_input" type="tel" placeholder="5号" maxlength="1" name="e" style="width:12.5%; margin:15px 0; border-bottom: 1px solid #04BE02; text-align: center;"/>
                    </div>
                    <div class="weui_cell_bd weui_cell_primary" id="pls" style="display:none;">
                        <input class="weui_input" type="tel" placeholder="1号" maxlength="1" name="a" style="width:12.5%; margin:15px 0; border-bottom: 1px solid #04BE02; text-align: center;"/>
                        <input class="weui_input" type="tel" placeholder="2号" maxlength="1" name="b" style="width:12.5%; margin:15px 0; border-bottom: 1px solid #04BE02; text-align: center;"/>
                        <input class="weui_input" type="tel" placeholder="3号" maxlength="1" name="c" style="width:12.5%; margin:15px 0; border-bottom: 1px solid #04BE02; text-align: center;"/>
                    </div>
                    <div class="weui_cell_bd weui_cell_primary" id="qxc" style="display:none;">
                        <input class="weui_input" type="tel" placeholder="1号" maxlength="1" name="a" style="width:12.5%; margin:15px 0; border-bottom: 1px solid #04BE02; text-align: center;"/>
                        <input class="weui_input" type="tel" placeholder="2号" maxlength="1" name="b" style="width:12.5%; margin:15px 0; border-bottom: 1px solid #04BE02; text-align: center;"/>
                        <input class="weui_input" type="tel" placeholder="3号" maxlength="1" name="c" style="width:12.5%; margin:15px 0; border-bottom: 1px solid #04BE02; text-align: center;"/>
                        <input class="weui_input" type="tel" placeholder="4号" maxlength="1" name="d" style="width:12.5%; margin:15px 0; border-bottom: 1px solid #04BE02; text-align: center;"/>
                        <input class="weui_input" type="tel" placeholder="5号" maxlength="1" name="e" style="width:12.5%; margin:15px 0; border-bottom: 1px solid #04BE02; text-align: center;"/>
                        <input class="weui_input" type="tel" placeholder="6号" maxlength="1" name="f" style="width:12.5%; margin:15px 0; border-bottom: 1px solid #04BE02; text-align: center;"/>
                        <input class="weui_input" type="tel" placeholder="7号" maxlength="1" name="g" style="width:12.5%; margin:15px 0; border-bottom: 1px solid #04BE02; text-align: center;"/>
                    </div>
                </div>
            </div>
            <input type="submit" class="weui_btn weui_btn_primary" value="是否中奖">
        </form>
    </div>
</div>

<script src="/static/public/js/app/lottery.js?d=20160110"></script>