<?php

namespace app\http\middleware;
// 引用权限验证类
use think\auth\Auth;
use think\Controller;

class YanZheng  extends Controller
{
    public function handle($request, \Closure $next)
    {
    	// 实例化权限验证类
    	$auth = new Auth();

    	// 检测权限
		// if($auth->check('show_button',1)){// 第一个参数是规则名称,第二个参数是用户UID
		//     //有显示操作按钮的权限
		// }else{
		//     //没有显示操作按钮的权限
		// }

		
		$request->hello = 'ThinkPHP';
		$a = $request->action();

    	return $next($request);
    }
}
