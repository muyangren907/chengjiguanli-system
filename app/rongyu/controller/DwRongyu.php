<?php

namespace app\rongyu\controller;

// 引用控制器基类
use app\BaseController;
// 引用教师数据模型类
use app\rongyu\model\DwRongyu as dwry;

class DwRongyu extends BaseController
{
    /**
     * 显示单位荣誉列表
     *
     * @return \think\Response
     */
    public function index()
    {
        // 设置要给模板赋值的信息
        $list['webtitle'] = '单位荣誉列表';
        $list['dataurl'] = 'dwry/data';

        // 模板赋值
        $this->view->assign('list',$list);

        // 渲染模板
        return $this->view->fetch();
    }

    /**
     * 显示单位荣誉列表
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
                    'type'=>'desc',
                    'fzschool'=>array(),
                    'hjschool'=>array(),
                    'category'=>array(),
                    'searchval'=>''
                ],'POST');


        // 实例化
        $dwry = new dwry;

        // 查询要显示的数据
        $data = $dwry->search($src);
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
            'webtitle'=>'添加单位荣誉',
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
        $list = request()->only(['url','project','title','teachers'=>array(),'hjschool','category','fzshijian','fzschool','jiangxiang'],'post');

        // 实例化验证模型
        $validate = new \app\rongyu\validate\DwRongyu;
        // 验证表单数据
        $result = $validate->scene('add')->check($list);
        $msg = $validate->getError();
        // 如果验证不通过则停止保存
        if(!$result){
            return json(['msg'=>$msg,'val'=>0]);
        }

        // 保存数据 
        $data = dwry::create($list);


        // 重组教师id
        $teachers = array();
        foreach ($list['teachers'] as $key => $value) {
           $teachers[]['teacherid'] = $value;
        }


        $data->cyDwry()->saveAll($teachers);

        
        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'添加成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }

    /**
     * 批量上传单位荣誉图片
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    // 批量添加
    public function createAll()
    {
        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'批量上传荣誉图片',
            'butname'=>'批传',
            'formpost'=>'POST',
            'url'=>'saveall',
        );

        // 模板赋值
        $this->view->assign('list',$list);
        // 渲染
        return $this->view->fetch();
    }

    // 保存批传
    public function saveall()
    {
        // 获取文件信息
        $list['text'] = $this->request->post('text');
        $list['serurl'] = $this->request->post('serurl');

        // 获取表单上传文件
        $file = request()->file('file');
        // 上传文件并返回结果
        $data = upload($list,$file);

        if($data['val'] != 1)
        {
            $data=['msg'=>'添加失败','val'=>0];
        }

        $data = dwry::create([
            'url'=>$data['url']
            ,'title'=>'批传单位荣誉图片'
        ]);

        $data ? $data=['msg'=>'批传成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        return json($data);
    }

     /**
     * 上传荣誉图片并保存
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
     public function upload()
    {

        // 获取文件信息
        $list['text'] = $this->request->post('text');
        $list['serurl'] = $this->request->post('serurl');

        // 获取表单上传文件
        $file = request()->file('file');
        // 上传文件并返回结果
        $data = upload($list,$file);

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
        // 获取学生信息
        $list['data'] = dwry::where('id',$id)
                ->field('id,title,project,category,hjschool,fzshijian,fzschool,jiangxiang,url')
                ->with([
                    'cyDwry'=>function($query){
                        $query->field('rongyuid,teacherid')
                        ->with(['teacher'=>function($query){
                            $query->field('id,xingming');
                        }]);
                    },
                ])
                ->find();

        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'编辑单位荣誉',
            'butname'=>'修改',
            'formpost'=>'PUT',
            'url'=>'dwry/update/'.$id,
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
        $list = request()->only(['title','project','category','hjschool','fzshijian','fzschool','jiangxiang','teachers'=>array(),'url'],'put');
        $list['id'] = $id;
        

        // 实例化验证类
        $validate = new \app\rongyu\validate\DwRongyu;
        // 验证表单数据
        $result = $validate->scene('edit')->check($list);
        $msg = $validate->getError();

        // 如果验证不通过则停止保存
        if(!$result){
            return json(['msg'=>$msg,'val'=>0]);;
        }


        // 更新数据
        $dwry = new dwry();
        $data = dwry::update($list);

        // 删除原来的参与教师
        $data->cyDwry()->where('rongyuid',$id)->delete(true);

        // 声明参与教师数组
        $canyulist = [];
        // 循环组成参与教师
        foreach ($list['teachers'] as $key => $value) {
            $canyulist[] = [
                'teacherid' => $value,
            ];
        }
        //  更新参考教师
        $data->cyDwry()->saveAll($canyulist);

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

        $data = dwry::destroy($id);

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
        $data = dwry::where('id',$id)->update(['status'=>$value]);

        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'状态设置成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }


    

}
