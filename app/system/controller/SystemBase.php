<?php

namespace app\system\controller;

// 引用控制器基类
use app\base\controller\AdminBase;
// 引用与此控制器同名的数据模型
use app\system\model\SystemBase as  sysbasemod;


class SystemBase extends AdminBase
{
    // 系统设置
    public function edit()
    {
        // 获取用户信息
        $sys = new sysbasemod;
        $list['data'] = $sys
            ->field('id, keywords, description, thinks, danwei, gradelist, classmax, classalias, xuenian, teacherrongyu, teacherketi, studefen, sys_title')
            ->order(['id' => 'desc'])
            ->find();

        $list['set'] = array(
            'webtitle' => '设置系统信息'
            ,'butname' => '设置'
            ,'formpost' => 'PUT'
            ,'url' => 'update/' . $list['data']['id']
        );

        // 模板赋值
        $this->view->assign('list', $list);


        // 渲染模板
        return $this->view->fetch('edit');
    }


    // 更新资源
    public function update($id)
    {

        // 获取表单数据
        $list = request()->only([
            'keywords'
            ,'description'
            ,'thinks'
            ,'danwei'
            ,'gradelist'
            ,'classmax'
            ,'classalias'
            ,'xuenian'
            ,'teacherrongyu'
            ,'teacherketi'
            ,'studefen'
            ,'sys_title'
        ], 'put');
        $list['id'] = $id;
        $findy = strpos($list['xuenian'], '月');
        $yue = substr($list['xuenian'],0,$findy);
        $findy = $findy + 3;
        $findr = strpos($list['xuenian'], '日');
        $ri = substr($list['xuenian'], $findy, $findr - $findy);
        $list['xuenian'] = date('Y') . '-' . $yue . '-' . $ri;

        // 验证表单数据
        $validate = new \app\system\validate\SystemBase;
        $result = $validate->scene('edit')->check($list);
        $msg = $validate->getError();
        if(!$result){
            return json(['msg'=>$msg,'val'=>0]);;
        }

        $sys = new sysbasemod;
        $sysList = $sys->find($id);
        $sysList->keywords = $list['keywords'];
        $sysList->description = $list['description'];
        $sysList->thinks = $list['thinks'];
        $sysList->danwei = $list['danwei'];
        $sysList->gradelist = $list['gradelist'];
        $sysList->classmax = $list['classmax'];
        $sysList->classalias = $list['classalias'];
        $sysList->xuenian = $list['xuenian'];
        $sysList->teacherrongyu = $list['teacherrongyu'];
        $sysList->teacherketi = $list['teacherketi'];
        $sysList->studefen = $list['studefen'];
        $sysList->sys_title = $list['sys_title'];
        $data = $sysList->save();

        // 根据更新结果设置返回提示信息
        $data >= 0 ? $data = ['msg' => '设置成功','val'=>1]
            : $data = ['msg' => '数据处理错误','val' => 0];

        // 返回信息
        return json($data);
    }


