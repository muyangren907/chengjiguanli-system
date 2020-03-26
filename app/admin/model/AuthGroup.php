<?php

namespace app\admin\model;

// 引用用户数据模型
use app\BaseModel;

class AuthGroup extends BaseModel
{
    // 查询所有角色
    public function search($srcfrom)
    {
        // 整理变量
        $src = [
            'searchval' => ''
            ,'status' => ''
        ];
        $src = array_cover($srcfrom, $src);

        // 查询数据
        $data = $this
            ->when(strlen($src['searchval']) > 0, function($query) use($src){
                    $query->where('title', 'like', '%' . $src['searchval'] . '%');
                })
            ->select();

        return $data;
    }

}
