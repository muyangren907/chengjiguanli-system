<?php

namespace app\chengji\model;

// 引用基类
use app\common\model\Base;


class Chengji extends Base
{
   

   // 定义更新成绩后计算平均分和总分
	// protected static function init()
 //    {
   //      self::afterUpdate(function ($cj) {
   //      	$cj =self::where('id',$cj->id)->find();
   //      	// 重新组合数组
   //      	$num[] = $cj->yuwen;
   //      	$num[] = $cj->shuxue;
   //      	$num[] = $cj->waiyu;

   //      	// 删除空数据
			// foreach ($num as $key => $value) {
			// 	if($value == null)
			// 	{
			// 		unset($num[$key]);
			// 	}
			// }

			// // 获取数组长度
			// $cnt = count($num);

			// // 如果存在数据则计算平均分与总分
			// if($cnt>0)
			// {
			// 	$cj->stuSum=array_sum($num);
			// 	$cj->stuAvg=$cj->stuSum/$cnt;
			// 	$cj->stuAvg = round($cj->stuAvg,1);
			// }

   //          $cj->save();
   //      });
    // }

    // 成绩和学科关联
    public function cjSubject()
    {
    	return $this->belongsTo('\app\teach\model\Subject');
    }



	
}
