<?php
declare (strict_types = 1);

namespace app\TeacherSearchChengji\controller;

// 引用学生查询基类
use \app\base\controller\TeacherSearchBase;

// 引用考试数据模型类
use app\kaoshi\model\Kaoshi as KS;
use app\middleware\KaoshiStatus;

class Kaoshi extends TeacherSearchBase
{
    // 显示考试列表
    public function index()
    {
        // 设置要给模板赋值的信息
        $url = '/TeacherSearchChengji/kaoshi/';
        $list['webtitle'] = '考试列表';
        $list['dataurl'] = $url . 'data';
        $list['status'] = $url . 'status';
        $list['luru'] = $url . 'luru';
        $list['create'] = $url . 'create';
        $list['edit'] = $url . 'edit';
        $list['delete'] = $url . 'delete';
        $list['more'] = $url . 'more';
        $list['user_group'] = 'teacher';
        $list['user_id'] = session('user_id');

        // 模板赋值
        $this->view->assign('list', $list);
        // 渲染模板
        return $this->view->fetch('kaoshi@index/index');
    }


    // 获取考试信息列表
    public function ajaxData()
    {
        // 获取参数
        $src = $this->request
            ->only([
                'xueqi_id' => ''
                ,'category_id' => ''
                ,'page' => '1'
                ,'limit' => '10'
                ,'field' => 'id'
                ,'order' => 'desc'
                ,'searchval' => ''
                ,'user_group' => ''
                ,'user_id' => ''
            ], 'POST');
        // 根据条件查询数据
        $ks = new KS;
        $data = $ks->search($src)
            ->visible([
                'id'
                ,'title'
                ,'bfdate'
                ,'enddate'
                ,'status'
                ,'luru'
                ,'ksCategory' => ['id', 'title']
                ,'ksZuzhi' => ['id', 'title']
                ,'ksXueqi' => ['id', 'title']
                ,'update_time'
            ]);
        $data = reSetObject($data, $src);

        return json($data);
    }


    // 创建考试
    public function create()
    {
        // 设置页面标题
        $list['set'] = array(
            'webtitle' => '新建考试'
            ,'butname' => '创建'
            ,'formpost' => 'POST'
            ,'url' => '/TeacherSearchChengji/kaoshi/save'
        );

        // 模板赋值
        $this->view->assign('list', $list);
        // 渲染
        return $this->view->fetch('kaoshi@index/create');
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
            ,'user_group' => session('onlineCategory')
            ,'user_id' => session('user_id')
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
            ->append(['nianjiids', 'manfenedit'])
            ->find();

        // 设置页面标题
        $list['set'] = array(
            'webtitle' => '编辑考试'
            ,'butname' => '修改'
            ,'formpost' => 'PUT'
            ,'url' => '/TeacherSearchChengji/kaoshi/update/' . $id
        );

        // 模板赋值
        $this->view->assign('list', $list);
        // 渲染
        return $this->view->fetch('kaoshi@index/create');
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
        $result = $validate->scene('edit')->check($list);
        $msg = $validate->getError();
        if(!$result){
            return json(['msg' => $msg, 'val' => 0]);
        }

        // 更新数据
        $ks = new KS();
        $ksdata = $ks::update($list);
        $ksdata ? $data = ['msg' => '更新成功', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];

        // 返回信息
        return json($data);
    }


    // 设置成绩是否允许编辑
    public function luru()
    {
        //  获取id变量
        $id = request()->post('id');
        $value = request()->post('value');

        // 获取考试信息
        $data = KS::where('id', $id)->update(['luru' => $value]);
        $data ? $data = ['msg' => '状态设置成功', 'val' => 1]
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


    // 考试更多操作页面
    public function moreAction($kaoshi_id)
    {
        // 获取考试信息
        $kaoshi = KS::where('id', $kaoshi_id)
            ->field('id, title, bfdate, enddate')
            ->find();

        // 设置页面标题
        $list['webtitle'] = $kaoshi->title  . '（' .  $kaoshi->bfdate . '~' . $kaoshi->enddate . '）';
        $list['kaoshi_id'] = $kaoshi->id;

        // 设置操作
        $url = '/TeacherSearchChengji/';
        $list['menu'] = [
            [
                'title' => '一、前期操作'
                ,'top' =>[
                    [
                        'title' => '考试设置'
                        ,'oncleck' => 'addteb'
                        ,'url' => $url . 'kaoshiset/index/' . $list['kaoshi_id']
                        ,'font' => '&#xe716;'
                        ,'w' => 600
                        ,'h' => 300
                    ]
                    ,[
                        'title' => '生成考号'
                        ,'oncleck' => 'addlayer'
                        ,'url' => $url . 'kaohao/createall/' . $list['kaoshi_id']
                        ,'font' => '&#xe66e;'
                        ,'w' => 600
                        ,'h' => 300
                    ]
                    ,[
                        'title' => '下载试卷标签数据'
                        ,'oncleck' => 'addlayer'
                        ,'url' => $url . 'excel/biaoqian/' . $list['kaoshi_id']
                        ,'font' => '&#xe663;'
                        ,'w' => 600
                        ,'h' => 300
                    ]

                ]
            ]
            ,[
                'title' => '二、表格录入'
               ,'top' =>[
                    [
                        'title' => '下载成绩录入表格'
                        ,'oncleck' => 'addlayer'
                        ,'url' => $url . 'excel/caiji/' . $list['kaoshi_id']
                        ,'font' => '&#xe656;'
                        ,'w' => 600
                        ,'h' => 300
                    ]
                    ,[
                        'title' => '已录成绩数量'
                        ,'oncleck' => 'addteb'
                        ,'url' => $url . '/chengji/tongji/yilucnt/' . $list['kaoshi_id']
                        ,'font' => '&#xe629;'
                        ,'w' => 600
                        ,'h' => 300
                    ]

                ]
            ]
            ,[
                'title' => '三、成绩统计'
               ,'top' =>[
                    [
                        'title' => '考试设置'
                        ,'oncleck' => 'addteb'
                        ,'url' => $url . 'kaoshiset/index/' . $list['kaoshi_id']
                        ,'font' => '&#xe716;'
                    ]

                ]
            ]
            ,[
                'title' => '四、统计结果'
               ,'top' =>[
                    [
                        'title' => '考试设置'
                        ,'oncleck' => 'addteb'
                        ,'url' => $url . 'kaoshiset/index/' . $list['kaoshi_id']
                        ,'font' => '&#xe716;'
                    ]

                ]
            ]
        ];


        $this->view->assign('list', $list);
        // 渲染
        return $this->view->fetch('kaoshi@index/more_action');
    }
}