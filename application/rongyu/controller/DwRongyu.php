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
        $cnt = $dwry->select()->count();

        // 查询数据
        $data = $dwry->search($search);
        $datacnt = $data->count();

        // 获取当前页数据
        $data = $data->slice($limit_start,$limit_length);


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
        // 设置页面标题
        $list['title'] = '添加单位荣誉';

        // 模板赋值
        $this->assign('list',$list);

        // 渲染
        return $this->fetch();
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
        $list = request()->only(['id','url','title','hjschool','category','fzshijian','fzschool','jiangxiang'],'post');

        // 实例化验证模型
        $validate = new \app\rongyu\validate\DwRongyu;
        // 验证表单数据
        $result = $validate->check($list);
        $msg = $validate->getError();
        // 如果验证不通过则停止保存
        if(!$result){
            return json(['msg'=>$msg,'val'=>0]);;
        }

        // 保存数据 
        $data = dwry::update($list);

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
        // 获取文件信息
        $list['text'] = '单位荣誉批量上传';
        $list['oldname']=input('post.name');
        $list['fieldsize'] = input('post.size');


        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');
        // 移动到框架应用根目录/uploads/ 目录下
        $info = $file->validate(['size'=>2*1024*1024,'ext'=>'jpg,png,gif,jpeg'])->move('uploads\danweirongyu');

        // use Qsnh\think\Upload\Upload;

        $upload = new Qsnh\think\Upload\Upload(config('upload'));

        $result = $upload->upload();

        if (!$result) {
            $this->error($upload->getErrors());
        }

        halt($result);
        return 'aa';
        

        if($info){
            // 成功上传后 获取上传信息
            $list['category'] = $info->getExtension();
            $list['url'] = $info->getSaveName();
            $list['newname'] = $info->getFilename(); 
            // $myfileurl = '\uploads\\'.$list['url'];
            $list['bianjitime'] = filemtime('uploads\danweirongyu\\'.$list['url']);
            $list['url'] = str_replace('\\','/',$list['url']);

            //将文件信息保存
            $file = new \app\system\model\Fields;
            $data = $file::create($list);

            // 如果图片上传成功，则添加荣誉记录
            if($data)
            {
                $rydata = dwry::create(['url'=>$list['url']]);
                $ryid = $rydata->id;
            }

            $ryid ? $data = array('msg'=>'上传成功','val'=>true,'url'=>$list['url'],'ryid'=>$ryid) : $data = array('msg'=>'保存文件信息失败','val'=>false,'url'=>null);
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
        $list = dwry::where('id',$id)
                ->field('id,title,category,hjschool,fzshijian,fzschool,jiangxiang,url')
                ->find();


        $this->assign('list',$list);

        return $this->fetch();
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
        $list = request()->only(['title','category','hjschool','fzshijian','fzschool','jiangxiang'],'put');
        

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
        $dwry = new dwry();
        $data = $dwry->save($list,['id'=>$id]);

        // 根据更新结果设置返回提示信息
        $data>=0 ? $data=['msg'=>'更新成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

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
            $id = request()->delete('ids/a');// 获取delete请求方式传送过来的数据并转换成数据
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
