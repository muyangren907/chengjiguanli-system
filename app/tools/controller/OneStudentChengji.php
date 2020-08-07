<?php
declare (strict_types = 1);

namespace app\tools\controller;

// 引用控制器基类
use app\BaseController;
// 引用学生数据模型类
// use \app\student\model\Student as STU;
// 引用学生数据模型类
use \app\tools\model\OneStudentChengji as STUCJ;


class OneStudentChengji extends BaseController
{
    // 获取学生历次考试所有学科成绩
    public function ajaxOldChengji()
    {
        // 获取表单参数
        $src = $this->request
            ->only([
                'page' => '1'
                ,'limit' => '10'
                ,'field' => 'kaoshi_id'
                ,'order' => 'desc'
                ,'student_id' => ''
                ,'category_id' => ''
                ,'xueqi_id' => ''
                ,'bfdate' => ''
                ,'enddate' => ''
            ], 'POST');


        // 获取学生成绩
        $stucj = new STUCJ;
        $khList = $stucj->oldList($src);
        $data = reSetArray($khList, $src);

        return json($data);
    }


    // 学生个人成绩雷达图
    public function ajaxLeiDa()
    {
        // 获取表单参数
        $src = $this->request
            ->only([
                'kaohao_id' => '',
            ], 'POST');

        // 获取学生成绩
        $stucj = new STUCJ;
        $data = $stucj->leiDa($src);

        return json($data);
    }


    // 学生个人总分仪表图
    public function ajaxYiBiao()
    {
        // 获取表单参数
        $src = $this->request
            ->only([
                'kaohao_id' => '',
            ], 'POST');

        // 获取学生成绩
        $stucj = new STUCJ;
        $data = $stucj->yiBiao($src);

        return json($data);
    }


    // 学生单次各学科成绩列表
    public function ajaxSubjectChengji()
    {
        // 获取表单参数
        // 获取参数
        $src = $this->request
            ->only([
                'kaohao_id' => '',
            ], 'POST');

        // 获取学生成绩
        $stucj = new STUCJ;
        $data = $stucj->oneChengji($src);

        // 整理变量
        $src = [
            'field' => 'subject_id'
            ,'order' => 'asc'
            ,'page' => 1
            ,'limit' => 10
        ];


        $data = reSetArray($data, $src);

        return json($data);
    }


    // 学生个人成绩列表
    public function ajaxSubjectDeFenLv()
    {
        // 获取表单参数
        // 获取参数
        $src = $this->request
            ->only([
                'kaohao_id' => '',
            ], 'POST');

        // 获取学生成绩
        $stucj = new STUCJ;
        $list = $stucj->oneChengji($src);
        $category = array();
        $data = array();
        foreach ($list as $key => $value) {
            $category[] = $value['subject_name'];
            $data[] = $value['defenlv'];
        }
        $data = [
            'xAxis' => [
                'type' => 'category'
                ,'data' => $category
            ]
            ,'yAxis' => [
                'type' => 'value'
                ,'data' => ''
            ]
            ,'series' => [
                [
                    'data' => $data
                    ,'name' => '得分率%'
                    ,'type' => 'bar'
                    ,'label' => [
                        'show' => true
                        ,'position'=>'top' // 在上方显示
                        ,'textStyle' => [
                            'color' => 'black',
                            'fontSize' => 12
                        ]
                    ]
                ],
            ]
        ];

        return json($data);
    }


    // 学生个人成绩列表
    public function ajaxSubjectWeiZhi()
    {
        // 获取表单参数
        // 获取参数
        $src = $this->request
            ->only([
                'kaohao_id' => '',
            ], 'POST');

        // 获取学生成绩
        $stucj = new STUCJ;
        $list = $stucj->oneChengji($src);
        $category = array();
        $data = array();
        foreach ($list as $key => $value) {
            $category[] = $value['subject_name'];
            $data[] = round($value['qweizhi'], 0);
        }
        $data = [
            'xAxis' => [
                'type' => 'value'
                ,'data' => ''
            ]
            ,'yAxis' => [
                'type' => 'category'
                ,'data' => $category
            ]
            ,'series' => [
                [
                    'data' => $data
                    ,'name' => '超过%'
                    ,'type' => 'bar'
                    ,'label' => [
                        'show' => true
                        ,'position'=>'insideRight' // 在上方显示
                        ,'textStyle' => [
                            'color' => 'black',
                            'fontSize' => 12
                        ]
                    ]
                ],
            ]
        ];
        return json($data);
    }


    // 学生单个学生历次成绩（得分率）
    public function ajaxOldSubject()
    {
        // 获取表单参数
        $src = $this->request
            ->only([
                'student_id' => ''
                ,'kaoshi_id' => array()
                ,'subject_id' => ''
                ,'category_id' => ''
                ,'xueqi_id' => ''
                ,'bfdate' => ''
                ,'enddate' => ''
            ], 'POST');

        // 获取学生成绩
        $stucj = new STUCJ;
        $data = $stucj->oldList($src);

        return json($data);
    }
}
