<?php

namespace app\chengji\controller;

// 引用控制器基类
use app\common\controller\Base;

class Tongji extends Base
{
    // 年级成绩汇总
    public function nianji()
    {
        // 实例化成绩数据模型
        $cj = new \app\chengji\model\Chengji;

        // 根据考试号和年级获取考试成绩
        $cjlist = $cj->searchNianji(1,'一年级');

        



        $tj = new \app\chengji\model\Tongji();
        $yuwen = $cjlist->column('yuwen');
        dump($yuwen);
        $a = $tj->tongji($yuwen);
        dump($a);
    }
}
