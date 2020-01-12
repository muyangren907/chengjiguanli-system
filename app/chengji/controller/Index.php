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
        if(count($ksinfo->ksNianji)>0)
        {
            $list['nianji'] = $ksinfo->ksNianji[0]->nianji;
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


    // 批量删除成绩
    public function deletecjs($kaoshi)
    {

        // 判断考试结束时间是否已过
        $enddate = kaoshiDate($kaoshi,'enddate');
        if($enddate === true)
        {
            $this->error('考试时间已过，不能删除成绩','/login/err');
        }

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

        $khid = Chengji::where('id',$id['0'])->value('kaohao_id');
        $kaoshiid = Kaohao:: where('id',$khid)->value('Kaoshi');

        // 判断考试结束时间是否已过
        $enddate = kaoshiDate($kaoshiid,'enddate');
        if($enddate === true)
        {
            $this->error('考试时间已过，不能删除成绩','/login/err');
        }

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

        // set_time_limit(0);
        // 创建表格
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet;
        $sheet = $spreadsheet->getActiveSheet();
        $thistime = date("Y-m-d h:i:sa");
        // 设置文档属性
        $spreadsheet->getProperties()
            ->setCreator("尚码成绩管理系统")    //作者
            ->setTitle("尚码成绩管理")  //标题
            ->setLastModifiedBy(session('username')) //最后修改者
            ->setDescription("该表格由".session('username').session('id')."于".$thistime."在尚码成绩管理系统中下载，只作为内部交流材料,不允许外泄。")  //描述
            ->setKeywords("尚码 成绩管理") //关键字
            ->setCategory("成绩管理"); //分类


        // 设置表头信息
        $sheet->setCellValue('A1', $tabletitle);
        $hb = 5 + $ks->ksSubject->count();
        $sheet->mergeCells('A1:'.$colname[$hb].'1');
        $sheet->setCellValue('A3', '序号');
        $sheet->setCellValue('B3', '班级');
        $sheet->setCellValue('C3', '姓名');
        $sheet->setCellValue('D3', '性别');
        $i = 4;
        foreach ($ks->ksSubject as $key => $value) {
            $sheet->setCellValue($colname[$i].'3', $value->subject_name->title);
            $i++;
        }
        $sheet->setCellValue($colname[$i].'3', '平均分');
        $sheet->setCellValue($colname[$i+1].'3', '总分');
        $i=$i+4;
        $sheet->setCellValue($colname[$i].'3', '项目');
        $sheet->setCellValue($colname[$i].'4', '人数');
        $sheet->setCellValue($colname[$i].'5', '平均分');
        $sheet->setCellValue($colname[$i].'6', '优秀率%');
        $sheet->setCellValue($colname[$i].'7', '及格率%');
        $sheet->setCellValue($colname[$i].'8', '标准差');
        $i++;
        foreach ($ks->ksSubject as $key => $value) {
            $sheet->setCellValue($colname[$i].'3', $value->subject_name->title);
            $i++;
        }
        

        // 循环写出成绩及个人信息
        $i = 4;
        foreach ($chengjiinfo as $key => $value) {
                // 表格赋值
                $sheet->setCellValue('A'.$i, $i-2);
                $sheet->setCellValue('B'.$i, $value['banji']);
                $sheet->setCellValue('C'.$i, $value['student']);
                $sheet->setCellValue('D'.$i, $value['sex']);
                $colcnt = 4;
                foreach ($ks->ksSubject as $k => $val) {
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

        // 居中
        $styleArrayJZ = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER, //垂直居中
            ],
        ];
        $sheet->getStyle('A1:'.$colname[$colcnt+1].($i-1))->applyFromArray($styleArrayJZ);

        // 加边框
        $styleArrayBK = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '00000000'],
                ],
            ],
        ];
        $sheet->getStyle('A3:'.$colname[$colcnt+1].($i-1))->applyFromArray($styleArrayBK);



        $tj = new \app\chengji\model\Tongji;
        $nianji = array();
        $chengjiinfo = $kh->srcChengji($src);
        $temp = $tj->tongjiSubject($chengjiinfo,$src['kaoshi']); 

        isset($colcnt) ? $colcnt = $colcnt+5 : $colcnt = 12;
        $colBiankuang = $colcnt;
        // 循环写出统计结果
        foreach ($ks->ksSubject as $key => $value) {
            $sheet->setCellValue($colname[$colcnt].'4', $temp['cj'][$value->subject_name->lieming]['xkcnt']);
            $sheet->setCellValue($colname[$colcnt].'5', $temp['cj'][$value->subject_name->lieming]['avg']);
            $sheet->setCellValue($colname[$colcnt].'6', $temp['cj'][$value->subject_name->lieming]['youxiu']);
            $sheet->setCellValue($colname[$colcnt].'7', $temp['cj'][$value->subject_name->lieming]['jige']);
            $sheet->setCellValue($colname[$colcnt].'8', $temp['cj'][$value->subject_name->lieming]['biaozhuncha']);
            $colcnt++;
        }

        $sheet->setCellValue($colname[$colBiankuang-1].'9', '总平均分');
        $sheet->setCellValue($colname[$colBiankuang].'9', $temp['cj']['all']['avg']);
        $sheet->mergeCells($colname[$colBiankuang].'9:'.$colname[$colcnt-1].'9');
        $sheet->setCellValue($colname[$colBiankuang-1].'10', '全科及格率');
        $sheet->setCellValue($colname[$colBiankuang].'10', $temp['cj']['all']['jige']);
        $sheet->mergeCells($colname[$colBiankuang].'10:'.$colname[$colcnt-1].'10');
        $sheet->getStyle($colname[$colBiankuang-1].'3:'.$colname[$colcnt-1].'10')->applyFromArray($styleArrayJZ);
        $sheet->getStyle($colname[$colBiankuang-1].'3:'.$colname[$colcnt-1].'10')->applyFromArray($styleArrayBK);

        // 修改标题字号
        $sheet->getStyle('A1')->getFont()->setBold(true)->setName('宋体')->setSize(16);
        // 设置行高
        $sheet->getDefaultRowDimension()->setRowHeight(22.5);
        $sheet->getRowDimension('1')->setRowHeight(25);
        // 设置列宽
        $sheet->getDefaultColumnDimension()->setWidth(9);
        $sheet->getColumnDimension('A')->setWidth(6);
        $sheet->getColumnDimension('B')->setWidth(12);
        $sheet->getColumnDimension($colname[$colBiankuang-1])->setWidth(13);


        // 页面设置
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
        $sheet->getPageMargins()->setTop(0.8);
        $sheet->getPageMargins()->setRight(0.2);
        $sheet->getPageMargins()->setLeft(0.2);
        $sheet->getPageMargins()->setBottom(0.8);
        // 打印居中
        $sheet->getPageSetup()->setHorizontalCentered(true);
        $sheet->getPageSetup()->setVerticalCentered(false);


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





    // 下载成绩表格
    public function dwChengjitiao($kaoshi)
    {

        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'成绩下载',
            'butname'=>'下载',
            'formpost'=>'POST',
            'url'=>'/chengji/index/dwcjtiaoxlsx',
            'kaoshi'=>$kaoshi
        );

        // 模板赋值
        $this->view->assign('list',$list);
        // 渲染
        return $this->view->fetch();
    }





    //生成学生成绩条表格
    public function dwchengjitiaoxlsx()
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

        // 获取当前年级成绩统计结果
        $kh = new Kaohao;
        $tj = new \app\chengji\model\Tongji;
        $srcAll = [
            'kaoshi'=>$src['kaoshi'],
            'ruxuenian'=>$src['ruxuenian']
        ];
        $srcAll['banji']= array_column($kh->cyBanji($srcAll), 'id');
        $chengjiinfo = $kh->srcChengji($src);

        $njtj = $tj->tongjiSubject($chengjiinfo,$src['kaoshi']);

        // 获取部分学生成绩
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

        $tabletitle =$ks->title.' '.$schoolname.' '.$nianji.' '.'学生成绩条';

        $colname = excelLieming();

        // set_time_limit(0);
        // 创建表格
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet;
        $sheet = $spreadsheet->getActiveSheet();
        $thistime = date("Y-m-d h:i:sa");
        // 设置文档属性
        $spreadsheet->getProperties()
            ->setCreator("尚码成绩管理系统")    //作者
            ->setTitle("尚码成绩管理")  //标题
            ->setLastModifiedBy(session('username')) //最后修改者
            ->setDescription("该表格由".session('username').session('id')."于".$thistime."在尚码成绩管理系统中下载，只作为内部交流材料,不允许外泄。")  //描述
            ->setKeywords("尚码 成绩管理") //关键字
            ->setCategory("成绩管理"); //分类
        
       
        $row = 1;   # 定义从 $row 行开始写入数据
        $rows = count($ks->ksSubject);  # 定义学生信息列要合并的行数

        // 给单元格加边框
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '00000000'],
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER, //垂直居中
            ],
        ];


        // 从这里开始循环写入学生成绩
        foreach ($chengjiinfo as $key => $value) {

            // 写入学生信息
            $sheet->setCellValue('A'.$row, '学校');
            $sheet->mergeCells('A'.($row+1).':'.'A'.($row+$rows)); # 输入学科名
            $sheet->setCellValue('A'.($row+1), $schoolname);
            $sheet->setCellValue('B'.$row, '班级');
            $sheet->mergeCells('B'.($row+1).':'.'B'.($row+$rows)); # 输入学科名
            $sheet->getStyle('B'.($row+1))->getAlignment()->setWrapText(true);
            $sheet->setCellValue('B'.($row+1), $value['banji']);
            $sheet->setCellValue('C'.$row, '姓名');
            $sheet->mergeCells('C'.($row+1).':'.'C'.($row+$rows)); # 输入学科名
            $sheet->setCellValue('C'.($row+1), $value['student']);
            $sheet->setCellValue('D'.$row, '学科');
            $sheet->setCellValue('E'.$row, '得分');
            $sheet->setCellValue('F'.$row, '平均分');
            $sheet->setCellValue('G'.$row, '优秀率%');
            $sheet->setCellValue('H'.$row, '及格率%');
            $sheet->setCellValue('I'.$row, '最高分');
            $sheet->setCellValue('J'.$row, '%75');
            $sheet->setCellValue('K'.$row, '%50');
            $sheet->setCellValue('L'.$row, '%25');
            $row = $row + 1 ;


            // 写入成绩
            foreach ($ks->ksSubject as $k => $val) {
                $sheet->setCellValue('D'.($row+$k), $val->subjectName->title);
                $sheet->setCellValue('E'.($row+$k), $value[$val->subject_name->lieming]);   # 得分
                $sheet->setCellValue('F'.($row+$k), $njtj['cj'][$val->subject_name->lieming]['avg']);
                $sheet->setCellValue('G'.($row+$k), $njtj['cj'][$val->subject_name->lieming]['max']);
                $sheet->setCellValue('H'.($row+$k), $njtj['cj'][$val->subject_name->lieming]['youxiu']);
                $sheet->setCellValue('I'.($row+$k), $njtj['cj'][$val->subject_name->lieming]['jige']);
                $sheet->setCellValue('J'.($row+$k), $njtj['cj'][$val->subject_name->lieming]['sifenwei'][0]);
                $sheet->setCellValue('K'.($row+$k), $njtj['cj'][$val->subject_name->lieming]['sifenwei'][1]);
                $sheet->setCellValue('L'.($row+$k), $njtj['cj'][$val->subject_name->lieming]['sifenwei'][2]);
            }

            // 设置格式
            $sheet->getStyle('A'.($row-1).':L'.($row+$rows-1))->applyFromArray($styleArray);

            $row = $row + $rows +1 ;

        }


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
