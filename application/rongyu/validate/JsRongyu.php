<?php

namespace app\rongyu\validate;

use think\Validate;

class JsRongyu extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
        'title|荣誉册标题'     =>  'require|length:1,50',
        'category|荣誉类型'     =>  'require|number',
        'fzshijian|发证时间'     =>  'require|date',
        'fzschool|颁奖单位'     =>  'require|number',
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [];
}
