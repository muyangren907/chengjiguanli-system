<?php

namespace app\teacher\controller;

// 引用控制器基类
use app\base\controller\AdminBase;
// 引用教师数据模型类
use app\teacher\model\Teacher as TC;
// 引用上传文件
use app\tools\controller\File;


class Index extends AdminBase
{
    // 显示教师列表
    public function index()
    {
        // 设置要给模板赋值的信息
        $list['webtitle'] = '教师列表';
        $list['dataurl'] = '/teacher/index/data';
        $list['status'] = '/teacher/index/status';

        // 模板赋值
        $this->view->assign('list', $list);

        // 渲染模板
        return $this->view->fetch();
    }


    /**
     * 显示教师信息列表
     *
     * @return \think\Response
     */
    public function ajaxData()
    {
        // 获取参数
        $src = $this->request
            ->only([
                'page' => '1'
                ,'limit' => '10'
                ,'field' => 'update_time'
                ,'order' => 'desc'
                ,'zhiwu_id' => array()
                ,'danwei_id' => array()
                ,'xueli_id' => array()
                ,'tuixiu' => 0
                ,'zhicheng_id' => ''
                ,'searchval' => ''
            ], 'POST');

        // 实例化
        $teacher = new TC;
        $data = $teacher->search($src)
            ->visible([
                'id'
                ,'xingming'
                ,'sex'
                ,'jsXueli' => ['title']
                ,'jsZhiwu' => ['title']
                ,'jsZhicheng' => ['title']
                ,'jsDanwei' => ['jiancheng']
                ,'biye'
                ,'zhuanye'
                ,'status'
                ,'phone'
                ,'update_time'
            ]);

        $data = reSetObject($data, $src);

        return json($data);
    }


    // 显示教师列表
    public function delList()
    {
        // 设置要给模板赋值的信息
        $list['webtitle'] = '教师列表';
        $list['dataurl'] = '/teacher/index/datadel';
        $list['status'] = '/teacher/index/status';

        // 模板赋值
        $this->view->assign('list', $list);

        // 渲染模板
        return $this->view->fetch();
    }


    /**
     * 显示教师信息列表
     *
     * @return \think\Response
     */
    public function ajaxDataDel()
    {
        // 获取参数
        $src = $this->request
            ->only([
                'page' => '1'
                ,'limit' => '10'
                ,'field' => 'update_time'
                ,'order' => 'desc'
                ,'zhiwu_id' => array()
                ,'danwei_id' => array()
                ,'xueli_id' => array()
                ,'searchval' => ''
            ], 'POST');

        // 实例化
        $teacher = new TC;
        $data = $teacher->searchDel($src)
            ->visible([
                'id'
                ,'xingming'
                ,'sex'
                ,'jsXueli' => ['title']
                ,'jsZhiwu' => ['title']
                ,'jsZhicheng' => ['title']
                ,'jsDanwei' => ['jiancheng']
                ,'biye'
                ,'zhuanye'
                ,'update_time'
            ]);
        $data = reSetObject($data, $src);

        return json($data);
    }


    // 创建教师
    public function create()
    {
        // 设置页面标题
        $list['set'] = array(
            'webtitle' => '添加教师'
            ,'butname' => '添加'
            ,'formpost' => 'POST'
            ,'url' => 'save'
        );

        // 模板赋值
        $this->view->assign('list', $list);
        // 渲染
        return $this->view->fetch('create');
    }


    // 保存信息
    public function save()
    {
        // 获取表单数据
        $list = request()->only([
            'xingming'
            ,'sex'
            ,'quanpin'
            ,'shoupin'
            ,'shengri'
            ,'phone'
            ,'zhiwu_id'
            ,'zhicheng_id'
            ,'xueli_id'
            ,'biye'
            ,'worktime'
            ,'zhuanye'
            ,'danwei_id'
            ,'tuixiu'
        ], 'POST');

        // 验证表单数据
        $validate = new \app\teacher\validate\Teacher;
        $result = $validate->scene('create')->check($list);
        $msg = $validate->getError();
        if(!$result){
            return json(['msg' => $msg, 'val' => 0]);
        }

        $tc = new TC();
        $temp = $tc->phoneSrc($list['phone']);
        if($temp)
        {
            return json(['msg' => '手机号已经存在', 'val' => 0]);
        }

        $list['quanpin'] = trim(strtolower(str_replace(' ', '', $list['quanpin'])));
        $list['shoupin'] = trim(strtolower($list['shoupin']));

        // 保存数据
        $data = TC::create($list);
        $data ? $data = ['msg' => '添加成功', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];

        // 返回信息
        return json($data);
    }


    // 查看教师信息
    public function read($id)
    {
        // 查询教师信息
        $myInfo = TC::withTrashed()
            ->where('id', $id)
            ->with(
                [
                    'jsDanwei' => function($query){
                        $query->field('id, title');
                    },
                    'jsZhiwu' => function($query){
                        $query->field('id, title');
                    },
                    'jsZhicheng' => function($query){
                        $query->field('id, title');
                    },
                    'jsXueli' => function($query){
                        $query->field('id, title');
                    },
                    'jsSubject' => function($query){
                        $query->field('id, title');
                    },
                ]
            )
            ->append(['age', 'gongling'])
            ->limit(1)
            ->find();

        // 设置页面标题
        $myInfo['webtitle'] = $myInfo->xingming . '信息';

        // 模板赋值
        $this->view->assign('list', $myInfo);
        // 渲染模板
        return $this->view->fetch();
    }


