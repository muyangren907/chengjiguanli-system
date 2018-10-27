<?php

namespace app\system\validate;

use think\Validate;

class School extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
        'title|单位名称'     =>  'require|chs|length:2,25',
        'jiancheng|单位简称'     =>  'require|chs|length:1,6',
        'biaoshi|单位标识'      =>      'number',
        'jibie|级别 '     =>  'number',
        'xingzhi|性质'    =>  'number',
        'xueduan|学段'    =>  'number',
        'paixu|排序 '     =>  'number|max:999',

    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [];
}
