<?php
namespace app\chengji\model;

// 引用基类
use app\BaseModel;
// 引用学生成绩统计类
use app\chengji\model\Tongji as TJ;


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
        $khSrc = new \app\kaohao\model\Search;
        $ksset = new \app\kaoshi\model\KaoshiSet;
        $nianji = $ksset->srcNianji($kaoshi_id);

        // 循环年级统计结果
        $data = array();
        foreach ($nianji as $njkey => $value) {
            // 获取参加考试班级
            $src['ruxuenian'] = $value['nianji'];
            $banji = $khSrc->cyBanji($src);
            $subject = $ksset->srcSubject($kaoshi_id, '', $value['nianji']);

            // 循环班级，获取并统计成绩
            foreach ($banji as $bjkey => $val) {
                $srcfrom = [
                    'kaoshi_id' => $kaoshi_id
                    ,'banji_id' => $val['id']
                ];
                $temp = $khSrc->srcChengjiList($srcfrom);
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
        $tj = new TJ;
        $khSrc = new \app\kaohao\model\Search;
        $ksset = new \app\kaoshi\model\KaoshiSet;

        // 获取参加考试学科
        $subject = $ksset->srcSubject($src['kaoshi_id'], '', $src['ruxuenian']);
        $banji =$khSrc->cyBanji($src);

        // 获取并统计各班级成绩
        $data = array();
        $srcfrom['kaoshi_id'] = $src['kaoshi_id'];
        foreach ($banji as $key => $value) {
            $srcfrom['banji_id'] = $value['id'];
            $temp = $khSrc->srcChengjiList($srcfrom);
            $temp = $tj->tongjiCnt($temp, $subject);
            $data[] = [
                'banji_id' => $value['banjiTitle']
                ,'banjinum' => $value['banjiTitle']
                ,'school_id' => $value['schJiancheng']
                ,'chengji' => $temp
            ];
        }

        $srcfrom['banji_id'] = array_column($banji, 'id');
        $temp = $khSrc->srcChengjiList($srcfrom);
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
        );

        $src = array_cover($srcfrom, $src);
        $src['banji_id'] = strToArray($src['banji_id']);

        // 实例化学生成绩统计类
        $tj = new TJ;
        $khSrc = new \app\kaohao\model\Search;
        $ksset = new \app\kaoshi\model\KaoshiSet;

        // 获取参加考试学科
        $subject = $ksset->srcSubject($src['kaoshi_id'], '', $src['ruxuenian']);
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
        $cj = $khSrc->srcChengjiList($src);
        if (array_key_exists($lieming, $cj[0]))
        {
            $cjcol = array_column($cj, $lieming);
            $cjcol = array_filter($cjcol, function($item){
                return $item !== null;
            });
            if (count($cjcol) > 0)
            {
                
                $data = $tj->fenshuduan($cjcol, $fsx);
            }
        }

        return $data;
    }


    // 根据条件查询各班级成绩
    public function search($srcfrom)
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
                'bjBanji'=>function($query){
                    $query
                        ->field('id, school_id, paixu')
                        ->with([
                            'glSchool'=>function($query){
                                $query->field('id, jiancheng, paixu');
                            },
                        ]);
                },
                'bjJieguo'=>function($query){
                    $query->field('subject_id, banji_id, stu_cnt,
                        chengji_cnt, avg, youxiu, jige, biaozhuncha,
                        max, min, q1, q2, q3')
                        ->with([
                            'bjSubject' => function($query){
                                $query->field('id, lieming, jiancheng, title');
                            },
                        ])
                        ->order(['subject_id']);
                }
            ])
            // ->cache(true)
            ->group('banji_id, kaoshi_id')
            ->append(['banjiTitle'])
            ->select();

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
            $data = sortArrByManyField($data, 'school_paixu', SORT_ASC, 'banji_paixu', SORT_ASC);
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
            $src['bfdate'] = date("Y-m-d", strtotime("-1 year"));
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
        $khSrc = new \app\kaohao\model\Search;
        $ksset = new \app\kaoshi\model\KaoshiSet;
        $cj = new \app\chengji\model\Chengji;
        $nianji = $ksset->srcNianji($kaoshi_id);
        $col = ['bpaixu', 'bweizhi'];

        // 初始化统计结果
        $data = array();
        foreach ($nianji as $njkey => $value) {
            // 获取参加考试班级
            $src['ruxuenian'] = $value['nianji'];
            $banji = $khSrc->cyBanji($src);
            $subject = $ksset->srcSubject($kaoshi_id, '', $value['nianji']);

            // 循环班级，获取并统计成绩
            foreach ($banji as $bjkey => $val) {
                // 获取成绩
                $srcfrom = [
                    'kaoshi_id' => $kaoshi_id,
                    'banji_id' => $val['id'],
                ];
                $temp = $khSrc->srcChengjiSubject($srcfrom);
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


    // 获取班级名称
    public function getBanjiTitleAttr()
    {
        $khSrc = new \app\kaohao\model\Search;
        $src = [
            'kaoshi_id' => $this->getAttr('kaoshi_id'),
            'banji_id' => $this->getAttr('banji_id'),
        ];

        $bj = $khSrc->cyBanji($src);
        return $bj[0]['banjiTitle'];
    }
}
