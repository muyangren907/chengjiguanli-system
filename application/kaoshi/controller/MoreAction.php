<?php

namespace app\kaoshi\controller;

// 引用控制器基类
use app\common\controller\Base;
// 引用考试数据模型类
use app\kaoshi\model\Kaoshi as KS;
// 引用学生类
use app\renshi\model\Student;
// 引用成绩类
use PhpOffice\PhpSpreadsheet\Spreadsheet;
// 引用二维码生成类
use \Endroid\QrCode\QrCode;


class MoreAction extends Base
{
    // 考试更多操作页面
    public function index($id)
    {
        // 获取考试信息
        $kaoshi = KS::where('id',$id)
            ->field('id,title,bfdate,enddate')
            ->find();

        // 设置页面标题
        $list['webtitle'] = $kaoshi['title'] .'（'. $kaoshi['bfdate'].'~'.$kaoshi['enddate'].'）';
        $list['kaoshiid'] = $kaoshi['id'];

        // 模板赋值
        $this->assign('list',$list);
        // 渲染
        return $this->fetch();
    }


    // 生成考号
    public function kaohao($kaoshi)
    {

        // 获取参考年级
        $kaoshilist = KS::where('id',$kaoshi)
                ->with([
                    'ksNianji'
                ])
                ->find();
        foreach ($kaoshilist->ks_nianji as $key => $value) {
            $list['data']['nianji'][$key]['id']=$value->nianji;
            $list['data']['nianji'][$key]['title']=$value->nianjiname;
        }


        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'生成考号',
            'butname'=>'生成',
            'formpost'=>'POST',
            'url'=>'/kaoshi/kaohao',
            'kaoshi'=>$kaoshi
        );


