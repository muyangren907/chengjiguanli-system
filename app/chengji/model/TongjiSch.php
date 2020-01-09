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
                foreach ($temp['cj'] as $k => $cj) {
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


    /**  
    * 年级成绩统计结果查询
    * 从数据库中取出数据
    * @access public 
    * @param number $kaoshi 考试id
    * @param number $ruxuenian 入学年
    * @return array 返回类型
    */
    public function search($srcfrom)
    {

        // 初始化参数 
        $src = array(
            'kaoshi'=>'',
            'ruxuenian'=>'',
        );

        // 用新值替换初始值
        $src = array_cover( $srcfrom , $src ) ;

        $kaoshi = $src['kaoshi'];


        $tongjiJg = $this
            ->where('kaoshi_id',$src['kaoshi'])
            ->where('ruxuenian',$src['ruxuenian'])
            ->field('kaoshi_id,ruxuenian')
            ->with([
                'schJieguo'=>function($query)use($kaoshi){
                    $query->field('subject_id,ruxuenian,chengji_cnt,avg,youxiu,jige')
                        ->where('kaoshi_id',$kaoshi)
                        ->with([
                            'schSubject'=>function($query){
                                $query->field('id,lieming,jiancheng');
                            },
                        ])
                        ->order(['subject_id']);
                }

            ])
            ->group('kaoshi_id,ruxuenian')
            ->select();



        // 初始化数组
        $data = array();

        // 重组数据
        foreach ($tongjiJg as $key => $value) {
            $data['all']=[
                'id'=>$value->id,
                'school'=>'全区',
                'schoolpaixu'=>999,
            ];
            foreach ($value->schJieguo as $k => $val) {
                if($val->subject_id>0){
                    $data['all']['chengji'][$val->schSubject->lieming] = [
                        'avg'=>$val->avg,
                        'youxiu'=>$val->youxiu,
                        'jige'=>$val->jige,
                        'cj_cnt'=>$val->chengji_cnt,
                    ];
                }else{
                    $data['all']['quanke'] = [
                        'avg'=>$val->avg,
                        'jige'=>$val->jige,
                    ];
                }
                
            }
        }

        return $data;
    }


    // 学科关联
    public function schSubject()
    {
        return $this->belongsTo('\app\teach\model\Subject','subject_id','id');
    }
    // 成绩统计结果关联
    public function schJieguo()
    {
        return $this->hasMany('\app\chengji\model\TongjiSch','ruxuenian','ruxuenian');
    }


}
