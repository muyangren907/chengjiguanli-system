<?php

namespace app\admin\model;

// 引用用户数据模型
use app\common\model\Base;

class AuthGroup extends Base
{
    // 查询所有角色
    public function search($src)
    {
        // 整理变量
        $searchval = $src['searchval'];

        // 查询数据
        $data = $this
            ->order([$src['field'] =>$src['type']])
            ->when(strlen($searchval)>0,function($query) use($searchval){
                    $query->where('title','like','%'.$searchval.'%');
                })
            ->select();
        return $data;
    }
    
}
