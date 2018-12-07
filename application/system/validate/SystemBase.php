<?php

namespace app\system\validate;

use think\Validate;

class SystemBase extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
        'title|标题'      =>  'require|length:2,50',
        'keywords|关键字'      =>  'require|length:2,60',
        'description|描述'      =>  'require|length:1,100',
        'thinks|感谢'      =>  'require|length:1,80',
        'danwei|单位'      =>  'require|length:2,80',
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [];
}
