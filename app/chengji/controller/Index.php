<?php
namespace app\chengji\controller;

use app\base\controller\AdminBase;     # 引用控制器基类
use app\chengji\model\Chengji; # 引用成绩数据模型
use \app\kaoshi\model\Kaohao; # 引用考号数据模型
use \app\teach\model\Subject; # 引用学科数据模型

class Index extends AdminBase
{
    // 成绩列表
    public function index($kaoshi_id)
    {
        // 设置要给模板赋值的信息
        $list['webtitle'] = '学生成绩列表';

        // 获取参加考试的年级和学科
        $ksset = new \app\kaoshi\model\KaoshiSet;
        $list['set']['nianji'] = $ksset->srcGrade($kaoshi_id);
        $src['kaoshi_id'] = $kaoshi_id;
        $list['set']['subject_id'] = $ksset->srcSubject($src);
        if (count($list['set']['nianji']) > 0) {
            $src['ruxuenian']=$list['set']['nianji'][0];
        } else {
            $src['ruxuenian']=array();
        }
        $src['kaoshi_id'] = $kaoshi_id;
        $cy = new \app\kaohao\model\SearchCanYu;
        $list['set']['school_id'] = $cy->school($src);
        $list['kaoshi_id'] = $kaoshi_id;
        $list['dataurl'] = '/chengji/index/data';

        // 模板赋值
        $this->view->assign('list', $list);
        return $this->view->fetch();
    }


    // 获取成绩信息
    public function ajaxData()
    {
        // 获取参数
        $src = $this->request
            ->only([
                'page'
                ,'limit'
                ,'field' => 'id'
                ,'order' => 'asc'
                ,'kaoshi_id'
                ,'school_id'
                ,'ruxuenian'
                ,'banji_id' => array()
                ,'searchval'
            ], 'POST');

        // 获取参与考试的班级
        if (count($src['banji_id']) == 0) {
            $cy = new \app\kaohao\model\SearchCanYu;
            $src['banji_id']= array_column($cy->class($src), 'id');
        }

        // 实例化并查询成绩
        $cj = new Chengji;
        $data = $cj->search($src);
        $data = reSetArray($data, $src);

        return json($data);
    }


    // 批量删除成绩
    public function deletecjs($kaoshi_id)
    {
        // 设置页面标题
        $list['set'] = array(
            'webtitle' => '批量删除成绩',
            'butname' => '删除',
            'formpost' => 'POST',
            'url' => '/chengji/index/deletecjmore',
            'kaoshi_id' => $kaoshi_id
        );
        // 获取参加考试的学校和年级
        $cy = new \app\kaohao\model\SearchCanYu;
        $src['kaoshi_id'] = $kaoshi_id;
        $list['school'] = $cy->school($src);
        $ksset = new \app\kaoshi\model\KaoshiSet;
        $list['nianji'] = $ksset->srcGrade($kaoshi_id);

        // 模板赋值
        $this->view->assign('list', $list);
        return $this->view->fetch();
    }


    // 按条件删除成绩
    public function deletecjmore()
    {
        // 获取参数
        $src = $this->request->only([
            'kaoshi_id'
            ,'banji_id'
            ,'subject_id'
        ], 'POST');
        $banji_id = $src['banji_id'];
        $subject_id = $src['subject_id'];
        // 判断考试状态
        event('kslu', $src['kaoshi_id']);

        // 实例化验证模型
        $validate = new \app\chengji\validate\Cjdownload;
        $result = $validate->scene('deletemore')->check($src);
        $msg = $validate->getError();
        if(!$result){
            $this->error($msg);
        }

        // 获取要删除成绩的考号
        $kaohao = new \app\kaohao\model\Kaohao;
        $kaohaolist = $kaohao::where('kaoshi_id', $src['kaoshi_id'])
            ->where('banji_id', 'in', $banji_id)
            ->column('id');

        // 删除成绩
        $data = Chengji::destroy(function ($query) use ($kaohaolist, $subject_id) {
            $query->where('kaohao_id', 'in', $kaohaolist)
                  ->where('subject_id', 'in', $subject_id);
        });

        if ($data) {
            $this->success(
                $msg = '删除成功'
                ,$url = '/chengji/index/deletecjs/' . $src['kaoshi_id'], $data = ''
                ,$wait = 3
                ,$header = []
            );
        } else {
            $this->error(
                $msg = '删除失败'
                ,$url = '/chengji/index/deletecjs/' . $src['kaoshi_id']
                ,$wait = 3
            );
        }

        // 根据更新结果设置返回提示信息
        $data ? $data = ['msg' => '成绩删除成功', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];

        // 返回信息
        return json($data);
    }


