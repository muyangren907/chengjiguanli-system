<?php

namespace app\chengji\model;

// 引用基类
use app\common\model\Base;
// 引用班级类
use app\teach\model\Banji;


class Chengji extends Base
{
   

   // 定义更新成绩后计算平均分和总分
	protected static function init()
    {
        self::afterUpdate(function ($cj) {
        	$cj = $cj->where('id',$cj->id)->find();
        	// 重新组合数组
        	$num[] = $cj->yuwen;
        	$num[] = $cj->shuxue;
        	$num[] = $cj->waiyu;

        	// 删除空数据
			foreach ($num as $key => $value) {
				if($value == null)
				{
					unset($num[$key]);
				}
			}

			// 获取数组长度
			$cnt = count($num);

			// 如果存在数据则计算平均分与总分
			if($cnt>0)
			{
				$cj->stuSum=array_sum($num);
				$cj->stuAvg=$cj->stuSum/$cnt;
				$cj->stuAvg = round($cj->stuAvg,1);
			}

            $cj->save();
        });
    }

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
		$bj = Banji::find($value);

		// 返回班级名称 
		return $bj->title;
	}

	// 班级名称(数字)获取器
	public function getBanjiNumnameAttr($value)
	{
		$bj = Banji::find($value);

		// 返回班级名称 
		return $bj->numTitle;
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
	public function getStuSumAttr($val)
	{
		return $this->myval($val);
	}
	public function getStuAvgAttr($val)
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
