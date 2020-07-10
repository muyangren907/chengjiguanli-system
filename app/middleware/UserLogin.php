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
        $category = session('onlineCategory');
        $isajax = $request->isAjax();
        if ($category != 'admin')
        {
            
            \app\facade\OnLine::jump('/login', '请使用管理员帐号登录');
        }

        // 尝试从session中获取用户名和密码
        $username = session('?admin.username') ? $username = session('admin.username') : $username = '';
        $password = session('?admin.password') ? $password = session('admin.password') : $password = '';
        // 尝试从cookie中获取用户名和密码
        if (strlen($username) < 1 )
        {
            $username = cookie('?username') ? $username = cookie('username') : $username = '';
            $password = cookie('?password') ? $password = cookie('password') : $password = '';
        }

        // 检验用户名或密码是否正确
        $yz = new \app\login\controller\Index;
        $yz = $yz->check($username,$password);

        if($yz['status'] == 0){
            \app\facade\OnLine::jump('/login', '请使用新密码登录');
        }

        return $next($request);
    }
}
