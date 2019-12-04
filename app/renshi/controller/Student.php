<?php

namespace app\renshi\controller;

// 引用控制器基类
use app\BaseController;
// 引用学生数据模型类
use app\renshi\model\Student as STU;
// 引用phpspreadsheet类
use app\renshi\controller\Myexcel;

class Student extends BaseController
{
    // 显示学生列表
    public function index()
    {

        // 设置要给模板赋值的信息
        $list['webtitle'] = '学生列表';

        // 模板赋值
        $this->assign('list',$list);

        // 渲染模板
        return $this->fetch();
    }


    // 获取学生信息列表
    public function ajaxData()
    {
        // 获取参数
        $src = $this->request
                ->only([
                    'page'=>'1',
                    'limit'=>'10',
                    'field'=>'update_time',
                    'type'=>'desc',
                    'school'=>array(),
                    'ruxuenian'=>array(),
                    'paixu'=>array(),
                    'searchval'=>''
                ],'POST');

        $ruxuenian = $src['ruxuenian'];
        $paixu = $src['paixu'];

        // 实例化班级数据模型
        $banji = new  \app\teach\model\Banji;
        $src['banji'] = $banji->where('status',1)
                    ->when(count($ruxuenian)>0,function($query) use($ruxuenian){
                        $query->where('ruxuenian','in',$ruxuenian);
                    })
                    ->when(count($paixu)>0,function($query) use($paixu){
                        $query->where('paixu','in',$paixu);
                    })
                    ->column('id');

        // 实例化
        $stu = new STU;

        // 查询要显示的数据
        $data = $stu->search($src);
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



    // 创建学生
    public function create()
    {
        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'添加学生',
            'butname'=>'添加',
            'formpost'=>'POST',
            'url'=>'/student',
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

        $list['shenfenzhenghao'] = strtolower($list['shenfenzhenghao']);

        // 查询数据是否重复
        $chongfu = STU::withTrashed()->where('shenfenzhenghao',$list['shenfenzhenghao'])->find();
        // 保存或更新数据
        $stu = new STU;
        if($chongfu == Null)
        {
            $stu::create($list);

        }else{
            if($chongfu->delete_time>0)
            {
                $chongfu->restore();
            }
            $data = $stu->save($list,['id'=>$chongfu->id]);
        }

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
        $list['data'] = STU::field('id,xingming,sex,shenfenzhenghao,shengri,banji,school,status')
            ->with([
                    'stuBanji'=>function($query){
                        $query->field('id,ruxuenian,paixu')->append(['banTitle']);
                    }
                ])
            ->find($id);

        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'编辑学生',
            'butname'=>'修改',
            'formpost'=>'PUT',
            'url'=>'/student/'.$id,
        );


        // 模板赋值
        $this->assign('list',$list);
        // 渲染
        return $this->fetch('create');
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
            $id = request()->delete('ids');// 获取delete请求方式传送过来的数据并转换成数据
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
        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'批量上传学生信息',
            'butname'=>'批传',
            'formpost'=>'POST',
            'url'=>'/student/createall',
        );

        // 模板赋值
        $this->assign('list',$list);
        // 渲染
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

