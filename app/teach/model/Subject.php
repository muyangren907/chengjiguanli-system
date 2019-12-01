<?php

namespace app\teach\model;

use app\common\model\Base;

class Subject extends Base
{
    // 查询所有单位
    public function search($src)
    {
        // 整理变量
        $searchval = $src['searchval'];

        // 查询数据
        $data = $this
            ->order([$src['field'] =>$src['type']])
            ->when(strlen($searchval)>0,function($query) use($searchval){
                    $query->where('title|jiancheng','like','%'.$searchval.'%');
                })
            ->with([
            	'sujCategory'=>function($query){
            		$query->field('id,title');
            	}
            ])
            ->select();
        return $data;
    }

    // 大类别关联
    public function sujCategory()
	{
		return $this->belongsTo('\app\system\model\Category','category','id');
	}


    // 是否参加考试获取器
    public function getKaoshiAttr($value){
        $kaoshi = array(0=>'否',1=>'是');
        return $kaoshi[$value];
    }	
}
