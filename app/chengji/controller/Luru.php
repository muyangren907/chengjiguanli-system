<?php
namespace app\chengji\controller;

// 引用控制器基类
use app\BaseController;
// 引用成绩数据模型
use app\chengji\model\Chengji;
// 引用考号数据模型
use \app\kaoshi\model\Kaohao;
// 引用学科数据模型
use \app\teach\model\Subject;


class Luru extends BaseController
{
    // 成绩列表
    public function index()
    {
        
        $ks = new \app\kaoshi\model\Kaoshi;
        // 获取参考年级
        $list['data'] = $ks::order(['id'=>'desc'])
                ->field('id,title')
                ->with([
                    'ksNianji'
                    ,'ksSubject'=>function($query){
                                $query->field('id,subjectid,kaoshiid')
                                    ->with(['subjectName'=>function($q){
                                        $q->field('id,title');
                                    }]
                                );
                            }
                ])
                ->limit(6)
                ->select()
                ->toArray();

        
        
        // 设置要给模板赋值的信息
        $list['webtitle'] = '已录列表';
        $list['dataurl'] = 'luru/data';


        // 模板赋值
        $this->view->assign('list',$list);
        // 渲染
        return $this->view->fetch();
    }




    // 获取本人录入成绩信息
    public function ajaxData()
    {
        // 获取参数
        $src = $this->request
                ->only([
                    'page'
                    ,'limit'
                    ,'field'=>'update_time'
                    ,'type'=>'desc'
                    ,'searchval'
                ],'POST');

        // 实例化
        $cj = new Chengji;

        // 查询要显示的数据
        $data = $cj->searchLuru($src);


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
        $this->view->assign('list',$list);
        // 渲染
        return $this->view->fetch();
    }

    // 保存使用二维码录入的成绩
    public function malusave()
    {   
        // 获取表单数据
        $list = $this->request->only(['kaohao_id','subject_id','defen'],'post');

        $kaoshiid = Kaohao::where('id',$list['kaohao_id'])->value('kaoshi');
        // 判断考试结束时间是否已过
        $enddate = kaoshiDate($kaoshiid,'enddate');
        if($enddate === true)
        {
            $data=['msg'=>'考试时间已过，不能录入成绩','val'=>0];
            return json($data);
        }

        // 成绩验证
        $manfen =  getmanfen($kaoshiid,$list['subject_id']);
        $mfyz = manfenvalidate($list['defen'],$manfen);
        if($mfyz['val'] == 0)
        {
            return json($mfyz);
        }

        // 保存成绩
        $cjone = Chengji::withTrashed()
                ->where('subject_id',$list['subject_id'])
                ->where('kaohao_id',$list['kaohao_id'])
                ->find();

        // 如果存在成绩则更新，不存在则添加
        if($cjone)
        {
            // 判断记录是否被删除 
            if($cjone->delete_time > 1)
            {
                $cjone->restore();
            }

            if($cjone->defen == $list['defen'])
            {
                $data=['msg'=>'与原成绩相同，不需要修改。','val'=>1];
                return json($data);
            }

            $cjone->defen = $list['defen'];
            $data = $cjone->save();

        }else{
            $data = [
                'kaohao_id'=>$list['kaohao_id'],
                'subject_id'=>$list['subject_id'],
                'user_id'=>session('userid'),
                'defen'=>$list['defen']
            ];
            $data = Chengji::create($data);
        }


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

        // 判断考试结束时间是否已过
        $kaoshiid = Kaohao::where('id',$list['kaohao_id'])->value('kaoshi');
        $enddate = kaoshiDate($kaoshiid,'enddate');
        if($enddate === true)
        {
            $data=['msg'=>'考试时间已过，不能录入成绩','val'=>0];
            return json($data);
        }


        // 获取学科id
        $subject = new \app\teach\model\Subject;
        $subject_id = $subject->where('lieming',$list['colname'])->value('id');



        // 成绩验证
        $manfen =  getmanfen($kaoshiid,$subject_id);
        $mfyz = manfenvalidate($list['newdefen'],$manfen);
        if($mfyz['val'] == 0)
        {
            return json($mfyz);
        }



        // 更新成绩 
        $cjone = Chengji::withTrashed()
                    ->where('kaohao_id',$list['kaohao_id'])
                    ->where('subject_id',$subject_id)
                    ->find();
        

        // 如果存在成绩则更新，不存在则添加
        if($cjone)
        {
            // 判断记录是否被删除 
            if($cjone->delete_time > 1)
            {
                $cjone->restore();
            }

            if($cjone->defen == $list['newdefen'])
            {
                $data=['msg'=>'与原成绩相同，不需要修改。','val'=>1];
                return json($data);
            }

            $cjone->defen = $list['newdefen'];
            $data = $cjone->save();

        }else{
            $data = [
                'kaohao_id'=>$list['kaohao_id'],
                'subject_id'=>$subject_id,
                'user_id'=>session('userid'),
                'defen'=>$list['newdefen']
            ];
            $data = Chengji::create($data);
        }

        // 判断返回内容
        $data  ? $data=['msg'=>'录入成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回更新结果
        return json($data);
    }


    
    // 根据考号获取学生信息
    public function read()
    {
        // 获取表单数据
        $val = input('post.val');
        // 实例化系统设置类
        $md5 = new \app\system\controller\Encrypt; 

        $val = $md5->decrypt($val,'dlbz');
        $list = explode('|',$val);
        $sbj = $list[1];

        $cjlist = Kaohao::where('id',$list[0])
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
        if($cjlist->cjStudent == Null)
        {
            $stu = new \app\renshi\model\Student;
            $stuinfo = $stu::withTrashed()
                            ->where('id',$cjlist->student)
                            ->field('id,xingming,sex')
                            ->find();
            $cjlist->cjStudent = array(
                'id'=>$stuinfo->id,
                'xingming'=>$stuinfo->xingming
            );
        }
        $cjlist->sbj = Subject::where('id',$sbj)->field('id,title')->find();

        // 获取列名
        return json($cjlist);
    }


    // 表格录入成绩上传页面
    public function biaolu()
    {

        $ks = new \app\kaoshi\model\Kaoshi;
        // 获取参考年级
        $list['data'] = $ks::order(['id'=>'desc'])
                ->field('id,title')
                ->with([
                    'ksNianji'
                    ,'ksSubject'=>function($query){
                                $query->field('id,subjectid,kaoshiid')
                                    ->with(['subjectName'=>function($q){
                                        $q->field('id,title');
                                    }]
                                );
                            }
                ])
                ->where('enddate','>=',time())
                ->select()
                ->toArray();

        
        
        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'表格录入',
            'butname'=>'下载',
            'formpost'=>'POST',
            'url'=>'/kaoshi/kaohao/dwcaiji',
        );


        // 模板赋值
        $this->view->assign('list',$list);
        // 渲染
        return $this->view->fetch();
    }

    

