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
        // 设置要给模板赋值的信息
        $list['webtitle'] = '单位荣誉列表';

        // 模板赋值
        $this->assign('list',$list);

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
        // 获取参数
        $src = $this->request
                ->only([
                    'page'=>'1',
                    'limit'=>'10',
                    'field'=>'update_time',
                    'order'=>'asc',
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
            'url'=>'/dwry',
        );


        // 模板赋值
        $this->assign('list',$list);
        // 渲染
        return $this->fetch('create');
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
        $list = request()->only(['id','url','title','teachers','hjschool','category','fzshijian','fzschool','jiangxiang'],'post');

        // 实例化验证模型
        $validate = new \app\rongyu\validate\DwRongyu;
        // 验证表单数据
        $result = $validate->check($list);
        $msg = $validate->getError();
        // 如果验证不通过则停止保存
        if(!$result){
            dwry::destroy($list['id'],true);
            return json(['msg'=>$msg,'val'=>0]);
        }

        // 保存数据 
        $data = dwry::update($list);

        if(!empty($list['teachers']))
        {
            // 单位荣誉参与数据模型
            // $dwrycy = new \app\rongyu\model\DwRongyuCanyu;

            // 声明参与教师数组
            $canyulist = [];
            // 循环组成参与信息
            foreach ($list['teachers'] as $key => $value) {
                $canyulist[] = [
                    'teacherid' => $value,
                    'rongyuid' => $list['id'],
                ];
            }

            $data->cyDwry()->saveAll($canyulist);
        }

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
    public function createall()
    {
        // 设置页面标题
        $list['title'] = '添加单位荣誉';

        // 模板赋值
        $this->assign('list',$list);

        // 渲染
        return $this->fetch();
       
    }

     /**
     * 上传荣誉图片并保存
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
     public function upload()
    {

        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');
        // 移动到框架应用根目录/uploads/ 目录下
        $info = $file->validate(['size'=>2*1024*1024,'ext'=>'jpg,png,gif,jpeg'])->move('uploads\danweirongyu');


        if($info){
            // 成功上传后 获取上传信息
            $list['url'] = $info->getSaveName();
            $list['url'] = str_replace('\\','/',$list['url']);


            // 如果图片上传成功，则添加荣誉记录
            $data = dwry::create(['url'=>$list['url']]);
            $id = $data->id;

            $id ? $data = array('msg'=>'上传成功','val'=>true,'url'=>$list['url'],'id'=>$id) : $data = array('msg'=>'保存文件信息失败','val'=>false,'url'=>null,'id'=>null);
        }else{
            // 上传失败获取错误信息
            $data = array('msg'=>$file->getError(),'val'=>false,'url'=>null);
        }

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
                ->field('id,title,category,hjschool,fzshijian,fzschool,jiangxiang,url')
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
            'url'=>'/dwry/'.$id,
        );


        // 模板赋值
        $this->assign('list',$list);
        // 渲染
        return $this->fetch('create');

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
        $list = request()->only(['title','category','hjschool','fzshijian','fzschool','jiangxiang','teachers'],'put');
        $list['id'] = $id;
        

        // 实例化验证类
        $validate = new \app\rongyu\validate\DwRongyu;
        // 验证表单数据
        $result = $validate->check($list);
        $msg = $validate->getError();

        // 如果验证不通过则停止保存
        if(!$result){
            return json(['msg'=>$msg,'val'=>0]);;
        }


        // 更新数据
        // $dwry = new dwry();
        $data = dwry::update($list);

        if(!empty($list['teachers']))
        {

            $data->cyDwry()->delete(true);

            // 声明参与教师数组
            $canyulist = [];
            // 循环组成参与信息
            foreach ($list['teachers'] as $key => $value) {
                $canyulist[] = [
                    'teacherid' => $value,
                    'rongyuid' => $list['id'],
                ];
            }

            $data->cyDwry()->saveAll($canyulist);
        }

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
