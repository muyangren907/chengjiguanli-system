<?php

namespace app\teach\controller;

// 引用控制器基类
use app\common\controller\Base;
// 引用学期数据模型类
use app\teach\model\Kaoshi as KS;
// 引用学生类
use app\renshi\model\Student;
// 引用成绩类
use app\chengji\model\Chengji;
// 引用PhpSpreadsheet类
use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// use PhpOffice\PhpSpreadsheet\IOFactory;

use \Endroid\QrCode\QrCode;

class Kaoshi extends Base
{
    // 显示学期列表
    public function index()
    {

        // 设置数据总数
        $list['count'] = KS::count();
        // 设置页面标题
        $list['title'] = '考试列表';

        // 模板赋值
        $this->assign('list', $list);

        // 渲染模板
        return $this->fetch();
    }


    // 获取学期信息列表
    public function ajaxData()
    {

        // 获取DT的传值
        $getdt = request()->param();

        //得到排序的方式
        $order = $getdt['order'][0]['dir'];
        //得到排序字段的下标
        $order_column = $getdt['order'][0]['column'];
        //根据排序字段的下标得到排序字段
        $order_field = $getdt['columns'][$order_column]['data'];
        //得到limit参数
        $limit_start = $getdt['start'];
        $limit_length = $getdt['length'];
        //得到搜索的关键词
        $search = $getdt['search']['value'];


        // 获取记录集总数
        $cnt = KS::count();
        //查询数据
        $data =KS::field('id,title,xueqi,category,bfdate,enddate,status')
            ->order([$order_field=>$order])
            ->limit($limit_start,$limit_length)
            ->all();
        

        // 如果需要查询
        if($search){
            $data = KS::field('id,title,xueqi,category,bfdate,enddate,status')
                ->order([$order_field=>$order])
                ->limit($limit_start,$limit_length)
                ->whereOr('title','like','%'.$search.'%')
                ->whereOr('category','in',function($query) use($search)
                {
                    $query->name('category')
                        ->where('title','like','%'.$search.'%')
                        ->field('id');
                })
                ->all();
        }

        $data = $data->append(['nianjinames','subjectnames','jieshu','kaishi']);

        $datacnt = $data->count();
        

        $data = [
            'draw'=> $getdt["draw"] , // ajax请求次数，作为标识符
            'recordsTotal'=>$datacnt,  // 获取到的结果数(每页显示数量)
            'recordsFiltered'=>$cnt,       // 符合条件的总数据量
            'data'=>$data, // 获取到的数据结果
        ];


        return json($data);
    }



    // 创建学期
    public function create()
    {
        // 设置页面标题
        $list['title'] = '添加学期';

        // 模板赋值
        $this->assign('list',$list);

        // 渲染
        return $this->fetch();
    }

    

