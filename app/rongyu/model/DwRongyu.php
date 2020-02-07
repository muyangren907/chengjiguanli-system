<?php

namespace app\rongyu\model;

// 引用数据模型基类
use app\common\model\Base;

class DwRongyu extends Base
{
    //搜索单位获奖荣誉
    public function search($srcfrom)
    {
        $src = [
            'field'=>'update_time',
            'order'=>'desc',
            'fzschool'=>array(),
            'hjschool'=>array(),
            'category'=>array(),
            'searchval'=>''
        ];
        // 用新值替换初始值
        $src = array_cover( $srcfrom , $src ) ;


        // 整理变量
        $hjschool = $src['hjschool'];
        $fzschool = $src['fzschool'];
        $category = $src['category'];
        $searchval = $src['searchval'];


        // 查询数据
        $data = $this
            ->order([$src['field'] =>$src['order']])
            ->when(count($hjschool)>0,function($query) use($hjschool){
                    $query->where('hjschool','in',$hjschool);
                })
            ->when(count($fzschool)>0,function($query) use($fzschool){
                    $query->where('fzschool','in',$fzschool);
                })
            ->when(count($category)>0,function($query) use($category){
                    $query->where('category','in',$category);
                })
            ->when(strlen($searchval)>0,function($query) use($searchval){
                    $query->where('title|jiancheng','like','%'.$searchval.'%');
                })
            ->with(
                [
                    'hjSchool'=>function($query){
                        $query->field('id,jiancheng');
                    },
                    'fzSchool'=>function($query){
                        $query->field('id,jiancheng,jibie')
                            ->with([
                                'dwJibie'=>function($query){
                                    $query->field('id,title');
                                },
                            ]);
                    },
                    'lxCategory'=>function($query){
                        $query->field('id,title');
                    },
                    'jxCategory'=>function($query){
                        $query->field('id,title');
                    }
                ]
            )
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
         return $this->belongsTo('\app\system\model\Category','jiangxiang','id');
    }

    // 参与人
    public function cyDwry()
    {
        return $this->hasMany('\app\rongyu\model\DwRongyuCanyu','rongyuid','id');
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
