<?php
// 命令空间
namespace app\kaoshi\model;

// 引用数据模型基类
use app\common\model\Base;

class Kaohao extends Base
{
    /**  
    * 根据班级ID查询参加当前考试的学生信息 
    * 
    * @access public 
    * @param mixed $kaoshi 当前考试ID 
    * @param array $banji 学生所在班级 
    * @return array 返回类型
    */  
    public function srcKaohao($kaoshi,$banji)
    {
        // 获取考试标签
        $data = $this->where('kaoshi',$kaoshi)
                    ->where('banji','in',$banji)
                    ->field('id,banji,school')
                    ->order(['banji'])
                    ->group('banji')
                    ->with([
                        'cjBanji'=>function($query){
                            $query->field('id,paixu,ruxuenian')
                                ->append(['numTitle','banjiTitle']);
                        }
                        ,'cjSchool'=>function($query){
                            $query->field('id,jiancheng');
                        }
                        ,'banjiKaohao'=>function($query) use($kaoshi){
                            $query->field('id,banji,student,kaoshi,school')
                                ->where('kaoshi',$kaoshi)
                                ->order(['banji','id'])
                                ->with([
                                    'cjStudent'=>function($q){
                                        $q->field('id,xingming');
                                    }
                            ]);
                        }
                    ])
                    ->select();
        return $data;
    }


    /**  
    * 以考号为基础查询学生成绩并排序 
    * @access public 
    * @param array $src 参数数组 
    * @param number $src['school'] 学生所在学校
    * @param number $src['nianji'] 学生所在年级 
    * @param number $src['paixu'] 班级标识 
    * @param number $src['searchval'] 关键字
    * @param number $src['field'] 排序字段
    * @param number $src['type'] 排序类型
    * @return array 返回类型
    */
    public function srcChengji($src)
    {
        $school = $src['school'];
        $nianji = $src['nianji'];
        $paixu = $src['paixu'];
        $seachval = $src['searchval'];


        $khlist = $this->where('kaoshi',$src['kaoshi'])
                ->field('id,school,student,nianji,banji')
                ->when(count($school)>0,function($query) use($school){
                    $query->where('school','in',$school);
                })
                ->when(count($paixu)>0,function($query) use($paixu){
                    $query->where('banji','in',function($q) use($paixu){
                        $q->name('banji')->where('paixu','in',$paixu)->field('id');
                    });
                })
                ->when(count($nianji)>0,function($query) use($nianji){
                    $query->where('nianji','in',$nianji);
                })
                ->when(strlen($seachval)>0,function($query) use($seachval){
                    $query->where(function($w) use ($seachval){
                        $w->whereOr('id',$seachval)
                        ->whereOr('student','in',function($q)use($seachval){
                            $q->name('student')->where('xingming','like','%'.$seachval.'%')->field('id');
                        });
                    });
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
        if($khlist->isEmpty())
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

        // 整理数据
        $data = array();
        foreach ($khlist as $key => $value) {
            $data[$key]['id'] = $value->id;
            $data[$key]['school'] = $value->cj_school->jiancheng;
            $data[$key]['student'] = $value->cj_student->xingming;
            $data[$key]['nianji'] = $value->nianji;
            $data[$key]['banji'] = $value->cj_banji->num_title;
            $dfsum = 0;
            $sbjcnt = 0;
            foreach ($value->ks_chengji as $k => $val) {
                $data[$key][$xk[$val->subject_id]] = $val->defen*1;
                $dfsum = $dfsum + $val->defen*1;
                $sbjcnt ++;
            }
            $data[$key]['sum'] = $dfsum;
            if($sbjcnt>0){
                $data[$key]['avg'] = round($dfsum/$sbjcnt,1);
            }else{
                $data[$key]['avg'] = 0;
            }
        }


        // 按条件排序
        if(count($data)>0){
            $data = arraySequence($data,$src['field'],$src['type']); //排序
        }


        return $data;
    }

    

    // 满分
    public function banjiKaohao()
    {
        return $this->hasMany('\app\kaoshi\model\Kaohao','banji','banji');
    }

    // 学校信息关联表
    public function cjSchool()
    {
    	return $this->belongsTo('\app\system\model\School','school','id');
    }

    // 班级信息关联表
    public function cjBanji()
    {
    	return $this->belongsTo('\app\teach\model\Banji','banji','id');
    }

    // 学生信息关联
    public function cjStudent()
    {
    	return $this->belongsTo('\app\renshi\model\Student','student','id');
    }

    // 满分
    public function cjManfen()
    {
    	return $this->hasMany('\app\kaoshi\model\KaoshiSubject','kaoshiid','kaoshi');
    }

    // 考试关联
    public function cjKaoshi()
    {
    	return $this->belongsTo('\app\kaoshi\model\Kaoshi','kaoshi','id');
    }


    // 考试成绩
    public function ksChengji()
    {
        return $this->hasMany('\app\chengji\model\Chengji','kaohao_id','id');
    }
}
