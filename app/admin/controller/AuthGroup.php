<?php

namespace app\admin\controller;

// 引用控制器基类
use app\BaseController;
// 引用角色数据模型类
use app\admin\model\AuthGroup as AG;


class AuthGroup extends BaseController
{
    // 角色列表
    public function index()
    {
        // 设置要给模板赋值的信息
        $list['webtitle'] = '角色列表';

        // 模板赋值
        $this->assign('list',$list);

        // 渲染模板
        return $this->fetch();
    }


    // 获取角色列表
    public function ajaxData()
    {
        // 获取参数
        $src = $this->request
                ->only([
                    'page'=>'1',
                    'limit'=>'10',
                    'field'=>'id',
                    'type'=>'asc',
                    'searchval'=>''
                ],'POST');


        // 实例化
        $ag = new AG;

        // 查询要显示的数据
        $data = $ag->search($src);
        // 获取符合条件记录总数
        $cnt = $data->count();
        // 获取当前页数据
        $limit_start = $src['page'] * $src['limit'] - $src['limit'];
        $limit_length = $src['limit'];
        $data = $data->slice($limit_start,$limit_length);
       
        // 重组返回内容
        $data = [
            'code'=> 0 , // ajax请求次数，作为标识符
            'msg'=>"",  // 获取到的结果数(每页显示数量)
            'count'=>$cnt, // 符合条件的总数据量
            'data'=>$data, //获取到的数据结果
        ];

        return json($data);
    }


    // 创建角色
    public function create()
    {
        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'添加角色',
            'butname'=>'添加',
            'formpost'=>'POST',
            'url'=>'/authgroup',
        );


        // 模板赋值
        $this->assign('list',$list);

        // 渲染
        return $this->fetch();
    }
    

    // 保存角色信息
    public function save()
    {

        // 实例化验证模型
        $validate = new \app\admin\validate\RuleGroup;


        // 获取表单数据
        $list = request()->only(['title','rules','miaoshu'],'post');
        $list['rules'] = implode(",",$list['rules']);


        // 验证表单数据
        $result = $validate->check($list);
        $msg = $validate->getError();


        // 如果验证不通过则停止保存
        if(!$result){
            return json(['msg'=>$msg,'val'=>0]);;
        }

        // 保存数据 
        $data = AG::create($list);


        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'添加成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
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

    


    // 修改角色信息
    public function edit($id)
    {
        // 获取单位信息
        $list['data'] = AG::field('id,title,miaoshu,rules')
            ->find($id);

        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'编辑角色',
            'butname'=>'修改',
            'formpost'=>'PUT',
            'url'=>'/authgroup/'.$id,
        );

        // 模板赋值
        $this->assign('list',$list);
        // 渲染
        return $this->fetch('create');
    }





    // 更新角色信息
    public function update($id)
    {

        // 实例化验证模型
        $validate = new \app\admin\validate\RuleGroup;

        // 获取表单数据
        $list = request()->only(['title','rules','miaoshu'],'put');
        $list['rules'] = implode(",",$list['rules']);

        // 验证表单数据
        $result = $validate->check($list);
        $msg = $validate->getError();

        // 如果验证不通过则停止保存
        if(!$result){
            return json(['msg'=>$msg,'val'=>0]);;
        }


        $data = AG::where('id',$id)->update($list);

        // 根据更新结果设置返回提示信息
        $data>=0 ? $data=['msg'=>'更新成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }

    


    // 删除角色
    public function delete($id)
    {

        if($id == 'm')
        {
            $id = request()->delete('ids');// 获取delete请求方式传送过来的数据并转换成数据
        }

        $data = AG::destroy($id);

        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'删除成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }



    // 设置角色状态
    public function setStatus()
    {

        //  获取id变量
        $id = request()->post('id');
        $value = request()->post('value');

        // 更新数据
        $data= AG::where('id',$id)->update(['status'=>$value]);

        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'状态设置成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }

    
}