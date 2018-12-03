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
    public function tongji($cjlist,$fenshuxian)
    {
    	// 获取成绩总数
        $cnt = $cjlist->count();

        // 如果没有成绩不计算
        if($cnt == 0)
        {
            $data = ['cnt'=>$cnt,'avg'=>$avg,'sum'=>$sum,'youxiu'=>$youxiulv,'jige'=>$jigelv];
            return $data;
        }

        // 循环计算各科成绩
        foreach ($fenshuxian as $key => $value) {
            // 获取学科成绩
            $xkchengji = $cjlist->column($value['lieming']);

            // 获取优秀人数
            $yx = $value['youxiu'];
            $youxiu = $cjlist->filter(function ($data) use($yx) {
                return  'think' == $data['yuwen'] >= $yx;
            })->count();

            // 获取及格人数
            $jg = $value['jige'];
            $jige = $cjlist->filter(function ($data) use($jg) {
                return  'think' == $data['yuwen'] >= $jg;
            })->count();

            // 计算成绩
            $data[$value['lieming']] = $this->tjxueke($xkchengji,$cnt,$youxiu,$jige);
        }        
    	
    	return $data;
    }



    // 统计学科成绩
    public function tjxueke($xkchengji,$cnt,$youxiu,$jige)
    {
        $sum = $sum = array_sum($xkchengji);
        $avg = round($sum/$cnt,2);
        $youxiulv = round($youxiu/$cnt*100,2);
        $jigelv = round($jige/$cnt*100,2);
        $max = max($xkchengji);
        $min = min($xkchengji);
        $data = ['cnt'=>$cnt,'sum'=>$sum,'avg'=>$avg,'youxiu'=>$youxiulv,'jige'=>$jigelv,'max'=>$max,'min'=>$min];
        return $data;
    }


}
