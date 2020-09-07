<?php
namespace app\chengji\model;
// 引用基类
use \app\BaseModel;
// 引用学生成绩统计类
use app\chengji\model\Tongji as TJ;

/**
 * @mixin think\Model
 */
class TongjiSch extends BaseModel
{
    // 统计参加本次考试所有学校成绩
    public function tjSchool($kaoshi_id)
    {
        $src['kaoshi_id'] = $kaoshi_id;
        // 查询要统计的学校
        $cy = new \app\kaohao\model\SearchCanYu;
        $more = new \app\kaohao\model\SearchMore;
        // 查询要统计的年级
        $ksset = new \app\kaoshi\model\KaoshiSet;
        $njList = $ksset->srcGrade($kaoshi_id);

        // 实例化学生成绩统计类
        $tj = new TJ;
            foreach ($njList as $k => $nianji) {
                $src = [
                    'kaoshi_id' => $kaoshi_id
                    ,'ruxuenian' => $nianji['ruxuenian']
                ];
                $src['banji_id'] = array_column($cy->class($src), 'id');
                $subject = $ksset->srcSubject($src);
                $temp = $more->srcChengjiList($src);
                $temp = $tj->tongjiSubject($temp, $subject);
                foreach ($temp['cj'] as $k => $cj) {
                    // 查询该班级该学科成绩是否存在
                    $tongjiJg = $this->where('kaoshi_id', $src['kaoshi_id'])
                        ->where('ruxuenian', $nianji['ruxuenian'])
                        ->where('subject_id', $cj['id'])
                        ->find();
                    if($tongjiJg)
                    {
                        $tongjiJg->kaoshi_id = $src['kaoshi_id'];
                        $tongjiJg->ruxuenian = $nianji['ruxuenian'];
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
                            ,'ruxuenian' => $nianji['ruxuenian']
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

        return true;
    }


    // 根据条件查询学校成绩
    public function search($srcfrom)
    {
        // 初始化参数
        $src = array(
            'kaoshi_id' => ''
            ,'ruxuenian' => ''
        );
        $src = array_cover($srcfrom, $src);
        $kaoshi_id = $src['kaoshi_id'];

        $tongjiJg = $this
            ->where('kaoshi_id', $src['kaoshi_id'])
            ->where('ruxuenian', $src['ruxuenian'])
            ->field('kaoshi_id, ruxuenian')
            ->with([
                'schJieguo' => function ($query) use ($src) {
                    $query->field('subject_id, ruxuenian, chengji_cnt, avg, youxiu, jige')
                        ->where('kaoshi_id', $src['kaoshi_id'])
                        ->with([
                            'schSubject' => function($query){
                                $query->field('id, lieming, jiancheng');
                            },
                        ])
                        ->order(['subject_id']);
                }
            ])
            ->group('kaoshi_id, ruxuenian')
            ->select();

        // 重组数据
        $data = array();
        foreach ($tongjiJg as $key => $value) {
            $data['all'] = [
                'id' => $value->id
                ,'school_jiancheng' => '全区'
                ,'school_paixu' => 9999
            ];
            foreach ($value->schJieguo as $k => $val) {
                if ($val->subject_id > 0) {
                    $data['all']['chengji'][$val->schSubject->lieming] = [
                        'avg' => $val->avg
                        ,'youxiu' => $val->youxiu
                        ,'jige' => $val->jige
                        ,'cjCnt' => $val->chengji_cnt
                    ];
                }else{
                    $data['all']['quanke'] = [
                        'avg' => $val->avg
                        ,'jige' => $val->jige
                    ];
                }
            }
        }
        return $data;
    }



    // 成绩排序
    public function schOrder($kaoshi_id)
    {
        $src = array('kaoshi_id' => $kaoshi_id);
        // 实例化学生成绩统计类
        $cy = new \app\kaohao\model\SearchCanYu;
        $more = new \app\kaohao\model\SearchMore;
        $ksset = new \app\kaoshi\model\KaoshiSet;
        $cj = new \app\chengji\model\Chengji;
        $nianji = $ksset->srcGrade($kaoshi_id);

        // 循环年级
        $data = array();
        foreach ($nianji as $njkey => $value) {
            // 获取参加考试班级
            $src['ruxuenian'] = $value['ruxuenian'];
            $subject = $ksset->srcSubject($src);
            $banji = $cy->class($src);
            $col = [
                'qpaixu'
                ,'qweizhi'
            ];

            // 获取成绩
            $srcfrom = [
                'kaoshi_id' => $kaoshi_id
                ,'ruxuenian' => $value['ruxuenian']
                ,'banji_id' => array_column($banji, 'id')
            ];
            $temp = $more->srcChengjiSubject($srcfrom);
            // 循环计算成绩排序
            foreach ($temp as $key => $value) {
                $cj->saveOrder($value, $col);
            }
        }
        return true;
    }


    // 学科关联
    public function schSubject()
    {
        return $this->belongsTo('\app\teach\model\Subject', 'subject_id', 'id');
    }


    // 成绩统计结果关联
    public function schJieguo()
    {
        return $this->hasMany('\app\chengji\model\TongjiSch', 'ruxuenian', 'ruxuenian');
    }
}
