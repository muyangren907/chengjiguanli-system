<?php

namespace app\rongyu\model;

// 引用数据模型基类
use app\BaseModel;

class DwRongyuCanyu extends BaseModel
{
    // 关闭全局自动时间戳
    protected $autoWriteTimestamp = false;


    // 荣誉册关联
    public function rongyu()
    {
    	return $this->belongsTo('\app\rongyu\model\DwRongyu', 'rongyu_id', 'id');
    }


    // 教师关联
    public function teacher()
    {
    	return $this->belongsTo('\app\teacher\model\Teacher', 'teacher_id', 'id');
    }

}
