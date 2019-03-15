<?php

namespace app\system\model;

use app\common\model\Base;

class Category extends Base
{
	// 关闭全局自动时间戳
    protected $autoWriteTimestamp = false;

    // // 父级类别获取器
    // public function getPidAttr($value)
    // {
    // 	return $this->where('id',$value)->value('title');
    // }

    // 本模型关联
    public function glPid()
    {
    	return $this->belongsTo('Category','pid','id');
    }
}
