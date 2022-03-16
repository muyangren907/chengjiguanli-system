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


    // 系统安装日期获取器
    public function getXitongTimeAttr($value)
    {
        return date('Y-m-d', $value);
    }


    // 系统安装日期修改器
    public function setBiaoqianTimeAttr($value)
    {
        $value = $value . ' ' . '00:00:00';
        $value = strtotime($value);
        return $value;
    }
    

    // 教师关联
    public function glTeacher()
    {
        return $this->belongsTo(\app\admin\model\Admin::class, 'teacher_id', 'id');
    }

    // 
}
