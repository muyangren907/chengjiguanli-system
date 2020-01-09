<?php
namespace app\chengji\model;
// 引用基类
use app\common\model\Base;
// 引用学生成绩统计类
use app\chengji\model\Tongji as TJ;

/**
 * @mixin think\Model
 */
class TongjiNj extends Base
{
    /**  
    * 统计各学校的指定个年级的成绩
    * 统计项目参考tongji方法
    * @access public 
    * @param number $kaoshi 考试id
    * @param number $ruxuenian 入学年
    * @return array 返回类型
    */
    public function tjNianji($kaoshi)
    {
        $src['kaoshi'] = $kaoshi;

        // 查询要统计成绩的学校
        $kh = new \app\kaoshi\model\Kaohao;
        $schoolList = $kh->cySchool($src);

        if(count($schoolList) == 0){
            return array();
        }
        // 查询我统计的年级
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
        foreach ($schoolList as $key => $school) {
            foreach ($njList as $k => $nianji) {
                    $src = [
                        'kaoshi'=>$kaoshi,
                        'school'=>$school['school'],
                        'ruxuenian'=>$nianji->nianji,
                    ];
                    $temp = $kh->srcChengji($src);
                    $temp = $tj->tongjiSubject($temp,$kaoshi);
                    foreach ($temp['cj'] as $k => $cj) {
                        // 查询该班级该学科成绩是否存在
                        $tongjiJg = $this->where('kaoshi_id',$src['kaoshi'])
                                        ->where('school_id',$school['school'])
                                        ->where('ruxuenian',$nianji->nianji)
                                        ->where('subject_id',$cj['id'])
                                        ->find();
                        if($tongjiJg)
                        {
                            $tongjiJg->kaoshi_id = $src['kaoshi'];
                            $tongjiJg->school_id = $school['school'];
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
                                'school_id'=>$school['school'],
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
            'ruxuenian'=>array(),
            'school'=>array(),
        );

        // 用新值替换初始值
        $src = array_cover( $srcfrom , $src ) ;

        $ruxuenian = $src['ruxuenian'];
        $school = strToarray($src['school']);
        $kaoshi = $src['kaoshi'];



        // 查询要统计成绩的学校
        $kh = new \app\kaoshi\model\Kaohao;
        $schoolList = $kh->cySchool($src);


        if(count($schoolList) == 0){
            return array();
        }


        $tongjiJg = $this
            ->where('kaoshi_id',$src['kaoshi'])
            ->where('ruxuenian',$src['ruxuenian'])
            ->when(count($school)>0,function($query) use($school){
                $query->where('school_id','in',$school);
            })
            ->field('kaoshi_id,school_id,ruxuenian')
            ->with([
                'njSchool'=>function($query){
                    $query->field('id,paixu,jiancheng');
                },
                'njJieguo'=>function($query) use($ruxuenian,$kaoshi){
                    $query->field('subject_id,school_id,ruxuenian,chengji_cnt,avg,youxiu,jige')
                        ->where('ruxuenian',$ruxuenian)
                        ->where('kaoshi_id',$kaoshi)
                        ->with([
                            'njSubject'=>function($query){
                                $query->field('id,lieming,jiancheng');
                            },
                        ])
                        ->order(['subject_id']);
                }

            ])
            ->group('kaoshi_id,school_id,ruxuenian')
            ->select();


        // 初始化数组
        $data = array();

        // 重组数据
        foreach ($tongjiJg as $key => $value) {
            $data[$value->school_id]=[
                'id'=>$value->id,
                'school'=>$value->njSchool->jiancheng,
                'schoolpaixu'=>$value->njSchool->paixu,
                // 'title'=>$value->banjiTitle,
                // 'banjipaixu'=>$value->bjBanji->paixu,
            ];
            foreach ($value->njJieguo as $k => $val) {
                if($val->subject_id>0){
                    $data[$value->school_id]['chengji'][$val->njSubject->lieming] = [
                        'avg'=>$val->avg,
                        'youxiu'=>$val->youxiu,
                        'jige'=>$val->jige,
                        'cj_cnt'=>$val->chengji_cnt,
                    ];
                }else{
                    $data[$value->school_id]['quanke'] = [
                        'avg'=>$val->avg,
                        'jige'=>$val->jige,
                    ];
                }
                
            }
        }

        $data = sortArrByManyField($data,'schoolpaixu',SORT_ASC);

        return $data;
    }


    // 考试关联
    public function njKaoshi()
    {
        return $this->belongsTo('\app\kaoshi\model\Kaoshi','kaoshi_id','id');
    }

    // 学校关联
    public function njSchool()
    {
        return $this->belongsTo('\app\system\model\School','school_id','id');
    }

    // 学科关联
    public function njSubject()
    {
        return $this->belongsTo('\app\teach\model\Subject','subject_id','id');
    }

    // 成绩统计结果关联
    public function njJieguo()
    {
        return $this->hasMany('\app\chengji\model\TongjiNj','school_id','school_id');
    }
}
