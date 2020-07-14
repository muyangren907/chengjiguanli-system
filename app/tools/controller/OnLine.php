<?php
declare (strict_types = 1);

namespace app\tools\controller;

class OnLine
{
    use \liliuwei\think\Jump;
    // 将关联学生成绩转换成以学科列名为key得分为value的数组
    public function jump($url = '', $msg = '')
    {
        $isajax = request()->isAjax();
        if($isajax)
        {
            $this->error($msg, '/login/err');
        }else{
            echo "<script language='javascript' type='text/javascript'>top.location.href='".$url."'</script>";
        }
        return true;
    }


    // 获取用户信息
    public function getLoginInfo($yu)
    {
        $username = '';
        $password = '';
        // 尝试从session中获取用户名和密码
        $username = session('?'.$yu.'.username')
            ? $username = session($yu.'.username') : $username = '';
        $password = session('?'.$yu.'.password')
            ? $password = session($yu.'.password') : $password = '';
        // 尝试从cookie中获取用户名和密码
        if (strlen($username) < 1 )
        {
            $username = cookie('?username')
                ? $username = cookie('username') : $username = '';
            $password = cookie('?password')
                ? $password = cookie('password') : $password = '';
        }

        $userInfo = [
            'username' => $username
            ,'password' => $password
        ];

        return $userInfo;
    }
}
