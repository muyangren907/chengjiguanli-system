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

    // 学科关联
    public function subjectName()
    {
        return $this->belongsTo('\app\teach\model\Subject','subject_id','id');
    }

    // 学科关联
    public function userName()
    {
        return $this->belongsTo('\app\admin\model\Admin','user_id','id');
    }


    // 列出要显示的学生成绩
    public function search($srcfrom)
    {

        // 初始化参数
        $src = array(
            'page'=>'1',
            'limit'=>'10',
            'field'=>'banji',
            'type'=>'desc',
            'kaoshi'=>'',
            'banji'=>array(),
            'searchval'=>''
        );

        // 用新值替换初始值
        $src = array_cover( $srcfrom , $src ) ;

        // 实例化考号数据模型
        $kh = new \app\kaoshi\model\Kaohao;

        // 以考号为基础查询成绩
        $chengjilist = $kh->srcChengji($src);

        // 按条件排序
        if(count($chengjilist)>0){
            $chengjilist = arraySequence($chengjilist,$src['field'],$src['type']); //排序
        }

        return $chengjilist;

    }






    
	
}
