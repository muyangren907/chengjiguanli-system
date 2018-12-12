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
        $ct = new \app\system\model\Category;
        return $ct
            ->where('id',$id)
            ->value('title');
    }


    // 查询所有单位
    public function searchAjax($getdt)
    {
        //得到排序的方式
        $order = $getdt['order'][0]['dir'];
        //得到排序字段的下标
        $order_column = $getdt['order'][0]['column'];
        //根据排序字段的下标得到排序字段
        $order_field = $getdt['columns'][$order_column]['data'];
        //得到limit参数
        $limit_start = $getdt['start'];
        $limit_length = $getdt['length'];
        //得到搜索的关键词
        $search = $getdt['search']['value'];


        // 如果需要查询
        if(trim($search)){
            $data =sch::field('id,title,jiancheng,biaoshi,xingzhi,jibie,status,xueduan,paixu')
                ->whereOr('title','like','%'.$search.'%')
                ->whereOr('pid','in',function($query) use ($search){
                    $query->name('category')->where('title','like','%'.$search.'%')->field('id');
                })
                ->order([$order_field=>$order])
                ->limit($limit_start,$limit_length)
                ->select();
        }else{
            $data =$this->field('id,title,jiancheng,biaoshi,xingzhi,jibie,status,xueduan,paixu')
            ->order([$order_field=>$order])
            ->limit($limit_start,$limit_length)
            ->select();
        }

        return $data;
    }

    // 查询所有数据
    public function searchAll()
    {
        return $this->cache('key',180)->select();
    }

    // 查询范围内数据
    // public function searchMany($jibie1,$jibie2)
    // {
    //     $jb = new \app\system\model\Category;
    //     $jibie1 = $jb->wherePid(102)
    //         ->whereTitle($jibie1)
    //         ->value('id');
    //     $jibie2 = $jb->wherePid(102)
    //         ->whereTitle($jibie2)
    //         ->value('id');

    //     $schlist = $this->where('jibie','between',[$jibie1,$jibie2])->select();
    //     return $schlist;
    // }







}
