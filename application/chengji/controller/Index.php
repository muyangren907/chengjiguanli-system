<?php
namespace app\chengji\controller;

// 引用控制器基类
use app\common\controller\Base;
// 引用学生数据模型
use app\renshi\model\Student;
// 引用成绩数据模型
use app\chengji\model\Chengji;
// 引用学科数据模型
use app\teach\model\Subject;
// 引用文件信息存储数据模型类
use app\system\model\Fields;
// 引用phpspreadsheet类
use app\renshi\controller\Myexcel;
// 引用考试类
use app\kaoshi\model\Kaoshi;

class Index extends Base
{
    // 使用二维码录入成绩
    public function malu()
    {
    	return $this->fetch();
    }

    // 保存使用二维码录入的成绩
    public function malusave()
    {
        // 获取表单数据
        $list = request()->only(['id','ziduan','defen'],'post');
        
        // 声明学科数组
        $subject = array('1'=>'yuwen','2'=>'shuxue','3'=>'waiyu');
        $zd = $subject[$list['ziduan']];

        // 更新成绩
        $cj = Chengji::update(['id'=>$list['id'], $zd=>$list['defen']]);

        empty($cj) ? $data = ['val' => 0] : $data = ['val' => 1,'defen'=>$cj->$zd];

        return json($data);
    }



    public function edit($id)
    {
        // 获取该学生成绩信息
        $cj = Chengji::where('id',$id)->append(['cj_kaoshi.title','cj_student.xingming'])->find();
        // 模板赋值
        $this->assign('list',$cj);
        // 渲染
        return $this->fetch();
    }


