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
        // // 查询要统计的学校
        $kh = new \app\kaoshi\model\Kaohao;
        // $subjectList = $kh->cySchool($src);
        // 查询要统计的年级
        $ksset = new \app\kaoshi\model\KaoshiSet;
        $njList = $ksset->srcNianji($kaoshi);
        
        // 实例化学生成绩统计类
        $tj = new TJ;
            foreach ($njList as $k => $nianji) {
                $src = [
                    'kaoshi'=>$kaoshi,
                    'ruxuenian'=>$nianji['nianji'],
                ];
                $src['banji'] = array_column($kh->cyBanji($src),'id');
                $subject = $ksset->srcSubject($kaoshi,'',$nianji['nianji']);
                $temp = $kh->srcChengji($src);
                $temp = $tj->tongjiSubject($temp,$subject);
                foreach ($temp['cj'] as $k => $cj) {
                    // 查询该班级该学科成绩是否存在
                    $tongjiJg = $this->where('kaoshi_id',$src['kaoshi'])
                                    ->where('ruxuenian',$nianji['nianji'])
                                    ->where('subject_id',$cj['id'])
                                    ->find();
                    if($tongjiJg)
                    {
                        $tongjiJg->kaoshi_id = $src['kaoshi'];
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
                        $tongjiJg->defenlv = $cj['defenlv'];
                        $data = $tongjiJg->save();
                    }else{
                        // 重新组合统计结果
                        $tongjiJg = [
                            'kaoshi_id'=>$src['kaoshi'],
                            'ruxuenian'=>$nianji['nianji'],
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
                            'q1'=>$cj['sifenwei'][0],
                            'q2'=>$cj['sifenwei'][1],
                            'q3'=>$cj['sifenwei'][2],
                            'zhongshu'=>$cj['zhongshu'],
                            'defenlv'=>$cj['defenlv'],
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
                        'cjCnt'=>$val->chengji_cnt,
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



    // 成绩排序
    public function schOrder($kaoshi)
    {
        $src = array('kaoshi'=>$kaoshi);
        // 实例化学生成绩统计类
        $kh = new \app\kaoshi\model\Kaohao;
        $ksset = new \app\kaoshi\model\KaoshiSet;
        $cj = new \app\chengji\model\Chengji;
        $nianji = $ksset->srcNianji($kaoshi);


        // 初始化统计结果
        $data = array();

        // 循环年级
        foreach ($nianji as $njkey => $value) {
            // 获取参加考试班级
            $src['ruxuenian'] = $value['nianji'];
            $subject = $ksset->srcSubject($kaoshi,'',$value['nianji']);
            $banji = $kh->cyBanji($src);
            $col = ['qpaixu','qweizhi'];

           // 获取成绩
           $srcfrom = [
                'kaoshi'=>$kaoshi,
                'ruxuenian'=>$value['nianji'],
                'banji'=>array_column($banji, 'id'),
            ];
            $temp = $kh->srcChengjiSubject($srcfrom);
            // 循环计算成绩排序
            foreach ($temp as $key => $value) {
                $cj->saveOrder($value,$col);
            }
        }

        return true;
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
