<?php
declare (strict_types = 1);

namespace app\tools\model;

// 引用数据模型基类
use app\BaseModel;

/**
 * @mixin think\Model
 */
class OneStudentChengji extends BaseModel
{
    // 一个学生所有学科历次成绩
    public function oldList($srcfrom)
    {
        // 初始化参数
        $src = array(
            'student_id' => ''
            ,'category_id' => ''
            ,'xueqi_id' => ''
            ,'bfdate' => ''
            ,'enddate' => ''
            ,'searchval' => ''
        );
        $src = array_cover($srcfrom, $src);

        // 查询成绩
        $one = new \app\kaohao\model\SearchOne;
        $stuCj = $one->oldChengji($src);

        // 获取可以参加考试的学科
        $sbj = new \app\teach\model\Subject;
        $sbjList = $sbj->where('kaoshi', 1)
            ->where('status', 1)
            ->field('id, lieming')
            ->column('lieming', 'id');

        // 整理数据
        $data = array();
        foreach ($stuCj as $key => $value) {
            if(!isset($value->cjKaoshi))
            {
                continue;
            }
            $data[$key] = [
                'kaoshi_id' => $value->kaoshi_id,
                'kaoshiTitle' => $value->cjKaoshi->title,
                'kaohao_id' => $value->id,
                'banjiTitle' => $value->banjiTitle,
                'zuzhi_id' => $value->cjKaoshi->ksZuzhi->jiancheng,
                'category_id' => $value->cjKaoshi->ksCategory->title,
                'bfdate' => $value->cjKaoshi->bfdate,
                'enddate' => $value->cjKaoshi->enddate,
            ];


            $cjcnt = count($value->ksChengji);

            if($cjcnt > 0)
            {
                $sbj = $value->ksChengji->column('subject_id');
                foreach ($sbjList as $sbj_k => $sbj_val) {
                    // 通过学科ID获取这个学科成绩对应的成绩下标。
                    // 这个地方需要再核实。
                    $xb = array_search($sbj_k, $sbj);      # ksChengji下标
                    if($xb === false)
                    {
                        $data[$key][$sbj_val] = '';
                    }else{
                        $data[$key][$sbj_val] = $value->ksChengji[$xb]->defen;
                    }
                }
                $defen = array_column($value->ksChengji->toArray(), 'defen');
                $sum = array_sum($defen );
                $avg = $sum / $cjcnt;
                $data[$key]['sum'] = $sum;
                $data[$key]['avg'] = round($avg,2);
            }else{
                foreach ($sbjList as $sbj_k => $sbj_val) {
                    $data[$key][$sbj_val] = '';
                }
                $data[$key]['sum'] = '';
                $data[$key]['avg'] = '';
            }
        }
        return $data;
    }


    // 一个学生一个学科历次成绩
    public function subjectOldChengji($srcfrom)
    {
        // 初始化参数
        $src = array(
            'student_id' => ''
            ,'kaoshi_id' => array()
            ,'subject_id' => ''
            ,'category_id' => ''
            ,'xueqi_id' => ''
            ,'bfdate' => ''
            ,'enddate' => ''
            ,'searchval' => ''
        );
        $src = array_cover($srcfrom, $src);

        $one = new \app\kaohao\model\SearchOne;
        $stuCj = $one->oldChengji($src);


        // 整理数据
        $data = array();
        $xAxis = array();
        $series = [
            0 => [
                'name'=>'得分率%',
                'type'=>'line',
                'data'=>array(),
            ],
            1 => [
                'name'=>'班级位置%',
                'type'=>'line',
                'data'=>array(),
            ],
            2 => [
                'name'=>'学校位置%',
                'type'=>'line',
                'data'=>array(),
            ],
            3 => [
                'name'=>'全部位置%',
                'type'=>'line',
                'data'=>array(),
            ],
        ];
        foreach ($stuCj as $key => $value) {
            $cjcnt = count($value->ksChengji);
            if($cjcnt > 0)
            {
                foreach ($value->ksChengji as $sbj_k => $sbj_val) {
                    if($src['subject_id'] == $sbj_val->subject_id)
                    {
                        $xAxis[] = $value->cjKaoshi->title;
                        $series['0']['data'][] = $sbj_val->defenlv;
                        $series['1']['data'][] = round($sbj_val->bweizhi,0);
                        $series['2']['data'][] = round($sbj_val->xweizhi,0);
                        $series['3']['data'][] = round($sbj_val->qweizhi,0);
                    }
                }
            }
        }

        $data = [
            'xAxis' => $xAxis
            ,'series' => $series
            ,'legend' => [
                '得分率%'
                ,'班级位置%'
                ,'学校位置%'
                ,'全部位置%'
            ]
        ];

        return $data;
    }


