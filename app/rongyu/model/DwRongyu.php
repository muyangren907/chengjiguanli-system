<?php

namespace app\rongyu\model;

// 引用数据模型基类
use app\BaseModel;

class DwRongyu extends BaseModel
{
    //搜索单位获奖荣誉
    public function search($srcfrom)
    {
        // 整理变量
        $src = [
            'fzschool_id' => array()
            ,'hjschool_id' => array()
            ,'category_id' => array()
            ,'searchval' => ''
        ];
        $src = array_cover($srcfrom, $src);
        $src['fzschool_id'] = strToArray($src['fzschool_id']);
        $src['hjschool_id'] = strToArray($src['hjschool_id']);
        $src['category_id'] = strToArray($src['category_id']);

        // 查询数据
        $data = $this
            ->when(count($src['hjschool_id']) > 0, function($query) use($src){
                    $query->where('hjschool_id', 'in', $src['hjschool_id']);
                })
            ->when(count($src['fzschool_id']) > 0, function($query) use($src){
                    $query->where('fzschool_id', 'in', $src['fzschool_id']);
                })
            ->when(count($src['category_id']) > 0, function($query) use($src){
                    $query->where('category_id', 'in', $src['category_id']);
                })
            ->when(strlen($src['searchval']) > 0, function($query) use($src){
                    $query->where('title|jiancheng', 'like', '%' . $src['searchval'] . '%');
                })
            ->with(
                [
                    'hjSchool' => function($query){
                        $query->field('id, jiancheng');
                    },
                    'fzSchool' => function($query){
                        $query->field('id, jiancheng, jibie_id')
                            ->with([
                                'dwJibie' => function($query){
                                    $query->field('id, title');
                                },
                            ]);
                    },
                    'lxCategory' => function($query){
                        $query->field('id, title');
                    },
                    'jxCategory' => function($query){
                        $query->field('id, title');
                    }
                ]
            )
            ->select();
        return $data;
    }


    // 获奖单位关联
    public function hjSchool()
    {
         return $this->belongsTo('\app\system\model\School', 'hjschool_id', 'id');
    }


    // 颁奖单位关联
    public function fzSchool()
    {
         return $this->belongsTo('\app\system\model\School', 'fzschool_id', 'id');
    }


    // 荣誉类型
    public function lxCategory()
    {
         return $this->belongsTo('\app\system\model\Category', 'category_id', 'id');
    }


    // 奖项
    public function jxCategory()
    {
         return $this->belongsTo('\app\system\model\Category', 'jiangxiang_id', 'id');
    }


    // 参与人
    public function cyDwry()
    {
        return $this->hasMany('\app\rongyu\model\DwRongyuCanyu', 'rongyu_id', 'id');
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
        $value > 0 ? $value = date('Y-m-d', $value) : $value = "";

        // 返回发证时间
        return $value;
    }

}
