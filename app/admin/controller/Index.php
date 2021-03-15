<?php

namespace app\admin\controller;

// 引用控制器基类
use app\base\controller\AdminBase;
// 引用用户数据模型
use app\admin\model\Admin as AD;
// 引用加密类
use WhiteHat101\Crypt\APR1_MD5;

class Index extends AdminBase
{
    // 管理员列表
    public function index()
    {
        // 设置要给模板赋值的信息
        $list['webtitle'] = '管理员列表';
        $list['dataurl'] = '/admin/index/data';
        $list['status'] = '/admin/index/status';

        // 模板赋值
        $this->view->assign('list', $list);

        // 渲染模板
        return $this->view->fetch();
    }


    // 获取数据管理员数据
    public function ajaxData()
    {
        // 获取参数
        $src = $this->request
                ->only([
                    'page' => '1'
                    ,'limit' => '10'
                    ,'field' => 'id'
                    ,'order' => 'desc'
                    ,'searchval' => ''
                ],'POST');

        // 实例化
        $ad = new AD;
        $data = $ad->search($src)
            ->visible([
                'id'
                ,'xingming'
                ,'sex'
                ,'shengri'
                ,'username'
                ,'adSchool' => ['jiancheng']
                ,'glGroup' => ['title']
                ,'phone'
                ,'thistime'
                ,'ip'
                ,'denglucishu'
                ,'status'
                ,'update_time'
            ]);
        $data = reSetObject($data, $src);

        return json($data);
    }


    // 创建用户信息
    public function create()
    {
        // 设置页面标题
        $list['set'] = array(
            'webtitle' => '添加管理员'
            ,'butname' => '添加'
            ,'formpost' => 'POST'
            ,'url' => 'save'
        );

        // 模板赋值
        $this->view->assign('list', $list);
        // 渲染
        return $this->view->fetch('create');
    }


