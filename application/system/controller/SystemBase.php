<?php

namespace app\system\controller;

// 引用控制器基类
use app\common\controller\Base;
// 引用与此控制器同名的数据模型
use app\system\model\SystemBase as  sysbasemod;


class SystemBase extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //实例化数据模型
        $sysbasemod = new sysbasemod();

        // 查询最新记录
        $list = $sysbasemod
            ->order(['id'=>'desc'])
            ->field('keywords,description')
            ->limit(1)
            ->find();

        // 模版赋值
        $this->assign('list',$list);
        
        // 渲染输出
        return $this->fetch();
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

    
}
