<?php

namespace app\system\model;

use app\BaseModel;

class School extends BaseModel
{

    // 教师数据模型关联
    public function dwAdmin()
    {
        return $this->hasMany('\app\admin\model\Admin', 'school_id', 'id');
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
            'jibie_id' => array()
            ,'xingzhi_id' => array()
            ,'xueduan_id' => array()
            ,'kaoshi' => ''
            ,'status' => 1
            ,'searchval' => ''
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
            ->when(strlen($src['status']) > 0, function($query) use($src){
                    $query->where('status', $src['status']);
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
                    'dwAdmin' => function($query){
                        $query->where('status', 1);
                    }
                ]
            )
            ->select();
        return $data;
    }


    // 根据是否能组织考试查询单位
    public function kaoshi()
    {
        $data = $this->where('kaoshi', 1)
            ->order(['jibie_id', 'paixu'])
            ->field('id, title, jiancheng, jibie_id')
            ->select();
        return $data;
    }


    // 根据级别查询单位
    public function srcJibie($srcfrom)
    {
        // 整理参数
        $src = [
            'low' => '班级'
            ,'high' => '其他级'
            ,'order' => 'asc'
        ];
        $src = array_cover($srcfrom, $src);

        // 实例化类别数据模型
        $cat = new \app\system\model\Category;
        $paixuList = $cat->where('p_id', 102)
            ->where('status', 1)
            ->order(['paixu'=>'asc'])
            ->field('id, title, paixu')
            ->select();

        $ids = array();
        $bf = false;
        // 取出low-high之间的类别id
        foreach ($paixuList as $key => $value) {
           // 开始
           if($src['low'] == $value->title)
           {
            $bf = true;
           }
           
           if($bf == true)
           {
            $ids[] = $value->id;
           }
           // 结束
            if($src['high'] == $value->title)
            {
             break;
            }
        }

        // 查询单位
        $schlist = $this->where('jibie_id', 'in', $ids)
            ->where('status', 1)
            ->order(['jibie_id' => $src['order'], 'paixu'])
            ->field('id, title, jiancheng')
            ->select();
        return $schlist;
    }


    // 根据学段查学校
    public function srcSchool($low = '幼儿园', $high = '其它学段', $order = 'asc')
    {
        // 实例化类别数据模型
        $cat = new \app\system\model\Category;
        $catlist = $cat->where('p_id', 103)
            ->where('status', 1)
            ->column('id', 'title');

        // 查询学校
        $schlist = $this->where('xueduan_id', 'between', [$catlist[$low], $catlist[$high]])
            ->where('status', 1)
            ->where('jibie_id', 10203)
            ->order(['xueduan_id' => $order, 'paixu'])
            ->field('id, title, jiancheng')
            ->select();

        return $schlist;
    }

}
