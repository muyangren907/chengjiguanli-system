<?php

namespace app\system\model;

use app\BaseModel;

class Category extends BaseModel
{
	// 关闭全局自动时间戳
    protected $autoWriteTimestamp = false;

    // 父级类型关联
    public function glPid()
    {
    	return $this->belongsTo('Category','pid','id');
    }


    // 子类型关联
    public function glCid()
    {
        return $this->hasMany('Category','pid','id');
    }


    // 查询所有类别
    public function search($srcfrom)
    {
        $src = [
            'field'=>'id',
            'order'=>'asc',
            'pid'=>'',
            'searchval'=>''
        ];

        // 用新值替换初始值
        $src = array_cover( $srcfrom , $src ) ;

        // 整理变量
        $pid = $src['pid'];
        $searchval = $src['searchval'];

        // 查询数据
        $data = $this
            ->order([$src['field'] =>$src['order']])
            ->when(strlen($pid)>0,function($query) use($pid){
                    $query->whereOr('pid','in',$pid);
                })
            ->when(strlen($searchval)>0,function($query) use($searchval){
                    $query->where('title','like','%'.$searchval.'%');
                })
            ->with(
                [
                    'glPid'=>function($query){
                        $query->field('id,title');
                    }
                ]
            )
            ->cache(true,60)
            ->select();
        return $data;
    }
}