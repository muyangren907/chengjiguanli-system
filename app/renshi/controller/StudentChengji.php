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
            ->where('id',$id)
            ->with([
                'stuBanji'=>function($query)
                {
                    $query->field('id,school,ruxuenian,paixu')->append(['banjiTitle']);
                },
                'stuSchool'=>function($query)
                {
                    $query->field('id,title');
                }
            ])
            ->find();


        // 获取参加考试学科
        $sbj = new \app\teach\model\Subject;
        $ksSbj = $sbj->searchKaoshi()->toArray();

        $myInfo['sbj'] = $ksSbj;
        // 设置页面标题
        $myInfo['webtitle'] = $myInfo->xingming.'－成绩';
        $myInfo['dataurl'] = '/renshi/studentcj/data';
        $myInfo['student'] = $id;


        // 模板赋值
        $this->view->assign('list',$myInfo);
        // 渲染模板
        return $this->view->fetch();
    }


    // 获取单个考试成绩列表
    public function ajaxData()
    {
        // 获取表单参数
        // 获取参数
        $src = $this->request
                ->only([
                    'page'=>'1',
                    'limit'=>'10',
                    'field'=>'kaoshiId',
                    'order'=>'desc',
                    'student'=>'',
                    'category'=>'',
                    'xueqi'=>'',
                    'bfdate'=>'',
                    'enddate'=>'',
                ],'POST');

        // 获取学生成绩
        $stucj = new STUCJ;
        $khList = $stucj->oneStudentChengjiList($src);

        // 获取符合条件记录总数
        $cnt = count($khList);
        // 获取当前页数据
        $limit_start = $src['page'] * $src['limit'] - $src['limit'];
        $limit_length = $src['limit'];
        // $khList = $khList->slice($limit_start,$limit_length);

        // 按条件排序
        $src['order'] == 'desc' ? $src['order'] =SORT_DESC :$src['order'] = SORT_ASC;
        if($cnt>0){
            $khList = sortArrByManyField($khList,$src['field'],$src['order']);
        }


        // 重组返回内容
        $data = [
            'code'=> 0 , // ajax请求次数，作为标识符
            'msg'=>"",  // 获取到的结果数(每页显示数量)
            'count'=>$cnt, // 符合条件的总数据量
            'data'=>$khList, //获取到的数据结果
        ];


        return json($data);
    }


    // 获取单个考试成绩图表
    public function ajaxOneStudentChengjiTuBiao()
    {
        // 获取表单参数
        // 获取参数
        $src = $this->request
                ->only([
                    'field'=>'kaoshiId',
                    'order'=>'asc',
                    'student'=>'',
                    'subject'=>'',
                    'category'=>'',
                    'xueqi'=>'',
                    'bfdate'=>'',
                    'enddate'=>'',
                ],'POST');

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
                    'kaohaoid'=>'',
                ],'POST');

        // 获取学生成绩
        $stucj = new STUCJ;
        $data = $stucj->oneStudentLeiDa($src);

        return json($data);
    }


}