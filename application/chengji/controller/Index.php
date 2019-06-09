<?php
namespace app\chengji\controller;

// 引用控制器基类
use app\common\controller\Base;
// 引用成绩数据模型
use app\chengji\model\Chengji;
// 引用考号数据模型
use \app\kaoshi\model\Kaohao;
// // 引用学科数据模型
use \app\teach\model\Subject;


class Index extends Base
{
    // 使用二维码录入成绩
    public function malu()
    {
    	// 设置页面标题
        $list['set'] = array(
            'webtitle'=>'扫码录成绩',
            'butname'=>'录入',
            'formpost'=>'PUT',
            'url'=>'/chengji/malu',
        );


        // 模板赋值
        $this->assign('list',$list);
        // 渲染
        return $this->fetch();
    }

    // 保存使用二维码录入的成绩
    public function malusave()
    {   
        // 获取表单数据
        $list = $this->request->only(['kaohao_id','subject_id','defen'],'post');

        // 更新成绩
        $data = Kaohao::where('id',$list['kaohao_id'])->find();
        $cj = $data->ksChengji()->isEmpty();
        if($cj == false)
        {
            $data->ksChengji()->delete(true);
        }

        $data = $data->ksChengji()->save([
                    'subject_id'=>$list['subject_id'],
                    'defen'=>$list['defen'],
                    'user_id'=>session('userid')
                ]);

        $data ? $data=['msg'=>'更新成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        return json($data);
    }


    // 学生成绩表中修改成绩
    public function update($id)  #id为考号ID
    {
        // 获取表单数据
        $list = $this->request->only(
            ['colname',
            'newdefen']
            ,'post');
        $list['kaohao_id'] = $id;
        // 获取学科信息
        $subject = new \app\teach\model\Subject;
        $subject_id = $subject->where('lieming',$list['colname'])->value('id');
        // 获取考试信息
        $kaohao = new \app\kaoshi\model\Kaohao;
        $kaohaoinfo = $kaohao->where('id',$list['kaohao_id'])
                        ->with([
                            'cjKaoshi'=>function($query) use($subject_id){
                                $query->field('id')
                                    ->with([
                                        'ksSubject'=>function($q) use($subject_id){
                                            $q->field('id,kaoshiid,subjectid,manfen')
                                                ->where('subjectid',$subject_id);
                                        }
                                    ]);
                            }
                        ])
                        ->field('id,kaoshi')
                        ->find();
        // 验证成绩
        if($list['newdefen'] === null){ # 如果不存在值，跳过这次循环
            $data=['msg'=>'没有找到值','val'=>0];
            return $data;
        }
        if(is_numeric($list['newdefen'])==false){ # 如果不为数字、则跳过
            $data=['msg'=>'请输入数字','val'=>0];
            return $data;
        }
        if( $list['newdefen']<0 || $list['newdefen'] > $kaohaoinfo->cj_kaoshi->ks_subject[0]->manfen) # 如果大于满分、小于0分的时候也跳过
        {
            $data=['msg'=>'得分范围在要大于等于0分，小于等于'.$kaohaoinfo->cj_kaoshi->ks_subject[0]->manfen.'分','val'=>0];
            return $data;
        }

        // 更新成绩 
        $cj = new Chengji;
        $cjinfo = $cj->where('kaohao_id',$list['kaohao_id'])
                    ->where('subject_id',$subject_id)
                    ->find();
        // 如果存在成绩则更新，不存在则添加
        if($cjinfo){
            $cjinfo->defen = $list['newdefen'];
            $cjinfo->user_id = session('userid');
            $data = $cjinfo->save();
        }else{
            $cj->defen = $list['newdefen'];
            $cj->kaohao_id = $list['kaohao_id'];
            $cj->subject_id = $subject_id;
            $cj->user_id = session('userid');
            $data = $cj->save();
        }
                    // update(['defen'=>$list['newdefen']]);

        // 判断返回内容
        $data ? $data=['msg'=>'录入成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回更新结果
        return $data;
    }


    
    // 根据考号获取学生信息
    public function read()
    {
        // 获取表单数据 
        // 获取表单数据
        $val = input('post.val');
        $val = action('system/Encrypt/decrypt',[$val,'key'=>'dlbz']);
        $list = explode('|',$val);
        $sbj = $list[1];

        $kh = new Kaohao;
        $cjlist = $kh->where('id',$list[0])
                ->field('id,banji,school,student')
                ->with([
                    'ksChengji'=>function($q) use($sbj){
                        $q->where('subject_id',$sbj)
                            ->field('kaohao_id,subject_id,defen');
                    }
                    ,'cjBanji'=>function($q){
                        $q->field('id,paixu,ruxuenian')
                            ->append(['numTitle','banjiTitle']);
                    }
                    ,'cjSchool'=>function($q){
                        $q->field('id,jiancheng');
                    }
                    ,'cjStudent'=>function($q){
                        $q->field('id,xingming');
                    }
                ])
                ->find();
        $cjlist->sbj = Subject::where('id',$sbj)->field('id,title')->find();

        // 获取列名
        return json($cjlist);
    }


    // 表格录入成绩上传页面
    public function biaolu()
    {
        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'表格录入成绩',
            'butname'=>'批传',
            'formpost'=>'POST',
            'url'=>'/chengji/biaolu',
        );

        // 模板赋值
        $this->assign('list',$list);
        // 渲染
        return $this->fetch();
    }

    

    // 保存表格批量上传的成绩 
    public function saveAll()
    {
        set_time_limit(0);
        // 获以电子表格存储位置
        $url = input('post.url');

        // 实例化操作表格类
        $excel = new \app\renshi\controller\Myexcel;

        // 读取表格数据
        $cjinfo = $excel->readXls($url);

        // 删除空单元格得到学科列名数组
        array_splice($cjinfo[1],0,4);
        $xk = $cjinfo[1];
      
        // 删除成绩采集表无用的标题行得到成绩数组
        array_splice($cjinfo,0,3);

        // 查询考试信息
        $kh = new Kaohao;
        $ks = new \app\kaoshi\model\Kaoshi;

        $user_id = session('userid');
        // 重新组合成绩信息
        foreach ($cjinfo as $key => $value) {
            foreach ($xk as $k => $val) {

                $thissbj = $val;    # 当前学科
                $defen = $value[$k+4];    # 当前学科

                // 如果不存在值，跳过这次循环
                if($defen === null){
                    continue;
                }
                // 如果不为数字、则跳过
                if(is_numeric($defen)==false){
                    continue;
                }


                $kaoshiid = $kh->where('id',$value[1])->value('kaoshi');
                $manfen = $ks->where('id',$kaoshiid)
                            ->field('id')
                            ->with([
                                'ksSubject'=>function($query) use($thissbj){
                                    $query->field('kaoshiid,subjectid,manfen')
                                        ->where('subjectid',$thissbj);
                                }
                            ])
                            ->find();

                // 如果大于满分、小于0分的时候也跳过
                if( $defen<0 || $defen>$manfen->ks_subject[0]->manfen )
                {
                    continue;
                }
                // 查询是否存在这个成绩
                $cj = Chengji::where('kaohao_id',$value[1])
                            ->where('subject_id',$val)
                            ->find();
                // 如果存在则删除
                if($cj){
                    $cj->delete(true);
                }
                $data = Chengji::create([
                    'kaohao_id'=>$value[1],
                    'subject_id'=>$val,
                    'user_id'=>$user_id,
                    'defen'=>$defen
                ]);
            }
        }

        // 判断成绩更新结果
        empty($data) ? $data=['msg'=>'上传失败','val'=>0] : $data=['msg'=>'上传成功','val'=>1];

        ob_flush();
        flush();
        // 返回成绩结果
        return json($data);
        
    }


    // 上传成绩采集表格
    public function upload()
    {
        // 获取文件信息
        $list['text'] = $this->request->post('text');
        $list['serurl'] = $this->request->post('serurl');

        // 获取表单上传文件
        $file = request()->file('file');
        // 上传文件并返回结果
        $data = upload($list,$file,true);

        return json($data);
    }


    // 成绩列表
    public function index($kaoshi)
    {
        // 设置要给模板赋值的信息
        $list['webtitle'] = '成绩列表';

        // 实例化考试数据模型
        $ks = new \app\kaoshi\model\Kaoshi;
        $ksinfo = $ks->where('id',$kaoshi)
                    ->field('id')
                    ->with([
                        'ksSubject'=>function($query){
                            $query->field('kaoshiid,subjectid')
                                ->with(['subjectName'=>function($q){
                                    $q->field('id,title,lieming');
                                }]
                            );
                        }
                    ])
                    ->find();

        $list['subject'] = $ksinfo->ks_subject;
        $list['kaoshi'] = $kaoshi;

        // 模板赋值
        $this->assign('list',$list);

        // 渲染模板
        return $this->fetch();
    }



    // 获取考试信息
    public function ajaxData()
    {
        // 获取参数
        $src = $this->request
                ->only([
                    'page'=>'1',
                    'limit'=>'10',
                    'field'=>'banji',
                    'type'=>'desc',
                    'kaoshi'=>'1',
                    'school'=>array(),
                    'nianji'=>array(),
                    'paixu'=>array(),
                    'searchval'=>''
                ],'POST');


        // 实例化
        $chengji = new Kaohao;

        // 查询要显示的数据
        $data = $chengji->srcChengji($src);


        // 获取符合条件记录总数
        $cnt = count($data);
        // 获取当前页数据
        $limit_start = $src['page'] * $src['limit'] - $src['limit'];
        $limit_length = $src['limit'];
        $data = array_slice($data,$limit_start,$limit_length);
       
        // 重组返回内容
        $data = [
            'code'=> 0 , // ajax请求次数，作为标识符
            'msg'=>"",  // 获取到的结果数(每页显示数量)
            'count'=>$cnt, // 符合条件的总数据量
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
            $id = request()->delete('ids');// 获取delete请求方式传送过来的数据并转换成数据
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
    public function dwChengji($kaoshi)
    {

        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'成绩下载',
            'butname'=>'下载',
            'formpost'=>'POST',
            'url'=>'/chengji/dwChengji',
            'kaoshi'=>$kaoshi
        );

        // 模板赋值
        $this->assign('list',$list);
        // 渲染
        return $this->fetch();
    }


    //生成学生表格
    public function dwchengjixls()
    {
        // 获取参数
        $list = $this->request
                ->only([
                    'kaoshi'=>'1',
                    'banji'=>array(),
                ],'POST');


        // 实例化验证模型
        $validate = new \app\chengji\validate\Cjdownload;
        // 验证表单数据
        $result = $validate->check($list);
        $msg = $validate->getError();

        // 如果验证不通过则停止保存
        if(!$result){
            $this->error($msg);
        }



        
        set_time_limit(0);
        $list = input();
        $kaoshi = $list['kaoshi'];
        // 获取数据库信息
        $cj = new Chengji();
        // $kh = new \app\kaoshi\model\Kaohao;
        $chengjiinfo = $cj->srcChengji($kaoshi,$list['banji']);


        // 获取考试标题
        $ks = new \app\kaoshi\model\Kaoshi;
        $ks = $ks->where('id',$kaoshi)
                ->field('id,title')
                ->with([
                    'ksSubject'=>function($query){
                        $query->field('kaoshiid,subjectid')
                            ->with(['subjectName'=>function($q){
                                $q->field('id,title,lieming');
                            }]
                        );
                    }
                ])
                ->find();

        $colname = excelLieming();


        // 创建表格
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet;
        $sheet = $spreadsheet->getActiveSheet();

        // 设置表头信息
        $sheet->setCellValue('A1', $ks->title.'学生成绩列表');
        $sheet->setCellValue('A2', '序号');
        $sheet->setCellValue('B2', '班级');
        $sheet->setCellValue('C2', '姓名');
        $i = 3;
        foreach ($ks->ks_subject as $key => $value) {
            $sheet->setCellValue($colname[$i].'2', $value->subject_name->title);
            $i++;
        }
        $sheet->setCellValue($colname[$i].'2', '平均分');
        $sheet->setCellValue($colname[$i+1].'2', '总分');
        $i=$i+3;
        $sheet->setCellValue($colname[$i].'2', '项目');
        $sheet->setCellValue($colname[$i].'3', '人数');
        $sheet->setCellValue($colname[$i].'4', '平均分');
        $sheet->setCellValue($colname[$i].'5', '优秀率%');
        $sheet->setCellValue($colname[$i].'6', '及格率%');
        $sheet->setCellValue($colname[$i].'7', '标准差');
        $i++;
        foreach ($ks->ks_subject as $key => $value) {
            $sheet->setCellValue($colname[$i].'2', $value->subject_name->title);
            $i++;
        }
        $sheet->setCellValue($colname[$i+1].'2', '总平均分');
        $sheet->setCellValue($colname[$i+2].'2', '全科及格率%');
        

        // 循环写出信息
        $i = 3;
        foreach ($chengjiinfo as $key => $value) {
                // 表格赋值
                $sheet->setCellValue('A'.$i, $i-2);
                $sheet->setCellValue('B'.$i, $value['banji']);
                $sheet->setCellValue('C'.$i, $value['student']);
                $colcnt = 3;
                foreach ($ks->ks_subject as $k => $val) {
                    if(isset($value[$val->subject_name->lieming]))
                    {
                        $sheet->setCellValue($colname[$colcnt].$i, $value[$val->subject_name->lieming]);
                    }
                    $colcnt++;
                }
                $sheet->setCellValue($colname[$colcnt].$i, $value['avg']);
                $sheet->setCellValue($colname[$colcnt+1].$i, $value['cnt']);
                $i++;
        }

        $tj = new \app\chengji\model\Tongji;
        $nianji = array();
        $chengjiinfo = $tj->srcChengji($kaoshi,$list['banji']);
        $temp = $tj->tongji($chengjiinfo,$kaoshi);
        $colcnt = $colcnt+4;
        // 循环写出统计结果
        foreach ($ks->ks_subject as $key => $value) {
            $sheet->setCellValue($colname[$colcnt].'3', $temp[$value->subject_name->lieming]['cnt']);
            $sheet->setCellValue($colname[$colcnt].'4', $temp[$value->subject_name->lieming]['avg']);
            $sheet->setCellValue($colname[$colcnt].'5', $temp[$value->subject_name->lieming]['youxiu']);
            $sheet->setCellValue($colname[$colcnt].'6', $temp[$value->subject_name->lieming]['jige']);
            $sheet->setCellValue($colname[$colcnt].'7', $temp[$value->subject_name->lieming]['biaozhuncha']);
            $colcnt++;
        }

        $sheet->setCellValue($colname[$colcnt+1].'3', $temp['avg']);
        $sheet->setCellValue($colname[$colcnt+2].'3', $temp['rate']);


        // 保存文件
        $filename = $ks->title.'学生成绩列表'.date('ymdHis').'.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        ob_flush();
        flush();
    }


      
}
