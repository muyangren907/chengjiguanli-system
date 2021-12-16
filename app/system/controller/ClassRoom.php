<?php

namespace app\system\controller;

// 引用控制器基类
use app\base\controller\AdminBase;
// 引用单位数据模型类
use app\system\model\ClassRoom as CR;

class ClassRoom extends AdminBase
{
    // 显示教室列表
    public function index()
    {
        // 设置要给模板赋值的信息
        $list['webtitle'] = '教室列表';
        $list['dataurl'] = 'classroom/data';
        $list['status'] = '/system/classroom/status';

        // 模板赋值
        $this->view->assign('list',$list);

        // 渲染模板
        return $this->view->fetch();
    }


    // 获取教室信息列表
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
                ,'bfdate'
                ,'enddate'
            ], 'POST');

        // 根据条件查询数据
        $classroom = new CR;
        $data = $classroom->search($src);
        $src['all'] = true;
        $cnt = $classroom->search($src)->count();
        $data = reset_data($data, $cnt);

        return json($data);
    }



    // 创建教室
    public function create()
    {
        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'添加教室'
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
            'title'
            ,'xuenian'
            ,'category_id'
            ,'bfdate'
            ,'enddate'
        ], 'post');

        // 验证表单数据
        $validate = new \app\teach\validate\Xueqi;
        $result = $validate->scene('create')->check($list);
        $msg = $validate->getError();
        if(!$result){
            return json(['msg' => $msg, 'val' => 0]);
        }

        // 保存数据
        $data = XQ::create($list);
        $data ? $data = ['msg' => '添加成功', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];
        // 返回信息

        return json($data);
    }


    // 修改教室信息
    public function edit($id)
    {
        // 获取教室信息
        $list['data'] = XQ::field('id, title, xuenian, category_id, bfdate, enddate')
            ->find($id);

       // 设置页面标题
        $list['set'] = array(
            'webtitle' => '编辑教室'
            ,'butname' => '修改'
            ,'formpost' => 'PUT'
            ,'url' => '/teach/xueqi/update/' . $id
        );

        // 模板赋值
        $this->view->assign('list',$list);
        // 渲染
        return $this->view->fetch('create');
    }


    // 更新教室信息
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
        $validate = new \app\teach\validate\Xueqi;
        $result = $validate->scene('edit')->check($list);
        $msg = $validate->getError();
        if(!$result){
            return json(['msg' => $msg, 'val' => 0]);
        }

        // 更新数据
        $xueqilist = XQ::find($id);
        $xueqilist->title = $list['title'];
        $xueqilist->xuenian = $list['xuenian'];
        $xueqilist->category_id = $list['category_id'];
        $xueqilist->bfdate = $list['bfdate'];
        $xueqilist->enddate = $list['enddate'];
        $data = $xueqilist->save();

        // 根据更新结果设置返回提示信息
        $data>=0 ? $data = ['msg' => '更新成功', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];

        // 返回信息
        return json($data);
    }


    // 删除教室
    public function delete()
    {
        // 整理数据
        $id = request()->delete('id');
        $id = explode(',', $id);

        $data = XQ::destroy($id);

        // 根据更新结果设置返回提示信息
        $data ? $data =['msg' => '删除成功', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];

        // 返回信息
        return json($data);
    }


    // 设置教室状态
    public function setStatus()
    {
        //  获取id变量
        $id = request()->post('id');
        $value = request()->post('value');

        // 获取教室信息
        $data = XQ::where('id', $id)->update(['status' => $value]);

        // 根据更新结果设置返回提示信息
        $data ? $data = ['msg' => '状态设置成功', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];

        // 返回信息
        return json($data);
    }


    // 获取最近6个教室
    // 查询单位列表
    public function srcXueqi()
    {
        // 实例化单位模型
        $xq = new XQ;
        $data = $xq->lastXueqi();
        $data = reset_data($data, 6);

        return json($data);
    }
}