    // 删除单人单科成绩
    public function delete($id)
    {
        // 整理数据
        $id = request()->delete('id');
        $id = explode(',', $id);

        $khid = Chengji::where('id', $id['0'])->value('kaohao_id');
        $kaoshi_id = Kaohao:: where('id', $khid)->value('Kaoshi_id');

        // 判断考试状态
        event('kslu', $kaoshi_id);
        $data = Chengji::destroy($id);

        // 根据更新结果设置返回提示信息
        $data ? $data = ['msg' => '删除成功', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];

        // 返回信息
        return json($data);
    }


    // 设置考试状态
    public function setStatus()
    {
        //  获取id变量
        $id = request()->post('id');
        $value = request()->post('value');

        $khid = Chengji::where('id', $id)->value('kaohao_id');
        $kaoshi_id = Kaohao:: where('id', $khid)->value('Kaoshi_id');
        event('kslu', $kaoshi_id);

        // 获取考试信息
        $data = Chengji::where('id', $id)->update(['status' => $value]);
        // 根据更新结果设置返回提示信息
        $data ? $data = ['msg' => '状态设置成功', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];

        // 返回信息
        return json($data);
    }


    // 下载成绩表格
    public function dwChengji($kaoshi_id)
    {
        // 设置页面标题
        $list['set'] = array(
            'webtitle' => '成绩下载'
            ,'butname' => '下载'
            ,'formpost' => 'POST'
            ,'url' => '/chengji/index/dwxlsx'
            ,'kaoshi_id' => $kaoshi_id
        );

        // 获取参加考试的学校和年级
        $cy = new \app\kaohao\model\SearchCanYu;
        $src['kaoshi_id'] = $kaoshi_id;
        $list['school_id'] = $cy->school($src);
        $ksset = new \app\kaoshi\model\KaoshiSet;
        $list['nianji'] = $ksset->srcGrade($kaoshi_id);

        // 模板赋值
        $this->view->assign('list', $list);
        // 渲染
        return $this->view->fetch();
    }


