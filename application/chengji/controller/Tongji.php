<?php

namespace app\chengji\controller;

// 引用控制器基类
use app\common\controller\Base;
// 引用成绩统计数据模型
use app\chengji\model\Tongji as TJ;

class Tongji extends Base
{
    // 年级成绩汇总
    public function tjBanji($kaoshi)
    {
        $ks = new \app\kaoshi\model\Kaoshi;
        $ksinfo = $ks->where('id',$kaoshi)
            ->with([
                'KsNianji'
                ,'ksSubject'=>function($query){
                    $query->field('kaoshiid,subjectid')
                        ->with(['subjectName'=>function($q){
                            $q->field('id,jiancheng,lieming');
                        }]
                    );
                }
            ])
            ->field('id')
            ->find();
        if($ksinfo->ks_nianji[0])
        {

            $list['nianji'] = $ksinfo->ks_nianji[0]->nianjiname;
        }else{
            $list['nianji'] ='一年级';
        }
        $list['subject'] = $ksinfo->ks_subject;
        // 设置要给模板赋值的信息
        $list['webtitle'] = '各年级的班级成绩列表';
        $list['kaoshi'] = $kaoshi;


        // 模板赋值
        $this->assign('list',$list);

        // 渲染模板
        return $this->fetch();
    }


    // 获取年级成绩统计结果
    public function ajaxBianji()
    {
        // 获取参数
        $src = $this->request
                ->only([
                    'page'=>'1',
                    'limit'=>'10',
                    'kaoshi'=>'',
                    'nianji'=>'一年级',
                    'school'=>array(),
                    'paixu'=>array(),
                ],'POST');

        // 查询要统计成绩的班级
        $kh = new \app\kaoshi\model\Kaohao;
        $school = $src['school'];
        $paixu = $src['paixu'];

        $bj = $kh->where('nianji',$src['nianji'])
                ->where('kaoshi',$src['kaoshi'])
                ->when(count($school)>0,function($query) use($school){
                    $query->where('school','in',$school);
                })
                ->when(count($paixu)>0,function($query) use($paixu){
                    $query->where('banji','in',function($q)use($paixu){
                        $q->name('banji')->where('paixu','in',$paixu)->field('id');
                    });
                })
                ->with([
                    'cjBanji'=>function($query){
                        $query->field('id,paixu,ruxuenian')
                            ->append(['numTitle','banjiTitle']);
                    }
                    ,'cjSchool'=>function($query){
                        $query->field('id,jiancheng');
                    }
                ])
                ->group('banji')
                ->field('id,banji,school')
                ->select();

        if($bj->isEmpty()){
            // 重组返回内容
            $data = [
                'code'=> 0 , // ajax请求次数，作为标识符
                'msg'=>"",  // 获取到的结果数(每页显示数量)
                'count'=>0, // 符合条件的总数据量
                'data'=>array(), //获取到的数据结果
            ];

            return json($data);
        }



        // 获取并统计各班级成绩
        $tj = new TJ;
        $data = array();
        $allcj = array();
        foreach ($bj as $key => $value) {
            $banji=[$value->banji];
            $nianji = array();
            $temp = $tj->srcChengji($src['kaoshi'],$banji,$nianji);
            $allcj = array_merge($allcj,  $temp);;
            $temp = $tj->tongji($temp,$src['kaoshi']);
            $data[] = [
                'banji'=>$value->cj_banji->banjiTitle,
                'school'=>$value->cj_school->jiancheng,
                'chengji'=>$temp
            ];
        }
        
        $cnt = count($data);

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
    public function dwBanji($kaoshi)
    {
        // 模板赋值
        $this->assign('id',$kaoshi);
        // 渲染模板
        return $this->fetch();

    }


    // 年级、班级学生成绩统计下载表格
    public function dwBanjixls($kaoshi)
    {
        // 获取表单参数
        $getParam = request()->param();

        // 实例化统计成绩数据模型
        $tj = new \app\chengji\model\Tongji;
        // 获取统计成绩参数
        $canshu = $tj->getCanshu($getParam['kaoshiid']);
        // 获取统计结果
        $data = $tj->tjnianji($getParam['kaoshiid'],$getParam['school'],$getParam['ruxuenian']);

        // 创建表格
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet;
        $sheet = $spreadsheet->getActiveSheet();

        // 设置表头信息
        $sheet->mergeCells('A1:K1');
        $sheet->setCellValue('A1', '学生成绩列表');
        $sheet->mergeCells('A3:A4');
        $sheet->setCellValue('A3', '序号');
        $sheet->mergeCells('B3:B4');
        $sheet->setCellValue('B3', '班级');
        $sheet->mergeCells('C3:E3');
        $sheet->setCellValue('C3', '语文('.$canshu[1]['manfen'].')');
        $sheet->setCellValue('C4', '平均分');
        $sheet->setCellValue('D4', '优秀率%');
        $sheet->setCellValue('E4', '及格率%');
        $sheet->mergeCells('F3:H3');
        $sheet->setCellValue('F3', '数学('.$canshu[2]['manfen'].')');
        $sheet->setCellValue('F4', '平均分');
        $sheet->setCellValue('G4', '优秀率%');
        $sheet->setCellValue('H4', '及格率%');
        $sheet->mergeCells('I3:K3');
        $sheet->setCellValue('I3', '英语('.$canshu[3]['manfen'].')');
        $sheet->setCellValue('I4', '平均分');
        $sheet->setCellValue('J4', '优秀率%');
        $sheet->setCellValue('K4', '及格率%');

        $i = 5;
        foreach ($data as $key => $value) {
            $sheet->setCellValue('A'.$i, $i-4);
            $sheet->setCellValue('B'.$i, $value['title']);
            $sheet->setCellValue('C'.$i, $value['data']['yuwen']['avg']);
            $sheet->setCellValue('D'.$i, $value['data']['yuwen']['youxiu']);
            $sheet->setCellValue('E'.$i, $value['data']['yuwen']['jige']);
            $sheet->setCellValue('F'.$i, $value['data']['shuxue']['avg']);
            $sheet->setCellValue('G'.$i, $value['data']['shuxue']['youxiu']);
            $sheet->setCellValue('H'.$i, $value['data']['shuxue']['jige']);
            $sheet->setCellValue('I'.$i, $value['data']['waiyu']['avg']);
            $sheet->setCellValue('J'.$i, $value['data']['waiyu']['youxiu']);
            $sheet->setCellValue('K'.$i, $value['data']['waiyu']['jige']);
            $i++;
        }
        $sheet->getColumnDimension('B')->setWidth(15);

        $styleArrayBody = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '666666'],
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];
        $i = $i-1;
        $sheet->getStyle('A3:K'.$i)->applyFromArray($styleArrayBody);



