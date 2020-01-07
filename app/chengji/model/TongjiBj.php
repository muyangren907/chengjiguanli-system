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

            foreach ($temp as $k => $cj) {
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
    public function tjBanji1($srcfrom)
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
            $temp = $tj->tongji($temp,$srcfrom['kaoshi']);

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
        $temp = $tj->tongji($allcj,$srcfrom['kaoshi']);
        $data[] = [
            'banji'=>'合计',
            'banjinum'=>'合计',
            'school'=>'合计',
            'chengji'=>$temp
        ];


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
        return $this->belongsTo('\app\teach\model\Banji','kaoshi_id','id');
    }

    // 学科关联
    public function bjSubject()
    {
        return $this->belongsTo('\app\teach\model\Subject','subject_id','id');
    }
    
}
