<?php

namespace app\system\model;

use app\common\model\Base;

class Category extends Base
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
    public function search($src)
    {
        // 整理变量
        // $xingzhi = $src['xingzhi'];

        // 查询数据
        $data = $this
            ->order([$src['field'] =>$src['order']])
            // ->when(strlen($src['xingzhi'])>0,function($query) use($xingzhi){
            //         $query->where('xingzhi','in',$xingzhi);
            //     })
            // ->when(strlen($search)>0,function($query) use($search){
            //         $query->where('title|jiancheng','like',$search);
            //     })
            // ->when(strlen($search)>0,function($query) use($search){
            //         $query->where('title|jiancheng','like',$search);
            //     })
            ->with(
                [
                    'glPid'=>function($query){
                        $query->field('id,title');
                    }
                ]
            )
            ->page($src['page'],$src['limit'])
            ->select();


        return $data;
    }
}
