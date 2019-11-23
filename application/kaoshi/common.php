<?php

// 验证考试是否结束 
function enddate($kaoshiid)
{
	$ks = new app\kaoshi\model\Kaoshi;
    $enddate = $ks->where('id',$kaoshiid)->value('enddate');

    $thistime = time();
    if($enddate<time())
    {
        $data = false;
    }else{
    	$data = true;
    }

    return $data;

}


