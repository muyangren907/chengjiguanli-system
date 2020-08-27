<?php
declare (strict_types = 1);

namespace app\tools\controller;

// 引用控制器基类
use app\BaseController;

class TeacherInfo extends BaseController
{

    // 查询教师荣誉
    public function srcRy()
    {
        // 获取参数
        $src = $this->request
            ->only([
                'page' => '1'
                ,'limit' => '10'
                ,'field' => 'update_time'
                ,'order' => 'desc'
                ,'teacher_id' => ''
            ], 'POST');

        // 查询数据
        $rongyu = new \app\rongyu\model\JsRongyuInfo;
        $data = $rongyu->srcTeacherRongyu($src['teacher_id'])
            ->visible([
                'id'
                ,'title'
                ,'ryTuce' => [
                    'title'
                    ,'fzSchool'
                ]
                ,'jiangxiang_id'
                ,'hjshijian'
                ,'update_time'
            ]);
        $data = reSetObject($data, $src);
        return json($data);
    }


    // 查询教师课题
    public function srcKt()
    {
        // 获取参数
        $src = $this->request
            ->only([
                'page' => '1'
                ,'limit' => '10'
                ,'field' => 'update_time'
                ,'order' => 'desc'
                ,'teacher_id' => ''
            ], 'POST');

        // 查询数据
        $keti = new \app\keti\model\KetiInfo;
        $data = $keti->srcTeacherKeti($src['teacher_id']);
        $data = reSetObject($data, $src);

        return json($data);
    }


}
