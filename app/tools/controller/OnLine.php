<?php
declare (strict_types = 1);

namespace app\tools\controller;

class OnLine
{
    use \liliuwei\think\Jump;
    // 将关联学生成绩转换成以学科列名为key得分为value的数组
    public function jump($url = '', $msg = '')
    {
        $isajax = request()->isAjax();
        if($isajax)
        {
            $this->error($msg, '/login/err');
        }else{
            echo "<script language='javascript' type='text/javascript'>top.location.href='".$url."'</script>";
        }
        return true;
    }


    // 获取用户信息
    public function myInfo()
    {
        $id = session('user_id');
        $ad = new \app\admin\model\Admin;
        $adInfo = $ad->where('id', $id)
            ->field('zhiwu_id, school_id')
            ->with([
                'adSchool' => function($query){
                    $query->field('id, jiancheng, jibie_id');
                },
            ])
            ->find();

        return $adInfo;
    }
}
