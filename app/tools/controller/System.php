<?php
declare (strict_types = 1);

namespace app\tools\controller;

// 引用控制器基类
use app\BaseController;

class System extends BaseController
{
    // 查询状态为1的学科
    public function subjectAll()
    {
        $sbj = new \app\teach\model\Subject;
        $sbjList = $sbj->where('status', 1)
            ->field('id, title, jiancheng, lieming')
            ->select();

        return $sbj;
    }


    // 查询可以参加考试的学科
    public function subjectKs()
    {
        $sbj = new \app\teach\model\Subject;
        $sbjList = $sbj->where('status&kaoshi', 1)
            ->field('id, title, jiancheng, lieming')
            ->select();
        return $sbj;
    }
}