        // 模板赋值
        $this->assign('list',$list);
        // 渲染
        return $this->fetch();
    }

    // 保存考号
    public function kaohaosave()
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

        // 将班级转换成数组
        $list['banjiids'] = implode(',',$list['banjiids']);
        $ksid = $list['kaoshi'];

        // 获取参加考试学生名单
        $stulist = Student::where('school',$list['school'])
                        ->where('banji','in',$list['banjiids'])
                        ->where('status',1)
                        ->field('id,school,banji')
                        ->with([
                            'stuBanji'=>function($query){
                                $query->field('id,ruxuenian');
                            }
                        ])
                        ->select();
        $njlist = nianjiList();
        // 重新组合学生信息
        $kaohao = array();
        foreach ($stulist as $key => $value) {
            $kaohao[$key]['student']= $value->id;
            $kaohao[$key]['school']= $list['school'];
            $kaohao[$key]['ruxuenian']= $value->stu_banji->ruxuenian;
            $kaohao[$key]['nianji']= $njlist[$kaohao[$key]['ruxuenian']];
            $kaohao[$key]['banji']= $value->stu_banji->id;
            $kaohao[$key]['kaoshi']= $list['kaoshi'];
        }

        // 保存考号
        $cj = new \app\chengji\model\Chengji;

        $data = $cj
            ->allowField(['id','kaoshi','student','school','ruxuenian','nianji','banji','create_time','update_time'])
            ->saveAll($kaohao);
        

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




    // 生成试卷标签二维码
    public function biaoqiandoc($id)
    {

        set_time_limit(0);
        // 获取数据库信息
        $chengjiinfo = Chengji::where('kaoshi',$id)
                        ->where('ruxuenian',2017)
                        // ->limit(15)
                        ->append(['cj_school.jiancheng','cj_Student.xingming','banjiNumname'])
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
                $info->addText($value['cj_school']['jiancheng'],$myStyle);
                $info->addText($value['banjiNumname'],$myStyle);
                $info->addText($value['cj_student']['xingming'],$myStyle);
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
        ob_flush();
        flush();

    }



    // 标签下载
    public function biaoqian($kaoshi)
    {
        // 获取参考年级
        $kaoshilist = KS::where('id',$kaoshi)
                ->with([
                    'ksNianji'
                    ,'ksSubject'=>function($query){
                                $query->field('id,subjectid,kaoshiid')
                                    ->with(['subjectName'=>function($q){
                                        $q->field('id,title');
                                    }]
                                );
                            }
                ])
                ->find();
        foreach ($kaoshilist->ks_nianji as $key => $value) {
            $list['data']['nianji'][$key]['id']=$value->nianji;
            $list['data']['nianji'][$key]['title']=$value->nianjiname;
        }
        foreach ($kaoshilist->ks_subject as $key => $value) {
            $list['data']['subject'][$key]['id']=$value->subjectid;
            $list['data']['subject'][$key]['title']=$value->subject_name->title;
        }


        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'下载考号',
            'butname'=>'下载',
            'formpost'=>'POST',
            'url'=>'/kaoshi/'.$kaoshi.'/biaoqianXls',
            'kaoshi'=>$kaoshi
        );


        // 模板赋值
        $this->assign('list',$list);
        // 渲染
        return $this->fetch();
    }



    //生成标签信息
    public function biaoqianXls()
    {
        set_time_limit(0);
        // 获取表单数据
        $list = request()->only(['banjiids','kaoshi','subject'],'post');

        $kaoshi = $list['kaoshi'];
        $banji = $list['banjiids'];
        $subject = $list['subject'];

        // 实例化验证模型
        $validate = new \app\kaoshi\validate\Biaoqian;
        // 验证表单数据
        $result = $validate->check($list);
        $msg = $validate->getError();

        // 如果验证不通过则停止保存
        if(!$result){
            $data=['msg'=>'数据处理错误','val'=>0];
            return json($data);
        }

        $ks = new KS();
        // 获取考试信息
        $chengjiinfo = $ks->srcChengji($kaoshi,$subject,$banji);

        // 创建表格
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // 设置表头信息
        $sheet->setCellValue('A1', '序号');
        $sheet->setCellValue('B1', '考号');
        $sheet->setCellValue('C1', '学校');
        $sheet->setCellValue('D1', '班级');
        $sheet->setCellValue('E1', '学科');
        $sheet->setCellValue('F1', '姓名');

        // 循环写出信息
        $i = 2;
        foreach ($chengjiinfo->ks_subject as $key => $sbj) {
            foreach ($chengjiinfo->ks_chengji as $xkkey => $cj) {
                // 表格赋值
                $sheet->setCellValue('A'.$i, $i-1);
                $sheet->setCellValue('B'.$i, action('system/Encrypt/encrypt',['data'=>$cj->id.'|'.$sbj->lieming,'key'=>'dlbz']));
                $sheet->setCellValue('C'.$i, $cj->cj_school->jiancheng);
                $sheet->setCellValue('D'.$i, $cj->cj_banji->numTitle);
                $sheet->setCellValue('E'.$i, $sbj->subject_name->title);
                $sheet->setCellValue('F'.$i, $cj->cj_student->xingming);
                $i++;
            }
        }


        // 保存文件
        $filename = $chengjiinfo['title'].date('ymdHis').'.xls';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');
        ob_flush();
        flush();
    }




    // 下载考试成绩采集表
    public function caiji($kaoshi)
    {
        // 获取参考年级
        $kaoshilist = KS::where('id',$kaoshi)
                ->with([
                    'ksNianji'
                    ,'ksSubject'=>function($query){
                                $query->field('id,subjectid,kaoshiid')
                                    ->with(['subjectName'=>function($q){
                                        $q->field('id,title');
                                    }]
                                );
                            }
                ])
                ->find();
        foreach ($kaoshilist->ks_nianji as $key => $value) {
            $list['data']['nianji'][$key]['id']=$value->nianji;
            $list['data']['nianji'][$key]['title']=$value->nianjiname;
        }
        foreach ($kaoshilist->ks_subject as $key => $value) {
            $list['data']['subject'][$key]['id']=$value->subjectid;
            $list['data']['subject'][$key]['title']=$value->subject_name->title;
        }


        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'下载成绩采集表',
            'butname'=>'下载',
            'formpost'=>'POST',
            'url'=>'/kaoshi/caiji',
            'kaoshi'=>$kaoshi
        );


        // 模板赋值
        $this->assign('list',$list);
        // 渲染
        return $this->fetch('biaoqian');
    }
    


 


    // 获取参考名单 
    public function dwcaiji()
    {
        // 实例化验证模型
        $validate = new \app\kaoshi\validate\Biaoqian;

        // 获取表单数据
        $list = request()->only(['banjiids','kaoshi','subject'],'post');

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
        // 获取考试信息
        $chengjiinfo = $ks->srcChengji($kaoshi,$subject,$banji);

        // 获取电子表格列名
        $lieming = excelLieming();

        // 创建表格
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // 设置表格标题与表头信息
        $sheet->setCellValue('A1',$chengjiinfo->title.' 成绩采集表');

        $sheet->setCellValue('A3', '序号');
        $sheet->setCellValue('B3', '考号');
        $sheet->setCellValue('C3', '班级');
        $sheet->setCellValue('D3', '姓名');
        // 获取列数并合并和一行
        $col = $lieming[count($chengjiinfo->ks_subject)+3];
        $sheet->mergeCells('A1:'.$col.'1');

         // 写入列名
        foreach ($chengjiinfo->ks_subject as $key => $value) {
            $sheet->setCellValue($lieming[$key + 4].'3', $value->subject_name['title']);
            $sheet->setCellValue($lieming[$key + 4].'2', $value->lieming);

        }
        // 隐藏第二行和第二列
        $sheet->getRowDimension('2')->setRowHeight('0');
        $sheet->getColumnDimension('B')->setWidth('0');


        // 将学生信息循环写入表中
        $i = 4;
        foreach ($chengjiinfo->ks_chengji as $key=>$value)
        {
            $sheet->setCellValue('A'.$i, $i-3);
            $sheet->setCellValue('B'.$i, $value['id']);
            $sheet->setCellValue('C'.$i, '\''.$value['banjiNumname']);
            $sheet->setCellValue('D'.$i, $value['cj_student']['xingming']);
            $i++;
        }


        // 保存文件
        $filename = $chengjiinfo->title.'成绩采集表'.date('ymdHis').'.xls';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');
    }


    
}
