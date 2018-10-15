<?php

namespace app\common\controller;

// 引用控制器类
use think\Controller;

class BaseError extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        // 跳转页面
        $this->redirect(url('/notfound'));
    }

     public function _empty()
    {
        $this->redirect(url('/notfound'));
    }
    
}
