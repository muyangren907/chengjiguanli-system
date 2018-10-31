<?php

function nianjiList()
{
	// 定义学年时间节点日期为每年的8月10日
	// $yd = '8-10';
	$jiedian = strtotime(date('Y').'-8-10');

	$time = new think\helper\Time();

	$thisday = $time->today();

	if($thisday[0]<=$jiedian)
	{
		$str = 1;
	}else{
		$str = 0;
	}

	$nian = date('Y') - $str;

	$njlist = array();

	$njlist[$nian]='一年级';
	$njlist[$nian-1]='二年级';
	$njlist[$nian-2]='三年级';
	$njlist[$nian-3]='四年级';
	$njlist[$nian-4]='五年级';
	$njlist[$nian-5]='六年级';

	return $njlist;
}
