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
    public function createAll($kaoshi_id)
    {
        // 获取参考年级
        $ksset = new ksset;
        $list['data']['nianji'] = $ksset->srcNianji($kaoshi_id);
        $list['data']['nianjiNum'] = array_column($list['data']['nianji'], 'nianji');

        // 设置页面标题
        $list['set'] = array(
            'webtitle' => '生成考号'
            ,'butname' => '生成'
            ,'formpost' => 'POST'
            ,'url' => '/kaoshi/kaohao/saveall'
            ,'kaoshi_id' => $kaoshi_id
        );

        // 模板赋值
        $this->view->assign('list', $list);
        // 渲染
        return $this->view->fetch();
    }


    // 保存考号
    public function saveAll()
    {
        // 获取表单数据
        $list = request()->only([
            'school_id'
            ,'kaoshi_id'
            ,'banji_id'
        ], 'POST');

        event('kslu', $list['kaoshi_id']);
        // 验证表单数据
        $validate = new \app\kaoshi\validate\Kaohao;
        $result = $validate->check($list);
        $msg = $validate->getError();
        if(!$result){
            return ['msg' => $msg, 'val' => 0];
        }

        // 获取参加考试学生名单
        $stu = new \app\renshi\model\Student;
        $src = [
            'banji_id' => $list['banji_id']
            ,'kaoshi' => 1
            ,'status' => 1
        ];
        $stulist = $stu->search($src)
            ->visible([
                'id'
                ,'school_id'
                ,'banji_id'
                ,'stuBanji' => [
                    'id'
                    ,'ruxuenian'
                    ,'paixu'
                ]
            ]);

        // 获取参加考试年级数组
        $bfdate = KS::where('id', $list['kaoshi_id'])->value('bfdate');
        $njlist = nianJiNameList($bfdate);
        // 重新组合学生信息
        $kaohao = array();
        foreach ($stulist as $key => $value) {
            $check = KH::withTrashed()
                        ->where('kaoshi_id', $list['kaoshi_id'])
                        ->where('student_id', $value->id)
                        ->find();
            if($check)
            {
                if($check->delete_time > 0)
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
            $kaohao[$key]['student_id'] = $value->id;
            $kaohao[$key]['school_id'] = $list['school_id'];
            $kaohao[$key]['ruxuenian'] = $value->stuBanji->ruxuenian;
            $kaohao[$key]['nianji'] = $njlist[$kaohao[$key]['ruxuenian']];
            $kaohao[$key]['banji_id'] = $value->stuBanji->id;
            $kaohao[$key]['paixu'] = $value->stuBanji->paixu;
            $kaohao[$key]['kaoshi_id'] = $list['kaoshi_id'];
        }

        // 保存考号
        $kh = new \app\kaoshi\model\Kaohao;
        $data = $kh
            ->allowField([ # 不是最佳实践
                'id'
                ,'kaoshi_id'
                ,'student_id'
                ,'school_id'
                ,'ruxuenian'
                ,'nianji'
                ,'banji_id'
                ,'paixu'
                ,'create_time'
                ,'update_time'
            ])
            ->saveAll($kaohao);

        // 根据更新结果设置返回提示信息
        $data ? $data = ['msg' => '生成成功', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];

        // 返回信息
        return json($data);
    }


    // 添加单条考号
    public function create($kaoshi_id)
    {
        // 获取参考年级、学科
        $ksset = new ksset;
        $list['data']['nianji'] = $ksset->srcNianji($kaoshi_id);
        $kh = new KH;
        $src['kaoshi_id'] = $kaoshi_id;
        if(count($list['data']['nianji']) > 0){
            $src['ruxuenian'] = $list['data']['nianji'][0];
        } else {
            $src['ruxuenian'] = array();
        }

        // 设置页面标题
        $list['set'] = array(
            'webtitle' => '添加考号'
            ,'butname' => '添加'
            ,'formpost' => 'POST'
            ,'url' => '/kaoshi/kaohao/saveOne'
            ,'kaoshi' => $kaoshi_id
        );

        // 模板赋值
        $this->view->assign('list', $list);
        // 渲染
        return $this->view->fetch();
    }


    // 保存单条考号
    public function save()
    {
        // 获取表单数据
        $list = request()->only([
            'kaoshi_id'
            ,'banji'
            ,'student_id'
        ], 'POST');
        $list['student_id'] = explode(' ', $list['student_id']);
        $list['student_id'] = $list['student_id'][1];

        event('kslu', $list['kaoshi_id']);

        // 查询考号是否存在
        $ks = KH::withTrashed()
                ->where('kaoshi_id', $list['kaoshi_id'])
                ->where('student_id', $list['student_id'])
                ->find();

        // 如果存在成绩则更新，不存在则添加
        if($ks)
        {
            // 判断记录是否被删除
            if($ks->delete_time > 0)
            {
                $ks->restore();
            }
            $data = ['msg' => '生成成功', 'val' => 1];
        }else{
            // 获取参加考试年级数组
            $bfdate = KS::where('id', $list['kaoshi_id'])->value('bfdate');
            $njlist = nianjiList($bfdate);

            // 获取班级信息
            $bj = new \app\teach\model\Banji;
            $bjinfo = $bj->where('id', $list['banji_id'])->find();
            $list['school_id'] = $bjinfo->school;
            $list['ruxuenian'] = $bjinfo->ruxuenian;
            $list['nianji'] = $njlist[$bjinfo->ruxuenian];
            $list['paixu'] = $bjinfo->paixu;
            $data = KH::create($list);
        }

        // 根据更新结果设置返回提示信息
        $data ? $data = ['msg' => '生成成功', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];

        // 返回信息
        return json($data);
    }


    // 学生信息
    public function read($id)
    {
        $list['webtitle'] ='成绩';
        $list['dataurl'] = '/renshi/studentcj/chengjilist';
        $list['id'] = $id;

        $stucj = new KH;
        $defen = $stucj->khSrcChengji($id);
        $color = [
            'layui-bg-red'
            ,'layui-bg-orange'
            ,'layui-bg-green'
            ,'layui-bg-cyan'
            ,'layui-bg-blue'
            ,'layui-bg-black'
        ];

        foreach ($defen->ksChengji as $key => $value) {
            $list['cj'][$value->subject_id]['defen'] = $value->defen * 1;
            $list['cj'][$value->subject_id]['defenlv'] = $value->defenlv * 1;
            $list['cj'][$value->subject_id]['title'] = $value->subjectName->title;
            $list['cj'][$value->subject_id]['color'] = $color[$key % 5];
        }

        // // 模板赋值
        $this->view->assign('list', $list);
        // 渲染模板
        return $this->view->fetch();
    }


    // 标签下载
    public function biaoqian($kaoshi_id)
    {
        // 获取参考年级、学科
        $ksset = new ksset;
        $list['data']['nianji'] = $ksset->srcNianji($kaoshi_id);
        $kh = new KH;
        $src['kaoshi_id'] = $kaoshi_id;
        if(count($list['data']['nianji']) > 0){
            $src['ruxuenian'] = $list['data']['nianji'][0];
        } else {
            $src['ruxuenian'] = array();
        }
        $list['data']['school'] = $kh->cySchool($src);
        // 设置页面标题
        $list['set'] = array(
            'webtitle' => '下载考号'
            ,'butname' => '下载'
            ,'formpost' => 'POST'
            ,'url' => '/kaoshi/kaohao/biaoqianxls'
            ,'kaoshi_id' => $kaoshi_id
        );

        // 模板赋值
        $this->view->assign('list', $list);
        // 渲染
        return $this->view->fetch();
    }


    //生成标签信息
    public function biaoqianXls()
    {
        // 获取表单数据
        $list = request()->only([
            'banji_id'=>array()
            ,'kaoshi_id'
            ,'subject_id'=>array()
        ], 'POST');
        event('kslu', $list['kaoshi_id']);
        $kaoshi_id = $list['kaoshi_id'];
        $banji_id = $list['banji_id'];
        $subject = $list['subject_id'];

        // 实例化验证模型
        $validate = new \app\kaoshi\validate\Biaoqian;
        $result = $validate->scene('biaoqian')->check($list);
        $msg = $validate->getError();
        if(!$result){
            $this->error($msg);
        }

        $ks = new KS();
        $kslist = $ks::where('id', $kaoshi_id)
                    ->field('id, title')
                    ->find();
        // 获取参考学科
        $ksset = new ksset();
        $ksSubject = $ksset->srcSubject($kaoshi_id, $list['subject_id'], '');

        // 查询考号
        $kh = new KH();
        $src = [
            'kaoshi_id' => $kaoshi_id
            ,'banji_id' => $banji_id
        ];
        $kaohao = $kh->srcBanjiKaohao($src);

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
            ->setDescription("该表格由" . session('username') . session('id') . "于" . $thistime . "在尚码成绩管理系统中下载，只作为内部交流材料,不允许外泄。")  //描述
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
                    $sheet->setCellValue('A' . $i, $i-1);
                    $stuKaohao = '';
                    $stuKaohao = $md5->encrypt($kh->id . '|' . $sbj['id'], 'dlbz');
                    $sheet->setCellValue('C' . $i, $bj->cjSchool->jiancheng);
                    $sheet->setCellValue('B' . $i, $stuKaohao);
                    $sheet->setCellValue('D' . $i, $bj->cjBanji->numTitle);
                    $sheet->setCellValue('E' . $i, $sbj['jiancheng']);
                    $sheet->setCellValue('F' . $i, $kh->cjStudent['xingming']);
                    $i++;
                }
            }
        }

        // 保存文件
        $filename = $kslist->title . ' 标签数据' . date('ymdHis') . '.xls';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');

        // 保存文件
        $filename = $kslist->title . ' 标签数据' . date('ymdHis') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        ob_flush();
        flush();
    }


    // 下载考试成绩采集表
    public function caiji($kaoshi_id)
    {
        // 获取参考年级、学科
        $ksset = new ksset;
        $list['data']['nianji'] = $ksset->srcNianji($kaoshi_id);
        $kh = new KH;
        $src['kaoshi_id'] = $kaoshi_id;
        if(count($list['data']['nianji']) > 0){
            $src['ruxuenian'] = $list['data']['nianji'][0];
        } else {
            $src['ruxuenian'] = array();
        }
        $list['data']['school'] = $kh->cySchool($src);

        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'下载成绩采集表'
            ,'butname'=>'下载'
            ,'formpost'=>'POST'
            ,'url'=>'/kaoshi/kaohao/dwcaiji'
            ,'kaoshi_id'=>$kaoshi_id
        );

        // 模板赋值
        $this->view->assign('list', $list);
        // 渲染
        return $this->view->fetch('biaoqian');
    }


    // 获取参考名单
    public function dwcaiji()
    {
        // 获取表单数据
        $list = request()->only([
            'banji_id' => array()
            ,'ruxuenian'
            ,'kaoshi_id'
            ,'subject_id' => array()
        ], 'POST');
        event('kslu', $list['kaoshi_id']);

        $kaoshi_id = $list['kaoshi_id'];
        $banji_id = $list['banji_id'];
        $subject_id = $list['subject_id'];

        // 验证表单数据
        $validate = new \app\kaoshi\validate\Biaoqian;
        $result = $validate->scene('caiji')->check($list);
        $msg = $validate->getError();
        if(!$result){
            $this->error($msg);
        }

        $ks = new KS();
        $kslist = $ks::where('id', $kaoshi_id)
                    ->field('id, title')
                    ->find();
        // 获取参加考试学科
        $ksset = new ksset();
        $ksSubject = $ksset->srcSubject($kaoshi_id, $list['subject_id']);

        // 查询考号
        $kh = new KH();
        $src = [
            'kaoshi_id' => $kaoshi_id
            ,'banji_id' => $banji_id
        ];
        $kaohao = $kh->srcBanjiKaohao($src);

        // 获取电子表格列名
        $lieming = excelColumnName();
        // 创建表格
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $thistime = date("Y-m-d h:i:sa");
        // 设置文档属性
        $spreadsheet->getProperties()
            ->setCreator("尚码成绩管理系统")    //作者
            ->setTitle("尚码成绩管理")  //标题
            ->setLastModifiedBy(session('username')) //最后修改者
            ->setDescription("该表格由" . session('username') . session('id') . "于" . $thistime . "在尚码成绩管理系统中下载，只作为内部交流材料,不允许外泄。")  //描述
            ->setKeywords("尚码 成绩管理") //关键字
            ->setCategory("成绩管理"); //分类

        // 设置表格标题与表头信息
        $sheet->setCellValue('A1',$kslist->title . ' 成绩采集表');

        $sheet->setCellValue('A2', $kaoshi_id);
        $sheet->setCellValue('B2', $list['ruxuenian']);
        $sheet->setCellValue('A3', '序号');
        $sheet->setCellValue('B3', '编号');
        $sheet->setCellValue('C3', '班级');
        $sheet->setCellValue('D3', '姓名');
        // 获取列数并合并和一行
        $col = $lieming[count($ksSubject) + 3];
        $sheet->mergeCells('A1:' . $col . '1');

         // 写入列名
        foreach ($ksSubject as $key => $value) {
            $sheet->setCellValue($lieming[$key + 4] . '3', $value['title']);
            $sheet->setCellValue($lieming[$key + 4] . '2', $value['id']);
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
                $sheet->setCellValue('A' . $i, $i - 3);
                $sheet->setCellValue('B' . $i, $kh->id);
                $sheet->setCellValue('C' . $i, $bj->cjBanji->banjiTitle);
                $sheet->setCellValue('D' . $i, $kh->cjStudent->xingming);
                $i ++;
            }
        }

        // 居中
        $styleArray = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER, //垂直居中
            ],
        ];
        $sheet->getStyle('A1:' . $col . ($i - 1))->applyFromArray($styleArray);

        // 加边框
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '00000000'],
                ],
            ],
        ];
        $sheet->getStyle('A3:' . $col . ($i - 1))->applyFromArray($styleArray);
        // 修改标题字号
        $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setBold(true)->setName('宋体')->setSize(11);
        // 设置行高
        $spreadsheet->getActiveSheet()->getDefaultRowDimension()->setRowHeight(20);
        $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(25);
        // 设置筛选
        $sheet->setAutoFilter('A3:' . $col . ($i - 1));


        // 保存文件
        $filename = $kslist->title . '成绩采集表' . date('ymdHis') . '.xlsx';
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
        // 整理数据
        $id = request()->delete('id');
        $id = explode(',', $id);

        // 判断考试结束时间是否已过
        $ksid = KH::where('id',$id[0])->value('kaoshi');
        event('kslu',$ksid);

        $data = KH::destroy($id);
        // 根据更新结果设置返回提示信息
        $data ? $data = ['msg' => '删除成功', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];
    // 返回信息
        return json($data);
    }
}