    // 该学生本次考试各学科成绩雷达图
    public function leiDa($srcfrom)
    {
        // 初始化参数
        $src = array(
            'kaohao_id' => '',
        );

        // 用新值替换初始值
        $src = array_cover($srcfrom, $src);

        $kh = new \app\kaohao\model\Kaohao;
        // 考号信息
        $khInfo = $kh->where('id', $src['kaohao_id'])
                    ->with([
                        'ksChengji'=>function($query){
                            $query->field('id,kaohao_id,subject_id,defen');
                        }
                    ])
                    ->find();

        // 参加考试学科
        $sbj = new \app\teach\model\Subject;
        $subject = subjectKaoshiList();
        // 获取参加考试学科满分
        $ksset = new \app\kaoshi\model\KaoshiSet;
        $manfen = $ksset->srcSubject($khInfo->kaoshi, '', $khInfo->ruxuenian);

        // 查询区成绩
        $SchoolChengji = new \app\chengji\model\TongjiSch;
        $schcj = $SchoolChengji
                    ->where('kaoshi_id',$khInfo->kaoshi_id)
                    ->where('ruxuenian',$khInfo->ruxuenian)
                    ->select();

        // 循环写入成绩
        $indicator = array();
        $legend = ['得分','全体平均分'];
        $bjcj = array();
        $bjcj['name'] = '得分';
        $qcj = array();
        $qcj['name'] = '全体平均分';
        $i = 0;

        foreach ($subject as $sbj_k => $sbj_val) {

            // 试卷满分
            if(isset($indicator[$i]) == false)
            {
                $indicator[$i]['name'] = $sbj_val->title;
                foreach ($manfen  as $mf_k => $mf_val) {
                    if($sbj_val['id'] == $mf_val['id'])
                    {
                        $indicator[$i]['max'] = $mf_val['fenshuxian']['manfen'];
                        continue;
                    }
                    if(isset($indicator[$i]) == false)
                    {
                        $indicator[$i]['max'] = null;
                    }
                }
            }

            // 学生成绩
            if(isset($bjcj['value'][$i]) == false)
            {
                foreach ($khInfo->ksChengji as $cj_k => $cj_val) {
                    if($sbj_val['id'] == $cj_val->subject_id)
                    {
                        $bjcj['value'][$i] = $cj_val->defen;
                        unset($khInfo->ksChengji[$cj_k]);
                        continue;
                    }
                }
            }
            if(isset($bjcj['value'][$i]) == false)
                    {
                        $bjcj['value'][$i] = null;
                    }

            // 班级成绩
            if(isset($qcj['value'][$i]) == false)
            {
                foreach ($schcj as $sch_k => $sch_val) {
                    if($sbj_val['id'] == $sch_val->subject_id)
                    {
                        $qcj['value'][$i] = $sch_val->avg;
                        unset($schcj[$sch_k]);
                        continue;
                    }

                }
            }
            if(isset($qcj['value'][$i]) == false)
            {
                $qcj['value'][$i] = null;
            }

            $i++;
        }

        $data = [
            'title' => '学生成绩'
            ,'legend' => $legend
            ,'indicator' => $indicator
            ,'series' => [
                'name'=>'成绩'
                ,'type' => 'radar'
                ,'data' => [$bjcj, $qcj]
            ]
        ];

        return $data;
    }