        // 判断表格是否正确
        if($stuinfo[0][0] != "学生信息上传模板" )
        {
            $data = array('msg'=>'请使用模板上传','val'=>0,'url'=>null);
            return json($data);
        }
        
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
            //  如果姓名、身份证号为空则跳过
            if(empty($value[1]) || empty($value[2]))
            {
                continue;
            }
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
                // 如果班级ID为空，删除数据并跳出当前循环
                if( empty($bj) )
                {
                    continue;
                }
            }
            $bfbanji = $value[3];

            // 各变量赋值
            $students[$i]['banji'] = $bj;
            $students[$i]['xingming'] = $value[1];
            $students[$i]['shenfenzhenghao'] = strtolower($value[2]);
            intval(substr($value[2],16,1) )% 2 ? $students[$i]['sex'] = 1 :$students[$i]['sex'] = 0 ;
            $students[$i]['shengri'] = substr($value[2],6,4).'-'.substr($value[2],10,2).'-'.substr($value[2],12,2);
            $students[$i]['school'] = $list['school'];
            $stuid = STU::withTrashed()->where('shenfenzhenghao',$value[2])->find();
            if($stuid)
            {
                if($stuid->delete_time>0)
                {
                    $stuid->restore();
                }
                if($stuid->status == 0)
                {
                    $stuid->status = 1;
                    $stuid->save();
                }
                $students[$i]['id'] = $stuid->id;
            }
            // 销毁无用变量
            $i++;
        }
       
        
        // 实例化学生信息数据模型
        $student = new STU();

        // 保存或更新信息
        $data = $student->saveAll($students);

        $data ? $data = ['msg'=>'数据同步成功','val'=>1] : ['msg'=>'数据同步失败','val'=>0];
        
        return json($data);
    }



    // 使用上传的表格进行校对，表格中不存在的数据删除
    public function Jiaodui()
    {
        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'校对并删除学生信息',
            'butname'=>'校对删除',
            'formpost'=>'POST',
            'url'=>'/student/jiaodui',
        );

        // 模板赋值
        $this->assign('list',$list);
        // 渲染
        return $this->fetch('create_all');
    }


    // 使用上传的表格进行校对，表格中不存在的数据删除
    public function JiaoduiDel()
    {
        // 获取表单数据
        $list = request()->only(['school','url'],'post');

        // 实例化操作表格类
        $excel = new Myexcel();

        // 读取表格数据
        $stuinfo = $excel->readXls($list['url']);

        // 判断表格是否正确
        if($stuinfo[0][0] != "学生信息上传模板" )
        {
            $data = array('msg'=>'请使用模板上传','val'=>0,'url'=>null);
            return json($data);
        }
        
        // 删除标题行
        array_splice($stuinfo,0,3);

        // 实例化班级数据模型
        $banji = new \app\teach\model\Banji;
        $njlist = nianjilist();
        $bjlist = banjinamelist();


        $i = 0;
        $bfbanji = ''; #前一个班级名
        $bj = '';  #当前班级名
        $students = array(); #存储整理后学生信息
        $bjarr = array(); #储存电子表格中包含的班级
        // 重新计算组合数据，如果存在数据则更新数据
        foreach ($stuinfo as $key => $value) {
            //  如果姓名、身份证号为空则跳过
            if(empty($value[1]) || empty($value[2]))
            {
                continue;
            }
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
                // 如果班级ID为空，删除数据并跳出当前循环
                if( empty($bj) )
                {
                    continue;
                }
                array_push($bjarr, $bj);
            }
            $bfbanji = $value[3];
            

            // 各变量赋值
            $students[strtolower($value[2])] = $bj;
            
            // 销毁无用变量
            $i++;
        }

        // 查询数据库中学生的信息
        // $student = new STU();

        $stulist = STU::where('banji','in',$bjarr)
                        ->where('school',$list['school'])
                        ->field('banji')
                        ->column('id,shenfenzhenghao,school,banji');
        // 声明要删除学生的ID数组
        $stuidarr = array();

        // 循环数据库中的学生信息，与电子表格中的信息对比，如果电子表格中不存在，则放数数组中。
        foreach ($stulist as $key => $value) {
            if(array_key_exists($value['shenfenzhenghao'],$students)==false){
                array_push($stuidarr, $value['id']);
            }else{
                if($value['banji']!=$students[$value['shenfenzhenghao']])
                {
                    array_push($stuidarr, $value['id']);
                }
            }
        }
        // 删除学生信息
        $data = STU::destroy($stuidarr);

        $data ? $data = ['msg'=>'数据同步成功','val'=>1] : ['msg'=>'数据同步失败','val'=>0];
        
        return json($data);
    }

    

    // 上传文件
    public function upload()
    {
        // 获取文件信息
        $list['text'] = $this->request->post('text');
        $list['serurl'] = $this->request->post('serurl');

        // 获取表单上传文件
        $file = request()->file('file');
        // 上传文件并返回结果
        $data = upload($list,$file,true);

        return json($data);
    }



    // 下载表格模板
    public function download()
    {
        $download =  new \think\response\Download('uploads\student\student_template.xlsx');
        return $download->name('student_template.xlsx');
    }




}