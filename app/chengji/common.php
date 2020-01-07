<?php

// 获取学科满分
function getmanfen($kaoshiid,$subjectid)
{

	// 根据考试号和学科名获取满分
	$KSXK = new app\kaoshi\model\KaoshiSubject;
	$manfen = $KSXK->where('kaoshiid',$kaoshiid)->where('subjectid',$subjectid)->value('manfen');

	$manfen = floatval($manfen);
	return $manfen;
}

// 分数验证
function manfenvalidate($defen,$manfen)
{
	$data['val'] = 1;
	$data['msg'] = '验证通过';

	if(is_numeric($defen) == false)
	{
		$data['val'] = 0;
		$data['msg'] = '得分必须是数字';
		return $data;
	}

	if( $defen < 0 )
	{
		$data['val'] = 0;
		$data['msg'] = '得分必须大于等于0';
		return $data;
	}

	if($defen > $manfen)
	{
		$data['val'] = 0;
		$data['msg'] = '得分必须必须小于等于'.$manfen;
		return $data;
	}

	if( ($defen*10)%5 != 0 )
	{
		$data['val'] = 0;
		$data['msg'] = '得分必须只能是x.5';
		return $data;
	}

	return $data;
}



// 统计结果整理





