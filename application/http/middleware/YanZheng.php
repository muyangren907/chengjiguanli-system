<?php

namespace app\http\middleware;

// 引用控制器类
use think\Controller;
// 引用权限验证类
use \php4world\Auth;
// 引用用户数据模型
use app\member\model\Member;


class YanZheng  extends Controller
{
    public function handle($request, \Closure $next)
    {
        // 声明帐号密码变量
        $username = 0;
        $password = 0;

        // 实例化用户类
        $membermod = new Member();

        // 如果用户没有登录直接跳转到登录页面
        if( session('?userid') )
        {
            $username = session('username');
            $password = session('password');
        }elseif(cookie('username') != null)
        {
            // 获取用户名和密码
            $username = cookie('username');
            $password = cookie('password');
        }else{
            $this->error('登录超时啦，请登录登录');
        }

        // 检验用户名或密码是否正确
        $yz = action('login/index/check',['username'=>$username,'password'=>$password]);
        if($yz == null){
            $this->error('请使用新密码登录');
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
