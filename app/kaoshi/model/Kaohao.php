<?php
// 命令空间
namespace app\kaoshi\model;

// 引用数据模型基类
use app\BaseModel;

class Kaohao extends BaseModel
{
    /**
    * 根据班级ID和考试ID，以班级为单位分组，查询参加当前考试的学生信息
    *
    * @access public
    * @param mixed $kaoshi 当前考试ID
    * @param array $banji 学生所在班级
    * @return array 返回类型
    */
    public function srcKaohaoBanji($kaoshi,$banji)
    {
        // 获取考试标签
        $data = $this->where('kaoshi',$kaoshi)
            ->where('banji','in',$banji)
            ->field('banji,school')
            ->order(['banji'])
            ->group('banji,school')
            ->with([
                'cjBanji'=>function($query){
                    $query->field('id,school,ruxuenian,paixu')
                            ->append(['banjiTitle','numTitle']);
                }
                ,
                'cjSchool'=>function($query){
                    $query->field('id,jiancheng');
                }
                ,
                'banjiKaohao'=>function($query) use($kaoshi){
                    $query->field('id,student,banji')
                        ->where('kaoshi',$kaoshi)
                        ->order(['banji','id'])
                        ->with([
                            'cjStudent'=>function($q){
                                $q->field('id,xingming,sex');
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
    * 整理出适合显示的学生成绩，
    * 以考号为基础查询学生成绩信息并排序，计划在网页上显示成绩列表中使用
    * 信息包括：学校、年级、班级、姓名、性别、各学科成绩、平均分、总分
    * @access public
    * @param array $src 参数数组
    * @param number $src['kaoshi'] 考试ID
    * @param array $src['banji'] 班级数组
    * @param number $src['searchval'] 关键字
    * @return array 返回类型
    */
    public function srcChengji($srcfrom)
    {
        // 初始化参数
        $src = array(
            'kaoshi'=>'0',
            'banji'=>array(),
            'searchval'=>''
        );

        // 用新值替换初始值
        $src = array_cover($srcfrom, $src);
        $khlist = self::search($src);

        // 成绩整理
        if($khlist->isEmpty())
        {
            return $data = array();
        }

        // 获取参考学科
        $ksset = new \app\kaoshi\model\KaoshiSet;
        $ksSubject = $ksset->srcSubject($src['kaoshi'], '', '');

        if(count($ksSubject)==0)
        {
            return $data = array();
        }

        $xk = array();
        foreach ($ksSubject as $key => $value) {
            $xk[$value['id']] = $value['lieming'];
        }

        // 实例化学生数据模型
        $stu = new \app\renshi\model\Student;
        $data = array();
        foreach ($khlist as $key => $value) {
            $data[$key]['id'] = $value->id;
            $data[$key]['school'] = $value->cjSchool->jiancheng;
            if($value->cjStudent != Null){
                $data[$key]['student'] = $value->cjStudent->xingming;
                $data[$key]['sex'] = $value->cjStudent->sex;
            }else{
                $stuinfo = $stu::withTrashed()
                        ->where('id',$value->student)
                        ->field('id,xingming,sex')
                        ->find();
                $data[$key]['student'] = $stuinfo->xingming;
                $data[$key]['sex'] = $stuinfo->sex;
            }
            $data[$key]['banji'] = $value->banjiTitle;
            $dfsum = 0;
            $sbjcnt = 0;

            // 整理当前学生成绩
            $cjarr = $this->zzcj($value->ksChengji);

             // 初始化参数
            $sbjcnt = 0;  #记录拥有成绩的学科数

            foreach ($xk as $k => $val) {
                if(array_key_exists($k,$cjarr))
                {
                    $data[$key][$val]=$cjarr[$k] * 1;
                    $sbjcnt++;
                }else{
                    $data[$key][$val]= null;
                }
            }

            if($sbjcnt>0){
                $data[$key]['sum'] = array_sum($cjarr);
                $data[$key]['avg'] = round($data[$key]['sum']/$sbjcnt,1);
            }else{
                $data[$key]['sum'] = null;
                $data[$key]['avg'] = null;
            }
        }

        return $data;
    }


    // 查询学生各学科成绩
    public function srcChengjiSubject($srcfrom)
    {
        // 初始化参数
        $src = array(
            'kaoshi_id' => '0',
            'banji_id' => array(),
            'searchval' => ''
        );

        // 用新值替换初始值
        $src = array_cover( $srcfrom , $src ) ;

        $khlist = self::search($src);


        // 成绩整理
        if($khlist->isEmpty())
        {
            return $data = array();
        }

        // 整理成绩
        $data = array();
        foreach ($khlist as $kh_k => $kh_val) {
            foreach ($kh_val->ksChengji as $cj_k => $cj_val) {
                $data[$cj_val->subject_id][$cj_val->id] = $cj_val->defen;
            }
        }

        return $data;

    }



    /**
    * 列出成绩原始数据，其它数据模型中的方法以此方法为基础进行数据整理
    * @access public
    * @param array $src 参数数组
    * @param number $src['kaoshi'] 考试ID
    * @param array $src['banji'] 班级数组
    * @param number $src['searchval'] 关键字
    * @return array 返回成绩对象
    */
    public function search($srcfrom)
    {
        // 初始化参数
        $src = array(
            'kaoshi'=>'0',
            'banji'=>array(),
            'searchval'=>''
        );

        // 用新值替换初始值
        $src = array_cover( $srcfrom , $src ) ;
        $src['banji'] = strToarray($src['banji']);

        // 查询成绩
        $data = $this->where('kaoshi',$src['kaoshi'])
                ->field('id,school,student,ruxuenian,paixu,kaoshi,nianji')
                ->where('banji','in',$src['banji'])
                ->when(strlen($src['searchval'])>0,function($query) use($src){
                    $query->where(function($w) use ($src){
                        $w
                        ->whereOr('student','in',function($q)use($src){
                            $q->name('student')->where('xingming','like','%'.$src['searchval'].'%')->field('id');
                        });
                    });
                })
                ->with([
                    'ksChengji'=>function($query){
                        $query->field('id,kaohao_id,subject_id,defen');
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

        return $data;
    }


    // 获取单个学生考试成绩
    public function srcOneStudentChengji($srcfrom)
    {
        // 初始化参数
        $src = array(
            'student_id' => '',
            'category_id' => '',
            'xueqi_id' => '',
            'kaoshi_id' => '',
        );
        $src = array_cover($srcfrom, $src);
        $src['category_id'] = strToArray($src['category_id']);
        $src['xueqi_id'] = strToArray($src['xueqi_id']);
        $src['kaoshi_id'] = strToArray($src['kaoshi_id']);

        if(isset($srcfrom['bfdate']) && strlen($srcfrom['bfdate'])>0)
        {
            $src['bfdate'] = $srcfrom['bfdate'];
        }else{
            $src['bfdate'] = date("Y-m-d",strtotime("-1 year"));
        }

        if(isset($srcfrom['enddate']) && strlen($srcfrom['enddate'])>0)
        {
            $src['enddate'] = $srcfrom['enddate'];
        }else{
            $src['enddate'] = date("Y-m-d",strtotime("+1 day"));
        }

        $stuCj = $this->where('student_id',$src['student_id'])
            ->when(count($src['category_id'])>0, function($query) use($src){
                $query->where('kaoshi_id','in',function($q) use($src){
                    $q->name('kaoshi')
                    ->where('category_id','in',$src['category_id'])
                    ->field('id');
                });
            })
            ->when(count($src['xueqi_id'])>0, function($query) use($src){
                $query->where('kaoshi_id','in',function($q) use($src){
                    $q->name('kaoshi')
                        ->where('xueqi_id','in',function($w) use($src){
                            $w->name('xueqi')
                                ->where('category_id','in',$src['xueqi_id'])
                                ->field('id');
                        })
                        ->field('id');
                });
            })
            ->when(count($src['kaoshi_id'])>0, function($query) use($src){
                $query->where('kaoshi_id', 'in', $src['kaoshi_id']);
            })
            ->where('kaoshi_id', 'in', function($query) use($src){
                $query->name('kaoshi')
                    ->whereTime('bfdate|enddate', 'between', [ $src['bfdate'],$src['enddate'] ])
                    ->field('id');
            })
            ->with([
                'ksChengji'=>function($query){
                    $query->field('id, kaohao_id, subject_id, defen, defenlv, bweizhi, xweizhi, qweizhi');
                }
                ,'cjSchool' => function($query){
                    $query->field('id, jiancheng');
                }
                ,'cjKaoshi' => function($query){
                    $query->field('id, title, zuzhi_id, xueqi_id, category_id, bfdate, enddate')
                        ->with([
                            'ksCategory' => function($q){
                                $q->field('id, title');
                            }
                            ,'ksZuzhi' => function($q)
                            {
                                $q->field('id, title, jiancheng');
                            }
                    ]);
                }
            ])
            ->field('id ,kaoshi_id, student_id, ruxuenian, nianji, banji_id, paixu')
            ->append(['banjiTitle'])
            ->select();

        return $stuCj;
    }


    // 根据考号查询成绩
    public function khSrcChengji($id)
    {
        $stuCj = self::where('id',$id)
            ->with([
                'ksChengji'=>function($query){
                    $query
                        ->with([
                            'subjectName'=>function($q){
                                $q->field('id,title');
                            }
                        ])
                        ->field('id,kaohao_id,subject_id,defen,defenlv,bweizhi,xweizhi,qweizhi');
                }
            ])
            ->field('id,kaoshi,student,ruxuenian,nianji,banji,paixu')
            ->append(['banjiTitle'])
            ->find();

        return $stuCj;
    }



    // 获取考试成绩最后更新时间
    public function lastUpdateTime($kaoshi_id)
    {
        // 获取考号
        $kaohaoids = self::where('kaoshi', $kaoshi_id)
            ->cache(true)
            ->column('id');

        $cj = new \app\chengji\model\Chengji;
        $lastcj = $cj->where('kaohao_id', 'in', $kaohaoids)
                    ->order(['update_time' => 'desc'])
                    ->find();

        return $lastcj;
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

    // // 满分
    // public function cjManfen()
    // {
    // 	return $this->hasMany('\app\kaoshi\model\KaoshiSubject','kaoshiid','kaoshi');
    // }

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
        $ruxuenian = strToarray($src['ruxuenian']);

        $schoolList = $this->when(count($ruxuenian)>0,function($query) use($ruxuenian){
                    $query->where('ruxuenian','in',$ruxuenian);
                })
                ->where('kaoshi',$src['kaoshi'])
                ->with(['cjSchool'=>function($query){
                        $query->field('id,jiancheng,paixu,title')->order(['paixu'=>'asc']);
                    }
                ])
                // ->cache(true)
                ->group('school')
                ->field('school')
                ->select()
                ->toArray();

        // 重新整理参加学校信息
        $data = array();
        foreach ($schoolList as $key => $value) {
            $data[] = [
                'paixu'=>$value['cjSchool']['paixu'],
                'id'=>$value['cjSchool']['id'],
                'title'=>$value['cjSchool']['title'],
                'jiancheng'=>$value['cjSchool']['jiancheng'],
            ];
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
            'ruxuenian'=>array(),
            'school'=>array(),
            'banji'=>array(),
        );


        // 用新值替换初始值
        $src = array_cover( $srcfrom , $src ) ;
        $school = strToarray($src['school']);
        $banji = strToarray($src['banji']);
        $ruxuenian = strToarray($src['ruxuenian']);


        // 获取考试时间
        $ks = new \app\kaoshi\model\Kaoshi;
        $kssj = $ks::where('id',$src['kaoshi'])->value('bfdate');

        // 通过给定参数，从考号表中获取参加考试的班级
        $bjids = $this
                ->when(count($ruxuenian)>0,function($query) use($ruxuenian){
                    $query->where('ruxuenian','in',$ruxuenian);
                })
                ->where('kaoshi',$src['kaoshi'])
                ->when(count($school)>0,function($query) use($school){
                    $query->where('school','in',$school);
                })
                ->when(count($banji)>0,function($query) use($banji){
                    $query->where('banji','in',$banji);
                })
                ->with([
                    'cjSchool'=>function($query){
                        $query->field('id,jiancheng,title');
                    }
                ])
                // ->cache(true)
                ->field('banji
                    ,any_value(id) as id
                    ,any_value(nianji) as nianji
                    ,any_value(paixu) as paixu
                    ,any_value(school) as school')
                ->group('banji')
                ->append(['banjiTitle','banTitle'])
                ->select();

        $bj = new \app\teach\model\Banji;

        $data = array();
        foreach ($bjids as $key => $value) {
            $data[] = [
                'id'=>$value->banji,
                'paixu'=>$value->paixu,
                'schTitle'=>$value->cjSchool->title,
                'schJiancheng'=>$value->cjSchool->jiancheng,
                'schPaixu'=>$value->cjSchool->paixu,
                'banTitle'=>$value->banTitle,
                'banjiTitle'=>$value->banjiTitle,
                // 'numTitle'=>$value->numTitle,
            ];
        }

        $data = sortArrByManyField($data,'schPaixu',SORT_ASC,'paixu',SORT_ASC);

        return $data;
    }


    /**
    * 获取参加考试的班级全名
    * @access public
    * @param number $kaoshi 考试id
    * @param number $ruxuenian 入学年
    * @return array 返回类型
    */
    public function getBanjiTitleAttr()
    {
        $bj = banjinamelist();
        // $title = $nj[$this->getAttr('nianji')] . $bj[$this->getAttr('paixu')];
        $title = $this->getAttr('nianji') . $bj[$this->getAttr('paixu')];
        return $title;
    }

    /**
    * 获取参加考试的班级全名
    * @access public
    * @param number $kaoshi 考试id
    * @param number $ruxuenian 入学年
    * @return array 返回类型
    */
    public function getBanTitleAttr()
    {
        $bj = banjinamelist();
        $title = $bj[$this->getAttr('paixu')];
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





