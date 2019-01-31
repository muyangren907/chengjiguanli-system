<?php

namespace app\rongyu\model;

// 引用数据模型基类
use app\common\model\Base;

class JsRongyu extends Base
{
	//搜索单位获奖荣誉
    public function search($search)
    {
        // 获取参数
    	$fzschool = $search['fzschool'];
    	$category = $search['category'];
    	$order_field = $search['order_field'];
    	$order = $search['order'];
    	$category = $search['category'];
    	$search = $search['search'];

    	$data = $this->order([$order_field =>$order])
    		->when(!empty($fzschool),function($query) use($fzschool){
                	$query->where('fzschool','in',$fzschool);
                })
    		->when(!empty($category),function($query) use($category){
                	$query->where('category','in',$category);
                })
    		->when(!empty($search),function($query) use($search){
                	$query->where('title','like',$search);
                })
            ->with(
                [
                    'fzSchool'=>function($query){
                        $query->field('id,jiancheng');
                    },
                    'lxCategory'=>function($query){
                        $query->field('id,title');
                    },
                ]
            )
            ->append(['cnt'])
    		->select();


    	return $data;
    }


    // 颁奖单位关联
    public function fzSchool()
    {
         return $this->belongsTo('\app\system\model\School','fzschool','id');
    }

    // 荣誉类型
    public function lxCategory()
    {
         return $this->belongsTo('\app\system\model\Category','category','id');
    }


    // 荣誉信息关联
    public function ryInfo()
    {
    	return $this->hasMany('JsRongyuInfo','rongyuce','id');
    }

    // 荣誉级别
    public function getCntAttr()
    {
         return $this->ryInfo->count();   
    }


    // 发证时间修改器
    public function setFzshijianAttr($value)
    {
        return strtotime($value);
    }

    // 发证时间获取器
    public function getFzshijianAttr($value)
    {
        return date('Y-m-d',$value);
    }
}
