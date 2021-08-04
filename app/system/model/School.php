<?php

namespace app\system\model;

use app\BaseModel;

class School extends BaseModel
{

    // 教师数据模型关联
    public function dwAdmin()
    {
        return $this->hasMany(\app\admin\model\Admin::class, 'school_id', 'id');
    }

    // 单位性质数据模型关联
    public function  dwXingzhi()
    {
        return $this->belongsTo(\app\system\model\Category::class, 'xingzhi_id', 'id');
    }


    // 单位级别数模型关联
    public function  dwJibie()
    {
        return $this->belongsTo(\app\system\model\Category::class, 'jibie_id', 'id');
    }


    // 单位学段数模型关联
    public function  dwXueduan()
    {
        return $this->belongsTo(\app\system\model\Category::class, 'xueduan_id', 'id');
    }


    // 考试获取器
    public function getKaoshiAttr($value)
    {
        $sex = [
            '0' => '不能'
            ,'1' => '能'
        ];

        $str = '';
        if(isset($sex[$value]))
        {
            $str = $sex[$value];
        }else{
            $str = '未知';
        }
        return $str;
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
            ,'page' => 1
            ,'limit' => 10
            ,'field' => 'id'
            ,'order' => 'desc'
            ,'cnt' => false
        ];
        $src = array_cover($srcfrom, $src);
        $src['jibie_id'] = str_to_array($src['jibie_id']);
        $src['xingzhi_id'] = str_to_array($src['xingzhi_id']);
        $src['xueduan_id'] = str_to_array($src['xueduan_id']);

        // 实例化类别数据模型
        $cat = new \app\system\model\Category;
        $paixuList = $cat->where('p_id', 102)
            ->where('status', 1)
            ->order(['paixu'=>'asc'])
            ->field('id, title, paixu')
            ->column(['id']);
        $paixuList = implode('\', \'', $paixuList);

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
            ->when($src['cnt'] == false, function ($query) use($src) {
                $query
                    ->page($src['page'], $src['limit'])
                    ->order([$src['field'] => $src['order']]);
            })
            ->orderRaw("field(jibie_id, $paixuList)")
            // ->orderRaw("field(name,'thinkphp','onethink','kancloud')")
            // ->fetchSql(true)
            ->select();

        return $data;
    }


    // 根据是否能组织考试查询单位
    public function kaoshi($src)
    {
        // 整理参数
        $src = [
            'page' => '1'
            ,'limit' => '10'
            ,'field' => 'jibie_id'
            ,'order' => 'asc'
            ,'all'=> false
        ];
        $src = array_cover($srcfrom, $src);


        $data = $this->where('kaoshi&&status', 1)
            ->where('status', 1)
            ->order(['jibie_id', 'paixu'])
            ->field('id, title, jiancheng, jibie_id')
            ->when($src['all'] == false, function($query) {
                $query
                    ->page($src['page'], $src['limit'])
                    ->order([$src['field'] => $src['order']]);
            })
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
            ,'page' => 1
            ,'limit' => 10
            ,'field' => 'id'
            ,'order' => 'asc'
            ,'cnt' => false
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
