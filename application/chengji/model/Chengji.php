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

    // 查询学生成绩
    public function srcChengji($kaoshi=0,$banji=array())
    {
        $kh = new \app\kaoshi\model\Kaohao;
        $khlist = $kh->where('kaoshi',$kaoshi)
                ->field('id,school,student,nianji,banji')
                ->when(count($banji)>0,function($query) use($banji){
                    $query->where('banji','in',$banji);
                })
                ->with([
                    'ksChengji'=>function($query){
                        $query->field('kaohao_id,subject_id,defen');
                    }
                    ,'cjBanji'=>function($query){
                        $query->field('id,paixu,ruxuenian')
                            ->append(['numTitle','banjiTitle']);
                    }
                    ,'cjSchool'=>function($query){
                        $query->field('id,jiancheng');
                    }
                    ,'cjStudent'=>function($query){
                        $query->field('id,xingming');
                    }
                ])
                ->select();

                
        // 获取参考学科
        $ks = new \app\kaoshi\model\Kaoshi;
        $ksinfo = $ks->where('id',$kaoshi)
                    ->with([
                        'ksSubject'=>function($query){
                            $query->field('kaoshiid,subjectid,lieming');
                        }
                    ])
                    ->find();
        $xk = array();
        foreach ($ksinfo->ks_subject as $key => $value) {
            $xk[$value->subjectid] = $value->lieming;
        }


        // 整理数据
        $data = array();
        foreach ($khlist as $key => $value) {
            $data[$key]['id'] = $value->id;
            $data[$key]['school'] = $value->cj_school->jiancheng;
            $data[$key]['student'] = $value->cj_student->xingming;
            $data[$key]['nianji'] = $value->nianji;
            $data[$key]['banji'] = $value->cj_banji->banji_title;
            $dfcnt = 0;
            $sbjcnt = 0;
            foreach ($value->ks_chengji as $k => $val) {
                $data[$key][$xk[$val->subject_id]] = $val->defen*1;
                $dfcnt = $dfcnt + $val->defen*1;
                $sbjcnt ++;
            }
            $data[$key]['cnt'] = $dfcnt;
            if($sbjcnt>0){
                $data[$key]['avg'] = round($dfcnt/$sbjcnt,1);
            }else{
                $data[$key]['avg'] = 0;
            }
        }

        // // 按条件排序
        // if(count($data)>0){
        //     $data = arraySequence($data,$src['field'],$src['type']); //排序
        // }
        return $data;
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



	
}
