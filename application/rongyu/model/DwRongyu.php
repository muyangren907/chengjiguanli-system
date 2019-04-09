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
    		->when(strlen($hjschool)>0,function($query) use($hjschool){
                	$query->where('hjschool','in',$hjschool);
                })
    		->when(strlen($fzschool)>0,function($query) use($fzschool){
                	$query->where('fzschool','in',$fzschool);
                })
    		->when(strlen($category)>0,function($query) use($category){
                	$query->where('category','in',$category);
                })
    		->when(strlen($search)>0,function($query) use($search){
                	$query->where('title','like',$search);
                })
            ->with(
                [
                    'hjSchool'=>function($query){
                        $query->field('id,jiancheng');
                    },
                    'fzSchool'=>function($query){
                        $query->field('id,jiancheng');
                    },
                    'lxCategory'=>function($query){
                        $query->field('id,title');
                    },
                    'jxCategory'=>function($query){
                        $query->field('id,title');
                    }
                ]
            )
            ->append(['jibie'])
    		->select();


    	return $data;
    }


    // 获奖单位关联
    public function hjSchool()
    {
         return $this->belongsTo('\app\system\model\School','hjschool','id');
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

    // 奖项
    public function jxCategory()
    {
         return $this->belongsTo('\app\system\model\Category','category','id');
    }

    // 参与人
    public function cyDwry()
    {
        return $this->hasMany('\app\rongyu\model\DwRongyuCanyu','rongyuid','id');
    }

    // 荣誉级别
    public function getJibieAttr()
    {
        $jibie = '';

        if($this->fzschool){
            $jibie = $this->fzSchool->jibie;
        }
        
         return $jibie;   
    }


    // 发证时间修改器
    public function setFzshijianAttr($value)
    {
        return strtotime($value);
    }

    // 发证时间获取器
    public function getFzshijianAttr($value)
    {
        // 判断发证时间是否为空
        if ($value>0)
        {
            $value = date('Y-m-d',$value);
        }else{
            $value = "";
        }

        // 返回发证时间
        return $value;
    }

}