<?php
// 命令空间
namespace app\kaohao\model;

// 引用数据模型基类
use app\BaseModel;

// 引用数据模型
use \app\kaohao\model\Kaohao as kh;

class Search extends BaseModel
{
    // 查询学生成绩详细信息
    public function srcChengjiList($srcfrom)
    {
        // 初始化参数
        $src = array(
            'kaoshi_id' => '0'
            ,'banji_id' => array()
            ,'searchval' => ''
        );
        // 用新值替换初始值
        $src = array_cover($srcfrom, $src);

        $kh = new kh;
        $khlist = $kh->search($src);
        if($khlist->isEmpty())
        {
            return $data = array();
        }

        // 获取参考学科
        $ksset = new \app\kaoshi\model\KaoshiSet;
        $ksSubject = $ksset->srcSubject($src['kaoshi_id'], '', '');
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
            $data[$key]['school_jiancheng'] = $value->cjSchool->jiancheng;
            if($value->cjStudent != Null){
                $data[$key]['student_xingming'] = $value->cjStudent->xingming;
                $data[$key]['sex'] = $value->cjStudent->sex;
            }else{
                $stuinfo = $stu::withTrashed()
                        ->where('id', $value->student_id)
                        ->field('id, xingming, sex')
                        ->find();
                $data[$key]['student_xingming'] = $stuinfo->xingming;
                $data[$key]['sex'] = $stuinfo->sex;
            }

            $data[$key]['ban_title'] = $value->banjiTitle;
            $data[$key]['banji_title'] = $value->banTitle;
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


    // 查询各班级考号，并以班级进行分组
    public function srcBanjiKaohao($srcfrom)
    {
        // 初始化参数
        $src = array(
            'kaoshi_id' => '0'
            ,'banji_id' => array()
        );
        // 用新值替换初始值
        $src = array_cover($srcfrom, $src);
        $src['banji_id'] = strToArray($src['banji_id']);

        // 获取考试标签
        $kh = new kh;
        $data = $kh->where('kaoshi_id', $src['kaoshi_id'])
            ->where('banji_id', 'in', $src['banji_id'])
            ->field('banji_id, school_id')
            ->order(['banji_id'])
            ->group('banji_id, school_id')
            ->with([
                'cjBanji' => function($query){
                    $query->field('id, school_id, ruxuenian, paixu')
                            ->append(['banjiTitle', 'numTitle']);
                }
                ,
                'cjSchool' => function($query){
                    $query->field('id, jiancheng');
                }
                ,
                'banjiKaohao' => function($query) use($src){
                    $query->field('id, student_id, banji_id')
                        ->where('kaoshi_id', $src['kaoshi_id'])
                        ->order(['banji_id', 'id'])
                        ->with([
                            'cjStudent' => function($q){
                                $q->field('id, xingming, sex');
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
                    $stuinof = $stu::onlyTrashed()
                        ->where('id', $val->student_id)
                        ->field('id, xingming')
                        ->find();
                    $data[$key]->banjiKaohao[$key]->cjStudent = array('id' => $stuinof->id, 'xingming' => $stuinof->xingming);
                }
            }
        }
        return $data;
    }


    // 查询各学科成绩精简版
    public function srcChengjiSubject($srcfrom)
    {
        // 初始化参数
        $src = array(
            'kaoshi_id' => '0'
            ,'banji_id' => array()
            ,'searchval' => ''
        );
        $src = array_cover($srcfrom, $src);

        $kh = new kh;
        $khlist = $kh->search($src);

        // 成绩整理
        if($khlist->isEmpty())
        {
            return $data = array();
        }
        $data = array();
        foreach ($khlist as $kh_k => $kh_val) {
            foreach ($kh_val->ksChengji as $cj_k => $cj_val) {
                $data[$cj_val->subject_id][$cj_val->id] = $cj_val->defen;
            }
        }

        return $data;
    }


    // 获取单个学生历次考试成绩
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

        $kh = new kh;
        $stuCj = $kh->where('student_id',$src['student_id'])
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
        $kh = new kh;
        $stuCj = $kh::where('id', $id)
            ->with([
                'ksChengji'=>function($query){
                    $query
                        ->with([
                            'subjectName'=>function($q){
                                $q->field('id, title');
                            }
                        ])
                        ->field('id, kaohao_id, subject_id, defen, defenlv, bweizhi, xweizhi, qweizhi');
                }
                ,'cjBanji' => function($q){
                    $q->field('id, paixu, ruxuenian')
                        ->append(['numTitle', 'banjiTitle']);
                }
                ,'cjSchool' => function($q){
                    $q->field('id, jiancheng');
                }
                ,'cjStudent' => function($q){
                    $q->field('id, xingming');
                }
            ])
            ->field('id, kaoshi_id, student_id, ruxuenian, nianji, banji_id, paixu')
            ->append(['banjiTitle'])
            ->find();

        return $stuCj;
    }


    // 根据考号查询成绩
    public function khSrcOneSubjectChengji($id, $subject_id)
    {
        $kh = new kh;
        $stuCj = $kh::where('id', $id)
            ->field('id ,banji_id, school_id, student_id')
            ->with([
                'ksChengji' => function($q) use($subject_id){
                    $q->where('subject_id',$subject_id)
                        ->field('kaohao_id, subject_id, defen')
                        ->with([
                            'subjectName' => function ($W) {
                                $W->field('id,title');
                            }
                        ]);
                }
                ,'cjBanji' => function($q){
                    $q->field('id, paixu, ruxuenian')
                        ->append(['numTitle', 'banjiTitle']);
                }
                ,'cjSchool' => function($q){
                    $q->field('id, jiancheng');
                }
                ,'cjStudent' => function($q){
                    $q->field('id, xingming');
                }
            ])
            ->find();

        if($stuCj->cjStudent == Null)
        {
            $stu = new \app\renshi\model\Student;
            $stuinfo = $stu::withTrashed()
                ->where('id', $cjlist->student)
                ->field('id, xingming, sex')
                ->find();
            $stuCj->cjStudent = array(
                'id' => $stuinfo->id
                ,'xingming' => $stuinfo->xingming
            );
        }

        return $stuCj;
    }


    // 获取考试成绩最后更新时间
    public function lastUpdateTime($kaoshi_id)
    {
        // 获取考号
        $kh = new kh;
        $kaohaoids = $kh->where('kaoshi_id', $kaoshi_id)
            ->cache(true)
            ->column('id');

        $cj = new \app\chengji\model\Chengji;
        $lastcj = $cj->where('kaohao_id', 'in', $kaohaoids)
                    ->order(['update_time' => 'desc'])
                    ->find();

        return $lastcj;
    }


    // 获取参加考试学校
    public function cySchool($srcfrom)
    {
        // 初始化参数
        $src = array(
            'kaoshi_id' => ''
            ,'ruxuenian' => ''
        );
        $src = array_cover($srcfrom, $src);
        $src['ruxuenian'] = strToarray($src['ruxuenian']);

        $kh = new kh;
        $schoolList = $kh->where('kaoshi_id', $src['kaoshi_id'])
                ->when(count($src['ruxuenian']) > 0, function($query) use($src){
                    $query->where('ruxuenian', 'in', $src['ruxuenian']);
                })
                ->with(['cjSchool' => function($query){
                        $query->field('id, jiancheng, paixu, title')
                        ->order(['paixu' => 'asc']);
                    }
                ])
                ->group('school_id')
                ->field('school_id')
                ->select()
                ->toArray();

        // 重新整理参加学校信息
        $data = array();
        foreach ($schoolList as $key => $value) {
            $data[] = [
                'paixu' => $value['cjSchool']['paixu'],
                'id' => $value['cjSchool']['id'],
                'title' => $value['cjSchool']['title'],
                'jiancheng' => $value['cjSchool']['jiancheng'],
            ];
        }

        if(count($data) > 0)
        {
            $data = sortArrByManyField($data, 'paixu', SORT_ASC);
        }

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
            'kaoshi_id' => ''
            ,'ruxuenian' => array()
            ,'school_id' => array()
            ,'banji_id' => array()
        );
        $src = array_cover($srcfrom, $src);
        $src['school_id'] = strToarray($src['school_id']);
        $src['banji_id'] = strToarray($src['banji_id']);
        $src['ruxuenian'] = strToarray($src['ruxuenian']);

        // 通过给定参数，从考号表中获取参加考试的班级
        $kh = new kh;
        $bjids = $kh
                ->where('kaoshi_id', $src['kaoshi_id'])
                ->when(count($src['ruxuenian'] ) > 0, function($query) use($src){
                    $query->where('ruxuenian', 'in', $src['ruxuenian'] );
                })
                ->when(count($src['school_id']) > 0, function($query) use($src){
                    $query->where('school_id', 'in', $src['school_id']);
                })
                ->when(count($src['banji_id']) > 0, function($query) use($src){
                    $query->where('banji_id', 'in', $src['banji_id']);
                })
                ->with([
                    'cjSchool' => function($query){
                        $query->field('id, jiancheng, title, paixu');
                    }
                ])
                ->field('banji_id
                    ,any_value(id) as id
                    ,any_value(nianji) as nianji
                    ,any_value(paixu) as paixu
                    ,any_value(school_id) as school_id')
                ->group('banji_id')
                ->append(['banjiTitle', 'banTitle'])
                ->select();

        $bj = new \app\teach\model\Banji;
        $data = array();
        foreach ($bjids as $key => $value) {
            $data[] = [
                'id'=>$value->banji_id,
                'paixu'=>$value->paixu,
                'schTitle'=>$value->cjSchool->title,
                'schJiancheng'=>$value->cjSchool->jiancheng,
                'schPaixu'=>$value->cjSchool->paixu,
                'banTitle'=>$value->banTitle,
                'banjiTitle'=>$value->banjiTitle,
                // 'numTitle'=>$value->numTitle,
            ];
        }
        if(count($data) > 0)
        {
            $data = sortArrByManyField($data, 'schPaixu', SORT_ASC, 'paixu', SORT_ASC);
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





