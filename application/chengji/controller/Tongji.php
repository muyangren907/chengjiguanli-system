<?php

namespace app\chengji\controller;

// 引用控制器基类
use app\common\controller\Base;

class Tongji extends Base
{
    // 年级成绩汇总
    public function nianji()
    {
        $id = input('param.id');
        // 实例化成绩数据模型
        $cj = new \app\chengji\model\Chengji;

        // 根据考试号和年级获取考试成绩
        $cjlist = $cj->searchNianji($id,'二年级');
        $cjlist = $cj->where('kaoshi',2)->select();
        if(!$cjlist)
        {
            return $this->error('没有找到成绩');
        }

        // 获取学科信息
        $xk = new \app\teach\model\Subject;
        $xk = $xk->where('id','<',4)->select();
        $xkTitle = $xk->column('title','id');
        $xkLieming = $xk->column('lieming','id');

        // 获取参加考试学科满分
        $kssub = new \app\kaoshi\model\KaoshiSubject;

        $xkinfo = $kssub ->where('kaoshiid',$id)->append(['subject.title','subject.lieming'])->select();

        // 循环取出优秀和及格分数线
        foreach ($xkinfo as $key => $value) {
            $fenshuxian[$value['subjectid']]['youxiu']=$value['youxiu'];
            $fenshuxian[$value['subjectid']]['jige']=$value['jige'];
            $fenshuxian[$value['subjectid']]['title']=$value['subject']['title'];
            $fenshuxian[$value['subjectid']]['lieming']=$value['subject']['lieming'];
        }


        $tj = new \app\chengji\model\Tongji();


        $a = $tj->tongji($cjlist,$fenshuxian);
        dump($a);
    }
}
