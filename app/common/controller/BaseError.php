<?php

namespace app\common\controller;

// 引用控制器类
use app\BaseController;

class BaseError extends BaseController
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    // public function index()
    // {
    //     // 跳转页面
    //     $this->error('不好意思，您访问的页面不存在~');
    // }

    //  public function _empty()
    // {
    //     $this->error('不好意思，您访问的页面不存在~');
    // }
    
    public function __call($method, $args)
    {
        return 'error request!';
    }
    
}