    // 学生成绩总分在班级排序
    public function zfPaixu($srcfrom)
    {
        // 初始化参数
        $src = array(
            'kaohao_id' => '',
        );
        // 用新值替换初始值
        $src = array_cover($srcfrom, $src);

        // 成绩查询信息
        $kh = new \app\kaohao\model\Kaohao;         #该考号对应的考试信息。
        $khInfo = $kh->where('id', $src['kaohao_id'])
                ->field('id, banji_id, school_id, ruxuenian, kaoshi_id')
                ->with([
                    'ksChengji' => function ($query) {
                        $query->field('id, kaohao_id, defen');
                    }
                ])
                ->find();
        $paixu['sum'] = 0;
        foreach ($khInfo->ksChengji as $key => $value) {
            $paixu['sum'] = $paixu['sum'] + $value->defen;
        }

        // 实例化并查询成绩
        $cj = new \app\chengji\model\Chengji;
        // 获取班级位置
        $src['kaoshi_id'] = $khInfo->kaoshi_id;
        $src['ruxuenian'] = $khInfo->ruxuenian;
        $src['banji_id'] = $khInfo->banji_id;
        $data = $cj->search($src);
        $data = sortArrByManyField($data, 'sum', SORT_DESC);
        $data = array_column($data, 'id');
        $rank = array_search($src['kaohao_id'], $data);
        $paixu['ban']['paixu'] = $rank;
        $paixu['ban']['weizhi'] = round(($rank + 1) / count($data) * 100, 0);
        // 获取区位置
        $cy = new \app\kaohao\model\SearchCanYu;
        $src['banji_id'] = array_column($cy->class($src), 'id');
        $data = $cj->search($src);
        $data = sortArrByManyField($data, 'sum', SORT_DESC);
        $data = array_column($data, 'id');
        $rank = array_search($src['kaohao_id'], $data);
        $paixu['qu']['paixu'] = $rank;
        $paixu['qu']['weizhi'] = round(($rank + 1) / count($data) * 100, 0);
        // 获取年级位置
        $src['school_id'] = $khInfo->school_id;
        $src['banji_id'] = array_column($cy->class($src), 'id');
        $data = $cj->search($src);
        $data = sortArrByManyField($data, 'sum', SORT_DESC);
        $data = array_column($data, 'id');
        $rank = array_search($src['kaohao_id'], $data);
        $paixu['xiao']['paixu'] = $rank;
        $paixu['xiao']['weizhi'] = round(($rank + 1) / count($data) * 100, 0);

        return $paixu;
    }


    // 该学生本次考试各学科成绩仪表图
    public function yiBiao($srcfrom)
    {
        // 初始化参数
        $src = array(
            'kaohao_id' => '',
        );
        // 用新值替换初始值
        $src = array_cover($srcfrom, $src);
        $paixu = $this->zfPaixu($srcfrom);
        $data = [
                'title' => '总分：' . $paixu['sum']
                ,'series' => [
                    'name'=>'总成绩'
                    ,'type' => 'gauge'
                    // ,'detail' => $rank . '%'
                    ,'data' => [['value'=>$paixu['ban']['weizhi'], 'name'=>'位置']]
                ]
            ];

        return $data;
    }


    // 查询某个学生单次所有学科成绩
    public function oneChengji($srcfrom)
    {
        // 初始化参数
        $src = array(
            'kaohao_id' => '',
        );

        // 用新值替换初始值
        $src = array_cover($srcfrom, $src);

        // 成绩查询信息
        $kh = new \app\kaohao\model\Kaohao;         #该考号对应的考试信息。
        $khInfo = $kh->where('id', $src['kaohao_id'])
                ->with([
                    'ksChengji' => function ($query) {
                        $query->field('id, subject_id, defen, kaohao_id, defenlv, qweizhi')
                            ->with([
                                'subjectName' => function($q) {
                                    $q->field('id, title');
                                }
                            ]);
                    }
                ])
                ->find();

        $data = array();

        $schtj = new \app\chengji\model\TongjiSch;
        $schtjInfo = $schtj->where('kaoshi_id', $khInfo->kaoshi_id)
                ->field('max,min,subject_id')
                ->column(('max,min'),'subject_id');

        foreach ($khInfo->ksChengji as $key => $value) {
            $data[] = [
                'id' => $value->id
                ,'subject_name' => $value->subjectName->title
                ,'subject_id' => $value->subject_id
                ,'defen' => $value->defen
                ,'defenlv' => $value->defenlv
                ,'qweizhi' => $value->qweizhi
                ,'max' => $schtjInfo[$value->subject_id]['max']
                ,'min' => $schtjInfo[$value->subject_id]['min']
            ];
        }

        return $data;
    }


