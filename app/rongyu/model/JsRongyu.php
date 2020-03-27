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
        $src = array_cover($srcfrom, $src);
        $src['fzschool_id'] = strToArray($src['fzschool_id']);
        $src['hjschool_id'] = strToArray($src['hjschool_id']);
        $src['category_id'] = strToArray($src['category_id']);

    	$data = $this
    		->when(count($src['fzschool_id']) > 0, function($query) use($src){
                	$query->where('fzschool_id', 'in', $src['fzschool_id']);
                })
    		->when(count($src['category_id']) > 0, function($query) use($src){
                	$query->where('category_id', 'in', $src['category_id']);
                })
    		->when(strlen($src['searchval']) > 0, function($query) use($src){
                	$query->where('title', 'like', '%' . $src['searchval'] . '%');
                })
            ->with(
                [
                    'fzSchool' => function($query){
                        $query->field('id, jiancheng, jibie_id')
                        ->with(['dwJibie' => function($q){
                            $q->field('id, title');
                        }]);
                    },
                    'lxCategory' => function($query){
                        $query->field('id, title');
                    },

                ]
            )
            ->withCount(['ryInfo' => 'count'])
    		->select();

    	return $data;
    }


    // 颁奖单位关联
    public function fzSchool()
    {
         return $this->belongsTo('\app\system\model\School', 'fzschool_id', 'id');
    }


    // 荣誉类型关联
    public function lxCategory()
    {
         return $this->belongsTo('\app\system\model\Category', 'category_id', 'id');
    }


    // 荣誉信息关联
    public function ryInfo()
    {
    	return $this->hasMany('JsRongyuInfo', 'rongyuce_id', 'id');
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
        $value > 0 ? $value = date('Y-m-d', $value) : $value = "";

        return $value;
    }



}
