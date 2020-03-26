<?php

namespace app\rongyu\model;

// 引用数据模型基类
use app\BaseModel;

class JsRongyu extends BaseModel
{
	//搜索教师获奖荣誉
    public function search($srcfrom)
    {
    	$src = [
            'fzschool_id'=>array(),
            'hjschool_id'=>array(),
            'category_id'=>array(),
            'searchval'=>''
        ];
        // 用新值替换初始值
        $src = array_cover( $srcfrom , $src ) ;

        // 整理参数
        $hjschool = $src['hjschool'];
        $fzschool = $src['fzschool'];
        $category = $src['category'];
        $searchval = $src['searchval'];

    	$data = $this
            ->order([$src['field'] =>$src['order']])
    		->when(count($fzschool)>0,function($query) use($fzschool){
                	$query->where('fzschool','in',$fzschool);
                })
    		->when(count($category)>0,function($query) use($category){
                	$query->where('category','in',$category);
                })
    		->when(strlen($searchval)>0,function($query) use($searchval){
                	$query->where('title','like','%'.$searchval.'%');
                })
            ->with(
                [
                    'fzSchool'=>function($query){
                        $query->field('id,jiancheng,jibie')
                        ->with(['dwJibie'=>function($q){
                            $q->field('id,title');
                        }]);
                    },
                    'lxCategory'=>function($query){
                        $query->field('id,title');
                    },

                ]
            )
            ->withCount(['ryInfo'=>'count'])
    		->select();


    	return $data;
    }


    // 颁奖单位关联
    public function fzSchool()
    {
         return $this->belongsTo('\app\system\model\School', 'fzschool', 'id');
    }


    // 荣誉类型关联
    public function lxCategory()
    {
         return $this->belongsTo('\app\system\model\Category', 'category', 'id');
    }


    // 荣誉信息关联
    public function ryInfo()
    {
    	return $this->hasMany('JsRongyuInfo', 'rongyuce', 'id');
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
        $value>0 ? $value = date('Y-m-d',$value) : $value = "";

        return $value;
    }



}
