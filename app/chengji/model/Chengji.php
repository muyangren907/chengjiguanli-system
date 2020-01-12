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



    // 列出已录成绩列表
    public function searchLuru($srcfrom)
    {
        // 初始化参数
        $src = array(
            'field'=>'banji',
            'type'=>'desc',
            'kaoshi'=>'0',
            'banji'=>array(),
            'subject_id'=>array(),
            'searchval'=>array(),
            'user_id'=>session('userid');
        );

        // 用新值替换初始值
        $src = array_cover( $srcfrom , $src ) ;
        $banji = strToarray($src['banji']);
        $subject_id = strToarray($src['subject_id']);
        $kaoshi = $src['kaoshi'];
        $searchval = $src['searchval'];

        // 获取参加考试时间
        $ks = new app\kaoshi\model\Kaoshi;
        $enddate = $ks->where('id',$kaoshiid)->value('enddate');

        $nianji = nianjiList($enddate);
        


        $cjList = $this
                ->where('user_id'=>$src['user_id'])
                ->when(count($subject_id)>0,function($query)use($subject_id){
                    $query->where('subjectid','in',$subject_id);
                })
                ->where('kaohao_id','in',function($query)use($banji,$kaoshi,$searchval,$nianji){
                    $query->name('kaohao')
                        ->where('kaoshi',$kaoshi)
                        ->where(count($banji)>0,function($q)use($banji){
                            $q->where('banji','in',$banji);
                        })
                        ->when(strlen($searchval>0),function($w)use($searchval,$nianji){
                            $w->name('student')
                                ->where('banji','in',function($x)use($nianji){
                                    $x->name('banji')
                                        ->where('ruxuenian','in',$nianji)
                                        ->field('id');
                                })
                                ->where('xingminng','like','%'.$searchval.'%')
                                ->field('id');
                        });
                })
                ->select();
        halt($cjList->toArray());


        return true;






    }



    // 列出要显示的学生所有学科成绩
    public function search($srcfrom)
    {

        // 初始化参数
        $src = array(
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


        $src['type'] == 'desc' ? $src['type'] =SORT_DESC :$src['type'] = SORT_ASC;

        // 按条件排序
        if(count($chengjilist)>0){
            $chengjilist = sortArrByManyField($chengjilist,$src['field'],$src['type']);
        }

        return $chengjilist;

    }
	
}
