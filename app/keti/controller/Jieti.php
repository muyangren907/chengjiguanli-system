<?php
declare (strict_types = 1);

namespace app\keti\controller;

// 引用控制器基类
use app\base\controller\AdminBase;

// 引用课题数据模型
use app\keti\model\Jieti as jt;
use app\keti\model\KetiInfo as ktinfo;

class Jieti extends AdminBase
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        // 设置要给模板赋值的信息
        $list['webtitle'] = '课题册列表';
        $list['dataurl'] = '/keti/jieti/data';
        $list['status'] = '/keti/jieti/data';

        // 模板赋值
        $this->view->assign('list', $list);

        // 渲染模板
        return $this->view->fetch();
    }


    /**
     * 显示课题册列表
     *
     * @return \think\Response
     */
    public function ajaxData()
    {
        // 获取参数
        $src = $this->request
            ->only([
                'page' => '1'
                ,'limit' => '10'
                ,'field' => 'shijian'
                ,'order' => 'desc'
                ,'danwei_id' => array()
                ,'searchval' => ''
            ], 'POST');

        // 根据条件查询数据
        $keti = new jt;
        $data = $keti->search($src);
        $data = reSetObject($data, $src);

        return json($data);
    }


    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function list($jieti_id)
    {

        $kt = new jt;
        // 设置要给模板赋值的信息
        $list['webtitle'] = $kt->where('id', $jieti_id)->value('title') . ' 列表';
        $list['jieti_id'] = $jieti_id;
        $list['dataurl'] = '/keti/info/data';
        $list['status'] = '/keti/info/status';

        // 模板赋值
        $this->view->assign('list', $list);

        // 渲染模板
        return $this->view->fetch();
    }


    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        // 设置页面标题
        $list['set'] = array(
            'webtitle' => '添加结题册'
            ,'butname' => '添加'
            ,'formpost' => 'POST'
            ,'url' => 'save'
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
            'title'
            ,'shijian'
            ,'danwei_id'
        ], 'post');

        // 实例化验证模型
        $validate = new \app\keti\validate\Jieti;
        $result = $validate->scene('create')->check($list);
        $msg = $validate->getError();
        if(!$result){
            return json(['msg' => $msg, 'val' => 0]);;
        }

        // 保存数据
        $data = jt::create($list);
        $data ? $data = ['msg' => '添加成功', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];

        // 返回信息
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
        // 获取荣誉册信息
        $list['data'] = jt::where('id', $id)
                ->field('id, title, shijian, danwei_id')
                ->find();

        // 设置页面标题
        $list['set'] = array(
            'webtitle' => '编辑结题册'
            ,'butname' => '修改'
            ,'formpost' => 'PUT'
            ,'url' => '/keti/jieti/update/' . $id
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
            ,'category_id'
            ,'shijian'
            ,'danwei_id'
        ], 'put');
        $list['id'] = $id;

        // 实例化验证类
        $validate = new \app\keti\validate\Jieti;
        $result = $validate->scene('edit')->check($list);
        $msg = $validate->getError();
        if(!$result){
            return json(['msg' => $msg, 'val' => 0]);;
        }

        // 更新数据
        $data = jt::update($list);
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

        $data = jt::destroy($id);
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
        $data = jt::where('id', $id)->update(['status' => $value]);

        // 根据更新结果设置返回提示信息
        $data ? $data = ['msg' => '状态设置成功', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];

        // 返回信息
        return json($data);
    }


    // 结题页面
    public function jieTi($jieti_id, $info_id="")
    {
        // 获取结题册信息
        $list['data']['jieti'] = jt::where('id', $jieti_id)
                ->field('id, title, danwei_id')
                ->find();

        // 获取结题信息
        $list['data']['info'] = ktinfo::where('id', $info_id)
                ->field('id, bianhao, title, jddengji_id, jtshijian, jtpic, beizhu')
                ->find();

        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'编辑结题'
            ,'butname'=>'修改'
            ,'formpost'=>'PUT'
            ,'url'=>'/keti/jieti/addsave'
            ,'jieti_id' => $jieti_id
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
            ,'jieti_id'
            ,'jddengji_id'
            ,'jtshijian'
            ,'teacher_id'=>array()
            ,'canyu_id'=>array()
            ,'beizhu'
            ,'id'
        ], 'PUT');

        // 实例化验证类
        $validate = new \app\keti\validate\KetiInfo;
        $result = $validate->scene('addjieti')->check($list);
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
        $data->ktZcr->delete(true);
        // 声明教师数组
            $teacherlist = [];
            $canyulist = [];
            // 循环组成获奖教师信息
            $list['teacher_id'] = explode(',', $list['teacher_id']);
            foreach ($list['teacher_id'] as $key => $value) {
                $canyulist[] = [
                    'teacher_id' => $value
                    ,'category_id' => 11901
                ];
            }
            $list['canyu_id'] = explode(',', $list['canyu_id']);
            foreach ($list['canyu_id'] as $key => $value) {
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
}
