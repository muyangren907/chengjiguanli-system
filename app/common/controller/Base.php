<?php

namespace app\common\controller;

// 引用控制器类
use app\BaseController;
// 引用权限验证类
use think\auth\Auth;


class Base extends Controller
{

    // 调用Auth中间件进行用户权限验证
    protected $middleware = [
    	'OnLine'=>[
    		'except'=>[
                'exit',
    		],
    	],
    ];

    public function _empty()
    {
        $this->error('不好意思，您访问的页面不存在~');
    }

}