    // 修改教师信息
    public function edit($id)
    {
        // 获取教师信息
        $list['data'] = TC::field('id, xingming, sex, quanpin, shoupin, shengri, phone, zhiwu_id, zhicheng_id, xueli_id, biye, worktime, zhuanye, danwei_id, tuixiu')
            ->find($id);

        // 设置页面标题
        $list['set'] = array(
            'webtitle' => '编辑教师'
            ,'butname' => '修改'
            ,'formpost' => 'PUT'
            ,'url' => '/teacher/index/update/' . $id
        );

        // 模板赋值
        $this->view->assign('list', $list);
        // 渲染
        return $this->view->fetch('create');
    }


    // 更新教师信息
    public function update($id)
    {
        // 获取表单数据
        $list = request()->only([
            'xingming'
            ,'sex'
            ,'quanpin'
            ,'shoupin'
            ,'shengri'
            ,'phone'
            ,'zhiwu_id'
            ,'zhicheng_id'
            ,'xueli_id'
            ,'biye'
            ,'worktime'
            ,'zhuanye'
            ,'danwei_id'
            ,'tuixiu'
        ], 'PUT');
        $list['id'] = $id;

        // 验证表单数据
        $validate = new \app\teacher\validate\Teacher;
        $result = $validate->scene('edit')->check($list);
        $msg = $validate->getError();
        if(!$result){
            return json(['msg' => $msg, 'val' => 0]);;
        }
        $tc = new TC();
        $temp = TC::withTrashed()->where('phone', $list['phone'])->find();
        if($temp)
        {
            if($temp->id != $id*1)
            {
                return json(['msg' => '手机号已经存在', 'val' => 0]);
            }
        }

        $list['quanpin'] = trim(strtolower(str_replace(' ', '', $list['quanpin'])));
        $list['shoupin'] = trim(strtolower($list['shoupin']));

        // 更新数据
        $teacher = new TC();
        $teacherlist = $teacher->find($id);

        $teacherlist->xingming = $list['xingming'];
        $teacherlist->sex = $list['sex'];
        $teacherlist->quanpin = $list['quanpin'];
        $teacherlist->shoupin = $list['shoupin'];
        $teacherlist->shengri = $list['shengri'];
        $teacherlist->phone = $list['phone'];
        $teacherlist->zhiwu_id = $list['zhiwu_id'];
        $teacherlist->zhicheng_id = $list['zhicheng_id'];
        $teacherlist->xueli_id = $list['xueli_id'];
        $teacherlist->biye = $list['biye'];
        $teacherlist->worktime = $list['worktime'];
        $teacherlist->zhuanye = $list['zhuanye'];
        $teacherlist->danwei_id = $list['danwei_id'];
        $teacherlist->tuixiu = $list['tuixiu'];
        $data = $teacherlist->save();

        // 根据更新结果设置返回提示信息
        $data>=0 ? $data = ['msg' => '更新成功', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];

        // 返回信息
        return json($data);
    }


    // 删除教师
    public function delete($id)
    {
        // 整理数据
        $id = request()->delete('id');
        $id = explode(',', $id);

        $data = TC::destroy($id);

        // 根据更新结果设置返回提示信息
        $data ? $data = ['msg' => '删除成功', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];

        // 返回信息
        return json($data);
    }


    // 恢复删除
     public function reDel($id)
    {
        $user = TC::onlyTrashed()->find($id);
        $data = $user->restore();

        // 根据更新结果设置返回提示信息
        $data ? $data = ['msg' => '恢复成功', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];

        // 返回信息
        return json($data);
    }


    // 设置教师状态
    public function setStatus()
    {
        //  获取id变量
        $id = request()->post('id');
        $value = request()->post('value');

        // 获取教师信息
        $data = TC::where('id', $id)->update(['status' => $value]);

        // 根据更新结果设置返回提示信息
        $data ? $data = ['msg' => '状态设置成功', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];

        // 返回信息
        return json($data);
    }


    // 批量添加
    public function createAll()
    {
        // 设置页面标题
        $list['set'] = array(
            'webtitle' => '批量上传教师信息'
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
        if("教师基本情况表" != $teacherinfo[0][0] || '姓名*' != $teacherinfo[2][1] || '性别*' != $teacherinfo[2][2])
        {
            $this->error('请使用模板上传', '/login/err');
            return json($data);
        }

        $teacher = new TC;
        $data = $teacher->createAll($teacherinfo, $list['school_id']);
        $data ? $data = ['msg' => '数据上传成功', 'val' => 1]
            : ['msg' => '数据上传失败', 'val' => 0];

        return json($data);
    }


    // 根据教师姓名、首拼、全拼搜索教师信息
    public function srcTeacher()
    {
        // 获取参数
        $src = $this->request
            ->only([
                'str' => ''
                ,'danwei_id' => ''
                ,'field' => 'id'
                ,'order' => 'desc'
                ,'teacher_id' => ''
            ], 'POST');

        $teacher = new TC();
        $data = $teacher->strSrcTeachers($src);

        $data = reSetObject($data, $src);

        return json($data);
    }


    // 下载表格模板
    public function downloadXls()
    {
        $fengefu = DIRECTORY_SEPARATOR;
        $url = public_path() . 'uploads' . $fengefu . 'teacher' . $fengefu . 'TeacherInfo.xlsx';
        return download($url, '教师名单模板.xlsx');
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


    // 重置密码
    public function resetpassword($id)
    {
        // 生成密码
        $md5 = new \WhiteHat101\Crypt\APR1_MD5;
        $password = $md5->hash('123456');

        // 查询用户信息
        $data = TC::where('id', $id)->update(['password' => $password]);
        // 根据更新结果设置返回提示信息
        $data ? $data = ['msg' => '密码已经重置为:<br>123456', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];

        // 返回信息
        return json($data);
    }



}
