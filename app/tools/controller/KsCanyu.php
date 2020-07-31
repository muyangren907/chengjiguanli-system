<?php
declare (strict_types = 1);

namespace app\tools\controller;

// 引用控制器基类
use app\BaseController;

class KsCanyu extends BaseController
{
        // 根据考试ID和年级获取参加考试学校
    public function school()
    {
        // 获取变量
        $src['kaoshi_id'] = input('post.kaoshi_id');
        $src['ruxuenian'] = input('post.ruxuenian');

        $khSrc = new \app\kaohao\model\Search;
        $school = $khSrc->cySchool($src);
        $cnt = count($school);

        // 重组返回内容
        $data = [
            'count'=>$cnt  // 符合条件的总数据量
            ,'data'=>$school  //获取到的数据结果
        ];

        return json($data);
    }


    // 根据考试ID和年级获取参加考试年级
    public function grade()
    {
        // 获取变量
        $kaoshi_id = input('post.kaoshi_id');
        $ksset = new \app\kaoshi\model\KaoshiSet;
        $nianji = $ksset->srcNianji($kaoshi_id);
        $cnt = count($nianji);

        // 重组返回内容
        $data = [
            'count'=>$cnt, // 符合条件的总数据量
            'data'=>$nianji, //获取到的数据结果
        ];

        return json($data);
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
                ,'field' => 'paixu'
                ,'order' => 'desc'
                ,'page' => 1
                ,'limit' => 100
            ], 'POST');

        $khSrc = new \app\kaohao\model\SearchMore;
        $bj = $khSrc->cyBanji($src);
        $cnt = count($bj);

        // 重组返回内容
        $data = [
            'count'=>$cnt, // 符合条件的总数据量
            'data'=>$bj, //获取到的数据结果
        ];

        return json($data);
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
