<?php
namespace app\chengji\controller;

// 引用控制器基类
use app\common\controller\Base;
// 引用学生类
use app\renshi\model\Student;
// 引用成绩类
use app\chengji\model\Chengji;

class Index extends Base
{
    // 导出参加考试学生二维码
    public function erweima()
    {
    	return $this->fetch();
    }

    
}
