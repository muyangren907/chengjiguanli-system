<?php
namespace app\base\controller;

// 引用控制器基类
use app\BaseController;

/**
 * 控制器基础类
 */
abstract class ToolBase  extends BaseController
{
    protected $middleware = [];
    protected $luruTeacherId = '';
    protected $online = '';

    protected function initialize()
    {
        $this->online = session('onlineCategory');
        if($this->online == 'teacher')
        {
            $this->middleware = [
                'online'
                ,'login'
            ];
        }else{
            $this->middleware = [
                'online'
                ,'login'
                ,'auth'
            ];
        }
        $this->luruTeacherId = session('user_id');
    }
    
}
