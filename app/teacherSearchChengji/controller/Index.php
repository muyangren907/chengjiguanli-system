<?php
declare (strict_types = 1);

namespace app\teacherSearchChengji\controller;

// 引用学生查询基类
use \app\base\controller\TeacherSearchBase;
// 引用与此控制器同名的数据模型
use \app\system\model\SystemBase as  sysbasemod;
// 引用学生数据模型类
use \app\teacherSearchChengji\model\OneTeacherChengji as TCHCJ;
// 引用学生数据模型类
use \app\teacher\model\Teacher as TCH;
// 引用加密类
use WhiteHat101\Crypt\APR1_MD5;

class Index extends TeacherSearchBase
{
    // 学生查询页首页
    public function index()
    {
    	// 获取信息
        $sysbasemod = new sysbasemod();     # 关键字
        $list = $sysbasemod::sysInfo();     # 描述
        $list['webtitle'] = config('shangma.webtitle'); # 系统名称
        $list['version'] = config('shangma.version');   # 版本号
        $tch = new TCH;   # 获取用户姓名

        $list->info = $tch->where('id', session('teacher.userid'))
                ->field('id, xingming, danwei_id')
                ->with([
                    'jsDanwei' => function ($query) {
                        $query->field('id, title, jiancheng');
                    }
                ])
                ->find();
        $sysClass = \app\facade\System::sysClass();
        $temp = [
            [
                'title' => '成绩查询'
                ,'font' => '&#xe6c9;'
                ,'authCid' => [
                    [
                        'title' => '班级成绩'
                        ,'url' => '/teachersearchchengji/index/banji'
                    ]
                    , [
                        'title' => '学生成绩'
                        ,'url' => '/teachersearchchengji/index/databanji'
                    ]
                ]
            ]
        ];

        if($sysClass->teacherrongyu)
        {
            $cnt = count($temp);
            $temp[] = [
                'title' => '荣誉查询'
                ,'font' => '&#xe6e4;'
                ,'authCid' => [
                    [
                        'title' => '荣誉查询一'
                        ,'url' => ''
                    ]
                ]
            ];
        }
        if($sysClass->teacherketi)
        {
            $cnt = count($temp);
            $temp[] = [
                'title' => '课题查询'
                ,'font' => '&#xe6b3;'
                ,'authCid' => [
                    [
                        'title' => '课题查询一'
                        ,'url' => ''
                    ]
                ]
            ];
        }

        $list['menu'] = $temp;


        // 模版赋值
        $this->view->assign('list', $list);
        // 渲染输出
        return $this->view->fetch();
    }



    // 教师登录欢迎页
    public function welcome()
    {
        //实例化数据模型
        $sysbasemod = new sysbasemod();

        // 查询系统设置
        $list = $sysbasemod
            ->order(['id'=>'desc'])
            ->field('thinks, danwei')
            ->find();

        // 查询用户登信息
        $list['username'] = session('teacher.username');
        $list['webtitle'] = config('shangma.webtitle');


        $list['xingming'] = TCH::where('phone', $list['username'])->value('xingming');
        $list['version'] = config('shangma.version');
        $list['kaoshi'] = 1;
        $list['teacher'] = 1;
        $list['student'] = 1;


        // 模版赋值
        $this->view->assign('list',$list);
        // 渲染输出
        return $this->view->fetch();
    }



    // 学生查询页首页
    public function read($teacher_id)
    {
        $kh = new \app\kaohao\model\Kaohao;
        $khInfo = $kh->where('id', $kaohao_id)
            ->with([
                'cjKaoshi' => function ($query) {
                    $query->field('id, title, bfdate, enddate');
                }
            ])
            ->find();
        $list['webtitle'] = $khInfo->cjKaoshi->title;
        $list['id'] = $khInfo->id;

        // 模板赋值
        $this->view->assign('list', $list);

        return $this->view->fetch('kaohao@index/read');
    }


