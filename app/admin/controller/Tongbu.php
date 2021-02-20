<?php
declare (strict_types = 1);

namespace app\admin\controller;

// 引用控制器基类
use app\BaseController;

use app\admin\model\Admin as ad;

class Tongbu extends BaseController
{
    // 统计成绩
    public function index()
    {
        // 设置页面标题
        $list['set'] = array(
            'webtitle' => '同步数据'
            ,'butname' => '一键同步'
            ,'formpost' => 'POST'
            ,'url' => '/tongbu/null'
            ,'kaoshi_id' => 0
        );

        $list['tjxm'] = [
            [
                'title' => '教师信息（必须最先统计）'
                ,'url' => '/admin/tongbu/teacher'
                ,'checked' => ' checked'
            ]
            ,[
                'title' => '班主任'
                ,'url' => '/admin/tongbu/bzr'
                ,'checked' => ' checked'
            ]
            ,[
                'title' => '成绩'
                ,'url' => '/admin/tongbu/chengji'
                ,'checked' => ' checked'
            ]
            ,[
                'title' => '单位荣誉'
                ,'url' => '/admin/tongbu/dwry'
                ,'checked' => ' checked'
            ]
            ,[
                'title' => '文件'
                ,'url' => '/admin/tongbu/file'
                ,'checked' => ' checked'
            ]
            ,[
                'title' => '教师荣誉'
                ,'url' => '/admin/tongbu/jsry'
                ,'checked' => ' checked'
            ]
            ,[
                'title' => '考试'
                ,'url' => '/admin/tongbu/kaoshi'
                ,'checked' => ' checked'
            ]
            ,[
                'title' => '课题'
                ,'url' => '/admin/tongbu/ktcy'
                ,'checked' => ''
            ]
            ,[
                'title' => '统计班级'
                ,'url' => '/admin/tongbu/tjbj'
                ,'checked' => ''
            ]
        ];

        // 模板赋值
        $this->view->assign('list', $list);
        // 渲染
        return $this->view->fetch('index/tongji');
    }

    // 将老师信息合并到admin中
    public function teacher()
    {
        $ad = new \app\admin\model\Admin;
        $tc = new \app\teacher\model\Teacher;
        $tclist = $tc::withTrashed()->select();
        foreach ($tclist as $key => $value) {
            $temp = $ad::withTrashed()
                ->where('teacher_id', $value->id)
                ->find();
            if($temp)
            {
                $temp->xingming = $value->xingming;
                $temp->sex = $value->getData("sex");
                $temp->shengri = $value->getData("shengri");
                $temp->password = $value->password;
                $temp->teacher_id = $value->id;
                $temp->school_id = $value->danwei_id;
                $temp->phone = $value->phone;
                $temp->worktime = $value->getData("worktime");
                $temp->zhiwu_id = $value->zhiwu_id;
                $temp->zhicheng_id = $value->zhicheng_id;
                $temp->biye = $value->biye;
                $temp->zhuanye = $value->zhuanye;
                $temp->xueli_id = $value->xueli_id;
                $temp->subject_id = $value->subject_id;
                $temp->quanpin = $value->quanpin;
                $temp->shoupin = $value->shoupin;
                $temp->tuixiu = $value->getData("tuixiu");
                $temp->denglucishu = $value->denglucishu + $temp->denglucishu;
                if($temp->this_time < $value->this_time)
                {
                    $temp->lastip = $value->lastip;
                    $temp->ip = $value->ip;
                    $temp->lasttime = $value->getData('lasttime');
                    $temp->thistime = $value->getData('thistime');
                }
                $temp->status = $value->status;
                if($temp->create_time > $value->create_time)
                {
                    $temp->create_time = $value->getData('create_time');
                }
                if($temp->delete_time < $value->delete_time)
                {
                    $temp->delete_time = $value->getData('delete_time');
                }
                $temp->beizhu = $value->beizhu;
                $data = $temp->save();
            } else {
                $data = $value->toArray();
                $data['teacher_id'] = $value->id;
                unset($data['id']);
                $data['sex'] = $value->getData('sex');
                $data['shengri'] = $value->getData('shengri');
                $data['username'] = $value->phone;
                $data['school_id'] = $value->danwei_id;
                unset($data['danwei_id']);
                $data['delete_time'] = $value->getData('delete_time');
                $data['worktime'] = $value->getData('worktime');
                $data['tuixiu'] = $value->getData('tuixiu');
                $data['create_time'] = $value->getData('create_time');
                $data['delete_time'] = $value->getData('delete_time');
                unset($data['update_time']);
                $data = $ad->create($data);
            }
        }

        // $data = [
        //     'mas' => '已经将教师信息同步到管理员表中：1、教师信息与管理员信息已经关联：使用教师信息替换管理员信息；2、教师与管理员信息未关联：在管理员表中创建教师信息。帐号为手机号，密码为原密码。'
        //     ,'val' => 1
        // ]

        // 根据更新结果设置返回提示信息
        $data ? $data = ['msg' => '教师信息同步成功', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];

       return json($data);
    }


