<?php
declare (strict_types = 1);

namespace app\middleware;

use think\exception\HttpResponseException;
use \liliuwei\think\Auth AS AuthHandle;
use think\facade\Config;


class Auth
{
    use \liliuwei\think\Jump; 
    /**
     * 处理请求
     *
     * @param \think\Request $request
     * @param \Closure       $next
     * @return Response
     */
    public function handle($request, \Closure $next)
    {

        $admins = Config::get('auth.auth_config.administrator');
        // 如果当前用户ID在配置排除的列表中，愚昧取消验证
        if(in_array(session('userid'),$admins)){
            $admin = true;
        }else{
            $admin = false;
        }

        // 获取当前地址
        $mod = strtolower(app('http')->getName());
        $con = strtolower($request->controller());
        $act = strtolower($request->action());

        $url = $mod.'/'.$con.'/'.$act;

        // 排除应用
        $uneed_m = array('index');
        // 排除控制器
        $uneed_c = array();     # 荣誉器名首字母要大写
        // 排除方法
        $uneed_a = array(
            'upload','myinfo',
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

        $auth = new AuthHandle;


        // 验证方法
        if( $auth->check($url, session('userid')) == false && $except == false && $admin == false ){// 第一个参数是规则名称,第二个参数是用户UID
            $this->error('哎哟~  因为权限不足');
        }

        return $next($request);
    }
}
