<?php
declare (strict_types = 1);

namespace app\composer\model;

use app\BaseModel;

/**
 * @mixin \think\Model
 */
class ComposerInfo extends BaseModel
{
    // 设置字段信息
    protected $schema = [
        'id' => 'int'
        ,'composer_id' => 'int'
        ,'xitong' => 'varchar'
        ,'xitong_time' => 'int'
        ,'teacher_id' => 'int'
        ,'weizhi' => 'varchar'
        ,'ip' => 'varchar'
        ,'biaoqian_time' => 'int'
        ,'info' => 'text'
        ,'infos' => 'text'
        ,'shangchuan_id' => 'int'
        ,'create_time' => 'int'
        ,'update_time' => 'int'
        ,'delete_time' => 'int'
    ];


    // 系统安装日期修改器
    public function setXitongTimeAttr($value)
    {
        $sj = strval($value);
        $value = strtotime(strval($sj));
        return $value;
    }


    // 系统安装日期获取器
    public function getXitongTimeAttr($value)
    {
        return date('Y-m-d', $value);
    }


    // 系统安装日期修改器
    public function setBiaoqianTimeAttr($value)
    {
        $sj = strtotime(strval($value));
        return $sj;
    }


    // 系统安装日期获取器
    public function getBiaoqianTimeAttr($value)
    {
        return date('Y-m-d', $value);
    }
}
