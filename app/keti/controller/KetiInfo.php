<?php

namespace app\keti\controller;

// 引用控制器基类
use app\BaseController;
// 引用课题信息数据模型类
use app\keti\model\KetiInfo as ktinfo;
// 引用PhpSpreadsheet类
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class KetiInfo extends BaseController
{
    // use \liliuwei\think\Jump;
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        // 设置要给模板赋值的信息
        $list['webtitle'] = '课题列表';
        $list['dataurl'] = 'ketiinfo/data';

        // 模板赋值
        $this->view->assign('list',$list);

        // 渲染模板
        return $this->view->fetch();
    }


    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function ketiList($ketice)
    {

        $kt = new \app\keti\model\Keti;
        // 设置要给模板赋值的信息
        $list['webtitle'] = $kt->where('id',$ketice)->value('title').' 列表';
        $list['ketice'] = $ketice;
        $list['dataurl'] = '/keti/ketiinfo/data';

        // 模板赋值
        $this->view->assign('list',$list);

        // 渲染模板
        return $this->view->fetch();
    }



    /**
     * 显示课题信息列表
     *
     * @return \think\Response
     */
    public function ajaxData()
    {
        // 获取参数
        $src = $this->request
                ->only([
                    'page'=>'1',
                    'limit'=>'10',
                    'field'=>'update_time',
                    'type'=>'desc',
                    'lxdanweiid'=>array(),
                    'lxcategory'=>array(),
                    'fzdanweiid'=>array(),
                    'subject'=>array(),
                    'category'=>array(),
                    'jddengji'=>array(),
                    'ketice'=>'',
                    'searchval'=>''
                ],'POST');


        // 实例化
        $ktinfo = new ktinfo;

        // 查询要显示的数据
        $data = $ktinfo->search($src);
        // 获取符合条件记录总数
        $cnt = $data->count();
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




    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create($ketice=0)
    {
        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'添加课题册',
            'butname'=>'添加',
            'formpost'=>'POST',
            'url'=>'/keti/ketiinfo/save', 
            'ketice'=>$ketice
        );

        // 模板赋值
        $this->view->assign('list',$list);
        // 渲染
        return $this->view->fetch('create');
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save()
    {
        // 获取表单数据
        $list = request()->only(['ketice','title','bianhao','fzdanweiid','subject','category','jhjtshijian','hjteachers','lxpic'],'POST');


        // 实例化验证类
        $validate = new \app\keti\validate\KetiInfo;
        // 验证表单数据
        $result = $validate->scene('add')->check($list);
        $msg = $validate->getError();

        // 如果验证不通过则停止保存
        if(!$result){
            return json(['msg'=>$msg,'val'=>0]);
        }


        // 更新数据
        $data = ktinfo::create($list);

        // 声明教师数组
            $teacherlist = [];
            // 循环组成获奖教师信息
            foreach ($list['hjteachers'] as $key => $value) {
                $canyulist[] = [
                    'teacherid' => $value,
                    'category' => 1,
                ];
            }
            

        // 添加新的获奖人与参与人信息
        $cy = $data->ktZcr()->saveAll($canyulist);

        // 根据更新结果设置返回提示信息
        if($cy){
            $data=['msg'=>'添加成功','val'=>1];
        }else{
            $data=['msg'=>'数据处理错误','val'=>0];
            $data->delete(true);
        }

        // 返回信息
        return json($data);
    }


    // 批量上传立项通知书
    public function createAll($ketice)
    {
        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'批量添加课题信息',
            'butname'=>'批传',
            'formpost'=>'POST',
            'url'=>'/keti/ketiinfo/saveall/'.$ketice,
        );

        // 模板赋值
        $this->view->assign('list',$list);
        // 渲染
        return $this->view->fetch();
    }

    // 批量保存图片
    public function saveAll($ketice)
    {
        // 获取文件信息
        $list['text'] = $this->request->post('text');
        $list['serurl'] = $this->request->post('serurl');

        // 获取表单上传文件
        $file = request()->file('file');
        // 上传文件并返回结果
        $data = saveFileInfo($file,$list,false);

        if($data['val'] != 1)
        {
            $data=['msg'=>'添加失败','val'=>0];
        }

        $data = ktinfo::create([
            'lxpic'=>$data['url']
            ,'title'=>'批传立项'
            ,'ketice'=>$ketice
        ]);

        $data ? $data=['msg'=>'批传成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        return json($data);
    }


    /**
     * 上传荣誉图片并保存
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    // public function upload()
    // {
    //     // 获取文件信息
    //     $list['text'] = $this->request->post('text');
    //     $list['serurl'] = $this->request->post('serurl');

    //     // 获取表单上传文件
    //     $file = request()->file('file');
    //     // 上传文件并返回结果
    //     $data = upload($list,$file);

    //     return json($data);
    // }


    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        // 获取课题信息
        $list['data'] = ktinfo::where('id',$id)
                ->field('id,title,fzdanweiid,bianhao,subject,category,jhjtshijian,lxpic')
                ->with([
                    'ktZcr'=>function($query){
                        $query->field('ketiinfoid,teacherid')
                            ->with([
                                'teacher'=>function($q){
                                    $q->field('id,xingming');
                                }
                            ]);
                    },
                ])
                ->find();
        

        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'编辑课题',
            'butname'=>'修改',
            'formpost'=>'PUT',
            'url'=>'/keti/ketiinfo/update/'.$id,
        );

        // 模板赋值
        $this->view->assign('list',$list);
        // 渲染
        return $this->view->fetch('create');
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update($id)
    {
        // 获取表单数据
        $list = request()->only(['title','bianhao','fzdanweiid','subject','category','jhjtshijian','hjteachers','lxpic'],'PUT');
        $list['id'] = $id;


        // 实例化验证类
        $validate = new \app\keti\validate\KetiInfo;
        // 验证表单数据
        $result = $validate->scene('edit')->check($list);
        $msg = $validate->getError();

        // 如果验证不通过则停止保存
        if(!$result){
            return json(['msg'=>$msg,'val'=>0]);
        }


        // 更新数据
        $data = ktinfo::update($list);

        // 删除原来的获奖人与参与人信息
        $data->ktZcr()->delete(true);
        // 声明教师数组
            $teacherlist = [];
            // 循环组成获奖教师信息
            foreach ($list['hjteachers'] as $key => $value) {
                $canyulist[] = [
                    'teacherid' => $value,
                    'category' => 1,
                ];
            }
            

        // 添加新的获奖人与参与人信息
        $data = $data->ktZcr()->saveAll($canyulist);

        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'更新成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {

        if($id == 'm')
        {
            $id = request()->delete('ids');// 获取delete请求方式传送过来的数据并转换成数据
        }

        $id = explode(',', $id);

        $data = ktinfo::destroy($id);

        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'删除成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }



    // 设置荣誉状态
    public function setStatus()
    {

        //  获取id变量
        $id = request()->post('id');
        $value = request()->post('value');

        // 获取学生信息
        $data = ktinfo::where('id',$id)->update(['status'=>$value]);

        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'状态设置成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }


    // 结题页面
    public function jieTi($id)
    {
        // 获取课题信息
        $list['data'] = ktinfo::where('id',$id)
                ->field('id,title,jddengji,jtshijian,jtpic')
                ->with([
                    'ktCy'=>function($query){
                        $query->field('ketiinfoid,teacherid')
                        ->with(['teacher'=>function($query){
                            $query->field('id,xingming');
                        }]);
                    },
                ])
                ->find();

        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'编辑结题',
            'butname'=>'修改',
            'formpost'=>'PUT',
            'url'=>'/keti/ketiinfo/jietiupdate/'.$id,
        );

        // 模板赋值
        $this->view->assign('list',$list);
        // 渲染
        return $this->view->fetch();
    }


    // 更新结题信息
    public function jtUpdate($id)
    {
        // 获取表单数据
        $list = request()->only(['jtpic','jddengji','jtshijian','cyteachers'],'PUT');
        $list['id'] = $id;


        // 实例化验证类
        $validate = new \app\keti\validate\KetiInfo;
        // 验证表单数据
        $result = $validate->scene('jieti')->check($list);
        $msg = $validate->getError();

        // 如果验证不通过则停止保存
        if(!$result){
            return json(['msg'=>$msg,'val'=>0]);
        }


        // 更新数据
        $data = ktinfo::update($list);

        // 删除原来的获奖人与参与人信息
        $data->ktCy()->delete(true);
        // 声明教师数组
            $teacherlist = [];
            // 循环组成获奖教师信息
            foreach ($list['cyteachers'] as $key => $value) {
                $canyulist[] = [
                    'teacherid' => $value,
                    'category' => 2,
                ];
            }
            

        // 添加新的获奖人与参与人信息
        $data = $data->ktCy()->saveAll($canyulist);

        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'更新成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);


    }


    // /**
    //  * 上传荣誉图片并保存
    //  *
    //  * @param  \think\Request  $request
    //  * @return \think\Response
    //  */
    // public function jtupload()
    // {

    //     // 获取表单上传文件 例如上传了001.jpg
    //     $file = request()->file('file');
    //     // 移动到框架应用根目录/uploads/ 目录下
    //     $info = $file->validate(['size'=>2*1024*1024,'ext'=>'jpg,png,gif,jpeg'])->move('uploads\keti\jieti');

    //     if($info){
    //         // 成功上传后 获取上传信息
    //         $list['url'] = $info->getSaveName();
    //         $list['url'] = str_replace('\\','/',$list['url']);
    //         // 如果图片上传成功，则返回
    //         $data = array('msg'=>'上传成功','val'=>true,'url'=>$list['url']);
    //     }else{
    //         // 上传失败获取错误信息
    //         $data = array('msg'=>$file->getError(),'val'=>false,'url'=>null);
    //     }

    //     // 返回信息
    //     return json($data);
    // }


    // 下载课题信息表
    public function outXlsx($ketice)
    {
        $ketiinfo = new ktinfo();
        $list = $ketiinfo->srcKeti($ketice);
        // halt($list);


        if($list->isEmpty())
        {
            // $this->error('兄弟，没有要下载的信息呀~');
            return '没有找到记录，下载失败';
        }else{
           $keticename = $list[0]['KtCe']['title'];
           $lxdanwei = $list[0]['KtCe']['ktLxdanwei']['title'];
           $lxshijian = strtotime($list[0]['KtCe']['lxshijian']);
           $lxshijian = date('Ym',$lxshijian);
        }

        //通过工厂模式创建内容
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('uploads/keti/keti.xlsx');
        $worksheet = $spreadsheet->getActiveSheet();

        $worksheet->getCell('A1')->setValue($keticename);
        $worksheet->getCell('A2')->setValue('发证单位:'.$lxdanwei);
        $worksheet->getCell('G2')->setValue('发证时间:'.$list[0]['KtCe']['lxshijian']);
        // 循环为excel每行赋值
        foreach ($list as $key => $value) {
            $myrowid = $key + 4;
            $worksheet->getCell('A'.$myrowid)->setValue($key+1);
            $worksheet->getCell('B'.$myrowid)->setValue($value->title);
            $worksheet->getCell('C'.$myrowid)->setValue($value->bianhao);
            if($value->ktZcr){
                foreach ($value->ktZcr as $k => $val) {
                    if($k==0)
                    {
                        $str = $val->teacher->xingming;
                    }else{
                        $str = $str.'、'.$val->teacher->xingming;
                    }
                }
                $worksheet->getCell('D'.$myrowid)->setValue($str);
            }
            // 课题负责单位
            if($value->fzSchool){
                $worksheet->getCell('E'.$myrowid)->setValue($value->fzSchool->jiancheng);
            }
            if($value->ktCy){
                foreach ($value->ktCy as $k => $val) {
                    if($k==0)
                    {
                        $str = $val->teacher->xingming;
                    }else{
                        $str = $str.'、'.$val->teacher->xingming;
                    }
                }
                $worksheet->getCell('F'.$myrowid)->setValue($str);
            }
            $worksheet->getCell('G'.$myrowid)->setValue($value->jddengji);
        }

        // 给单元格加边框
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '00000000'],
                ],
            ],
        ];
        
        if($key+4>9)
        {
            
            $worksheet->getStyle('A10:H'.($key+4))->applyFromArray($styleArray);
            // 设置行高
            for($i = 10;  $i<=($key+4); $i++){
                $worksheet->getRowDimension($i)->setRowHeight(30);
            }
            
        }

        $worksheet->getStyle('A4')->applyFromArray($styleArray);

        //告诉浏览器输出07Excel文件
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        //告诉浏览器输出浏览器名称
        header('Content-Disposition: attachment;filename="'.$keticename .$lxshijian.'.xlsx"');
        //禁止缓存
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');


    }



}
