<?php

namespace app\kaoshi\validate;

use think\Validate;

class Biaoqian extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
        'banjiids|班级'      =>  'require|array',
        'kaoshi|考试'      =>  'require|number',
        'subject|学科'      =>  'require|array',
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [];
}
