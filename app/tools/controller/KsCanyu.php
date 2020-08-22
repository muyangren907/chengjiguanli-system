<?php
declare (strict_types = 1);

namespace app\tools\controller;

// 引用控制器基类
use app\BaseController;

class KsCanYu extends BaseController
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
        $school = reSetArray($school, $src);

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
        $nianji = reSetArray($nianji, $src);

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

        $khSrc = new \app\kaohao\model\SearchCanyu;
        $bj = $khSrc->class($src);
        $bj = reSetArray($bj, $src);

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
        $bj = reSetObject($bj, $src);

        return json($bj);
    }


    // 根据考试ID和年级获取参加考试学科
    public function subject()
    {
        // 获取参数
        $src = $this->request
            ->only([
                'kaoshi_id' => ''
                ,'nianji' => ''
                ,'field' => 'paixu'
                ,'order' => 'desc'
                ,'page' => 1
                ,'limit' => 100
            ], 'POST');

        $ksset = new \app\kaoshi\model\KaoshiSet;
        $sbj = $ksset->srcSubject($src);

        $sbj = reSetArray($sbj, $src);
        return json($sbj);
    }
}
