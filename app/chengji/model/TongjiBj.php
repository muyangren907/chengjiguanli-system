<?php
namespace app\chengji\model;

// 引用基类
use app\common\model\Base;
// 引用学生成绩统计类
use app\chengji\model\Tongji as TJ;
// 引用学生成绩类
use app\kaoshi\model\Kaohao;

/**
 * @mixin think\Model
 */
class TongjiBj extends Base
{
    /**
    * 统计指定个年级的各班级成绩
    * 统计项目参考tongji方法
    * @access public
    * @param number $kaoshi 考试id
    * @param number $ruxuenian 入学年
    * @return array 返回类型
    */
    public function tjBanji($kaoshi)
    {
        $src = array('kaoshi'=>$kaoshi);
        // 实例化学生成绩统计类
        $tj = new TJ;
        $kh = new Kaohao;
        $ksset = new \app\kaoshi\model\KaoshiSet;
        $nianji = $ksset->srcNianji($kaoshi);
        // 初始化统计结果
        $data = array();

        // 循环年级
        foreach ($nianji as $njkey => $value) {
            // 获取参加考试班级
            $src['ruxuenian'] = $value['nianji'];
            $banji = $kh->cyBanji($src);
            $subject = $ksset->srcSubject($kaoshi,'',$value['nianji']);

            // 循环班级，获取并统计成绩
            foreach ($banji as $bjkey => $val) {
               $srcfrom = [
                    'kaoshi'=>$kaoshi,
                    'banji'=>$val['id'],
                ];
                $temp = $kh->srcChengji($srcfrom);
                $temp = $tj->tongjiSubject($temp,$subject);

                // 循环更新或写入成绩
                foreach ($temp['cj'] as $cjkey => $cj) {
                    $tongjiJg = $this->where('kaoshi_id',$src['kaoshi'])
                                    ->where('banji_id',$val['id'])
                                    ->where('subject_id',$cj['id'])
                                    ->find();
                    if($tongjiJg)
                    {
                        $tongjiJg->kaoshi_id = $src['kaoshi'];
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
                            'kaoshi_id'=>$src['kaoshi'],
                            'banji_id'=>$val['id'],
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
        }

        return true;
    }



        /**
    * 统计指定个年级的各班级成绩
    * 统计项目参考tongji方法
    * @access public
    * @param number $kaoshi 考试id
    * @param number $ruxuenian 入学年
    * @return array 返回类型
    */
    public function tjBanjiCnt($srcfrom)
    {

        // 初始化参数
        $src = array(
            'page'=>'1',
            'limit'=>'10',
            'kaoshi'=>'',
            'ruxuenian'=>'',
            'school'=>'',
            'banji'=>array(),
        );


        // 用新值替换初始值
        $src = array_cover( $srcfrom , $src ) ;

        // 实例化学生成绩统计类
        $tj = new TJ;
        $kh = new Kaohao;
        // $cj = new Chengji;
        $ksset = new \app\kaoshi\model\KaoshiSet;

        // 获取参加考试学科
        $subject = $ksset->srcSubject($src['kaoshi'],'',$src['ruxuenian']);
        $banji =$kh->cyBanji($src);


        // 获取并统计各班级成绩
        $data = array();
        $srcfrom['kaoshi'] = $src['kaoshi'];
        foreach ($banji as $key => $value) {
            $srcfrom['banji'] = $value['id'];
            $temp = $kh->srcChengji($srcfrom);
            $temp = $tj->tongjiCnt($temp,$subject);
            $data[] = [
                'banji'=>$value['banjiTitle'],
                'banjinum'=>$value['banjiTitle'],
                'school'=>$value['schJiancheng'],
                'chengji'=>$temp
            ];
        }


        $srcfrom['banji'] = array_column($banji, 'id');

        // 获取年级成绩
        $temp = $kh->srcChengji($srcfrom);
        $temp = $tj->tongjiCnt($temp,$subject);
        $data[] = [
            'banji'=>'合计',
            'banjinum'=>'合计',
            'school'=>'合计',
            'chengji'=>$temp
        ];


        return $data;
    }




    /**
    * 班级成绩统计结果查询
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
            'banji'=>array(),
        );

        // 用新值替换初始值
        $src = array_cover( $srcfrom , $src ) ;
        $src['banji'] = strToarray($src['banji']);


        if(count($src['banji']) == 0){
            return array();
        }

        $kaoshi = $src['kaoshi'];

        $tongjiJg = $this
            ->where('kaoshi_id',$src['kaoshi'])
            ->where('banji_id','in',$src['banji'])
            ->field('banji_id,kaoshi_id')
            ->with([
                'bjBanji'=>function($query){
                    $query->field('id,school,paixu')
                        ->with([
                            'glSchool'=>function($query){
                                $query->field('id,jiancheng,paixu');
                            },
                        ]);
                },
                'bjJieguo'=>function($query){
                    $query->field('subject_id,banji_id,stu_cnt,chengji_cnt,avg,youxiu,jige,biaozhuncha,max,min,q1,q2,q3')
                        ->with([
                            'bjSubject'=>function($query){
                                $query->field('id,lieming,jiancheng,title');
                            },
                        ])
                        ->order(['subject_id']);
                }
            ])
            // ->cache(true)
            ->group('banji_id,kaoshi_id')
            ->append(['banjiTitle'])
            ->select();


        // 初始化数组
        $data = array();


        // 重组数据
        foreach ($tongjiJg as $key => $value) {

            $data[$value->banji_id]=[
                'id'=>$value->id,
                'school'=>$value->bjBanji->glSchool->jiancheng,
                'schoolpaixu'=>$value->bjBanji->glSchool->paixu,
                'title'=>$value->banjiTitle,
                'banjipaixu'=>$value->bjBanji->paixu,
                'stuCnt'=>$value->stuCnt,
            ];
            foreach ($value->bjJieguo as $k => $val) {
                if($val->subject_id>0){
                    $data[$value->banji_id]['chengji'][$val->bjSubject->lieming] = [
                        'avg'=>$val->avg*1,
                        'youxiu'=>$val->youxiu*1,
                        'jige'=>$val->jige*1,
                        'cjCnt'=>$val->chengji_cnt,
                        'title'=>$val->bjSubject->title,
                        'jiancheng'=>$val->bjSubject->jiancheng,
                        'biaozhuncha'=>$val->biaozhuncha*1,
                        'sifenwei'=>[
                            'min'=>$val->min,
                            'q1'=>$val->q1*1,
                            'q2'=>$val->q2*1,
                            'q3'=>$val->q3*1,
                            'max'=>$val->max,
                        ],
                    ];
                }else{
                    $data[$value->banji_id]['quanke'] = [
                        'avg'=>$val->avg,
                        'jige'=>$val->jige,
                    ];
                }

            }
        }


        $data = sortArrByManyField($data,'schoolpaixu',SORT_ASC,'banjipaixu',SORT_ASC);

        return $data;
    }


    /**
    * 查询班级历次成绩
    */
    public function srcBanjiChengji($srcfrom)
    {
        // 初始化参数
        $src = array(
            'banji' => '',
            'category' => '',
            'xueqi' => '',
        );

        // 用新值替换初始值
        $src = array_cover( $srcfrom , $src ) ;
        $src['xueqi'] = strToarray($src['xueqi']);
        $src['category'] = strToarray($src['category']);

        if(isset($srcfrom['bfdate']) && strlen($srcfrom['bfdate'])>0)
        {
            $src['bfdate'] = $srcfrom['bfdate'];
        }else{
            $src['bfdate'] = date("Y-m-d",strtotime("-1 year"));
        }

        if(isset($srcfrom['enddate']) && strlen($srcfrom['enddate'])>0)
        {
            $src['enddate'] = $srcfrom['enddate'];
        }else{
            $src['enddate'] = date("Y-m-d",strtotime("+1 day"));
        }


        $data = $this
                ->where('banji_id',$src['banji'])
                ->where('kaoshi_id','in',function($query) use($src){
                    $query->name('kaoshi')
                        ->whereTime('bfdate|enddate','between',[ $src['bfdate'],$src['enddate'] ])
                        ->when(count($src['xueqi']) > 0, function($q) use($src){
                            $q->where('xueqi', 'in', function($w) use($src){
                                $w->name('xueqi')
                                    ->where('category', 'in', $src['xueqi'])
                                    ->field('id');
                            });
                        })
                        ->when(count($src['category']) > 0, function($q) use($src){
                            $q->where('category', 'in', $src['category']);
                        })
                        ->field('id');
                })
                ->with([
                    'bjKaoshi' => function($query){
                        $query->field('id,title,bfdate');
                    },
                    'bjSubject' => function($query){
                        $query->field('id,title,jiancheng,paixu,lieming');
                    },
                    'quJieguo' => function($query){
                        $query->field('id,kaoshi_id,subject_id,defenlv');
                    }
                ])
                ->select();

        return $data;
    }



    // 成绩排序
    public function bjOrder($kaoshi)
    {
        $src = array('kaoshi'=>$kaoshi);
        // 实例化学生成绩统计类
        $kh = new Kaohao;
        $ksset = new \app\kaoshi\model\KaoshiSet;
        $cj = new \app\chengji\model\Chengji;
        $nianji = $ksset->srcNianji($kaoshi);
        $col = ['bpaixu','bweizhi'];


        // 初始化统计结果
        $data = array();

        // 循环年级
        foreach ($nianji as $njkey => $value) {
            // 获取参加考试班级
            $src['ruxuenian'] = $value['nianji'];
            $banji = $kh->cyBanji($src);
            $subject = $ksset->srcSubject($kaoshi,'',$value['nianji']);

            // 循环班级，获取并统计成绩
            foreach ($banji as $bjkey => $val) {
               // 获取成绩
               $srcfrom = [
                    'kaoshi'=>$kaoshi,
                    'banji'=>$val['id'],
                ];
                $temp = $kh->srcChengjiSubject($srcfrom);
                // 循环计算成绩排序
                foreach ($temp as $key => $value) {
                    $cj->saveOrder($value,$col);
                }
            }
        }
        return true;
    }



    // 考试关联
    public function bjKaoshi()
    {
        return $this->belongsTo('\app\kaoshi\model\Kaoshi','kaoshi_id','id');
    }


    // 班级关联
    public function bjBanji()
    {
        return $this->belongsTo('\app\teach\model\Banji','banji_id','id');
    }

    // 学科关联
    public function bjSubject()
    {
        return $this->belongsTo('\app\teach\model\Subject','subject_id','id');
    }

    // 成绩统计结果关联
    public function bjJieguo()
    {
        $ksid = $this->getAttr('kaoshi_id');
        return $this->hasMany('\app\chengji\model\TongjiBj','banji_id','banji_id')
                ->where('kaoshi_id',$ksid);
    }


    // 区成绩统计结果关联
    public function quJieguo()
    {
        $sbjid = $this->getAttr('subject_id');
        return $this->belongsTo('\app\chengji\model\TongjiSch','kaoshi_id','kaoshi_id')
                ->where('subject_id',$sbjid);
    }


    // 获取班级名称
    public function getBanjiTitleAttr()
    {
        $kh = new \app\kaoshi\model\Kaohao;
        $src = [
            'kaoshi'=>$this->getAttr('kaoshi_id'),
            'banji'=>$this->getAttr('banji_id'),
        ];

        $bj = $kh->cyBanji($src);
        return $bj[0]['banjiTitle'];
    }


}
