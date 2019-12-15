<?php

namespace app\chengji\controller;

// 引用控制器基类
use app\BaseController;
// 引用成绩统计数据模型
use app\chengji\model\Bjtongji as BTJ;

class Bjtongji extends BaseController
{
    // 年级成绩汇总
    public function biaoge($kaoshi)
    {
        $ks = new \app\kaoshi\model\Kaoshi;
        $ksinfo = $ks->where('id',$kaoshi)
            ->with([
                'KsNianji'
                ,'ksSubject'=>function($query){
                    $query->field('kaoshiid,subjectid,manfen')
                        ->with(['subjectName'=>function($q){
                            $q->field('id,title,lieming');
                        }]
                    );
                }
            ])
            ->field('id,title')
            ->find();

        if(count($ksinfo->ks_nianji)>0)
        {
            $list['nianji'] = $ksinfo->ksNianji[0]->nianji;
        }else{
            $list['nianji'] = "一年级";
        }
        $list['subject'] = $ksinfo->ksSubject->toArray();
        // 设置要给模板赋值的信息
        $list['webtitle'] = '各年级的班级成绩列表';
        $list['kaoshi'] = $kaoshi;
        $list['kaoshititle'] = $ksinfo->title;
        $list['dataurl'] = '/chengji/bjtj/data';


        // 模板赋值
        $this->view->assign('list',$list);

        // 渲染模板
        return $this->view->fetch();
    }


    // 获取年级成绩统计结果
    public function ajaxData()
    {
        // 获取参数
        $src = $this->request
                ->only([
                    'page'=>'1',
                    'limit'=>'10',
                    'kaoshi'=>'',
                    'nianji'=>'',
                    'school'=>'',
                    'paixu'=>array(),
                ],'POST');


        // 统计成绩
        $btj = new BTJ;

        $data = $btj->tjBanji($src['kaoshi'],$src['nianji'],[$src['school']],$src['paixu']);

        dump($data);

        halt('aa');

       
        // 获取记录总数
        $cnt = count($data);
        // 截取当前页数据
        $data = array_slice($data,($src['page']-1)*$src['limit'],$src['limit']);

        // 重组返回内容
        $data = [
            'code'=> 0 , // ajax请求次数，作为标识符
            'msg'=>"",  // 获取到的结果数(每页显示数量)
            'count'=>$cnt, // 符合条件的总数据量
            'data'=>$data, //获取到的数据结果
        ];

        return json($data);
    }

    // 年级、班级学生成绩统计结果下载界面
    public function dwBiaoge($kaoshi)
    {
        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'各班级成绩汇总表下载',
            'butname'=>'下载',
            'formpost'=>'POST',
            'url'=>'/bjtongji/dwBanji',
            'kaoshi'=>$kaoshi
        );

        // 模板赋值
        $this->view->assign('list',$list);
        // 渲染
        return $this->view->fetch();

    }


    // 年级、班级学生成绩统计下载表格
    public function dwBanjixls($kaoshi)
    {
        // 获取表单参数
        $src = $this->request
                ->only([
                    'kaoshi'=>'',
                    'nianji'=>'一年级',
                    'school'=>array(),
                ],'POST');

        $schools = [$src['school']];


        // 统计成绩
        $btj = new BTJ;
        $data = $btj->tjBanji($src['kaoshi'],$src['nianji'],$schools,array());

        
        // 获取参考学科
        $ks = new \app\kaoshi\model\Kaoshi;
        $ksinfo = $ks->where('id',$src['kaoshi'])
                    ->field('id,title')
                    ->with([
                        'ksSubject'=>function($query){
                            $query->field('kaoshiid,subjectid,manfen')
                                ->with(['subjectName'=>function($q){
                                    $q->field('id,title,lieming');
                                }]
                            );
                        }
                    ])
                    ->find();
        $xk = $ksinfo->ks_subject;


        // 获取要下载成绩的学校和年级信息
        $school = new \app\system\model\School;
        $schoolname = $school->where('id',$src['school'])->value('jiancheng');
        $tabletitle = $ksinfo->title.' '.$schoolname.' '.$src['nianji'].'各班级成绩汇总';

        // 创建表格
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet;
        $sheet = $spreadsheet->getActiveSheet();

        $sbjcol = ['xkcnt'=>'人数','avg'=>'平均分','jige'=>'及格率%','youxiu'=>'优秀率%'];
        $sbjcolcnt = count($sbjcol);
        $colname = excelLieming();
        $colcnt = $sbjcolcnt*count($xk)+3;


        // 设置表头信息
        $sheet->mergeCells('A1:'.$colname[$colcnt].'1');
        $sheet->setCellValue('A1', $tabletitle);
        $sheet->mergeCells('A3:A4');
        $sheet->setCellValue('A3', '序号');
        $sheet->mergeCells('B3:B4');
        $sheet->setCellValue('B3', '班级');
        $col = 2;
        foreach ($xk as $key => $value) {
            $colend = $col + $sbjcolcnt - 1;
            $sheet->mergeCells($colname[$col].'3:'.$colname[$colend].'3');
            $sheet->setCellValue($colname[$col].'3', $value->subject_name->title.' ('.$value->manfen.')');
            foreach ($sbjcol as $k => $val) {
                 $sheet->setCellValue($colname[$col].'4', $val);
                 $col++;
            }
        }
        $sheet->mergeCells($colname[$col].'3:'.$colname[$col].'4');
        $sheet->setCellValue($colname[$col].'3', '全科及格率%');
        $col++;
        $sheet->mergeCells($colname[$col].'3:'.$colname[$col].'4');
        $sheet->setCellValue($colname[$col].'3', '全科平均');

        $row = 5;
        foreach ($data as $key => $value) {
            $col = 2;
            $sheet->setCellValue('A'.$row, $row-4);
            $sheet->setCellValue('B'.$row, $value['banji']);
            foreach ($xk as $ke => $val) {
                foreach ($sbjcol as $k => $v) {
                     $sheet->setCellValue($colname[$col].$row, $value['chengji'][$val->subject_name->lieming][$k]);
                     $col++;
                }
            }
            $sheet->setCellValue($colname[$col].$row, $value['chengji']['rate']);
            $col++;
            $sheet->setCellValue($colname[$col].$row, $value['chengji']['avg']);
            $row++;
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


    
}
