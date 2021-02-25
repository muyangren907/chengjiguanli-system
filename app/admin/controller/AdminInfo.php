<?php
namespace app\admin\controller;

// 引用控制器基类
use app\base\controller\AdminBase;

// 引用用户数据模型
use app\admin\model\Admin as AD;

class AdminInfo extends AdminBase
{
    // 读取用户信息
    public function readAdmin($id)
    {
        // 获取管理员信息
        $ad = new AD;
        $list = AD::where('id', $id)
                ->field('id, xingming, sex, shengri, username, teacher_id, school_id, phone, denglucishu, lastip, ip, lasttime, quanpin, shoupin, zhiwu_id, zhicheng_id, biye, zhuanye, xueli_id, worktime, create_time, update_time')
                ->with([
                    'adSchool' => function($query){
                        $query->field('id, title');
                    },
                    'adZhiwu' => function($query){
                        $query->field('id, title');
                    },
                    'adZhicheng' => function($query){
                        $query->field('id, title');
                    },
                    'adXueli' => function($query){
                        $query->field('id, title');
                    },
                ])
                ->find();
        $list['webtitle'] = '帐号信息';
        $list->groupnames = $ad->getGroupnames($id);

        // 模板赋值
        $this->view->assign('list', $list);

        // 渲染模板
        return $this->view->fetch('read');
    }


    // 修改自己的密码
    public function editPassword()
    {
        // 设置页面标题
        $list['set'] = array(
            'webtitle' => '修改密码'
            ,'butname' => '修改'
            ,'formpost' => 'PUT'
            ,'url' => '/admin/index/updatepassword/' . session('user_id')
        );

        // 模板赋值
        $this->view->assign('list', $list);

        // 渲染模板
        return $this->view->fetch();
    }


    // 保存新密码
    public function updatePassword($id)
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
        $serpassword = AD::where('id', $id)->value('password');

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
        $data = AD::update(['id' => $id, 'password' => $password]);

        // 根据更新结果设置返回提示信息
        $data ? $data = ['msg' => '修改成功', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];

        // 返回信息
        return json($data);
    }


    // 读取用户信息
    public function myInfo()
    {
        $id = session('user_id');
        // 获取管理员信息
        $ad = new AD;
        $list = AD::where('id', $id)
                ->field('id, xingming, sex, shengri, username, teacher_id, school_id, phone, denglucishu, lastip, ip, lasttime, quanpin, shoupin, zhiwu_id, zhicheng_id, biye, zhuanye, xueli_id, worktime, create_time, update_time')
                ->with([
                    'adSchool' => function($query){
                        $query->field('id, title');
                    },
                    'adZhiwu' => function($query){
                        $query->field('id, title');
                    },
                    'adZhicheng' => function($query){
                        $query->field('id, title');
                    },
                    'adXueli' => function($query){
                        $query->field('id, title');
                    },
                ])
                ->find();
        $list['webtitle'] = '我的信息';
        $list->groupnames = $ad->getGroupnames($id);

        // 模板赋值
        $this->view->assign('list', $list);

        // 渲染模板
        return $this->view->fetch('read');
    }


    public function myQuanxian()
    {
        $id = session('user_id');
        $ad = new AD;
        $adInfo = $ad->where('id', session('user_id'))
                ->field('zhiwu_id')
                ->find();

        $bzr = new \app\teach\model\BanZhuRen;
        $banji_id = $bzr->srcTeacherNow($id);

        return $banji_id;

    }


    // 查询教师荣誉
    public function srcRy()
    {
        // 获取参数
        $src = $this->request
            ->only([
                'page' => '1'
                ,'limit' => '10'
                ,'field' => 'update_time'
                ,'order' => 'desc'
                ,'teacher_id' => ''
            ], 'POST');

        // 查询数据
        $rongyu = new \app\rongyu\model\JsRongyuInfo;
        $data = $rongyu->srcTeacherRongyu($src['teacher_id'])
            ->visible([
                'id'
                ,'title'
                ,'ryTuce' => [
                    'title'
                    ,'fzSchool'
                ]
                ,'jiangxiang_id'
                ,'hjshijian'
                ,'update_time'
            ]);
        $data = reSetObject($data, $src);
        return json($data);
    }


    // 查询教师课题
    public function srcKt()
    {
        // 获取参数
        $src = $this->request
            ->only([
                'page' => '1'
                ,'limit' => '10'
                ,'field' => 'update_time'
                ,'order' => 'desc'
                ,'teacher_id' => ''
            ], 'POST');

        // 查询数据
        $keti = new \app\keti\model\KetiInfo;
        $data = $keti->srcTeacherKeti($src['teacher_id']);
        $data = reSetObject($data, $src);

        return json($data);
    }


    // 查询担任班主任情况
    public function srcBzr()
    {
       // 获取参数
        $src = $this->request
            ->only([
                'page' => '1'
                ,'limit' => '10'
                ,'field' => 'update_time'
                ,'order' => 'desc'
                ,'teacher_id' => ''
            ], 'POST');

        // 查询数据
        $bzr = new \app\teach\model\BanZhuRen;
        $data = $bzr->srcTeacher($src);
        $data = reSetObject($data, $src);

        return json($data); 
    }


    // 修改信息
    public function edit()
    {
       $id = session('user_id');
       // 获取用户信息
       $list['data'] = AD::where('id', $id)
            ->field('id, xingming, quanpin, shoupin, username, shengri, sex, phone, zhiwu_id, zhicheng_id, xueli_id, biye, zhuanye, worktime')
            ->with([
                'adSchool'=>function($query){
                    $query->field('id, jiancheng');
                }
            ])
            ->find();

        // 设置页面标题
        $list['set'] = array(
            'webtitle' => '编辑管理员'
            ,'butname' => '修改'
            ,'formpost' => 'PUT'
            ,'url' => '/admin/info/update/' . $id
        );

        // 模板赋值
        $this->view->assign('list', $list);
        // 渲染
        return $this->view->fetch('edit');
    }


    // 更新管理员信息
    public function update($id)
    {
        // 获取表单数据
        $list = request()->only([
            'xingming'
            ,'quanpin'
            ,'shoupin'
            ,'username'
            ,'shengri'
            ,'sex'
            ,'phone'
            ,'school_id'
            ,'zhicheng_id'
            ,'xueli_id'
            ,'biye'
            ,'zhuanye'
            ,'worktime'
        ], 'PUT');
        $list['id'] = $id;

        // 验证表单数据
        $validate = new \app\admin\validate\Admin;
        $result = $validate->scene('infoedit')->check($list);
        $msg = $validate->getError();
        if(!$result){
            return json(['msg' => $msg, 'val' => 0]);;
        }

        // 更新我的信息
        $admindata = AD::update($list);

        // 根据更新结果设置返回提示信息
        $admindata ? $data = ['msg' => '更新成功', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];

        // 返回信息
        return json($data);
    }
}
