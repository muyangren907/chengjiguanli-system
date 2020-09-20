<?php
declare (strict_types = 1);

namespace app\teach\controller;

// 引用控制器基类
use app\base\controller\AdminBase;
// 引用班主任数据模型
use app\teach\model\BanZhuRen as bzr;

class BanZhuRen extends AdminBase
{

    // 主任列表
    public function index($banji_id)
    {
        // 设置要给模板赋值的信息
        $list['webtitle'] = '班主任列表';
        $list['dataurl'] = '/teach/banzhuren/data';
        $list['status'] = '/teach/banzhuren/status';
        $list['banji_id'] = $banji_id;

        $bj = new \app\teach\model\Banji;
        $bjInfo = $bj->where('id', $banji_id)
                ->append(['banjiTitle'])
                ->find();
        $list['bjTitle'] = $bjInfo->banjiTitle;

        // 模板赋值
        $this->view->assign('list', $list);

        // 渲染模板
        return $this->view->fetch();
    }


    // 获取班主任列表
    public function ajaxData()
    {
        // 获取参数
        $src = $this->request
            ->only([
                'page' => '1'
                ,'limit' => '10'
                ,'field' => 'bfdate'
                ,'order' => 'desc'
                ,'banji_id' => ''
            ], 'POST');

        // 查询数据
        $bzr = new bzr;
        $data = $bzr->search($src)
            ->visible([
                'id'
                ,'glTeacher' => ['xingming']
                ,'banji_id'
                ,'teacher_id'
                ,'bfdate'
                ,'update_time'
            ]);  # 查询数据
        $data = reSetObject($data, $src);

        // 返回数据
        return json($data);
    }



    public function create($banji_id)
    {
        // 设置页面标题
        $list['set'] = array(
            'webtitle' => '添加班主任'
            ,'butname' => '添加'
            ,'formpost' => 'POST'
            ,'url' => 'save'
            ,'banji_id' => $banji_id
        );

        // 模板赋值
        $this->view->assign('list', $list);
        // 渲染
        return $this->view->fetch('chengji@create');
    }


    /**
     * 保存班级
     *
     * @return \think\Response
     */
    public function save()
    {
        // 获取表单数据
        $list = request()->only([
            'school_id'
            ,'ruxuenian'
            ,'bjsum'
        ], 'post');

        // 验证表单数据
        $validate = new \app\teach\validate\Banji;
        $result = $validate->scene('create')->check($list);
        $msg = $validate->getError();
        if(!$result)
        {
            return json(['msg' => $msg, 'val' => 0]);
        }

        // 整理要添加的数据
        $paixumax = bjmod::where('school_id', $list['school_id'])
            ->where('ruxuenian', $list['ruxuenian'])
            ->max('paixu');

        // 获取班级最大数
        $cnfMax = \app\facade\System::sysClass();

        if($paixumax + $list['bjsum'] > $cnfMax->classmax) # 如果增加班级数超过2个，则少加班级
        {
            if($paixumax >= $cnfMax)
            {
                return json(['msg' => '已经超过同年级班级数的上线啦。', 'val' => 0]);
            }
            if($paixumax + $list['bjsum'] > $cnfMax) # 如果增加班级数超过2个，则少加班级
            {
                $list['bjsum'] = $cnfMax - $paixumax;
            }
        }

        $i = 1;
        while($i <= $list['bjsum'])
        {
            $bjarr[] = array(
                'school_id' => $list['school_id'],
                'ruxuenian' => $list['ruxuenian'],
                'paixu' => $paixumax + $i,
            );
            $i ++;
        }

        // 保存数据
        $bj = new bjmod();
        $data = $bj->saveAll($bjarr);

        // 根据更新结果设置返回提示信息
        $data ? $data = ['msg' => '添加成功', 'val'=>1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];

        // 返回信息
        return json($data);
    }


    /**
     * 删除班级
     *
     * @return \think\Response
     */
    public function delete($id)
    {

        $id = request()->delete('id');
        $id = explode(',', $id);

        $data = bjmod::destroy($id);

        // 根据更新结果设置返回提示信息
        $data ? $data = ['msg' => '删除成功', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];

        // 返回信息
        return json($data);
    }


}
