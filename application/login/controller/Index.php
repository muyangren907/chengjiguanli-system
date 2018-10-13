<?php
namespace app\login\controller;

// 引用控制器类
use think\Controller;
// 引用用户数据模型
use app\member\model\Member as membermod;


class Index extends Controller
{
    // 显示登录界面
    public function index()
    {
        // 渲染输出
        return $this->fetch();
    }


    // 登录验证
    public function yanzheng()
    {
        $membermod = new membermod();

        $list = request()->post();

        $validate = new \app\login\validate\Yanzheng;

        $data = request()->post('username');

        if (!$validate->check($data)) {
            dump($validate->getError());
        }


        // return true;
    }
}
