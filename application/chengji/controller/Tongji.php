<?php

namespace app\chengji\controller;

// 引用控制器基类
use app\common\controller\Base;

class Tongji extends Base
{
    // 年级成绩汇总
    public function tjnianji($id)
    {

        // 设置页面标题
        $list['title'] = '年级成绩统计';
        $list['kaoshi'] = $id;

        // 模板赋值
        $this->assign('list', $list);

        // 渲染模板
        return $this->fetch();
    }


    // 获取年级成绩统计结果
    public function ajaxNianji()
    {
        // 获取年级和班级列表名
        $njnames = nianjiList();

        // 获取表单参数
        $getParam = request()->param();
        $school = $getParam['school'];

        // 实例化成绩数据模型
        $cj = new \app\chengji\model\Chengji;

        // 根据考试号和年级获取考试成绩
        $cjlist = $cj->searchNianji($getParam['kaoshiid'],$school,$getParam['ruxuenian']);

        // 根据年级获取一个有多少个班级
        $bj = new \app\teach\model\Banji;
        $bjids = $bj->where('ruxuenian',$getParam['ruxuenian'])
                ->when(!empty($school),function($query) use($school){
                    $query->where('school','in',$school);
                })
                ->append(['title'])
                ->select(); 
        $cnt = $bjids->count() + 1;       


        // 实例化成绩统计模型
        $tj = new \app\chengji\model\Tongji();
        // 获取统计成绩参数
        $canshu = $tj->getCanshu($getParam['kaoshiid']);

        

        // 循环获取各班级成绩
        $i = 0;
        foreach ($bjids as $key => $value) {
            $data[$i]['id'] = $i+1;
            $data[$i]['title'] = $value['title'];
            $bjlist = $cjlist->where('banji',$value['id']);
            $data[$i]['data'] = $tj->tongji($bjlist,$canshu);
            
            $i++;
        }

        $data[$i]['id'] = $i+1;
        $data[$i]['title'] = '合计';
        $data[$i]['data'] = $tj->tongji($cjlist,$canshu);
        // 重组返回内容
        $data = [
            'draw'=> $getParam["draw"] , // ajax请求次数，作为标识符
            'recordsTotal'=>$cnt,  // 获取到的结果数(每页显示数量)
            'recordsFiltered'=>$cnt,       // 符合条件的总数据量
            'data'=>$data, //获取到的数据结果
        ];

        return json($data);
    }


    // 年级、班级学生成绩统计结果下载界面
    public function downloadnj($id)
    {
        dump('aa');

    }


    // 年级、班级学生成绩统计下载表格
    public function downloadxls($id)
    {
        dump('aa');

    }



    // 获取各学校、各年级考试成绩
    public function tjschool($id)
    {
        // 设置页面标题
        $list['title'] = '学校成绩统计';
        $list['kaoshi'] = $id;

        // 模板赋值
        $this->assign('list', $list);

        // 渲染模板
        return $this->fetch();
    }


    // 获取年级成绩统计结果
    public function ajaxSchool()
    {
        // 获取年级和班级列表名
        // $njnames = nianjiList();

        // 获取表单参数
        $getParam = request()->param();
        $nianji = $getParam['nianji'];

        // 实例化成绩数据模型
        $cj = new \app\system\model\Chengji;

        // 根据考试号和年级获取考试成绩
        $cjlist = $cj->searchNianji($kaoshi=$getParam['kaoshiid'],$nianji=$getParam['ruxuenian']);

        // 获取学校列表

        $sch = new \app\teach\model\School;
        $schids = $sch->where('ruxuenian',$getParam['ruxuenian'])
                ->when(!empty($school),function($query) use($school){
                    $query->where('school','in',$school);
                })
                ->append(['title'])
                ->select(); 
        $cnt = $bjids->count() + 1;       


        // 实例化成绩统计模型
        $tj = new \app\chengji\model\Tongji();
        // 获取统计成绩参数
        $canshu = $tj->getCanshu($getParam['kaoshiid']);

        

        // 循环获取各班级成绩
        $i = 0;
        foreach ($bjids as $key => $value) {
            $data[$i]['id'] = $i+1;
            $data[$i]['title'] = $value['title'];
            $bjlist = $cjlist->where('banji',$value['id']);
            $data[$i]['data'] = $tj->tongji($bjlist,$canshu);
            
            $i++;
        }

        $data[$i]['id'] = $i+1;
        $data[$i]['title'] = '合计';
        $data[$i]['data'] = $tj->tongji($cjlist,$canshu);
        // 重组返回内容
        $data = [
            'draw'=> $getParam["draw"] , // ajax请求次数，作为标识符
            'recordsTotal'=>$cnt,  // 获取到的结果数(每页显示数量)
            'recordsFiltered'=>$cnt,       // 符合条件的总数据量
            'data'=>$data, //获取到的数据结果
        ];

        return json($data);
    }



    public function test()
    {
        $aa = schlist('区级','区级');
        dump($aa);
    }

}
