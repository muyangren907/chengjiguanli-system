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

        $userInfo = \app\facade\OnLine::getLoginInfo('admin');

        // 检验用户名或密码是否正确
        $yz = new \app\login\controller\Index;
        $yz = $yz->check($userInfo['username'],$userInfo['password']);

        if($yz['status'] == 0){
            \app\facade\OnLine::jump('/login', '请使用新密码登录');
        }

        return $next($request);
    }
}
