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

        // 获取记录总数
        $count = $admin->count();

        // 设置要给模板赋值的信息
        $list['title'] = '管理员列表';
        $list['count'] = $count;

        // 模板赋值
        $this->assign('list',$list);

        // 渲染模板
        return $this->fetch();

    }


    // 获取数据管理员数据
    public function ajaxData()
    {
        //实例化管理员数据模型类
        $admin = new Admin();

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


        //查询数据
        $data = $admin
            ->field('id,xingming,xingbie,username,denglucishu,status,create_time')
            ->order([$order_field=>$order])
            ->limit($limit_start,$limit_length)
            ->all();
            $cnt = $data->count();
            $datacnt = $cnt;

        // 如果需要查询
        if($search){
            $data = $admin
                ->field('id,xingming,xingbie,username,denglucishu,status,create_time')
                ->order([$order_field=>$order])
                ->limit($limit_start,$limit_length)
                ->where('username|xingming','like','%'.$search.'%')
                ->all();
            $datacnt = $data->count();
        }
        
        


        $data = [
            'draw'=> $getdt["draw"] , // ajax请求次数，作为标识符
            'recordsTotal'=>$cnt,  // 获取到的结果数(每页显示数量)
            'recordsFiltered'=>$datacnt,       // 符合条件的总数据量
            'data'=>$data, //获取到的数据结果
        ];

        return json($data);
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