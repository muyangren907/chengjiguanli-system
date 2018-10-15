<?php
namespace app\login\controller;

// 引用控制器类
use think\Controller;
// 引用用户数据模型
use app\member\model\Member as membermod;
// 引用请求类
use think\facade\Request;
// 引用加密类
use WhiteHat101\Crypt\APR1_MD5;


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
        // 实例化模型
        $membermod = new membermod();
        // 实例化验证模型
        $validate = new \app\login\validate\Yanzheng;
        // 实例化加密类
        $md5 = new APR1_MD5();

        // 获取表单数据
        $data = request()->only(['username','password']);

        // 验证表单数据
        $result = $validate->check($data);
        $msg = $validate->getError();
        if(!$result){
            $this->redirect('/notfound',[], 302, ['msg' => $msg]);
        }

        // 重新计算密码
        $miyao = $membermod->miyao('admin');
        $data['password'] = $md5->hash($miyao,$data['password']);

        // 验证用户名和密码
        $list = $membermod->check($data);

        if($list)
        {
            dump($list);
        }else{
            dump($list);
        }



    }
}
