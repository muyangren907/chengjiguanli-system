<?php

namespace app\teach\model;

use app\common\model\Base;


class Xueqi extends Base
{
     // 开始时间修改器
    public function setBfdateAttr($value)
    {
        return strtotime($value);
    }

    // 开始时间获取器
    public function getBfdateAttr($value)
    {
        return date('Y-m-d',$value);
    }

    // 结束时间修改器
    public function setEnddateAttr($value)
    {
        return strtotime($value);
    }

    // 结束时间获取器
    public function getEnddateAttr($value)
    {
        return date('Y-m-d',$value);
    }

    // 分类获取器
    public function getcategoryAttr($value)
    {
        return db('category')
                ->where('id',$value)
                ->value('title');
    }
}
