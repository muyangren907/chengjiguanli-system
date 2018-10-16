<?php

namespace app\http\middleware;

// 引用控制器类
use think\Controller;
// 引用权限验证类
use \php4world\Auth;


class YanZheng  extends Controller
{
    public function handle($request, \Closure $next)
    {
        // 验证用户在否登录
        if(!session('?userid') && cookie('name') == null )
        {
            // 跳转到首页
            $this->redirect('/login');
            return '验证失败';
        }else{
            // 
            dump('检验密码对不对');
        }
        // 验证用户名和密码是否正确
        // 验证用户权限

        // 实例化权限验证类
    	$auth = new Auth();

    	$act = $request->action();
    	$cnt = $request->controller();
    	$mod = $request->module();
    	$url = $mod.'/'.$cnt.'/'.$act;

		
		if( !$auth->check($url, '1') ){// 第一个参数是规则名称,第二个参数是用户UID
		    dump('验证不通过');
		}


    	return $next($request);
    }
}
