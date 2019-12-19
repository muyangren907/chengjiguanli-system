<?php

namespace app\http\middleware;

// 引用控制器类
use think\Controller;
// 引用权限验证类
use \php4world\Auth;


class OnLine  extends Controller
{
    public function handle($request, \Closure $next)
    {
        // 声明帐号密码变量
        $username = session('username');
        $password = session('password');

        // 如果用户没有登录直接跳转到登录页面
        if( strlen($username)<1 )
        {
            $username = cookie('username');
            $password = cookie('password');
        }
        if( strlen($username)<1 )
        {
            echo "<script>top.location.href='/login';</script>";
        }

        // 检验用户名或密码是否正确
        $yz = action('login/index/check',['username'=>$username,'password'=>$password]);
        if($yz['status'] == 0){
            echo "<script>top.location.href='login';</script>";
        }

    	return $next($request);
    }
}
