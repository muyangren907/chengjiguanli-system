<?php
declare (strict_types = 1);

namespace app\middleware;

class UserLogin
{
    /**
     * 处理请求
     *
     * @param \think\Request $request
     * @param \Closure       $next
     * @return Response
     */
    public function handle($request, \Closure $next)
    {

        // 尝试从session中获取用户名和密码
        $username = session('?username') ? $username = session('username') : $username = '';
        $password = session('?password') ? $password = session('password') : $password = '';

        // 尝试从cookie中获取用户名和密码
        if( strlen($username)<1 )
        {
            $username = cookie('?username') ? $username = cookie('username') : $username = '';
            $password = cookie('?password') ? $password = cookie('password') : $password = '';
        }
        // 如果没有获取到用户名和密码，则跳转到登录页面
        if( strlen($username)<1 )
        {
            echo "<script>top.location.href='/login';</script>";
        }

        // 检验用户名或密码是否正确
        $yz = new \app\login\controller\Index;
        $yz = $yz->check($username,$password);
        if($yz['status'] == 0){
            echo "<script>top.location.href='login';</script>";
        }


        return $next($request);
    }
}
