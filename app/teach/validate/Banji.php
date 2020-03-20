<?php

namespace app\teach\validate;

use think\Validate;

class Banji extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */
	protected $rule = [
        'school_id|学校'     =>      'require|number',
        'ruxuenian|年级'  =>      'require|number',
        'bjsum|班级数'    =>      'require|number'
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */
    protected $message = [];
}
