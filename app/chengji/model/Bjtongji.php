<?php

namespace app\chengji\model;

// 引用基类
use app\common\model\Base;
// 引用学生成绩统计类
use app\chengji\model\Tongji as TJ;
use app\chengji\model\Chengji;

class Bjtongji extends Base
{
    /**  
    * 统计指定个年级的各班级成绩
    * 统计项目参考tongji方法
    * @access public 
    * @param number $kaoshi 考试id
    * @param number $ruxuenian 入学年
    * @return array 返回类型
    */
    public function tjBanji($srcfrom)
    {

        // 查询要统计成绩的班级
        $kh = new \app\kaoshi\model\Kaohao;
        $bj = $kh->cyBanji($srcfrom);

        $srcfrom['nianji'] = $srcfrom['ruxuenian'];
        $srcfrom['banji'] = $srcfrom['paixu'];
        unset($srcfrom['ruxuenian'],$srcfrom['paixu']);



        $data = array();
        if($bj->isEmpty()){
            return $data;
        }

        // 实例化学生成绩统计类
        $tj = new TJ;
        $cj = new Chengji;

        // 获取并统计各班级成绩
        $data = array();
        $bjs = array();
        foreach ($bj as $key => $value) {
            $bjs[] = $value->banji;
            $banji=[$value->banji];
            $temp = $cj->search($srcfrom);
            $temp = $tj->tongji($temp,$srcfrom['kaoshi']);
            $data[] = [
                'banji'=>$value->bjtitle,
                'school'=>$value->cj_school->jiancheng,
                'chengji'=>$temp
            ];
            
        }

        $srcfrom['banji'] = $bjs;
        // 获取年级成绩
        // $allcj = $tj->srcChengji($kaoshi=$kaoshi,$banji=$bjs,$nianji=$nianji,$school=array());
        $allcj = $cj->search($srcfrom);
        $temp = $tj->tongji($allcj,$srcfrom['kaoshi']);
        $data[] = [
            'banji'=>'合计',
            'school'=>'',
            'chengji'=>$temp
        ];


        return $data;
    }
}
