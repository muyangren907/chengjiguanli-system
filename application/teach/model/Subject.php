<?php

namespace app\teach\model;

use app\common\model\Base;

class Subject extends Base
{
    // 分类获取器
    public function getcategoryAttr($value)
    {
        return db('category')
                ->where('id',$value)
                ->value('title');
    }
}