    // 保存表格批量上传的成绩 
    public function saveAll()
    {
        // set_time_limit(0);
        // 获以电子表格存储位置
        $url = input('post.url');

        // 实例化操作表格类
        $excel = new \app\renshi\controller\Myexcel;

        // 读取表格数据
        $cjinfo = $excel->readXls(public_path().'public\\uploads\\'.$url);

        $kaoshiid = $cjinfo[1][0];  #获取考号


        if($kaoshiid == null || $cjinfo[2][0] != '序号' || $cjinfo[2][1] != '编号' || $cjinfo[2][2] != '班级' || $cjinfo[2][3] != '姓名')
        {
            $data=['msg'=>'请使用模板上传','val'=>0];
            return json($data);
        }
        // 判断考试结束时间是否已过
        $enddate = kaoshiDate($kaoshiid,'enddate');
        if($enddate === true)
        {
            $data=['msg'=>'考试时间已过，不能录入成绩','val'=>0];
            return json($data);
        }

        // 删除空单元格得到学科列名数组
        array_splice($cjinfo[1],0,4);
        $xk = $cjinfo[1];

        // 删除成绩采集表无用的标题行得到成绩数组
        array_splice($cjinfo,0,3);

        // 查询考试信息
        $kh = new Kaohao;
        // $ks = new \app\kaoshi\model\Kaoshi;


        $user_id = session('userid');   # 获取用户id
        $data = array();


        // 重新组合数组
        foreach ($xk as $key => $value) {
            // 获取成绩满分
            $manfen =  getmanfen($kaoshiid,$value);
            # code...
            foreach ($cjinfo as $k => $val) {
                $defen = $val[$key+4];    # 当前学生当前学科成绩
                // 如果不存在值，跳过这次循环
                if($defen === null){
                    continue;
                }
                // 验证成绩格式，如果不对则跳过
                $mfyz = manfenvalidate($defen,$manfen);
                if($mfyz['val'] == 0)
                {
                    continue;
                }

                // 添加或更新数据
                $cjone = Chengji::withTrashed()
                        ->where('kaohao_id',$val[1])
                        ->where('subject_id',$value)
                        ->find();
                // 判断成绩是否存在
                if($cjone)
                {
                    // 如果存在则更新记录
                    if($cjone->defen != $defen || $cjone->delete_time > 1)
                    {
                        $cjone->restore();
                        $cjone->defen = $defen;
                        $cjone->save();
                    }
                }else{
                    // 如果不存在则新增记录
                    $data = [
                        'kaohao_id'=>$val[1],
                        'subject_id'=>$value,
                        'user_id'=>$user_id,
                        'defen'=>$defen
                    ];
                    Chengji::create($data);
                }
            }
        }


        // 判断成绩更新结果
        $data=['msg'=>'成绩导入成功','val'=>1];

        // ob_flush();
        // flush();
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



    




    
}
