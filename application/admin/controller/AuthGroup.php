<?php

namespace app\admin\controller;

// 引用控制器基类
use app\common\controller\Base;
// 引用角色数据模型类
use app\admin\model\AuthGroup as agmod;

class AuthGroup extends Base
{
    // 角色列表
    public function index()
    {
        // 实例化角色数据模型类
        $agmod = new agmod();

        // 设置数据总数
        $list['count'] = $agmod->count();
        // 设置页面标题
        $list['title'] = '角色列表';


        // 模板赋值
        $this->assign('list', $list);

        // 渲染模板
        return $this->fetch();
    }



    // 获取角色列表
    public function ajaxData()
    {
        // 实例化角色数据模型类
        $agmod = new agmod();

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
        $cnt = $agmod->count();
        //查询数据
        $data = $agmod
            ->field('id,title,miaoshu,status')
            ->order([$order_field=>$order])
            ->limit($limit_start,$limit_length)
            ->all();
        

        // 如果需要查询
        if($search){
            $data = $agmod
                ->field('id,title,miaoshu,status')
                ->order([$order_field=>$order])
                ->limit($limit_start,$limit_length)
                ->where('title|miaoshu','like','%'.$search.'%')
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



    // 创建角色
    public function create()
    {
        // 设置页面标题
        $list['title'] = '添加权限';

        // 模板赋值
        $this->assign('list',$list);

        // 渲染
        return $this->fetch();
    }

    

    // 保存角色信息
    public function save()
    {
        // 实例化权限数据模型类
        $agmod = new agmod();

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
        $data = $agmod->save($list);

        $msg = array();

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
