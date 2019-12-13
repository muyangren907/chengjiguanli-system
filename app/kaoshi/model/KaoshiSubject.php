<?php

namespace app\kaoshi\model;

// 引用数据模型基类
use app\common\model\Base;

class KaoshiSubject extends Base
{
    // 关联学科
    public function subjectName()
    {
    	return $this->belongsTo('\app\teach\model\Subject','subjectid','id');
    }
}