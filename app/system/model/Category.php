<?php

namespace app\system\model;

use app\BaseModel;

class Category extends BaseModel
{
	// 关闭全局自动时间戳
    // protected $autoWriteTimestamp = false;

    // 父级类型关联
    public function glPid()
    {
    	return $this->belongsTo('Category', 'p_id', 'id');
    }


    // 子类型关联
    public function glCid()
    {
        return $this->hasMany('Category', 'p_id', 'id');
    }


    // 查询所有类别
    public function search($srcfrom)
    {
        $src = [
            'p_id'=>''
            ,'searchval'=>''
        ];

        // 用新值替换初始值
        $src = array_cover($srcfrom, $src) ;

        // 查询数据
        $data = $this
            ->when(strlen($src['p_id']) > 0, function($query) use($src){
                    $query->whereOr('p_id', 'in', $src['p_id']);
                })
            ->when(strlen($src['searchval']) > 0, function($query) use($src){
                    $query->where('title', 'like', '%' . $src['searchval'] . '%');
                })
            ->with(
                [
                    'glPid'=>function($query){
                        $query->field('id, title');
                    }
                ]
            )
            // ->cache(true, 60)
            ->select();
        return $data;
    }

    // 查询子类别
    public function srcChild($srcfrom)
    {
        $src = [
            'p_id'=>''
        ];

        // 用新值替换初始值
        $src = array_cover($srcfrom, $src) ;
        $child = self::where('p_id', $src['p_id'])
            ->where('status', 1)
            ->select();
        return $child;
    }
}