    //生成学生成绩表格
    public function dwchengjixlsx()
    {
        // 获取参数
        $src = $this->request
            ->only([
                'kaoshi_id'=>'1'
                ,'banji_id'=>array()
                ,'school_id'
                ,'ruxuenian'
                ,'subject_id'
            ], 'POST');

        // 获取要下载成绩的学校和年级信息
        $school = new \app\system\model\School;
        $schoolname = $school->where('id', $src['school_id'])->value('jiancheng');

        // 实例化验证模型
        $validate = new \app\chengji\validate\Cjdownload;
        $result = $validate->scene('download')->check($src);
        $msg = $validate->getError();
        if(!$result){
            $this->error($msg);
        }

        // 获取参与考试的班级
        ob_start();
        $more = new \app\kaohao\model\SearchMore;
        $chengjiinfo = $more->srcChengjiList($src);
        $ksset = new \app\kaoshi\model\KaoshiSet;
        $subject_id = $ksset->srcSubject($src);

        // 获取考试标题
        $ks = new \app\kaoshi\model\Kaoshi;
        $ks = $ks->where('id', $src['kaoshi_id'])
                ->field('id, title, bfdate, enddate')
                ->find();

        // 获取考试年级名称
        $njlist = nianJiNameList('str', $ks->getData('bfdate'));
        $nianji = $njlist[$src['ruxuenian']];
        $tabletitle = $ks->title . ' ' . $schoolname . ' ' . $nianji . ' ' . '学生成绩详细列表';
        $colname = excelColumnName();

        // set_time_limit(0);
        // 创建表格
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet;
        $sheet = $spreadsheet->getActiveSheet();
        $thistime = date("Y-m-d h:i:sa");
        // 设置文档属性
        $spreadsheet->getProperties()
            ->setCreator("码蚁成绩管理系统")    //作者
            ->setTitle("码蚁成绩管理")  //标题
            ->setLastModifiedBy(session('username')) //最后修改者
            ->setDescription("该表格由" . session('username') . session('id') . "于" . $thistime . "在码蚁成绩管理系统中下载，只作为内部交流材料,不允许外泄。")  //描述
            ->setKeywords("码蚁 成绩管理") //关键字
            ->setCategory("成绩管理"); //分类


        // 设置表头信息
        $sheet->setCellValue('A1', $tabletitle);
        $hb = 5 + count($subject_id);
        $sheet->mergeCells('A1:' . $colname[$hb] . '1');
        $sheet->mergeCells('A2:' . $colname[$hb] . '2');
        $sheet->setCellValue('A2', '考试时间：' . $ks->bfdate . ' ~ '. $ks->enddate);
        $sheet->setCellValue('A3', '序号');
        $sheet->setCellValue('B3', '班级');
        $sheet->setCellValue('C3', '姓名');
        $sheet->setCellValue('D3', '性别');
        $i = 4;
        foreach ($subject_id as $key => $value) {
            $sheet->setCellValue($colname[$i] . '3', $value['title']);
            $i ++;
        }
        $sheet->setCellValue($colname[$i] . '3', '平均分');
        $sheet->setCellValue($colname[$i + 1] . '3', '总分');
        $i = $i + 4;
        $sheet->setCellValue($colname[$i] . '3', '项目');
        $sheet->setCellValue($colname[$i] . '4', '人数');
        $sheet->setCellValue($colname[$i] . '5', '平均分');
        $sheet->setCellValue($colname[$i] . '6', '优秀率%');
        $sheet->setCellValue($colname[$i] . '7', '及格率%');
        $sheet->setCellValue($colname[$i] . '8', '标准差');
        $sheet->setCellValue($colname[$i] . '9', '中位数');
        $sheet->setCellValue($colname[$i] . '10', '众数');

        $i ++;
        foreach ($subject_id as $key => $value) {
            $sheet->setCellValue($colname[$i] . '3', $value['title']);
            $i ++;
        }

        // 循环写出成绩及个人信息
        $i = 4;
        foreach ($chengjiinfo as $key => $value) {
            // 表格赋值
            $sheet->setCellValue('A' . $i, $i - 2);
            $sheet->setCellValue('B' . $i, $value['banji_title']);
            $sheet->setCellValue('C' . $i, $value['student_xingming']);
            $sheet->setCellValue('D' . $i, $value['sex']);
            $colcnt = 4;
            foreach ($subject_id as $k => $val) {
                if(isset($value[$val['lieming']]))
                {
                    $sheet->setCellValue($colname[$colcnt] . $i, $value[$val['lieming']]);
                }
                $colcnt ++;
            }
            $sheet->setCellValue($colname[$colcnt] . $i, $value['avg']);
            $sheet->setCellValue($colname[$colcnt + 1] . $i, $value['sum']);
            $i ++;
        }

        // 表格格式
        $styleArrayJZ = [  # 居中
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER, //垂直居中
            ],
        ];
        $sheet->getStyle('A1:'.$colname[$colcnt + 1] . ($i - 1))->applyFromArray($styleArrayJZ);
        // 表格格式
        $styleArrayJZ = [  # 居中
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ],
        ];
        $sheet->getStyle('A2:'.$colname[$colcnt + 1] . ($i - 1))->applyFromArray($styleArrayJZ);
        $styleArrayBK = [ # 加边框
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '00000000'],
                ],
            ],
        ];
        $sheet->getStyle('A3:'.$colname[$colcnt + 1] . ($i - 1))->applyFromArray($styleArrayBK);

        $tj = new \app\chengji\model\Tongji;
        $temp = $tj->tongjiSubject($chengjiinfo, $subject_id);

        isset($colcnt) ? $colcnt = $colcnt + 5 : $colcnt = 12;
        $colBiankuang = $colcnt;
        // 循环写出统计结果
        foreach ($subject_id as $key => $value) {
            $sheet->setCellValue($colname[$colcnt] . '4', $temp['cj'][$value['lieming']]['xkcnt']);
            $sheet->setCellValue($colname[$colcnt] . '5', $temp['cj'][$value['lieming']]['avg']);
            $sheet->setCellValue($colname[$colcnt] . '6', $temp['cj'][$value['lieming']]['youxiu']);
            $sheet->setCellValue($colname[$colcnt] . '7', $temp['cj'][$value['lieming']]['jige']);
            $sheet->setCellValue($colname[$colcnt] . '8', $temp['cj'][$value['lieming']]['biaozhuncha']);
            $sheet->setCellValue($colname[$colcnt] . '9', $temp['cj'][$value['lieming']]['zhongweishu']);
            $sheet->setCellValue($colname[$colcnt] . '10', $temp['cj'][$value['lieming']]['zhongshu']);
            $colcnt ++;
        }


        $sheet->setCellValue($colname[$colBiankuang - 1] . '11', '总平均分');
        $sheet->setCellValue($colname[$colBiankuang] . '11', $temp['cj']['all']['avg']);
        $sheet->mergeCells($colname[$colBiankuang] . '11:' . $colname[$colcnt - 1] . '11');
        $sheet->setCellValue($colname[$colBiankuang - 1] . '12', '全科及格率%');
        $sheet->setCellValue($colname[$colBiankuang] . '12', $temp['cj']['all']['jige']);
        $sheet->mergeCells($colname[$colBiankuang] . '12:' . $colname[$colcnt - 1] . '12');
        $sheet->getStyle($colname[$colBiankuang - 1] . '3:' . $colname[$colcnt - 1] . '12')->applyFromArray($styleArrayJZ);
        $sheet->getStyle($colname[$colBiankuang - 1] . '3:' . $colname[$colcnt - 1] . '12')->applyFromArray($styleArrayBK);


        $sheet->getStyle('A1')->getFont()->setBold(true)->setName('宋体')->setSize(16); # 修改标题字号
        $sheet->getDefaultRowDimension()->setRowHeight(22.5); # 设置行高
        $sheet->getRowDimension('1')->setRowHeight(25);
        $sheet->getDefaultColumnDimension()->setWidth(9); # 设置列宽
        $sheet->getColumnDimension('A')->setWidth(6);
        $sheet->getColumnDimension('B')->setWidth(12);
        $sheet->getColumnDimension($colname[$colBiankuang-1])->setWidth(13);

        // 页面设置
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
        $sheet->getPageMargins()->setTop(0.8); # 页边距
        $sheet->getPageMargins()->setRight(0.2);
        $sheet->getPageMargins()->setLeft(0.2);
        $sheet->getPageMargins()->setBottom(0.8);
        $sheet->getPageSetup()->setHorizontalCentered(true); # 打印居中
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
        exit();
    }


    // 下载成绩表格
    public function dwChengjitiao($kaoshi_id)
    {
        // 设置页面标题
        $list['set'] = array(
            'webtitle' => '成绩下载'
            ,'butname' => '下载'
            ,'formpost' => 'POST'
            ,'url' => '/chengji/index/dwcjtiaoxlsx'
            ,'kaoshi_id' => $kaoshi_id
        );

        // 获取参加考试的学校和年级
        $cy = new \app\kaohao\model\SearchCanYu;
        $src['kaoshi_id'] = $kaoshi_id;
        $list['school_id'] = $cy->school($src);
        $ksset = new \app\kaoshi\model\KaoshiSet;
        $list['nianji'] = $ksset->srcGrade($kaoshi_id);

        // 模板赋值
        $this->view->assign('list', $list);
        return $this->view->fetch('dw_chengji');
    }


    //生成学生成绩条表格
    public function dwchengjitiaoxlsx()
    {
        // 获取参数
        $src = $this->request
            ->only([
                'kaoshi_id' => '1'
                ,'banji_id' => array()
                ,'school_id'
                ,'ruxuenian'
                ,'subject_id'
            ], 'POST');
        // 获取要下载成绩的学校和年级信息
        $school = new \app\system\model\School;
        $schoolname = $school->where('id', $src['school_id'])->value('jiancheng');

        // 实例化验证模型
        $validate = new \app\chengji\validate\Cjdownload;
        // 验证表单数据
        $result = $validate->check($src);
        $msg = $validate->getError();

        // 如果验证不通过则停止保存
        if (!$result) {
            $this->error($msg);
        }

        // 获取参与考试的班级
        ob_start();
        $more = new \app\kaohao\model\SearchMore;
        $cy = new \app\kaohao\model\SearchCanYu;
        $chengjiinfo = $more->srcChengjiList($src);
        $ksset = new \app\kaoshi\model\KaoshiSet;
        $subject_id = $ksset->srcSubject($src);

        $tj = new \app\chengji\model\Tongji;
        $srcAll = [
            'kaoshi_id' => $src['kaoshi_id'],
            'ruxuenian' => $src['ruxuenian']
        ];
        $srcAll['banji_id']= array_column($cy->class($srcAll), 'id');
        $chengjiinfo = $more->srcChengjiList($src);
        $njtj = $tj->tongjiSubject($chengjiinfo, $subject_id);

        // 获取考试标题
        $ks = new \app\kaoshi\model\Kaoshi;
        $ks = $ks->where('id', $src['kaoshi_id'])
                ->field('id, title, bfdate, enddate')
                ->find();

        // 获取考试年级名称
        $njlist = nianJiNameList('str', $ks->getData('bfdate'));
        $nianji = $njlist[$src['ruxuenian']];
        $tabletitle = $ks->title . ' ' . $schoolname . ' ' . $nianji . ' ' . '学生成绩条';

        // set_time_limit(0);
        // 创建表格
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet;
        $sheet = $spreadsheet->getActiveSheet();
        $thistime = date("Y-m-d h:i:sa");
        // 设置文档属性
        $spreadsheet->getProperties()
            ->setCreator("码蚁成绩管理系统")    //作者
            ->setTitle("码蚁成绩管理")  //标题
            ->setLastModifiedBy(session('username')) //最后修改者
            ->setDescription("该表格由" . session('username') . session('id' ) ."于" . $thistime . "在码蚁成绩管理系统中下载，只作为内部交流材料,不允许外泄。")  //描述
            ->setKeywords("码蚁 成绩管理") //关键字
            ->setCategory("成绩管理"); //分类

        $row = 1;   # 定义从 $row 行开始写入数据
        $rows = count($subject_id);  # 定义学生信息列要合并的行数

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
            $sheet->setCellValue('A' . $row, '学校');
            $sheet->mergeCells('A' . ($row + 1).':' . 'A' . ($row + $rows)); # 输入学科名
            $sheet->setCellValue('A' . ($row + 1), $schoolname);
            $sheet->setCellValue('B' . $row, '班级');
            $sheet->mergeCells('B' . ($row + 1) . ':' . 'B' . ($row + $rows)); # 输入学科名
            $sheet->getStyle('B' . ($row + 1))->getAlignment()->setWrapText(true);
            $sheet->setCellValue('B' . ($row + 1), $value['banji_title']);
            $sheet->setCellValue('C' . $row, '姓名');
            $sheet->mergeCells('C' . ($row + 1) . ':' . 'C' . ($row + $rows)); # 输入学科名
            $sheet->setCellValue('C' . ($row + 1), $value['student_xingming']);
            $sheet->setCellValue('D' . $row, '学科');
            $sheet->setCellValue('E' . $row, '得分');
            $sheet->setCellValue('F' . $row, '平均分');
            $sheet->setCellValue('G' . $row, '优秀率%');
            $sheet->setCellValue('H' . $row, '及格率%');
            $sheet->setCellValue('I' . $row, '最高分');
            $sheet->setCellValue('J' . $row, '%25');
            $sheet->setCellValue('K' . $row, '%50');
            $sheet->setCellValue('L' . $row, '%75');
            $row = $row + 1 ;

            // 写入成绩
            foreach ($subject_id as $k => $val) {
                $sheet->setCellValue('D' . ($row + $k), $val['title']);
                $sheet->setCellValue('E' . ($row + $k), $value[$val['lieming']]);   # 得分
                $sheet->setCellValue('F' . ($row + $k), $njtj['cj'][$val['lieming']]['avg']);
                $sheet->setCellValue('G' . ($row + $k), $njtj['cj'][$val['lieming']]['max']);
                $sheet->setCellValue('H' . ($row + $k), $njtj['cj'][$val['lieming']]['youxiu']);
                $sheet->setCellValue('I' . ($row + $k), $njtj['cj'][$val['lieming']]['jige']);
                $sheet->setCellValue('J' . ($row + $k), $njtj['cj'][$val['lieming']]['sifenwei'][0]);
                $sheet->setCellValue('K' . ($row + $k), $njtj['cj'][$val['lieming']]['sifenwei'][1]);
                $sheet->setCellValue('L' . ($row + $k), $njtj['cj'][$val['lieming']]['sifenwei'][2]);
            }

            // 设置格式
            $sheet->getStyle('A' . ($row - 1) . ':L' . ($row + $rows - 1))->applyFromArray($styleArray);
            $row = $row + $rows + 1 ;
        }

        // 保存文件
        $filename = $tabletitle . date('ymdHis') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        ob_flush();
        flush();
        exit();
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
                    'order'=>'desc',
                    'kaohao'=>''
                ],'POST');

        $chengji = new Chengji;

        $data = $chengji
                ->where('kaohao_id',$src['kaohao'])
                ->field('id,kaohao_id,subject_id,user_id,user_group,defen,update_time')
                ->order([$src['field']=>$src['order']])
                ->with([
                    'subjectName'=>function($query){
                        $query->field('id,title');
                    }
                ])
                ->append(['userInfo'])
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
