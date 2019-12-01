<?php

namespace app\chengji\model;

// 引用基类
use app\common\model\Base;
// 引用学生成绩统计类
use app\chengji\model\Tongji as TJ;

class Njtongji extends Base
{
    /**  
    * 统计各学校的指定个年级的成绩
    * 统计项目参考tongji方法
    * @access public 
    * @param number $kaoshi 考试id
    * @param number $ruxuenian 入学年
    * @return array 返回类型
    */
    public function tjNianji($kaoshi,$nianji)
    {
        // 查询要统计成绩的学校
        $kh = new \app\kaoshi\model\Kaohao;
        $school = $kh->cySchool($kaoshi=$kaoshi,$ruxuenian=$nianji);

        $data = array();
        if($school->isEmpty()){
            return $data;
        }

        // 实例化学生成绩统计类
        $tj = new TJ;

        // 获取并统计各班级成绩
        $data = array();
        foreach ($school as $key => $value) {
            $schools=[$value->cj_school->id];
            $temp = $tj->srcChengji($kaoshi=$kaoshi,$banji=array(),$nianji=$nianji,$schools=$schools);
            $temp = $tj->tongji($temp,$kaoshi);
            $data[] = [
                'school'=>$value->cj_school->jiancheng,
                'chengji'=>$temp
            ];
        }
        
        // 获取年级成绩
        $allcj = $tj->srcChengji($kaoshi=$kaoshi,$banji=array(),$nianji=$nianji,$school=array());
        $temp = $tj->tongji($allcj,$kaoshi);
        $data[] = [
            'school'=>'合计',
            'chengji'=>$temp
        ];
        return $data;
    }
}
