<?php
namespace app\login\controller;

// 引用用户数据模型
use app\admin\model\Admin as AD;
// // 引用加密类
use WhiteHat101\Crypt\APR1_MD5;
// 引用view类
use think\facade\View;


class Index
{
    // 显示登录选择界面
    public function index()
    {
        // 清除cookie
        cookie('userid', null);
        cookie('username', null);
        cookie('password', null);
        // 清除session（当前作用域）
        session(null);

        // 获取系统名称和版本号
        $list['webtitle'] = config('shangma.webtitle');
        $list['version'] = config('shangma.version');

        View::assign('list',$list);

        // 渲染输出
        return View::fetch('index');
    }



    // 登录验证分流
    public function yanchengdenglu()
    {
        // 获取表单数据
        $list = request()
            ->only([
                'username'
                ,'password'
                ,'category'
            ]);

        $validate = new \app\login\validate\Yanzheng;
        $result = $validate->scene('fenliu')->check($list);
        $msg = $validate->getError();
        if(!$result){
            return json(['msg' => $msg, 'val' => 0]);
        }

        switch ($list['category']) {
            case 'admin':
                $data = $this->admin($list['username'], $list['password']);
                break;

            case 'teacher':
                $data = $this->teacher($list['username'], $list['password']);
                break;

            case 'student':
                $data = $this->student($list['username'], $list['password']);
                break;

            default:
                $data = ['msg' => '用户身份丢失', 'val' => 1];
                break;
        }

        return json($data);
    }



    // 管理员登录验证
    public function admin($username, $password)
    {
        session(null);
        // 获取服务器密码
        $userinfo = AD::where('username', $username)
            ->where('status', 1)
            ->field('id, lastip, username, ip, denglucishu, lasttime, thistime, password')
            ->find();

        if($userinfo == null)
        {
            // 验证结果;
            $data = ['msg' => '管理员帐号不存在或被禁用', 'val' => 0];
            return $data;
        }

        // 验证用户名和密码
        $check = $this->check($password, $userinfo->password);

        if($check === true)
        {
            session('onlineCategory', 'admin');
            session('user_id', $userinfo->id);
            session('username', $username);
            session('password', $password);

            // 将本次信息上传到服务器上
            $userinfo->lastip = $userinfo->ip;
            $userinfo->ip = request()->ip();
            $userinfo->denglucishu = ['inc', 1];
            $userinfo->lasttime = $userinfo->getData('thistime');
            $userinfo->thistime = time();
            $userinfo->save();

            // 跳转到首页
            $data = ['msg' => '验证成功', 'val' => 1, 'url' =>'\\'];
        }else{
            // 提示错误信息
            $data = ['msg' => '用户名或密码错误', 'val' => 0];
        }

        return $data;
    }


    // 管理员登录验证
    public function teacher($username, $password)
    {
        session(null);
        // 获取服务器密码
        $tch = new \app\teacher\model\Teacher;
        $userinfo = $tch::where('phone', $username)
            ->where('status', 1)
            ->field('id, lastip, phone, ip, denglucishu, lasttime, thistime, password')
            ->find();

        if($userinfo == null)
        {
            // 验证结果;
            $data = ['msg' => '教师帐号不存在或被禁用', 'val' => 0];
            return $data;
        }

        // 验证用户名和密码
        $check = $this->check($password, $userinfo->password);

        if($check === true)
        {
            session('onlineCategory', 'teacher');
            session('user_id', $userinfo->id);
            session('username', $username);
            session('password', $password);

            // 将本次信息上传到服务器上
            $userinfo->lastip = $userinfo->ip;
            $userinfo->ip = request()->ip();
            $userinfo->denglucishu = ['inc', 1];
            $userinfo->lasttime = $userinfo->getData('thistime');
            $userinfo->thistime = time();
            $userinfo->save();

            // 跳转到首页
            $data = ['msg' => '验证成功', 'val' => 1, 'url' => '/teacherSearchChengji/index/index'];
        }else{
            // 提示错误信息
            $data = ['msg' => '用户名或密码错误', 'val' => 0];
        }

        return $data;
    }

    // 管理员登录验证
    public function student($username, $password)
    {
        session(null);
        // 获取服务器密码
        $stu = new \app\student\model\Student;
        $userinfo = $stu::where('shenfenzhenghao', $username)
            ->where('status', 1)
            ->field('id, lastip, shenfenzhenghao, ip, denglucishu, lasttime, thistime, password')
            ->find();

        if($userinfo == null)
        {
            // 验证结果;
            $data = ['msg' => '教师帐号不存在或被禁用', 'val' => 0];
            return $data;
        }

        // 验证用户名和密码
        $check = $this->check($password, $userinfo->password);

        if($check === true)
        {
            session('onlineCategory', 'student');
            session('user_id', $userinfo->id);
            session('username', $username);
            session('password', $password);

            // 将本次信息上传到服务器上
            $userinfo->lastip = $userinfo->ip;
            $userinfo->ip = request()->ip();
            $userinfo->denglucishu = ['inc', 1];
            $userinfo->lasttime = $userinfo->getData('thistime');
            $userinfo->thistime = time();
            $userinfo->save();

            // 跳转到首页
            $data = ['msg' => '验证成功', 'val' => 1, 'url' => '/studentSearchChengji/index/index'];
        }else{
            // 提示错误信息
            $data = ['msg' => '用户名或密码错误', 'val' => 0];
        }

        return $data;
    }


    // 已知密码进行验证
    public function check($inputPassword, $serverPassword)
    {
        // 实例化加密类
        $md5 = new APR1_MD5();
        //验证密码
        $check = $md5->check($inputPassword, $serverPassword);
        return $check;
    }


    // 系统更新日志
    public function shangmaLog()
    {
        // 渲染模板
        return View::fetch();
    }


    // 错误页面
    public function myerror()
    {
        // 获取系统名称和版本号
        $list['webtitle'] = config('shangma.webtitle');
        $list['version'] = config('shangma.version');

        View::assign('list',$list);

        // 渲染输出
        return View::fetch();
    }


    // 系统维护
    public function weihu()
    {
        // 获取系统名称和版本号
        $list = [
            'shijian' => config('shangma.shijian')
            ,'shichang' => config('shangma.shichang')
            ,'webtitle' => '系统维护中'
            ,'version' => config('shangma.version')
        ];

        View::assign('list',$list);
        return View::fetch();
    }

}
