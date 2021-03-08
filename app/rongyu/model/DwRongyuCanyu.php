<?php

namespace app\rongyu\model;

// 引用数据模型基类
use app\BaseModel;

class DwRongyuCanyu extends BaseModel
{
    // 关闭全局自动时间戳
    protected $autoWriteTimestamp = false;


    // 荣誉册关联
    public function rongyu()
    {
    	return $this->belongsTo('\app\rongyu\model\DwRongyu', 'rongyu_id', 'id');
    }


    // 教师关联
    public function teacher()
    {
    	return $this->belongsTo('\app\admin\model\Admin', 'teacher_id', 'id');
    }

    //搜索课题册
    public function searchCanyu($srcfrom)
    {
        $src = [
            'rongyu_id' => ''
        ];
        $src = array_cover($srcfrom, $src);

        $list = $this
            ->where('rongyu_id', $src['rongyu_id'])
            ->with(
                [
                    'teacher' => function($query){
                        $query->field('id, xingming, school_id')
                            ->with([
                                'adSchool' => function ($q) {
                                    $q->field('id, jiancheng');
                                }
                            ]);
                    },
                    'rongyu' => function($query){
                        $query->field('id, title');
                    },
                ]
            )
            ->select();
        return $list;
    }

}
