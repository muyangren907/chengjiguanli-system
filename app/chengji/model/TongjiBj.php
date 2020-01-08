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
        // 查询参与班级
        $src['banji'] = $kh->cyBanji($src);
        $src['kaoshi'] = $kaoshi;


        // 获取并统计各班级成绩
        $data = array();
        foreach ($src['banji'] as $key => $banji) {
            
            $srcfrom = [
                'kaoshi'=>$src['kaoshi'],
                'banji'=>[$banji['id']]
            ];

            $temp = $kh->srcChengji($srcfrom);
            $temp = $tj->tongjiSubject($temp,$srcfrom['kaoshi']);

            foreach ($temp['cj'] as $k => $cj) {
                // 查询该班级该学科成绩是否存在
                $tongjiJg = $this->where('kaoshi_id',$src['kaoshi'])
                                ->where('banji_id',$banji['id'])
                                ->where('subject_id',$cj['id'])
                                ->find();
                if($tongjiJg)
                {
                    $tongjiJg->kaoshi_id = $src['kaoshi'];
                    $tongjiJg->banji_id = $banji['id'];
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
                        'banji_id'=>$banji['id'],
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
            'banji'=>array(),
        );


        // 用新值替换初始值
        $src = array_cover( $srcfrom , $src ) ;

        if(count($src['banji']) == 0){
            return array();
        }

        // 实例化学生成绩统计类
        $tj = new TJ;
        $cj = new Chengji;


        // 获取并统计各班级成绩
        $data = array();
        foreach ($src['banji'] as $key => $value) {
            $srcfrom = [
                'kaoshi'=>$src['kaoshi'],
                'banji'=>[$value['id']]
            ];
            $temp = $cj->search($srcfrom);
            $temp = $tj->tongjiCnt($temp,$srcfrom['kaoshi']);
            $data[] = [
                'banji'=>$value['banjiTitle'],
                'banjinum'=>$value['banjiNum'],
                'school'=>$value['glSchool']['jiancheng'],
                'chengji'=>$temp
            ];
        }


        $srcfrom['banji'] = array_column($src['banji'], 'id');
        // 获取年级成绩
        // $allcj = $tj->srcChengji($kaoshi=$kaoshi,$banji=$bjs,$nianji=$nianji,$school=array());
        $allcj = $cj->search($srcfrom);
        $temp = $tj->tongjiCnt($allcj,$srcfrom['kaoshi']);
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


        if(count($src['banji']) == 0){
            return array();
        }

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
                    $query->field('subject_id,banji_id,chengji_cnt,avg,youxiu,jige')
                        ->with([
                            'bjSubject'=>function($query){
                                $query->field('id,lieming,jiancheng');
                            },
                        ])
                        ->order(['subject_id']);
                }
            ])
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
            ];
            foreach ($value->bjJieguo as $k => $val) {
                if($val->subject_id>0){
                    $data[$value->banji_id]['chengji'][$val->bjSubject->lieming] = [
                        'avg'=>$val->avg,
                        'youxiu'=>$val->youxiu,
                        'jige'=>$val->jige,
                        'cj_cnt'=>$val->chengji_cnt,
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
        return $this->hasMany('\app\chengji\model\TongjiBj','banji_id','banji_id');
    }


    // 获取班级名称
    public function getBanjiTitleAttr()
    {
        $bfdate = \app\kaoshi\model\Kaoshi::where('id',$this->getAttr('kaoshi_id'))
                  ->value('bfdate');

        $banji = new \app\teach\model\Banji;
        $title = $banji->myBanjiTitle($this->getAttr('banji_id'),$bfdate);

        return $title;
    }
    
}
