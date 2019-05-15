<?php

namespace app\rongyu\controller;

// 引用控制器基类
use app\common\controller\Base;
// 引用教师数据模型类
use app\rongyu\model\JsRongyuInfo as ryinfo;

// 引用PhpSpreadsheet类
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;


class JsRongyuInfo extends Base
{
    /**
     * 显示教师荣誉册列表
     *
     * @return \think\Response
     */
    public function index()
    {
        // 设置要给模板赋值的信息
        $list['webtitle'] = '荣誉列表';

        // 模板赋值
        $this->assign('list',$list);

        // 渲染模板
        return $this->fetch();
    }

/**
     *荣誉册中荣誉信息列表
     *
     * @return \think\Response
     */
    public function rongyuList($rongyuce)
    {
        // 荣誉数据模型
        $ry = new \app\rongyu\model\JsRongyu;
        // 设置要给模板赋值的信息
        $list['webtitle'] = $ry->where('id',$rongyuce)->value('title') . ' 荣誉';
        $list['rongyuce'] = $rongyuce;

        // 模板赋值
        $this->assign('list',$list);

        // 渲染模板
        return $this->fetch();
    }


    /**
     * 显示教师荣誉册列表
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
                    'fzschool'=>array(),
                    'hjschool'=>array(),
                    'category'=>array(),
                    'rongyuce'=>'',
                    'searchval'=>''
                ],'POST');


        // 实例化
        $ryinfo = new ryinfo;

        // 查询要显示的数据
        $data = $ryinfo->search($src);
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
    public function create($rongyuce = 0)
    {
        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'添加荣誉',
            'butname'=>'添加',
            'formpost'=>'POST',
            'url'=>'/jsryinfo',
            'rongyuce'=>$rongyuce
        );

        // 模板赋值
        $this->assign('list',$list);
        // 渲染
        return $this->fetch('create');
    }

    /**留备用
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save()
    {
        
        // 获取表单数据
        $list = request()->only(['rongyuce','title','bianhao','category','hjschool','subject','hjshijian','jiangxiang','hjteachers','cyteachers','pic'],'put');


        // 实例化验证类
        $validate = new \app\rongyu\validate\JsRongyuInfo;
        // 验证表单数据
        $result = $validate->scene('add')->check($list);
        $msg = $validate->getError();

        // 如果验证不通过则停止保存
        if(!$result){
            return json(['msg'=>$msg,'val'=>0]);
        }


        // 更新数据
        $data = ryinfo::create($list);

        // 声明教师数组
            $teacherlist = [];
            // 循环组成获奖教师信息
            foreach ($list['hjteachers'] as $key => $value) {
                $canyulist[] = [
                    'teacherid' => $value,
                    'category' => 1,
                ];
            }
            if(!empty($list['cyteachers'])){
                // 循环组成参与教师信息
                foreach ($list['cyteachers'] as $key => $value) {
                    $canyulist[] = [
                        'teacherid' => $value,
                        'category' => 2,
                    ];
                }
            }
            

        // 添加新的获奖人与参与人信息
        $data->allJsry()->saveAll($canyulist);

        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'添加成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }

    /**
     * 批量上传教师荣誉册图片
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function createAll($rongyuce)
    {

        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'批量上传教师荣誉册图片',
            'butname'=>'批传',
            'formpost'=>'POST',
            'url'=>'/jsryinfoaddall/'.$rongyuce,
        );

        // 模板赋值
        $this->assign('list',$list);
        // 渲染
        return $this->fetch();
    }

    // 保存批传
    public function saveall($rongyuce)
    {
        // 获取文件信息
        $list['text'] = $this->request->post('text');
        $list['serurl'] = $this->request->post('serurl');

        // 获取表单上传文件
        $file = request()->file('file');
        // 上传文件并返回结果
        $data = upload($list,$file);

        if($data['val'] != 1)
        {
            $data=['msg'=>'添加失败','val'=>0];
        }

        $data = ryinfo::create([
            'pic'=>$data['url']
            ,'title'=>'批传教师荣誉'
            ,'rongyuce'=>$rongyuce
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
    public function upload()
    {
        // 获取文件信息
        $list['text'] = $this->request->post('text');
        $list['serurl'] = $this->request->post('serurl');

        // 获取表单上传文件
        $file = request()->file('file');
        // 上传文件并返回结果
        $data = upload($list,$file);

        return json($data);
    }

    /**
     * 荣誉册中荣誉信息列表
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {

    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        // 获取荣誉信息
        $list['data'] = ryinfo::where('id',$id)
                ->field('id,rongyuce,title,bianhao,hjschool,subject,jiangxiang,hjshijian,pic')
                ->with([
                    'hjJsry'=>function($query){
                        $query->field('rongyuid,teacherid')
                        ->with(['teacher'=>function($query){
                            $query->field('id,xingming');
                        }]);
                    },
                    'cyJsry'=>function($query){
                        $query->field('rongyuid,teacherid')
                        ->with(['teacher'=>function($query){
                            $query->field('id,xingming');
                        }]);
                    },
                    'ryTuce'=>function($query){
                        $query->field('id,fzshijian');
                    }
                ])
                ->find();

        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'编辑荣誉',
            'butname'=>'修改',
            'formpost'=>'PUT',
            'url'=>'/jsryinfo/'.$id,
            'rongyuce'=>$id
        );

        // 模板赋值
        $this->assign('list',$list);
        // 渲染
        return $this->fetch('create');
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
        $list = request()->only(['bianhao','title','category','hjschool','subject','hjshijian','jiangxiang','hjteachers','cyteachers','pic'],'put');
        $list['id'] = $id;


        // 实例化验证类
        $validate = new \app\rongyu\validate\JsRongyuInfo;
        // 验证表单数据
        $result = $validate->scene('edit')->check($list);
        $msg = $validate->getError();

        // 如果验证不通过则停止保存
        if(!$result){
            return json(['msg'=>$msg,'val'=>0]);
        }


        // 更新数据
        $data = ryinfo::update($list);

        // 删除原来的获奖人与参与人信息
        $data->allJsry()->where('rongyuid',$id)->delete(true);
        // 声明教师数组
            $teacherlist = [];
            // 循环组成获奖教师信息
            foreach ($list['hjteachers'] as $key => $value) {
                $canyulist[] = [
                    'teacherid' => $value,
                    'category' => 1,
                ];
            }
            if(!empty($list['cyteachers'])){
                // 循环组成参与教师信息
                foreach ($list['cyteachers'] as $key => $value) {
                    $canyulist[] = [
                        'teacherid' => $value,
                        'category' => 2,
                    ];
                }
            }
            

        // 添加新的获奖人与参与人信息
        $data->allJsry()->saveAll($canyulist);

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

        $data = ryinfo::destroy($id);

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
        $data = ryinfo::where('id',$id)->update(['status'=>$value]);

        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'状态设置成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }

    

    // 下载荣誉信息
    public function outXlsx($rongyuce)
    {

        $ryinfo = new ryinfo();
        $list = $ryinfo->srcTuceRy($rongyuce);

        // halt($list);

        if($list->isEmpty())
        {
            $this->error('兄弟，没有要下载的信息呀~');
            return '';
        }else{
            $filename = $list[0]['ryTuce']['title'];
            $fzschool = $list[0]['ryTuce']['fz_school']['title'];
            $fzshijian = strtotime($list[0]['ryTuce']['fzshijian']);
            $fzshijian = date('Ym',$fzshijian);
        }

        //通过工厂模式创建内容
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load("uploads/rongyu_teacher/js_rongyu.xlsx");
        $worksheet = $spreadsheet->getActiveSheet();

        $worksheet->getCell('A1')->setValue($filename);
        $worksheet->getCell('A2')->setValue('发证单位:'.$fzschool);
        $worksheet->getCell('G2')->setValue('发证时间:'.$list[0]['ryTuce']['fzshijian']);
        // 循环为excel每行赋值
        foreach ($list as $key => $value) {
            $myrowid = $key + 4;
            $worksheet->getCell('A'.$myrowid)->setValue($key+1);
            $worksheet->getCell('B'.$myrowid)->setValue($value->title);
            $worksheet->getCell('C'.$myrowid)->setValue($value->hjJsName);
            if($value->hj_school){
                $worksheet->getCell('D'.$myrowid)->setValue($value->hj_school->jiancheng);
            }
            if($value->ry_subject){
                $worksheet->getCell('E'.$myrowid)->setValue($value->ry_subject->title);
            }
            $worksheet->getCell('F'.$myrowid)->setValue($value->cyJsName);
            if($value->jx_category){
                $worksheet->getCell('G'.$myrowid)->setValue($value->jx_category->title);
            }
            $worksheet->getCell('H'.$myrowid)->setValue($value->bianhao);
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
            
            $worksheet->getStyle('A10:I'.($key+4))->applyFromArray($styleArray);
            // 设置行高
            for($i = 10;  $i<=($key+4); $i++){
                $worksheet->getRowDimension($i)->setRowHeight(30);
            }
            
        }

        $worksheet->getStyle('A4')->applyFromArray($styleArray);


        //告诉浏览器输出07Excel文件
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        //告诉浏览器输出浏览器名称
        header('Content-Disposition: attachment;filename="'. $filename .$fzshijian.'.xlsx"');
        //禁止缓存
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        // ob_end_clean();
        // ob_start();
        // 释放内存
        $spreadsheet->disconnectWorksheets();
        unset($spreadsheet);

        // return '下载后请关闭窗口';
    }


    // 搜索教师荣誉
    public function ryTeacher($id)
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

        //得到搜索的关键词
        $search = [
            'teacherid'=>$id,
            'order'=>$order,
            'order_field'=>$order_field
        ];


        // 实例化
        $ryinfo = new ryinfo;

        // 获取荣誉总数
        $cnt = $ryinfo->select()->count();

        // 查询数据
        $data = $ryinfo->srcTeacher($search);
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





}
