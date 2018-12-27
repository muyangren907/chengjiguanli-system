<?php

namespace app\rongyu\model;

// 引用数据模型基类
use app\common\model\Base;

class DwRongyu extends Base
{
    //搜索单位获奖荣誉
    public function search($search)
    {
    	// 获取参数
    	$hjschool = $search['hjschool'];
    	$fzschool = $search['fzschool'];
    	$category = $search['category'];
    	$order_field = $search['order_field'];
    	$order = $search['order'];
    	$category = $search['category'];
    	$search = $search['search'];

    	$data = $this->order([$order_field =>$order])
    		->when(!empty($hjschool),function($query) use($hjschool){
                	$query->where('hjschool','in',$hjschool);
                })
    		->when(!empty($fzschool),function($query) use($fzschool){
                	$query->where('fzschool','in',$fzschool);
                })
    		->when(!empty($category),function($query) use($category){
                	$query->where('category','in',$category);
                })
    		->when(!empty($search),function($query) use($search){
                	$query->where('title','like',$search);
                })
    		->select();

    	return $data;
    }
}
