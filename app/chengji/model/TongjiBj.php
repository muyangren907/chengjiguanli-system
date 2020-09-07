<?php
namespace app\chengji\model;

// 引用基类
use \app\BaseModel;
// 引用学生成绩统计类
use \app\chengji\model\Tongji as TJ;
// 引用考号查询
use \app\kaohao\model\SearchMore as More;
use \app\kaohao\model\SearchCanYu as Canyu;
// 引用考试参与
use \app\kaoshi\model\KaoshiSet as ksset;


/**
 * @mixin think\Model
 */
class TongjiBj extends BaseModel
{
    // 统计参加本次考试所有班级的成绩并保存
    public function tjBanji($kaoshi_id)
    {
        $src = array('kaoshi_id' => $kaoshi_id);
        // 实例化学生成绩统计类
        $tj = new TJ;
        $more = new More();
        $cy = new Canyu();
        $ksset = new ksset();
        $nianji = $ksset->srcGrade($kaoshi_id);

        // 循环年级统计结果
        $data = array();
        foreach ($nianji as $njkey => $value) {
            // 获取参加考试班级
            $src['ruxuenian'] = $value['ruxuenian'];
            $banji = $cy->class($src);
            $subject = $ksset->srcSubject($src);

            // 循环班级，获取并统计成绩
            foreach ($banji as $bjkey => $val) {
                $srcfrom = [
                    'kaoshi_id' => $kaoshi_id
                    ,'banji_id' => $val['id']
                ];
                $temp = $more->srcChengjiList($srcfrom);
                $temp = $tj->tongjiSubject($temp, $subject);

                // 循环更新或写入成绩
                foreach ($temp['cj'] as $cjkey => $cj) {
                    $tongjiJg = $this->where('kaoshi_id', $src['kaoshi_id'])
                        ->where('banji_id', $val['id'])
                        ->where('subject_id', $cj['id'])
                        ->find();
                    if($tongjiJg)
                    {
                        $tongjiJg->kaoshi_id = $src['kaoshi_id'];
                        $tongjiJg->banji_id = $val['id'];
                        $tongjiJg->subject_id = $cj['id'];
                        $tongjiJg->stu_cnt = $cj['stucnt'];
                        $tongjiJg->chengji_cnt = $cj['xkcnt'];
                        $tongjiJg->sum = $cj['sum'];
                        $tongjiJg->avg = $cj['avg'];
                        $tongjiJg->biaozhuncha = $cj['biaozhuncha'];
                        $tongjiJg->youxiu = $cj['youxiu'];
                        $tongjiJg->jige = $cj['jige'];
                        $tongjiJg->max = $cj['max'];
                        $tongjiJg->min = $cj['min'];
                        $tongjiJg->q1 = $cj['sifenwei'][0];
                        $tongjiJg->q2 = $cj['sifenwei'][1];
                        $tongjiJg->q3 = $cj['sifenwei'][2];
                        $tongjiJg->zhongshu = $cj['zhongshu'];
                        $tongjiJg->zhongweishu = $cj['zhongweishu'];
                        $tongjiJg->defenlv = $cj['defenlv'];
                        $data = $tongjiJg->save();
                    }else{
                        // 重新组合统计结果
                        $tongjiJg = [
                            'kaoshi_id' => $src['kaoshi_id']
                            ,'banji_id' => $val['id']
                            ,'subject_id' => $cj['id']
                            ,'stu_cnt' => $cj['stucnt']
                            ,'chengji_cnt' => $cj['xkcnt']
                            ,'sum' => $cj['sum']
                            ,'avg' => $cj['avg']
                            ,'biaozhuncha' => $cj['biaozhuncha']
                            ,'youxiu' => $cj['youxiu']
                            ,'jige' => $cj['jige']
                            ,'max' => $cj['max']
                            ,'min' => $cj['min']
                            ,'q1' => $cj['sifenwei'][0]
                            ,'q2' => $cj['sifenwei'][1]
                            ,'q3' => $cj['sifenwei'][2]
                            ,'zhongshu' => $cj['zhongshu']
                            ,'zhongweishu' => $cj['zhongweishu']
                            ,'defenlv' => $cj['defenlv']
                        ];
                        $data = $this::create($tongjiJg);
                    }
                }
            }
        }

        return true;
    }


