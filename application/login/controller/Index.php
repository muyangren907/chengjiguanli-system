<?php
namespace app\login\controller;

// 引用控制器类
use think\Controller;
// 引用用户数据模型
use app\admin\model\Admin as AD;
// 引用加密类
use WhiteHat101\Crypt\APR1_MD5;
// 引用Session类
use \think\facade\Session;
// 引用验证码类
use think\captcha\Captcha;


class Index extends Controller
{
    // 显示登录界面
    public function index()
    {
        // 清除cookie
        cookie(null, 'think_');
        // 清除session（当前作用域）
        session(null);

        // 获取系统版本号
        $list['version'] = config('app.chengji.version');

        $this->assign('list',$list);

        // 渲染输出
        return $this->fetch();
    }


    // 登录验证
    public function yanzheng()
    {

        // 实例化验证模型
        $validate = new \app\login\validate\Yanzheng;


        // 获取表单数据
        $data = request()->only(['username','password','captcha']);

        
        // 验证表单数据
        $result = $validate->check($data);
        if(!$result){
            $data=['msg'=>$validate->getError(),'status'=>0];
            return json($data);
        }

        // 验证用户名和密码
        $check = $this->check($data['username'],$data['password']);

        if($check['status']==1)
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
            $userinfo->ip = request()->ip();
            $userinfo->denglucishu = ['inc', 1];
            $userinfo->lasttime = $userinfo->thistime;
            $userinfo->thistime = time();
            $userinfo->save();

            // 跳转到首页
            $data=['msg'=>'验证成功','status'=>1];
        }else{
            // 提示错误信息
            $data=['msg'=>$check['msg'],'status'=>0];
        }

        return json($data);
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
            // 清除session（当前作用域）
            session(null);
            // 验证结果;
            $data=['msg'=>'用户名不存在或被禁用','status'=>0];
            return $data;
        }


        //验证密码
        $check = $md5->check($password,$userinfo->password);
        
        if($check)
        {
            session(null);
            session('userid', $userinfo->id);
            session('username', $username);
            session('password', $password);
            $data=['msg'=>'验证成功','status'=>1];
        }else{
             // 清除cookie
            cookie(null, 'think_');
            // 清除session（当前作用域）
            session(null);
            $data=['msg'=>'用户名或密码错误','status'=>0];
        }
        return $data;        
    }

    // 生成验证码
    public function verify()
    {
        $captcha = new Captcha();
        $captcha->fontSize = 30;
        $captcha->length   = 6;
        $captcha->codeSet = '0123456789'; 
        return $captcha->entry();    
    }    
}
