<?php

namespace app\chengji\model;

// 引用基类
use app\common\model\Base;
// 引用班级类
use app\teach\model\Banji;


class Chengji extends Base
{
   // 学生姓名获取器
	public function getStudentAttr($value)
	{
		return db('student')->where('id',$value)->value('xingming');
	}

	// 学校简称获取器
	public function getSchoolAttr($value)
	{
		return db('school')->where('id',$value)->value('jiancheng');
	}

	// 班级名称获取器
	public function getBanjiAttr($value)
	{
		$bj = Banji::get($value);

		// 返回班级名称 
		return $bj->title;
	}

	// 班级名称(数字)获取器
	public function getBanjiNumnameAttr()
	{
		$bj = Banji::get($this->banji);

		// 返回班级名称 
		return $bj->numTitle;
	}

	// 学生总分
	public function getStuSumAttr()
	{
		$sum = $this->getData('yuwen') + $this->getData('shuxue') +$this->getData('waiyu');
		$sum == 0 ? $sum='' : $sum;
		return $sum;
	}
	// 学生总分
	public function getStuAvgAttr()
	{
		// 将三科成绩以数组形式储存
		$num[] = $this->getAttr('yuwen');
		$num[] = $this->getAttr('shuxue');
		$num[] = $this->getAttr('waiyu');

		// 删除空数据
		$i = 0;
		foreach ($num as $key => $value) {
			if($value == null)
			{
				unset($num[$key]);
			}
		}

		// 获取数组长度
		if(count($num) == null)
		{
			$sum = '';
		}else{
			$sum = array_sum($num)/count($num);
			$sum = round($sum,1);
		}

		return $sum;
	}

	// 格式化成绩
	public function getYuwenAttr($val)
	{
		return $this->myval($val);
	}
	public function getShuxueAttr($val)
	{
		return $this->myval($val);
	}
	public function getWaiyuAttr($val)
	{
		return $this->myval($val);
	}


	// 格式化成绩
	public function myval($val)
	{
		$val == 0 ? $val='' : $val = $val*1;
		return $val;
	}
}
