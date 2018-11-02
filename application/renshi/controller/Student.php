<?php

namespace app\renshi\controller;

// 引用控制器基类
use app\common\controller\Base;
// 引用学生数据模型类
use app\renshi\model\Student as STU;
// 引用文件信息存储数据模型类
use app\system\model\Fields;
// 引用phpspreadsheet类
use app\renshi\controller\Myexcel;

class Student extends Base
{
    // 显示学生列表
    public function index()
    {

        // 设置数据总数
        $list['count'] = STU::count();
        // 设置页面标题
        $list['title'] = '学生列表';

        // 模板赋值
        $this->assign('list', $list);

        // 渲染模板
        return $this->fetch();
    }


    // 获取学生信息列表
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
        $cnt = STU::count();
        //查询数据
        $data =STU::field('id,xingming,sex,shengri,status')
            ->order([$order_field=>$order])
            ->limit($limit_start,$limit_length)
            ->all();
        

        // 如果需要查询
        if($search){
            $data = STU::field('id,xingming,sex,shengri,status')
                ->order([$order_field=>$order])
                ->limit($limit_start,$limit_length)
                ->where('xingming','like','%'.$search.'%')
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



    // 创建学生
    public function create()
    {
        // 设置页面标题
        $list['title'] = '添加学生';

        // 模板赋值
        $this->assign('list',$list);

        // 渲染
        return $this->fetch();
    }

    

    // 保存信息
    public function save()
    {
        // 实例化验证模型
        $validate = new \app\renshi\validate\Student;


        // 获取表单数据
        $list = request()->only(['xingming','sex','quanpin','shoupin','shengri','zhiwu','zhicheng','xueli','biye','worktime','zhuanye','danwei'],'post');


        // 验证表单数据
        $result = $validate->check($list);
        $msg = $validate->getError();


        // 如果验证不通过则停止保存
        if(!$result){
            return json(['msg'=>$msg,'val'=>0]);;
        }

        // 保存数据 
        $data = STU::create($list);

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




    // 修改学生信息
    public function edit($id)
    {

        // 获取学生信息
        $list = STU::field('id,xingming,sex,quanpin,shoupin,shengri,zhiwu,zhicheng,xueli,biye,worktime,zhuanye,danwei')
            ->get($id);


        $this->assign('list',$list);

        return $this->fetch();
    }





    // 更新学生信息
    public function update($id)
    {
        $validate = new \app\renshi\validate\Student;

        // 获取表单数据
        $list = request()->only(['xingming','sex','quanpin','shoupin','shengri','zhiwu','zhicheng','xueli','biye','worktime','zhuanye','danwei'],'put');

        // 验证表单数据
        $result = $validate->check($list);
        $msg = $validate->getError();

        // 如果验证不通过则停止保存
        if(!$result){
            return json(['msg'=>$msg,'val'=>0]);;
        }


        // 更新数据
        $teacher = new Teacher();
        $data = $teacher->save($list,['id'=>$id]);
        // $data = STU::where('id',$id)->update($list);

        // 根据更新结果设置返回提示信息
        $data>=0 ? $data=['msg'=>'更新成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }

    



    // 删除学生
    public function delete($id)
    {

        if($id == 'm')
        {
            $id = request()->delete('ids/a');// 获取delete请求方式传送过来的数据并转换成数据
        }

        $data = STU::destroy($id);

        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'删除成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }



    // 设置学生状态
    public function setStatus()
    {

        //  获取id变量
        $id = request()->post('id');
        $value = request()->post('value');

        // 获取学生信息
        $data = STU::where('id',$id)->update(['status'=>$value]);

        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'状态设置成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }

    // 批量添加
    public function createAll()
    {
        return $this->fetch();
    }

    // 批量保存
    public function saveAll()
    {
        // 未完成

        // 获取表单数据
        $list = request()->only(['danwei','url'],'post');

        // 实例化操作表格类
        $excel = new Myexcel();

        // 读取表格数据
        $teacherinfo = $excel->readExcel($list['url']);
        

        
        return json($data);
    }

    

    // 上传文件
    public function upload()
    {
        // 获取文件信息
        $list['text'] = '学生名单';
        $list['oldname']=input('post.name');
        $list['bianjitime'] = input('post.lastModifiedDate');
        $list['fieldsize'] = input('post.size');
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');
        // 移动到框架应用根目录/uploads/ 目录下
        $info = $file->move( '..\uploads\teacher');
        if($info){
            // 成功上传后 获取上传信息
            $list['category'] = $info->getExtension();
            $list['url'] = $info->getSaveName();
            $list['newname'] = $info->getFilename(); 

            //将文件信息保存
            $data = Fields::create($list);

            $data ? $data = array('msg'=>'上传成功','val'=>true,'url'=>'..\uploads\teacher\\'.$list['url']) : $data = array('msg'=>'保存文件信息失败','val'=>false,'url'=>null);
        }else{
            // 上传失败获取错误信息
            $data = array('msg'=>$file->getError(),'val'=>false,'url'=>null);
        }

        // 返回信息
        return json($data);
    }
}
