<?php

namespace app\keti\controller;

// 引用控制器基类
use app\base\controller\AdminBase;
// 引用课题信息数据模型类
use app\keti\model\KetiInfo as ktinfo;
// 引用PhpSpreadsheet类
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// 引用上传文件
use app\tools\controller\File;


class KetiInfo extends AdminBase
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        // 设置要给模板赋值的信息
        $list['webtitle'] = '课题列表';
        $list['dataurl'] = '/keti/ketiinfo/data';
        $list['status'] = '/keti/ketiinfo/status';

        // 模板赋值
        $this->view->assign('list', $list);

        // 渲染模板
        return $this->view->fetch();
    }


    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function ketiList($ketice_id)
    {

        $kt = new \app\keti\model\Keti;
        // 设置要给模板赋值的信息
        $list['webtitle'] = $kt->where('id', $ketice_id)->value('title') . ' 列表';
        $list['ketice_id'] = $ketice_id;
        $list['dataurl'] = '/keti/ketiinfo/data';
        $list['status'] = '/keti/ketiinfo/status';

        // 模板赋值
        $this->view->assign('list', $list);

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
                    'page'=>'1'
                    ,'limit'=>'10'
                    ,'field'=>'update_time'
                    ,'order'=>'desc'
                    ,'lxdanwei_id'=>array()
                    ,'lxcategory_id'=>array()
                    ,'fzdanwei_id'=>array()
                    ,'subject_id'=>array()
                    ,'category_id'=>array()
                    ,'jddengji_id'=>array()
                    ,'ketice_id'=>''
                    ,'searchval'=>''
                ],'POST');

        // 实例化
        $ktinfo = new ktinfo;
        $data = $ktinfo->search($src);
        $data = reSetObject($data, $src);

        return json($data);
    }


    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create($ketice_id=0)
    {
        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'添加课题册',
            'butname'=>'添加',
            'formpost'=>'POST',
            'url'=>'/keti/ketiinfo/save',
            'ketice_id'=>$ketice_id
        );

        // 模板赋值
        $this->view->assign('list', $list);
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
        $list = request()->only([
            'ketice_id'
            ,'title'
            ,'bianhao'
            ,'fzdanwei_id'
            ,'subject_id'
            ,'category_id'
            ,'jhjtshijian'
            ,'teacher_id'
            ,'lxpic'
        ], 'POST');

        // 实例化验证类
        $validate = new \app\keti\validate\KetiInfo;
        $result = $validate->scene('create')->check($list);
        $msg = $validate->getError();
        if(!$result){
            return json(['msg' => $msg, 'val' => 0]);
        }

        // 更新数据
        $data = ktinfo::create($list);

        // 声明教师数组
            $teacherlist = [];
            $list['teacher_id'] = explode(',', $list['teacher_id']);
            // 循环组成获奖教师信息
            foreach ($list['teacher_id'] as $key => $value) {
                $canyulist[] = [
                    'teacher_id' => $value
                    ,'category_id' => 11901
                ];
            }

        // 添加新的获奖人与参与人信息
        $cy = $data->ktZcr()->saveAll($canyulist);

        // 根据更新结果设置返回提示信息
        if($cy){
            $data = ['msg' => '添加成功', 'val' => 1];
        }else{
            $data = ['msg' => '数据处理错误', 'val' => 0];
            $data->delete(true);
        }

        // 返回信息
        return json($data);
    }


    // 批量上传立项通知书
    public function createAll($ketice_id)
    {
        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'批量添加课题信息,'
            ,'butname'=>'批传'
            ,'formpost'=>'POST'
            ,'url'=>'/keti/ketiinfo/saveall/' . $ketice_id
        );

        // 模板赋值
        $this->view->assign('list', $list);
        // 渲染
        return $this->view->fetch();
    }


    // 批量保存图片
    public function saveAll($ketice_id)
    {
        // 获取表单数据
        $list = request()->only([
            'text'
            ,'serurl'
        ], 'post');

        // 获取表单上传文件
        $file = request()->file('file');
        // 上传文件并返回结果
        $data = \app\facade\File::saveFileInfo($file, $list, false);

        if($data['val'] != 1)
        {
            $data = ['msg' => '添加失败', 'val' => 0];
        }

        $data = ktinfo::create([
            'lxpic' => $data['url']
            ,'title' => '批传立项'
            ,'ketice_id' => $ketice_id
        ]);

        $data ? $data = ['msg' => '批传成功', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];

        return json($data);
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
                ->field('id, title, fzdanwei_id, bianhao, subject_id, category_id, jhjtshijian, lxpic')
                ->with([
                    'ktZcr'=>function($query){
                        $query->field('ketiinfo_id,teacher_id')
                            ->with([
                                'teacher'=>function($q){
                                    $q->field('id, xingming');
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
            'url'=>'/keti/ketiinfo/update/' . $id,
        );

        // 模板赋值
        $this->view->assign('list', $list);
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
        $list = request()->only([
            'title'
            ,'bianhao'
            ,'fzdanwei_id'
            ,'subject_id'
            ,'category_id'
            ,'jhjtshijian'
            ,'hjteachers'
            ,'lxpic'
        ], 'PUT');
        $list['id'] = $id;

        // 验证数据
        $validate = new \app\keti\validate\KetiInfo;
        $result = $validate->scene('edit')->check($list);
        $msg = $validate->getError();
        if(!$result){
            return json(['msg' => $msg, 'val' => 0]);
        }

        // 更新数据
        $data = ktinfo::update($list); # 更新课题信息
        $data->ktZcr->delete(true);  # 删除原来课题主持人信息
        // 声明教师数组
            $teacherlist = [];
            // 循环组成获奖教师信息
            foreach ($list['hjteachers'] as $key => $value) {
                $canyulist[] = [
                    'teacher_id' => $value
                    ,'category_id' => 11901
                ];
            }
        $data = $data->ktZcr()->saveAll($canyulist); # 添加新课题主持人

        // 根据更新结果设置返回提示信息
        $data ? $data = ['msg' => '更新成功', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];

        // 返回信息
        return json($data);
    }


    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete()
    {

        // 整理数据
        $id = request()->delete('id');
        $id = explode(',', $id);

        $data = ktinfo::destroy($id);
        $data ? $data = ['msg' => '删除成功', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];

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
        $data = ktinfo::where('id', $id)->update(['status' => $value]);

        // 根据更新结果设置返回提示信息
        $data ? $data = ['msg' => '状态设置成功', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];

        // 返回信息
        return json($data);
    }


    // 结题页面
    public function jieTi($id)
    {
        // 获取课题信息
        $list['data'] = ktinfo::where('id', $id)
                ->field('id, title, jddengji_id, jtshijian, jtpic,beizhu')
                ->with([
                    'ktCy'=>function($query){
                        $query->field('ketiinfo_id,teacher_id')
                        ->with(['teacher'=>function($query){
                            $query->field('id, xingming');
                        }]);
                    },
                ])
                ->find();

        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'编辑结题'
            ,'butname'=>'修改'
            ,'formpost'=>'PUT'
            ,'url'=>'/keti/ketiinfo/jietiupdate/' . $id
        );

        // 模板赋值
        $this->view->assign('list', $list);
        // 渲染
        return $this->view->fetch();
    }


    // 更新结题信息
    public function jtUpdate($id)
    {
        // 获取表单数据
        $list = request()->only([
            'jtpic'
            ,'jddengji_id'
            ,'jtshijian'
            ,'cyteachers'=>array()
            ,'beizhu'
        ], 'PUT');
        $list['id'] = $id;

        // 实例化验证类
        $validate = new \app\keti\validate\KetiInfo;
        $result = $validate->scene('jieti')->check($list);
        $msg = $validate->getError();
        if (!$result) {
            return json(['msg' => $msg, 'val' => 0]);
        }
        if ($list['jddengji_id'] == 11804 && $list['beizhu']=='') {
            return json(['msg' => '流失的课题必须在备注中写明原因', 'val' => 0]);
        }
        // 更新数据
        $data = ktinfo::update($list);

        // 删除原来的获奖人与参与人信息
        $data->ktCy->delete(true);
        // 声明教师数组
            $teacherlist = [];
            $canyulist = [];
            // 循环组成获奖教师信息
            foreach ($list['cyteachers'] as $key => $value) {
                $canyulist[] = [
                    'teacher_id' => $value
                    ,'category_id' => 11902
                ];
            }

        // 添加新的获奖人与参与人信息
        if (count($canyulist)>0) {
            $data = $data->ktCy()->saveAll($canyulist);
        }else{
            $data = true;
        }


        // 根据更新结果设置返回提示信息
        $data ? $data = ['msg' => '更新成功', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];

        // 返回信息
        return json($data);
    }


    // 下载课题信息表
    public function outXlsx($ketice_id)
    {
        $ketiinfo = new ktinfo();
        $list = $ketiinfo->srcKeti($ketice_id);

        if($list->isEmpty())
        {
            $this->error('兄弟，没有要下载的信息呀~', '/login/err');
        }else{
           $keticename = $list[0]['KtCe']['title'];
           $lxdanwei = $list[0]['KtCe']['ktLxdanwei']['title'];
           $lxshijian = strtotime($list[0]['KtCe']['lxshijian']);
           $lxshijian = date('Ym', $lxshijian);
        }

        //通过工厂模式创建内容
        ob_start();
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('uploads/keti/keti.xlsx');
        $worksheet = $spreadsheet->getActiveSheet();

        $worksheet->getCell('A1')->setValue($keticename);
        $worksheet->getCell('A2')->setValue('发证单位:' . $lxdanwei);
        $worksheet->getCell('G2')->setValue('发证时间:' . $list[0]['KtCe']['lxshijian']);
        // 循环为excel每行赋值
        foreach ($list as $key => $value) {
            $myrowid = $key + 4;
            $worksheet->getCell('A' . $myrowid)->setValue($key + 1);
            $worksheet->getCell('B' . $myrowid)->setValue($value->title);
            $worksheet->getCell('C' . $myrowid)->setValue($value->bianhao);
            // 课题主持人
            if($value->ktZcr){
                $str = '';
                foreach ($value->ktZcr as $k => $val) {
                    if($k==0)
                    {
                        $str = $val->teacher->xingming;
                    }else{
                        $str = $str . '、' . $val->teacher->xingming;
                    }
                }
                $worksheet->getCell('D' . $myrowid)->setValue($str);
            }
            // 课题负责单位
            if($value->fzSchool){
                $worksheet->getCell('E' . $myrowid)->setValue($value->fzSchool->jiancheng);
            }
            // 课题参与人
            if($value->ktCy){
                $str = '';
                foreach ($value->ktCy as $k => $val) {
                    if($k==0)
                    {
                        $str = $val->teacher->xingming;
                    }else{
                        $str = $str . '、' . $val->teacher->xingming;
                    }
                }
                $worksheet->getCell('F' . $myrowid)->setValue($str);
            }
            $worksheet->getCell('G' . $myrowid)->setValue($value->jddengji);
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

        if($key + 4 > 9)
        {

            $worksheet->getStyle('A10:H' . ($key + 4))->applyFromArray($styleArray);
            // 设置行高
            for($i = 10;  $i <= ($key + 4); $i ++){
                $worksheet->getRowDimension($i)->setRowHeight(30);
            }

        }

        $worksheet->getStyle('A4')->applyFromArray($styleArray);

        //告诉浏览器输出07Excel文件
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        //告诉浏览器输出浏览器名称
        header('Content-Disposition: attachment;filename="' . $keticename . $lxshijian . '.xlsx"');
        //禁止缓存
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        ob_flush();
        flush();
        exit();
    }
}
