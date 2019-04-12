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

    // 查询所有单位
    public function search($src)
    {
        // 整理变量
        $xingzhi = $src['xingzhi'];
        $searchval = $src['searchval'];

        // 查询数据
        $data = $this
            ->order([$src['field'] =>$src['order']])
            ->when(strlen($searchval)>0,function($query) use($searchval){
                    $query->where('title|jiancheng','like','%'.$searchval.'%');
                })
            ->with(
                [
                    'dwXingzhi'=>function($query){
                        $query->field('id,title');
                    },
                    'dwJibie'=>function($query){
                        $query->field('id,title');
                    },
                    'dwXueduan'=>function($query){
                        $query->field('id,title');
                    },
                ]
            )
            ->select();
        return $data;
    }
}
