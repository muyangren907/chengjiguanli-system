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
        $list['dataurl'] = 'student/data';

        // 模板赋值
        $this->view->assign('list',$list);

        // 渲染模板
        return $this->view->fetch();
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

        if(count($ruxuenian)==0)
        {
            $njlist = nianjilist();
            $ruxuenian = array_keys($njlist);
        }


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


    // 毕业学生列表
    public function byList()
    {
        // 设置要给模板赋值的信息
        $list['webtitle'] = '毕业学生';
        $list['dataurl'] = '/renshi/student/databy';

        // 模板赋值
        $this->view->assign('list',$list);

        // 渲染模板
        return $this->view->fetch();
    }


    // 获取学生信息列表
    public function ajaxDataBy()
    {
        // 获取参数
        $src = $this->request
                ->only([
                    'page'=>'1',
                    'limit'=>'10',
                    'field'=>'update_time',
                    'type'=>'desc',
                    'school'=>array(),
                    'searchval'=>''
                ],'POST');


        // 实例化
        $stu = new STU;

        // 查询要显示的数据
        $data = $stu->searchBy($src);
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


    // 删除学生列表
    public function delList()
    {
        // 设置要给模板赋值的信息
        $list['webtitle'] = '异动学生';
        $list['dataurl'] = '/renshi/student/datadel';

        // 模板赋值
        $this->view->assign('list',$list);

        // 渲染模板
        return $this->view->fetch();
    }


    // 获取学生信息列表
    public function ajaxDataDel()
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

        if(count($ruxuenian)==0)
        {
            $njlist = nianjilist();
            $ruxuenian = array_keys($njlist);
        }


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
        $data = $stu->searchDel($src);
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
            'url'=>'save',
        );

        // 模板赋值
        $this->view->assign('list',$list);
        // 渲染
        return $this->view->fetch('create');
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

        $list['shenfenzhenghao'] = strtoupper($list['shenfenzhenghao']);

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
            $data = $stu::update($list,['id'=>$chongfu->id]);
        }

        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'添加成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }

    //
    public function read($id)
    {
        // 查询教师信息
        $myInfo = STU::withTrashed()
            ->where('id',$id)
            ->with([
                'stuBanji'=>function($query)
                {
                    $query->field('id,school,ruxuenian,paixu')->append(['banjiTitle']);
                },
                'stuSchool'=>function($query)
                {
                    $query->field('id,title');
                }
            ])
            ->find();
        // 设置页面标题
        $myInfo['webtitle'] = $myInfo->xingming.' 信息';


        // 模板赋值
        $this->view->assign('list',$myInfo);
        // 渲染模板
        return $this->view->fetch();
    }



    // 获取考试成绩
    public function ajaxDatachengji()
    {
        // 获取表单参数
        // 获取参数
        $src = $this->request
                ->only([
                    'page'=>'1',
                    'limit'=>'10',
                    'field'=>'update_time',
                    'type'=>'desc',
                    'studentid'=>'',
                ],'POST');

        // 获取学生成绩
        $kh = new \app\kaoshi\model\Kaohao;
        $khList = $kh
                    ->where('student',$src['studentid'])
                    ->field('id,kaoshi,school,ruxuenian,banji,paixu,student')
                    ->with([
                        'cjSchool'=>function($query){
                            $query->field('id,jiancheng');
                        }
                        ,'cjKaoshi'=>function($query)
                        {
                            $query->field('id,title,category,zuzhi,bfdate,enddate')
                                ->with([
                                    'ksCategory'=>function($query){
                                        $query->field('id,title');
                                    }
                                    ,'ksZuzhi'=>function($query)
                                    {
                                        $query->field('id,title,jiancheng');
                                    }
                                ]);
                        }
                        ,'ksChengji'
                    ])
                    ->append(['banjiTitle'])
                    ->select();

        // 获取符合条件记录总数
        $cnt = $khList->count();
        // 获取当前页数据
        $limit_start = $src['page'] * $src['limit'] - $src['limit'];
        $limit_length = $src['limit'];
        $khList = $khList->slice($limit_start,$limit_length);

        // 重组返回内容
        $data = [
            'code'=> 0 , // ajax请求次数，作为标识符
            'msg'=>"",  // 获取到的结果数(每页显示数量)
            'count'=>$cnt, // 符合条件的总数据量
            'data'=>$khList, //获取到的数据结果
        ];


        return json($data);
    }




    // 修改学生信息
    public function edit($id)
    {

        // 获取学生信息
        $list['data'] = STU::field('id,xingming,sex,shenfenzhenghao,shengri,banji,school,kaoshi,status')
            ->with([
                    'stuBanji'=>function($query){
                        $query->field('id,ruxuenian,paixu')->append(['banTitle']);
                    }
                ])
            ->find($id)->toArray();

        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'编辑学生',
            'butname'=>'修改',
            'formpost'=>'PUT',
            'url'=>'/renshi/student/update/'.$id,
        );


        // 模板赋值
        $this->view->assign('list',$list);
        // 渲染
        return $this->view->fetch('create');
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

        $stu = new STU();

        $stuinfo = $stu::withTrashed()
                    ->where('shenfenzhenghao',$list['shenfenzhenghao'])
                    ->where('id','<>',$id)
                    ->with([
                        'stuSchool'=>function($query){
                            $query->field('title,jiancheng,id');
                        },
                        'stuBanji'
                    ])
                    ->find();


        if($stuinfo){
            return json(['msg'=>'此身份证号与　'.$stuinfo->stuSchool->jiancheng.':'.$stuinfo->xingming.'　重复。','val'=>0]);
        }

        // 更新数据
        $stu = new STU();
        $data = $stu::update($list,['id'=>$id]);

        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'更新成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

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

        $id = explode(',', $id);

        $data = STU::destroy($id);

        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'删除成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }


    // 恢复删除
     public function reDel($id)
    {

        $user = STU::onlyTrashed()->find($id);
        $data = $user->restore();


        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'恢复成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

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

    // // 批量添加
    // public function createAll()
    // {
    //     // 设置页面标题
    //     $list['set'] = array(
    //         'webtitle'=>'批量上传学生信息',
    //         'butname'=>'批传',
    //         'formpost'=>'POST',
    //         'url'=>'saveall',
    //     );

    //     // 模板赋值
    //     $this->view->assign('list',$list);
    //     // 渲染
    //     return $this->view->fetch();
    // }

    // 批量保存
    // public function saveAll()
    // {
    //     // 获取表单数据
    //     $list = request()->only(['school','url'],'post');

    //     // 实例化操作表格类
    //     $excel = new Myexcel();

    //     // 读取表格数据
    //     $stuinfo = $excel->readXls(public_path().'public\\uploads\\'.$list['url']);

    //     // 判断表格是否正确
    //     if($stuinfo[0][0] != "学生信息上传模板" )
    //     {
    //         $data = array('msg'=>'请使用模板上传','val'=>0,'url'=>null);
    //         return json($data);
    //     }
        
    //     // 删除标题行
    //     array_splice($stuinfo,0,3);

    //     // 实例化班级数据模型
    //     $banji = new \app\teach\model\Banji;
    //     $njlist = nianjilist();
    //     $bjlist = banjinamelist();


    //     $i = 0;
    //     $bfbanji = '';
    //     $bj = '';
    //     $students = array();
    //     // 重新计算组合数据，如果存在数据则更新数据
    //     foreach ($stuinfo as $key => $value) {
    //         //  如果姓名、身份证号为空则跳过
    //         if(empty($value[1]) || empty($value[2]))
    //         {
    //             continue;
    //         }
    //         // 判断本行班级与上行班级数据是否相等，如果不相等则从数据库查询班级ID
    //         if($bfbanji != $value[3])
    //         {
    //             // 获取入学年与排序
    //             $paixu = array_search(substr($value[3],9),$bjlist);
    //             $ruxuenian = array_search(substr($value[3],0,9),$njlist);
    //             // 查询班级ID
    //             $bj = $banji::where('school',$list['school'])
    //                 ->where('ruxuenian',$ruxuenian)
    //                 ->where('paixu',$paixu)
    //                 ->value('id');
    //             // 如果班级ID为空，删除数据并跳出当前循环
    //             if( empty($bj) )
    //             {
    //                 continue;
    //             }
    //         }
    //         $bfbanji = $value[3];

    //         // 各变量赋值
    //         $students[$i]['banji'] = $bj;
    //         $students[$i]['xingming'] = $value[1];
    //         $students[$i]['shenfenzhenghao'] = strtoupper($value[2]);
    //         intval(substr($value[2],16,1) )% 2 ? $students[$i]['sex'] = 1 :$students[$i]['sex'] = 0 ;
    //         $students[$i]['shengri'] = substr($value[2],6,4).'-'.substr($value[2],10,2).'-'.substr($value[2],12,2);
    //         $students[$i]['school'] = $list['school'];
    //         $stuid = STU::withTrashed()->where('shenfenzhenghao',$value[2])->find();
    //         if($stuid)
    //         {
    //             if($stuid->delete_time>0)
    //             {
    //                 $stuid->restore();
    //             }
    //             if($stuid->status == 0)
    //             {
    //                 $stuid->status = 1;
    //                 $stuid->save();
    //             }
    //             $students[$i]['id'] = $stuid->id;
    //         }
    //         // 销毁无用变量
    //         $i++;
    //     }
       
        
    //     // 实例化学生信息数据模型
    //     $student = new STU();

    //     // 保存或更新信息
    //     $data = $student->saveAll($students);

    //     $data ? $data = ['msg'=>'数据同步成功','val'=>1] : ['msg'=>'数据同步失败','val'=>0];
        
    //     return json($data);
    // }



    // 使用上传的表格进行校对，表格中不存在的数据删除
    public function createAll()
    {

        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'校对学生名单',
            'butname'=>'校对',
            'formpost'=>'POST',
            'url'=>'/renshi/student/saveall',
        );

        // 模板赋值
        $this->view->assign('list',$list);
        // 渲染
        return $this->view->fetch('create_all');
    }


    // 使用上传的表格进行校对，表格中不存在的数据删除
    public function saveAll()
    {
        // 获取表单数据
        $list = request()->only(['school','url'],'post');

        // 实例化操作表格类
        $excel = new Myexcel();

        // 读取表格数据
        $stuinfo = $excel->readXls(public_path().'public\\uploads\\'.$list['url']);


        // 判断表格是否正确
        if($stuinfo[0][2] != "序号" && $stuinfo[1][2] != "姓名" && $stuinfo[2][2] != "身份证号")
        {
            $this->error('请使用模板上传','/login/err');
            return json($data);
        }
        
        // 删除标题行
        array_splice($stuinfo,0,3);


        $stuinfo = array_filter($stuinfo,function($q){
            return $q[1] != null && strlen($q[2]) >=6 && $q[3] != null;
        });


        // 获取班级对应的入学年和排序 
        $bj = array_column($stuinfo, 3);

        // 获取班级名
        $bjStrName = array_unique($bj);

        // 实例化学生数据模型
        $stu = new STU;
        // 声明数据，记录要删除学生ID
        $delarr = array();


        // 循环班级数组，查询数据，进行对比，并返回结果。
        foreach ($bjStrName as $key => $value) {

            $myStuList = array();
            // 获取电子表格中本班级学生名单
            $myStuList = array_filter($stuinfo,function($q) use ($value){
                return $q[3] == $value;
            });


            $xlsStuList = array_column($myStuList, 2,0);
            $xlsStuList = array_map('strtoupper', $xlsStuList);  # 将大写字母转换成小写字母
            $xlsStuList = array_map('trim', $xlsStuList);  # 将大写字母转换成小写字母


            $bjid = strBjmArray($value,$list['school']);
            if($bjid == null)
            {
                continue;
            }

            $serStulist = $stu::withTrashed()
                        ->where('banji',$bjid)
                        ->field('id,xingming,shenfenzhenghao,sex')
                        ->select();
            $sfzh = $serStulist->column('shenfenzhenghao');

            // 返回数据对比结果 
            $jiaoji = array_intersect($xlsStuList, $sfzh);  #返回交集
            $add = array_diff($xlsStuList, $sfzh);
            $del = array_diff($sfzh, $xlsStuList);


            // 从新增的数据中查找是否有已经存在，但是班级不正确的信息。
            $add_temp = $stu::withTrashed()
                        ->where('shenfenzhenghao','in',$add)
                        ->field('shenfenzhenghao')
                        ->column('shenfenzhenghao','id');

            foreach ($add_temp as $key => $val) {
                // 这个地方在大小写不一致的时候容易出错，需要将小写转换成大写
                $k = array_search($val, $xlsStuList);
                $jiaoji[$k]=$val;
            }
            $add = array_diff($add, $add_temp);



            // 针对不同数据进行不同操作
            // 更新数据
            foreach ($jiaoji as $key => $val) {
                $oneStu = $stu::withTrashed()
                    ->where('shenfenzhenghao',$val)
                    ->field('id,xingming,banji,school,delete_time')
                    ->find();

                $oneStu->restore();
                $oneStu->xingming = $myStuList[$key-1][1];
                $oneStu->school = $list['school'];
                $oneStu->banji = $bjid;
                $oneStu->save();
            }



            // 新增数据
            $data = array();
            foreach ($add as $key => $val) {
                $sfzhval = strtoupper(trim($myStuList[$key-1][2]));
                if(strlen($sfzhval) == 18)
                {
                    intval(substr($sfzhval,16,1) )% 2 ? $sex = 1 :$sex = 0 ;
                    $data[] = [
                        'xingming'=>$myStuList[$key-1][1],
                        'shenfenzhenghao'=>$sfzhval,
                        'banji'=>$bjid,
                        'school'=>$list['school'],
                        'shengri' => substr($sfzhval,6,4).'-'.substr($sfzhval,10,2).'-'.substr($sfzhval,12,2),
                        'sex' =>$sex,
                    ];
                }else{
                    $data[] = [
                        'xingming'=>$myStuList[$key-1][1],
                        'shenfenzhenghao'=>$sfzhval,
                        'banji'=>$bjid,
                        'school'=>$list['school'],
                        'shengri' => '1970-1-1',
                        'sex' =>2,
                    ];
                }
            }
            $stu->saveAll($data);


            // 记录要删除的学生ID数据
            foreach ($del as $key => $val){
                array_push($delarr,$serStulist[$key]->id);
            }
        }




        // 获取学校名称
        $sch = new \app\system\model\school;
        $sch = $sch::where('id',$list['school'])->value('jiancheng');

        // 查询要删除的学生信息
        $del = $stu::where('id','in',$delarr)
                ->field('id,xingming,banji,sex')
                ->with([
                    'stuBanji'=>function($query){
                        $query->field('id,ruxuenian,paixu')->append(['banjiTitle']);
                    }
                ])
                ->select();


        // 导出要删除的信息
        // 创建表格
        set_time_limit(0);
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet;
        $sheet = $spreadsheet->getActiveSheet();
        // 设置表头信息
        $sheet->setCellValue('A1', $sch.'需要删除学生名单');
        $sheet->setCellValue('A2', '此表中学生名单是系统中比上传名单中多的数据，是否删除请结合实际情况');
        $sheet->setCellValue('A3', '序号');
        $sheet->setCellValue('B3', 'ID');
        $sheet->setCellValue('C3', '班级');
        $sheet->setCellValue('D3', '姓名');
        $sheet->setCellValue('E3', '性别');

        // 定义数据起始行号
        $i = 4;

        foreach ($del as $key => $val) {
            $j = $i+$key;
            $sheet->setCellValue('A'.$j, $key+1);
            $sheet->setCellValue('B'.$j, $val->id);
            $sheet->setCellValue('C'.$j, $val->stuBanji->banjiTitle);
            $sheet->setCellValue('D'.$j, $val->xingming);
            $sheet->setCellValue('E'.$j, $val->sex);
        }


        // 保存文件
        $filename = $sch.'删除学生名单'.date('ymdHis').'.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        ob_flush();
        flush();

    }


    // 使用上传的表格进行校对，表格中不存在的数据删除
    public function deletes()
    {
        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'根据表格删除学生信息',
            'butname'=>'删除',
            'formpost'=>'POST',
            'url'=>'/renshi/student/deleteall',
        );

        // 模板赋值
        $this->view->assign('list',$list);
        // 渲染
        return $this->view->fetch();
    }


    // 使用上传的表格进行校对，表格中不存在的数据删除
    public function deleteXlsx()
    {
        // 获取表单数据
        $list = request()->only(['url'],'post');

        // 实例化操作表格类
        $excel = new Myexcel();

        // 读取表格数据
        $stuinfo = $excel->readXls(public_path().'public\\uploads\\'.$list['url']);


        // 判断表格是否正确
        if($stuinfo[0][2] != "序号" && $stuinfo[1][2] != "ID" && $stuinfo[2][2] != "班级" && $stuinfo[3][2] != "姓名")
        {
            $data = array('msg'=>'请使用模板上传','val'=>0,'url'=>null);
            return json($data);
        }
        
        // 删除标题行
        array_splice($stuinfo,0,3);

        $stuinfo = array_filter($stuinfo,function($q){
            return $q[1] != null && $q[2] != null && $q[3] != null;
        });


        // 获取班级对应的入学年和排序 
        $stuids = array_column($stuinfo, 1);

        
        // 实例化学生数据模型
        $stu = new STU;

        $data = $stu::destroy(function($query) use($stuids){
            $query->where('id','in',$stuids);
        });

        $data ? $data = ['msg'=>'数据同步成功','val'=>1] : ['msg'=>'数据同步失败','val'=>0];

        return json($data);
    }

    

    // // 上传文件
    // public function upload()
    // {
    //     // 获取文件信息
    //     $list['text'] = $this->request->post('text');
    //     $list['serurl'] = $this->request->post('serurl');

    //     // 获取表单上传文件
    //     $file = request()->file('file');
    //     // 上传文件并返回结果
    //     $data = upload($list,$file,true);

    //     return json($data);
    // }



    // 下载表格模板
    public function download()
    {
        $url = public_path().'public\\uploads\\student\\student_template.xlsx';
        return download($url,'学生名单模板.xlsx');
    }


    // 根据教师姓名、首拼、全拼搜索教师信息
    public function srcStudent()
    {
        // 声明结果数组
        $data = array();

        $str = input("post.str");
        $banji = input("post.banji");

        // 判断是否存在数据，如果没有数据则返回。
        if(strlen($str) <= 0){
            return json($data);
        }

        // 如果有数据则查询教师信息
        $list = STU::field('id,xingming,school,shengri,sex')
                    ->whereOr('xingming','like','%'.$str.'%')
                    ->when(strlen($banji),function($query)use($banji){
                        $query->where('banji',$banji);
                    })
                    ->with(
                        [
                            'stuSchool'=>function($query){
                                $query->field('id,jiancheng');
                            },
                            'stuBanji'=>function($query){
                                $query->field('id,jiancheng');
                            },
                        ]
                    )
                    ->append(['age'])
                    ->select();
        return json($list);
    }




}
