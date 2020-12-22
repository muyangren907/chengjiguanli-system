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
        'xingming|用户姓名'  =>  'require|chs|length:2,6',
        'username|帐号'  =>  ['require', 'uset'=>'/^[a-z][a-z0-9-_]*$/'],
        'teacher_id|用户编号'  =>  'require|number|length:1,11',
        'group_id|角色'   =>  'require|array',
        'shengri|出生日期'   =>  'date',
        'xingbie|性别'   =>  'in:0,1,2',
        'phone|手机'     =>  'mobile',
        'beizhu|备注'    =>  'max:80',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */
    protected $message = [];
}
