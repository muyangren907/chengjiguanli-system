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

        // 统计成绩
        $schtj = new SCHTJ;
        $data = $schtj->tjSchool($kaoshi);

        $data == true ? $data=['msg'=>'全区年级统计完成','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        return json($data);
    }
}
