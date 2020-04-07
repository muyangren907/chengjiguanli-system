<?php

namespace app\kaohao\validate;

use think\Validate;

class Kaohao extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */
	protected $rule = [
        'kaoshi_id|考试号'      =>  'require|number',
        'banji_id|参考班级'      =>  'require|array',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */
    protected $message = [];

    protected $scene = [
        'create'  =>  [
            'kaoshi_id'
            ,'banji_id'
        ]
    ];
}
