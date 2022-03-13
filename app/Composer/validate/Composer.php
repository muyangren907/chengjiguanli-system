<?php
declare (strict_types = 1);

namespace app\composer\validate;

use think\Validate;

class Composer extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名' =>  ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'teacher_id' => 'require|number',
        'xinghao' =>  'require',
        'xuliehao' =>  'require',
        'mac' =>  'require',
        'weizhi'  => 'require|length:2,80',
        'ip' => 'require|ip',
        'biaoqian_time' => 'require|date',
        'shangchuan_id' => 'require|number',
        'info' => 'require',
        'infos' => 	'require',
        'xitong' =>	'require|length:2,80',
        'xitong_time' => 'require|date'
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名' =>  '错误信息'
     *
     * @var array
     */
    protected $message = [];
}
