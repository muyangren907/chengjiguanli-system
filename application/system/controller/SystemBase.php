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

        // 设置要给模板赋值的信息
        $list['title'] = '系统设置';

        // 模板赋值
        $this->assign('list',$list);

        // 渲染模板
        return $this->fetch();
    }



    // 系统设置列表
    public function ajaxData()
    {
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
        $cnt = 1;
        //查询数据
        $data = sysbasemod::field('id,title,keywords,description,thinks,danwei')
            ->order([$order_field=>$order])
            // ->limit(1,1)
            ->select();

        $datacnt = 1;

        $data = [
            'draw'=> $getdt["draw"] , // ajax请求次数，作为标识符
            'recordsTotal'=>$datacnt,  // 获取到的结果数(每页显示数量)
            'recordsFiltered'=>$cnt,       // 符合条件的总数据量
            'data'=>$data, //获取到的数据结果
        ];

        return json($data);
    }



    // 编辑系统设置
    public function edit($id)
    {
        // 获取用户信息
        $list = sysbasemod::field('id,title,keywords,description,thinks,danwei')
            ->get($id);


        $this->assign('list',$list);

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
