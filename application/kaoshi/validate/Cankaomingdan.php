<?php

namespace app\teach\validate;

use think\Validate;

class Cankaomingdan extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
        'id|考试号'      =>  'require|number',
        'banjiids|参考班级'      =>  'require|array',
        'subject|参考学科'      =>  'require|array',
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [];
}
