<?php
declare (strict_types = 1);

namespace app\tools\controller;

// 引用控制器基类
use app\BaseController;

class System extends BaseController
{
    // 是否启用别名
    public function sysClass()
    {
        // 实例化系统设置对象
        $sys = new \app\system\model\SystemBase;
        $alias = $sys->order(['id'=>'desc'])
            ->field('gradelist, classmax, classalias, xuenian, teacherrongyu, teacherketi')
            ->find();
        return $alias;
    }

}
