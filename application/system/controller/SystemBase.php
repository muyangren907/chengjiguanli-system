<?php

namespace app\system\controller;

// 引用控制器基类
use app\common\controller\Base;
// 引用与此控制器同名的数据模型
use app\system\model\SystemBase as  sysbasemod;


class SystemBase extends Base
{
    // 系统设置
    public function index()
    {

        // 获取用户信息
        $list = sysbasemod::field('id,webtitle,keywords,description,thinks,danwei')
            ->order(['id'=>'desc'])
            ->find();

        // 设置要给模板赋值的信息
        $list['title'] = '系统设置';

        $this->assign('list',$list);

        return $this->fetch();

        // 模板赋值
        $this->assign('list',$list);

        // 渲染模板
        return $this->fetch();
    }


    // 更新资源
    public function update($id)
    {
        $validate = new \app\system\validate\SystemBase;

        // 获取表单数据
        $list = request()->only(['title','keywords','description','thinks','danwei'],'put');;

        // 验证表单数据
        $result = $validate->check($list);
        $msg = $validate->getError();

        // 如果验证不通过则停止保存
        if(!$result){
            return json(['msg'=>$msg,'val'=>0]);;
        }


        $data = sysbasemod::where('id',$id)->update($list);

        // 根据更新结果设置返回提示信息
        $data>=0 ? $data=['msg'=>'更新成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }

    
}
