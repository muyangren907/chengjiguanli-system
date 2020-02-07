<?php

namespace app\rongyu\controller;

// 引用控制器基类
use app\BaseController;
// 引用教师数据模型类
use app\rongyu\model\JsRongyu as jsry;
// 引用教师数据模型类
use app\rongyu\model\JsRongyuInfo as jsryinfo;

class Jiaoshi extends BaseController
{
    /**
     * 显示教师荣誉册列表
     *
     * @return \think\Response
     */
    public function index()
    {
        // 设置要给模板赋值的信息
        $list['webtitle'] = '教师荣誉册列表';
        $list['dataurl'] = 'jiaoshi/data';

        // 模板赋值
        $this->view->assign('list',$list);

        // 渲染模板
        return $this->view->fetch();
    }

    /**
     * 显示教师荣誉册列表
     *
     * @return \think\Response
     */
    public function ajaxData()
    {
        // 获取参数
        $src = $this->request
                ->only([
                    'page'=>'1',
                    'limit'=>'10',
                    'field'=>'update_time',
                    'order'=>'desc',
                    'fzschool'=>array(),
                    'hjschool'=>array(),
                    'category'=>array(),
                    'searchval'=>''
                ],'POST');


        // 实例化
        $jsry = new jsry;

        // 查询要显示的数据
        $data = $jsry->search($src);
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

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'添加荣誉册',
            'butname'=>'添加',
            'formpost'=>'POST',
            'url'=>'save',
        );

        // 模板赋值
        $this->view->assign('list',$list);
        // 渲染
        return $this->view->fetch('create');
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save()
    {
        // 获取表单数据
        $list = request()->only(['title','category','fzshijian','fzschool'],'post');

        // 实例化验证模型
        $validate = new \app\rongyu\validate\JsRongyu;
        // 验证表单数据
        $result = $validate->check($list);
        $msg = $validate->getError();
        // 如果验证不通过则停止保存
        if(!$result){
            return json(['msg'=>$msg,'val'=>0]);
        }

        // 保存数据 
        $data = jsry::create($list);

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
        
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        // 获取荣誉册信息
        $list['data'] = jsry::where('id',$id)
                ->field('id,title,category,fzshijian,fzschool')
                ->find();

        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'编辑荣誉册',
            'butname'=>'修改',
            'formpost'=>'PUT',
            'url'=>'/rongyu/jiaoshi/update/'.$id,
        );

        // 模板赋值
        $this->view->assign('list',$list);
        // 渲染
        return $this->view->fetch('create');
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update($id)
    {
        // 获取表单数据
        $list = request()->only(['title','category','fzshijian','fzschool'],'put');
        $list['id'] = $id;
        

        // 实例化验证类
        $validate = new \app\rongyu\validate\JsRongyu;
        // 验证表单数据
        $result = $validate->check($list);
        $msg = $validate->getError();

        // 如果验证不通过则停止保存
        if(!$result){
            return json(['msg'=>$msg,'val'=>0]);;
        }


        // 更新数据
        $data = jsry::update($list);

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

        if($id == 'm')
        {
            $id = request()->delete('ids');// 获取delete请求方式传送过来的数据并转换成数据
        }

        $id = explode(',', $id);

        $data = jsry::destroy($id);

        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'删除成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }



    // 设置荣誉状态
    public function setStatus()
    {

        //  获取id变量
        $id = request()->post('id');
        $value = request()->post('value');

        // 获取学生信息
        $data = jsry::where('id',$id)->update(['status'=>$value]);

        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'状态设置成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }
}
