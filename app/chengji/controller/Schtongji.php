<?php
namespace app\chengji\controller;
// 引用控制器基类
use app\BaseController;
// 引用成绩统计数据模型
use app\chengji\model\TongjiSch as SCHTJ;

class Schtongji
{

    // 统计全区年级成绩
    public function tongji()
    {
        // 获取变量
        $kaoshi = input('post.kaoshi');
        // 判断考试状态
        event('ksjs',$kaoshi);
        // 统计成绩
        $schtj = new SCHTJ;
        $data = $schtj->tjSchool($kaoshi);

        if(true == $data)
        {
            $data=['msg'=>'全区年级统计完成','val'=>1];
            $src = [
                'kaoshi_id' => $kaoshi,
                'category' => 'schtj',
            ];
            event('tjlog', $src);
        }else{
            $data=['msg'=>'数据处理错误','val'=>0];
        }

        return json($data);
    }


    // 统计学生在班级名次
    public function schOrder()
    {
        // 获取变量
        $kaoshi = input('post.kaoshi');
        // 判断考试状态
        event('ksjs',$kaoshi);

        // 统计成绩
        $schtj = new SCHTJ;
        $data = $schtj->schOrder($kaoshi);

        if(true == $data)
        {
            $data=['msg'=>'学生成绩在全区位置统计完成','val'=>1];
            $src = [
                'kaoshi_id' => $kaoshi,
                'category' => 'schwz',
            ];
            event('tjlog', $src);
        }else{
            $data=['msg'=>'数据处理错误','val'=>0];
        }

        return json($data);
    }


}