<?php
declare (strict_types = 1);

namespace app\update\model;

use think\Model;

/**
 * @mixin think\Model
 */
class Subject extends Model
{
    // 设置当前模型的数据库连接
    protected $connection = 'new';
}