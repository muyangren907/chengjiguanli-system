<?php

namespace app\teach\model;

use app\common\model\Base;

class Subject extends Base
{
    // 按条件查询学科
    public function search($src)
    {
        // 整理变量
        $searchval = $src['searchval'];

        // 查询数据
        $data = $this
            ->order([$src['field'] =>$src['order']])
            ->when(strlen($searchval)>0,function($query) use($searchval){
                    $query->where('title|jiancheng','like','%'.$searchval.'%');
                })
            ->with([
            	'sbjCategory'=>function($query){
            		$query->field('id,title');
            	}
            ])
            ->select();
        return $data;
    }

    // 获取参加考试的学科
    public function searchKaoshi()
    {
        $data = self::where('kaoshi',1)
                ->field('id,title,jiancheng,lieming')
                ->select();

        return $data;
    }

    // 大类别关联
    public function sbjCategory()
	{
		return $this->belongsTo('\app\system\model\Category','category','id');
	}
}
