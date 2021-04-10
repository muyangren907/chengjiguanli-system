<?php

namespace app\keti\controller;

// 引用控制器基类
use app\base\controller\AdminBase;

// 引用课题数据模型
use app\keti\model\Lixiang as lx;

class Lixiang extends AdminBase
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        // 设置要给模板赋值的信息
        $list['webtitle'] = '课题册列表';
        $list['dataurl'] = '/keti/lixiang/data';
        $list['status'] = '/keti/lixiang/data';

        // 模板赋值
        $this->view->assign('list', $list);

        // 渲染模板
        return $this->view->fetch();
    }


    /**
     * 显示课题册列表
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
                ,'field' => 'lxshijian'
                ,'order' => 'desc'
                ,'lxdanwei_id' => array()
                ,'category_id' => array()
                ,'searchval' => ''
            ], 'POST');

        // 根据条件查询数据
        $keti = new lx;
        $data = $keti->search($src);
        $data = reSetObject($data, $src);

        return json($data);
    }


    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function list($lixiang_id)
    {

        $kt = new lx;
        // 设置要给模板赋值的信息
        $list['webtitle'] = $kt->where('id', $lixiang_id)->value('title') . ' 列表';
        $list['lixiang_id'] = $lixiang_id;
        $list['dataurl'] = '/keti/info/data';
        $list['status'] = '/keti/info/status';

        // 模板赋值
        $this->view->assign('list', $list);

        // 渲染模板
        return $this->view->fetch();
    }


    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        // 设置页面标题
        $list['set'] = array(
            'webtitle' => '添加课题册'
            ,'butname' => '添加'
            ,'formpost' => 'POST'
            ,'url' => 'save'
        );

        // 模板赋值
        $this->view->assign('list', $list);
        // 渲染
        return $this->view->fetch('create');
    }


    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save()
    {
        // 获取表单数据
        $list = request()->only([
            'title'
            ,'category_id'
            ,'lxshijian'
            ,'lxdanwei_id'
        ], 'post');

        // 实例化验证模型
        $validate = new \app\keti\validate\Keti;
        $result = $validate->scene('create')->check($list);
        $msg = $validate->getError();
        if(!$result){
            return json(['msg' => $msg, 'val' => 0]);;
        }

        // 保存数据
        $data = lx::create($list);
        $data ? $data = ['msg' => '添加成功', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];

        // 返回信息
        return json($data);
    }


    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        // 获取荣誉册信息
        $list['data'] = lx::where('id', $id)
                ->field('id, title, category_id, lxshijian, lxdanwei_id')
                ->find();

        // 设置页面标题
        $list['set'] = array(
            'webtitle' => '编辑课题册'
            ,'butname' => '修改'
            ,'formpost' => 'PUT'
            ,'url' => '/keti/lixiang/update/' . $id
        );

        // 模板赋值
        $this->view->assign('list', $list);
        // 渲染
        return $this->view->fetch('create');
    }


    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update($id)
    {
        // 获取表单数据
        $list = request()->only([
            'title'
            ,'category_id'
            ,'lxshijian'
            ,'lxdanwei_id'
        ], 'put');
        $list['id'] = $id;

        // 实例化验证类
        $validate = new \app\keti\validate\Keti;
        $result = $validate->scene('edit')->check($list);
        $msg = $validate->getError();
        if(!$result){
            return json(['msg' => $msg, 'val' => 0]);;
        }

        // 更新数据
        $data = lx::update($list);
        $data ? $data = ['msg' => '更新成功', 'val' => 1]
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

        $data = lx::destroy($id);
        $data ? $data = ['msg' => '删除成功', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];

        // 返回信息
        return json($data);
    }


        // 设置荣誉状态
    public function setStatus()
    {
        //  获取id变量
        $id = request()->post('id');
        $value = request()->post('value');

        // 获取学生信息
        $data = lx::where('id', $id)->update(['status' => $value]);

        // 根据更新结果设置返回提示信息
        $data ? $data = ['msg' => '状态设置成功', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];

        // 返回信息
        return json($data);
    }
}
