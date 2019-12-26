<?php
namespace app\chengji\controller;

// 引用控制器基类
use app\BaseController;
// 引用成绩数据模型
use app\chengji\model\Chengji;
// 引用考号数据模型
use \app\kaoshi\model\Kaohao;
// 引用学科数据模型
use \app\teach\model\Subject;


class Index extends BaseController
{
    // 使用二维码录入成绩
    public function malu()
    {
    	// 设置页面标题
        $list['set'] = array(
            'webtitle'=>'扫码录成绩',
            'butname'=>'录入',
            'formpost'=>'PUT',
            'url'=>'/chengji/malu',
        );


        // 模板赋值
        $this->view->assign('list',$list);
        // 渲染
        return $this->view->fetch();
    }

    // 保存使用二维码录入的成绩
    public function malusave()
    {   
        // 获取表单数据
        $list = $this->request->only(['kaohao_id','subject_id','defen'],'post');

        $kaoshiid = Kaohao::where('id',$list['kaohao_id'])->value('kaoshi');

        // 成绩验证
        $manfen =  getmanfen($kaoshiid,$list['subject_id']);
        $mfyz = manfenvalidate($list['defen'],$manfen);
        if($mfyz['val'] == 0)
        {
            return json($mfyz);
        }

        // 更新成绩
        $cjone = Chengji::withTrashed()
                ->where('subject_id',$list['subject_id'])
                ->where('kaohao_id',$list['kaohao_id'])
                ->find();

        if($cjone)
        {
            // 如果存在则更新记录
            if($cjone->defen != $list['defen'] || $cjone->delete_time > 1)
            {
                $cjone->defen = $list['defen'];
                $cjone->delete_time = null;
                $data = $cjone->save();
            }
        }else{
            $data = [
                'kaohao_id'=>$list['kaohao_id'],
                'subject_id'=>$list['subject_id'],
                'user_id'=>session('userid'),
                'defen'=>$list['defen']
            ];
            $data = Chengji::create($data);
        }


        $data ? $data=['msg'=>'更新成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        return json($data);
    }


    // 学生成绩表中修改成绩
    public function update($id)  #id为考号ID
    {
        // 获取表单数据
        $list = $this->request->only(
            ['colname',
            'newdefen']
            ,'post');
        $list['kaohao_id'] = $id;


        // 获取学科id
        $subject = new \app\teach\model\Subject;
        $subject_id = $subject->where('lieming',$list['colname'])->value('id');

        // 获取考试ID
        $kaoshiid = Kaohao::where('id',$list['kaohao_id'])->value('kaoshi');

        // 成绩验证
        $manfen =  getmanfen($kaoshiid,$subject_id);
        $mfyz = manfenvalidate($list['newdefen'],$manfen);
        if($mfyz['val'] == 0)
        {
            return json($mfyz);
        }



        // 更新成绩 
        $cjinfo = Chengji::withTrashed()
                    ->where('kaohao_id',$list['kaohao_id'])
                    ->where('subject_id',$subject_id)
                    ->find();

        // 如果存在成绩则更新，不存在则添加
        if($cjinfo){
            if($cjinfo->defen != $list['newdefen'] || $cjinfo->delete_time > 1)
            {
                $cjinfo->defen = $list['newdefen'];
                $cjinfo->delete_time = null;
                $data = $cjinfo->save();
            }
        }else{
            $data = [
                'kaohao_id'=>$list['kaohao_id'],
                'subject_id'=>$subject_id,
                'user_id'=>session('userid'),
                'defen'=>$list['newdefen']
            ];
            $data = Chengji::create($data);
        }

        // 判断返回内容
        $data || $cjinfo ? $data=['msg'=>'录入成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回更新结果
        return json($data);
    }


    
    // 根据考号获取学生信息
    public function read()
    {
        // 获取表单数据
        $val = input('post.val');
        // 实例化系统设置类
        $md5 = new \app\system\controller\Encrypt; 

        $val = $md5->decrypt($val,'dlbz');
        $list = explode('|',$val);
        $sbj = $list[1];

        $cjlist = Kaohao::where('id',$list[0])
                ->field('id,banji,school,student')
                ->with([
                    'ksChengji'=>function($q) use($sbj){
                        $q->where('subject_id',$sbj)
                            ->field('kaohao_id,subject_id,defen');
                    }
                    ,'cjBanji'=>function($q){
                        $q->field('id,paixu,ruxuenian')
                            ->append(['numTitle','banjiTitle']);
                    }
                    ,'cjSchool'=>function($q){
                        $q->field('id,jiancheng');
                    }
                    ,'cjStudent'=>function($q){
                        $q->field('id,xingming');
                    }
                ])
                ->find();
        if($cjlist->cjStudent == Null)
        {
            $stu = new \app\renshi\model\Student;
            $stuinfo = $stu::withTrashed()
                            ->where('id',$cjlist->student)
                            ->field('id,xingming,sex')
                            ->find();
            $cjlist->cjStudent = array(
                'id'=>$stuinfo->id,
                'xingming'=>$stuinfo->xingming
            );
        }
        $cjlist->sbj = Subject::where('id',$sbj)->field('id,title')->find();

        // 获取列名
        return json($cjlist);
    }


    // 表格录入成绩上传页面
    public function biaolu()
    {
        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'表格录入成绩',
            'butname'=>'批传',
            'formpost'=>'POST',
            'url'=>'/chengji/index/saveall',
        );

        // 模板赋值
        $this->view->assign('list',$list);
        // 渲染
        return $this->view->fetch();
    }

    

    // 保存表格批量上传的成绩 
    public function saveAll()
    {
        set_time_limit(0);
        // 获以电子表格存储位置
        $url = input('post.url');

        // 实例化操作表格类
        $excel = new \app\renshi\controller\Myexcel;

        // 读取表格数据
        $cjinfo = $excel->readXls(public_path().'public\\uploads\\'.$url);

        $kaoshiid = $cjinfo[1][0];  #获取考号

        // 删除空单元格得到学科列名数组
        array_splice($cjinfo[1],0,4);
        $xk = $cjinfo[1];

        // 删除成绩采集表无用的标题行得到成绩数组
        array_splice($cjinfo,0,3);

        // 查询考试信息
        $kh = new Kaohao;
        // $ks = new \app\kaoshi\model\Kaoshi;


        $user_id = session('userid');   # 获取用户id
        $data = array();


        // 重新组合数组
        foreach ($xk as $key => $value) {
            // 获取成绩满分
            $manfen =  getmanfen($kaoshiid,$value);
            # code...
            foreach ($cjinfo as $k => $val) {
                $defen = $val[$key+4];    # 当前学生当前学科成绩
                // 如果不存在值，跳过这次循环
                if($defen === null){
                    continue;
                }
                // 验证成绩格式，如果不对则跳过
                $mfyz = manfenvalidate($defen,$manfen);
                if($mfyz['val'] == 0)
                {
                    continue;
                }

                // 添加或更新数据
                $cjone = Chengji::withTrashed()
                        ->where('kaohao_id',$val[1])
                        ->where('subject_id',$value)
                        ->find();
                // 判断成绩是否存在
                if($cjone)
                {
                    // 如果存在则更新记录
                    if($cjone->defen != $defen || $cjone->delete_time > 1)
                    {
                        $cjone->defen = $defen;
                        $cjone->delete_time = null;
                        $cjone->save();
                    }
                }else{
                    // 如果不存在则新增记录
                    $data = [
                        'kaohao_id'=>$val[1],
                        'subject_id'=>$value,
                        'user_id'=>$user_id,
                        'defen'=>$defen
                    ];
                    Chengji::create($data);
                }
            }
        }


        // 判断成绩更新结果
        $data=['msg'=>'成绩导入成功','val'=>1];

        ob_flush();
        flush();
        // 返回成绩结果
        return json($data);
    }


    // 上传成绩采集表格
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


    // 成绩列表
    public function index($kaoshi)
    {
        
         // 设置要给模板赋值的信息
        $list['webtitle'] = '学生成绩列表';

        // 实例化考试数据模型
        $ks = new \app\kaoshi\model\Kaoshi;
        $ksinfo = $ks->where('id',$kaoshi)
                    ->field('id')
                    ->with([
                        'ksSubject'=>function($query){
                            $query->field('kaoshiid,subjectid')
                                ->with(['subjectName'=>function($q){
                                    $q->field('id,title,lieming');
                                }]
                            );
                        }
                        ,'ksNianji'
                    ])
                    ->find();



        $list['subject'] = $ksinfo->ksSubject->toArray();
        $list['kaoshi'] = $kaoshi;
        $list['dataurl'] = '/chengji/index/data';
        if(count($ksinfo->ks_nianji)>0)
        {
            $list['nianji'] = $ksinfo->ks_nianji[0]->nianji;
        }else{
            $list['nianji'] = "一年级";
        }


        // 模板赋值
        $this->view->assign('list',$list);

        // 渲染模板
        return $this->view->fetch();
    }



    // 获取成绩信息
    public function ajaxData()
    {
        // 获取参数
        $src = $this->request
                ->only(['page','limit','field','type','kaoshi','school','ruxuenian','paixu','searchval'
                ],'POST');

        $src['school'] = strToarray($src['school']);

        // 获取参与考试的班级
        $kh = new \app\kaoshi\model\Kaohao;
        $src['banji']= array_column($kh->cyBanji($src), 'id');

       
        // 实例化
        $cj = new Chengji;

        // 查询要显示的数据
        $data = $cj->search($src);



        // 获取符合条件记录总数
        $cnt = count($data);
        // 获取当前页数据
        $limit_start = $src['page'] * $src['limit'] - $src['limit'];
        $limit_length = $src['limit'];
        $data = array_slice($data,$limit_start,$limit_length);
       
        // 重组返回内容
        $data = [
            'code'=> 0 , // ajax请求次数，作为标识符
            'msg'=>"",  // 获取到的结果数(每页显示数量)
            'count'=>$cnt, // 符合条件的总数据量
            'data'=>$data, //获取到的数据结果
        ];


        return json($data);
    }




    // // 删除成绩
    // public function deletecj($id)
    // {

    //     // 声明要删除成绩数组
    //     $data = array();

    //     if($id == 'm')
    //     {
    //         $id = request()->delete('ids/a');// 获取delete请求方式传送过来的数据并转换成数据
    //         $i=0;
    //         foreach ($id as $key => $value) {
    //             $data[$i]['id'] = $value;
    //             $data[$i]['yuwen'] = Null;
    //             $data[$i]['shuxue'] = Null;
    //             $data[$i]['wanyu'] = Null;
    //         }
    //     }else{
    //         $data[0]['id'] = $id; 
    //         $data[0]['yuwen'] = Null;
    //         $data[0]['shuxue'] = Null;
    //         $data[0]['waiyu'] = Null;
    //         $data[0]['stuSum'] = Null;
    //         $data[0]['stuAvg'] = Null;
    //     }


    //     $cj = new Chengji();
    //     $data = $cj->saveAll($data);

    //     // 根据更新结果设置返回提示信息
    //     $data ? $data=['msg'=>'成绩删除成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

    //     // 返回信息
    //     return json($data);
    // }


    // 批量删除成绩
    public function deletecjs($kaoshi)
    {

        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'批量删除成绩',
            'butname'=>'删除',
            'formpost'=>'POST',
            'url'=>'/chengji/index/deletecjmore',
            'kaoshi'=>$kaoshi
        );

        $ks = new \app\kaoshi\model\Kaoshi;
        $subject = $ks
                        ->where('id',$kaoshi)
                        ->with([
                            'ksSubject'=>function($query){
                                $query->field('kaoshiid,subjectid')
                                    ->with(['subjectName'=>function($q){
                                        $q->field('id,title');
                                    }]
                                );
                            }
                        ])
                        ->find()
                        ->toArray();
        $list['subject'] = $subject['ksSubject'];

        // 模板赋值
        $this->view->assign('list',$list);
        // 渲染
        return $this->view->fetch();
    }


