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
        $order_field = $getdt['columns'][$order_column]['name'];
        if($order_field=='')
        {
            $order_field = $getdt['columns'][$order_column]['data'];
        }
        //得到limit参数
        $limit_start = $getdt['start'];
        $limit_length = $getdt['length'];
        $banji = $getdt['banji'];

        //处理入学年
        if(empty($getdt['ruxuenian']))
        {
            $njlist = nianjiList();
            $njnum = array_keys($njlist);
        }else{
            $njnum = $getdt['ruxuenian'];
        }

        // 获取班级id
        
        $bj = new \app\teach\model\Banji;
        $bjlist = $bj->where('ruxuenian','in',$njnum)
            ->when(!empty($banji),function($query) use($banji){
                    $query->where('paixu','in',$banji);
                })
            ->column('id');


        //得到搜索的关键词
        $search = [
            'school'=>$getdt['school'],
            'banji'=>$bjlist,
            'order'=>$order,
            'order_field'=>$order_field,
            'search'=>$getdt['search']['value']
        ];


        // 实例化学生数据模型
        $stu = new STU;

        // 筛选数据
        $data = $stu->searchMany($search);
        //获取数据总数
        $cnt = $data->count();
        // 获取当前页数据
        $data = $data->slice($limit_start,$limit_length);
        // 获取本页数据总数
        $datacnt = $data->count();
        //追加属性
        $data = $data->append(['stu_school.title','stu_banji.title','age']);
        // 组合返回数据
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
        $list = request()->only(['xingming','sex','shenfenzhenghao','shengri','school','ruxuenian','banji'],'post');

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
        $list = STU::field('id,xingming,sex,shenfenzhenghao,shengri,banji,school,status')
            ->get($id);


        $this->assign('list',$list);

        return $this->fetch();
    }





    // 更新学生信息
    public function update($id)
    {
        $validate = new \app\renshi\validate\Student;

        // 获取表单数据
        $list = request()->only(['xingming','sex','shengri','school','shenfenzhenghao','ruxuenian','banji'],'put');

        // 验证表单数据
        $result = $validate->check($list);
        $msg = $validate->getError();

        // 如果验证不通过则停止保存
        if(!$result){
            return json(['msg'=>$msg,'val'=>0]);;
        }


        // 更新数据
        $stu = new STU();
        $data = $stu->save($list,['id'=>$id]);

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
        // 获取表单数据
        $list = request()->only(['school','url'],'post');

        // 实例化操作表格类
        $excel = new Myexcel();

        // 读取表格数据
        $stuinfo = $excel->readXls($list['url']);
        // 删除标题行
        array_splice($stuinfo,0,3);

        // 实例化班级数据模型
        $banji = new \app\teach\model\Banji;
        $njlist = nianjilist();
        $bjlist = banjinamelist();


        $i = 0;
        $bfbanji = '';
        $bj = '';
        $students = array();
        // 重新计算组合数据，如果存在数据则更新数据
        foreach ($stuinfo as $key => $value) {
            // 判断本行班级与上行班级数据是否相等，如果不相等则从数据库查询班级ID
            if($bfbanji != $value[3])
            {
                // 获取入学年与排序
                $paixu = array_search(substr($value[3],9),$bjlist);
                $ruxuenian = array_search(substr($value[3],0,9),$njlist);
                // 查询班级ID
                $bj = $banji::where('school',$list['school'])
                    ->where('ruxuenian',$ruxuenian)
                    ->where('paixu',$paixu)
                    ->value('id');
            }
            $bfbanji = $value[3];
            // 如果班级ID为空，删除数据并跳出当前循环
            if($bj == null || $bj =='' )
            {
                continue;
            }

            // 各变量赋值
            $students[$i]['banji'] = $bj;
            $students[$i]['xingming'] = $value[1];
            $students[$i]['shenfenzhenghao'] = $value[2];
            substr($value[2],16,17)%2 == 1 ? $students[$i]['sex']=1 :$students[$i]['sex']=0;
            $students[$i]['shengri'] = substr($value[2],6,4).'-'.substr($value[2],10,2).'-'.substr($value[2],12,2);
            $students[$i]['school'] = $list['school'];
            $stuid = STU::where('shenfenzhenghao',$value[2])->value('id');
            $stuid > 0 ? $students[$i]['id'] = $stuid : true;
            // 销毁无用变量
            $i++;
        }
        
        
        // 实例化学生信息数据模型
        $student = new STU();

        // 保存或更新信息
        $data = $student->saveAll($students);
        // $cnt = $data->count();

        $data ? $data = ['msg'=>'数据同步成功','val'=>true] : ['msg'=>'数据同步失败','val'=>false];
        

        
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
        $info = $file->move( '..\public\uploads\student');
        if($info){
            // 成功上传后 获取上传信息
            $list['category'] = $info->getExtension();
            $list['url'] = $info->getSaveName();
            $list['newname'] = $info->getFilename(); 

            //将文件信息保存
            $data = Fields::create($list);

            $data ? $data = array('msg'=>'上传成功','val'=>true,'url'=>'..\public\uploads\student\\'.$list['url']) : $data = array('msg'=>'保存文件信息失败','val'=>false,'url'=>null);
        }else{
            // 上传失败获取错误信息
            $data = array('msg'=>$file->getError(),'val'=>false,'url'=>null);
        }

        // 返回信息
        return json($data);
    }

    // 下载表格模板
    public function download()
    {
        $download =  new \think\response\Download('student_template.xlsx');
        return $download->name('student_template.xlsx');
    }

    // 查询参加考试学生名单
    public function ckStudents()
    {

    }

    // 导出数据
    public function outCankao($data)
    {
        
    }


}
