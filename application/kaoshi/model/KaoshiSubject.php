<?php

namespace app\kaoshi\model;

// 引用模型类
use think\Model;

class KaoshiSubject extends Model
{
    // 关联学科
    public function subjectName()
    {
    	return $this->belongsTo('\app\teach\model\Subject','subjectid','id');
    }
}
