<?php

namespace app\teach\model;

use app\BaseModel;

class Subject extends BaseModel
{
    // 按条件查询学科
    public function search($srcfrom)
    {
        // 整理变量
        $src = [
            'status' => ''
            ,'kaoshi' => ''
            ,'delete_time' => ''
            ,'searchval' => ''
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
            ->select();
        return $data;
    }


    // 大类别关联
    public function sbjCategory()
	{
		return $this->belongsTo('\app\system\model\Category', 'category_id', 'id');
	}
}
