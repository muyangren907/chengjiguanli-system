<?php

namespace app\teach\model;

use app\BaseModel;


class Xueqi extends BaseModel
{
     // 开始时间修改器
    public function setBfdateAttr($value)
    {
        return strtotime($value);
    }

    // 开始时间获取器
    public function getBfdateAttr($value)
    {
        return date('Y-m-d', $value);
    }

    // 结束时间修改器
    public function setEnddateAttr($value)
    {
        return strtotime($value);
    }

    // 结束时间获取器
    public function getEnddateAttr($value)
    {
        return date('Y-m-d', $value);
    }

    // 分类关联
    public function glCategory()
    {
        return $this->belongsTo('\app\system\model\Category', 'category_id', 'id');
    }

    // 根据条件查询学期
    public function search($srcfrom)
    {
        // 整理变量
        $src = [
            'category' => ''
            ,'searchval' => ''
            ,'status' => ''
            ,'bfdate' => ''
            ,'enddate' => ''
        ];
        $src = array_cover($srcfrom, $src) ;
        if(isset($srcfrom['bfdate']) && strlen($srcfrom['bfdate']) > 0)
        {
            $src['bfdate'] = $srcfrom['bfdate'];
        }else{
            $src['bfdate'] = date("Y-m-d", strtotime("-4 year"));
        }
        if(isset($srcfrom['enddate']) && strlen($srcfrom['enddate']) > 0)
        {
            $src['enddate'] = $srcfrom['enddate'];
        }else{
            $src['enddate'] = date("Y-m-d", strtotime("+10 year"));
        }

        // 查询数据
        $data = $this
            ->whereTime('bfdate|enddate', 'between', [$src['bfdate'], $src['enddate']])
            ->when(strlen($src['searchval']) > 0, function($query) use($src){
                    $query->where('title|xuenian', 'like', '%' . $src['searchval'] . '%');
                })
            ->when(strlen($src['category']) > 0, function($query) use($src){
                    $query->where('category', $src['category']);
                })
            ->when(strlen($src['status']) > 0, function($query) use($src){
                    $query->where('status', $src['status']);
                })
            ->with(
                [
                    'glCategory'=>function($query){
                        $query->field('id, title');
                    },
                ]
            )
            ->select();

        return $data;
    }
}
