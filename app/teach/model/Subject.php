<?php

namespace app\teach\model;

use app\BaseModel;

class Subject extends BaseModel
{
    // 设置字段信息
    protected $schema = [
        'id' => 'int'
        ,'title' => 'varchar'
        ,'jiancheng' => 'varchar'
        ,'lieming' => 'varchar'
        ,'category_id' => 'int'
        ,'kaoshi' => 'tinyint'
        ,'paixu' => 'int'
        ,'status' => 'tinyint'
        ,'create_time' => 'int'
        ,'update_time' => 'int'
        ,'delete_time' => 'int'
    ];


    // 按条件查询学科
    public function search($srcfrom)
    {
        // 整理变量
        $src = [
            'status' => ''
            ,'kaoshi' => ''
            ,'delete_time' => ''
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
            ->withTrashed()
            ->when(strlen($src['searchval']) > 0, function($query) use($src){
                $query->where('title|jiancheng', 'like', '%' . $src['searchval'] . '%');
            })
            ->when(strlen($src['kaoshi']) > 0, function($query) use($src){
                $query->where('kaoshi', $src['kaoshi']);
            })
            ->when(strlen($src['status']) > 0, function($query) use($src){
                $query->where('status', $src['status']);
            })
            ->when(strlen($src['delete_time']) > 0, function($query){
                $query->whereNotNull('delete_time');
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


    // 查询列名是否唯一
    public function onlyLeiming($srcfrom)
    {
        // 初始值
        $src = [
            'searchval' => ''
            ,'id' => ''
        ];
        $src = array_cover($srcfrom, $src);

        $list = $this::withTrashed()
            ->where('lieming', $src['searchval'])
            ->find();
        $data = ['msg' => '列标识已经存在！', 'val' => 0];

        if($list)
        {
            if($src['id'] == $list->id){
                $data = ['msg' => '', 'val' => 1];
            }
        }else{
           $data = ['msg' => '', 'val' => 1];
        }
    }


    // 大类别关联
    public function sbjCategory()
	{
		return $this->belongsTo(\app\system\model\Category::class, 'category_id', 'id');
	}
}
