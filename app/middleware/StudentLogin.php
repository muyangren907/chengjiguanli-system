<?php
declare (strict_types = 1);

namespace app\middleware;

class StudentLogin
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
        if ($category != 'student')
        {

            \app\facade\OnLine::jump('/login/student', '请使用学生帐号登录');
        }

        $userInfo = \app\facade\OnLine::getLoginInfo('student');

        // 检验用户名或密码是否正确
        $yz = new \app\login\controller\Student;
        $yz = $yz->check($userInfo['username'],$userInfo['password']);

        if($yz['status'] == 0){
            \app\facade\OnLine::jump('/login/student', '请使用新密码登录');
        }

        return $next($request);
    }
}
