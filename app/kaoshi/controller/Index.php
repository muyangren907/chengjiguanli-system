<?php

namespace app\kaoshi\controller;

// 引用控制器基类
use app\BaseController;
// 引用考试数据模型类
use app\kaoshi\model\Kaoshi as KS;

use app\middleware\KaoshiStatus;



class Index extends BaseController
{
    // 显示考试列表
    public function index()
    {
        // 设置要给模板赋值的信息
        $list['webtitle'] = '考试列表';
        $list['dataurl'] = 'index/data';
        $list['status'] = '/kaoshi/index/status';
        $list['luru'] = '/kaoshi/index/luru';

        // 模板赋值
        $this->view->assign('list', $list);

        // 渲染模板
        return $this->view->fetch();
    }


    // 获取考试信息列表
    public function ajaxData()
    {
        // 获取参数
        $src = $this->request
            ->only([
                'xueqi'=>''
                ,'category_id'=>''
                ,'page'=>'1'
                ,'limit'=>'10'
                ,'field'=>'id'
                ,'order'=>'desc'
                ,'searchval'=>''
            ], 'POST');

        // 实例化
        $ks = new KS;

        // 查询要显示的数据
        $data = $ks->search($src);
        $data = reSetObject($data, $src);

        return json($data);
    }


    // 创建考试
    public function create()
    {
        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'新建考试'
            ,'butname'=>'创建'
            ,'formpost'=>'POST'
            ,'url'=>'save'
        );

        // 模板赋值
        $this->view->assign('list', $list);
        // 渲染
        return $this->view->fetch('create');
    }


    // 保存信息
    public function save()
    {
        // 获取表单数据
        $list = request()->only([
            'title'
            ,'xueqi_id'
            ,'category_id'
            ,'bfdate'
            ,'enddate'
            ,'zuzhi_id'
        ], 'post');

        // 验证表单数据
        $validate = new \app\kaoshi\validate\Kaoshi;
        $result = $validate->scene('create')->check($list);
        $msg = $validate->getError();
        if(!$result){
            return json(['msg' => $msg, 'val' => 0]);
        }

        // 保存数据
        $ks = new KS();
        $ksdata = $ks->create($list);

        // 根据更新结果设置返回提示信息
        $ksdata ? $data = ['msg' => '添加成功', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];

        // 返回信息
        return json($data);
    }


    // 修改考试信息
    public function edit($id)
    {
        // 获取考试信息
        $list['data'] = KS::where('id', $id)
            ->field('id, title, xueqi_id, category_id, bfdate, enddate, zuzhi_id')
            ->append(['nianjiids','manfenedit'])
            ->find();

        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'编辑考试'
            ,'butname'=>'修改'
            ,'formpost'=>'PUT'
            ,'url'=>'/kaoshi/index/update/' . $id
        );

        // 模板赋值
        $this->view->assign('list', $list);
        // 渲染
        return $this->view->fetch('create');
    }


    // 更新考试信息
    public function update($id)
    {
        event('kslu', $id);
        // 获取表单数据
        $list = request()->only([
            'title',
            'xueqi_id',
            'category_id',
            'bfdate',
            'enddate',
            'zuzhi_id'
        ], 'post');
        $list['id'] = $id;

        // 验证表单数据
        $validate = new \app\kaoshi\validate\Kaoshi;
        $result = $validate->check($list);
        $msg = $validate->getError();

        // 如果验证不通过则停止保存
        if(!$result){
            return json(['msg' => $msg, 'val' => 0]);
        }

        // 更新数据
        $ks = new KS();
        $ksdata = $ks::update($list);

        // 根据更新结果设置返回提示信息
        $ksdata ? $data = ['msg' => '更新成功', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];

        // 返回信息
        return json($data);
    }


    // 删除考试
    public function delete($id)
    {
        // 整理数据
        $id = request()->delete('id');
        $id = explode(',', $id);

        $data = KS::destroy($id);

        // 根据更新结果设置返回提示信息
        $data ? $data = ['msg' => '删除成功', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];

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
        $data = KS::where('id', $id)->update(['status' => $value]);

        // 根据更新结果设置返回提示信息
        $data ? $data = ['msg' => '状态设置成功', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];

        // 返回信息
        return json($data);
    }


    // 设置成绩是否允许操作
    public function luru()
    {
        //  获取id变量
        $id = request()->post('id');
        $value = request()->post('value');

        // 获取考试信息
        $data = KS::where('id', $id)->update(['luru' => $value]);

        // 根据更新结果设置返回提示信息
        $data ? $data = ['msg' => '状态设置成功', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];

        // 返回信息
        return json($data);
    }


    // 考试更多操作页面
    public function moreAction($kaoshi)
    {
        // 获取考试信息
        $kaoshi = KS::where('id', $kaoshi)
            ->field('id, title, bfdate, enddate')
            ->find();

        // 设置页面标题
        $list['webtitle'] = $kaoshi['title']  . '（' .  $kaoshi['bfdate'] . '~' . $kaoshi['enddate'] . '）';
        $list['kaoshi'] = $kaoshi['id'];

        // 模板赋值
        $this->view->assign('list', $list);
        // 渲染
        return $this->view->fetch();
    }


    // 根据考试ID和年级获取参加考试学校
    public function cySchool()
    {
        // 获取变量
        $src['kaoshi'] = input('post.kaoshi');
        $src['ruxuenian'] = input('post.ruxuenian');

        $kh = new \app\kaoshi\model\Kaohao;
        $school = $kh->cySchool($src);
        $cnt = count($school);

        // 重组返回内容
        $data = [
            'count'=>$cnt  // 符合条件的总数据量
            ,'data'=>$school  //获取到的数据结果
        ];

        return json($data);
    }


    // 根据考试ID和年级获取参加考试年级
    public function cyNianji()
    {
        // 获取变量
        $kaoshi = input('post.kaoshi');
        $ksset = new \app\kaoshi\model\KaoshiSet;
        $nianji = $ksset->srcNianji($kaoshi);
        $cnt = count($nianji);

        // 重组返回内容
        $data = [
            'count'=>$cnt, // 符合条件的总数据量
            'data'=>$nianji, //获取到的数据结果
        ];

        return json($data);
    }


    // 根据考试ID和年级获取参加考试班级
    public function cyBanji()
    {
        // 获取变量
        $src['school'] = input('post.school');
        $src['ruxuenian'] = input('post.ruxuenian');
        $src['kaoshi'] = input('post.kaoshi');

        $kh = new \app\kaoshi\model\Kaohao;
        $bj = $kh->cyBanji($src);
        $cnt = count($bj);

        // 重组返回内容
        $data = [
            'count'=>$cnt, // 符合条件的总数据量
            'data'=>$bj, //获取到的数据结果
        ];

        return json($data);
    }


    // 根据考试ID和年级获取参加考试学科
    public function cySubject()
    {
        // 获取变量
        $kaoshi = input('post.kaoshi');
        $nianji = input('post.ruxuenian');

        $ksset = new \app\kaoshi\model\KaoshiSet;
        $sbj = $ksset->srcSubject($kaoshi,'',$nianji);
        $cnt = count($sbj);

        // 重组返回内容
        $data = [
            'count'=>$cnt, // 符合条件的总数据量
            'data'=>$sbj, //获取到的数据结果
        ];

        return json($data);
    }
}
