<?php
namespace app\index\controller;

// 引用控制器基类
use app\BaseController;
// 引用与此控制器同名的数据模型
use app\system\model\SystemBase as  sysbasemod;
// 引用视图功能类
use think\facade\View;



class Index extends BaseController
{

    // 初始化
    protected function initialize()
    {

    }


    // 主页
    public function index()
    {
        //实例化系统数据模型
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
        // 获取用户姓名
        $ad = new \app\admin\model\Admin;
        $list->xingming = $ad->where('id',session('userid'))->value('xingming');
        // 查询用户拥有的权限
        $admininfo = $ad->where('id',session('userid'))
                        ->field('id')
                        ->with([
                            'glGroup'=>function($query){
                                $query->where('status',1)->field('title,rules,miaoshu');
                            }
                        ])
                        ->find();
        $rules = '';
        foreach ($admininfo->gl_group as $key => $value) {
            if($key == 0){
                $rules = $value->rules;
            }else{
                $rules = $rules.','.$value->rules;
            }
        }


        // 实例化权限数据模型
        $authrule = new \app\admin\model\AuthRule;
        // 获取用户拥有权限的菜单
        $list['menu'] = $authrule
                        ->where('pid',0)
                        ->where('status&ismenu',1)
                        ->when(session('userid')>2,function($query) use($rules){
                            $query->where('id','in',$rules);
                        })
                        ->field('id,title,font,name,pid')
                        ->with([
                            'authCid'=>function($query) use($rules){
                                $query->where('status&ismenu',1)
                                    ->when(session('userid')>2,function($query) use($rules)
                                    {
                                        $query->where('id','in',$rules);
                                    })
                                    ->field('id,title,name,pid,url');
                            },
                        ])
                        ->order(['paixu'])
                        ->select()->toArray();


        // 模版赋值
        View::assign('list',$list);
        // 渲染输出
        return View::fetch();
    }



    public function welcome()
    {

        //实例化数据模型
        $sysbasemod = new sysbasemod();

        // 查询系统设置
        $list = $sysbasemod
            ->order(['id'=>'desc'])
            ->field('webtitle,thinks,danwei')
            ->find();

        // 查询用户登信息
        $list['username'] = session('username');

        // 查询用户姓名及用户拥有的权限
        $admin = new \app\admin\model\Admin;
        $list['xingming'] = $admin->where('id',session('userid'))->value('xingming');
        $list['group'] = $admin->getGroupnames(session('userid'));

        $list['server'] = request()->server();
        // 获取版本号
        $list->version = config('app.chengji.version');


        // 考试数
        $con = new \app\kaoshi\model\Kaoshi;
        $list['kaoshi'] = $con->count();
        // 教师数
        $con = new \app\renshi\model\Teacher;
        $list['teacher'] =  $con->count();
        // 学生数
        $con = new \app\renshi\model\Student;
        $list['student'] =  $con->count();
        // 管理员数
        $con = new \app\admin\model\Admin;
        $list['admin'] =  $con->count();
        // 荣誉数
        $con = new \app\rongyu\model\JsRongyuInfo;
        $list['rongyu'] =  $con->count();
        // 课题数
        $con = new \app\keti\model\KetiInfo;
        $list['keti'] =  $con->count();




        // 模版赋值
        View::assign('list',$list);

        
        // 渲染输出
        return View::fetch('welcome');
    }


}
