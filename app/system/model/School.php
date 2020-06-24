<?php

namespace app\system\model;

use app\BaseModel;

class School extends BaseModel
{

    // 教师数据模型关联
    public function dwTeacher()
    {
        return $this->hasMany('\app\teacher\model\Teacher', 'danwei_id', 'id');
    }

    // 单位性质数据模型关联
    public function  dwXingzhi()
    {
        return $this->belongsTo('\app\system\model\Category', 'xingzhi_id', 'id');
    }


    // 单位级别数模型关联
    public function  dwJibie()
    {
        return $this->belongsTo('\app\system\model\Category', 'jibie_id', 'id');
    }


    // 单位学段数模型关联
    public function  dwXueduan()
    {
        return $this->belongsTo('\app\system\model\Category', 'xueduan_id', 'id');
    }


    // 查询所有单位
    public function search($srcfrom)
    {
        // 整理参数
        $src = [
            'jibie_id'=>array(),
            'xingzhi_id'=>array(),
            'xueduan_id'=>array(),
            'kaoshi'=>'',
            'searchval'=>''
        ];
        $src = array_cover($srcfrom, $src);
        $src['jibie_id'] = strToArray($src['jibie_id']);
        $src['xingzhi_id'] = strToArray($src['xingzhi_id']);
        $src['xueduan_id'] = strToArray($src['xueduan_id']);

        // 查询数据
        $data = $this
            ->when(count($src['xingzhi_id']) > 0, function($query) use($src){
                    $query->where('xingzhi_id', 'in', $src['xingzhi_id']);
                })
            ->when(count($src['xueduan_id']) > 0, function($query) use($src){
                    $query->where('xueduan_id', 'in', $src['xueduan_id']);
                })
            ->when(count($src['jibie_id']) > 0, function($query) use($src){
                    $query->where('jibie_id', 'in', $src['jibie_id']);
                })
            ->when(strlen($src['searchval']) > 0, function($query) use($src){
                    $query->where('title|jiancheng', 'like', '%' . $src['searchval'] . '%');
                })
            ->when(strlen($src['kaoshi']) > 0, function($query) use($src){
                    $query->where('kaoshi', $src['kaoshi']);
                })
            ->with(
                [
                    'dwXingzhi' => function($query){
                        $query->field('id, title');
                    },
                    'dwJibie' => function($query){
                        $query->field('id, title');
                    },
                    'dwXueduan' => function($query){
                        $query->field('id, title');
                    },
                ]
            )
            ->withCount(
                [
                    'dwTeacher' => function($query){
                        $query->where('status', 1);
                    }
                ]
            )
            ->select();
        return $data;
    }
}
