<?php

namespace app\chengji\model;

// 引用基类
use app\common\model\Base;
// 引用学生成绩统计类
use app\chengji\model\Tongji as TJ;

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
    public function tjBanji($kaoshi,$nianji,$school=array(),$paixu=array())
    {
        // 查询要统计成绩的班级
        $kh = new \app\kaoshi\model\Kaohao;
        $bj = $kh->cyBanji($kaoshi=$kaoshi,$ruxuenian=$nianji,$school=$school,$paixu=$paixu);

        $data = array();
        if($bj->isEmpty()){
            return $data;
        }

        // 实例化学生成绩统计类
        $tj = new TJ;

        // 获取并统计各班级成绩
        $data = array();
        $bjs = array();
        foreach ($bj as $key => $value) {
            $bjs[] = $value->banji;
            $banji=[$value->banji];
            $temp = $tj->srcChengji($kaoshi=$kaoshi,$banji=$banji,$nianji=$nianji,$school=array());
            $temp = $tj->tongji($temp,$kaoshi);
            $data[] = [
                'banji'=>$value->bjtitle,
                'school'=>$value->cj_school->jiancheng,
                'chengji'=>$temp
            ];
            
        }


        // 获取年级成绩
        $allcj = $tj->srcChengji($kaoshi=$kaoshi,$banji=$bjs,$nianji=$nianji,$school=array());
        $temp = $tj->tongji($allcj,$kaoshi);
        $data[] = [
            'banji'=>'合计',
            'school'=>'',
            'chengji'=>$temp
        ];


        return $data;
    }
}
