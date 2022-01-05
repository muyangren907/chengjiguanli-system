<?php
namespace app\teach\model;

use app\BaseModel;

/**
 * @mixin \think\Model
 */
class FenGong extends BaseModel
{
    // 设置字段信息
    protected $schema = [
        'id' =>   'int'
        ,'banji_id' =>     'int'
        ,'subject_id' =>   'int'
        ,'teacher_id' =>   'int'
        ,'create_time' =>  'int'
        ,'update_time' =>  'int'
        ,'delete_time' =>  'int'
        ,'beizhu' =>  'varchar'
    ];


    // 按条件查询分工
    public function search($srcfrom)
    {
        // 整理变量
        $src = [
            'status' => ''
            ,'searchval' => ''
            ,'page' => 1
            ,'limit' => 10
            ,'field' => 'id'
            ,'order' => 'desc'
            ,'all' => false
        ];
        $src = array_cover($srcfrom, $src);

        // 查询数据
        $data = $this
            ->when(strlen($src['searchval']) > 0, function($query) use($src){
                $query->where('title|jiancheng', 'like', '%' . $src['searchval'] . '%');
            })
            ->with([
                'sbjCategory' => function($query){
                    $query->field('id, title');
                }
            ])
            ->when($src['all'] == false, function ($query) use($src) {
                $query
                    ->page($src['page'], $src['limit']);
            })
            ->order([$src['field'] => $src['order']])
            ->select();
        return $data;
    }


    // 大类别关联
    public function sbjXueqi()
    {
        return $this->belongsTo(\app\system\model\Category::class, 'category_id', 'id');
    }
}
