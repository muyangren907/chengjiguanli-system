<?php
declare (strict_types = 1);

namespace app\Update\model;

use think\Model;

/**
 * @mixin think\Model
 */
class Banji extends Model
{
    // 设置当前模型的数据库连接
    protected $connection = 'new';
}
