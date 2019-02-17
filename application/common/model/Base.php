<?php

namespace app\common\model;

// 引用模型类
use think\Model;
// 引用软删除类
use think\model\concern\SoftDelete;

class Base extends Model
{

    // 开启全局自动时间戳
    protected $autoWriteTimestamp = true;

    // 开启软删除
    use SoftDelete;
    protected $deleteTime = 'delete_time';

    // 状态获取器
    public function getStatusAttr($value)
    {
        $status =array('1'=>'已启用','0'=>'已停用');
        return $status[$value];
    }
}