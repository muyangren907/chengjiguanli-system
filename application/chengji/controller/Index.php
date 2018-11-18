<?php
namespace app\chengji\controller;

// 引用控制器基类
use app\common\controller\Base;
// 引用学生数据模型
use app\renshi\model\Student;
// 引用成绩数据模型
use app\chengji\model\Chengji;
// 引用学科数据模型
use app\teach\model\subject;

class Index extends Base
{
    // 使用二维码录入成绩
    public function malu()
    {
    	return $this->fetch();
    }

    // 保存使用二维码录入的成绩
    public function malusave()
    {
        // 获取表单数据
        $list = request()->only(['id','ziduan','defen'],'post');
        // 声明学科数组
        $subject = array('1'=>'yuwen','2'=>'shuxue','3'=>'waiyu');
        $zd = $subject[$list['ziduan']];

        // 更新成绩
        $cj = Chengji::update(['id'=>$list['id'], $zd=>$list['defen']]);

        empty($cj) ? $data = ['val' => 0] : $data = ['val' => 1,'defen'=>$cj->$zd];

        return json($data);


    }


    
    // 根据考号获取学生信息
    public function read()
    {
        // 获取表单数据 
        $list = request()->only(['id','ziduan'],'post');
        // 声明学科数组
        $subject = array('1'=>array('yuwen','语文'),'2'=>array('shuxue','数学'),'3'=>array('waiyu','外语'));


        $zd = $subject[$list['ziduan']][0];
        $zdname = $subject[$list['ziduan']][1];
        $stuinfo = Chengji::where('id',$list['id'])
                    ->field('id,school,student,banji,'.$zd)
                    ->append(['studentname','schooljian','banjiname'])
                    ->find();
        $stuinfo['zdname'] = $zdname;
        $stuinfo['zdstr'] = $zd;
        return json($stuinfo->visible(['studentname','schooljian','banjiname','banji',$zd,'zdstr','zdname']));
    }


    

    
}
