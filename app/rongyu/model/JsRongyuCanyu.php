<?php

namespace app\rongyu\model;

// 引用数据模型类
use app\BaseModel;

class JsRongyuCanyu extends BaseModel
{

    // 荣誉册关联
    public function rongyu()
    {
    	return $this->belongsTo('\app\rongyu\model\JsRongyu', 'rongyu_id', 'id');
    }

    // 教师关联
    public function teacher()
    {
    	return $this->belongsTo('\app\teacher\model\Teacher', 'teacher_id', 'id');
    }
}
