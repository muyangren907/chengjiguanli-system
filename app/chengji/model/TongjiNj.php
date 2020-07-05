<?php
namespace app\chengji\model;
// 引用基类
use app\BaseModel;
// 引用学生成绩统计类
use app\chengji\model\Tongji as TJ;

/**
 * @mixin think\Model
 */
class TongjiNj extends BaseModel
{
    // 统计所有参加本次考试年级的成绩
    public function tjNianji($kaoshi_id)
    {
        $src['kaoshi_id'] = $kaoshi_id;

        // 查询要统计成绩的学校
        $khSrc = new \app\kaohao\model\Search;
        $schoolList = $khSrc->cySchool($src);

        if(count($schoolList) == 0){
            return false;
        }
        // 查询要统计的年级
        $ksset = new \app\kaoshi\model\KaoshiSet;
        $njList = $ksset->srcNianji($kaoshi_id);

        // 实例化学生成绩统计类
        $tj = new TJ;
        foreach ($schoolList as $schkey => $school) {
            foreach ($njList as $njkey => $nianji) {
                $src = [
                    'kaoshi_id' => $kaoshi_id
                    ,'school_id' => $school['id']
                    ,'ruxuenian' => $nianji['nianji']
                ];
                $src['banji_id'] = array_column($khSrc->cyBanji($src), 'id');
                $subject = $ksset->srcSubject($kaoshi_id, '', $nianji['nianji']);
                $temp = $khSrc->srcChengjiList($src);
                $temp = $tj->tongjiSubject($temp, $subject);
                foreach ($temp['cj'] as $cjkey => $cj) {
                    // 查询该班级该学科成绩是否存在
                    $tongjiJg = $this->where('kaoshi_id', $src['kaoshi_id'])
                        ->where('school_id', $school['id'])
                        ->where('ruxuenian', $nianji['nianji'])
                        ->where('subject_id', $cj['id'])
                        ->find();
                    if($tongjiJg)
                    {
                        $tongjiJg->kaoshi_id = $src['kaoshi_id'];
                        $tongjiJg->school_id = $school['id'];
                        $tongjiJg->ruxuenian = $nianji['nianji'];
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
                            'kaoshi_id' => $src['kaoshi_id'],
                            'school_id' => $school['id'],
                            'ruxuenian' => $nianji['nianji'],
                            'subject_id' => $cj['id'],
                            'stu_cnt' => $cj['stucnt'],
                            'chengji_cnt' => $cj['xkcnt'],
                            'sum' => $cj['sum'],
                            'avg' => $cj['avg'],
                            'biaozhuncha' => $cj['biaozhuncha'],
                            'youxiu' => $cj['youxiu'],
                            'jige' => $cj['jige'],
                            'max' => $cj['max'],
                            'min' => $cj['min'],
                            'q1' => $cj['sifenwei'][0],
                            'q2' => $cj['sifenwei'][1],
                            'q3' => $cj['sifenwei'][2],
                            'zhongshu' => $cj['zhongshu'],
                            'zhongweihu' => $cj['zhongweishu'],
                            'defenlv' => $cj['defenlv'],
                        ];

                        $data = $this::create($tongjiJg);
                    }
                }
            }
        }

