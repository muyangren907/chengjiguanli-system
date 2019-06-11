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
                            $q->field('id,title,lieming');
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

        $data = array_slice($data,($src['page']-1)*$src['limit'],$src['limit']);

        // 获取年级成绩
        $temp = $tj->tongji($allcj,$src['kaoshi']);
        $data[] = [
            'banji'=>'',
            'school'=>'合计',
            'chengji'=>$temp
        ];

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
        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'各班级成绩汇总表下载',
            'butname'=>'下载',
            'formpost'=>'POST',
            'url'=>'/cjtongji/dwBanji',
            'kaoshi'=>$kaoshi
        );

        // 模板赋值
        $this->assign('list',$list);
        // 渲染
        return $this->fetch();

    }


    // 年级、班级学生成绩统计下载表格
    public function dwBanjixls($kaoshi)
    {
        // 获取表单参数
        $src = $this->request
                ->only([
                    'kaoshi'=>'',
                    'nianji'=>'一年级',
                    'school'=>'',
                ],'POST');


        // 查询要统计成绩的班级
        $kh = new \app\kaoshi\model\Kaohao;

        $bj = $kh->where('nianji',$src['nianji'])
                ->where('kaoshi',$src['kaoshi'])
                ->where('school',$src['school'])
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

        // 获取年级成绩
        $temp = $tj->tongji($allcj,$src['kaoshi']);
        $data[] = [
            'banji'=>'合计',
            'school'=>'',
            'chengji'=>$temp
        ];

        
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

        $sbjcol = ['cnt'=>'人数','avg'=>'平均分','jige'=>'及格率','youxiu'=>'优秀率'];
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
            $sheet->setCellValue($colname[$col].'3', $value->subject_name->title.' '.$value->manfen);
            foreach ($sbjcol as $k => $val) {
                 $sheet->setCellValue($colname[$col].'4', $val);
                 $col++;
            }
        }
        $sheet->mergeCells($colname[$col].'3:'.$colname[$col].'4');
        $sheet->setCellValue($colname[$col].'3', '全科及格');
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



    // 获取各学校、各年级考试成绩
    public function tjNianji($kaoshi)
    {

        $ks = new \app\kaoshi\model\Kaoshi;
        $ksinfo = $ks->where('id',$kaoshi)
            ->with([
                'KsNianji'
                ,'ksSubject'=>function($query){
                    $query->field('kaoshiid,subjectid')
                        ->with(['subjectName'=>function($q){
                            $q->field('id,title,lieming');
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
        $list['webtitle'] = '各学校的年级成绩统计表';
        $list['kaoshi'] = $kaoshi;


        // 模板赋值
        $this->assign('list',$list);

        // 渲染模板
        return $this->fetch();
    }


    // 获取年级成绩统计结果
    public function ajaxNianji()
    {
        // 获取参数
        $src = $this->request
                ->only([
                    'page'=>'1',
                    'limit'=>'10',
                    'kaoshi'=>'',
                    'nianji'=>'一年级',
                ],'POST');

        // 查询要统计成绩的班级
        $kh = new \app\kaoshi\model\Kaohao;

        $nianji = $kh->where('nianji',$src['nianji'])
                ->where('kaoshi',$src['kaoshi'])
                ->with(['cjSchool'=>function($query){
                        $query->field('id,jiancheng');
                    }
                ])
                ->group('school')
                ->field('id,banji,school')
                ->select();

        if($nianji->isEmpty()){
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
        foreach ($nianji as $key => $value) {
            $school=[$value->cj_school->id];
            $nianji = [$src['nianji']];
            $temp = $tj->srcChengji($src['kaoshi'],array(),$nianji,$school);
            $allcj = array_merge($allcj,  $temp);;
            $temp = $tj->tongji($temp,$src['kaoshi']);
            $data[] = [
                'school'=>$value->cj_school->jiancheng,
                'chengji'=>$temp
            ];
        }

        // 获取年级成绩
        $temp = $tj->tongji($allcj,$src['kaoshi']);
        $data[] = [
            'school'=>'合计',
            'chengji'=>$temp
        ];

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
    public function dwNianji($kaoshi)
    {

        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'各年级成绩汇总表下载',
            'butname'=>'下载',
            'formpost'=>'POST',
            'url'=>'/cjtongji/dwNanji',
            'kaoshi'=>$kaoshi
        );

        // 模板赋值
        $this->assign('list',$list);
        // 渲染
        return $this->fetch();

    }


    // 年级、班级学生成绩统计下载表格
    public function dwNianjixls($kaoshi)
    {

        // 获取参数
        $src = $this->request
                ->only([
                    'page'=>'1',
                    'limit'=>'10',
                    'kaoshi'=>'',
                    'nianji'=>'一年级',
                ],'POST');

        // 查询要统计成绩的班级
        $kh = new \app\kaoshi\model\Kaohao;

        $nianji = $kh->where('nianji',$src['nianji'])
                ->where('kaoshi',$src['kaoshi'])
                ->with(['cjSchool'=>function($query){
                        $query->field('id,jiancheng');
                    }
                ])
                ->group('school')
                ->field('id,banji,school')
                ->select();


        if($nianji->isEmpty()){
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
        foreach ($nianji as $key => $value) {
            $school=[$value->cj_school->id];
            $nianji = [$src['nianji']];
            $temp = $tj->srcChengji($src['kaoshi'],array(),$nianji,$school);
            $allcj = array_merge($allcj,  $temp);;
            $temp = $tj->tongji($temp,$src['kaoshi']);
            $data[] = [
                'school'=>$value->cj_school->jiancheng,
                'chengji'=>$temp
            ];
        }

        // 获取年级成绩
        $temp = $tj->tongji($allcj,$src['kaoshi']);
        $data[] = [
            'school'=>'合计',
            'chengji'=>$temp
        ];

        
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
        $tabletitle = $ksinfo->title.' '.$src['nianji'].'各学校成绩汇总';


        // 创建表格
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet;
        $sheet = $spreadsheet->getActiveSheet();

        $sbjcol = ['cnt'=>'人数','avg'=>'平均分','jige'=>'及格率%','youxiu'=>'优秀率%'];
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
            $sheet->setCellValue($colname[$col].'3', $value->subject_name->title.' '.$value->manfen);
            foreach ($sbjcol as $k => $val) {
                 $sheet->setCellValue($colname[$col].'4', $val);
                 $col++;
            }
        }
        $sheet->mergeCells($colname[$col].'3:'.$colname[$col].'4');
        $sheet->setCellValue($colname[$col].'3', '全科及格率%');
        $col++;
        $sheet->mergeCells($colname[$col].'3:'.$colname[$col].'4');
        $sheet->setCellValue($colname[$col].'3', '总平均分');

        $row = 5;
        foreach ($data as $key => $value) {
            $col = 2;
            $sheet->setCellValue('A'.$row, $row-4);
            $sheet->setCellValue('B'.$row, $value['school']);
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
