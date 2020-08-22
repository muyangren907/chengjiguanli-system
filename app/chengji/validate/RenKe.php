<?php
declare (strict_types = 1);

namespace app\chengji\validate;

use think\Validate;

class RenKe extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */
	protected $rule = [
        'id|ID'      =>  'require|array',
        'teacher_id|教师'      =>  'require',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */
    protected $message = [];

    protected $scene = [
        'edit'  =>  [
            'id'
            ,'teacher_id'
        ]
    ];
}
