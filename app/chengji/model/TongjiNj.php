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
                    foreach ($temp as $k => $cj) {
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
    * 统计各学校的指定个年级的成绩
    * 统计项目参考tongji方法
    * @access public 
    * @param number $kaoshi 考试id
    * @param number $ruxuenian 入学年
    * @return array 返回类型
    */
    public function tjNianji1($srcfrom)
    {
        // 初始化参数 
        $src = array(
            'page'=>'1',
            'limit'=>'10',
            'kaoshi'=>'',
            'ruxuenian'=>'',
        );


        // 用新值替换初始值
        $src = array_cover( $srcfrom , $src ) ;

        $data = array();
        if(strlen($src['ruxuenian']) == 0){
            return $data;
        }

        // 查询要统计成绩的学校
        $kh = new \app\kaoshi\model\Kaohao;
        $school = $kh->cySchool($src);

        if(count($school) == 0){
            return array();
        }

        // 实例化学生成绩统计类
        $tj = new TJ;


        // 获取并统计各班级成绩
        $data = array();
        $srcfrom = [
            'kaoshi'=>$src['kaoshi']
            ,'ruxuenian'=>$src['ruxuenian']
        ];

        foreach ($school as $key => $value) {
            $srcfrom['school'] = [$value['school']];
            $srcfrom['banji'] = array_column($kh->cyBanji($srcfrom), 'id');
            $temp = $kh->srcChengji($srcfrom);
            $temp = $tj->tongji($temp,$src['kaoshi']);
            $data[] = [
                'school'=>$value['cjSchool']['jiancheng'],
                'chengji'=>$temp
            ];
        }


        // 获取年级成绩
        $srcfrom['school'] = array_column($school, 'school');
        $srcfrom['banji'] = array_column($kh->cyBanji($srcfrom), 'id');
        $allcj = $kh->srcChengji($srcfrom);
        $temp = $tj->tongji($allcj,$src['kaoshi']);
        $data[] = [
            'school'=>'合计',
            'chengji'=>$temp
        ];
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
}
