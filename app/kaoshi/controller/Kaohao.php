<?php
namespace app\kaoshi\controller;

// 引用控制器基类
use app\BaseController;
// 引用考试数据模型类
use app\kaoshi\model\Kaoshi as KS;
// 引用考号数据模型类
use app\kaoshi\model\Kaohao as KH;
// 引用考试设置数据模型类
use app\kaoshi\model\KaoshiSet as ksset;


// 引用成绩类
use PhpOffice\PhpSpreadsheet\Spreadsheet;
// 引用二维码生成类
use \Endroid\QrCode\QrCode;

// 调用验证类 
use think\Validate;


class Kaohao extends BaseController
{
    // 生成考号
    public function create($kaoshi)
    {

        // 获取参考年级
        $ksset = new ksset;
        $list['data']['nianji'] = $ksset->srcNianji($kaoshi);
        $list['data']['nianjiNum'] = array_column($list['data']['nianji'], 'nianji');

        $kh = new KH;
        $src['kaoshi'] = $kaoshi;
        $list['data']['school'] = $kh->cySchool($src);

        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'生成考号',
            'butname'=>'生成',
            'formpost'=>'POST',
            'url'=>'/kaoshi/kaohao/save',
            'kaoshi'=>$kaoshi
        );



        // 模板赋值
        $this->view->assign('list',$list);
        // 渲染
        return $this->view->fetch();
    }

    // 保存考号
    public function save()
    {

        // 实例化验证模型
        $validate = new \app\kaoshi\validate\Kaohao;

        // 获取表单数据
        $list = request()->only(['school','kaoshi','banjiids'],'post');


        // 验证表单数据
        $result = $validate->check($list);
        $msg = $validate->getError();

        // 如果验证不通过则停止保存
        if(!$result){
            return ['msg'=>$msg,'val'=>0];
        }

        if(kaoshiDate($list['kaoshi'],'enddate'))
        {
            return ['msg'=>'考试已经结束，不能分配考号','val'=>0];
        }

        // 获取实例化学生数据模型
        $stu = new \app\renshi\model\Student;
        // 获取参加考试学生名单
        $stulist = $stu::where('school',$list['school'])
                        ->where('banji','in',$list['banjiids'])
                        ->where('status',1)
                        ->field('id,school,banji')
                        ->with([
                            'stuBanji'=>function($query){
                                $query->field('id,ruxuenian,paixu');
                            }
                        ])
                        ->select();
        
        // 获取参加考试年级数组
        $bfdate = KS::where('id',$list['kaoshi'])->value('bfdate');
        $njlist = nianjiList($bfdate);
        // 重新组合学生信息
        $kaohao = array();
        foreach ($stulist as $key => $value) {
            $check = KH::withTrashed()
                        ->where('kaoshi',$list['kaoshi'])
                        ->where('student',$value->id)
                        ->find();
            if($check)
            {
                if($check->delete_time>0)
                {
                    $check->restore();
                }
                if($check->status == 0)
                {
                    $check->status = 1;
                    $check->save();
                }

                continue;
            }
            $kaohao[$key]['student']= $value->id;
            $kaohao[$key]['school']= $list['school'];
            $kaohao[$key]['ruxuenian']= $value->stuBanji->ruxuenian;
            $kaohao[$key]['nianji']= $njlist[$kaohao[$key]['ruxuenian']];
            $kaohao[$key]['banji']= $value->stuBanji->id;
            $kaohao[$key]['paixu']= $value->stuBanji->paixu;
            $kaohao[$key]['kaoshi']= $list['kaoshi'];
        }

        // 保存考号
        $kh = new \app\kaoshi\model\Kaohao;

        $data = $kh
            ->allowField(['id','kaoshi','student','school','ruxuenian','nianji','banji','paixu','create_time','update_time'])
            ->saveAll($kaohao);
        

        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'生成成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }



    // 添加单条考号
    public function addOne($kaoshi)
    {
        
        // 获取参考年级、学科
        $ksset = new ksset;
        $list['data']['nianji'] = $ksset->srcNianji($kaoshi);
        $kh = new KH;
        $src['kaoshi'] = $kaoshi;
        if(count($list['data']['nianji'])>0){
            $src['ruxuenian']=$list['data']['nianji'][0];
        } else {
            $src['ruxuenian']=array();
        }
        $list['data']['school'] = $kh->cySchool($src);


        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'添加考号',
            'butname'=>'添加',
            'formpost'=>'POST',
            'url'=>'/kaoshi/kaohao/saveOne',
            'kaoshi'=>$kaoshi
        );



        // 模板赋值
        $this->view->assign('list',$list);
        // 渲染
        return $this->view->fetch();
    }



    // 保存单条考号
    public function saveOne()
    {
        // 获取表单数据
        $list = request()->only(['kaoshi','banji','student'],'post');
        $list['student'] = explode(' ', $list['student']);
        $list['student'] = $list['student'][1];

        // 查询考号是否存在
        $ks = KH::where('kaoshi',$list['kaoshi'])
                ->where('student',$list['student'])
                ->find();
        if($ks)
        {
            $data=['msg'=>'该学生考号已经存在','val'=>0];
            return json($data);
        }

        // 获取参加考试年级数组
        $bfdate = KS::where('id',$list['kaoshi'])->value('bfdate');
        $njlist = nianjiList($bfdate);


        // 获取班级信息
        $bj = new \app\teach\model\Banji;
        $bjinfo = $bj->where('id',$list['banji'])->find();
        $list['school'] = $bjinfo->school;
        $list['ruxuenian'] = $bjinfo->ruxuenian;
        $list['nianji'] = $njlist[$bjinfo->ruxuenian];
        $list['paixu'] = $bjinfo->paixu;

        $data = KH::create($list);

        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'生成成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }








    /**
     * 生成指定网址的二维码
     * @param string $url 二维码中所代表的网址
    */
    public function create_qrcode($url='127.0.0.1')
    {
        $qrCode = new QrCode($url);
        header("Content-type: image/jpg");
        return $qrCode->writeString();
    }




    // 生成试卷标签二维码可以换成pdf格式
    public function biaoqiandoc($id)
    {

        // 获取数据库信息
        $chengjiinfo = Chengji::where('kaoshi',$id)
                        ->where('ruxuenian',2017)
                        ->append(['cjSchool.jiancheng','cjStudent.xingming','banjiNumname'])
                        ->select();

        // 获取学科信息
        $xks = KS::get($id);
        $xks = $xks->Subjectids;

        $subject = new \app\teach\model\Subject();
        $xks = $subject->where('id','in',$xks)->column('id,title');

        // Word处理
        // 实例化类
        $phpWord = new \PhpOffice\PhpWord\PhpWord(); 


        // 设置页面格式
        $sectionStyle = array(
            'pageSizeW'=>2*567,
            'pageSizeH'=>3*567,
            'orientation'=>'landscape',
            'marginLeft'=>80,
            'marginRight'=>80,
            'marginTop'=>100,
            'marginBottom'=>100
        );
        $section = $phpWord->createSection($sectionStyle);


        // 设置图片格式
        $imageStyle = array('width'=>45,'height'=>45,'align'=>'left');

        // 学生信息样式
        $myStyle = 'myStyle';
        $phpWord->addFontStyle(
            $myStyle,
            [
                'name' => '宋体',
                'size' => 6.5,
                'color' => '000000',
                'bold' => true,
            ]
        );
        

        // 循环写出信息
        foreach ($chengjiinfo as $key => $value) {
            foreach ($xks as $xkkey => $val) {
                // 创建表格
                $table = $section->addTable($key);
                $table->addRow(1500);

                
                $img = $this->create_qrcode($value['id'].','.$xkkey);
                $table->addCell(850)->addImage($img,$imageStyle);
                

                // $table->addCell(700)->addImage('aaaa.jpg',$imageStyle);
                $info = $table->addCell(650);
                $info->addText($value['cjSchool']['jiancheng'],$myStyle);
                $info->addText($value['banjiNumname'],$myStyle);
                $info->addText($value['cjStudent']['xingming'],$myStyle);
                $info->addText($val,$myStyle);

            }
        }



        // 保存文件
        $filename = '试卷标签.docx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('php://output');

    }



    // 标签下载
    public function biaoqian($kaoshi)
    {

        // 获取参考年级、学科
        $ksset = new ksset;
        $list['data']['nianji'] = $ksset->srcNianji($kaoshi);
        $kh = new KH;
        $src['kaoshi'] = $kaoshi;
        if(count($list['data']['nianji'])>0){
            $src['ruxuenian']=$list['data']['nianji'][0];
        } else {
            $src['ruxuenian']=array();
        }
        $list['data']['school'] = $kh->cySchool($src);
        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'下载考号',
            'butname'=>'下载',
            'formpost'=>'POST',
            'url'=>'/kaoshi/kaohao/biaoqianxls',
            'kaoshi'=>$kaoshi
        );

        // 模板赋值
        $this->view->assign('list',$list);
        // 渲染
        return $this->view->fetch();
    }



    //生成标签信息
    public function biaoqianXls()
    {

        // 获取表单数据
        $list = request()->only(['banjiids'=>array(),'kaoshi','subject'=>array()],'post');

        $kaoshi = $list['kaoshi'];
        $banji = $list['banjiids'];
        $subject = $list['subject'];

        if(kaoshiDate($kaoshi,'enddate'))
        {
            $this->error('考试已经结束，不能下载','/kaoshi/kaohao/biaoqian/'.$kaoshi);
        }

        // 实例化验证模型
        $validate = new \app\kaoshi\validate\Biaoqian;
        // 验证表单数据
        $result = $validate->check($list);
        $msg = $validate->getError();


        // 如果验证不通过则停止保存
        if(!$result){
            $this->error($msg);
        }
        

        $ks = new KS();
        $kslist = $ks::where('id',$kaoshi)
                    ->field('id,title')
                    ->find();
        // 获取参考学科
        $ksset = new ksset();
        $ksSubject = $ksset->srcSubject($kaoshi,$list['subject'],'');


        $kh = new KH();
        // 获取考试信息
        $kaohao = $kh->srcKaohao($kaoshi,$banji);


        $thistime = date("Y-m-d h:i:sa");
        // 创建表格
        $spreadsheet = new Spreadsheet();
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
        $sheet->setCellValue('A1', '序号');
        $sheet->setCellValue('B1', '考号');
        $sheet->setCellValue('C1', '学校');
        $sheet->setCellValue('D1', '班级');
        $sheet->setCellValue('E1', '学科');
        $sheet->setCellValue('F1', '姓名');


        // 实例化系统设置类
        $md5 = new \app\system\controller\Encrypt; 


        // 循环写出信息
        $i = 2;
        foreach ($kaohao as $key=>$bj)
        {
            foreach ($ksSubject as $ksbj => $sbj)
            {
                foreach ($bj->banjiKaohao as $kkh => $kh)
                {
                    // 表格赋值
                    $sheet->setCellValue('A'.$i, $i-1);
                    $stuKaohao = '';
                    $stuKaohao = $md5->encrypt($kh->id.'|'.$sbj['id'],'dlbz');
                    $sheet->setCellValue('C'.$i, $bj->cjSchool->jiancheng);
                    $sheet->setCellValue('B'.$i, $stuKaohao);
                    $sheet->setCellValue('D'.$i, $bj->cjBanji->numTitle);
                    $sheet->setCellValue('E'.$i, $sbj['jiancheng']);
                    $sheet->setCellValue('F'.$i, $kh->cjStudent['xingming']);
                    $i++;
                }
            }
        }

        // 保存文件
        $filename = $kslist->title.' 标签数据'.date('ymdHis').'.xls';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');

        // 保存文件
        $filename = $kslist->title.' 标签数据'.date('ymdHis').'.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        ob_flush();
        flush();
        
    }




    // 下载考试成绩采集表
    public function caiji($kaoshi)
    {
        
        if(kaoshiDate($kaoshi,'enddate'))
        {
            $this->error('考试已经结束，不能下载','/kaoshi/kaohao/biaoqian/'.$kaoshi);
        }

        // 获取参考年级、学科
        $ksset = new ksset;
        $list['data']['nianji'] = $ksset->srcNianji($kaoshi);
        $kh = new KH;
        $src['kaoshi'] = $kaoshi;
        if(count($list['data']['nianji'])>0){
            $src['ruxuenian']=$list['data']['nianji'][0];
        } else {
            $src['ruxuenian']=array();
        }
        $list['data']['school'] = $kh->cySchool($src);

        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'下载成绩采集表',
            'butname'=>'下载',
            'formpost'=>'POST',
            'url'=>'/kaoshi/kaohao/dwcaiji',
            'kaoshi'=>$kaoshi
        );

        // 模板赋值
        $this->view->assign('list',$list);
        // 渲染
        return $this->view->fetch('biaoqian');
    }
    


 


    // 获取参考名单 
    public function dwcaiji()
    {
        // 实例化验证模型
        $validate = new \app\kaoshi\validate\Biaoqian;

        // 获取表单数据
        $list = request()->only(['banjiids'=>array(),'ruxuenian','kaoshi','subject'=>array()],'post');

        $kaoshi = $list['kaoshi'];
        $banji = $list['banjiids'];
        $subject = $list['subject'];


        // 验证表单数据
        $result = $validate->check($list);
        $msg = $validate->getError();

        // 如果验证不通过则停止保存
        if(!$result){
            $this->error($msg);
        }
        
        $ks = new KS();
        $kslist = $ks::where('id',$kaoshi)
                    ->field('id,title')
                    ->find();
        // 获取参加考试学科
        $ksset = new ksset();
        $ksSubject = $ksset->srcSubject($kaoshi,$list['subject']);


        $kh = new KH();
        // 获取考试信息
        $kaohao = $kh->srcKaohao($kaoshi,$banji);


        // 获取电子表格列名
        $lieming = excelLieming();

        // 创建表格
        $spreadsheet = new Spreadsheet();
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

        // 设置表格标题与表头信息
        $sheet->setCellValue('A1',$kslist->title.' 成绩采集表');

        $sheet->setCellValue('A2', $kaoshi);
        $sheet->setCellValue('B2', $list['ruxuenian']);
        $sheet->setCellValue('A3', '序号');
        $sheet->setCellValue('B3', '编号');
        $sheet->setCellValue('C3', '班级');
        $sheet->setCellValue('D3', '姓名');
        // 获取列数并合并和一行
        $col = $lieming[count($ksSubject)+3];
        $sheet->mergeCells('A1:'.$col.'1');


         // 写入列名
        foreach ($ksSubject as $key => $value) {
            $sheet->setCellValue($lieming[$key + 4].'3', $value['title']);
            $sheet->setCellValue($lieming[$key + 4].'2', $value['id']);
        }
        // 隐藏第二行和第二列
        $sheet->getRowDimension('2')->setRowHeight('0');
        $sheet->getColumnDimension('B')->setWidth('0');
        $sheet->getColumnDimension('C')->setWidth('13');


        // 将学生信息循环写入表中
        $i = 4;
        foreach ($kaohao as $key=>$bj)
        {
            foreach ($bj->banjiKaohao as $k => $kh) {
                $sheet->setCellValue('A'.$i, $i-3);
                $sheet->setCellValue('B'.$i, $kh->id);
                $sheet->setCellValue('C'.$i, $bj->cjBanji->banjiTitle);
                $sheet->setCellValue('D'.$i, $kh->cjStudent->xingming);
                $i++;
            }
        }

        // 居中
        $styleArray = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER, //垂直居中
            ],
        ];
        $sheet->getStyle('A1:'.$col.($i-1))->applyFromArray($styleArray);

        // 加边框
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '00000000'],
                ],
            ],
        ];
        $sheet->getStyle('A3:'.$col.($i-1))->applyFromArray($styleArray);
        // 修改标题字号
        $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setBold(true)->setName('宋体')->setSize(11);
        // 设置行高
        $spreadsheet->getActiveSheet()->getDefaultRowDimension()->setRowHeight(20);
        $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(25);
        // 设置筛选
        $sheet->setAutoFilter('A3:'.$col.($i-1));


        // 保存文件
        $filename = $kslist->title.'成绩采集表'.date('ymdHis').'.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        ob_flush();
        flush();

    }


    // 删除考号
    public function delete($id)
    {

        if($id == 'm')
        {
            $id = request()->delete('ids');// 获取delete请求方式传送过来的数据并转换成数据
        }

        $id = explode(',', $id);

        // 判断考试结束时间是否已过
        $ksid = KH::where('id',$id[0])->value('kaoshi');
        $enddate = kaoshiDate($ksid,'enddate');
        

        if( $enddate === true )
        {
            $data=['msg'=>'考试时间已过，不能删除','val'=>0];
        }else{
            $data = KH::destroy($id);
            // 根据更新结果设置返回提示信息
            $data ? $data=['msg'=>'删除成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];
        }
        // 返回信息
        return json($data);
    }

    
}
