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


    // 学年节点获取器
    public function getXuenianAttr($value)
    {
        $value = date('n月j日', $value);
        return $value;
    }


    // 学年节点修改器
    public function setXuenianAttr ($value)
    {
        $value = strtotime($value);
        $value = date('Y', time()).'-'.date('m-d', $value);
        $value = strtotime($value);
        return $value;
    }
}
