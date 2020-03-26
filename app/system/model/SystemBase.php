<?php

namespace app\system\model;

use app\BaseModel;

class SystemBase extends BaseModel
{
    // 查询系统信息
    static function sysInfo()
    {
        $info = self::order(['id' => 'desc'])
            ->field('id, keywords, description')
            ->find();
        return $info;
    }
}