    // 系统初始化
    public function resetMayi()
    {
        $data = ['msg' => '初始化成功', 'val' => 1];
        try {
            // 删除管理员
            $obj = new \app\admin\model\Admin;
            $list = $obj::destroy(function ($query) {
                $query->where('id', '>', 2);
            });

            // 删除用户组
            $obj = new \app\admin\model\AuthGroup;
            $list = $obj::destroy(function ($query) {
                $query->where('id', '>', 1);
            });

            // 删除用户与用户组对应
            $obj = new \app\admin\model\AuthGroupAccess;
            $list = $obj::destroy(function ($query) {
                $query->where('id', '>', 0);
            });

            // 删除班主任
            $obj = new \app\teach\model\BanZhuRen;
            $list = $obj::destroy(function ($query) {
                $query->where('id', '>', 0);
            });

            // 删除班级
            $obj = new \app\teach\model\Banji;
            $list = $obj::destroy(function ($query) {
                $query->where('id', '>', 0);
            });

            // 删除成绩
            $obj = new \app\chengji\model\Chengji;
            $list = $obj::destroy(function ($query) {
                $query->where('id', '>', 0);
            });

            // 删除单位荣誉
            $obj = new \app\rongyu\model\DwRongyu;
            $list = $obj::destroy(function ($query) {
                $query->where('id', '>', 0);
            });

            // 删除单位荣誉参与
            $obj = new \app\rongyu\model\DwRongyuCanyu;
            $list = $obj::destroy(function ($query) {
                $query->where('id', '>', 0);
            });

            // // 删除分工
            // $obj = new \app\rongyu\model\FenGong;
            // $list = $obj::destroy(function ($query) {
            //     $query->where('id', '>', 0);
            // });
            //
            // 删除文件
            $obj = new \app\system\model\Fields;
            $list = $obj::destroy(function ($query) {
                $query->where('id', '>', 0);
            });

            // 删除教师荣誉
            $obj = new \app\rongyu\model\JsRongyu;
            $list = $obj::destroy(function ($query) {
                $query->where('id', '>', 0);
            });

            // 删除教师荣誉参与
            $obj = new \app\rongyu\model\JsRongyuCanyu;
            $list = $obj::destroy(function ($query) {
                $query->where('id', '>', 0);
            });

            // 删除教师荣誉信息
            $obj = new \app\rongyu\model\JsRongyuInfo;
            $list = $obj::destroy(function ($query) {
                $query->where('id', '>', 0);
            });

            // 删除考号
            $obj = new \app\kaohao\model\Kaohao;
            $list = $obj::destroy(function ($query) {
                $query->where('id', '>', 0);
            });

            // 删除考试
            $obj = new \app\kaoshi\model\Kaoshi;
            $list = $obj::destroy(function ($query) {
                $query->where('id', '>', 0);
            });

            // 删除单位荣誉参与
            $obj = new \app\kaoshi\model\KaoshiSet;
            $list = $obj::destroy(function ($query) {
                $query->where('id', '>', 0);
            });

            // 删除课程表
            // $obj = new \app\rongyu\model\DwRongyuCanyu;
            // $list = $obj::destroy(function ($query) {
            //     $query->where('id', '>', 0);
            // });
            //
            // 删除课程表临时表
            // $obj = new \app\rongyu\model\DwRongyuCanyu;
            // $list = $obj::destroy(function ($query) {
            //     $query->where('id', '>', 0);
            // });
            //
            // 删除课节
            // $obj = new \app\rongyu\model\DwRongyuCanyu;
            // $list = $obj::destroy(function ($query) {
            //     $query->where('id', '>', 0);
            // });
            //
            // 删除课题删
            $obj = new \app\keti\model\Keti;
            $list = $obj::destroy(function ($query) {
                $query->where('id', '>', 0);
            });

            // 删除课题参与
            $obj = new \app\keti\model\KetiCanyu;
            $list = $obj::destroy(function ($query) {
                $query->where('id', '>', 0);
            });

            // 删除课题信息
            $obj = new \app\keti\model\ketiInfo;
            $list = $obj::destroy(function ($query) {
                $query->where('id', '>', 0);
            });

            // 删除单位
            $obj = new \app\system\model\School;
            $list = $obj::destroy(function ($query) {
                $query->where('id', '>', 0);
            });

            // 删除学生信息
            $obj = new \app\student\model\Student;
            $list = $obj::destroy(function ($query) {
                $query->where('id', '>', 0);
            });

            // 删除教师信息
            $obj = new \app\teacher\model\Teacher;
            $list = $obj::where('id', '>', 1)->delete();

            // 删除班级成绩统计
            $obj = new \app\chengji\model\TongjiBj;
            $list = $obj::destroy(function ($query) {
                $query->where('id', '>', 0);
            });

            // 删除统计记录
            $obj = new \app\kaoshi\model\TongjiLog;
            $list = $obj::destroy(function ($query) {
                $query->where('id', '>', 0);
            });

            // 删除年级成绩统计
            $obj = new \app\chengji\model\TongjiNj;
            $list = $obj::destroy(function ($query) {
                $query->where('id', '>', 0);
            });

            // 删除学校成绩统计
            $obj = new \app\chengji\model\TongjiSch;
            $list = $obj::destroy(function ($query) {
                $query->where('id', '>', 0);
            });

            // 删除学期
            $obj = new \app\teach\model\Xueqi;
            $list = $obj::destroy(function ($query) {
                $query->where('id', '>', 1);
            });

        } catch (ValidateException $e) {
            $data = ['msg' => '初始化失败', 'val' => 0];
        }

        // 返回信息
        return json($data);
    }

}