    // 本次考试各学科的得分率
    public function oneDeFenLv($srcfrom)
    {
        // 初始化参数
        $src = array(
            'kaohao_id' => '',
        );

        // 用新值替换初始值
        $src = array_cover($srcfrom, $src);

        // 获取学生成绩
        $list = $this->oneChengji($src);
        $category = array();
        $data = array();
        foreach ($list as $key => $value) {
            $category[] = $value['subject_name'];
            $data[] = $value['defenlv'];
        }
        $data = [
            'xAxis' => [
                'type' => 'category'
                ,'data' => $category
            ]
            ,'yAxis' => [
                'type' => 'value'
                ,'data' => ''
            ]
            ,'series' => [
                [
                    'data' => $data
                    ,'name' => '得分率%'
                    ,'type' => 'bar'
                    ,'label' => [
                        'show' => true
                        ,'position'=>'top' // 在上方显示
                        ,'textStyle' => [
                            'color' => 'black',
                            'fontSize' => 12
                        ]
                    ]
                ],
            ]
        ];
        return $data;
    }


    // 本次考试各学科成绩位置
    public function oneSubjectWeiZhi($srcfrom)
    {
        // 初始化参数
        $src = array(
            'kaohao_id' => '',
        );

        // 用新值替换初始值
        $src = array_cover($srcfrom, $src);

        // 获取学生成绩
        $list = $this->oneChengji($src);
        $category = array();
        $data = array();
        foreach ($list as $key => $value) {
            $category[] = $value['subject_name'];
            $data[] = round($value['qweizhi'], 0);
        }
        $data = [
            'xAxis' => [
                'type' => 'value'
                ,'data' => ''
            ]
            ,'yAxis' => [
                'type' => 'category'
                ,'data' => $category
            ]
            ,'series' => [
                [
                    'data' => $data
                    ,'name' => '排名%'
                    ,'type' => 'bar'
                    ,'label' => [
                        'show' => true
                        ,'position'=>'insideRight' // 在上方显示
                        ,'textStyle' => [
                            'color' => 'black',
                            'fontSize' => 12
                        ]
                    ]
                ],
            ]
        ];

        return $data;
    }


    // 生成学生单次考试成绩报告
    public function baogao($srcfrom)
    {
        // 初始化参数
        $src = array(
            'kaohao_id' => '',
        );
        // 用新值替换初始值
        $src = array_cover($srcfrom, $src);

        $oneCj = new \app\kaohao\model\SearchOne;
        $thisCj = $oneCj->oneKaohaoChengji($src['kaohao_id']);
        // halt($thisCj->toArray());


        $xingming = $thisCj->cjStudent->xingming;
        $ksTitle = $thisCj->cjKaoshi->title;
        $subjectCnt = count($thisCj->ksChengji);
        $kslx = $thisCj->cjKaoshi->ksCategory->title;
        $zpx = $this->zfPingyu($src);
        $tempSrc = [
            'kaoshi_id' => $thisCj->kaoshi_id
            ,'banji_id' => $thisCj->banji_id
            ,'cj' => $thisCj->ksChengji->toArray()
        ];

        $xkdb = $this->subjectDuibi($tempSrc);  # 学科成绩对比
        $xbbanjidb = $this->subjectAvgDuibi($tempSrc);
        $lastdb = $this->lastDb($src['kaohao_id']);


        $str = $xingming . '同学，你在《'.$ksTitle.'》'.$kslx.'中参加了' . $subjectCnt . '个学科的成绩测试，';
        $str = $str . '从总分上看你的成绩' .$zpx. '。' . $xkdb . $xbbanjidb;
        $str = $str . $lastdb;
        return $str;
    }


    // 总成绩位置评语
    private function zfPingyu($srcfrom)
    {
        // 初始化参数
        $src = array(
            'kaohao_id' => '',
        );
        // 用新值替换初始值
        $src = array_cover($srcfrom, $src);

        // 获取本次总分位置
        $zfPaixu = $this->zfPaixu($src);
        $zfPaixu = $zfPaixu['ban']['weizhi'];
        $zpx = '';
        switch ($zfPaixu) {
            case $zfPaixu >= 90:
                $zpx = '特别优秀';
                break;
            case $zfPaixu >= 80:
                $zpx = '很优秀';
                break;
            case $zfPaixu >= 70:
                $zpx = '良好';
                break;
            case $zfPaixu >= 60:
                $zpx = '合格';
                break;
            case $zfPaixu >= 45:
                $zpx = '差一点就合格啦';
                break;
            case $zfPaixu >= 25:
                $zpx = '离合格还差一些';
                break;
            case $zfPaixu >= 0:
                $zpx = '还有很大提升空间';
                break;
            default:
                $zpx = '还不错';
                break;
        }

        return $zpx;
    }


