<?php
declare (strict_types = 1);

namespace app\searchtools\controller;

// 引用基类
use \app\base\ToolsBase;
// 引用考试设置
use app\kaoshi\model\KoashiSet as ksset;

class Kaoshi extends ToolsBase
{
    // 查询参加考试的学科
    public function subject($src)
    {
        $ksset = new ksset();
        $data =  $ksset->srcSubject($src);
        return $data;
    }

    
    // 查询参加考试的年级
    public function grade($kaoshi_id)
    {
        $ksset = new ksset();
        $data =  $ksset->srcGrade($kaoshi_id);
        return $data;
    }
    
}
