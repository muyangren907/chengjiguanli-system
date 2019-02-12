<?php

namespace app\rongyu\model;

use think\Model;

class DwRongyuCanyu extends Model
{
    // 关闭全局自动时间戳
    protected $autoWriteTimestamp = false;

    // 荣誉册关联
    public function rongyu()
    {
    	return $this->belongsTo('\app\rongyu\model\DwRongyu','rongyuid','id');
    }

    // 教师关联
    public function teacher()
    {
    	return $this->belongsTo('\app\renshi\model\Teacher','teacherid','id');
    }

}
