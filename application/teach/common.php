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


	// 班级列表
	function banjinamelist()
	{
		$bjarr = array(
			'1'=>'一班',
			'2'=>'二班',
			'3'=>'三班',
			'4'=>'四班',
			'5'=>'五班',
			'6'=>'六班',
			'7'=>'七班',
			'8'=>'八班',
			'9'=>'九班',
			'10'=>'十班',
			'11'=>'十一班',
			'12'=>'十二班',
			'13'=>'十三班',
			'14'=>'十四班',
			'15'=>'十五班',
		);

		return $bjarr;
	}

