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



    // 创建考试
    public function create()
    {
        // 设置页面标题
        $list['title'] = '添加考试';

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
                'manfen'=>$list['manfen'][$key],
                'youxiu'=>$list['manfen'][$key]*0.9,
                'jige'=>$list['manfen'][$key]*0.6
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




    // 修改考试信息
    public function edit($id)
    {

        // 获取考试信息
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





    // 更新考试信息
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
                'manfen'=>$list['manfen'][$key],
                'youxiu'=>$list['manfen'][$key]*0.9,
                'jige'=>$list['manfen'][$key]*0.6,
            ];
        }
        // 添加考试学科信息
        $xkdata = $ksdata->kaoshisubject()->saveAll($subjectarr);

        // 根据更新结果设置返回提示信息
        $ksdata&&$njdata&&$xkdata ? $data=['msg'=>'更新成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

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
