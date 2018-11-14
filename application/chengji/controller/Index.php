<?php
namespace app\chengji\controller;

// 引用控制器基类
use app\common\controller\Base;
// 引用学生类
use app\renshi\model\Student;
// 引用成绩类
use app\chengji\model\Chengji;

class Index extends Base
{
    // 导出参加考试学生二维码
    public function erweima()
    {
    	return $this->fetch();
    }

    // 生成考号
    public function kaohao()
    {
    	return $this->fetch();
    }

    // 保存考号
    public function kaohaosave()
    {
        // 获取表单数据
        $list = request()->only(['kaoshi','banjiids'],'post');
        // 获取参加考试班级
        $list['banjiids'] = implode(',',$list['banjiids']);

        // 获取参加考试学生名单
        $stulist = Student::where('status',1)
                        ->where('banji','in',$list['banjiids'])
                        ->field('id,school,banji')
                        ->append(['nianji'])
                        ->select();

        // 组合参加考试学生信息
        $stus = array();
        foreach ($stulist as $key => $value) {
            $stus[] = [
                'kaoshi' => $list['kaoshi'],
                'school' => $value->school,
                'ruxuenian' => $value->nianji,
                'banji' => $value->banji,
                'student' => $value->id
            ];
        }

        // 声明成绩数据模型类
        $cj = new Chengji();
        $data = $cj->saveAll($stus);


        // 根据更新结果设置返回提示信息
        $data ? $data=['msg'=>'添加成功','val'=>1] : $data=['msg'=>'数据处理错误','val'=>0];

        // 返回信息
        return json($data);
    }
}
