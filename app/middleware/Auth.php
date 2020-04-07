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

        $uneed_a = array(
            'upload',   # 上传
            'ajaxdata',     # 常规数据获取
            'saveall',  # 批量保存
        );


        // 排除指定模块下的指定方法
        $uneed_u = array(
            // Index应用
            'index/index/index',    # 主页
            'index/index/welcome',  # 欢迎页
            // Admin应用
            'admin/index/myinfo',   # 个人信息
            'admin/index/editpassword',   # 编辑密码
            'admin/index/updatepassword',   # 更新密码
            // Teach应用
            'teach/banji/mybanji',  # 获取班级数据
            'teach/banji/banjilist',  # 获取班级数据
            'teach/banjichengji/ajaxdatatiaoxing',  # 获取班级成绩-条形统计表
            // Kaoshi应用
            'kaoshi/index/cyschool',    # 获取参加考试学校
            'kaoshi/index/cynianji',    # 获取参加考试年级
            'kaoshi/index/cybanji',    # 获取参加考试班级
            'kaoshi/index/cysubject',    # 获取参加考试学科
            'kaoshi/index/cysubject',    # 获取参加考试学科
            // Kaohao应用
            'kaohao/excel/biaoqianxls',    # 下载试卷标签
            'kaohao/excel/dwcaiji',    # 下载成绩采集表
            // Renshi应用
            'renshi/student/ajaxdataby',    # 获取毕业学生列表
            'renshi/student/ajaxdatadel',    # 获取删除学生列表
            'renshi/student/srcstudent',    # 查询学生名单
            'renshi/studentchengji/ajaxonestudentchengjitubiao',    # 获取学生成绩拆线图数据
            'renshi/studentchengji/ajaxonestudentchengjileida',    # 获取学生成绩雷达图数据
            'renshi/teacher/ajaxdatadel',   # 获取删除教师列表
            'renshi/teacher/srcteacher',    # 搜索教师
            'renshi/teacher/srcry',    # 获取当前教师荣誉列表
            'renshi/teacher/srckt',    # 获取当前教师课题列表
            // Chengji应用
            'chengji/index/ajaxaddinfo',    # 获取录入该学生成绩人员的信息
            'chengji/index/dwchengjixlsx',    # 下载学生成绩
            'chengji/index/dwchengjitiaoxlsx',    # 下载学生成绩条
            'chengji/bjtongji/dwbanjixls',    # 下载班级成绩统计表
            'chengji/bjtongji/myavg',    # 获取单项成绩数据
            'chengji/bjtongji/myxiangti',    # 获取成绩箱体图数据
            'chengji/njtongji/dwnianjixlsx',    # 下载年级成绩统计表
            'chengji/njtongji/myavg',    # 获取单项成绩数据
            'chengji/njtongji/myxiangti',    # 获取成绩箱体图数据
        );


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
            $this->error('哎哟~  因为权限不足', '/login/err');
        }

        return $next($request);
    }
}
