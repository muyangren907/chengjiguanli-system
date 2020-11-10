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
            ->field('id, keywords, description, thinks, danwei, gradelist, classmax, classalias, xuenian, teacherrongyu, teacherketi')
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
        $data = $sysList->save();

        // 根据更新结果设置返回提示信息
        $data >= 0 ? $data = ['msg' => '设置成功','val'=>1]
            : $data = ['msg' => '数据处理错误','val' => 0];

        // 返回信息
        return json($data);
    }

}
