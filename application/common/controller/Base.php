<?php

namespace app\common\controller;

// 引用控制器类
use think\Controller;
// 引用权限验证类
use think\auth\Auth;


class Base extends Controller
{

    // 调用Auth中间件进行用户权限验证
    protected $middleware = ['YanZheng'];

    public function _empty()
    {
        $this->redirect('error/index/index');
    }

}
