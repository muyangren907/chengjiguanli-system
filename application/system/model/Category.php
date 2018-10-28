<?php

namespace app\system\model;

use app\common\model\Base;

class Category extends Base
{

    // 父级类别获取器
    public function getPidAttr($value)
    {
    	return $this->where('id',$value)->value('title');
    }
}
