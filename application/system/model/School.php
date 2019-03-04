<?php

namespace app\system\model;

use app\common\model\Base;

class School extends Base
{

    // 教师数据模型关联
    public function dwTeacher()
    {
        return $this->hasMany('\app\renshi\model\Teacher','danwei','id');
    }

    // 单位性质数据模型关联
    public function  dwXingzhi()
    {
        return $this->belongsTo('\app\system\model\Category','xingzhi','id');
    }


    // 单位级别数模型关联
    public function  dwJibie()
    {
        return $this->belongsTo('\app\system\model\Category','jibie','id');
    }


    // 单位学段数模型关联
    public function  dwXueduan()
    {
        return $this->belongsTo('\app\system\model\Category','xueduan','id');
    }



    // 查询所有单位
    public function search($search)
    {
        // 获取参数
        $xingzhi = $search['xingzhi'];
        $order_field = $search['order_field'];
        $order = $search['order'];
        $search = $search['search'];



        $data = $this->order([$order_field =>$order])
            ->when(strlen($xingzhi)>0,function($query) use($xingzhi){
                    $query->where('xingzhi','in',$xingzhi);
                })
            ->when(strlen($search)>0,function($query) use($search){
                    $query->where('title|jiancheng','like',$search);
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
            ->withCount(
                [
                    'dwTeacher'=>function($query){
                        $query->where('status',1);
                    }
                ]
            )
            // ->append(['cnt'])
            ->select();


        return $data;
    }

    // 查询所有数据
    public function searchAll()
    {
        return $this->cache('key',180)->select();
    }
}
