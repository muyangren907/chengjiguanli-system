<?php
namespace app\index\controller;

use think\Controller;

class Index extends Controller
{
    // 主页
    public function index()
    {
        return $this->fetch();
    }

    public function welcome()
    {
        return $this->fetch();
    }
}
