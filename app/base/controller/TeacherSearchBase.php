<?php
namespace app\base\controller;

// 引用控制器基类
use app\BaseController;

/**
 * 控制器基础类
 */
abstract class TeacherSearchBase  extends BaseController
{
    /**
     * 控制器中间件
     * @var array
     */
    protected $middleware = [
        'online'
        ,'login'
    ];

    // 初始化变量
    protected function initialize()
    {
        $this->online = session('onlineCategory');
        if($this->online != 'teacher')
        {
            \app\facade\OnLine::jump('/login', '请使用教师帐号登录');
        }
    }
}
