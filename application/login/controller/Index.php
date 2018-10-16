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
        $userid = $membermod->check($data);

        if($userid)
        {
            // 获取用户信息
            $userinfo = $membermod->get($userid);

            // Session存值
            session('username', $userinfo->username);
            session('password', $userinfo->password);
            session('userid', $userinfo->id);

            if( request()->post('online') == true )
            {
                // 设置
                cookie('username', $userinfo->username);
                cookie('password', $userinfo->password);
            }

            // 将本次信息上传到服务器上
            $userinfo->lastip = $userinfo->ip;
            $userinfo->ip = request()->host();
            $userinfo->denglucishu = ['inc', 1];
            $userinfo->lasttime = $userinfo->thistime;
            $userinfo->thistime = time();
            $userinfo->save();

            // 跳转到首页
            $this->redirect(url('/'));
            return '验证完成';

            //模版
        }else{
            // 跳转到首页
            $this->redirect(url('/notfound',['msg' => '用户名或密码错误']));
            return '验证失败';
        }

        return '';
    }



    // 首次登录添加admin
    public function first()
    {
        // 实例化模型
        $membermod = new membermod();
        // 实例化加密类
        $md5 = new APR1_MD5();

        $userinfo = $membermod->get(1);

        $msg = array();

        if( $userinfo == null )
        {
            $msg[] = '1、检查到不存在超级管理员，准备添加超级管理员；';
            $membermod->id =1;
            $membermod->xingming ='管理员';
            $membermod->username    = 'admin';
            $membermod->miyao       = $md5->salt();
            $membermod->password    = $md5->hash($membermod->miyao,'123');
            $data = $membermod->save();
            $data ? $msg[] = '2、超级管理员添加成功。用户名:admin、密码:123;' : $msg[] = '2、超级管理员添加失败，请联系系统维护人员。';

        }else{
            $msg[] = '1、已经存在超级管理员终止操作；';
        }

        foreach ($msg as $key => $value) {
            echo $value;
            echo '<br>';
        }

        return '';
    }
}