    // 保存管理员
    public function save()
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
            ,'group_id'
            ,'zhiwu_id'
            ,'zhicheng_id'
            ,'xueli_id'
            ,'biye'
            ,'zhuanye'
            ,'worktime'
            ,'tuixiu'
            ,'beizhu'
        ], 'POST');

        // 设置密码，默认为123456
        $md5 = new APR1_MD5();
        $list['password'] = $md5->hash('123456');

        // 验证表单数据
        $validate = new \app\admin\validate\Admin;
        $result = $validate->scene('admincreate')->check($list);
        $msg = $validate->getError();
        if(!$result){
            return json(['msg' => $msg, 'val' => 0]);;
        }

        // 实例化管理员数据模型类
        $admin = new AD();
        $admindata = $admin->create($list);
        $groupdata=$admindata->glGroup()->saveAll($list['group_id']);   # 更新中间表

        // 根据更新结果设置返回提示信息
        $admindata && $groupdata ? $data = ['msg' => '添加成功', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];

        // 返回信息
        return json($data);
    }

    // 修改信息
    public function edit($id)
    {
        // 获取用户信息
       $list['data'] = AD::where('id',$id)
            ->field('id, xingming, quanpin, shoupin, username, shengri, sex, phone, school_id, zhiwu_id, zhicheng_id, xueli_id, biye, zhuanye, worktime, tuixiu, beizhu')
            ->with([
                'adSchool'=>function($query){
                    $query->field('id, jiancheng');
                }
                ,'glGroup'=>function($query){
                    $query->where('status', 1)->field('title, rules, miaoshu');
                }
            ])
            ->find();

        // 设置页面标题
        $list['set'] = array(
            'webtitle' => '编辑管理员'
            ,'butname' => '修改'
            ,'formpost' => 'PUT'
            ,'url' => '/admin/index/update/' . $id
        );

        // 模板赋值
        $this->view->assign('list', $list);
        // 渲染
        return $this->view->fetch('create');
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
            ,'group_id' => array()
            ,'zhiwu_id'
            ,'zhicheng_id'
            ,'xueli_id'
            ,'biye'
            ,'zhuanye'
            ,'worktime'
            ,'tuixiu'
            ,'beizhu'
        ], 'PUT');
        $list['id'] = $id;

        $list['group_id'] = array_values($list['group_id']);

        // 验证表单数据
        $validate = new \app\admin\validate\Admin;
        $result = $validate->scene('adminedit')->check($list);
        $msg = $validate->getError();
        if(!$result){
            return json(['msg' => $msg, 'val' => 0]);;
        }

        // 更新管理员信息
        $admindata = AD::update($list);
        // 更新中间表
        $groupdata=$admindata->glGroup()->detach();
        $groupdata=$admindata->glGroup()->attach($list['group_id']);

        // 根据更新结果设置返回提示信息
        $admindata && $groupdata ? $data = ['msg' => '更新成功', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];

        // 返回信息
        return json($data);
    }


    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete()
    {
        // 整理数据
        $id = request()->delete('id');
        $id = explode(',', $id);

        $data = AD::destroy($id);

        // 根据更新结果设置返回提示信息
        $data ? $data = ['msg' => '删除成功', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];

        // 返回信息
        return json($data);
    }


    // 修改管理员状态
    public function setStatus()
    {
        //  获取id变量
        $id = request()->post('id');
        $value = request()->post('value');

        // 更新管理员信息
        $data = AD::where('id', $id)->update(['status' => $value]);

        // 根据更新结果设置返回提示信息
        $data ? $data = ['msg' => '状态设置成功', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];

        // 返回信息
        return json($data);
    }


    // 重置密码
    public function resetPassword($id)
    {
        // 生成密码
        $md5 = new APR1_MD5();
        $password = $md5->hash('123456');

        // 查询用户信息
        $data = AD::where('id', $id)->update(['password' => $password]);
        // 根据更新结果设置返回提示信息
        $data ? $data = ['msg' => '密码已经重置为:<br>123456', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];

        // 返回信息
        return json($data);
    }


    // // 查询管理员
    // public function adminList()
    // {
    //     $src = request()->only([
    //         'searchval'
    //     ],'POST');

    //     $ad = new AD;
    //     $list = $ad->search($src);
    //     $cnt = $list->count();
    //     $data = array();
    //     foreach ($list as $key => $value) {
    //         $data[] = [
    //             'xingming' => $value->adSchool->jiancheng . ' -- ' .$value->xingming
    //             ,'id' => $value->id
    //         ];
    //     }

    //     return json($data);
    // }


    // 批量添加
    public function createAll()
    {
        // 设置页面标题
        $list['set'] = array(
            'webtitle' => '批量上传管理员信息'
            ,'butname' => '批传'
            ,'formpost' => 'POST'
            ,'url' => 'saveall'
        );

        // 模板赋值
        $this->view->assign('list', $list);
        // 渲染
        return $this->view->fetch();
    }


    // 批量保存
    public function saveAll()
    {
        // 获取表单数据
        $list = request()->only([
            'school_id'
            ,'url'
        ], 'POST');

        // 实例化操作表格类
        $teacherinfo = \app\facade\File::readXls(public_path() . 'uploads/' . $list['url']);

        // 判断表格是否正确
        if("教师基本情况表" != $teacherinfo[0][0] || '姓名*' != $teacherinfo[2][1] || '帐号*' != $teacherinfo[2][2])
        {
            $this->error('请使用模板上传', '/login/err');
            return json($data);
        }

        $admin = new AD;
        $data = $admin->createAll($teacherinfo, $list['school_id']);
        $data ? $data = ['msg' => '数据上传成功', 'val' => 1]
            : ['msg' => '数据上传失败', 'val' => 0];

        return json($data);
    }


    // 下载表格模板
    public function downloadXls()
    {
        $fengefu = DIRECTORY_SEPARATOR;
        $url = public_path() . 'uploads' . $fengefu . 'admin' . $fengefu . 'AdminInfo.xlsx';
        return download($url, '管理员模板.xlsx');
    }


    // 根据教师姓名、首拼、全拼搜索教师信息
    public function srcAdmin()
    {
        // 获取参数
        $src = $this->request
            ->only([
                'searchval' => ''
                ,'school_id' => ''
                ,'field' => 'id'
                ,'order' => 'desc'
                ,'teacher_id' => ''
            ], 'POST');

        $ad = new AD();
        $list = $ad->strSrcTeachers($src)
            ->visible([
                'id'
                ,'xingming'
                ,'adSchool' => ['jiancheng']
            ]);
        $data = array();
        foreach ($list as $key => $value) {
            $data[] = [
                'xingming' => $value->adSchool->jiancheng . ' -- ' .$value->xingming
                ,'id' => $value->id
            ];
        }
        $data = reSetArray($data, $src);

        return json($data);
    }


    // 查询用户名是否重复
    public function srcUsername()
    {
        // 获取参数
        $srcfrom = $this->request
            ->only([
                'searchval' => ''
                ,'id' => ''
            ], 'POST');
        $src = [
                'searchval' => ''
                ,'id' => ''
            ];
        $src = array_cover($srcfrom, $src);

        $ad = new AD();
        $list = $ad->where('username', $src['searchval'])
            ->find();
        $data = ['msg' => '用户名已经存在！', 'val' => 0];

        if($list)
        {
            if($src['id'] > 0)
            {
                
                if($src['id'] == $list->id){
                    $data = ['msg' => '', 'val' => 1];
                }
            }
        }else{
           $data = ['msg' => '', 'val' => 1]; 
        }
        return json($data);
    }


    // 查询用户名是否重复
    public function srcPhone()
    {
        // 获取参数
        $srcfrom = $this->request
            ->only([
                'searchval' => ''
                ,'id'
            ], 'POST');
        $src = [
                'searchval' => ''
                ,'id' => ''
            ];
        $src = array_cover($srcfrom, $src);

        $ad = new AD();
        $list = $ad->where('phone', $src['searchval'])
            ->find();
        
        // 根据更新结果设置返回提示信息
        $data = ['msg' => '电话号码已经存在！', 'val' => 0];
        if($list)
        {
            if($src['id'] > 0)
            {
                
                if($src['id'] == $list->id){
                    $data = ['msg' => '', 'val' => 1];
                }
            }
        }else{
           $data = ['msg' => '', 'val' => 1]; 
        }
        return json($data);
    }
}
