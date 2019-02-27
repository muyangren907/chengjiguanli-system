<?php

namespace app\keti\controller;

// 引用控制器基类
use app\common\controller\Base;
// 引用课题信息数据模型类
use app\keti\model\KetiInfo as ktinfo;


class KetiInfo extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        // 设置数据总数
        $list['count'] = ktinfo::count();
        // 设置页面标题
        $list['title'] = '课题信息列表';

        // 模板赋值
        $this->assign('list', $list);

        // 渲染模板
        return $this->fetch();
    }



    /**
     * 显示课题信息列表
     *
     * @return \think\Response
     */
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

        //得到搜索的关键词
        $search = [
            'lxdanweiid'=>$getdt['lxdanweiid'],
            'lxcategory'=>$getdt['lxcategory'],
            'fzdanweiid'=>$getdt['fzdanweiid'],
            'subject'=>$getdt['subject'],
            'category'=>$getdt['category'],
            'ketice'=>$getdt['ketice'],
            'search'=>$getdt['search']['value'],
            'order'=>$order,
            'order_field'=>$order_field
        ];

        // 实例化
        $keti = new ktinfo;

        // 获取荣誉总数
        $cnt = $keti->select()->count();

        // 查询数据
        $data = $keti->search($search);
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




    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create($id=0)
    {
        // 设置页面标题
        $list['title'] = '添加课题信息';
        $list['ketice'] = $id;

        // 模板赋值
        $this->assign('list',$list);

        // 渲染
        return $this->fetch();
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
        $list = request()->only(['ketice','title','bianhao','fzdanweiid','subject','category','jhjtshijian','hjteachers'],'POST');



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
        $data->ktZcr()->saveAll($canyulist);

        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'添加成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }


    // 批量上传立项通知书
    public function createall($id)
    {
        // 设置页面标题
        $list['title'] = '批量添加课题信息';
        $list['ketice'] = $id;

        // 模板赋值
        $this->assign('list',$list);

        // 渲染
        return $this->fetch();
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
        $ketice=input('post.ketice');


        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');
        // 移动到框架应用根目录/uploads/ 目录下
        $info = $file->validate(['size'=>2*1024*1024,'ext'=>'jpg,png,gif,jpeg'])->move('uploads\keti\lixiang');

     

        if($info){
            // 成功上传后 获取上传信息
            $list['url'] = $info->getSaveName();
            $list['url'] = str_replace('\\','/',$list['url']);


            // 如果图片上传成功，则添加荣誉记录
            $data = ktinfo::create(['lxpic'=>$list['url'],'ketice'=>$ketice]);
            $id = $data->id;

            $id ? $data = array('msg'=>'上传成功','val'=>true,'url'=>$list['url'],'ktid'=>$id) : $data = array('msg'=>'保存文件信息失败','val'=>false,'url'=>null);
        }else{
            // 上传失败获取错误信息
            $data = array('msg'=>$file->getError(),'val'=>false,'url'=>null);
        }

        // 返回信息
        return json($data);
    }


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
        $list = ktinfo::where('id',$id)
                ->field('id,title,fzdanweiid,bianhao,subject,category,jhjtshijian,lxpic')
                ->with([
                    'ktZcr'=>function($query){
                        $query->field('ketiinfoid,teacherid')
                        ->with(['teacher'=>function($query){
                            $query->field('id,xingming');
                        }]);
                    },
                ])
                ->find();
        

        // 模板赋值
        $this->assign('list',$list);

        // 渲染模板
        return $this->fetch();
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
        $list = request()->only(['ketice','title','bianhao','fzdanweiid','subject','category','jhjtshijian','hjteachers','lxpic'],'PUT');
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
        $data->ktZcr()
            ->where('ketiinfoid',$list['id'])
            ->where('category',1)
            ->delete(true);
        // 声明教师数组
            $teacherlist = [];
            // 循环组成获奖教师信息
            foreach ($list['hjteachers'] as $key => $value) {
                $canyulist[] = [
                    'teacherid' => $value,
                    'rongyuid' => $list['id'],
                    'category' => 1,
                ];
            }
            

        // 添加新的获奖人与参与人信息
        $data->ktZcr()->saveAll($canyulist);

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
        //
    }



}
