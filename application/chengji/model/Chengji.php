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

    // /**  
    // * 根据考试ID和班级获取学生各学科成绩、平均分、总分 
    // * 
    // * @access public 
    // * @param mixed $kaoshi 当前考试ID 
    // * @param array $banji 学生所在班级 
    // * @return array 返回类型
    // */ 
    // public function srcChengji($kaoshi=0,$banji=array())
    // {
    //     $kh = new \app\kaoshi\model\Kaohao;
    //     $khlist = $kh->where('kaoshi',$kaoshi)
    //             ->field('id,school,student,nianji,banji')
    //             ->when(count($banji)>0,function($query) use($banji){
    //                 $query->where('banji','in',$banji);
    //             })
    //             ->with([
    //                 'ksChengji'=>function($query){
    //                     $query->field('kaohao_id,subject_id,defen');
    //                 }
    //                 ,'cjBanji'=>function($query){
    //                     $query->field('id,paixu,ruxuenian')
    //                         ->append(['numTitle','banjiTitle']);
    //                 }
    //                 ,'cjSchool'=>function($query){
    //                     $query->field('id,jiancheng');
    //                 }
    //                 ,'cjStudent'=>function($query){
    //                     $query->field('id,xingming,sex');
    //                 }
    //             ])
    //             ->select();

                
    //     // 获取参考学科
    //     $ks = new \app\kaoshi\model\Kaoshi;
    //     $ksinfo = $ks->where('id',$kaoshi)
    //                 ->with([
    //                     'ksSubject'=>function($query){
    //                         $query->field('kaoshiid,subjectid,lieming');
    //                     }
    //                 ])
    //                 ->find();
    //     $xk = array();
    //     foreach ($ksinfo->ks_subject as $key => $value) {
    //         $xk[$value->subjectid] = $value->lieming;
    //     }


    //     // 整理数据
    //     $data = array();
    //     foreach ($khlist as $key => $value) {
    //         $data[$key]['id'] = $value->id;
    //         $data[$key]['school'] = $value->cj_school->jiancheng;
    //         if(isset($value->cj_student)){
    //             $data[$key]['student'] = $value->cj_student->xingming;
    //             $data[$key]['sex'] = $value->cj_student->sex;
    //         }else{
    //             $stu = new \app\renshi\model\Student;
    //             $stuname = $stu::withTrashed()->where('id',$value->student)->field('id,xingming,sex')->find();
    //             $data[$key]['student'] = $stuname->xingming;
    //             $data[$key]['sex'] = $stuname->sex;
    //         }
    //         $data[$key]['nianji'] = $value->nianji;
    //         $data[$key]['banji'] = $value->cj_banji->banji_title;
    //         $dfsum = 0;
    //         $sbjcnt = 0;
    //         foreach ($value->ks_chengji as $k => $val) {
    //             $data[$key][$xk[$val->subject_id]] = $val->defen*1;
    //             $dfsum = $dfsum + $val->defen*1;
    //             $sbjcnt ++;
    //         }
    //         $data[$key]['sum'] = $dfsum;
    //         if($sbjcnt>0){
    //             $data[$key]['avg'] = round($dfsum/$sbjcnt,1);
    //         }else{
    //             $data[$key]['avg'] = 0;
    //         }
    //     }

    //     // // 按条件排序
    //     // if(count($data)>0){
    //     //     $data = arraySequence($data,$src['field'],$src['type']); //排序
    //     // }
    //     return $data;
    // }


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
