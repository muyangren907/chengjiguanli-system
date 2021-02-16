<?php
namespace app\login\controller;

// 引用控制器基类
use app\BaseController;

use app\login\controller\YanZheng as yz;


class Index extends BaseController
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
        if(!$sysbasemod)
        {
            $list = $sysbasemod::sysInfo();     # 描述
        } else {
            $list['sys_title'] = config('shangma.webtitle');
        }
        // 获取系统名称和版本号
        $list['version'] = config('shangma.version');

        $this->view->assign('list',$list);

        // 渲染输出
        return $this->view->fetch('index');
    }


    // 管理员登录验证
    public function admin()
    {
        // // 清除cookie
        // cookie('userid', null);
        // cookie('username', null);
        // cookie('password', null);
        // // 清除session（当前作用域）
        // session(null);

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

        $yz = yz::admin($list['username'], $list['password']);

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


    // 学生登录验证
    public function teacher()
    {
        // // 清除cookie
        // cookie('userid', null);
        // cookie('username', null);
        // cookie('password', null);
        // // 清除session（当前作用域）
        // session(null);

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

        $yz = yz::teacher($list['username'], $list['password']);

        if($yz['val'] === 1)
        {
            // 获取服务器密码
            $ter = new \app\teacher\model\Teacher;
            $userinfo = $ter::where('phone', $list['username'])
                ->where('status', 1)
                ->field('id, lastip, phone, ip, denglucishu, lasttime, thistime, password')
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


    // 学生登录验证
    public function student()
    {
        // // 清除cookie
        // cookie('userid', null);
        // cookie('username', null);
        // cookie('password', null);
        // // 清除session（当前作用域）
        // session(null);

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

        $yz = yz::student($list['username'], $list['password']);

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


    // 系统更新日志
    public function shangmaLog()
    {
        // 渲染模板
        return $this->view->fetch();
    }


    // 错误页面
    public function myerror()
    {
        // 获取系统名称和版本号
        $list['webtitle'] = config('shangma.webtitle');
        $list['version'] = config('shangma.version');

        $this->view->assign('list',$list);

        // 渲染输出
        return $this->view->fetch();
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

        $this->view->assign('list',$list);
        return $this->view->fetch();
    }

}
