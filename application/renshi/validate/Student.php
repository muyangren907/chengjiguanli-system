<?php

namespace app\renshi\validate;

use think\Validate;

class Student extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
        'xingming|姓名'     =>  'require|chs|length:2,8',
        'sex|性别'            =>      'require|chs|max:2',
        'shengri|出生日期'        =>      'date',
        'shenfenzhenghao|身份证号' =>      "require|idCard",
        'school|学校'        =>      'require|number',
        'ruxuenian|年级'         =>      'require|number',
        'banji|班级'     =>      'require|number'
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [];
}
