<?php

namespace app\admin\controller;

// 引用控制器基类
use app\common\controller\Base;
// 引用权限数据模型类
use app\admin\model\AuthRule as AR;

class AuthRule extends Base
{
    // 显示权限列表
    public function index()
    {
        // 设置要给模板赋值的信息
        $list['webtitle'] = '权限列表';

        // 模板赋值
        $this->assign('list',$list);

        // 渲染模板
        return $this->fetch();
    }


    // 获取权限信息列表
    public function ajaxData()
    {
        // 获取参数
        $src = $this->request
                ->only([
                    'page'=>'1'
                    ,'limit'=>'10'
                    ,'field'=>'id'
                    ,'order'=>'asc'
                    ,'searchval'=>''
                ],'POST');

        // 实例化
        $ar = new AR;

        // 查询要显示的数据
        $data = $ar->search($src);
        // 获取符合条件记录总数
        $cnt = $data->count();
        // 获取当前页数据
        $limit_start = $src['page'] * $src['limit'] - $src['limit'];
        $limit_length = $src['limit']-1;
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



    // 创建权限
    public function create()
    {
        // 设置页面标题
        $list['title'] = '添加权限';

        // 模板赋值
        $this->assign('list',$list);

        // 渲染
        return $this->fetch();
    }

    

    // 保存信息
    public function save()
    {
        // 实例化验证模型
        $validate = new \app\admin\validate\Rule;


        // 获取表单数据
        $list = request()->only(['title','name','pid','condition','paixu','ismenu','font','beizhu','url'],'post');


        // 验证表单数据
        $result = $validate->check($list);
        $msg = $validate->getError();


        // 如果验证不通过则停止保存
        if(!$result){
            return json(['msg'=>$msg,'val'=>0]);;
        }

        // 保存数据 
        $data = AR::create($list);

        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'添加成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }

    //
    public function read($id)
    {
        //
    }




    // 修改权限信息
    public function edit($id)
    {

        // 获取权限信息
        $list = AR::field('id,title,name,condition,pid,paixu,ismenu,font,url')
            ->get($id);


        $this->assign('list',$list);

        return $this->fetch();
    }





    // 更新权限信息
    public function update($id)
    {
        $validate = new \app\admin\validate\Rule;

        // 获取表单数据
        $list = request()->only(['title','name','pid','condition','paixu','ismenu','font','beizhu','url'],'put');

        // 验证表单数据
        $result = $validate->check($list);
        $msg = $validate->getError();

        // 如果验证不通过则停止保存
        if(!$result){
            return json(['msg'=>$msg,'val'=>0]);;
        }


        $data = AR::where('id',$id)->update($list);

        // 根据更新结果设置返回提示信息
        $data>=0 ? $data=['msg'=>'更新成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }

    



    // 删除权限
    public function delete($id)
    {

        if($id == 'm')
        {
            $id = request()->delete('ids/a');// 获取delete请求方式传送过来的数据并转换成数据
        }

        $data = AR::destroy($id);

        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'删除成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }



    // 设置权限状态
    public function setStatus()
    {

        //  获取id变量
        $id = request()->post('id');
        $value = request()->post('value');

        // 获取权限信息
        $data = AR::where('id',$id)->update(['status'=>$value]);

        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'状态设置成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }

    
}
