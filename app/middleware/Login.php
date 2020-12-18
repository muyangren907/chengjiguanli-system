<?php
declare (strict_types = 1);

namespace app\middleware;

class Login
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
        switch ($category) {
            case 'admin':
                $yz = new \app\login\controller\Index;
                $yz = $yz->yz(session('username'), session('password'));
                break;
            case 'teacher':
                $yz = new \app\login\controller\Teacher;
                $yz = $yz->yz(session('username'), session('password'));
                break;
            case 'student':
                $yz = new \app\login\controller\Student;
                $yz = $yz->yz(session('username'), session('password'));
                break;
            default:
                \app\facade\OnLine::jump('/login', '请选择用户角色');
                break;
        }
        if($yz['val'] == 0)
        {
            \app\facade\OnLine::jump('/login', $yz['msg']);
        }

        return $next($request);
    }
}
