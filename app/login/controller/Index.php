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
                $data = $this->admin($list);
                break;

            case 'teacher':
                $data = $this->teacher($list);
                break;

            case 'student':
                $data = $this->student($list);
                break;

            default:
                $data = ['msg' => '用户身份丢失', 'val' => 1];
                break;
        }

        return json($data);
    }



    // 登录验证
    public function admin($list)
    {
        // 获取服务器密码
        $userinfo = AD::where('username', $list['username'])
            ->where('val', 1)
            ->field('id, lastip, username, ip, denglucishu, lasttime, thistime, password')
            ->find();

        if($userinfo == null)
        {
            // 清除session（当前作用域）
            session(null);
            // 验证结果;
            $data = ['msg' => '管理员帐号不存在或被禁用', 'val' => 0];
            return json($data);
        }


        // 验证用户名和密码
        $check = $this->check($list['password'], $userinfo->password);

        if($check['val'] === 1)
        {
            session(null);
            session('onlineCategory', 'admin');
            session('user_id', $userinfo->id);

            // 将本次信息上传到服务器上
            $userinfo->lastip = $userinfo->ip;
            $userinfo->ip = request()->ip();
            $userinfo->denglucishu = ['inc', 1];
            $userinfo->lasttime = $userinfo->getData('thistime');
            $userinfo->thistime = time();
            $userinfo->save();

            // 跳转到首页
            $data = ['msg' => '验证成功', 'val' => 1];
        }else{
            // 提示错误信息
            $data = ['msg' => $check['msg'], 'val' => 0];
        }

        return json($data);
    }


    // 已知密码进行验证
    public function check($srcfrom)
    {
        $src = [
            'username' => ''
            ,'password' => ''
            ,'onlineCategory' => ''
            ,'user_id' => ''
        ];
        $src = array_cover($srcfrom, $src);

        // 实例化加密类
        $md5 = new APR1_MD5();

        //验证密码
        $check = $md5->check($inputPassword, $serverPassword);

        if($check)
        {
            session('username', $username);
            session('password', $password);
            $data = ['msg' => '验证成功', 'val' => 1];
        }else{
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
