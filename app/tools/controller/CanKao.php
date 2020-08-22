<?php
declare (strict_types = 1);

namespace app\zhengli\controller;

use app\base\controller\ToolsBase;

class CanKao1 extends BaseController
{
    // 获取参考学科
    public function subjectIdLieming($srcfrom)
    {
        $ksset = new \app\kaoshi\model\KaoshiSet;
        $ksSubject = $ksset->srcSubject($srcfrom);
        if(count($ksSubject)==0)
        {
            return $data = array();
        }
        $xk = array();
        foreach ($ksSubject as $key => $value) {
            $xk[$value['id']] = $value['lieming'];
        }
        return $xk;
    }
}
