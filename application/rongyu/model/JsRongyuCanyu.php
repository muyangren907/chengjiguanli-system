<?php

namespace app\rongyu\model;

// 引用数据模型类
use think\Model;

class JsRongyuCanyu extends Model
{

    // 荣誉册关联
    public function rongyu()
    {
    	return $this->belongsTo('\app\rongyu\model\JsRongyu','rongyuid','id');
    }

    // 教师关联
    public function teacher()
    {
    	return $this->belongsTo('\app\renshi\model\Teacher','teacherid','id');
    }
}
