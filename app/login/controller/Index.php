<?php
namespace app\login\controller;

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

        // 获取信息
        $sysbasemod = new \app\system\model\SystemBase;     # 关键字
        $list = $sysbasemod::sysInfo();     # 描述
        // 获取系统名称和版本号
        $list['version'] = config('shangma.version');


        View::assign('list',$list);

        // 渲染输出
        return View::fetch('index');
    }


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
            $admin = new \app\admin\model\Admin;
            $userinfo = $admin::where('username', $list['username'])
                ->where('status', 1)
                ->field('id, lastip, username, ip, denglucishu, lasttime, thistime, password')
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
        $admin = new \app\admin\model\Admin;
        $userinfo = $admin::where('username', $username)
            ->where('status', 1)
            ->field('id, lastip, username, ip, denglucishu, lasttime, thistime, password')
            ->find();
        if ($userinfo == null)
        {
            // 验证结果;
            $data = ['msg' => '管理员帐号不存在或被禁用', 'val' => 0];
            return $data;
        }

        // 验证用户名和密码
        $check = loginCheck($password, $userinfo->password);

        if ($check === true)
        {
            session('onlineCategory', 'admin');
            session('user_id', $userinfo->id);
            session('username', $username);
            session('password', $password);
            // 跳转到首页
            $data = ['msg' => '验证成功', 'val' => 1, 'url' =>'\\'];
        } else {
            // 提示错误信息
            $data = ['msg' => '用户名或密码错误', 'val' => 0];
        }

        return $data;
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
