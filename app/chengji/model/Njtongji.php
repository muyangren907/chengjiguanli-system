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
    public function tjNianji($srcfrom)
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
}
