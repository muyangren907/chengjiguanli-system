<?php

namespace app\rongyu\controller;

// 引用控制器基类
use app\common\controller\Base;
// 引用教师数据模型类
use app\rongyu\model\DwRongyu as dwry;

class DwRongyu extends Base
{
    /**
     * 显示单位荣誉列表
     *
     * @return \think\Response
     */
    public function index()
    {
        // 设置数据总数
        $list['count'] = dwry::count();
        // 设置页面标题
        $list['title'] = '单位荣誉';

        // 模板赋值
        $this->assign('list', $list);

        // 渲染模板
        return $this->fetch();
    }

    /**
     * 显示单位荣誉列表
     *
     * @return \think\Response
     */
    public function ajaxData()
    {
        // 获取DT的传值
        $getdt = request()->param();

        //得到排序的方式
        $order = $getdt['order'][0]['dir'];
        //得到排序字段的下标
        $order_column = $getdt['order'][0]['column'];
        //根据排序字段的下标得到排序字段
        $order_field = $getdt['columns'][$order_column]['name'];
        if($order_field=='')
        {
            $order_field = $getdt['columns'][$order_column]['data'];
        }
        //得到limit参数
        $limit_start = $getdt['start'];
        $limit_length = $getdt['length'];

        //得到搜索的关键词
        $search = [
            'hjschool'=>$getdt['hjschool'],
            'fzschool'=>$getdt['fzschool'],
            'category'=>$getdt['category'],
            'search'=>$getdt['search']['value'],
            'order'=>$order,
            'order_field'=>$order_field
        ];

        // 实例化
        $dwry = new dwry();

        // 获取荣誉总数
        $datacnt = $dwry->select()->count();

        // 查询数据
        $data = $dwry->search($search);

        $cnt = $data->count();

        // 重组返回内容
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
