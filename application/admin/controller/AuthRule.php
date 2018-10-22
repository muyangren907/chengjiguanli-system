<?php

namespace app\admin\controller;

// 引用控制器基类
use app\common\controller\Base;
// 引用权限数据模型类
use app\admin\model\AuthRule as authrulemod;

class AuthRule extends Base
{
    // 显示权限列表
    public function index()
    {
        // 实例化权限数据模型类
        $authrulemod = new authrulemod();

        // 设置数据总数
        $list['count'] = $authrulemod->count();
        // 设置页面标题
        $list['title'] = '权限列表';


        // 模板赋值
        $this->assign('list', $list);

        // 渲染模板
        return $this->fetch();
    }


    // 获取权限信息列表
    public function ajaxData()
    {
        // 实例化权限数据模型类
        $authrulemod = new authrulemod();

        // 获取DT的传值
        $getdt = request()->param();

        //得到排序的方式
        $order = $getdt['order'][0]['dir'];
        //得到排序字段的下标
        $order_column = $getdt['order'][0]['column'];
        //根据排序字段的下标得到排序字段
        $order_field = $getdt['columns'][$order_column]['data'];
        //得到limit参数
        $limit_start = $getdt['start'];
        $limit_length = $getdt['length'];
        //得到搜索的关键词
        $search = $getdt['search']['value'];


        // 获取记录集总数
        $cnt = $authrulemod->count();
        //查询数据
        $data = $authrulemod
            ->field('id,title,name,condition,paixu,ismenu,font,status,pid')
            ->order([$order_field=>$order])
            ->limit($limit_start,$limit_length)
            ->all();
        

        // 如果需要查询
        if($search){
            $data = $authrulemod
                ->field('id,title,name,condition,paixu,ismenu,font,status,pid')
                ->order([$order_field=>$order])
                ->limit($limit_start,$limit_length)
                ->where('title|name|pid','like','%'.$search.'%')
                ->all();
        }

        $datacnt = $data->count();
        
        


        $data = [
            'draw'=> $getdt["draw"] , // ajax请求次数，作为标识符
            'recordsTotal'=>$datacnt,  // 获取到的结果数(每页显示数量)
            'recordsFiltered'=>$cnt,       // 符合条件的总数据量
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
        // 实例化权限数据模型类
        $authrulemod = new authrulemod();

        // 实例化验证模型
        $validate = new \app\admin\validate\Rule;


        // 获取表单数据
        $list = request()->only(['title','name','pid','condition','paixue','ismenu','font','beizhu'],'post');


        // 验证表单数据
        $result = $validate->check($list);
        $msg = $validate->getError();


        // 如果验证不通过则停止保存
        if(!$result){
            return json(['msg'=>$msg,'val'=>0]);;
        }

        // 保存数据 
        $data = $authrulemod->save($list);

        $msg = array();

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
        //实例化权限数据模型
        $authrulemod = new authrulemod();

        // 获取权限信息
        $list = $authrulemod
            ->field('id,title,name,condition,pid,paixu,ismenu,font')
            ->get($id);


        $this->assign('list',$list);

        return $this->fetch();
    }





    // 更新权限信息
    public function update($id)
    {
        // 实例化权限数据模型类
        $authrulemod = new authrulemod();
        // 实例化验证模型
        $validate = new \app\admin\validate\Rule;

        // 获取表单数据
        $list = request()->put();

        // 验证表单数据
        $result = $validate->check($list);
        $msg = $validate->getError();

        // 如果验证不通过则停止保存
        if(!$result){
            return json(['msg'=>$msg,'val'=>0]);;
        }


        $data = $authrulemod->save($list,['id'=>$id]);

        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'更新成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //实例化权限数据模型类
        $authrulemod = new authrulemod();

        if($id == 'm')
        {
            $id = request()->delete('ids/a');// 获取delete请求方式传送过来的数据并转换成数据
        }

        $data = $authrulemod->destroy($id);

        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'删除成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }



    // 设置权限状态
    public function setStatus()
    {
        // 实例化权限数据模型类
        $authrulemod = new authrulemod();

        //  获取id变量
        $id = request()->post('id');
        $value = request()->post('value');

        // 获取权限信息
        $list = $authrulemod->get($id);

        // 修改状态值
        $list->status = $value;

        // 更新数据
        $data = $list->save();

        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'状态设置成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }
}
