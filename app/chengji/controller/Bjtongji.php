<?php

namespace app\chengji\controller;

// 引用控制器基类
use app\BaseController;
// 引用成绩统计数据模型
use app\chengji\model\TongjiBj as BTJ;

class Bjtongji extends BaseController
{
    // 班级成绩汇总
    public function biaoge($kaoshi_id)
    {
        // 获取考试信息
        $ks = new \app\kaoshi\model\Kaoshi;
        $ksinfo = $ks->where('id', $kaoshi_id)
            ->field('id, title')
            ->find();
        // 获取参与学校
        $khSrc = new \app\kaohao\model\Search;
        $src['kaoshi_id'] = $kaoshi_id;
        $list['school_id'] = $khSrc->cySchool($src);

        // 获取年级与学科
        $ksset = new \app\kaoshi\model\KaoshiSet;
        $list['nianji'] = $ksset->srcNianji($kaoshi_id);
        $list['subject_id'] = $ksset->srcSubject($kaoshi_id, '', '');
        // 设置要给模板赋值的信息
        $list['webtitle'] = '各年级的班级成绩列表';
        $list['kaoshi_id'] = $kaoshi_id;
        $list['kaoshititle'] = $ksinfo->title;
        $list['dataurl'] = '/chengji/bjtj/data';

        // 模板赋值
        $this->view->assign('list', $list);

        // 渲染模板
        return $this->view->fetch();
    }


