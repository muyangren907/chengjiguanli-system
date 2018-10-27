<?php

namespace app\system\controller;

// 引用控制器基类
use app\common\controller\Base;
// 引用单位数据模型类
use app\system\model\School as sch;

class School extends Base
{
    // 单位列表
    public function index()
    {
        $count = sch::count();

        // 设置要给模板赋值的信息
        $list['title'] = '单位列表';
        $list['count'] = $count;

        // 模板赋值
        $this->assign('list',$list);

        // 渲染模板
        return $this->fetch();
    }


    //  获取单位列表数据
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
        $cnt = sch::count();
        //查询数据
        $data =sch::field('id,title,jiancheng,biaoshi,xingzhi,jibie,status,xueduan,paixu')
            ->order([$order_field=>$order])
            ->limit($limit_start,$limit_length)
            ->all();
        

        // 如果需要查询
        if($search){
            $data =sch::field('id,title,jiancheng,biaoshi,xingzhi,jibie,status,xueduan,paixu')
                ->whereOr('title','like','%'.$search.'%')
                ->whereOr('pid','in',function($query) use ($search){
                    $query->name('category')->where('title','like','%'.$search.'%')->field('id');
                })
                ->order([$order_field=>$order])
                ->limit($limit_start,$limit_length)
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



    // 添加单位
    public function create()
    {
        // 设置页面标题
        $list['title'] = '添加单位';

        // 模板赋值
        $this->assign('list',$list);

        // 渲染
        return $this->fetch();
    }

    

    // 保存信息
    public function save()
    {

        // 实例化验证模型
        $validate = new \app\system\validate\School;


        // 获取表单数据
        $list = request()
                ->only(['title','jiancheng','biaoshi','xingzhi','jibie','xueduan','paixu'],'post');


        // 验证表单数据
        $result = $validate->check($list);
        $msg = $validate->getError();


        // 如果验证不通过则停止保存
        if(!$result){
            return json(['msg'=>$msg,'val'=>0]);;
        }

        // 保存数据 
        $data = sch::create($list);


        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'添加成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }



    // 编辑单位
    public function edit($id)
    {
        // 获取单位信息
        $list = sch::field('id,title,jiancheng,biaoshi,xingzhi,jibie,status,xueduan,paixu')
            ->get($id);

        $this->assign('list',$list);

        return $this->fetch();
    }

    // 更新单位信息
    public function update($id)
    {
        $validate = new \app\system\validate\School;

        // 获取表单数据
        $list = request()
                ->only(['title','jiancheng','biaoshi','xingzhi','jibie','xueduan','paixu'],'put');


        // 验证表单数据
        $result = $validate->check($list);
        $msg = $validate->getError();

        // 如果验证不通过则停止保存
        if(!$result){
            return json(['msg'=>$msg,'val'=>0]);;
        }


        $data = sch::where('id',$id)->update($list);

        // 根据更新结果设置返回提示信息
        $data>=0 ? $data=['msg'=>'更新成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }

    
    // 删除单位
    public function delete($id)
    {
        if($id == 'm')
        {
            $id = request()->delete('ids/a');
        }

        $data = sch::destroy($id);

        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'删除成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }

    // 设置单位状态
    public function setStatus()
    {

        //  获取id变量
        $id = request()->post('id');
        $value = request()->post('value');

        // 获取单位信息
        $data = sch::where('id',$id)->update(['status'=>$value]);

        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'状态设置成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }
}