    // 本次考试各学科成绩对比
    private function subjectDuibi($src)
    {
        $cj = array();
        foreach ($src['cj'] as $key => $value) {
            $cj[$key] = $value['defenlv'];
        }
        $py = '';
        arsort($cj);
        $cjCnt = count($cj);

        if ($cjCnt<=1)
        {
            $py = '';
        }else{
            $tj = new \app\chengji\model\Tongji;
            $avg = round(array_sum($cj) / $cjCnt,2);
            $bzc = $tj->getVariance($avg, $cj, true);
            $bzcpy = '本次考试中各学科成绩';
            switch ($bzc) {
                case $bzc < 5:
                    $bzcpy = $bzcpy . '几乎没有差距，';
                    break;
                case $bzc < 10:
                    $bzcpy = $bzcpy . '有点差距，';
                    break;
                case $bzc < 15:
                    $bzcpy = $bzcpy . '有些差距，';
                    break;
                case $bzc < 20:
                    $bzcpy = $bzcpy . '差距有点大，';
                    break;
                case $bzc < 20:
                    $bzcpy = $bzcpy . '差距非常大，';
                    break;

                default:
                    $bzcpy = $bzcpy . '不均衡，';
                    break;
            }
            if ($cjCnt == 2)
            {
                $key = array_search(reset($cj), $cj);
                $xkMax = $src['cj'][$key]['subjectName']['title'];
                $key = array_search(end($cj), $cj);
                $xkMin = $src['cj'][$key]['subjectName']['title'];
            } else {
                $legend = round($cjCnt * 0.3, 0);
                for ($i = 1; $i <= $legend; $i++)
                {
                    if ($i == 1)
                    {
                        $key = array_search(reset($cj), $cj);
                        $xkMax = $src['cj'][$key]['subjectName']['title'];
                    } else {
                         next($cj);
                         $key = key($cj);
                         $xkMax = $xkMax . '、' .$src['cj'][$key]['subjectName']['title'];
                    }
                }
                for ($i = 1; $i <= $legend; $i++)
                {
                    if ($i == 1)
                    {
                        $key = array_search(end($cj), $cj);
                        $xkMin = $src['cj'][$key]['subjectName']['title'];
                    } else {
                         prev($cj);
                         $key = key($cj);
                         $xkMin = $xkMin . '、' .$src['cj'][$key]['subjectName']['title'];
                    }
                }
            }
            if($bzc == 0)
            {
                $py = $bzcpy;
            }else{
               $py = $bzcpy . $xkMax . '成绩比' . $xkMin . '成绩好一些。';
            }
        }

        return $py;
    }


