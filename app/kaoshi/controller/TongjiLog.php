<?php
declare (strict_types = 1);

namespace app\Kaoshi\controller;

// 引用控制器基类
use app\BaseController;

class TongjiLog extends BaseController
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index($kaoshi_id)
    {
        // 获取考试信息
        $ks = new \app\kaoshi\model\Kaoshi;
        $ksinfo = $ks->where('id',$kaoshi_id)
            ->field('id,title')
            ->find();

        // 设置要给模板赋值的信息
        $list['webtitle'] = '最新统计结果状态';
        $list['kaoshi'] = $kaoshi_id;
        $list['kaoshititle'] = $ksinfo->title;
        $list['dataurl'] = '/kaoshi/tjlog/data';


        // 模板赋值
        $this->view->assign('list',$list);

        // 渲染模板
        return $this->view->fetch();
    }

    public function ajaxData()
    {
        // 获取参数
        $src = $this->request
            ->only([
                'kaoshi'=>'',
            ],'POST');

        // 实例化考号
        $kh = new \app\kaoshi\model\Kaohao;
        $lastcj = $kh->lastUpdateTime($src['kaoshi']);
        $cjLastTime = $lastcj->getData('update_time');
        $src['cjlast'] = $cjLastTime;

        $log = new \app\kaoshi\model\TongjiLog;
        $data = $log->search($src);
        $cnt = count($data);

        // 重组返回内容
        $data = [
            'code'=> 0 , // ajax请求次数，作为标识符
            'msg'=>"",  // 获取到的结果数(每页显示数量)
            'count'=>$cnt, // 符合条件的总数据量
            'data'=>$data, //获取到的数据结果
        ];
        return json($data);
    }
}
