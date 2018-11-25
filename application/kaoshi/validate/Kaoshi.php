<?php

namespace app\teach\validate;

use think\Validate;

class Kaoshi extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
        'title|标题'      =>  'require|length:1,25',
        'zuzhi|组织单位'      =>  'require|number',
        'xueqi|学期'      =>  'require|number',
        'category|分类'      =>  'require|number',
        'bfdate|考试时间'      =>  'require|date',
        'enddate|考试时间'      =>  'require|date',
        'nianji|参考年级'      =>  'require|array',
        'subject|参考学科'      =>  'require|array',
        'manfen|满分'      =>  'require|array',
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [];
}
