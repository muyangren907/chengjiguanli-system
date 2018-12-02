<?php

namespace app\chengji\model;

use think\Model;

class Tongji extends Model
{
    var $avg = '';
    var $sum = '';
    var $youxiulv = '';#优秀率
    var $jigelv = '';#及格率


    //获取统计成绩
    public function tongji($cjs)
    {
    	$cnt = count($cjs);
    	$sum = $this->sum($cjs);
    	$avg = $sum/$cnt;
    	$data = ['cnt'=>$cnt,'avg'=>$avg,'sum'=>$sum];
    	return $data;
    }


    // 总分
    public function sum($cjs)
    {
    	$sum = array_sum($cjs);
    	return $sum;
    }


}
