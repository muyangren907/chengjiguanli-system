<?php

namespace app\rongyu\model;

// 引用数据模型类
use app\BaseModel;

class JsRongyuCanyu extends BaseModel
{

    // 荣誉册关联
    public function rongyu()
    {
    	return $this->belongsTo('\app\rongyu\model\JsRongyu', 'rongyu_id', 'id');
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
            ,'category_id' => ''
        ];
        $src = array_cover($srcfrom, $src);

        $list = $this
            ->where('rongyu_id', $src['rongyu_id'])
            ->where('category_id', $src['category_id'])
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
