<?php

namespace app\rongyu\model;

// 引用数据模型基类
use app\common\model\Base;

class JsRongyuInfo extends Base
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
    		// ->when(!empty($fzschool),function($query) use($fzschool){
      //           	$query->where('fzschool','in',$fzschool);
      //           })
    		->when(!empty($category),function($query) use($category){
                	$query->where('category','in',$category);
                })
    		->when(!empty($search),function($query) use($search){
                	$query->where('title','like',$search);
                })
            ->with(
                [
                    'hjSchool'=>function($query){
                        $query->field('id,jiancheng');
                    },
                    // 'fzSchool'=>function($query){
                    //     $query->field('id,jiancheng');
                    // },
                    'rySubject'=>function($query){
                        $query->field('id,title');
                    },
                    'jxCategory'=>function($query){
                        $query->field('id,title');
                    },
                    'ryTuce'=>function($query){
                        $query->field('id,title');
                    }
                ]
            )
            // ->append(['jibie'])
    		->select();


    	return $data;
    }


    // 荣誉图册关联
    public function ryTuce()
    {
        return $this->belongsTo('\app\rongyu\model\JsRongyu','rongyuce','id');
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

    // 荣誉所属学科
    public function rySubject()
    {
         return $this->belongsTo('\app\teach\model\Subject','subject','id');
    }

    // 奖项
    public function jxCategory()
    {
         return $this->belongsTo('\app\system\model\Category','jiangxiang','id');
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
    public function setHjshijianAttr($value)
    {
        return strtotime($value);
    }

    // 发证时间获取器
    public function getHjshijianAttr($value)
    {
        if ($value>0)
        {
            $value = date('Y-m-d',$value);
        }
        return $value;
    }
}
