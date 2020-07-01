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
        $this->view->assign('list', $list);

        // 渲染模板
        return $this->view->fetch();
    }


    //  获取单位列表数据
    public function ajaxData()
    {
        // 获取参数
        $src = $this->request
                ->only([
                    'page' => '1'
                    ,'limit' => '10'
                    ,'field' => 'id'
                    ,'order' => 'desc'
                    ,'searchval' => ''
                ],'POST');

        // 根据条件查询数据
        $fl = new FL;
        $data = $fl->search($src)
            ->visible([
                'id'
                ,'flCategory'=>['title']
                ,'oldname'
                ,'fieldsize'
                ,'flUser'=>['xingming']
                ,'bianjitime'
                ,'update_time'
            ]);
        $data = reSetObject($data, $src);

        return json($data);
    }


    // 下载文件
    public function download($id)
    {
        // 实例化文件数据模型
        $fl = new FL;
        // 查询文件信息
        $filist = $fl->where('id', $id)->find();
        if($filist->oldname == null)
        {
            $oldname = $filist->newname;
        }else{
            $oldname = $filist->oldname;
        }

        $url = public_path() . 'public\\uploads\\' . $filist->url;

        $data = file_exists($url);
        if ($data === true) {
            return download($url, $oldname);
        } else {
           return $this->error('文件不存在！');
        }
        

    }


    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        $id = request()->delete('id');
        $id = explode(',', $id);

        $data = FL::destroy($id);

        // 根据更新结果设置返回提示信息
        $data ? $data = ['msg' => '删除成功', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];

        // 返回信息
        return json($data);
    }


}