    // 获取年级成绩统计结果
    public function ajaxData()
    {
        // 获取参数
        $src = $this->request
            ->only([
                'page' => '1'
                ,'limit' => '10'
                ,'kaoshi_id' => ''
                ,'ruxuenian' => ''
                ,'school_id' => array()
                ,'banji_id' => array()
            ], 'POST');

        if (count($src['banji_id'])==0) {
            // 获取参与考试的班级
            $khSrc = new \app\kaohao\model\Search;
            $src['banji_id']= array_column($khSrc->cyBanji($src),'id');
        }

        // 统计成绩
        $btj = new BTJ;
        $data = $btj->search($src);

        // 获取记录总数
        $cnt = count($data);
        // 截取当前页数据
        $data = array_slice($data, ($src['page'] - 1) * $src['limit'], $src['limit']);
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
    public function dwBiaoge($kaoshi_id)
    {
        // 设置页面标题
        $list['set'] = array(
            'webtitle' => '各班级成绩汇总表下载'
            ,'butname' => '下载'
            ,'formpost' => 'POST'
            ,'url' => '/chengji/bjtj/dwxlsx'
            ,'kaoshi_id' => $kaoshi_id
        );
        // 获取参与学校
        $khSrc = new \app\kaohao\model\Search;
        $src['kaoshi_id'] = $kaoshi_id;
        $list['set']['school_id'] = $khSrc->cySchool($src);
        // 获取年级与学科
        $ksset = new \app\kaoshi\model\KaoshiSet;
        $list['set']['nianji'] = $ksset->srcNianji($kaoshi_id);

        // 模板赋值
        $this->view->assign('list', $list);
        // 渲染
        return $this->view->fetch();

    }


    // 年级、班级学生成绩统计下载表格
    public function dwBanjixls()
    {
        // 获取表单参数
        $src = $this->request
            ->only([
                'kaoshi_id' => ''
                ,'ruxuenian' => ''
                ,'school_id' => array()
            ], 'POST');
        $src['school_id'] = strToarray($src['school_id']);

        // 获取相关参数
        $khSrc = new \app\kaohao\model\Search;  # 参考班级
        $src['banji_id']= array_column($khSrc->cyBanji($src), 'id');
        $btj = new BTJ;     # 成绩统计结果
        $data = $btj->search($src);
        $ntj = new \app\chengji\model\TongjiNj;
        $dataAll = $ntj->search($src);
        count($dataAll) > 0 ? $data['all'] = $dataAll[0] : $data;
        $ks = new \app\kaoshi\model\Kaoshi; # 参考学科
        $ksinfo = $ks->where('id', $src['kaoshi_id'])
                    ->field('id, title, bfdate')
                    ->find();
        $ksset = new \app\kaoshi\model\KaoshiSet;
        $xk = $ksset->srcSubject($src['kaoshi_id'], '', $src['ruxuenian']);
        $njlist = nianJiNameList($ksinfo->getData('bfdate'));   # 参考年级
        $nianji = $njlist[$src['ruxuenian']];
        $school = new \app\system\model\School; # 学校、年级信息
        $schoolname = $school->where('id', 'in', $src['school_id'])->value('jiancheng');
        $tabletitle = $ksinfo->title . ' ' . $schoolname . ' ' .  $nianji . '各班级成绩汇总';

        // 将数据写入表格中
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet;  # 创建文档
        $sheet = $spreadsheet->getActiveSheet();
        $thistime = date("Y-m-d h:i:sa");
        $spreadsheet->getProperties()   # 设置文档属性
            ->setCreator("码蚁成绩管理系统")    //作者
            ->setTitle("码蚁成绩管理")  //标题
            ->setLastModifiedBy(session('username')) //最后修改者
            ->setDescription("该表格由" . session('username') . session('id') . "于" . $thistime . "在码蚁成绩管理系统中下载，只作为内部交流材料,不允许外泄。")  //描述
            ->setKeywords("码蚁 成绩管理") //关键字
            ->setCategory("成绩管理"); //分类

        // 设置要导出的项目、列名、起始行
        $sbjcol = [
            'cjCnt' => '人数'
            ,'avg' => '平均分'
            ,'jige' => '及格率%'
            ,'youxiu' => '优秀率%'
        ];
        $sbjcolcnt = count($sbjcol);
        $colname = excelColumnName();
        $colcnt = $sbjcolcnt*count($xk)+3;

        // 设置表头信息
        $sheet->mergeCells('A1:' . $colname[$colcnt] . '1');
        $sheet->setCellValue('A1', $tabletitle);
        $sheet->mergeCells('A3:A4');
        $sheet->setCellValue('A3', '序号');
        $sheet->mergeCells('B3:B4');
        $sheet->setCellValue('B3', '班级');
        $col = 2;
        foreach ($xk as $key => $value) {   # 把学科信息定入表头
            $colend = $col + $sbjcolcnt - 1;
            $sheet->mergeCells($colname[$col].'3:'.$colname[$colend].'3');
            $sheet->setCellValue($colname[$col].'3', $value['title'].' ('.$value['fenshuxian']['manfen'].')');
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
        $sheet->getStyle('C3:'.$colname[$col].'4')->getAlignment()->setWrapText(true);

        $row = 5;      # 循环写入成绩
        foreach ($data as $key => $value) {
            $col = 2;
            $sheet->setCellValue('A'.$row, $row-4);
            if($key === 'all')
            {
                $sheet->setCellValue('B'.$row, '合计');
                $a = 'hj';
            }else{
                $sheet->setCellValue('B'.$row, $value['banji_title']);
                $a = 'val';
            }

            foreach ($xk as $ke => $val) {
                foreach ($sbjcol as $k => $v) {
                     $sheet->setCellValue($colname[$col].$row, $value['chengji'][$val['lieming']][$k]);
                     $col++;
                }
            }
            $sheet->setCellValue($colname[$col].$row, $value['quanke']['jige']);
            $col++;
            $sheet->setCellValue($colname[$col].$row, $value['quanke']['avg']);
            $row++;
        }

        // 设置表格格式
        $styleArray = [   # 居中
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER, //垂直居中
            ],
        ];
        $sheet->getStyle('A1:'.$colname[$col].($row-1))->applyFromArray($styleArray);
        $styleArray = [ # 加边框
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '00000000'],
                ],
            ],
        ];
        $sheet->getStyle('A3:'.$colname[$col].($row-1))
            ->applyFromArray($styleArray);
        $sheet->getStyle('A1')->getFont()->setBold(true)
            ->setName('宋体')->setSize(20); # 修改标题字号
        $sheet->getDefaultRowDimension()->setRowHeight(35); # 设置行高
        $sheet->getRowDimension('3:4')->setRowHeight(25);
        $sheet->getDefaultColumnDimension()->setWidth(8.3); # 设置列宽
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(10.5);

        // 页面设置
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE); # 横向
        $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);  # 大小A4
        $sheet->getPageMargins()->setTop(0.8); # 页边距
        $sheet->getPageMargins()->setRight(0.2);
        $sheet->getPageMargins()->setLeft(0.2);
        $sheet->getPageMargins()->setBottom(0.8);
        $sheet->getPageSetup()->setHorizontalCentered(true);  # 打印居中
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


    // 统计各班级成绩
    public function tongji()
    {
        // 获取变量
        $kaoshi_id = input('post.kaoshi_id');
        // 判断考试状态
        event('ksjs', $kaoshi_id);

        // 统计成绩
        $btj = new BTJ;
        $data = $btj->tjBanji($kaoshi_id);

        if (true == $data) {
            $data = ['msg' => '各班级成绩统计完成', 'val' => 1];
            $src = [
                'kaoshi_id' => $kaoshi_id,
                'category' => 'bjtj',
            ];
            event('tjlog', $src);
        } else {
            $data = ['msg' => '数据处理错误', 'val' => 0];
        }

        return json($data);
    }


    // 统计学生在班级名次
    public function bjOrder()
    {
        // 获取变量
        $kaoshi_id = input('post.kaoshi_id');
        // 判断考试状态
        event('ksjs', $kaoshi_id);

        // 统计成绩
        $btj = new BTJ;
        $data = $btj->bjOrder($kaoshi_id);

        if (true == $data) {
            $data = ['msg' => '学生成绩在班级位置统计完成。', 'val' => 1];
            $src = [
                'kaoshi_id' => $kaoshi_id
                ,'category' => 'bjwz'
            ];
            event('tjlog', $src);
        } else {
            $data = ['msg' => '数据处理错误', 'val' => 0];
        }

        return json($data);
    }


    // 统计平均分优秀率及格率
    public function myAvg($kaoshi_id)
    {
        // 获取参数
        $src = $this->request
            ->only([
                'kaoshi_id' => ''
                ,'ruxuenian' => ''
                ,'school_id' => array()
                ,'banji_id' => array()
                ,'xiangmu' => ''
            ], 'POST');

        if (count($src['banji_id']) == 0) {
            // 获取参与考试的班级
            $khSrc = new \app\kaohao\model\Search;
            $src['banji_id'] = array_column($khSrc->cyBanji($src), 'id');
        }

        // 统计成绩
        $btj = new BTJ;
        $data = $btj->search($src);
        $data = tiaoxingOnexiangmu($data, $src['xiangmu']);

        return json($data);
    }


    // 统计平均分优秀率及格率
    public function myXiangti($kaoshi_id)
    {
        // 获取参数
        $src = $this->request
            ->only([
                'kaoshi_id' => ''
                ,'ruxuenian' => ''
                ,'school_id' => array()
                ,'banji_id' => array()
            ], 'POST');

        if (count($src['banji_id']) == 0) {
            // 获取参与考试的班级
            $khSrc = new \app\kaohao\model\Search;
            $src['banji_id']= array_column($khSrc->cyBanji($src), 'id');
        }

        // 统计成绩
        $btj = new BTJ;
        $data = $btj->search($src);
        $data = xiangti($data);

        return json($data);
    }


}
