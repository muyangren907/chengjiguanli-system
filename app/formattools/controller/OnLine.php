<?php
declare (strict_types = 1);

namespace app\formattools\controller;

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
}
