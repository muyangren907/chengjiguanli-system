<?php

namespace app\chengji\controller;

// 引用控制器基类
use app\base\controller\AdminBase;
// 引用成绩统计数据模型
use app\chengji\model\Tongji as TJ;

class Tongji extends AdminBase
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
        $list['nianji'] = $ksset->srcGrade($kaoshi_id);
        $src = [
            'kaoshi_id' => $kaoshi_id
        ];
        $list['subject_id'] = $ksset->srcSubject($src);

        // 获取参与学校
        if(count($list['nianji']) > 0)
        {
            $khSrc = new \app\kaohao\model\SearchCanYu;
            $src['ruxuenian'] = [$list['nianji'][0]['ruxuenian']];
            $src['kaoshi_id'] = $kaoshi_id;
            $list['school_id'] = $khSrc->school($src);
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


    // 按学科重新计算得分率
    public function editDefenlv($kaoshi_id) {

        // 设置页面标题
        $list['set'] = array(
            'webtitle'=>'编辑课题',
            'butname'=>'修改',
            'formpost'=>'PUT',
            'url'=>'/chengji/tongji/editdfl',
            'kaoshi_id'=>$kaoshi_id
        );

        // 模板赋值
        $this->view->assign('list', $list);
        // 渲染
        return $this->view->fetch();
    }


    // 更新得分率
    public function updateDefenLv() {
        // 获取参数
        $src = $this->request
            ->only([
                'kaoshi_id' => 0
                ,'subject_id' => 0
                ,'ruxuenian' => 0
            ], 'PUT');

        // 获取满分
        $ksSet = new \app\kaoshi\model\KaoshiSet;
        $manfen = $ksSet->where('kaoshi_id', $src['kaoshi_id'])
                    ->where('subject_id', $src['subject_id'])
                    ->where('ruxuenian', $src['ruxuenian'])
                    ->field('id,title')
                    ->value('manfen');
        // 获取考号
        $kaohao = new \app\kaohao\model\Kaohao;
        $kaohaoid = $kaohao->where('kaoshi_id', $src['kaoshi_id'])
                        ->where('ruxuenian', $src['ruxuenian'])
                        ->column('id');
        // 查询成绩
        $cj = new \app\chengji\model\Chengji;
        $cjList = $cj->where('kaohao_id', 'in', $kaohaoid)
                    ->where('subject_id', $src['subject_id'])
                    ->whereNotNull('defen')
                    ->field('id, defen, defenlv')
                    ->select();

        $data = array();
        foreach ($cjList as $key => $value) {
           $data[] = [
                'id' => $value->id
                ,'defenlv' => $value->defen / $manfen *100
           ];
        }

        $data = $cj->saveAll($data);

        $data ? $data = ['msg' => '重新计算完成', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];

        // 返回信息
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
                'kaoshi_id' => '',
            ],'POST');

        // 实例化考号
        $khSrc = new \app\kaohao\model\Search;
        $lastcj = $khSrc->lastUpdateTime($src['kaoshi_id']);
        $logLastTime = $lastcj->getData('update_time');

        $log = new \app\kaoshi\model\TongjiLog;


        halt($logLastTime);


    }


}
