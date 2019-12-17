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
    public function list($srcfrom)
    {

        // 初始化参数 
        $src = array(
            'page'=>'1',
            'limit'=>'10',
            'field'=>'banji',
            'type'=>'desc',
            'kaoshi'=>'',
            'school'=>array(),
            'ruxuenian'=>'',
            'banji'=>array(),
            'searchval'=>''
        );

        // 用新值替换初始值
        $src = array_cover( $srcfrom , $src ) ;



        // 实例化考号数据模型
        $kh = new \app\kaoshi\model\Kaohao;

        // 以考号为基础查询成绩
        $chengjilist = $kh->srcChengji($src);

        // 成绩整理
        if($chengjilist->isEmpty())
        {
            return $data = array();
        }


        // 获取参考学科
        $kaoshi = new \app\kaoshi\model\Kaoshi;
        $ksinfo = $kaoshi->where('id',$src['kaoshi'])
                    ->with([
                        'ksSubject'=>function($query){
                            $query->field('kaoshiid,subjectid,lieming');
                        }
                    ])
                    ->find();

        if($ksinfo->ks_subject->isEmpty())
        {
            return $data = array();
        }

        $xk = array();
        foreach ($ksinfo->ks_subject as $key => $value) {
            $xk[$value->subjectid] = $value->lieming;
        }

        $bjlist = banjinamelist();

        // 实例化学生数据模型
        $stu = new \app\renshi\model\Student;


        // 整理数据
        $data = array();
        foreach ($chengjilist as $key => $value) {
            $data[$key]['id'] = $value->id;
            $data[$key]['school'] = $value->cj_school->jiancheng;
            if($value->cj_student != Null){
                $data[$key]['student'] = $value->cj_student->xingming;
                $data[$key]['sex'] = $value->cj_student->sex;
            }else{
                $stuinfo = $stu::withTrashed()
                        ->where('id',$value->student)
                        ->field('id,xingming,sex')
                        ->find();
                $data[$key]['student'] = $stuinfo->xingming;
                $data[$key]['sex'] = $stuinfo->sex;
            }
            // $data[$key]['nianji'] = $value->nianji;
            $data[$key]['banji'] = $value->banjiTitle;
            $dfsum = 0;
            $sbjcnt = 0;

            $cjarr = $this->zzcj($value->ks_chengji);

             // 初始化参数
            $dfsum = 0;
            $sbjcnt = 0;

            foreach ($xk as $k => $val) {
                // 设置总分的初始值
                $dfsum = null;
                // 为每个学科赋值并记录学科数
                if(array_key_exists($k,$cjarr))
                {
                    $data[$key][$val]=$cjarr[$k] * 1;
                    $sbjcnt++;
                    $dfsum = $dfsum + $data[$key][$val];
                }else{
                    $data[$key][$val]= null;
                }
            }



            $data[$key]['sum'] = $dfsum;
            if($sbjcnt>0){
                $data[$key]['avg'] = round($dfsum/$sbjcnt,1);
            }else{
                $data[$key]['avg'] = null;
            }
        }


        // 按条件排序
        if(count($data)>0){
            $data = arraySequence($data,$src['field'],$src['type']); //排序
        }

        return $data;

    }





    // 列出要统计的学生成绩
    public function search($srcfrom)
    {

        // 初始化参数 
        $src = array(
            'page'=>'1',
            'limit'=>'10',
            'field'=>'banji',
            'type'=>'desc',
            'kaoshi'=>'',
            'school'=>array(),
            'ruxuenian'=>'',
            'banji'=>array(),
            'searchval'=>''
        );

        // 用新值替换初始值
        $src = array_cover( $srcfrom , $src ) ;



        // 实例化考号数据模型
        $kh = new \app\kaoshi\model\Kaohao;

        // 以考号为基础查询成绩
        $chengjilist = $kh->srcChengji($src);

        // 成绩整理
        if($chengjilist->isEmpty())
        {
            return $data = array();
        }


        // 获取参考学科
        $kaoshi = new \app\kaoshi\model\Kaoshi;
        $ksinfo = $kaoshi->where('id',$src['kaoshi'])
                    ->with([
                        'ksSubject'=>function($query){
                            $query->field('kaoshiid,subjectid,lieming');
                        }
                    ])
                    ->find();

        if($ksinfo->ks_subject->isEmpty())
        {
            return $data = array();
        }

        $xk = array();
        foreach ($ksinfo->ks_subject as $key => $value) {
            $xk[$value->subjectid] = $value->lieming;
        }

        $bjlist = banjinamelist();

        // 实例化学生数据模型
        $stu = new \app\renshi\model\Student;


        // 整理数据
        $data = array();
        foreach ($chengjilist as $key => $value) {
            $data[$key]['id'] = $value->id;
            $data[$key]['school'] = $value->cj_school->jiancheng;
            if($value->cj_student != Null){
                $data[$key]['student'] = $value->cj_student->xingming;
                $data[$key]['sex'] = $value->cj_student->sex;
            }else{
                $stuinfo = $stu::withTrashed()
                        ->where('id',$value->student)
                        ->field('id,xingming,sex')
                        ->find();
                $data[$key]['student'] = $stuinfo->xingming;
                $data[$key]['sex'] = $stuinfo->sex;
            }
            // $data[$key]['nianji'] = $value->nianji;
            $data[$key]['banji'] = $value->banjiTitle;
            $dfsum = 0;
            $sbjcnt = 0;

            $cjarr = $this->zzcj($value->ks_chengji);

             // 初始化参数
            $dfsum = 0;
            $sbjcnt = 0;

            foreach ($xk as $k => $val) {
                // 设置总分的初始值
                $dfsum = null;
                // 为每个学科赋值并记录学科数
                if(array_key_exists($k,$cjarr))
                {
                    $data[$key][$val]=$cjarr[$k] * 1;
                    $sbjcnt++;
                    $dfsum = $dfsum + $data[$key][$val];
                }else{
                    $data[$key][$val]= null;
                }
            }



            $data[$key]['sum'] = $dfsum;
            if($sbjcnt>0){
                $data[$key]['avg'] = round($dfsum/$sbjcnt,1);
            }else{
                $data[$key]['avg'] = null;
            }
        }


        // 按条件排序
        if(count($data)>0){
            $data = arraySequence($data,$src['field'],$src['type']); //排序
        }

        return $data;

    }




    // 转置成绩数组
    private function zzcj($array = array())
    {
        
        $arr = array();
        foreach ($array as $key => $value) {
            $arr[$value['subject_id']] = $value['defen'];
        }
        return $arr;
    }
	
}