        // 保存文件
        $filename = '学生成绩列表'.date('ymdHis').'.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        ob_flush();
        flush();

    }



    // 获取各学校、各年级考试成绩
    public function tjNianji($kaoshi)
    {
        // 设置页面标题
        $list['title'] = '各学校的年级成绩统计表';
        $list['kaoshi'] = $kaoshi;

        // 模板赋值
        $this->assign('list', $list);

        // 渲染模板
        return $this->fetch();
    }


    // 获取年级成绩统计结果
    public function ajaxNianji()
    {
        // 获取表单参数
        $getParam = request()->param();

        // 实例化统计成绩数据模型
        $tj = new \app\chengji\model\Tongji;
        $data = $tj->tjschool($getParam['kaoshiid'],$getParam['ruxuenian']);
        $cnt = count($data);

        
        // 重组返回内容
        $data = [
            'draw'=> $getParam["draw"] , // ajax请求次数，作为标识符
            'recordsTotal'=>$cnt,  // 获取到的结果数(每页显示数量)
            'recordsFiltered'=>$cnt,       // 符合条件的总数据量
            'data'=>$data, //获取到的数据结果
        ];

        return json($data);
    }



    // 年级、班级学生成绩统计结果下载界面
    public function dwNianji($kaoshi)
    {
        // 模板赋值
        $this->assign('id',$kaoshi);
        // 渲染模板
        return $this->fetch();

    }


    // 年级、班级学生成绩统计下载表格
    public function dwNianjixls($kaoshi)
    {

        // 获取表单参数
        $getParam = request()->param();

        // 实例化统计成绩数据模型
        $tj = new \app\chengji\model\Tongji;
        // 获取统计成绩参数
        $canshu = $tj->getCanshu($getParam['kaoshiid']);
        // 获取统计结果
        $data = $tj->tjschool($getParam['kaoshiid'],$getParam['ruxuenian']);

        // 创建表格
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet;
        $sheet = $spreadsheet->getActiveSheet();

        // 设置表头信息
        $sheet->mergeCells('A1:K1');
        $sheet->setCellValue('A1', '学生成绩列表');
        $sheet->mergeCells('A3:A4');
        $sheet->setCellValue('A3', '序号');
        $sheet->mergeCells('B3:B4');
        $sheet->setCellValue('B3', '班级');
        $sheet->mergeCells('C3:E3');
        $sheet->setCellValue('C3', '语文('.$canshu[1]['manfen'].')');
        $sheet->setCellValue('C4', '平均分');
        $sheet->setCellValue('D4', '优秀率%');
        $sheet->setCellValue('E4', '及格率%');
        $sheet->mergeCells('F3:H3');
        $sheet->setCellValue('F3', '数学('.$canshu[2]['manfen'].')');
        $sheet->setCellValue('F4', '平均分');
        $sheet->setCellValue('G4', '优秀率%');
        $sheet->setCellValue('H4', '及格率%');
        $sheet->mergeCells('I3:K3');
        $sheet->setCellValue('I3', '英语('.$canshu[3]['manfen'].')');
        $sheet->setCellValue('I4', '平均分');
        $sheet->setCellValue('J4', '优秀率%');
        $sheet->setCellValue('K4', '及格率%');

        $i = 5;
        foreach ($data as $key => $value) {
            $sheet->setCellValue('A'.$i, $i-4);
            $sheet->setCellValue('B'.$i, $value['title']);
            $sheet->setCellValue('C'.$i, $value['data']['yuwen']['avg']);
            $sheet->setCellValue('D'.$i, $value['data']['yuwen']['youxiu']);
            $sheet->setCellValue('E'.$i, $value['data']['yuwen']['jige']);
            $sheet->setCellValue('F'.$i, $value['data']['shuxue']['avg']);
            $sheet->setCellValue('G'.$i, $value['data']['shuxue']['youxiu']);
            $sheet->setCellValue('H'.$i, $value['data']['shuxue']['jige']);
            $sheet->setCellValue('I'.$i, $value['data']['waiyu']['avg']);
            $sheet->setCellValue('J'.$i, $value['data']['waiyu']['youxiu']);
            $sheet->setCellValue('K'.$i, $value['data']['waiyu']['jige']);
            $i++;
        }
        $sheet->getColumnDimension('B')->setWidth(15);

        $styleArrayBody = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '666666'],
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];
        $i = $i-1;
        $sheet->getStyle('A3:K'.$i)->applyFromArray($styleArrayBody);



        // 保存文件
        $filename = '各学校年级成绩统计表'.date('ymdHis').'.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        ob_flush();
        flush();

    }

}