    // 本次考试各学科成绩与班级平均分对比
    private function subjectAvgDuibi($src)
    {
        // 与班级平均分对比
        $cj = array();
        foreach ($src['cj'] as $key => $value) {
           $cj[$value['subject_id']]['defen'] = $value['defen'];
           $cj[$value['subject_id']]['oldkey'] = $key;
        }
        $btj = new \app\chengji\model\TongjiBj;
        $btCj = $btj->where('kaoshi_id', $src['kaoshi_id'])
                    ->where('banji_id', $src['banji_id'])
                    ->select();
        $avg = array();
        foreach ($btCj as $key => $value) {
            $avg[$value->subject_id] = $value->avg;
        }
        $avgCha = array();
        $zhengfu = [
            'fu' => 0
            ,'ling' => 0
            ,'zheng' => 0
        ];
        foreach ($cj as $key => $value) {
            $temp = $value['defen'] - $avg[$key];
            $avgCha[$value['oldkey']] = $temp;
            if($temp < 0)
            {
                $zhengfu['fu'] ++;
            }elseif($temp == 0)
            {
                $zhengfu['ling'] ++;
            }else{
                $zhengfu['zheng'] ++;
            }
        }
        $bjdbpy = '与班级平均分对比，'; #与班级平均分对比结果
        $cjCnt = count($src['cj']);
        $zheng = '';
        $ling = '';
        $fu = '';
        $py = '';

        // 比平均分多
        if($zhengfu['zheng'] > 0)
        {
            if($zhengfu['zheng'] == $cjCnt)
            {
                $zheng = $zheng . '所有学科成绩高于班级平均分，';
            }else{
                $xk = '';
                foreach ($avgCha as $key => $value) {
                    if($value > 0)
                    {
                        if($xk == '')
                        {
                            $xk = $src['cj'][$key]['subjectName']['title'];
                        }else{
                            $xk = $xk . '、' . $src['cj'][$key]['subjectName']['title'];
                        }
                    }
                }
                $zheng = $zheng . $xk . '成绩高于班级平均分';
            }
            arsort($avgCha);
            $key = array_search(reset($avgCha), $avgCha);
            $xk = $src['cj'][$key]['subjectName']['title'];
            if($zhengfu['zheng'] == 1)
            {
                $zheng = $zheng . reset($avgCha) .'分';
            }else{
                $zheng = $zheng . ',其中' . $xk .'成绩高于班级平均' . reset($avgCha) .'分';
            }

        }


        // 与平均分同样多
        if($zhengfu['ling'] > 0)
        {
            if($zhengfu['ling'] == $cjCnt)
            {
                $ling = $ling . '所有学科成绩与班级平均分相同';
            }else{
                $xk = '';
                foreach ($avgCha as $key => $value) {
                    if($value == 0)
                    {
                        if($xk == '')
                        {
                            $xk = $src['cj'][$key]['subjectName']['title'];
                        }else{
                            $xk = $xk . '、' . $src['cj'][$key]['subjectName']['title'];
                        }
                    }
                }
                $ling = $ling . $xk . '成绩与班级平均分相同';
            }
        }


        // 比平均分少
        if($zhengfu['fu'] > 0)
        {
            if($zhengfu['fu'] == $cjCnt)
            {
                $fu = $fu . '所有学科成绩低于班级平均分，';
            }else{
                $xk = '';
                foreach ($avgCha as $key => $value) {
                    if($value < 0)
                    {
                        if($xk == '')
                        {
                            $xk = $src['cj'][$key]['subjectName']['title'];
                        }else{
                            $xk = $xk . '、' . $src['cj'][$key]['subjectName']['title'];
                        }
                    }
                }
                $fu = $fu . $xk . '成绩低于班级平均分';
            }
            arsort($avgCha);
            $key = array_search(end($avgCha), $avgCha);
            $xk = $src['cj'][$key]['subjectName']['title'];
            if($zhengfu['fu'] == 1)
            {
                $fu = $fu . abs(end($avgCha)) .'分。';
            }else{
                $fu = $fu . ',其中' . $xk .'成绩低与班级平均' . abs(end($avgCha)) .'分。';
            }

        }

        if(strlen($zheng) > 0)
        {
            if(strlen($ling)>0 || strlen($fu)>0)
            {
                $py = $bjdbpy . $zheng . ',';
            }else{
                $py = $bjdbpy . $zheng . '。';
            }
        }

        if(strlen($ling) > 0)
        {
            if(strlen($fu) > 0)
            {
                $py = $py . $ling . '，' . $fu;
            }else{
                $py = $py . $ling . '。';
            }
        }

        return $py;
    }



