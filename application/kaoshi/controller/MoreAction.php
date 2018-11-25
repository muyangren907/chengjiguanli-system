<?php

namespace app\kaoshi\controller;

// 引用控制器基类
use app\common\controller\Base;
// 引用考试数据模型类
use app\kaoshi\model\Kaoshi as KS;
// 引用学生类
use app\renshi\model\Student;
// 引用成绩类
use app\chengji\model\Chengji;
// 引用PhpSpreadsheet类
use PhpOffice\PhpSpreadsheet\Spreadsheet;
// 引用二维码生成类
use \Endroid\QrCode\QrCode;


class MoreAction extends Base
{
    // 考试更多操作页面
    public function index($id)
    {
        
        // 设置模板赋值数据
        $list['kaoshiid']= $id;
        $list['title']='考试操作';
        // 模板赋值
        $this->assign('list',$list);

        // 渲染模板
        return $this->fetch();
    }


    // 生成考号
    public function kaohao($id)
    {
        // 考试ID赋值
        $this->assign('id',$id);

        return $this->fetch();
    }

    // 保存考号
    public function kaohaosave()
    {
        // 实例化验证模型
        $validate = new \app\teach\validate\Kaohao;

        // 获取表单数据
        $list = request()->only(['kaoshi','banjiids'],'post');
        

        // 验证表单数据
        $result = $validate->check($list);
        $msg = $validate->getError();

        // 如果验证不通过则停止保存
        if(!$result){
            return ['msg'=>$msg,'val'=>0];
        }

        // 将班级转换成数组
        $list['banjiids'] = implode(',',$list['banjiids']);

        // 获取参加考试学生名单
        $stulist = Student::where('status',1)
                        ->where('banji','in',$list['banjiids'])
                        ->field('id,school,banji')
                        ->append(['nianji'])
                        ->select();
        $njlist = nianjilist();

        // 组合参加考试学生信息
        $stus = array();
        foreach ($stulist as $key => $value) {
            $src = Chengji::where('kaoshi',$list['kaoshi'])
                    ->where('student',$value->id)
                    ->select();
            if($src->isEmpty()){
                $stus[] = [
                'kaoshi' => $list['kaoshi'],
                'school' => $value->getData('school'),
                'ruxuenian' => $value->nianji,
                'nianji' => $njlist[$value->nianji],
                'banji' => $value->banji,
                'student' => $value->id
            ];
            }
        }

        // 声明成绩数据模型类
        $cj = new Chengji();
        $data = $cj->saveAll($stus);


        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'添加成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

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
    public function biaoqian($id)
    {

        // 获取数据库信息
        $chengjiinfo = Chengji::where('kaoshi',$id)
                        ->append(['studentname','schooljian','banjiNumname'])
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
        $imageStyle = array('width'=>42,'height'=>42,'align'=>'left');

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
                $info->addText($value['schooljian'],$myStyle);
                $info->addText($value['banjiNumname'],$myStyle);
                $info->addText($value['studentname'],$myStyle);
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




    // 下载考试成绩采集表
    public function caiji($id)
    {
        // 模板赋值
        $this->assign('id',$id);
        // 渲染模板
        return $this->fetch();
    }
    


 


    // 获取参考名单 
    public function cankaomingdan()
    {

        // 实例化验证模型
        $validate = new \app\teach\validate\Cankaomingdan;

        // 获取表单数据
        $list = request()->only(['id','banjiids','subject'],'post');

        // 验证表单数据
        $result = $validate->check($list);
        $msg = $validate->getError();

        // 如果验证不通过则停止保存
        if(!$result){
            $this->error($msg);
        }

        // 获取考试标题
        $kstitle = KS::where('id',$list['id'])->value('title');

        // 获取参加考试学科信息
        $subject = new \app\teach\model\Subject();
        $xks = $subject->field('id,title')->all($list['subject']);

        
        // 循环组成第三行表头信息
        $biaotou = ['序号','参考号','班级','姓名'];
        foreach ($xks as $key => $value) {
            $biaotou[] = $value['title'];
        }

        // 获取电子表格列名
        $lieming = excelLieming();

        // 查询参加考试学生信息
        $datas = Chengji::where('kaoshi',$list['id'])
                ->where('banji','in',$list['banjiids'])
                ->append(['studentname','banjiNumname'])
                ->select();


        // 创建表格
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // 设置表格标题与表头信息
        $sheet->setCellValue('A1',$kstitle.'成绩采集表');
        foreach ($xks as $key => $value) {
            $sheet->setCellValue($lieming[$key + 4].'2', $value['id']);
        }
        $sheet->getRowDimension('2')->setRowHeight(0);
        $sheet->getColumnDimension('B')->setWidth(0);
        foreach ($biaotou as $key => $value) {
            $sheet->setCellValue($lieming[$key].'3', $value);
        }


        // 将学生信息循环写入表中
        $i = 4;
        foreach ($datas as $data)
        {
            $sheet->setCellValue('A'.$i, $i-3);
            $sheet->setCellValue('B'.$i, $data['id']);
            $sheet->setCellValue('C'.$i, $data['banjiNumname']);
            $sheet->setCellValue('D'.$i, $data['studentname']);
            $i++;
        }

        // 保存文件
        $filename = $kstitle.'成绩采集表'.date('ymdHis').'.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }
}
