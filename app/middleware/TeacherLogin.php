<?php
declare (strict_types = 1);

namespace app\middleware;

class TeacherLogin
{
    use \liliuwei\think\Jump;
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
        if ($category != 'teacher')
        {

            \app\facade\OnLine::jump('/login/teacher', '请使用教师帐号登录');
        }

        $userInfo = \app\facade\OnLine::getLoginInfo('teacher');

        // 检验用户名或密码是否正确
        $yz = new \app\login\controller\Teacher;
        $yz = $yz->check($userInfo['username'],$userInfo['password']);

        if($yz['status'] == 0){
            \app\facade\OnLine::jump('/login/teacher', '请使用新密码登录');
        }

        return $next($request);
    }
}
