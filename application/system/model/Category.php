<?php

namespace app\system\model;

use app\common\model\Base;

class Category extends Base
{
    // 获取类别列表
    public function getCategory($id = 0)
    {
    	return $this
    		->where('pid',$id)
    		->where('status',1)
    		->field('id,title')
    		->select();
    }


    // 父级类别获取器
    public function getPidAttr($value)
    {
    	return $this->where('id',$value)->value('title');
    }
}
