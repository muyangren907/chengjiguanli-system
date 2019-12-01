<?php

namespace app\http\middleware;

// 引用控制器类
use think\Controller;
// 引用权限验证类
use \php4world\Auth;


class OnLine  extends Controller
{
    public function handle($request, \Closure $next)
    {
        // 声明帐号密码变量
        $username = session('username');
        $password = session('password');

        // 如果用户没有登录直接跳转到登录页面
        if( strlen($username)<1 )
        {
            $username = cookie('username');
            $password = cookie('password');
        }
        if( strlen($username)<1 )
        {
            echo "<script>top.location.href='/login';</script>";
        }

        // 检验用户名或密码是否正确
        $yz = action('login/index/check',['username'=>$username,'password'=>$password]);
        if($yz['status'] == 0){
            echo "<script>top.location.href='login';</script>";
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
            'welcome','upload','myinfo',
            'mybanji','banjilist',
            'editpassword','updatepassword',
            // 教师信息查询
            'srcteacher','srcry','srckt',
            // 查询班级成绩、查询年级成绩、查询录入成绩人员信息
            'ajaxbianji','ajaxnianji','ajaxaddinfo',
            // 批量保存
            // 'saveall',
            // 下载成绩表、下载成绩统计表
            'dwchengjixls','dwbanjixls','dwnianjixls',
            //保存考号、下载试卷标签、下载成绩采集表
            'updateset','kaohaosave','biaoqianxls','dwcaiji',
            //课题结题图片上传和更新
            'jtupload','jtupdate','ajaxdata'
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
            $this->error('哎哟~  因为权限不足');
        } 

    	return $next($request);
    }
}
