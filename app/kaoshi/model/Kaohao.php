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
            'kaoshi'=>'',
            'school'=>array('0'),
            'ruxuenian'=>'',
            'banji'=>array('0'),
            'searchval'=>''
        );

        // 用新值替换初始值
        $src = array_cover( $srcfrom , $src ) ;


        // 重新定义变量
        $school = $src['school'];
        $ruxuenian = $src['ruxuenian'];
        $banji = $src['banji'];
        $seachval = $src['searchval'];


        // 查询成绩
        $khlist = $this->where('kaoshi',$src['kaoshi'])
                ->field('id,school,student,banji,kaoshi')
                ->when(count($school)>0,function($query) use($school){
                    $query->where('school','in',$school);
                })
                ->when(count($banji)>0,function($query) use($banji){
                    $query->where('banji','in',$banji);
                })
                ->when(strlen($ruxuenian)>0,function($query) use($ruxuenian){
                    $query->where('ruxuenian',$ruxuenian);
                })
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

        return $khlist;
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
                    $query->where('banji','in',function($q)use($paixu){
                        $q->name('banji')->where('paixu','in',$paixu)->field('id');
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

        $data  = $bj->where('id','in',$bjids)
                ->field('id,school')
                ->with([
                    'glSchool'=>function($query){
                        $query->field('id,title,jiancheng');
                    },
                ])
                ->select();
        foreach ($data as $key => $value) {
            $data[$key]->banjiTitle = $bj->myBanjiTitle($value->id,$kssj);
        }

        return $data->toArray();
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

}
