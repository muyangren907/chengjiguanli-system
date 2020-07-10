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
        $online = session('?onlineCategory');
        if($online == false)
        {
            $this->error('很长时间没有操作，登录超时啦~','/login/student');
        }else{
            $category = session('onlineCategory');
            if ($category != 'student')
            {
                $this->error('请使用学生帐号登录', '/login/student');
            }
        }

        // 尝试从session中获取用户名和密码
        $username = session('?student.username') ? $username = session('student.username') : $username = '';
        $password = session('?student.password') ? $password = session('student.password') : $password = '';
        // 尝试从cookie中获取用户名和密码
        if (strlen($username)<1 )
        {
            $username = cookie('?username') ? $username = cookie('username') : $username = '';
            $password = cookie('?password') ? $password = cookie('password') : $password = '';
        }

        $isajax = $request->isAjax();

        // 如果没有获取到用户名和密码，则跳转到登录页面
        if(strlen($username)<1)
        {
            if($isajax)
            {
                $this->error('很长时间没有操作，登录超时啦~', '/login/err');
            }else{
                echo "<script language='javascript' type='text/javascript'>top.location.href='/login/student'</script>";
            }
        }

        // 检验用户名或密码是否正确
        $yz = new \app\login\controller\Student;
        $yz = $yz->check($username,$password);
        if($yz['status'] == 0){
            if($isajax)
            {
                $this->error('密码刚才修改过了，请重新登录~', '/login/err');
            }else{
                echo "<script language='javascript' type='text/javascript'>top.location.href='/login/student'</script>";
            }

        }

        return $next($request);
    }
}
