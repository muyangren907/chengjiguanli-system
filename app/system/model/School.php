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
    public function search($src)
    {
        // 整理变量
        $xingzhi = $src['xingzhi'];
        $jibie = $src['jibie'];
        $searchval = $src['searchval'];

        // 查询数据
        $data = $this
            ->order([$src['field'] =>$src['type']])
            ->when(count($xingzhi)>0,function($query) use($xingzhi){
                    $query->where('xingzhi','in',$xingzhi);
                })
            ->when(count($jibie)>0,function($query) use($jibie){
                    $query->where('jibie','in',$jibie);
                })
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
            ->withCount(
                [
                    'dwTeacher'=>function($query){
                        $query->where('status',1);
                    }
                ]
            )
            ->select();
        return $data;
    }
}
