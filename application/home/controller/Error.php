<?php

namespace app\home\controller;

use think\Controller;

class Error extends Controller
{
    public function index()
    {
    	// 跳转页面
        $this->redirect(url('/notfound'));
    }
}
