<?php

namespace app\chengji\model;

use think\Model;

class Tongji extends Model
{
    //统计成绩
    public function tongji($cjlist,$fenshuxian)
    {
    	// 获取成绩总数
        $cnt = $cjlist->count();

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
        $sum = array_sum($xkchengji);
        if($sum != 0)
        {
            $avg = round($sum/$cnt,2);
            $youxiulv = round($youxiu/$cnt*100,2);
            $jigelv = round($jige/$cnt*100,2);
            $max = max($xkchengji);
            $min = min($xkchengji);
            $data = ['cnt'=>$cnt,'sum'=>$sum,'avg'=>$avg,'youxiu'=>$youxiulv,'jige'=>$jigelv,'max'=>$max,'min'=>$min];
        }else{
            $data = ['cnt'=>0,'sum'=>'-','avg'=>'-','youxiu'=>'-','jige'=>'-','max'=>'-','min'=>'-'];
        }
        
        return $data;
    }


    // 获取统计成绩需要的参数
    public function getCanshu($kaoshiid)
    {
        // 获取学科信息
        $xk = new \app\teach\model\Subject;
        $xk = $xk->where('id','<',4)->select();
        $xkTitle = $xk->column('title','id');
        $xkLieming = $xk->column('lieming','id');

        // 获取参加考试学科满分
        $kssub = new \app\kaoshi\model\KaoshiSubject;

        $fenshuxian = $kssub ->where('kaoshiid',$kaoshiid)->append(['subject.title','subject.lieming'])->select();

        // 循环取出优秀和及格分数线
        foreach ($fenshuxian as $key => $value) {
            $fsx[$value['subjectid']]['youxiu']=$value['youxiu'];
            $fsx[$value['subjectid']]['jige']=$value['jige'];
            $fsx[$value['subjectid']]['title']=$value['subject']['title'];
            $fsx[$value['subjectid']]['lieming']=$value['subject']['lieming'];
        }

        // 返回数据
        return $fsx;
    }


}
