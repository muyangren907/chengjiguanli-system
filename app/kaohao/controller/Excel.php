<?php
namespace app\kaohao\controller;

// 引用控制器基类
use app\base\controller\AdminBase;

// 引用数据模型类
use app\kaoshi\model\Kaoshi as KS;
use app\kaohao\model\SearchMore as srcMore;
use app\kaohao\model\SearchCanYu as srcCy;
use app\kaoshi\model\KaoshiSet as ksset;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use \Endroid\QrCode\QrCode;
use think\Validate;


class Excel extends AdminBase
{
    // 标签下载
    public function biaoqian($kaoshi_id)
    {
        // 获取参考年级、学科
        $ksset = new ksset;
        $list['data']['nianji'] = $ksset->srcGrade($kaoshi_id);
        $srcMore = new srcMore;
        $src['kaoshi_id'] = $kaoshi_id;
        if(count($list['data']['nianji']) > 0){
            $src['ruxuenian'] = $list['data']['nianji'][0];
        } else {
            $src['ruxuenian'] = array();
        }
        $srcCy = new srcCy();
        $list['data']['school'] = $srcCy->school($src);
        // 设置页面标题
        $list['set'] = array(
            'webtitle' => '下载考号'
            ,'butname' => '下载'
            ,'formpost' => 'POST'
            ,'url' => '/kaohao/excel/biaoqianxls'
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

        ob_start();
        $ks = new KS();
        $kslist = $ks::where('id', $kaoshi_id)
                    ->field('id, title')
                    ->find();
        // 获取参考学科
        $ksset = new ksset();
        $ksSubject = $ksset->srcSubject($list);

        // 查询考号
        $srcMore = new srcMore();
        $src = [
            'kaoshi_id' => $kaoshi_id
            ,'banji_id' => $banji_id
        ];
        $kaohao = $srcMore->srcBanjiKaohao($src);

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
                    $stuKaohao = \app\facade\Tools::encrypt($kh->id . '|' . $sbj['id'], 'dlbz');
                    $sheet->setCellValue('C' . $i, $bj->cjSchool->jiancheng);
                    $sheet->setCellValue('B' . $i, $stuKaohao);
                    $sheet->setCellValue('D' . $i, $bj->numBanjiTitle);
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

        ob_flush();
        flush();
        exit();
    }


    // 下载考试成绩采集表
    public function caiji($kaoshi_id)
    {
        // 获取参考年级、学科
        $ksset = new ksset;
        $list['data']['nianji'] = $ksset->srcGrade($kaoshi_id);
        $srcMore = new srcMore;
        $src['kaoshi_id'] = $kaoshi_id;
        if(count($list['data']['nianji']) > 0){
            $src['ruxuenian'] = $list['data']['nianji'][0];
        } else {
            $src['ruxuenian'] = array();
        }
        $srcCy = new srcCy();
        $list['data']['school'] = $srcCy->school($src);

        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'下载成绩采集表'
            ,'butname'=>'下载'
            ,'formpost'=>'POST'
            ,'url'=>'/luru/index/dwcaiji'
            ,'kaoshi_id'=>$kaoshi_id
        );

        // 模板赋值
        $this->view->assign('list', $list);
        // 渲染
        return $this->view->fetch('biaoqian');
    }
}
