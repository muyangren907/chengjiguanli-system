<?php

namespace app\chengji\model;

// 引用基类
use app\common\model\Base;
// 引用班级类
use app\teach\model\Banji;


class Chengji extends Base
{
   // 学生姓名获取器
	public function getStudentnameAttr()
	{
		return db('student')->where('id',$this->student)->value('xingming');
	}

	// 学校简称获取器
	public function getSchooljianAttr()
	{
		return db('school')->where('id',$this->school)->value('jiancheng');
	}

	// 班级名称获取器
	public function getBanjinameAttr()
	{
		$bj = Banji::get($this->banji);

		// 返回班级名称 
		return $bj->title;
	}
}
