<?php

namespace app\chengji\controller;

// 引用控制器基类
use app\BaseController;
// 引用成绩统计数据模型
use app\chengji\model\Tongji as TJ;

class Tongji extends BaseController
{
    // 统计已经录入成绩数量
    public function yiluCnt($kaoshi_id)
    {
        // 获取考试信息
        $ks = new \app\kaoshi\model\Kaoshi;
        $ksinfo = $ks->where('id', $kaoshi_id)
            ->field('id, title')
            ->find();

        // 获取参加考试的年级和学科
        $ksset = new \app\kaoshi\model\KaoshiSet;
        $list['nianji'] = $ksset->srcNianji($kaoshi_id);
        $list['subject_id'] = $ksset->srcSubject($kaoshi_id);

        // 获取参与学校
        if(count($list['nianji']) > 0)
        {
            $khSrc = new \app\kaohao\model\KaohaoSearch;
            $src['ruxuenian'] = [$list['nianji'][0]['nianji']];
            $src['kaoshi_id'] = $kaoshi_id;
            $list['school_id'] = $khSrc->cySchool($src);
        }

        // 设置要给模板赋值的信息
        $list['webtitle'] = '各年级的班级成绩列表';
        $list['kaoshi_id'] = $kaoshi_id;
        $list['kaoshititle'] = $ksinfo->title;
        $list['dataurl'] = '/chengji/tongji/data';
        // 模板赋值
        $this->view->assign('list', $list);

        // 渲染模板
        return $this->view->fetch();
    }


    // 获取年级成绩统计结果
    public function ajaxData()
    {
        // 获取参数
        $src = $this->request
            ->only([
                'page' => '1'
                ,'limit' => '10'
                ,'kaoshi_id' => ''
                ,'ruxuenian' => ''
                ,'school_id' => array()
                ,'banji_id' => array()
                ,'field' => 'banji_id'
                ,'order' => 'asc'
            ], 'POST');

        // 统计成绩
        $btj = new \app\chengji\model\TongjiBj;
        $data = $btj->tjBanjiCnt($src);
        $data = reSetArray($data, $src);

        return json($data);
    }


    public function newJieguo($kaoshi_id)
    {
        // 获取考试信息
        $ks = new \app\kaoshi\model\Kaoshi;
        $ksinfo = $ks->where('id', $kaoshi_id)
            ->field('id, title')
            ->find();

        // 设置要给模板赋值的信息
        $list['webtitle'] = '最新统计结果状态';
        $list['kaoshi'] = $kaoshi_id;
        $list['kaoshititle'] = $ksinfo->title;
        $list['dataurl'] = '/chengji/tongji/jgdata';

        // 模板赋值
        $this->view->assign('list', $list);

        // 渲染模板
        return $this->view->fetch();
    }


    public function ajaxNewJieguo()
    {
        // 获取参数
        $src = $this->request
            ->only([
                'kaoshi' => '',
            ],'POST');

        // 实例化考号
        $kh = new \app\kaoshi\model\Kaohao;
        $lastcj = $kh->lastUpdateTime($src['kaoshi']);
        $logLastTime = $lastcj->getData('update_time');

        $log = new \app\kaoshi\model\TongjiLog;


        halt($logLastTime);


    }


}
