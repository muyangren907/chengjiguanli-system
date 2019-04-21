<?php

namespace app\kaoshi\controller;

// 引用控制器基类
use app\common\controller\Base;
// 引用考试数据模型类
use app\kaoshi\model\Kaoshi as KS;



class Index extends Base
{
    // 显示考试列表
    public function index()
    {

        // 设置要给模板赋值的信息
        $list['webtitle'] = '考试列表';

        // 模板赋值
        $this->assign('list',$list);

        // 渲染模板
        return $this->fetch();
    }


    // 获取考试信息列表
    public function ajaxData()
    {

        // 获取参数
        $src = $this->request
                ->only([
                    'page'=>'1',
                    'limit'=>'10',
                    'field'=>'update_time',
                    'order'=>'asc',
                    'searchval'=>''
                ],'POST');


        // 实例化
        $ks = new KS;

        // 查询要显示的数据
        $data = $ks->search($src);
        // 获取符合条件记录总数
        $cnt = $data->count();
        // 获取当前页数据
        $limit_start = $src['page'] * $src['limit'] - $src['limit'];
        $limit_length = $src['limit']-1;
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



    // 创建考试
    public function create()
    {
        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'新建考试',
            'butname'=>'创建',
            'formpost'=>'POST',
            'url'=>'/kaoshi',
        );


        // 模板赋值
        $this->assign('list',$list);
        // 渲染
        return $this->fetch('create');
    }

    

    // 保存信息
    public function save()
    {
        // 实例化验证模型
        $validate = new \app\kaoshi\validate\Kaoshi;


        // 获取表单数据
        $list = request()->only(['title','xueqi','category','bfdate','enddate','zuzhi'],'post');

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


        // 根据更新结果设置返回提示信息
        $ksdata ? $data=['msg'=>'添加成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }

    //
    public function read($id)
    {
        //
    }




    // 修改考试信息
    public function edit($id)
    {

        // 获取考试信息
        $list['data'] = KS::where('id',$id)
            ->field('id,title,xueqi,category,bfdate,enddate,zuzhi')
            ->append(['nianjiids','manfenedit'])
            ->find();

        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'编辑考试',
            'butname'=>'修改',
            'formpost'=>'PUT',
            'url'=>'/kaoshi/'.$id,
        );


        // 模板赋值
        $this->assign('list',$list);
        // 渲染
        return $this->fetch('create');

    }





    // 更新考试信息
    public function update($id)
    {
        $validate = new \app\kaoshi\validate\Kaoshi;

        // 获取表单数据
        $list = request()->only(['title','xueqi','category','bfdate','enddate','zuzhi'],'post');

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


        // 根据更新结果设置返回提示信息
        $ksdata ? $data=['msg'=>'更新成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }





    // 设置考试信息
    public function kaoshiset($id)
    {

        // 获取考试信息
        $data = KS::where('id',$id)
                    ->with(
                            [
                                'ksSubject'=>function($query){
                                    $query->with([
                                        'subjectName'=>function($q){
                                            $q->field('id,jiancheng');
                                        }
                                    ]);
                                }
                                ,'ksNianji'
                            ]
                        )
                    ->field('id')
                    ->find();

        // 重新整理年级和学科
        $subject=array();
        foreach ($data['ks_subject'] as $key => $value) {
            $subject[] = $value['subjectid'];
        }

        $nianji = array();
        foreach ($data['ks_nianji'] as $key => $value) {
            $nianji[] = $value['nianji'];
        }

        $list['data']['ks_subjectid'] = implode(',' , $subject);
        $list['data']['ks_nianjiid'] = implode(',' , $nianji);
        $list['data']['ks_subject'] = $subject;


        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'设置考试',
            'butname'=>'设置',
            'formpost'=>'PUT',
            'url'=>'/kaoshiset/'.$id,
        );


        // 模板赋值
        $this->assign('list',$list);
        // 渲染
        return $this->fetch();

    }





    // 更新考试信息
    public function updateset($id)
    {
        $validate = new \app\kaoshi\validate\Kaoshiset;

        // 获取表单数据
        $list = request()->only(['nianji','subject','manfen','youxiu','jige','lieming','nianjiname'],'post');


        // 验证表单数据
        $result = $validate->check($list);
        $msg = $validate->getError();
        

        // 如果验证不通过则停止保存
        if(!$result){
            return json(['msg'=>$msg,'val'=>0]);;
        }

        $list['id'] = $id;

        // 整理数据
        $data = array();
        $i = 0;
        foreach ($list['subject'] as $key => $value) {
            $data[$i]['subjectid'] = $key;
            $data[$i]['manfen'] = $list['manfen'][$key];
            $data[$i]['youxiu'] = $list['youxiu'][$key];
            $data[$i]['jige'] = $list['jige'][$key];
            $data[$i]['lieming'] = $list['lieming'][$key];
            $i++;
        }

        // 更新数据
        $ks = new KS();
        $ksdata = $ks->where('id',$list['id'])->find();

        // 更新学科表
        $subjectdata=$ksdata->ksSubject()->delete();
        $subjectdata=$ksdata->ksSubject()->saveAll($data);


        // 整理数据
        $data = array();
        $i = 0;
        foreach ($list['nianji'] as $key => $value) {
            $data[$i]['nianji'] = $key;
            $data[$i]['nianjiname'] = $list['nianjiname'][$key];
            $i++;
        }

        // 更新学科表
        $nianjidata=$ksdata->ksNianji()->delete();
        $nianjidata=$ksdata->ksNianji()->saveAll($data);


        // 根据更新结果设置返回提示信息
        $ksdata && $subjectdata && $nianjidata ? $data=['msg'=>'更新成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }

    



    // 删除考试
    public function delete($id)
    {

        if($id == 'm')
        {
            $id = request()->delete('ids');// 获取delete请求方式传送过来的数据并转换成数据
        }

        $data = KS::destroy($id);

        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'删除成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }



    // 设置考试状态
    public function setStatus()
    {

        //  获取id变量
        $id = request()->post('id');
        $value = request()->post('value');

        // 获取考试信息
        $data = KS::where('id',$id)->update(['status'=>$value]);

        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'状态设置成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }






}
