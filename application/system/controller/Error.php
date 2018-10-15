<?php

namespace app\system\controller;

// 引用空控制器基类
use app\common\controller\BaseError;

class Error extends BaseError
{
    public function index()
    {
    	// 跳转页面
        $this->redirect(url('/notfound'));
    }
}
