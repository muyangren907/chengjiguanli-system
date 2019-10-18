<?php
// 命令空间
namespace app\kaoshi\model;

// 引用数据模型基类
use app\common\model\Base;

class Kaohao extends Base
{
    /**  
    * 根据班级ID和考试ID，以班级为单位分组，查询参加当前考试的学生信息 
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

        $stu = new \app\renshi\model\Student;
        // 找出已经被删除学生，并添加该学生信息
        foreach ($data as $key => $value) {
            foreach ($value->banji_kaohao as $k => $val) {
                if($val->cj_student == Null)
                {
                    $stuinof = $stu::withTrashed()
                            ->where('id',$val->student)
                            ->field('id,xingming')
                            ->find();
                    $data[$key]->banji_kaohao[$key]->cj_student = array('id'=>$stuinof->id,'xingming'=>$stuinof->xingming);
                }
            }
        }

        return $data;
    }


    /**  
    * 以考号为基础查询学生成绩信息并排序 
    * 信息包括：学校、年级、班级、姓名、性别、各学科成绩、平均分、总分
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
    public function srcChengji($srcfrom)
    {
        // 初始化参数 
        $src = array(
            'page'=>'1',
            'limit'=>'10',
            'field'=>'banji',
            'type'=>'desc',
            'kaoshi'=>'',
            'school'=>array(),
            'nianji'=>'',
            'banji'=>array(),
            'searchval'=>''
        );
        // 用新值替换初始值
        $src = array_cover( $srcfrom , $src ) ;

        // 重新定义变量
        $school = $src['school'];
        $nianji = $src['nianji'];
        $banji = $src['banji'];
        $seachval = $src['searchval'];

        // 查询成绩
        $khlist = $this->where('kaoshi',$src['kaoshi'])
                ->field('id,school,student,nianji,banji')
                ->when(count($school)>0,function($query) use($school){
                    $query->where('school','in',$school);
                })
                ->when(count($banji)>0,function($query) use($banji){
                    $query->where('banji','in',$banji);
                })
                ->when(strlen($nianji)>0,function($query) use($nianji){
                    $query->where('ruxuenian',$nianji);
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
                        $query->field('id,paixu,ruxuenian');
                    }
                    ,'cjSchool'=>function($query){
                        $query->field('id,jiancheng');
                    }
                    ,'cjStudent'=>function($query){
                        $query->field('id,xingming,sex');
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

        $bjlist = banjinamelist();

        // 整理数据
        $data = array();
        foreach ($khlist as $key => $value) {
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
            $data[$key]['nianji'] = $value->nianji;
            $data[$key]['banji'] = $value->nianji.$bjlist[$value->cj_banji->paixu];
            $dfsum = 0;
            $sbjcnt = 0;

            $cjarr = $this->zzcj($value->ks_chengji);

             // 初始化参数
            $dfsum = 0;
            $sbjcnt = 0;

            foreach ($xk as $k => $val) {
                // 为每个学科赋值并记录学科数
                if(array_key_exists($k,$cjarr))
                {
                    $data[$key][$val]=$cjarr[$k] * 1;
                    $sbjcnt++;
                    $dfsum = $dfsum + $data[$key][$val];
                }else{
                    $data[$key][$val]='';
                }
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

    // 转置成绩数组
    private function zzcj($array = array())
    {
        
        $arr = array();
        foreach ($array as $key => $value) {
            $arr[$value['subject_id']] = $value['defen'];
        }
        return $arr;
    }

    /**  
    * 获取参加考试的学校
    * @access public 
    * @param number $kaoshi 考试id
    * @param number $ruxuenian 入学年
    * @return array 返回类型
    */
    public function cySchool($kaoshi,$ruxuenian)
    {
        $data = $this->where('ruxuenian',$ruxuenian)
                ->where('kaoshi',$kaoshi)
                ->with(['cjSchool'=>function($query){
                        $query->field('id,jiancheng');
                    }
                ])
                ->group('school')
                ->field('school')
                ->select();
        return $data;

    }


    /**  
    * 获取参加考试的班级
    * @access public 
    * @param number $kaoshi 考试id
    * @param number $ruxuenian 入学年
    * @return array 返回类型
    */
    public function cyBanji($kaoshi,$ruxuenian,$school=array(),$paixu=array())
    {
        // 获取考试时间
        $ks = new \app\kaoshi\model\Kaoshi;
        $kssj = $ks::where('id',$kaoshi)->value('bfdate');
        $year = date('Y',$kssj);


        $data = $this->where('ruxuenian',$ruxuenian)
                ->where('kaoshi',$kaoshi)
                ->when(count($school)>0,function($query) use($school){
                    $query->where('school','in',$school);
                })
                ->when(count($paixu)>0,function($query) use($paixu){
                    $query->where('banji','in',function($q)use($paixu){
                        $q->name('banji')->where('paixu','in',$paixu)->field('id');
                    });
                })
                ->with([
                    'cjBanji'=>function($query){
                        $query->field('id,paixu,ruxuenian');
                    }
                    ,'cjSchool'=>function($query){
                        $query->field('id,jiancheng');
                    }
                ])
                ->group('banji,school')
                ->field('banji,school')
                ->select();
        $njlist = nianjiList($year);
        $bjlist = banjinamelist();


        foreach ($data as $key => $value) {
            # code...
            $data[$key]['bjtitle'] = $njlist[$value->cjBanji->ruxuenian].$bjlist[$value->cjBanji->paixu];
        }

        return $data;
    }

}
