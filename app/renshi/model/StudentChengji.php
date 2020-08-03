<?php
declare (strict_types = 1);

namespace app\Renshi\model;

// 引用数据模型基类
use app\BaseModel;

/**
 * @mixin think\Model
 */
class StudentChengji extends BaseModel
{
    // 一个学生所有学科成绩列表
    public function oneStudentChengjiList($srcfrom)
    {
        // 初始化参数
        $src = array(
            'student_id' => ''
            ,'category_id' => ''
            ,'xueqi_id' => ''
            ,'bfdate' => ''
            ,'enddate' => ''
        );
        $src = array_cover($srcfrom, $src);

        // 查询成绩
        $khSrc = new \app\kaohao\model\Search;
        $stuCj = $khSrc->srcOneStudentChengji($src);

        // 获取可以参加考试的学科
        $sbj = new \app\teach\model\Subject;
        $sbjList = $sbj->where('kaoshi', 1)
            ->where('status', 1)
            ->field('id, lieming')
            ->column('lieming', 'id');

        // 整理数据
        $data = array();
        foreach ($stuCj as $key => $value) {
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
    public function oneStudentSubjectChengji($srcfrom)
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
        );
        $src = array_cover( $srcfrom , $src );

        $khSrc = new \app\kaohao\model\Search;
        $stuCj = $khSrc->srcOneStudentChengji($src);


        // 获取可以参加考试的学科
        $sbj = new \app\teach\model\Subject;
        $sbjList = $sbj->where('kaoshi',1)
                        ->where('status',1)
                        ->field('id,lieming')
                        ->column('lieming','id');

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


    // 一个学生一个学科历次成绩
    public function oneStudentLeiDa($srcfrom)
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
                            $query->field('id, kaohao_id, subject_id, defen');
                        }
                    ])
                    ->find();

        // 参加考试学科
        $subject = subjectList(1,1);
        // 获取参加考试学科满分
        $ksset = new \app\kaoshi\model\KaoshiSet;
        $manfen = $ksset->srcSubject($khInfo->kaoshi_id, '', $khInfo->ruxuenian);

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
                        continue;
                    }
                    if(isset($bjcj['value'][$i]) == false)
                    {
                        $bjcj['value'][$i] = null;
                    }
                }
            }

            // 班级成绩
            if(isset($qcj['value'][$i]) == false)
            {
                foreach ($schcj as $sch_k => $sch_val) {
                    if($sbj_val['id'] == $sch_val->subject_id)
                    {
                        $qcj['value'][$i] = $sch_val->avg;
                        continue;
                    }
                    if(isset($qcj['value'][$i]) == false)
                    {
                        $qcj['value'][$i] = null;
                    }
                }
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

}
