<?php

namespace app\common\controller;

// 引用控制器类
use think\Controller;
// 引用权限验证类
use think\auth\Auth;
// 引用软删除类
use think\model\concern\SoftDelete;



class Base extends Controller
{
    // 开启全局自动时间戳
    protected $autoWriteTimestamp = true;

    // 开启软删除
    use SoftDelete;
    protected $deleteTime = 'delete_time';

    // 当前类初始化
    protected function initialize()
    {
    	$this->quanxianyanzheng();
    }

    protected function quanxianyanzheng()
    {
    	// 实例化权限验证Auth类
    	$auth = new Auth();

    	// 检测权限
     //    if($auth->check('show_button',1)){// 第一个参数是规则名称,第二个参数是用户UID
     //        //有显示操作按钮的权限
     //    }else{
     //        //没有显示操作按钮的权限
     //    }
    }
}
