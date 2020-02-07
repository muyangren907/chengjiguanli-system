<?php

namespace app\teach\controller;

// 引用控制器基类
use app\BaseController;
// 引用班级数据模型类
use app\teach\model\Banji as BJ;

class Banji extends BaseController
{
    // 显示班级列表
    public function index()
    {
       // 设置要给模板赋值的信息
        $list['webtitle'] = '班级列表';
        $list['dataurl'] = 'banji/data';

        // 模板赋值
        $this->view->assign('list',$list);

        // 渲染模板
        return $this->view->fetch();
    }



    // 获取班级信息列表
    public function ajaxData()
    {
        // 获取参数
        $src = $this->request
                ->only([
                    'page'=>'1',
                    'limit'=>'10',
                    'field'=>'school',
                    'order'=>'asc',
                    'school'=>'',
                    'ruxuenian'=>'',
                ],'POST');


        // 实例化
        $bj = new BJ;

        // 查询要显示的数据
        $data = $bj->search($src);
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



    // 创建班级
    public function create()
    {
        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'添加班级',
            'butname'=>'添加',
            'formpost'=>'POST',
            'url'=>'save',
        );

        // 模板赋值
        $this->view->assign('list',$list);
        // 渲染
        return $this->view->fetch('create');
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
            ->find($id);


        $this->view->assign('list',$list);

        return $this->view->fetch();
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
            $id = request()->delete('ids');// 获取delete请求方式传送过来的数据并转换成数据
        }

        $id = explode(',', $id);

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
        $thisbj = BJ::find($id);


        // 获取别一个班级信息
        if( $caozuo > 0 )
        {
            $bjinfo = BJ::withTrashed()
                    ->where('school',$thisbj->getData('school'))
                    ->where('ruxuenian',$thisbj->ruxuenian)
                    ->where('paixu','>=',$thisbj->paixu)
                    ->order(['paixu'])
                    ->limit('2')
                    ->field('id,paixu')
                    ->select();
        }else{
            $bjinfo = BJ::withTrashed()
                    ->where('school',$thisbj->getData('school'))
                    ->where('ruxuenian',$thisbj->ruxuenian)
                    ->where('paixu','<=',$thisbj->paixu)
                    ->order(['paixu'=>'desc'])
                    ->limit('2')
                    ->field('id,paixu')
                    ->select();
        }
        if($bjinfo->count() == 2)
        {
            $bjinfo = $bjinfo->toArray();

            $temp = $bjinfo[0]['paixu'];
            $bjinfo[0]['paixu'] = $bjinfo[1]['paixu'];
            $bjinfo[1]['paixu'] = $temp;

            // 实例化Db类
            $db = new \think\facade\Db;
            $yz = 0;
            foreach ($bjinfo as $key => $value) {
                $data = $db::name('banji')->update($value);
                $data ? $yz = $yz : $yz = $yz+1;
            }

            $bj = new BJ;
            $bjtitle = $bj->myBanjiTitle($bjinfo[0]['id']);
            

            $yz==0 ? $data = ['msg'=>'移动成功','val'=>1,'title'=>$bjtitle,'paixu'=>$bjinfo[0]['paixu']] : $data = ['msg'=>'数据处理错误','val'=>0];
        }else{
            $data = ['msg'=>'已经到头啦~','val'=>0];
        }

        // 返回处理结果
        return json($data);
        
    }


    /**
     * 获取文件信息并保存
     *
     * @param  str      $school    单位id
     *         str      $ruxuenian  入学年
     * @return array  $data
     */
    public function mybanji()
    {
        // 获取变量
        $school = input('post.school');
        $ruxuenian = input('post.ruxuenian');
        // 获取班级id列表
        $list = BJ::where('school',$school)
                ->where('ruxuenian','in',$ruxuenian)
                ->order('paixu')
                ->field('id,ruxuenian,paixu')
                ->where('status',1)
                ->append(['banTitle'])
                ->select()->toArray();
        $cnt = count($list);

        $data = [
            'count'=>$cnt, // 符合条件的总数据量
            'data'=>$list, //获取到的数据结果
        ];

        return json($data);
    }


    // 获取该学校各年级的班级名和id
    public function banjiList()
    {
        // 获取年级名对应的入学年
        $njanmelist = nianjiList();
        $bjnamelist = banjinamelist();
        $njlist = array_keys($njanmelist);

        // 获取变量
        $school = input('post.school');
        // $ruxuenian = explode(',',input('post.ruxuenian'));
        $ruxuenian = input('post.ruxuenian');
        $ruxuenian = strToarray($ruxuenian);

        // 查询年级数据
        $list = BJ:: where('school',$school)
                ->where('ruxuenian','in',$ruxuenian)
                ->where('status',1)
                ->group('ruxuenian')
                ->field('ruxuenian')
                ->with([
                    'njBanji'=>function($query)use($school){
                        $query->where('status',1)
                        ->where('school',$school)
                        ->field('id,ruxuenian,paixu')
                        ->where('status',1)
                        ->order('paixu')
                        ->append(['banjiTitle','banTitle']);
                    }
                ])
                ->select();
        // 返回数据
        return json($list);

    }



}
