<?php

namespace app\admin\controller;

// 引用控制器基类
use app\common\controller\Base;
// 引用用户数据模型
use app\admin\model\Admin;

class Index extends Base
{
    // 管理员列表
    public function index()
    {
        //实例化管理员数据模型类
        $admin = new Admin();

        // 获取管理员信息
        $list = $admin
            ->where('id','>',1)
            ->all();
        
        // 模板赋值
        $this->assign('list',$list);

        // 渲染模板
        return $this->fetch();

    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