    // 修改密码
    public function editpassword()
    {
        // 设置页面标题
        $list['set'] = array(
            'webtitle' => '修改密码'
            ,'butname' => '修改'
            ,'formpost' => 'PUT'
            ,'url' => '/teachersearchchengji/index/updatepassword/' . session('teacher.userid')
        );

        // 模板赋值
        $this->view->assign('list', $list);

        // 渲染模板
        return $this->view->fetch('admin@index/edit_password');
    }


    // 保存新密码
    public function updatePassword($teacher_id)
    {
        // 获取表单数据
        $list = request()->post();

        // 验证表单数据
        $validate = new \app\admin\validate\SetPassword;
        $result = $validate->check($list);
        $msg = $validate->getError();

        // 如果验证不通过则停止保存
        if(!$result){
            return json(['msg' => $msg, 'val' => 0]);;
        }

        // 获取用户名
        $tch = new TCH;
        $serpassword = $tch::where('id', $teacher_id)->value('password');

        // 实例化加密类
        $md5 = new APR1_MD5();
        //验证密码
        $check = $md5->check($list['oldpassword'], $serpassword);

        if(!$check)
        {
            $data = ['msg' => '旧密码错误', 'val' => 0];
            return json($data);
        }

        // 更新密码
        $password = $md5->hash($list['newpassword']);
        $data = $tch::update(['id' => $teacher_id, 'password' => $password]);

        // 根据更新结果设置返回提示信息
        $data ? $data = ['msg' => '修改成功', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];

        // 返回信息
        return json($data);
    }


    // 班级成绩列表
    public function banji()
    {
        $teacher_id = session('teacher.userid');
        $list['teacher_id'] = $teacher_id;

        $sbj = new \app\teach\model\Subject;
        $list['subject'] = $sbj->kaoshi();

        // 设置要给模板赋值的信息
        $list['webtitle'] = '班级成绩列表';
        $list['dataurl'] = '/teachersearchchengji/index/banjidata';

        // 模板赋值
        $this->view->assign('list', $list);

        // 渲染模板
        return $this->view->fetch();
    }


    // 获取班级成绩数据
    public function ajaxDataBanji()
    {
        // 获取参数
        $src = $this->request
            ->only([
                'page' => '1'
                ,'limit' => '10'
                ,'teacher_id' => ''
                ,'xueqi_id' => ''
                ,'category_id' => array() # 考试类型
                ,'subject_id' => array()
                ,'bfdate' => ''
                ,'enddate' => ''
            ], 'POST');

        // 统计成绩
        $btj = new \app\chengji\model\TongjiBj;
        $data = $btj->searchTeacher($src);
        $data = reSetObject($data, $src);

        return json($data);
    }


    // 查看班级成绩
    public function detail($bjtj_id)
    {
        // 统计成绩
        $btj = new \app\chengji\model\TongjiBj;
        $list = $btj->where('id', $bjtj_id)
            ->field('id, banji_id, kaoshi_id, subject_id')
            ->with([
                'bjSubject' => function ($query) {
                    $query->field('id, title, jiancheng');
                }
                ,'bjKaoshi' => function ($query) {
                    $query->field('id, title, enddate');
                }
            ])
            ->append(['banjiTitle'])
            ->find();

        // 设置要给模板赋值的信息
        $list['webtitle'] = $list->banjiTitle . '学生成绩';
        $list['dataurl'] = '/teachersearchchengji/index/detaildata';

        // 模板赋值
        $this->view->assign('list', $list);

        // 渲染模板
        return $this->view->fetch();
    }


    // 获取班级学生成绩
    public function ajaxDataDetail()
    {
        // 获取参数
        $src = $this->request
            ->only([
                'page' => '1'
                ,'limit' => '10'
                ,'kaoshi_id' => ''
                ,'banji_id' => ''
                ,'subject_id' => array()
                ,'searchval'
            ], 'POST');

        $cj = new \app\chengji\model\Chengji;
        $data = $cj->searchTeacher($src);

        $data = reSetArray($data, $src);

        return json($data);
    }
}
