<?php

namespace app\http\middleware;

// 引用控制器类
use think\Controller;
// 引用权限验证类
use \php4world\Auth;


class YanZheng  extends Controller
{
    public function handle($request, \Closure $next)
    {
        // 声明帐号密码变量
        $username = 0;
        $password = 0;

        // 如果用户没有登录直接跳转到登录页面
        if( session('?username') )
        {
            $username = session('username');
            $password = session('password');
        }elseif(cookie('username') != null)
        {
            // 获取用户名和密码
            $username = cookie('username');
            $password = cookie('password');
        }else{
            $this->redirect('/login',302);
        }

        // 检验用户名或密码是否正确
        $yz = action('login/index/check',['username'=>$username,'password'=>$password]);
        if($yz == null){
            $this->error('请重新登录');
        }
        

        // 实例化权限验证类
    	$auth = new Auth();

        // 获取当前地址
        $mod = $request->module();
        $con = $request->controller();
        $act = $request->action();
    	$url = $mod.'/'.$con.'/'.$act;

        // 排除模块
        $uneed_m = array('home');
        // 排除控制器
        $uneed_c = array();     # 荣誉器名首字母要大写
        // 排除方法
        $uneed_a = array(
            'welcome','update','save',
            'index','mybanji','banjilist',
            'ajaxnianji','editpassword','updatepassword'
        );
        // 排除指定模块下的指定方法
        $uneed_u = array('index/Index/index');

        // 验证是否是排除方法
        if(in_array($mod,$uneed_m) || in_array($con,$uneed_c) || in_array($act,$uneed_a) || in_array($url,$uneed_u))
        {
            $except = true;
        }else{
            $except = false;
        }

        // 验证方法
        if( !$auth->check($url, session('userid')) && $except == false ){// 第一个参数是规则名称,第二个参数是用户UID
            $this->error('哎哟~  权限不足');
        } 

    	return $next($request);
    }
}
