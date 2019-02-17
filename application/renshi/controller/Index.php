<?php

namespace app\renshi\controller;

// 引用控制器基类
use app\common\controller\Base;
// 引用教师数据模型类
use app\renshi\model\Teacher;
// 引用文件信息存储数据模型类
use app\system\model\Fields;
// 引用phpspreadsheet类
use app\renshi\controller\Myexcel;

class Index extends Base
{
    // 显示教师列表
    public function index()
    {

        // 设置数据总数
        $list['count'] = Teacher::count();
        // 设置页面标题
        $list['title'] = '教师列表';

        // 模板赋值
        $this->assign('list', $list);

        // 渲染模板
        return $this->fetch();
    }


    // 获取教师信息列表
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
        $cnt = Teacher::count();
        //查询数据
        $data =Teacher::field('id,xingming,sex,shengri,xueli,biye,worktime,zhuanye,danwei,status')
            ->order([$order_field=>$order])
            ->limit($limit_start,$limit_length)
            ->all();
        

        // 如果需要查询
        if($search){
            $data = Teacher::field('id,xingming,sex,shengri,xueli,biye,worktime,zhuanye,danwei,status')
                ->order([$order_field=>$order])
                ->limit($limit_start,$limit_length)
                ->where('xingming|biye|zhuanye','like','%'.$search.'%')
                ->all();
        }

        $datacnt = $data->count();
        $data = $data->append(['age']);
        
        


        $data = [
            'draw'=> $getdt["draw"] , // ajax请求次数，作为标识符
            'recordsTotal'=>$datacnt,  // 获取到的结果数(每页显示数量)
            'recordsFiltered'=>$cnt,       // 符合条件的总数据量
            'data'=>$data, //获取到的数据结果
        ];

        return json($data);
    }



    // 创建教师
    public function create()
    {
        // 设置页面标题
        $list['title'] = '添加教师';

        // 模板赋值
        $this->assign('list',$list);

        // 渲染
        return $this->fetch();
    }

    

    // 保存信息
    public function save()
    {
        // 实例化验证模型
        $validate = new \app\renshi\validate\Teacher;


        // 获取表单数据
        $list = request()->only(['xingming','sex','quanpin','shoupin','shengri','zhiwu','zhicheng','xueli','biye','worktime','zhuanye','danwei'],'post');


        // 验证表单数据
        $result = $validate->check($list);
        $msg = $validate->getError();

        $list['quanpin'] = strtolower($list['quanpin']);
        $list['shoupin'] = strtolower($list['shoupin']);


        // 如果验证不通过则停止保存
        if(!$result){
            return json(['msg'=>$msg,'val'=>0]);;
        }

        // 保存数据 
        $data = Teacher::create($list);

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




    // 修改教师信息
    public function edit($id)
    {

        // 获取教师信息
        $list = Teacher::field('id,xingming,sex,quanpin,shoupin,shengri,zhiwu,zhicheng,xueli,biye,worktime,zhuanye,danwei')
            ->get($id);


        $this->assign('list',$list);

        return $this->fetch();
    }





    // 更新教师信息
    public function update($id)
    {
        $validate = new \app\renshi\validate\Teacher;

        // 获取表单数据
        $list = request()->only(['xingming','sex','quanpin','shoupin','shengri','zhiwu','zhicheng','xueli','biye','worktime','zhuanye','danwei'],'put');

        // 验证表单数据
        $result = $validate->check($list);
        $msg = $validate->getError();

        // 如果验证不通过则停止保存
        if(!$result){
            return json(['msg'=>$msg,'val'=>0]);;
        }

        $list['quanpin'] = strtolower($list['quanpin']);
        $list['shoupin'] = strtolower($list['shoupin']);
        // 更新数据
        $teacher = new Teacher();
        $data = $teacher->save($list,['id'=>$id]);
        // $data = Teacher::where('id',$id)->update($list);

        // 根据更新结果设置返回提示信息
        $data>=0 ? $data=['msg'=>'更新成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }

    



    // 删除教师
    public function delete($id)
    {

        if($id == 'm')
        {
            $id = request()->delete('ids/a');// 获取delete请求方式传送过来的数据并转换成数据
        }

        $data = Teacher::destroy($id);

        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'删除成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }



    // 设置教师状态
    public function setStatus()
    {

        //  获取id变量
        $id = request()->post('id');
        $value = request()->post('value');

        // 获取教师信息
        $data = Teacher::where('id',$id)->update(['status'=>$value]);

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
        // 获取表单数据
        $list = request()->only(['school','url'],'post');

        // 实例化操作表格类
        $excel = new \app\renshi\controller\Myexcel;;

        // 读取表格数据
        $teacherinfo = $excel->readXls($list['url']);

        // 判断表格是否正确
        if($teacherinfo[0][1] != "教师基本情况表" )
        {
            $data = array('msg'=>'请使用模板上传','val'=>false,'url'=>null);
            return json($data);
        }

        // 删除标题行
        array_splice($stuinfo,0,3);

        // 整理数据
        $i = 0;
        $teacher = array();

        

        
        return json($data);
    }

    

    // 上传文件
    public function upload()
    {
        // 获取文件信息
        $list['text'] = '教师名单';
        $list['oldname']=input('post.name');
        $list['bianjitime'] = input('post.lastModifiedDate');
        $list['fieldsize'] = input('post.size');
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');
        // 移动到框架应用根目录/uploads/ 目录下
        $info = $file->move( '..\public\uploads\teacher');
        if($info){
            // 成功上传后 获取上传信息
            $list['category'] = $info->getExtension();
            $list['url'] = $info->getSaveName();
            $list['newname'] = $info->getFilename(); 

            //将文件信息保存
            $data = Fields::create($list);

            $data ? $data = array('msg'=>'上传成功','val'=>true,'url'=>'..\public\uploads\teacher\\'.$list['url']) : $data = array('msg'=>'保存文件信息失败','val'=>false,'url'=>null);
        }else{
            // 上传失败获取错误信息
            $data = array('msg'=>$file->getError(),'val'=>false,'url'=>null);
        }

        // 返回信息
        return json($data);
    }



    // 根据教师姓名、首拼、全拼搜索教师信息
    public function srcTeacher($str="")
    {
        // 声明结果数组
        $data = array();


        // 判断是否存在数据，如果没有数据则返回。
        if(strlen($str) <= 0)
        {
            return json($data);
        }


        // 如果有数据则查询教师信息
        $list = Teacher::field('id,xingming,danwei,shengri,sex')
                    ->whereOr('xingming|quanpin','like',$str.'%')
                    ->whereOr('quanpin','like',$str.'%')
                    ->whereOr('shoupin','like',$str.'%')
                    ->append(['age'])
                    ->all();
        return json($list);
    }


    // 下载表格模板
    public function download()
    {
        $download =  new \think\response\Download('TeacherInfo.xlsx');
        return $download->name('TeacherInfo.xlsx');
    }



}