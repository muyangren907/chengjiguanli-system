<?php

namespace app\kaoshi\controller;

// 引用控制器基类
use app\BaseController;
// 引用考试数据模型类
use app\kaoshi\model\Kaoshi as KS;
// 引用考号数据模型类
use app\kaoshi\model\Kaohao as KH;

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
        $kaoshilist = KS::where('id',$kaoshi)
                ->with([
                    'ksNianji'
                ])
                ->find();

        if(count($kaoshilist->ks_nianji)>0)
        {
            foreach ($kaoshilist->ks_nianji as $key => $value) {
                $list['data']['nianji'][$key]['id']=$value->nianji;
                $list['data']['nianji'][$key]['title']=$value->nianjiname;
            }
        }else{
            $list['data']['nianji']= array();
        }
        


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

        if(kaoshiDate($list['kaoshi'],'bfdate'))
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
                                $query->field('id,ruxuenian');
                            }
                        ])
                        ->select();

        $njlist = nianjiList();
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
            $kaohao[$key]['ruxuenian']= $value->stu_banji->ruxuenian;
            $kaohao[$key]['nianji']= $njlist[$kaohao[$key]['ruxuenian']];
            $kaohao[$key]['banji']= $value->stu_banji->id;
            $kaohao[$key]['kaoshi']= $list['kaoshi'];
        }

        // 保存考号
        $kh = new \app\kaoshi\model\Kaohao;

        $data = $kh
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




    // 生成试卷标签二维码可以换成pdf格式
    public function biaoqiandoc($id)
    {

        set_time_limit(0);
        // 获取数据库信息
        $chengjiinfo = Chengji::where('kaoshi',$id)
                        ->where('ruxuenian',2017)
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


        // 获取考试年级
        if(count($kaoshilist->ks_nianji)>0)
        {
            foreach ($kaoshilist->ks_nianji as $key => $value) {
                $list['data']['nianji'][$key]['id']=$value->nianji;
                $list['data']['nianji'][$key]['title']=$value->nianjiname;
            }
        }else{
            $list['data']['nianji']= array();
        }
        // 获取考试学科
        if(count($kaoshilist->ks_subject)>0)
        {
            foreach ($kaoshilist->ks_subject as $key => $value) {
                $list['data']['subject'][$key]['id']=$value->subjectid;
                $list['data']['subject'][$key]['title']=$value->subject_name->title;
            }
        }else{
            $list['data']['subject']= array();
        }


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
        $kslist = $ks::where('id',$kaoshi)
                    ->field('id,title')
                    ->with([
                        'ksSubject'=>function($query) use($subject){
                            $query->where('subjectid','in',$subject)
                                ->field('kaoshiid,subjectid')
                                ->with(['subjectName'=>function($q){
                                    $q->field('id,jiancheng,lieming');
                                }]
                            );
                        }
                    ])
                    ->find();


        $kh = new KH();
        // 获取考试信息
        $kaohao = $kh->srcKaohao($kaoshi,$banji);


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


        // 实例化系统设置类
        $md5 = new \app\system\controller\Encrypt; 



        // 循环写出信息
        $i = 2;
        foreach ($kaohao as $key=>$bj)
        {

            foreach ($kslist->ksSubject as $ksbj => $sbj)
            {

                // halt($obj);


                foreach ($bj->banjiKaohao as $kkh => $kh)
                {
                    // 表格赋值
                    $sheet->setCellValue('A'.$i, $i-1);
                    $stuKaohao = '';
                    $stuKaohao = $md5->encrypt($kh->id.'|'.$sbj->subject_name->id,'dlbz');
                    $sheet->setCellValue('C'.$i, $bj->cjSchool->jiancheng);
                    $sheet->setCellValue('B'.$i, $stuKaohao);
                    $sheet->setCellValue('D'.$i, $bj->cjBanji->numTitle);
                    $sheet->setCellValue('E'.$i, $sbj->subject_name->jiancheng);
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
        // ob_flush();
        // flush();
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
        // 获取考试年级
        if(count($kaoshilist->ks_nianji)>0)
        {
            foreach ($kaoshilist->ks_nianji as $key => $value) {
                $list['data']['nianji'][$key]['id']=$value->nianji;
                $list['data']['nianji'][$key]['title']=$value->nianjiname;
            }
        }else{
            $list['data']['nianji']= array();
        }
        // 获取考试学科
        if(count($kaoshilist->ks_subject)>0)
        {
            foreach ($kaoshilist->ks_subject as $key => $value) {
                $list['data']['subject'][$key]['id']=$value->subjectid;
                $list['data']['subject'][$key]['title']=$value->subject_name->title;
            }
        }else{
            $list['data']['subject']= array();
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
        $kslist = $ks::where('id',$kaoshi)
                    ->field('id,title')
                    ->with([
                        'ksSubject'=>function($query) use($subject){
                            $query->where('subjectid','in',$subject)
                                ->field('kaoshiid,subjectid')
                                ->with(['subjectName'=>function($q){
                                    $q->field('id,title,lieming');
                                }]
                            );
                        }
                    ])
                    ->find();

        $kh = new KH();
        // 获取考试信息
        $kaohao = $kh->srcKaohao($kaoshi,$banji);


        // 获取电子表格列名
        $lieming = excelLieming();

        // 创建表格
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // 设置表格标题与表头信息
        $sheet->setCellValue('A1',$kslist->title.' 成绩采集表');

        $sheet->setCellValue('A3', '序号');
        $sheet->setCellValue('B3', '考号');
        $sheet->setCellValue('C3', '班级');
        $sheet->setCellValue('D3', '姓名');
        // 获取列数并合并和一行
        $col = $lieming[count($kslist->ks_subject)+3];
        $sheet->mergeCells('A1:'.$col.'1');


         // 写入列名
        foreach ($kslist->ks_subject as $key => $value) {
            $sheet->setCellValue($lieming[$key + 4].'3', $value->subject_name->title);
            $sheet->setCellValue($lieming[$key + 4].'2', $value->subject_name->id);
        }
        // 隐藏第二行和第二列
        $sheet->getRowDimension('2')->setRowHeight('0');
        $sheet->getColumnDimension('B')->setWidth('0');


        // 将学生信息循环写入表中
        $i = 4;
        foreach ($kaohao as $key=>$bj)
        {
            foreach ($bj->banji_kaohao as $k => $kh) {
                $sheet->setCellValue('A'.$i, $i-3);
                $sheet->setCellValue('B'.$i, $kh->id);
                $sheet->setCellValue('C'.$i, $bj->cj_banji->banjiTitle);
                $sheet->setCellValue('D'.$i, $kh->cj_student->xingming);
                $i++;
            }
        }


        // 保存文件
        $filename = $kslist->title.'成绩采集表'.date('ymdHis').'.xls';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');
    }


    // 删除考号
    public function delete($id)
    {

        if($id == 'm')
        {
            $id = request()->delete('ids');// 获取delete请求方式传送过来的数据并转换成数据
        }

        $id = explode(',', $id);

        // 删除成绩
        $db = new \think\Db;
        $db::startTrans(); # 启动事务
        try {
            KH::destroy($id);
            $chengji = new \app\chengji\model\Chengji;
            $cjids = $chengji::where('kaohao_id','in',$id)->column('id');
            $chengji::destroy($cjids);
            $data = true;
            $db::commit();
        } catch (\Exception $e) {
            $data = false;
            // 回滚事务
            $db::rollback();
        }

        // 根据更新结果设置返回提示信息
        $data==true ? $data=['msg'=>'删除成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }

    
}