    public function update($id)
    {
        // 获取表单数据
        $list = request()->param();
        
        // 更新成绩
        $data = Chengji::update($list);

        // 判断返回内容
        $data ? $data=['msg'=>'录入成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回更新结果
        return $data;
    }


    
    // 根据考号获取学生信息
    public function read()
    {
        // 获取表单数据 
        $list = request()->only(['id','ziduan'],'post');
        // 声明学科数组
        $subject = array('1'=>array('yuwen','语文'),'2'=>array('shuxue','数学'),'3'=>array('waiyu','外语'));


        $zd = $subject[$list['ziduan']][0];
        $zdname = $subject[$list['ziduan']][1];
        $stuinfo = Chengji::where('id',$list['id'])
                    ->field('id,school,student,banji,'.$zd)
                    ->append(['cj_school.jiancheng','cj_banji.title','cj_student.xingming'])
                    ->find();
        $stuinfo['zdname'] = $zdname;
        $stuinfo['zdstr'] = $zd;
        return json($stuinfo->visible(['cj_student.xingming','cj_school.jiancheng','cj_banji.title',$zd,'zdstr','zdname']));
    }


    // 表格录入成绩上传页面
    public function biaolu()
    {
        return $this->fetch();
    }

    

    // 保存表格批量上传的成绩 
    public function saveAll()
    {
        set_time_limit(0);
        // 获以电子表格存储位置
        $url = input('post.url');

        // 实例化操作表格类
        $excel = new Myexcel();

        // 读取表格数据
        $cjinfo = $excel->readXls($url);

        // 获取成绩采集学科信息
        $xk = $cjinfo[1];
        array_splice($xk,0,4);
        $xklie = Subject::where('id','in',$xk)->column('id,lieming');
       
        // 删除成绩采集表标题行
        array_splice($cjinfo,0,3);

        // 获取学科满分
        if($cjinfo[0][1] !=null)
        {
            $manfen = getmanfen($cjinfo[0][1],$xk);
        }else{
            $data = ['msg'=>'上传失败','val' => 0];
            return json($data);
        }
        $cj = array();
        $i = 0;
        // 重新组合成绩信息
        foreach ($cjinfo as $key => $value) {
            $x = 1;
            foreach ($xklie as $k => $val) {
                if(!empty($value[3+$x]) && manfenvalidate($value[3+$x],$manfen[$k])){
                    $cj[$i][$xklie[$k]] = number_format($value[3+$x],1);
                    $cj[$i]['id'] = $value[1];  
                }
                $x++;
            }
            $i++;
        }

        // 实例成绩模块
        $cjmod = new Chengji();
        // 保存成绩
        $data = $cjmod->saveAll($cj);

        // 判断成绩更新结果
        empty($cj) ? $data = ['msg'=>'上传失败','val' => 0] : $data = ['msg'=>'上传成功','val' => 1,];
        ob_flush();
        flush();

        // 返回成绩结果
        return json($data);
        

    }


    // 上传成绩采集表格
    public function upload()
    {
        // 获取文件信息
        $list['text'] = '成绩采集';
        $list['oldname']=input('post.name');
        $list['bianjitime'] = input('post.lastModifiedDate');
        $list['fieldsize'] = input('post.size');

        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');
        // 移动到框架应用根目录/uploads/ 目录下
        $info = $file->move( '..\public\uploads\chengji');
        if($info){
            // 成功上传后 获取上传信息
            $list['category'] = $info->getExtension();
            $list['url'] = $info->getSaveName();
            $list['newname'] = $info->getFilename(); 

            //将文件信息保存
            $data = Fields::create($list);

            $data ? $data = array('msg'=>'上传成功','val'=>true,'url'=>'..\public\uploads\chengji\\'.$list['url']) : $data = array('msg'=>'保存文件信息失败','val'=>false,'url'=>null);
        }else{
            // 上传失败获取错误信息
            $data = array('msg'=>$file->getError(),'val'=>false,'url'=>null);
        }

        // 返回信息
        return json($data);
    }


    // 成绩列表
    public function Chengjilist($id)
    {
        // 实例化成绩数据模型
        $cj = new Chengji();

        // 查询成绩数量
        $list['count'] = $cj->searchAll($id)->count();
        // 设置页面标题
        $list['title'] = '成绩列表';
        $list['kaoshi'] = $id;

        // 模板赋值
        $this->assign('list', $list);

        // 渲染模板
        return $this->fetch();
    }



    // 获取考试信息
    public function ajaxData()
    {
        // 获取DT的传值
        $getdt = request()->param();

        //得到排序的方式
        $order = $getdt['order'][0]['dir'];
        //得到排序字段的下标
        $order_column = $getdt['order'][0]['column'];
        //根据排序字段的下标得到排序字段
        $order_field = $getdt['columns'][$order_column]['name'];
        if($order_field=='')
        {
            $order_field = $getdt['columns'][$order_column]['data'];
        }
        //得到limit参数
        $limit_start = $getdt['start'];
        $limit_length = $getdt['length'];

        // 获取班级id
        $njlist = nianjiList();
        $njnum = array_keys($njlist);
        $bj = new \app\teach\model\Banji;
        $bjlist = $bj->where('ruxuenian','in',$njnum)
                ->where('paixu','in',$getdt['banji'])
                ->column('id');


        //得到搜索的关键词
        $search = [
            'kaoshiid'=>$getdt['kaoshi'],
            'school'=>$getdt['school'],
            'nianji'=>$getdt['nianji'],
            'banji'=>$bjlist,
            'search'=>$getdt['search']['value'],
            'order'=>$order,
            'order_field'=>$order_field
        ];
        

        // 实例化成绩数据模型
        $cj = new Chengji();

        // 查询成绩总数
        $cnt = $cj->searchAll($getdt['kaoshi'])->count();

        // 分页查询成绩
        $data = $cj->searchAjax($search);
        // 获取符合条件记录数
        $datacnt = $data->count();
        // 获取当前页数据
        $data = $data->slice($limit_start,$limit_length);


        // 重组返回内容
        $data = [
            'draw'=> $getdt["draw"] , // ajax请求次数，作为标识符
            'recordsTotal'=>$cnt,  // 获取到的结果数(每页显示数量)
            'recordsFiltered'=>$datacnt,       // 符合条件的总数据量
            'data'=>$data, //获取到的数据结果
        ];

        return json($data);
    }




    // 删除成绩
    public function deletecj($id)
    {

        // 声明要删除成绩数组
        $data = array();

        if($id == 'm')
        {
            $id = request()->delete('ids/a');// 获取delete请求方式传送过来的数据并转换成数据
            $i=0;
            foreach ($id as $key => $value) {
                $data[$i]['id'] = $value;
                $data[$i]['yuwen'] = Null;
                $data[$i]['shuxue'] = Null;
                $data[$i]['wanyu'] = Null;
            }
        }else{
            $data[0]['id'] = $id; 
            $data[0]['yuwen'] = Null;
            $data[0]['shuxue'] = Null;
            $data[0]['waiyu'] = Null;
            $data[0]['stuSum'] = Null;
            $data[0]['stuAvg'] = Null;
        }


        $cj = new Chengji();
        $data = $cj->saveAll($data);

        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'成绩删除成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }



    // 删除成绩
    public function delete($id)
    {

        if($id == 'm')
        {
            $id = request()->delete('ids/a');// 获取delete请求方式传送过来的数据并转换成数据
        }

        $data = Chengji::destroy($id);

        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'删除成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }




    // 设置成绩状态
    public function setStatus()
    {

        //  获取id变量
        $id = request()->post('id');
        $value = request()->post('value');

        // 获取班级信息
        $data = Chengji::where('id',$id)->update(['status'=>$value]);

        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'状态设置成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }



    // 下载成绩表格
    public function download($id)
    {

       // 模板赋值
        $this->assign('id',$id);
        // 渲染模板
        return $this->fetch();
    }


    //生成学生表格
    public function chengjixls()
    {
        set_time_limit(0);
        $list = input();
        $id = $list['id'];
        // 获取数据库信息
        $chengjiinfo = Chengji::where('kaoshi',$id)
                        ->where('banji','in',$list['banjiids'])
                        ->order(['ruxuenian','stuAvg'=>'desc'])
                        ->append(['cj_student.xingming','cj_banji.title'])
                        ->select();

        // 获取考试标题
        $ks = Kaoshi::where('id',$id)->find('title');
       

        // 创建表格
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet;
        $sheet = $spreadsheet->getActiveSheet();

        // 设置表头信息
        $sheet->setCellValue('A1', $ks.'学生成绩列表');
        $sheet->setCellValue('A2', '序号');
        $sheet->setCellValue('B2', '班级');
        $sheet->setCellValue('C2', '姓名');
        $sheet->setCellValue('D2', '语文');
        $sheet->setCellValue('E2', '数学');
        $sheet->setCellValue('F2', '英语');
        $sheet->setCellValue('G2', '平均分');
        $sheet->setCellValue('H2', '总分');


        // 循环写出信息
        $i = 3;
        foreach ($chengjiinfo as $key => $value) {
            if($value->stuSum !== null)
            {
                // 表格赋值
                $sheet->setCellValue('A'.$i, $i-2);
                $sheet->setCellValue('B'.$i, $value['cj_banji']['title']);
                $sheet->setCellValue('C'.$i, $value['cj_student']['xingming']);
                $sheet->setCellValue('D'.$i, $value->yuwen);
                $sheet->setCellValue('E'.$i, $value->shuxue);
                $sheet->setCellValue('F'.$i, $value->waiyu);
                $sheet->setCellValue('G'.$i, $value->stuAvg);
                $sheet->setCellValue('H'.$i, $value->stuSum);
                $i++;
            }
        }


        // 保存文件
        $filename = $ks.'学生成绩列表'.date('ymdHis').'.xls';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');
        ob_flush();
        flush();
    }


      
}
