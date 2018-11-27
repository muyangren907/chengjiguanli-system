<?php

// 获取学科满分
function getmanfen($kaoshiid,$subjectid)
{
	// 获取考试号
	$cj = new app\chengji\model\Chengji;
	$kaoshiid = $cj->where('id',$kaoshiid)->value('kaoshi');

	// 根据考试号和学科名获取满分
	$KSXK = new app\kaoshi\model\KaoshiSubject;
	$manfen = $KSXK->where('kaoshiid',$kaoshiid)->where('subjectid','in',$subjectid)->column('subjectid,manfen');
	return $manfen;

}

// 分数验证
function manfenvalidate($defen,$manfen)
{
	if(is_numeric($defen) && $defen>=0 && $defen<=$manfen && ($defen*10%5)==0)
	{
		return true;
	}

	return false;
}

