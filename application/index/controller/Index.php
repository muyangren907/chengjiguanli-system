<?php
namespace app\index\controller;

// 引用控制器基类
use app\common\controller\Base;
// 引用与此控制器同名的数据模型
use app\system\model\SystemBase as  sysbasemod;

use think\auth\Auth;

class Index extends Base
{
    //关闭自动时间
    protected $autoWriteTimestamp = false;

    // 主页
    public function index()
    {
        //实例化数据模型
        $sysbasemod = new sysbasemod();

        // 查询最新记录
        $list = $sysbasemod
            ->order(['id'=>'desc'])
            ->field('title,keywords,description')
            ->limit(1)
            ->find();

        // 获取版本号
        $list->version = config('version');

        // 模版赋值
        $this->assign('list',$list);

        // $url = url('welcome');
        // halt($url);
        
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
            ->field('title,copyright,thinks')
            ->limit(1)
            ->find();

        // 获取版本号
        $list->version = config('version');

        // 模版赋值
        $this->assign('list',$list);

        
        // 渲染输出
        return $this->fetch();
    }


}
