<?php

namespace app\chengji\validate;

use think\Validate;

class Cjdownload extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
        'banji|班级'      =>  'require|array',
        'kaoshi|考试'      =>  'require|number'
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [];
}