        return true;
    }


    // 根据条件查询年级成绩
    public function search($srcfrom)
    {
        // 初始化参数
        $src = array(
            'kaoshi_id'=>'',
            'ruxuenian'=>array(),
            'school_id'=>array(),
        );

        // 用新值替换初始值
        $src = array_cover($srcfrom, $src);
        $ruxuenian = $src['ruxuenian'];
        $school = strToarray($src['school_id']);
        $kaoshi = $src['kaoshi_id'];

        // 查询要统计成绩的学校
        $khSrc = new \app\kaohao\model\Search;
        $schoolList = $khSrc->cySchool($src);

        if(count($schoolList) == 0){
            return array();
        }

        $tongjiJg = $this
            ->where('kaoshi_id', $src['kaoshi_id'])
            ->where('ruxuenian', $src['ruxuenian'])
            ->when(count($src['school_id']) > 0, function ($query) use ($src) {
                $query->where('school_id', 'in', $src['school_id']);
            })
            ->field('kaoshi_id, school_id, ruxuenian')
            ->with([
                'njSchool' => function ($query) {
                    $query->field('id, paixu, jiancheng');
                },
                'njJieguo' => function ($query) {
                    $query->field('subject_id, school_id, ruxuenian, stu_cnt, chengji_cnt,
                        avg, youxiu, jige, biaozhuncha, max, min, q1, q2, q3, zhongshu, zhongweishu')
                        ->with([
                            'njSubject' => function($query){
                                $query->field('id, lieming, jiancheng, title');
                            },
                        ])
                        ->order(['subject_id']);
                }

            ])
            ->group('kaoshi_id, school_id, ruxuenian')
            ->select();

        // 重组数据
        $data = array();
        foreach ($tongjiJg as $key => $value) {
            $data[$value->school_id] = [
                'id' => $value->id
                ,'school_jiancheng' => $value->njSchool->jiancheng
                ,'school_paixu' => $value->njSchool->paixu
                ,'stuCnt' => $value->stu_cnt
                // 'title'=>$value->banjiTitle,
                // 'banjipaixu'=>$value->bjBanji->paixu,
            ];
            foreach ($value->njJieguo as $k => $val) {
                if($val->subject_id > 0){
                    $data[$value->school_id]['chengji'][$val->njSubject->lieming] = [
                        'avg' => $val->avg * 1
                        ,'youxiu' => $val->youxiu * 1
                        ,'jige' => $val->jige * 1
                        ,'cjCnt' => $val->chengji_cnt
                        ,'title' => $val->njSubject->title
                        ,'jiancheng' => $val->njSubject->jiancheng
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
                    $data[$value->school_id]['quanke'] = [
                        'avg' => $val->avg
                        ,'jige' => $val->jige
                    ];
                }

            }
        }
        $data = sortArrByManyField($data, 'school_paixu', SORT_ASC);

        return $data;
    }


    // 成绩排序
    public function njOrder($kaoshi_id)
    {
        $src = array('kaoshi_id' => $kaoshi_id);
        // 实例化学生成绩统计类
        $khSrc = new \app\kaohao\model\Search;
        $ksset = new \app\kaoshi\model\KaoshiSet;
        $cj = new \app\chengji\model\Chengji;
        $nianji = $ksset->srcNianji($kaoshi_id);
        $col = ['xpaixu', 'xweizhi'];

        // 循环年级
        $data = array();
        foreach ($nianji as $njkey => $value) {
            // 获取参加考试班级
            $src['ruxuenian'] = $value['nianji'];

            $school = $khSrc->cySchool($src);
            $subject = $ksset->srcSubject($kaoshi_id, '', $value['nianji']);

            // 循环班级，获取并统计成绩
            foreach ($school as $schkey => $val) {
                // 获取查询成绩参数
                $src['school_id'] = $val['id'];
                $banji = $khSrc->cyBanji($src);
                $srcfrom = [
                    'kaoshi_id' => $kaoshi_id
                    ,'school_id' => $val['id']
                    ,'banji_id' => array_column($banji, 'id')
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
    public function njKaoshi()
    {
        return $this->belongsTo('\app\kaoshi\model\Kaoshi', 'kaoshi_id', 'id');
    }

    // 学校关联
    public function njSchool()
    {
        return $this->belongsTo('\app\system\model\School', 'school_id', 'id');
    }

    // 学科关联
    public function njSubject()
    {
        return $this->belongsTo('\app\teach\model\Subject', 'subject_id', 'id');
    }

    // 成绩统计结果关联
    public function njJieguo()
    {
        $ruxuenian = $this->getAttr('ruxuenian');
        $kaoshi = $this->getAttr('kaoshi_id');
        return $this->hasMany('\app\chengji\model\TongjiNj', 'school_id', 'school_id')
            ->where('ruxuenian', $ruxuenian)
            ->where('kaoshi_id', $kaoshi);
    }

}
