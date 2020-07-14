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
        $list['data'] = sysbasemod::field('id, keywords, description, thinks, danwei')
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
        ], 'put');
        $list['id'] = $id;

        // 验证表单数据
        $validate = new \app\system\validate\SystemBase;
        $result = $validate->scene('edit')->check($list);
        $msg = $validate->getError();
        if(!$result){
            return json(['msg'=>$msg,'val'=>0]);;
        }

        $data = sysbasemod::where('id', $id)->update($list);

        // 根据更新结果设置返回提示信息
        $data >= 0 ? $data = ['msg' => '设置成功','val'=>1]
            : $data = ['msg' => '数据处理错误','val' => 0];

        // 返回信息
        return json($data);
    }

}
