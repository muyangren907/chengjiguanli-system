<?php

namespace app\system\model;

use app\common\model\Base;

class School extends Base
{
    // 单位性质获取器
    public function getXingzhiAttr($value)
    {
    	return $this->getcategory($value);
    }

    // 单位级别获取器
    public function getJibieAttr($value)
    {
    	return $this->getcategory($value);
    }

    // 单位学段获取器
    public function getXueduanAttr($value)
    {
    	return $this->getcategory($value);
    }

    // 获取类别名
    public function getcategory($id)
    {
        return db('category')
            ->where('id',$id)
            ->value('title');
    }


}