    // 对比上次成绩
    private function lastDb($kaohao_id)
    {
        $py = '';
        $kh = new \app\kaohao\model\Kaohao;
        $thisCj = $kh->where('id', $kaohao_id)
            ->field('id, student_id, kaoshi_id')
            ->with([
                'ksChengji' => function ($query) {
                    $query->field('id, kaohao_id, subject_id, bpaixu, xpaixu, qpaixu')
                        ->with([
                            'subjectName' => function ($query) {
                                $query->field('id, title');
                            }
                        ]);
                },
                'cjKaoshi' => function ($query) {
                    $query->field('id, enddate');
                }
            ])
            ->find();
        $student_id = $thisCj->student_id;
        $subject_id = array();
        $subject_title = array();
        foreach ($thisCj->ksChengji as $key => $value) {
            $subject_id[] = $value->subject_id;
            $subject_title[$value->subject_id] = $value->subjectName->title;
        }

        $thisPaixu = array();
        foreach ($thisCj->ksChengji as $key => $value) {
            $thisPaixu[$value->subject_id] = $value['bpaixu'];
        }

        $enddate = $thisCj->cjKaoshi->getData('enddate');

        $cj = new \app\chengji\model\Chengji;
        $lastCj = $cj->where('subject_id', 'in', $subject_id)
                ->where('kaohao_id', 'in', function ($query) use ($student_id, $kaohao_id, $enddate) {
                    $query->name('kaohao')
                        ->where('id', '<>', $kaohao_id)
                        ->where('student_id', $student_id)
                        ->where('kaoshi_id', 'in', function ($q) use($enddate) {
                            $q->name('kaoshi')
                                ->where('enddate', '<', $enddate)
                                ->field('id');
                        })
                        ->field('id');
                })
                ->field('id, kaohao_id, subject_id, bpaixu, xpaixu, qpaixu')
                ->select();

        $lastPaixu = array();
        foreach ($lastCj as $key => $value) {
            $lastPaixu[$value->subject_id] = $value->bpaixu;
        }
        if(count($lastPaixu) == 0)
        {
            return $py;
        }

        // 循环对比成绩
        $cha = array();
        $zhengfu = [
            'zheng' => 0
            ,'ling' => 0
            ,'fu' => 0
        ];
        $zheng = '';
        $ling = '';
        $fu = '';

        foreach ($thisPaixu as $key => $value) {
            if(isset($lastPaixu[$key]))
            {
                $cha[$key] = $lastPaixu[$key] - $value;
                if ($cha[$key] < 0)
                {
                    $zhengfu['fu'] ++;
                }elseif($cha[$key] == 0)
                {
                    $zhengfu['ling'] ++;
                }else{
                    $zhengfu['zheng'] ++;
                }
            }
        }
        arsort($cha);

        // 名次上的评语
        if($zhengfu['zheng'] > 0)
        {
            $xk = '';
            foreach ($cha as $key => $value) {
                if($value > 0)
                {
                    if($xk == '')
                    {
                        $xk = $subject_title[$key];
                    }else{
                        $xk = $xk . '、' . $subject_title[$key];
                    }
                }
            }
            if($zhengfu['zheng'] == 1)
            {
                $zheng = $xk . '成绩上升';
            }else{
                reset($cha);
                $t = key($cha);
                $zheng = $xk .  '成绩上升，其中' . $subject_title[$t] . '成绩上升最多';
            }
        }


        // 名次相同的评语
        if($zhengfu['ling'] > 0)
        {
            $xk = '';
            foreach ($cha as $key => $value) {
                if($value == 0)
                {
                    if($xk == '')
                    {
                        $xk = $subject_title[$key];
                    }else{
                        $xk = $xk . '、' . $subject_title[$key];
                    }
                }
            }
            $ling = $xk . '成绩保持原来水平';
        }


        // 名次下降的评语
        if($zhengfu['fu'] > 0)
        {
            $xk = '';
            foreach ($cha as $key => $value) {
                if($value < 0)
                {
                    if($xk == '')
                    {
                        $xk = $subject_title[$key];
                    }else{
                        $xk = $xk . '、' . $subject_title[$key];
                    }
                }
            }
            if($zhengfu['fu'] == 1)
            {
                $fu = $xk . '成绩下降';
            }else{
                end($cha);
                $t = key($cha);
                $fu = $xk .  '成绩下降，其中' . $subject_title[$t] . '成绩下降最多';
            }
        }


        $bjdbpy = '与上次考试成绩相比';
        if(strlen($zheng) > 0)
        {
            if(strlen($ling)>0 || strlen($fu)>0)
            {
                $py = $bjdbpy . $zheng . ',';
            }else{
                $py = $bjdbpy . $zheng . '。';
            }
        }

        if(strlen($ling) > 0)
        {
            if(strlen($fu) > 0)
            {
                $py = $py . $ling . '，' . $fu;
            }else{
                $py = $py . $ling . '。';
            }
        }

        if(strlen($fu) > 0)
        {
            $py = $py . $fu . '。';
        }

        return $py;
    }


}
