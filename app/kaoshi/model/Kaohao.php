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
                    ->field('banji,school')
                    ->order(['banji'])
                    ->group('banji,school')
                    ->with([
                        'cjBanji'
                        ,
                        'cjSchool'=>function($query){
                            $query->field('id,jiancheng');
                        }
                        ,
                        'banjiKaohao'=>function($query) use($kaoshi){
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
            foreach ($value->banjiKaohao as $k => $val) {
                if($val->cjStudent == Null)
                {
                    $stuinof = $stu::withTrashed()
                            ->where('id',$val->student)
                            ->field('id,xingming')
                            ->find();
                    $data[$key]->banjiKaohao[$key]->cjStudent = array('id'=>$stuinof->id,'xingming'=>$stuinof->xingming);
                }
            }
        }

        return $data;
    }


    /**  
    * 列出适合显示的学生成绩，
    * 以考号为基础查询学生成绩信息并排序，计划在网页上显示成绩列表中使用 
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
            'kaoshi'=>'0',
            'banji'=>array('0'),
            'searchval'=>''
        );

        // 用新值替换初始值
        $src = array_cover( $srcfrom , $src ) ;


        // 重新定义变量
        // $school = $src['school'];
        // $ruxuenian = $src['ruxuenian'];
        $banji = $src['banji'];
        $seachval = $src['searchval'];


        // 查询成绩
        $khlist = $this->where('kaoshi',$src['kaoshi'])
                ->field('id,school,student,banji,kaoshi')
                // ->when(count($school)>0,function($query) use($school){
                //     $query->where('school','in',$school);
                // })
                ->where('banji','in',$banji)
                // ->when(strlen($ruxuenian)>0,function($query) use($ruxuenian){
                //     $query->where('ruxuenian',$ruxuenian);
                // })
                ->when(strlen($seachval)>0,function($query) use($seachval){
                    $query->where(function($w) use ($seachval){
                        $w
                        // ->whereOr('id',$seachval)
                        ->whereOr('student','in',function($q)use($seachval){
                            $q->name('student')->where('xingming','like','%'.$seachval.'%')->field('id');
                        });
                    });
                })
                ->with([
                    'ksChengji'=>function($query){
                        $query->field('kaohao_id,subject_id,defen');
                    }
                    ,'cjSchool'=>function($query){
                        $query->field('id,jiancheng');
                    }
                    ,'cjStudent'=>function($query){
                        $query->field('id,xingming,sex');
                    }
                ])
                ->append(['banjiTitle'])
                ->select();


        // 成绩整理
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

        // 实例化学生数据模型
        $stu = new \app\renshi\model\Student;


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
            // $data[$key]['nianji'] = $value->nianji;
            $data[$key]['banji'] = $value->banjiTitle;
            $dfsum = 0;
            $sbjcnt = 0;

            $cjarr = $this->zzcj($value->ks_chengji);

             // 初始化参数
            $sbjcnt = 0;  #记录拥有成绩的学科数

            foreach ($xk as $k => $val) {
                if(array_key_exists($k,$cjarr))
                {
                    $data[$key][$val]=$cjarr[$k] * 1;
                    $sbjcnt++;
                    // $dfsum = $dfsum + $data[$key][$val];
                }else{
                    $data[$key][$val]= null;
                }
            }



            $data[$key]['sum'] = array_sum($cjarr);
            if($sbjcnt>0){
                $data[$key]['avg'] = round($data[$key]['sum']/$sbjcnt,1);
            }else{
                $data[$key]['avg'] = null;
            }
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

    

    /**  
    * 获取参加考试的学校
    * @access public 
    * @param number $kaoshi 考试id
    * @param number $ruxuenian 入学年
    * @return array 返回类型
    */
    public function cySchool($srcfrom)
    {
        // 初始化参数 
        $src = array(
            'kaoshi'=>'',
            'ruxuenian'=>'',
        );
        // 用新值替换初始值
        $src = array_cover( $srcfrom , $src ) ;

        $data = $this->where('ruxuenian',$src['ruxuenian'])
                ->where('kaoshi',$src['kaoshi'])
                ->with(['cjSchool'=>function($query){
                        $query->field('id,jiancheng,paixu')->order(['paixu'=>'asc']);
                    }
                ])
                ->group('school')
                ->field('school')
                ->select()
                ->toArray();

        // 将cjSchool中排序向上层移动，为后面的排序做准备
        foreach ($data as $key => $value) {
            $data[$key]['paixu'] = $value['cjSchool']['paixu'];
            unset($data[$key]['cjSchool']['paixu']);
        }

        $data = sortArrByManyField($data,'paixu',SORT_ASC);

        return $data;

    }


    /**  
    * 获取参加考试的班级
    * @access public 
    * @param number $kaoshi 考试id
    * @param number $ruxuenian 入学年
    * @return array 返回班级数据模型
    */
    public function cyBanji($srcfrom)
    {
        
        // 初始化参数 
        $src = array(
            'kaoshi'=>'',
            'ruxuenian'=>'',
            'school'=>array(),
            'paixu'=>array(),
        );

        // 用新值替换初始值
        $src = array_cover( $srcfrom , $src ) ;
        $school = $src['school'];
        $paixu = $src['paixu'];


        // 获取考试时间
        $ks = new \app\kaoshi\model\Kaoshi;
        $kssj = $ks::where('id',$src['kaoshi'])->value('bfdate');

        $bjids = $this
                ->where('ruxuenian',$src['ruxuenian'])
                ->where('kaoshi',$src['kaoshi'])
                ->when(count($school)>0,function($query) use($school){
                    $query->where('school','in',$school);
                })
                ->when(count($paixu)>0,function($query) use($paixu){
                    $query->withTrashed()
                        ->where('banji','in',function($q)use($paixu){
                            $q->name('banji')
                            ->where('paixu','in',$paixu)
                            ->field('id');
                    });
                })
                ->with([
                    'cjSchool'=>function($query){
                        $query->field('id,jiancheng');
                    }
                ])
                ->group('banji')
                ->field(['banji'])
                ->select()
                ->toArray();


        foreach ($bjids as $key => $value) {
            // halt($key);
            $bjids[$key] = $value['banji'];
        }


        $bj = new \app\teach\model\Banji;

        $data  = $bj->withTrashed()
                ->where('id','in',$bjids)
                ->field('id,school,paixu')
                ->with([
                    'glSchool'=>function($query){
                        $query->field('id,title,jiancheng,paixu');
                    },
                ])
                ->select()
                ->toArray();
        
        foreach ($data as $key => $value) {
            $data[$key]['banjiNum'] = $bj->myBanjiNum($value['id'],$kssj);
            $data[$key]['banjiTitle'] = $bj->myBanjiTitle($value['id'],$kssj);
            $data[$key]['schOrd'] = $value['glSchool']['paixu'];
            unset($data[$key]['glSchool']['paixu']);
        }

        $data = sortArrByManyField($data,'schOrd',SORT_ASC,'paixu',SORT_ASC);

        return $data;
    }


    /**  
    * 获取参加考试的班级
    * @access public 
    * @param number $kaoshi 考试id
    * @param number $ruxuenian 入学年
    * @return array 返回类型
    */
    public function getBanjiTitleAttr()
    {
        $ks = $this->where('id',$this->id)
                ->with([
                    'cjKaoshi'=>function($query){
                        $query->field('id,bfdate');
                    }
                ])
                ->find();
        $bfdate = $ks->cjKaoshi->getData('bfdate');

        $bj = new \app\teach\model\Banji;
        $title = $bj->myBanjiTitle($this->getAttr('banji'),$bfdate);

        return $title;
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





