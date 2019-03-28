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
            ->field('id,webtitle,keywords,description')
            ->find();

        // 存储网站名
        session('webtitle',$list->webtitle);

        // 获取版本号
        $list->version = config('app.chengji.version');
        // 获取用户名
        $list->username = session('username');


        // 实例化权限数据模型
        $authrule = new \app\admin\model\AuthRule;

        $list['menu'] = $authrule
                        ->where('pid',0)
                        ->where('status&ismenu',1)
                        ->field('id,title,font,name,pid')
                        ->with([
                            'authCid'=>function($query){
                                $query->field('id,title,name,pid,url');
                            },
                        ])
                        ->order(['paixu'])
                        ->select();


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
            ->field('webtitle,thinks,danwei')
            ->find();

        // 查询用户登录次数
        $admin = new \app\admin\model\Admin;
        $userid = session('userid');
        $list['username'] = session('username');
        $list['denglu'] = $admin->where('id',$userid)
                        ->field('denglucishu,lastip,lasttime')
                        ->find();
        $list['yuyan'] = request()->langset();
        $list['server'] = request()->server();
        $list['env'] = request()->env();



        // 获取版本号
        $list->version = config('app.chengji.version');

        // 模版赋值
        $this->assign('list',$list);

        
        // 渲染输出
        return $this->fetch();
    }


}
