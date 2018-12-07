<?php

namespace app\teach\model;

use app\common\model\Base;

class Subject extends Base
{
    // 类别获取器
    public function sujCategory()
	{
		return $this->belongsTo('\app\system\model\Category','category','id');
	}


	// 是否参加考试获取器
	public function getKaoshiAttr($value)
	{
		$data = [1=>'是',0=>'否'];

		return $data[$value];
	}
	
}
