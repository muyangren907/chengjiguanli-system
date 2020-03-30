<?php
declare (strict_types = 1);

namespace app\renshi\controller;

// 引用控制器基类
use app\BaseController;
// 引用学生数据模型类
use \app\renshi\model\Student as STU;
// 引用学生数据模型类
use \app\renshi\model\StudentChengji as STUCJ;


class StudentChengji extends BaseController
{
    // 学生信息页
    public function index($id)
    {
        // 查询学生信息
        $myInfo = STU::withTrashed()
            ->where('id', $id)
            ->with([
                'stuBanji'=>function($query){
                    $query->field('id, school_id, ruxuenian, paixu')
                        ->with([
                            'glSchool' => function($q){
                                $q->field('id,title,jiancheng');
                            }
                        ])
                        ->append(['banjiTitle']);
                }
            ])
            ->find();

        // 获取参加考试学科
        $sbj = new \app\teach\model\Subject;
        $ksSbj = $sbj->searchKaoshi()->toArray();

        $myInfo['sbj'] = $ksSbj;
        // 设置页面标题
        $myInfo['webtitle'] = $myInfo->xingming . ' － 成绩';
        $myInfo['dataurl'] = '/renshi/studentcj/data';
        $myInfo['student'] = $id;

        // 模板赋值
        $this->view->assign('list', $myInfo);
        // 渲染模板
        return $this->view->fetch();
    }


    // 获取单个考试成绩列表
    public function ajaxData()
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
        $khList = $stucj->oneStudentChengjiList($src);
        halt($khList);
        $data = reSetArray($data, $src);

        return json($data);
    }


    // 获取单个考试成绩图表
    public function ajaxOneStudentChengjiTuBiao()
    {
        // 获取表单参数
        // 获取参数
        $src = $this->request
            ->only([
                'field' => 'kaoshiId'
                ,'order' => 'asc'
                ,'student_id' => ''
                ,'subject_id' => ''
                ,'category_id' => ''
                ,'xueqi_id' => ''
                ,'bfdate' => ''
                ,'enddate' => ''
            ], 'POST');

        // 获取学生成绩
        $stucj = new STUCJ;
        $data = $stucj->oneStudentSubjectChengji($src);

        return json($data);
    }


    // 获取单个考试成绩图表
    public function ajaxOneStudentChengjiLeiDa()
    {
        // 获取表单参数
        // 获取参数
        $src = $this->request
            ->only([
                'kaohao_id' => '',
            ], 'POST');

        // 获取学生成绩
        $stucj = new STUCJ;
        $data = $stucj->oneStudentLeiDa($src);

        return json($data);
    }
}
