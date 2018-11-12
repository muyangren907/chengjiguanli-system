<?php
namespace app\chengji\controller;

// 引用控制器基类
use app\common\controller\Base;

class Index extends Base
{
    // 导出参加考试学生二维码
    public function erweima()
    {
    	return $this->fetch();
    }
}
