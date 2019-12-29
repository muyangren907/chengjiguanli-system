<?php

namespace app\chengji\model;

// 引用基类
use app\common\model\Base;
// 引用学生成绩统计类
use app\chengji\model\Tongji as TJ;
// use app\chengji\model\Chengji;

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
}
