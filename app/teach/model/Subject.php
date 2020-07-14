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
            ,'searchval' => ''
        ];
        $src = array_cover($srcfrom, $src) ;

        // 查询数据
        $data = $this
            ->when(strlen($src['searchval']) > 0, function($query) use($src){
                $query->where('title|jiancheng', 'like', '%' . $src['searchval'] . '%');
            })
            ->when(strlen($src['kaoshi']) > 0, function($query) use($src){
                $query->where('kaoshi', $src['kaoshi']);
            })
            ->when(strlen($src['status']) > 0, function($query) use($src){
                $query->where('status', $src['status']);
            })
            ->with([
            	'sbjCategory' => function($query){
            		$query->field('id, title');
            	}
            ])
            ->select();
        return $data;
    }

    // 获取参加考试的学科
    public function kaoshi()
    {
        $data = self::where('kaoshi', 1)
                ->field('id, title, jiancheng, lieming')
                ->order(['paixu'=>'asc'])
                ->select();

        return $data;
    }

    // 大类别关联
    public function sbjCategory()
	{
		return $this->belongsTo('\app\system\model\Category', 'category_id', 'id');
	}
}
