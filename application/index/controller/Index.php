<?php
namespace app\index\controller;

// 引用控制器基类
use app\common\controller\Base;
// 引用与此控制器同名的数据模型
use app\system\model\SystemBase as  sysbasemod;



class Index extends Base
{

    // 初始化
    protected function initialize()
    {

    }


    // 主页
    public function index()
    {
        //实例化数据模型
        $sysbasemod = new sysbasemod();

        // 查询系统信息
        $list = $sysbasemod
            ->order(['id'=>'desc'])
            ->field('title,keywords,description')
            ->find();

        // 实例化管理员数据模型
        $admin = new \app\admin\model\Admin;
        // 获取管理员信息
        $userinfo = $admin
            ->where('username',session('username'))
            ->field('username,id')
            ->find();

        // 获取版本号
        $list->version = config('app.chengji.version');

        // 模版赋值
        $this->assign('list',$list);
        $this->assign('userinfo',$userinfo);


        // 渲染输出
        return $this->fetch();
    }

    public function welcome()
    {
        //实例化数据模型
        $sysbasemod = new sysbasemod();

        // 查询最新记录
        $list = $sysbasemod
            ->order(['id'=>'desc'])
            ->field('title,thinks,danwei')
            ->find();

        // 获取版本号
        $list->version = config('app.chengji.version');

        // 模版赋值
        $this->assign('list',$list);

        
        // 渲染输出
        return $this->fetch();
    }

    public function exit()
    {
        // 清除cookie
        cookie(null, 'think_');
        // 清除session（当前作用域）
        session(null);

        // 跳转页面
        $this->redirect('/login');

    }

    


}
