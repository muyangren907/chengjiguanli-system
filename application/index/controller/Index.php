<?php
namespace app\index\controller;

// 引用控制器基类
use app\common\controller\Base;
// 引用与此控制器同名的数据模型
use app\system\model\SystemBase as  sysbasemod;

use think\auth\Auth;

class Index extends Base
{

    // 初始化
    protected function initialize()
    {
        //实例化数据模型
        $sysbasemod = new sysbasemod();

        // 查询数据
        $list = $sysbasemod
            ->where('id','>',0)
            ->find();

        if( $list == null )
        {
            $sysbasemod->title = '学生成绩统计系统';
            $sysbasemod->save();
        }
        dump('index初始化');

    }


    // 主页
    public function index()
    {
        //实例化数据模型
        $sysbasemod = new sysbasemod();

        // 查询最新记录
        $list = $sysbasemod
            ->order(['id'=>'desc'])
            ->field('title,keywords,description')
            ->find();

        // 获取版本号
        $list->version = config('app.chengji.version');

        // 模版赋值
        $this->assign('list',$list);


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
            ->find();

        // 获取版本号
        $list->version = config('app.chengji.version');

        // 模版赋值
        $this->assign('list',$list);

        
        // 渲染输出
        return $this->fetch();
    }


}