    // 统计参加本次考试的各班级成绩数
    public function tjBanjiCnt($srcfrom)
    {
        // 初始化参数
        $src = array(
            'page' => '1'
            ,'limit' => '10'
            ,'kaoshi_id' => ''
            ,'banji_id' => array()
            ,'school_id' => array()
            ,'ruxuenian' => ''
        );
        $src = array_cover($srcfrom, $src);

        $src['banji_id'] = strToArray($src['banji_id']);
        $src['school_id'] = strToArray($src['school_id']);

        // 实例化学生成绩统计类
        $tj = new TJ();
        $more = new More();
        $cy = new Canyu();
        $ksset = new ksset();

        // 获取参加考试学科
        $subject = $ksset->srcSubject($src);
        $banji =$cy->class($src);

        // 获取并统计各班级成绩
        $data = array();
        $srcfrom['kaoshi_id'] = $src['kaoshi_id'];
        foreach ($banji as $key => $value) {
            $srcfrom['banji_id'] = $value['id'];
            $temp = $more->srcChengjiList($srcfrom);
            $temp = $tj->tongjiCnt($temp, $subject);
            $data[] = [
                'banji_id' => $value['banjiTitle']
                ,'banjinum' => $value['banjiTitle']
                ,'school_id' => $value['schJiancheng']
                ,'chengji' => $temp
            ];
        }

        $srcfrom['banji_id'] = array_column($banji, 'id');
        $temp = $more->srcChengjiList($srcfrom);
        $temp = $tj->tongjiCnt($temp, $subject);
        $data[] = [
            'banji_id' => '合计',
            'banjinum' => '合计',
            'school_id' => '合计',
            'chengji' => $temp
        ];

        return $data;
    }


    // 统计各学科分数频率
    public function tjBanjiFenshuduan($srcfrom)
    {
        // 初始化参数
        $src = array(
            'page' => '1'
            ,'limit' => '10'
            ,'kaoshi_id' => ''
            ,'banji_id' => array()
            ,'ruxuenian' => ''
            ,'subject_id' => ''
            ,'cishu' => 20
        );

        $src = array_cover($srcfrom, $src);
        $src['banji_id'] = strToArray($src['banji_id']);

        // 实例化学生成绩统计类
        $tj = new TJ;
        $more = new More();
        $cy = new Canyu();
        $ksset = new ksset();

        // 获取参加考试学科
        $subject = $ksset->srcSubject($src);
        $fsx = 0;
        $lieming = 'lieming';
        foreach ($subject as $key => $value) {
            if ($value['id'] == $src['subject_id'])
            {
                $fsx = $value['fenshuxian']['manfen'];
                $lieming = $value['lieming'];
            }
        }

        // 获取并统计各班级成绩
        $data = array();
        $cj = $more->srcChengjiList($src);
        if (array_key_exists($lieming, $cj[0]))
        {
            $cjcol = array_column($cj, $lieming);
            $cjcol = array_filter($cjcol, function($item){
                return $item !== null;
            });
            if (count($cjcol) > 0)
            {
                $data = $tj->fenshuduan($cjcol, $fsx, $src['cishu']);
            }
        }

        return $data;
    }


    // 根据条件查询各班级成绩
    public function search($srcfrom)
    {
        // 查询数据
        $tongjiJg = $this->searchBase($srcfrom);

        // 重组数据
        $data = array();
        foreach ($tongjiJg as $key => $value) {
            $data[$value->banji_id] = [
                'id' => $value->id
                ,'school_jiancheng' => $value->bjBanji->glSchool->jiancheng
                ,'school_paixu' => $value->bjBanji->glSchool->paixu
                ,'banji_title' => $value->banjiTitle
                ,'banji_paixu' => $value->bjBanji->paixu
                ,'stu_cnt' => $value->stuCnt
            ];
            foreach ($value->bjJieguo as $k => $val) {
                if($val->subject_id > 0){
                    $data[$value->banji_id]['chengji'][$val->bjSubject->lieming] = [
                        'avg' => $val->avg * 1
                        ,'youxiu' => $val->youxiu * 1
                        ,'jige' => $val->jige * 1
                        ,'cjCnt' => $val->chengji_cnt
                        ,'title' => $val->bjSubject->title
                        ,'jiancheng' => $val->bjSubject->jiancheng
                        ,'biaozhuncha' => $val->biaozhuncha * 1
                        ,'sifenwei' => [
                            'min' => $val->min
                            ,'q1' => $val->q1 * 1
                            ,'q2' => $val->q2 * 1
                            ,'q3' => $val->q3 * 1
                            ,'max' => $val->max
                        ]
                    ];
                }else{
                    $data[$value->banji_id]['quanke'] = [
                        'avg' => $val->avg
                        ,'jige' => $val->jige
                    ];
                }
            }
        }
        if(count($data)>0)
        {
            $data = \app\facade\Tools::sortArrByManyField($data, 'school_paixu', SORT_ASC, 'banji_paixu', SORT_ASC);
        }

        return $data;
    }


