<?php

namespace app\teach\controller;

// 引用控制器基类
use app\common\controller\Base;
// 引用班级数据模型类
use app\teach\model\Banji as BJ;

class Banji extends Base
{
    // 显示班级列表
    public function index()
    {
       // 设置要给模板赋值的信息
        $list['webtitle'] = '班级列表';

        // 模板赋值
        $this->assign('list',$list);

        // 渲染模板
        return $this->fetch();
    }



    // 获取班级信息列表
    public function ajaxData()
    {

        // 获取参数
        $src = $this->request
                ->only([
                    'page'=>'1',
                    'limit'=>'10',
                    'field'=>'update_time',
                    'order'=>'asc',
                    'school'=>'',
                    'ruxuenian'=>'',
                    'searchval'=>''
                ],'POST');


        // 实例化
        $bj = new BJ;

        // 查询要显示的数据
        $data = $bj->search($src);
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



    // 创建班级
    public function create()
    {
        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'添加班级',
            'butname'=>'添加',
            'formpost'=>'POST',
            'url'=>'/banji',
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
        $validate = new \app\teach\validate\Banji;


        // 获取表单数据
        $list = request()->only(['school','ruxuenian','bjsum'],'post');


        // 验证表单数据
        $result = $validate->check($list);
        $msg = $validate->getError();


        // 如果验证不通过则停止保存
        if(!$result){
            return json(['msg'=>$msg,'val'=>0]);
        }

        $paixumax = BJ::where('school',$list['school'])
                ->where('ruxuenian',$list['ruxuenian'])
                ->max('paixu');

        if($paixumax + $list['bjsum'] > 25){
            $list['bjsum'] = 25 - $paixumax;
        }

        $i = 1;
        while($i<=$list['bjsum'])
        {
            $bjarr[] = array(
                'school'=>$list['school'],
                'ruxuenian'=>$list['ruxuenian'],
                'paixu'=>$paixumax+$i
            );
            $i++;
        }

        // 实例化班级数据模型类
        $bj = new BJ();

        // 保存数据 
        $data = $bj->saveAll($bjarr);

        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'添加成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }

    //
    public function read($id)
    {
        //
    }




    // 修改班级信息
    public function edit($id)
    {

        // 获取班级信息
        $list = BJ::field('id,school,ruxuenian,paixu')
            ->get($id);


        $this->assign('list',$list);

        return $this->fetch();
    }





    // 更新班级信息
    public function update($id)
    {
        $validate = new \app\teach\validate\Xueqi;

        // 获取表单数据
        $list = request()->only(['title','xuenian','category','bfdate','enddate'],'put');

        // 验证表单数据
        $result = $validate->check($list);
        $msg = $validate->getError();

        // 如果验证不通过则停止保存
        if(!$result){
            return json(['msg'=>$msg,'val'=>0]);;
        }


        // 更新数据
        $xq = new XQ();
        $data = $xq->save($list,['id'=>$id]);
        // $data = BJ::where('id',$id)->update($list);

        // 根据更新结果设置返回提示信息
        $data>=0 ? $data=['msg'=>'更新成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }

    



    // 删除班级
    public function delete($id)
    {

        if($id == 'm')
        {
            $id = request()->delete('ids/a');// 获取delete请求方式传送过来的数据并转换成数据
        }

        $data = BJ::destroy($id);

        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'删除成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }



    // 设置班级状态
    public function setStatus()
    {

        //  获取id变量
        $id = request()->post('id');
        $value = request()->post('value');

        // 获取班级信息
        $data = BJ::where('id',$id)->update(['status'=>$value]);

        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'状态设置成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }


    public function yidong($id)
    {
        // 获取操作参数
        $caozuo = input('post.cz');

        // 获取当前班级信息
        $thisbj = BJ::get($id);

        // 获取别一个班级信息
        if( $caozuo > 0 )
        {
            $bjinfo = BJ::where('school',$thisbj->getData('school'))
                    ->where('ruxuenian',$thisbj->ruxuenian)
                    ->where('paixu','>=',$thisbj->paixu)
                    ->order(['paixu'])
                    ->limit('2')
                    ->field('id,paixu')
                    ->select();
        }else{
            $bjinfo = BJ::where('school',$thisbj->getData('school'))
                    ->where('ruxuenian',$thisbj->ruxuenian)
                    ->where('paixu','<=',$thisbj->paixu)
                    ->order(['paixu'=>'desc'])
                    ->limit('2')
                    ->field('id,paixu')
                    ->select();
        }
        if($bjinfo->count() == 2)
        {
            // 更改班级位置
            foreach ($bjinfo as $key => $value) {
                $value->paixu = $value->paixu + $caozuo;
                $caozuo = $caozuo * -1;
            }
            $bjinfo = $bjinfo->toArray();

            // 实例化班级数据模型
            $bj = new BJ();
            // 更新数据
            $data = $bj->saveAll($bjinfo);
            $data ? $data = ['msg'=>'移动成功','val'=>1] : $data = ['msg'=>'数据处理错误','val'=>0];
        }else{
            $data = ['msg'=>'已经到头啦~','val'=>0];
        }

        // 返回处理结果
        return json($data);
        
    }


    // 根据单位年级获取班级列表
    public function mybanji()
    {
        $school = input('post.school');
        $nianji = input('post.nianji');
        // 获取班级id列表
        $list = BJ::where('school',$school)
                ->where('ruxuenian',$nianji)
                ->order('paixu')
                ->select();
        // 追加班级名
        $list = $list->append(['title']);

        // 声明班级空数组
        $banji = array();
        // 重组数据
        foreach ($list as $key => $value) {
            $banji[] = ['id'=>$value['id'],'title'=>$value['title']];
        }
        return json($banji);
    }


    // 获取该学校各年级的班级名和id
    public function banjilist()
    {
        // 获取学校
        $school = input('post.school');
        // 获取年级名对应的入学年
        $njanmelist = nianjiList();
        $bjnamelist = banjinamelist();
        $njlist = array_keys($njanmelist);



        // 查询年级数据
        $list = BJ:: where('school',$school)
                ->where('ruxuenian','in',$njlist)
                ->group('ruxuenian')
                ->field('school,ruxuenian')
                ->select();
        // 追加年级对应的班级数
        $list = $list->append(['banjiids']);
        
        // 重新组合数据
        $bjarr = array();

        foreach ($list as $key => $value) {
            $bjarr[$value->ruxuenian]['title'] = $njanmelist[$value->ruxuenian];   #赋值年级名
            $bj = array();
            foreach ($value['banjiids'] as $key => $val) {
                $bjarr[$value->ruxuenian]['banji'][$key] = $bjnamelist[$val];  #赋值班级名
            }
        }

        // 返回数据
        return json($bjarr);

    }



}
