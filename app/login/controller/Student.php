<?php
namespace app\login\controller;

class Student
{
    // 学生登录验证
    public function login()
    {
        session('onlineCategory', null);
        session('user_id', null);
        session('username', null);
        session('password', null);

        // 获取表单数据
        $list = request()
            ->only([
                'username'
                ,'password'
                ,'category'
            ]);

        $validate = new \app\login\validate\Yanzheng;
        $result = $validate->scene('admin')->check($list);
        $msg = $validate->getError();
        if(!$result){
            return json(['msg' => $msg, 'val' => 0]);
        }

        $yz = $this->yz($list['username'], $list['password']);

        if($yz['val'] === 1)
        {
            // 获取服务器密码
            $stu = new \app\student\model\Student;
            $userinfo = $stu::where('shenfenzhenghao', $list['username'])
                ->where('status', 1)
                ->field('id, lastip, shenfenzhenghao, ip, denglucishu, lasttime, thistime, password')
                ->find();
            // 将本次信息上传到服务器上
            $userinfo->lastip = $userinfo->ip;
            $userinfo->ip = request()->ip();
            $userinfo->denglucishu = ['inc', 1];
            $userinfo->lasttime = $userinfo->getData('thistime');
            $userinfo->thistime = time();
            $userinfo->save();
        }

        return json($yz);
    }


    // 获学生帐号密码信息
    public function yz($username, $password)
    {
        // 获取服务器密码
        $stu = new \app\student\model\Student;
        $userinfo = $stu::where('shenfenzhenghao', $username)
            ->where('status', 1)
            ->field('id, lastip, shenfenzhenghao, ip, denglucishu, lasttime, thistime, password')
            ->find();
        if ($userinfo == null)
        {
            // 验证结果;
            $data = ['msg' => '学生帐号不存在或被禁用', 'val' => 0];
            return $data;
        }

        // 验证用户名和密码
        $check = loginCheck($password, $userinfo->password);

        if ($check === true)
        {
            session('onlineCategory', 'student');
            session('user_id', $userinfo->id);
            session('username', $username);
            session('password', $password);
            // 跳转到首页
            $data = ['msg' => '验证成功', 'val' => 1, 'url' =>'\\studentSearchChengji\\index\\index'];
        } else {
            // 提示错误信息
            $data = ['msg' => '用户名或密码错误', 'val' => 0];
        }

        return $data;
    }

}
