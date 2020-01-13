<?php

namespace app\chengji\model;

// 引用基类
use app\common\model\Base;


class Chengji extends Base
{
   

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

    // 考号关联
    public function cjKaohao()
    {
        return $this->belongsTo('\app\kaoshi\model\Kaohao','kaohao_id','id');
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
            'user_id'=>session('userid'),
        );

        // 用新值替换初始值
        $src = array_cover( $srcfrom , $src ) ;
        $banji = strToarray($src['banji']);
        $subject_id = strToarray($src['subject_id']);
        $kaoshi = $src['kaoshi'];
        $searchval = $src['searchval'];


        $nianji = nianjiList();
        $cjList = $this
                ->where('user_id',$src['user_id'])
                ->when(count($subject_id)>0,function($query)use($subject_id){
                    $query->where('subjectid','in',$subject_id);
                })
                ->with([
                    'subjectName'=>function($query){
                        $query->field('id,title,lieming');
                    }
                    ,'cjKaohao'=>function($query){
                        $query->field('id,kaoshi,school,ruxuenian,nianji,banji,paixu,student')
                            ->append(['banjiTitle'])
                            ->with([
                            'cjSchool'=>function($query){
                                $query->field('id,jiancheng,paixu');
                            }
                            ,'cjStudent'=>function($query){
                                $query->field('id,xingming,sex');
                            }
                        ]);
                    }
                ])
                ->order([$src['field']=>$src['type']])
                ->limit(200)
                ->select()
                ->toArray();

        return $cjList;
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
