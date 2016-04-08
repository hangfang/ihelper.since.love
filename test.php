<?php
$contents = explode("\n",file_get_contents('express.txt'));

$result = array();

foreach($contents as $v){

	$tmp = explode(',', $v);
	$result[$tmp[1]] = $tmp[0];
}

file_put_contents('kdniao.php', var_export($result, true));