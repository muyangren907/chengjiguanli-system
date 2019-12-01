<?php

namespace app\keti\validate;

use think\Validate;

class Keti extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
        'title|课题册标题'     =>  'require|length:1,30',
        'category|课题类型'     =>  'require|number',
        'lxshijian|立项时间'     =>  'require|date',
        'lxdanweiid|立项单位'     =>  'require|number',
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [];
}
