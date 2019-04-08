<?php

namespace app\system\controller;

// 引用控制器基类
use app\common\controller\Base;
// 引用类别数据模型类
use app\system\model\Category as CG;

class Category extends Base
{
    
    

    // 类别列表
    public function index()
    {
        // 设置要给模板赋值的信息
        $list['webtitle'] = '类别列表';

        // 模板赋值
        $this->assign('list',$list);

        // 渲染模板
        return $this->fetch();
    }


    //  获取单位列表数据
    public function ajaxData()
    {
        // 获取参数
        $src = $this->request
                ->only([
                    'page'=>'1',
                    'limit'=>'10',
                    'field'=>'id',
                    'order'=>'asc',
                    'pid'=>'',
                    'searchval'=>''
                ],'POST');

        // 实例化
        $cg = new CG;

        // 查询要显示的数据
        $data = $cg->search($src);
        // 获取记录总数
        $cnt = $data->count();
        // 获取当前页数据
        $limit_start = $src['page'] * $src['limit'] - $src['limit'];
        $limit_length = $src['limit']-1;
        $data = $data->slice($limit_start,$limit_length);
       
        // 重组返回内容
        $data = [
            'code'=> 0 , // ajax请求次数，作为标识符
            'msg'=>"",  // 获取到的结果数(每页显示数量)
            'count'=>$cnt,       // 符合条件的总数据量
            'data'=>$data, //获取到的数据结果
        ];

        return json($data);
    }



    // 添加类别
    public function create()
    {
        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'添加类别',
            'butname'=>'添加',
            'formpost'=>'POST',
            'url'=>'/category',
        );


        // 模板赋值
        $this->assign('list',$list);

        // 渲染
        return $this->fetch();
    }

    

    // 保存信息
    public function save()
    {

        // 实例化验证模型
        $validate = new \app\system\validate\Category;


        // 获取表单数据
        $list = request()->only(['title','pid','paixu'],'post');


        // 验证表单数据
        $result = $validate->check($list);
        $msg = $validate->getError();


        // 如果验证不通过则停止保存
        if(!$result){
            return json(['msg'=>$msg,'val'=>0]);;
        }

        // 保存数据 
        $data = CG::create($list);


        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'添加成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }



    // 编辑类别
    public function edit($id)
    {
        // 获取类别信息
        $list = CG::field('id,title,pid,paixu')
            ->get($id);

        $this->assign('list',$list);

        return $this->fetch();
    }

    // 更新类别信息
    public function update($id)
    {
        $validate = new \app\system\validate\Category;

        // 获取表单数据
        $list = request()->only(['title','pid','paixu'],'put');

        // 验证表单数据
        $result = $validate->check($list);
        $msg = $validate->getError();

        // 如果验证不通过则停止保存
        if(!$result){
            return json(['msg'=>$msg,'val'=>0]);;
        }


        $data = CG::where('id',$id)->update($list);

        // 根据更新结果设置返回提示信息
        $data>=0 ? $data=['msg'=>'更新成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }

    
    // 删除类别
    public function delete($id)
    {
        if($id == 'm')
        {
            $id = request()->delete('ids/a');
        }

        $data = CG::destroy($id);

        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'删除成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }

    // 设置类别状态
    public function setStatus()
    {

        //  获取id变量
        $id = request()->post('id');
        $value = request()->post('value');

        // 获取类别信息
        $data = CG::where('id',$id)->update(['status'=>$value]);

        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'状态设置成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }
}
