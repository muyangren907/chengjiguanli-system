<?php

namespace app\chengji\model;

// 引用基类
use app\common\model\Base;


class Chengji extends Base
{
   
    // 成绩和学科关联
    public function cjSubject()
    {
    	return $this->belongsTo('\app\teach\model\Subject');
    }

    // 数据筛选
    public function search($src)
    {
        // 获取参数
        $kaoshi = $src['kaoshi'];
        // $banji = $src['banji'];
        $searchval = $src['searchval'];


        $data = $this
                ->order([$src['field'] =>$src['order']])
                // ->when(count($school)>0,function($query) use($school){
                //     $query->where('school','in',$school);
                // })
                ->when(strlen($searchval)>0,function($query) use($searchval){
                        $query->where('xingming','like','%'.$searchval.'%')->field('id');
                })
                // ->append(['age'])
                ->select();

        return $data;
    }


    // 学科关联
    public function subjectName()
    {
        return $this->belongsTo('\app\teach\model\Subject','subject_id','id');
    }



	
}
