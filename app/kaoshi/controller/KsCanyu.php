<?php

namespace app\kaoshi\controller;

// 引用控制器基类
use app\base\controller\AdminBase;


class KsCanYu extends AdminBase
{
    // 根据考试ID和年级获取参加考试学校
    public function school()
    {
        // 获取参数
        $src = $this->request
            ->only([
                'ruxuenian' => ''
                ,'kaoshi_id' => ''
                ,'limit' => 100
            ], 'POST');

        $cy = new \app\kaohao\model\SearchCanYu;
        $school = $cy->school($src);
        $src['all'] = true;
        $cnt = $cy->school($src)->count();
        $data = reset_data($data, $cnt);

        return json($school);
    }


    // 根据考试ID和年级获取参加考试年级
    public function grade()
    {
        // 获取参数
        $src = $this->request
            ->only([
                'kaoshi_id' => ''
                ,'limit' => 100
            ], 'POST');
        $ksset = new \app\kaoshi\model\KaoshiSet;
        $nianji = $ksset->srcGrade($src['kaoshi_id']);
        $src['all'] = true;
        $cnt = $cy->srcGrade($src)->count();
        $data = reset_data($data, $cnt);

        return json($nianji);
    }


    // 根据考试ID和年级获取参加考试班级
    public function class()
    {
        // 获取参数
        $src = $this->request
            ->only([
                'school_id' => ''
                ,'ruxuenian' => ''
                ,'kaoshi_id' => ''
                ,'limit' => 100
            ], 'POST');
        $khSrc = new \app\kaohao\model\SearchCanYu;

        $bj = $khSrc->class($src);
        $src['all'] = true;
        $cnt = $cy->class($src)->count();
        $data = reset_data($data, $cnt);

        return json($bj);
    }


    // 根据考试ID和年级获取参加考试班级
    public function tjClass()
    {
        // 获取参数
        $src = $this->request
            ->only([
                'school_id' => ''
                ,'ruxuenian' => ''
                ,'kaoshi_id' => ''
                ,'subject_id' => ''
                ,'limit' => 100
            ], 'POST');

        $khSrc = new \app\chengji\model\TongjiBj;
        $bj = $khSrc->searchSubjedt($src);
        $src['all'] = true;
        $cnt = $khSrc->searchSubjedt($src)->count();
        $data = reset_data($data, $cnt);

        return json($bj);
    }


    // 根据考试ID和年级获取已经参加本次考试学科
    public function subject()
    {
        // 获取参数
        $src = $this->request
            ->only([
                'kaoshi_id' => ''
                ,'ruxuenian' => ''
                ,'subject_id' => ''
                ,'field' => 'paixu'
                ,'order' => 'asc'
                ,'page' => 1
                ,'limit' => 100
            ], 'POST');

        $ksset = new \app\kaoshi\model\KaoshiSet;
        $sbj = $ksset->srcSubject($src);
        $src['all'] = true;
        $cnt = $ksset->srcSubject($src)->count();
        $data = reset_data($data, $cnt);

        return json($sbj);
    }
}
