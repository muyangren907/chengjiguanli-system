<?php
namespace app\chengji\model;
// 引用基类
use app\common\model\Base;
// 引用学生成绩统计类
use app\chengji\model\Tongji as TJ;

/**
 * @mixin think\Model
 */
class TongjiSch extends Base
{
    /**  
    * 统计各学校的指定个年级的成绩
    * 统计项目参考tongji方法
    * @access public 
    * @param number $kaoshi 考试id
    * @param number $ruxuenian 入学年
    * @return array 返回类型
    */
    public function tjSchool($kaoshi)
    {
        $src['kaoshi'] = $kaoshi;
        // 查询我统计的年级
        $kh = new \app\kaoshi\model\Kaohao;

        
        // 查询要统计的年级
        $ks = new \app\kaoshi\model\Kaoshi;
        $ksinfo = $ks->where('id',$kaoshi)
                    ->field('id')
                    ->with(['ksNianji',
                        'ksSubject'=>function($query)
                        {
                            $query->field('kaoshiid,subjectid');
                        }
                    ])
                    ->find();
        $njList = $ksinfo->ksNianji;
        $subjectList =  $ksinfo->ksSubject;


        // 实例化学生成绩统计类
        $tj = new TJ;
            foreach ($njList as $k => $nianji) {
                $src = [
                    'kaoshi'=>$kaoshi,
                    'ruxuenian'=>$nianji->nianji,
                ];
                $temp = $kh->srcChengji($src);
                $temp = $tj->tongjiSubject($temp,$kaoshi);
                foreach ($temp as $k => $cj) {
                    // 查询该班级该学科成绩是否存在
                    $tongjiJg = $this->where('kaoshi_id',$src['kaoshi'])
                                    ->where('ruxuenian',$nianji->nianji)
                                    ->where('subject_id',$cj['id'])
                                    ->find();
                    if($tongjiJg)
                    {
                        $tongjiJg->kaoshi_id = $src['kaoshi'];
                        $tongjiJg->ruxuenian = $nianji->nianji;
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
                        $tongjiJg->qian = $cj['sifenwei'][0];
                        $tongjiJg->zhong = $cj['sifenwei'][1];
                        $tongjiJg->hou = $cj['sifenwei'][2];
                        $tongjiJg->zhong = $cj['zhongshu'];
                        $data = $tongjiJg->save();
                    }else{
                        // 重新组合统计结果
                        $tongjiJg = [
                            'kaoshi_id'=>$src['kaoshi'],
                            'ruxuenian'=>$nianji->nianji,
                            'subject_id'=>$cj['id'],
                            'stu_cnt'=>$cj['stucnt'],
                            'chengji_cnt'=>$cj['xkcnt'],
                            'sum'=>$cj['sum'],
                            'avg'=>$cj['avg'],
                            'biaozhuncha'=>$cj['biaozhuncha'],
                            'youxiu'=>$cj['youxiu'],
                            'jige'=>$cj['jige'],
                            'max'=>$cj['max'],
                            'min'=>$cj['min'],
                            'qian'=>$cj['sifenwei'][0],
                            'zhong'=>$cj['sifenwei'][1],
                            'hou'=>$cj['sifenwei'][2],
                            'zhongshu'=>$cj['zhongshu'],
                        ];

                        $data = $this::create($tongjiJg);
                    }
                }

        }
        
        return true;
    }
}
