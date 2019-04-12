<?php

namespace app\teach\controller;

// 引用控制器基类
use app\common\controller\Base;
// 引用学期数据模型类
use app\teach\model\Xueqi as XQ;

class Xueqi extends Base
{
    // 显示学期列表
    public function index()
    {
        // 设置要给模板赋值的信息
        $list['webtitle'] = '学期列表';

        // 模板赋值
        $this->assign('list',$list);

        // 渲染模板
        return $this->fetch();
    }


    // 获取学期信息列表
    public function ajaxData()
    {

        // 获取参数
        $src = $this->request
                ->only([
                    'page'=>'1',
                    'limit'=>'10',
                    'field'=>'id',
                    'order'=>'desc',
                    'searchval'=>''
                ],'POST');


        // 实例化
        $xq = new XQ;

        // 查询要显示的数据
        $data = $xq->search($src);
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



    // 创建学期
    public function create()
    {
        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'添加学期',
            'butname'=>'添加',
            'formpost'=>'POST',
            'url'=>'/xueqi',
        );

        // 模板赋值
        $this->assign('list',$list);
        // 渲染
        return $this->fetch('create');
    }

    

    // 保存信息
    public function save()
    {
        // 实例化验证模型
        $validate = new \app\teach\validate\Xueqi;


        // 获取表单数据
        $list = request()->only(['title','xuenian','category','bfdate','enddate'],'post');


        // 验证表单数据
        $result = $validate->check($list);
        $msg = $validate->getError();


        // 如果验证不通过则停止保存
        if(!$result){
            return json(['msg'=>$msg,'val'=>0]);
        }

        // 保存数据 
        $data = XQ::create($list);

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




    // 修改学期信息
    public function edit($id)
    {

        // 获取学期信息
        $list['data'] = XQ::field('id,title,xuenian,category,bfdate,enddate')
            ->get($id);

       // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'编辑学期',
            'butname'=>'修改',
            'formpost'=>'PUT',
            'url'=>'/xueqi/'.$id,
        );

        // 模板赋值
        $this->assign('list',$list);
        // 渲染
        return $this->fetch('create');
    }





    // 更新学期信息
    public function update($id)
    {
        $validate = new \app\teach\validate\Xueqi;

        // 获取表单数据
        $list = request()->only(['title','xuenian','category','bfdate','enddate'],'put');

        // 验证表单数据
        $result = $validate->check($list);
        $msg = $validate->getError();

        // 如果验证不通过则停止保存
        if(!$result){
            return json(['msg'=>$msg,'val'=>0]);;
        }


        // 更新数据
        $xq = new XQ();
        $data = $xq->save($list,['id'=>$id]);
        // $data = XQ::where('id',$id)->update($list);

        // 根据更新结果设置返回提示信息
        $data>=0 ? $data=['msg'=>'更新成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }

    



    // 删除学期
    public function delete($id)
    {

        if($id == 'm')
        {
            $id = request()->delete('ids');// 获取delete请求方式传送过来的数据并转换成数据
        }

        $data = XQ::destroy($id);

        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'删除成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }



    // 设置学期状态
    public function setStatus()
    {

        //  获取id变量
        $id = request()->post('id');
        $value = request()->post('value');

        // 获取学期信息
        $data = XQ::where('id',$id)->update(['status'=>$value]);

        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'状态设置成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }
}