    // 根据条件查询各班级成绩
    public function searchBase($srcfrom)
    {
        // 初始化参数
        $src = array(
            'kaoshi_id' => ''
            ,'banji_id' => array()
        );
        $src = array_cover($srcfrom, $src);
        $src['banji_id'] = strToarray($src['banji_id']);
        $kaoshi_id = $src['kaoshi_id'];

        if(count($src['banji_id']) == 0){
            return array();
        }

        $tongjiJg = $this
            ->where('kaoshi_id', $src['kaoshi_id'])
            ->where('banji_id', 'in', $src['banji_id'])
            ->field('banji_id, kaoshi_id')
            ->with([
                'bjBanji '=> function ($query) {
                    $query
                        ->field('id, school_id, paixu, ruxuenian, alias')
                        ->with([
                            'glSchool' => function($query){
                                $query->field('id, jiancheng, paixu');
                            },
                        ]);

                },
                'bjJieguo' => function ($query) {
                    $query->field('id, teacher_id, subject_id, banji_id, stu_cnt,
                        chengji_cnt, avg, youxiu, jige, biaozhuncha,
                        max, min, q1, q2, q3')
                        ->with([
                            'bjSubject' => function($q){
                                $q->field('id, lieming, jiancheng, title');
                            },
                            'bjTeacher' => function ($q) {
                                $q->field('id, xingming');
                            }
                        ])
                        ->order(['subject_id']);
                }
            ])
            ->group('banji_id, kaoshi_id')
            ->append(['banjiTitle'])
            ->select();

        return $tongjiJg;
    }



    // 查询成绩统计结果（没有分组）
    public function searchSubjedt($srcfrom)
    {
        // 初始化参数
        $src = array(
            'kaoshi_id' => ''
            ,'banji_id' => array()
            ,'subject_id' => array()
            ,'school_id' => ''
            ,'ruxuenian' => ''
            ,'teacher_id' => ''
        );
        $src = array_cover($srcfrom, $src);
        $src['banji_id'] = strToarray($src['banji_id']);
        $src['subject_id'] = strToarray($src['subject_id']);
        $src['teacher_id'] = strToarray($src['teacher_id']);

        $data = $this->where('kaoshi_id', $src['kaoshi_id'])
                ->when(count($src['banji_id']) > 0, function ($query) use($src) {
                    $query->where('banji_id', 'in', $src['banji_id']);
                })
                ->when(count($src['teacher_id']) > 0, function ($query) use($src) {
                    $query->where('teacher_id', 'in', $src['teacher_id']);
                })
                ->where('banji_id', 'in', function ($query) use($src) {
                    $query->name('banji')
                        ->when(strlen($src['school_id']) > 0, function ($q) use ($src) {
                            $q->where('school_id', $src['school_id']);
                        })
                        ->when(strlen($src['school_id']) > 0, function ($q) use ($src) {
                            $q->where('ruxuenian', $src['ruxuenian']);
                        })
                        ->field('id');
                })
                ->when(count($src['subject_id']) > 0, function ($query) use($src) {
                    $query->where('subject_id', 'in', $src['subject_id']);
                })
                ->field('id, banji_id, kaoshi_id')
                ->append(['banTitle'])
                ->select();

        return $data;
    }


    // 查询与指定教师相关的所有考试成绩
    public function searchTeacher($srcfrom)
    {
        // 初始化参数
        $src = array(
            'xueqi_id' => ''
            ,'category_id' => array()
            ,'subject_id' => array()
            ,'teacher_id' => 0
            ,'bfdate' => ''
            ,'enddate' => ''
        );
        $src = array_cover($srcfrom, $src);
        $src['xueqi_id'] = strToarray($src['xueqi_id']);
        $src['subject_id'] = strToarray($src['subject_id']);
        $src['category_id'] = strToarray($src['category_id']);

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

        $bj = new \app\teach\model\Banji;
        $bjList = $bj->where('banzhuren', $src['teacher_id'])->column('id');

        $data = $this->where('teacher_id', $src['teacher_id'])
                ->where('subject_id', '<>', 0)
                ->when(count($src['subject_id']) > 0, function ($query) use($src) {
                    $query->where('subject_id', 'in', $src['subject_id']);
                })
                ->where('kaoshi_id', 'in', function ($query) use($src) {
                    $query->name('kaoshi')
                        ->whereTime('bfdate|enddate', 'between', [$src['bfdate'], $src['enddate']])
                        ->when(count($src['xueqi_id'])>0, function ($q) use($src) {
                            $q->where('xueqi_id', 'in', function ($w) use($src) {
                                $w->name('xueqi')
                                    ->where('category_id', 'in', $src['xueqi_id'])
                                        ->field('id');
                                });
                        })
                        ->when(count($src['category_id'])>0, function ($q) use($src) {
                            $q->where('category_id', 'in', $src['category_id']);
                        })
                        ->field('id');
                })
                ->when(count($bjList) > 0, function ($query) use($bjList) {
                    $query->whereOr('id', 'in', function ($q) use($bjList) {
                        $q->name('tongjiBj')
                            ->where('banji_id', 'in', $bjList)
                            ->where('subject_id', '<>', 0)
                            ->field('id');
                    });
                })
                ->with([
                    'bjSubject' => function ($query) {
                        $query->field('id, title, jiancheng');
                    }
                    ,'bjKaoshi' => function ($query) {
                        $query->field('id, title, enddate');
                    }
                ])
                ->append(['banjiTitle'])
                ->select();

        return $data;
    }


    // 查询任课教师
    public function renke($srcfrom)
    {
        // 查询数据
        $tongjiJg = $this->searchBase($srcfrom);

        // 重组数据
        $data = array();
        foreach ($tongjiJg as $key => $value) {
            $data[$value->banji_id] = [
                'school_paixu' =>$value->school_paixu
                ,'school_jiancheng' => $value->bjBanji->glSchool->jiancheng
                ,'banji_title' => $value->banjiTitle
                ,'banji_paixu' => $value->banji_paixu

            ];
            foreach ($value->bjJieguo as $k => $val) {
                if($val->subject_id > 0){
                    if(isset($val->bjTeacher->xingming))
                    {
                        $data[$value->banji_id][$val->bjSubject->lieming] = $val->bjTeacher->xingming;
                    }else{
                        $data[$value->banji_id][$val->bjSubject->lieming] = '';
                    }

                    $data[$value->banji_id]['id'] = $val->id;
                }
            }
        }
        if(count($data)>0)
        {
            $data = \app\facade\Tools::sortArrByManyField($data, 'school_paixu', SORT_ASC, 'banji_paixu', SORT_ASC);
        }

        return $data;
    }


    /**
    * 查询班级历次成绩
    */
    public function srcBanjiChengji($srcfrom)
    {
        // 初始化参数
        $src = array(
            'banji_id' => ''
            ,'category_id' => ''
            ,'xueqi_id' => ''
            ,'searchval' => ''
        );
        $src = array_cover($srcfrom, $src);
        $src['xueqi_id'] = strToarray($src['xueqi_id']);
        $src['category_id'] = strToarray($src['category_id']);
        if(isset($srcfrom['bfdate']) && strlen($srcfrom['bfdate']) > 0)
        {
            $src['bfdate'] = $srcfrom['bfdate'];
        }else{
            $src['bfdate'] = date("Y-m-d", strtotime("-2 year"));
        }
        if(isset($srcfrom['enddate']) && strlen($srcfrom['enddate']) > 0)
        {
            $src['enddate'] = $srcfrom['enddate'];
        }else{
            $src['enddate'] = date("Y-m-d", strtotime("+1 day"));
        }

        $data = $this
            ->where('banji_id', $src['banji_id'])
            ->where('kaoshi_id', 'in', function ($query) use ($src) {
                $query->name('kaoshi')
                    ->where('luru&status', '0')
                    ->whereTime('bfdate|enddate', 'between', [$src['bfdate'], $src['enddate']])
                    ->when(count($src['xueqi_id']) > 0, function($q) use ($src) {
                        $q->where('xueqi_id', 'in', function($w) use ($src) {
                            $w->name('xueqi')
                                ->where('category_id', 'in', $src['xueqi_id'])
                                ->field('id');
                        });
                    })
                    ->when(count($src['category_id']) > 0, function($q) use ($src) {
                        $q->where('category_id', 'in', $src['category_id']);
                    })
                    ->when(strlen($src['searchval']) > 0, function($q) use ($src) {
                        $q->where('title', 'like', '%' . $src['searchval'] . '%');
                    })
                    ->field('id');
            })
            ->with([
                'bjKaoshi' => function ($query) {
                    $query->field('id, title, bfdate');
                },
                'bjSubject' => function ($query) {
                    $query->field('id, title, jiancheng, paixu, lieming');
                },
                'quJieguo' => function ($query) {
                    $query->field('id, kaoshi_id, subject_id, defenlv');
                }
            ])
            ->select();

        return $data;
    }


    // 成绩排序
    public function bjOrder($kaoshi_id)
    {
        $src = array('kaoshi_id' => $kaoshi_id);
        // 实例化学生成绩统计类
        $more = new More();
        $cy = new Canyu();
        $ksset = new ksset();
        $cj = new \app\chengji\model\Chengji;

        $nianji = $ksset->srcGrade($kaoshi_id);
        $col = ['bpaixu', 'bweizhi'];

        // 初始化统计结果
        $data = array();
        foreach ($nianji as $njkey => $value) {
            // 获取参加考试班级
            $src['ruxuenian'] = $value['ruxuenian'];
            $banji = $cy->class($src);
            $subject = $ksset->srcSubject($kaoshi_id, '', $value['ruxuenian']);

            // 循环班级，获取并统计成绩
            foreach ($banji as $bjkey => $val) {
                // 获取成绩
                $srcfrom = [
                    'kaoshi_id' => $kaoshi_id,
                    'banji_id' => $val['id'],
                ];
                $temp = $more->srcChengjiSubject($srcfrom);

                // 循环计算成绩排序
                foreach ($temp as $key => $value) {
                    $cj->saveOrder($value, $col);
                }
            }
        }
        return true;
    }


    // 考试关联
    public function bjKaoshi()
    {
        return $this->belongsTo('\app\kaoshi\model\Kaoshi', 'kaoshi_id', 'id');
    }


    // 班级关联
    public function bjBanji()
    {
        return $this->belongsTo('\app\teach\model\Banji', 'banji_id', 'id');
    }


    // 学科关联
    public function bjSubject()
    {
        return $this->belongsTo('\app\teach\model\Subject', 'subject_id', 'id');
    }


    // 成绩统计结果关联
    public function bjJieguo()
    {
        $ksid = $this->getAttr('kaoshi_id');
        return $this->hasMany('\app\chengji\model\TongjiBj', 'banji_id', 'banji_id')
                ->where('kaoshi_id', $ksid);
    }


    // 区成绩统计结果关联
    public function quJieguo()
    {
        $sbjid = $this->getAttr('subject_id');
        return $this->belongsTo('\app\chengji\model\TongjiSch', 'kaoshi_id', 'kaoshi_id')
                ->where('subject_id', $sbjid);
    }


    // 教师关联
    public function bjTeacher()
    {
        return $this->belongsTo('\app\teacher\model\Teacher', 'teacher_id', 'id');
    }


    // 获取班级名称
    public function getBanjiTitleAttr()
    {
        $ks = new \app\kaoshi\model\Kaoshi;
        $ksInfo = $ks->where('id', $this->getAttr('kaoshi_id'))
            ->field('id, enddate')
            ->find();

        $bj = new \app\teach\model\Banji;
        $bjInfo = $bj->where('id', $this->getAttr('banji_id'))
            ->field('id, ruxuenian, alias, paixu')
            ->append(['banTitle'])
            ->find();

        $njlist = nianJiNameList('str', $ksInfo->getData('enddate'));
        $njname = $njlist[$bjInfo->ruxuenian];
        $title = $njname . $bjInfo->banTitle;

        return $title;
    }


    // 获取班级名称
    public function getBanTitleAttr()
    {
        $bj = $this->getAttr('bjBanji');

        $bjname = $bj->banTitle;

        $title = $bjname;

        return $title;
    }
}
