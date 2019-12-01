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

    // 分类关联
    public function glCategory()
    {
        return $this->belongsTo('\app\system\model\Category','category','id');
    }

    // 查询所有单位
    public function search($src)
    {
        // 整理变量
        $searchval = $src['searchval'];

        // 查询数据
        $data = $this
            ->order([$src['field'] =>$src['type']])
            ->when(strlen($searchval)>0,function($query) use($searchval){
                    $query->where('title|xuenian','like','%'.$searchval.'%');
                })
            ->with(
                [
                    'glCategory'=>function($query){
                        $query->field('id,title');
                    },
                ]
            )
            ->select();
        return $data;
    }
}
