<?php

namespace app\admin\validate;

use think\Validate;

class Admin extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
        'xingming'  =>  'require|chs|length:2,6',
        'username'  =>  ['require','ustr'=>'/^[\u4e00-\u9fa5]*$/']
        'shengri'   =>  'date',
        'xingbie'   =>  'in:0,1,2',
        'phone'     =>  'mobile',
        'beizhu'    =>  'max:80',
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
        'username.ustr' => '帐号格式错误',
    ];
}
