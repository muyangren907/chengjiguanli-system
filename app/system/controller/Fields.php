<?php

namespace app\system\controller;

// 引用控制器基类
use app\BaseController;
// 引用单位数据模型类
use app\system\model\Fields as FL;

class Fields extends BaseController
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        // 设置要给模板赋值的信息
        $list['webtitle'] = '文件列表';
        $list['dataurl'] = 'file/data';

        // 模板赋值
        $this->view->assign('list',$list);

        // 渲染模板
        return $this->view->fetch();
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
                    'type'=>'desc',
                ],'POST');


        // 实例化
        $fl = new FL;

        // 查询要显示的数据
        $data = $fl->search($src);
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


    // 下载文件
    public function download($id)
    {
        // 实例化文件数据模型
        $fl = new FL;
        // 查询文件信息
        $filist = $fl->where('id',$id)->find();

        $url = 'uploads\\'.$filist->url;
        $name = $filist->oldname;

        $a = $this->request->root();

        return download('favicon.ico','aa.ico');

        // return download('.\\uploads\\chengji\\20190906\\fa3d00866ee52fcc5ae94b178a37de1a.xls', "$name");

        // return download('uploads\\'.$filist->url, $filist->oldname)->expire(300);

        // 下载文件
        // $download =  new \think\Download('uploads\\'.$filist->url,'aa.xls');

        // return $download->name($filist->oldname);

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
            $id = request()->delete('ids');
        }

        $id = explode(',',$id);

        $data = FL::destroy($id);

        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'删除成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }

    
}
