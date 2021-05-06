<?php

namespace app\teach\model;

use app\BaseModel;


/**
 * @mixin \think\Model
 */
class Jiaoyanzu extends BaseModel
{
    // 分类关联
    public function glCategory()
    {
        return $this->belongsTo('\app\system\model\Category', 'category_id', 'id');
    }


    // 根据条件查询教研组
    public function search($srcfrom)
    {
        // 整理变量
        $src = [
            'category_id' => ''
            ,'searchval' => ''
            ,'status' => ''
        ];
        $src = array_cover($srcfrom, $src) ;

        // 查询数据
        $data = $this
            ->when(strlen($src['searchval']) > 0, function($query) use($src){
                    $query->where('title|xuenian', 'like', '%' . $src['searchval'] . '%');
                })
            ->when(strlen($src['category_id']) > 0, function($query) use($src){
                    $query->where('category_id', $src['category_id']);
                })
            ->when(strlen($src['status']) > 0, function($query) use($src){
                    $query->where('status', $src['status']);
                })
            ->with(
                [
                    'glCategory'=>function($query){
                        $query->field('id, title');
                    },
                ]
            )
            ->select();

        return $data;
    }
}