    // 班主任
    public function bzr()
    {
        $bzr = new \app\teach\model\BanZhuRen;
        $bzrList = $bzr::withTrashed()->field('id, teacher_id')->select();
        $arr = array();
        foreach ($bzrList as $key => $value) {
            $arr[] = [
                'id' => $value->id
                ,'teacher_id' => ad::newId($value->teacher_id)
            ];
        }
        if(count($arr)>0)
        {
            $data = $bzr->saveAll($arr);
        }else{
            $data = true;
        }

        // 根据更新结果设置返回提示信息
        $data ? $data = ['msg' => '班主任同步完成', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];

        return json($data);
    }

    // 成绩录入人
    public function chengji()
    {
        $chengji = new \app\chengji\model\Chengji;
        $chengjiList = $chengji->where('user_group', '<>', 'admin')->field('id, user_id')->select();
        $arr = array();
        foreach ($chengjiList as $key => $value) {
            $arr[] = [
                'id' => $value->id
                ,'user_id' => ad::newId($value->user_id)
            ];
        }
        if(count($arr)>0)
        {
            $data = $chengji->saveAll($arr);
        }else{
            $data = true;
        }
        // 根据更新结果设置返回提示信息
        $data ? $data = ['msg' => '成绩同步完成', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];
        return json($data);
    }


    // 单位荣誉参与
    public function dwry()
    {
        $dwry = new \app\rongyu\model\DwRongyuCanyu;
        $dwryList = $dwry::withTrashed()->field('id, teacher_id')->select();
        $arr = array();
        foreach ($dwryList as $key => $value) {
            $arr[] = [
                'id' => $value->id
                ,'teacher_id' => ad::newId($value->teacher_id)
            ];
        }
        if(count($arr)>0)
        {
            $data = $dwry->saveAll($arr);
        }else{
            $data = true;
        }
        // 根据更新结果设置返回提示信息
        $data ? $data = ['msg' => '单位荣誉同步完成', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];
        return json($data);
    }


    // 文件
    public function file()
    {
        $file = new \app\system\model\Fields;
        $fileList = $file::withTrashed()->where('user_group', '<>', 'admin')->field('id, user_id')->select();
        $arr = array();
        foreach ($fileList as $key => $value) {
            $arr[] = [
                'id' => $value->id
                ,'user_id' => ad::newId($value->user_id)
            ];
        }
        if(count($arr)>0)
        {
            $data = $file->saveAll($arr);
        }else{
            $data = true;
        }
        // 根据更新结果设置返回提示信息
        $data ? $data = ['msg' => '文件同步完成', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];
        return json($data);
    }


    // 教师荣誉参与
    public function jsry()
    {
        $jsry = new \app\rongyu\model\JsRongyuCanyu;
        $jsryList = $jsry::withTrashed()->field('id, teacher_id')->select();
        $arr = array();
        foreach ($jsryList as $key => $value) {
            $arr[] = [
                'id' => $value->id
                ,'teacher_id' => ad::newId($value->teacher_id)
            ];
        }
        if(count($arr)>0)
        {
            $data = $jsry->saveAll($arr);
        }else{
            $data = true;
        }
        // 根据更新结果设置返回提示信息
        $data ? $data = ['msg' => '教师同步完成', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];
        return json($data);
    }


    // 考试
    public function kaoshi()
    {
        $kaoshi = new \app\kaoshi\model\Kaoshi;
        $kaoshiList = $kaoshi::withTrashed()->select();
        $data = false;
        // if(isset($kaoshiList[0]['user_id']))
        // {
            $arr = array();
            foreach ($kaoshiList as $key => $value) {
                if($value->user_id > 0){
                   $arr[] = [
                        'id' => $value->id
                        ,'user_id' => ad::newId($value->user_id)
                    ];
                }
            }
            if(count($arr)>0)
            {
                $data = $kaoshi->saveAll($arr);
            }else{
                $data = true;
            }

        // 根据更新结果设置返回提示信息
        $data ? $data = ['msg' => '考试同步完成', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];
        return json($data);
    }


    // 课题参与
    public function ktcy()
    {
        $ktcy = new \app\keti\model\KetiCanyu;
        $ktcyList = $ktcy::withTrashed()->field('id, teacher_id')->select();
        $arr = array();
        foreach ($ktcyList as $key => $value) {
             $arr[] = [
                'id' => $value->id
                ,'teacher_id' => ad::newId($value->teacher_id)
            ];
        }
        if(count($arr)>0)
        {
            $data = $ktcy->saveAll($arr);
        }else{
            $data = true;
        }
        // 根据更新结果设置返回提示信息
        $data ? $data = ['msg' => '课题同步完成', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];
        return json($data);
    }


    // 统计班级
    public function tjbj()
    {
        $tjbj = new \app\chengji\model\TongjiBj;
        $tjbjList = $tjbj::withTrashed()->field('id, teacher_id')->select();
        $arr = array();
        foreach ($tjbjList as $key => $value) {
            $arr[] = [
                'id' => $value->id
                ,'teacher_id' => ad::newId($value->teacher_id)
            ];
        }
        if(count($arr)>0)
        {
            $data = $tjbj->saveAll($arr);
        }else{
            $data = true;
        }
        // 根据更新结果设置返回提示信息
        $data ? $data = ['msg' => '统计班级同步完成', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];
        return json($data);
    }
}
