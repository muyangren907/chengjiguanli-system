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
        $khSrc = new \app\kaohao\model\SearchCanYu;
        $myself = config('shangma.lurufanwei');
        $category = session('onlineCategory');
        if($category == 'teacher' && $myself == true)
        {
            $teacher_id = session('user_id');
            $s = \think\facade\Session::all();

            $btj = new \app\chengji\model\TongjiBj;
            $src['banji_id'] = $btj->where('teacher_id', $teacher_id)
                        ->where('kaoshi_id', $src['kaoshi_id'])
                        ->column('banji_id');
            $bzr = new \app\teach\model\BanZhuRen;
            $src['teacher_id'] = $teacher_id;
            $bjInfo = $bzr->srcTeacher($src);
            foreach ($bjInfo as $key => $value) {
                if($value->glBanji->biye === false)
                {
                    array_push($src['banji_id'], $value->glBanji->id);
                }
            }
        }
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
                ,'ruxuenian' => ''
                ,'field' => 'paixu'
                ,'order' => 'asc'
                ,'page' => 1
                ,'limit' => 100
            ], 'POST');

        $ksset = new \app\kaoshi\model\KaoshiSet;
        $sbj = $ksset->srcSubject($src);

        $sbj = reSetArray($sbj, $src);
        return json($sbj);
    }
}
