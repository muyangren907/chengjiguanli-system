<?php
namespace app\login\controller;

// 引用控制器类
use think\Controller;
// 引用用户数据模型
use app\admin\model\Admin as AD;

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

        // 实例化验证模型
        $validate = new \app\login\validate\Yanzheng;


        // 获取表单数据
        $data = request()->only(['username','password']);

        // 验证表单数据
        $result = $validate->check($data);
        $msg = $validate->getError();
        if(!$result){
            $this->error($msg);
        }


        // 验证用户名和密码
        $check = $this->check($data['username'],$data['password']);

        if($check)
        {

            // 设置cookie值
            if( request()->post('online') == true )
            {
                // 设置
                cookie('userid', session('userid') ,259200);
                cookie('username', $data['username'] ,259200);
                cookie('password', $data['password'] ,259200);
            }

            // 将本次信息上传到服务器上
            $userinfo = AD::getByUsername($data['username']);
            $userinfo->lastip = $userinfo->ip;
            $userinfo->ip = request()->host();
            $userinfo->denglucishu = ['inc', 1];
            $userinfo->lasttime = $userinfo->thistime;
            $userinfo->thistime = time();
            $userinfo->save();

            // 跳转到首页
            $this->redirect(url('/'));
        }else{
            // 提示错误信息
            $this->error('用户名或密码错误');
        }

        return '';
    }


    // 已知密码进行验证
    public function check($username,$password)
    {
        // 实例化加密类
        $md5 = new APR1_MD5();

        // 获取服务器密码
        $userinfo = AD::where('username',$username)->where('status',1)->find();

        if($userinfo == null)
        {
            // 提示错误信息
            $this->error('帐号不存在');
        }


        //验证密码
        $check = $md5->check($password,$userinfo->password);
        
        if($check)
        {
            // Session存值
            session('userid', $userinfo->id);
            session('username', $username);
            session('password', $password);
        }else{
             // 清除cookie
            cookie(null, 'think_');
            // 清除session（当前作用域）
            session(null);
        }
        return $check;        
    }


    // 生成验证码
    public function verify()
    {
        $captcha = new \think\captcha\Captcha;
        return $captcha->entry();    
    }

    public function checkcaptcha($value)
    {
        dump($value);
        $captcha = new \think\captcha\Captcha;
        if( $captcha->check($value))
        {
            return true;
        }else{
            return false;
        }
    }
    
}
