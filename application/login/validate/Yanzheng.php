<?php

namespace app\login\validate;

use think\Validate;

class Yanzheng extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
        'username'  =>  ['require',],
        'password'  =>  'number'
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
        'username.require'  =>  '帐号不能为空',
        'password.number'  =>  '密码必须为纯数字'
    ];
}