    // 保存信息
    public function save()
    {
        // 实例化验证模型
        $validate = new \app\teach\validate\Kaoshi;


        // 获取表单数据
        $list = request()->only(['title','xueqi','category','bfdate','enddate','nianji','subject','manfen','zuzhi'],'post');


        // 验证表单数据
        $result = $validate->check($list);
        $msg = $validate->getError();


        // 如果验证不通过则停止保存
        if(!$result){
            return json(['msg'=>$msg,'val'=>0]);
        }


        // 保存数据 
        $ks = new KS();

        $ksdata = $ks->create($list);

       

        // 获取年级列表
        $njname = nianjilist();
        // 重组参加考试年级信息
        foreach ($list['nianji'] as $key => $value) {
            $nianjiarr[]=['nianji'=>$value,'nianjiname'=>$njname[$value]];
        }

        // 添加考试年级信息
        $njdata = $ksdata->kaoshinianji()->saveAll($nianjiarr);

        // 过滤分数掉空值
        $list['manfen'] = array_values(array_filter($list['manfen']));

        // 重组参加考试学科信息
        foreach ($list['subject'] as $key => $value) {
            $subjectarr[]=[
                'subjectid'=>$value,
                'manfen'=>$list['manfen'][$key]
            ];
        }

        // 添加考试学科信息
        $xkdata = $ksdata->kaoshisubject()->saveAll($subjectarr);

        // 根据更新结果设置返回提示信息
        $ksdata&&$njdata&&$xkdata ? $data=['msg'=>'添加成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }

    //
    public function read($id)
    {
        //
    }




    // 修改学期信息
    public function edit($id)
    {

        // 获取学期信息
        $list = KS::where('id',$id)
            ->field('id,title,xueqi,category,bfdate,enddate,zuzhi')
            // ->with('kaoshisubject')
            ->find();

        $list = $list->append(['nianjiids','manfenedit']);

        // 模板赋值
        $this->assign('list',$list);

        //渲染模板
        return $this->fetch();

    }





    // 更新学期信息
    public function update($id)
    {
        $validate = new \app\teach\validate\Kaoshi;

        // 获取表单数据
        $list = request()->only(['title','xueqi','category','bfdate','enddate','nianji','subject','zuzhi','manfen'],'post');

        // 验证表单数据
        $result = $validate->check($list);
        $msg = $validate->getError();

        

        // 如果验证不通过则停止保存
        if(!$result){
            return json(['msg'=>$msg,'val'=>0]);;
        }

        $list['id'] = $id;
        // 更新数据
        $ks = new KS();
        $ksdata = $ks::update($list);


        // 删除参加考试的年级和学科
        $ksdata->kaoshinianji()->delete();
        $ksdata->kaoshisubject()->delete();


        // 添加考试年级和学科
        // 获取年级列表
        $njname = nianjilist();
        // 重组参加考试年级信息
        foreach ($list['nianji'] as $key => $value) {
            $nianjiarr[]=['nianji'=>$value,'nianjiname'=>$njname[$value]];
        }

        // 添加考试年级信息
        $njdata = $ksdata->kaoshinianji()->saveAll($nianjiarr);

        
        // 过滤分数掉空值
        $list['manfen'] = array_values(array_filter($list['manfen']));
        // 重组参加考试学科信息
        foreach ($list['subject'] as $key => $value) {
            $subjectarr[]=[
                'subjectid'=>$value,
                'manfen'=>$list['manfen'][$key]
            ];
        }
        // 添加考试学科信息
        $xkdata = $ksdata->kaoshisubject()->saveAll($subjectarr);

        // 根据更新结果设置返回提示信息
        $ksdata&&$njdata&&$xkdata ? $data=['msg'=>'更新成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }

    



    // 删除学期
    public function delete($id)
    {

        if($id == 'm')
        {
            $id = request()->delete('ids/a');// 获取delete请求方式传送过来的数据并转换成数据
        }

        $data = KS::destroy($id);

        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'删除成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }



    // 设置学期状态
    public function setStatus()
    {

        //  获取id变量
        $id = request()->post('id');
        $value = request()->post('value');

        // 获取学期信息
        $data = KS::where('id',$id)->update(['status'=>$value]);

        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'状态设置成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
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
        // 获取表单数据
        $list = request()->only(['kaoshi','banjiids'],'post');
        // 获取参加考试班级
        $list['banjiids'] = implode(',',$list['banjiids']);

        // 获取参加考试学生名单
        $stulist = Student::where('status',1)
                        ->where('banji','in',$list['banjiids'])
                        ->field('id,school,banji')
                        ->append(['nianji'])
                        ->select();

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
    public function biaoqian()
    {

        $id = 2;
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

        // 获取表单数据
        $list = request()->only(['id','banjis','subjects'],'post');
        $list = ['id'=>2,'banjis'=>'1,2,3,4,5,6,13','subjects'=>'1,2,3'];

        // 获取考试标题
        $kstitle = KS::where('id',$list['id'])->value('title');

        // 获取参加考试学科信息
        $subject = new \app\teach\model\Subject();
        $xks = $subject->where('id','in',$list['subjects'])->column('id,title,lieming');
        
        // 循环组成第三行表头信息
        $biaotou = ['序号','参考号','班级','姓名'];
        foreach ($xks as $key => $value) {
            $biaotou[] = $value['title'];
        }

        // 获取电子表格列名
        $lieming = excelLieming();

        // 查询参加考试学生信息
        $datas = Chengji::where('kaoshi',$list['id'])
                ->where('banji','in',$list['banjis'])
                ->append(['studentname','banjiNumname'])
                ->select();


        // 创建表格
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // 设置表格标题与表头信息
        $sheet->setCellValue('A1',$kstitle.'成绩采集表');
        foreach ($xks as $key => $value) {
            $sheet->setCellValue($lieming[$key + 3].'2', $value['lieming']);
        }
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
