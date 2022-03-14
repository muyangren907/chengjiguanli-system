<?php

namespace app\composer\controller;

// 引用控制器基类
use app\base\controller\AdminBase;
// 引用电脑数据模型类
use app\composer\model\Composer as Comp;
use app\composer\model\ComposerInfo as CompInfo;


class Index extends AdminBase
{
    // 显示电脑列表
    public function index()
    {
        // 设置要给模板赋值的信息
        $list['webtitle'] = '电脑列表';
        $list['dataurl'] = 'index/data';
        $list['status'] = '/composer/index/status';

        // 模板赋值
        $this->view->assign('list',$list);

        // 渲染模板
        return $this->view->fetch();
    }


    // 获取电脑信息列表
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
            ], 'POST');

        // 根据条件查询数据
        $comp = new Comp;
        $data = $comp->search($src)
            ->visible([
                'id'
                ,'xinghao'
                ,'xuliehao'
                ,'mac'
                ,'glInfo'
                ,'update_time'
            ]);
        $src['all'] = true;
        $cnt = $comp->search($src)->count();
        $data = reset_data($data, $cnt);
              
        return json($data);
    }



    // 创建电脑
    public function create()
    {
        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'添加电脑'
            ,'butname'=>'添加'
            ,'formpost'=>'POST'
            ,'url'=>'save'
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
            'teacher_id' => ""
            ,'url' => ""
            ,'xinghao' => ""
            ,'xuliehao' => ''
            ,'weizhi' => ""
            ,'mac' => ""
            ,'ip' => ""
            ,'biaoqian_time' => "2022-3-11+21:49:9"
            ,'shangchuan_id' => ""
            ,'info' => ""
            ,'infos' => ""
            ,'xitong' => ""
            ,'xitong_time' => ""
            ,'shangchuan_id' => session('user_id')
        ], 'post');

        // 验证表单数据
        $validate = new \app\composer\validate\Composer;
        $result = $validate->check($list);
        $msg = $validate->getError();
        if(!$result){
            return json(['msg' => $msg, 'val' => 0]);
        }

        // 保存数据
        try{
            $comp = new Comp;
            $info = new CompInfo;
            $comp->xinghao = $list['xinghao'];
            $comp->xuliehao = $list['xuliehao'];
            $comp->mac = $list['mac'];
            $info->teacher_id = $list['teacher_id'];
            $info->xitong = $list['xitong'];

            $list['xitong_time'] = str_replace('/', '-', $list['xitong_time']);
            $list['xitong_time'] = $list['xitong_time'] . ' ' . '00:00:00';
            $list['xitong_time'] = strtotime($list['xitong_time'], time());

            $info->xitong_time = $list['xitong_time'];
            $info->xitong = $list['xitong'];
            $info->weizhi = $list['weizhi'];
            $info->biaoqian_time = $list['biaoqian_time'];
            $info->ip = $list['ip'];
            $info->info = $list['info'];
            $info->infos = $list['infos'];
            $info->shangchuan_id = $list['shangchuan_id'];
            $comp->glInfo = $info;
            $composer = $comp->together(['glInfo'])->save();
            if($composer)
            {
                $data = ['msg' => '添加成功', 'val' => 1];
            } else {
                $data = ['msg' => '添加失败', 'val' => 0];
            }
        } catch (\Exception $e) {
            $data = ['msg' => $e->getMessage(), 'val' => 0];
        }

        // 返回信息
        return json($data);
    }


    // 修改电脑信息
    public function edit($id)
    {
        // 获取电脑信息
        $list['data'] = Comp::field('id, title, xuenian, category_id, bfdate, enddate')
            ->find($id);

       // 设置页面标题
        $list['set'] = array(
            'webtitle' => '编辑电脑'
            ,'butname' => '修改'
            ,'formpost' => 'PUT'
            ,'url' => '/composer/index/update/' . $id
        );

        // 模板赋值
        $this->view->assign('list',$list);
        // 渲染
        return $this->view->fetch('create');
    }


    // 更新电脑信息
    public function update($id)
    {
        // 获取表单数据
        $list = request()->only([
            'title'
            ,'xuenian'
            ,'category_id'
            ,'bfdate'
            ,'enddate'
        ], 'put');
        $list['id'] = $id;

        // 验证表单数据
        $validate = new \app\composer\validate\Comp;
        $result = $validate->scene('edit')->check($list);
        $msg = $validate->getError();
        if(!$result){
            return json(['msg' => $msg, 'val' => 0]);
        }

        // 更新数据
        $complist = Comp::find($id);
        $complist->title = $list['title'];
        $complist->xuenian = $list['xuenian'];
        $complist->category_id = $list['category_id'];
        $complist->bfdate = $list['bfdate'];
        $complist->enddate = $list['enddate'];
        $data = $complist->save();

        // 根据更新结果设置返回提示信息
        $data>=0 ? $data = ['msg' => '更新成功', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];

        // 返回信息
        return json($data);
    }


    // 删除电脑
    public function delete()
    {
        // 整理数据
        $id = request()->delete('id');
        $id = explode(',', $id);

        $data = Comp::destroy($id);

        // 根据更新结果设置返回提示信息
        $data ? $data =['msg' => '删除成功', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];

        // 返回信息
        return json($data);
    }


    // 设置电脑状态
    public function setStatus()
    {
        //  获取id变量
        $id = request()->post('id');
        $value = request()->post('value');

        // 获取电脑信息
        $data = Comp::where('id', $id)->update(['status' => $value]);

        // 根据更新结果设置返回提示信息
        $data ? $data = ['msg' => '状态设置成功', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];

        // 返回信息
        return json($data);
    }
}
