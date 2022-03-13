<?php
declare (strict_types = 1);

namespace app\composer\model;

use app\BaseModel;

/**
 * @mixin \think\Model
 */
class Composer extends BaseModel
{
    // 设置字段信息
    protected $schema = [
        'id' => 'int'
        ,'xinghao' => 'varchar'
        ,'xuliehao' => 'varchar'
        ,'mac' => 'varchar'
        ,'create_time' => 'int'
        ,'update_time' => 'int'
        ,'delete_time' => 'int'
    ];


    // 根据条件查询学期
    public function search($srcfrom)
    {
        // 整理变量
        $src = [
            'page' => 1
            ,'limit' => 10
            ,'field' => 'id'
            ,'order' => 'desc'
            ,'all' => false
        ];
        $src = array_cover($srcfrom, $src) ;

        // 查询数据
        $data = $this
            ->where('id', '>', 0)
            ->with(
                [
                    'glInfo'=>function($query){
                        $query->field('id, title');
                    },
                ]
            )
            ->when($src['all'] == false, function ($query) use($src) {
                $query
                    ->page($src['page'] * 1, $src['limit'] * 1);
            })
            ->order([$src['field'] => $src['order']])
            ->select();

        return $data;
    }


    // 分类关联
    public function glInfo()
    {
        return $this->belongsTo(\app\composer\model\ComposerInfo::class, 'composer_id', 'id');
    }

}
