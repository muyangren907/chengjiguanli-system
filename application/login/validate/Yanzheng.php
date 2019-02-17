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
        'username'  =>  'require',
        'password'  =>  'require',
        'captcha'  =>  'require'
    ];

    protected $message = [
      'username.require' => '用户名必须填写',
      'password.require'  => '密码必须填写',
      'password.number'   => '密码必须是数字',
      'captcha.require' => '验证码必须填写',
    ];
}