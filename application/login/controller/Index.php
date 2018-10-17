<?php
namespace app\login\controller;

// 引用控制器类
use think\Controller;
// 引用用户数据模型
use app\admin\model\Admin as admin;
// 引用与此控制器同名的数据模型
use app\system\model\SystemBase as  sysbasemod;
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
        $admin = new admin();
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
            $this->error($msg);
        }

        // 重新计算密码
        $miyao = $admin->miyao('admin');
        $data['password'] = $md5->hash($miyao,$data['password']);

        // 验证用户名和密码
        $userid = $this->check($data['username'],$data['password']);

        if($userid)
        {

            // 设置cookie值
            if( request()->post('online') == true )
            {
                // 设置
                cookie('username', $userinfo->username ,259200);
                cookie('password', $userinfo->password ,259200);
            }

            // 将本次信息上传到服务器上
            $userinfo = $admin->get($userid);
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
        //实例化类
        $admin = new admin();

        //验证密码
        $yz = $admin->check($username,$password);

        if($yz)
        {
            // Session存值
            session('username', $username);
            session('password', $password);
            session('userid', $yz);
        }else{
             // 清除cookie
            cookie(null, 'think_');
            // 清除session（当前作用域）
            session(null);
        }
        return $yz;        
    }



    // 首次登录添加admin
    public function first()
    {
        // 实例化模型
        $admin = new admin();
        // 实例化加密类
        $md5 = new APR1_MD5();
        // 实例化系统参数类
        $sysbasemod = new sysbasemod();

        $userinfo = $admin->get(1);

        $msg = array();

        $sysbase = $sysbasemod->get(1);

        if( $sysbase == null )
        {
            $sysbasemod->title = '学生成绩统计系统';
            $sysbasemod->save();
            $msg[] = '、系统参数初始化完成;';
        }else{
            $msg[] = '、系统参数已经初始化不再重复操作;';
        }

        $userinfo = $admin->get(1);

        if( $userinfo == null )
        {
            $admin->id =1;
            $admin->xingming ='管理员';
            $admin->username    = 'admin';
            $admin->miyao       = $md5->salt();
            $admin->password    = $md5->hash($admin->miyao,'123');
            $data = $admin->save();
            $msg[] = '、超级管理员信息初始化完成;';
        }else{
            $msg[] = '、超级管理员已经初始化不再重复操作;';
        }

        




        foreach ($msg as $key => $value) {
            echo $key+1 .$value;
            echo '<br>';
        }
        echo '</br>';
        echo '现在可以重新登录页系统';

        return '';
    }
}
