<?php

namespace app\teach\validate;

use think\Validate;

class Xueqi extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
        'title|标题'     =>  'required|length:2,25',
        'xuenian|学年'     =>  'required|length:1,15',
        'category|分类'     =>  'required|number',
        'bfdate|时间'     =>  'required|date',
        'enddate|时间'     =>  'required|date',
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [];
}