    // 按条件删除成绩
    public function deletecjmore()
    {
        // 获取参数
        $src = $this->request
                ->only(['kaoshi','banji','subject'],'POST');
        $banji = $src['banji'];
        $subject = $src['subject'];

        // 获取要删除成绩的考号
        $kaohao = new \app\kaoshi\model\Kaohao;
        $kaohaolist = $kaohao::where('kaoshi',$src['kaoshi'])
                            ->where('banji','in',$src['banji'])
                            ->column('id');

        // 删除成绩
        $data = Chengji::destroy(function($query) use ($kaohaolist,$subject){
            $query->where('kaohao_id','in',$kaohaolist)
                  ->where('subject_id','in',$subject);
        });

        if($data){
            $this->success($msg = '删除成功',  $url = '/chengji/index/deletecjs/'.$src['kaoshi'], $data = '',  $wait = 3,  $header = []);
        }else{
            $this->error($msg = '删除失败',  $url = '/chengji/index/deletecjs/'.$src['kaoshi'], $wait = 3);
        }
        
        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'成绩删除成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }





    // 删除单人单科成绩
    public function delete($id)
    {

        if($id == 'm')
        {
            $id = request()->delete('ids');// 获取delete请求方式传送过来的数据并转换成数据
        }

        $id = explode(',', $id);

        $data = Chengji::destroy($id);

        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'删除成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }





    // 设置成绩状态
    public function setStatus()
    {

        //  获取id变量
        $id = request()->post('id');
        $value = request()->post('value');

        // 获取班级信息
        $data = Chengji::where('id',$id)->update(['status'=>$value]);

        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'状态设置成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }






    // 下载成绩表格
    public function dwChengji($kaoshi)
    {

        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'成绩下载',
            'butname'=>'下载',
            'formpost'=>'POST',
            'url'=>'/chengji/index/dwxlsx',
            'kaoshi'=>$kaoshi
        );

        // 模板赋值
        $this->view->assign('list',$list);
        // 渲染
        return $this->view->fetch();
    }





    //生成学生表格
    public function dwchengjixlsx()
    {
        // 获取参数
        $src = $this->request
                ->only([
                    'kaoshi'=>'1',
                    'banji'=>array(),
                    'school',
                    'ruxuenian'
                ],'POST');


        // 获取要下载成绩的学校和年级信息
        $school = new \app\system\model\School;
        $schoolname = $school->where('id',$src['school'])->value('jiancheng');

        // 实例化验证模型
        $validate = new \app\chengji\validate\Cjdownload;
        // 验证表单数据
        $result = $validate->check($src);
        $msg = $validate->getError();

        // 如果验证不通过则停止保存
        if(!$result){
            $this->error($msg);
        }

        $src['school'] = strToarray($src['school']);

        // 获取参与考试的班级
        $kh = new \app\kaoshi\model\Kaohao;
        $src['banji']= array_column($kh->cyBanji($src), 'id');


        // 获取数据库信息
        $kh = new Kaohao();
        // $src = [
        //     'kaoshi'=>$list['kaoshi'],
        //     'banji'=>$list['banji'],
        // ];
        $chengjiinfo = $kh->srcChengji($src);


        // 获取考试标题
        $ks = new \app\kaoshi\model\Kaoshi;
        $ks = $ks->where('id',$src['kaoshi'])
                ->field('id,title,bfdate')
                ->with([
                    'ksSubject'=>function($query){
                        $query->field('kaoshiid,subjectid')
                            ->with(['subjectName'=>function($q){
                                $q->field('id,title,lieming');
                            }]
                        );
                    }
                ])
                ->find();
        // 获取考试年级名称
        $njlist = nianjiList($ks->getData('bfdate'));
        $nianji = $njlist[$src['ruxuenian']];

        $tabletitle =$ks->title.' '.$schoolname.' '.$nianji.' '.'学生成绩详细列表';

        $colname = excelLieming();

        set_time_limit(0);
        // 创建表格
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet;
        $sheet = $spreadsheet->getActiveSheet();
        

        // 设置表头信息
        $sheet->setCellValue('A1', $tabletitle);
        $sheet->setCellValue('A2', '序号');
        $sheet->setCellValue('B2', '班级');
        $sheet->setCellValue('C2', '姓名');
        $sheet->setCellValue('D2', '性别');
        $i = 4;
        foreach ($ks->ks_subject as $key => $value) {
            $sheet->setCellValue($colname[$i].'2', $value->subject_name->title);
            $i++;
        }
        $sheet->setCellValue($colname[$i].'2', '平均分');
        $sheet->setCellValue($colname[$i+1].'2', '总分');
        $i=$i+4;
        $sheet->setCellValue($colname[$i].'2', '项目');
        $sheet->setCellValue($colname[$i].'3', '人数');
        $sheet->setCellValue($colname[$i].'4', '平均分');
        $sheet->setCellValue($colname[$i].'5', '优秀率%');
        $sheet->setCellValue($colname[$i].'6', '及格率%');
        $sheet->setCellValue($colname[$i].'7', '标准差');
        $i++;
        foreach ($ks->ks_subject as $key => $value) {
            $sheet->setCellValue($colname[$i].'2', $value->subject_name->title);
            $i++;
        }
        $sheet->setCellValue($colname[$i+1].'2', '总平均分');
        $sheet->setCellValue($colname[$i+2].'2', '全科及格率%');
        

        // 循环写出成绩及个人信息
        $i = 3;
        foreach ($chengjiinfo as $key => $value) {
                // 表格赋值
                $sheet->setCellValue('A'.$i, $i-2);
                $sheet->setCellValue('B'.$i, $value['banji']);
                $sheet->setCellValue('C'.$i, $value['student']);
                $sheet->setCellValue('D'.$i, $value['sex']);
                $colcnt = 4;
                foreach ($ks->ks_subject as $k => $val) {
                    if(isset($value[$val->subject_name->lieming]))
                    {
                        $sheet->setCellValue($colname[$colcnt].$i, $value[$val->subject_name->lieming]);
                    }
                    $colcnt++;
                }
                $sheet->setCellValue($colname[$colcnt].$i, $value['avg']);
                $sheet->setCellValue($colname[$colcnt+1].$i, $value['sum']);
                $i++;
        }

        $tj = new \app\chengji\model\Tongji;
        $nianji = array();
        $chengjiinfo = $kh->srcChengji($src);
        $temp = $tj->tongji($chengjiinfo,$src['kaoshi']);
        isset($colcnt) ? $colcnt = $colcnt+5 : $colcnt = 12;
        // 循环写出统计结果
        foreach ($ks->ks_subject as $key => $value) {
            $sheet->setCellValue($colname[$colcnt].'3', $temp[$value->subject_name->lieming]['xkcnt']);
            $sheet->setCellValue($colname[$colcnt].'4', $temp[$value->subject_name->lieming]['avg']);
            $sheet->setCellValue($colname[$colcnt].'5', $temp[$value->subject_name->lieming]['youxiu']);
            $sheet->setCellValue($colname[$colcnt].'6', $temp[$value->subject_name->lieming]['jige']);
            $sheet->setCellValue($colname[$colcnt].'7', $temp[$value->subject_name->lieming]['biaozhuncha']);
            $colcnt++;
        }

        $sheet->setCellValue($colname[$colcnt+1].'3', $temp['avg']);
        $sheet->setCellValue($colname[$colcnt+2].'3', $temp['rate']);


        // 保存文件
        $filename = $tabletitle.date('ymdHis').'.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        ob_flush();
        flush();
    }





    // 学生成绩录入信息
    public function readAdd($kaohao)
    {

        // 设置要给模板赋值的信息
        $list['webtitle'] = '查看成绩录入信息';
        $list['kaohao'] = $kaohao;
        $list['dataurl'] = '/chengji/index/dataadd';

        // 模板赋值
        $this->view->assign('list',$list);

        // 渲染模板
        return $this->view->fetch();
    }





    // ajax获取学生成绩录入信息
    public function ajaxaddinfo()
    {
        // 获取参数
        $src = $this->request
                ->only([
                    'page'=>'1',
                    'limit'=>'10',
                    'field'=>'subject_id',
                    'type'=>'desc',
                    'kaohao'=>''
                ],'POST');

        $chengji = new Chengji;

        $data = $chengji
                ->where('kaohao_id',$src['kaohao'])
                ->field('id,kaohao_id,subject_id,user_id,defen,update_time')
                ->order([$src['field']=>$src['type']])
                ->with([
                    'subjectName'=>function($query){
                        $query->field('id,title');
                    },
                    'userName'=>function($query){
                        $query->field('id,school,xingming')
                            ->with([
                                'adSchool'=>function($query){
                                    $query->field('id,jiancheng');
                                }
                            ]);
                    }
                ])
                ->select();


        $cnt = count($data);

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

      
}
