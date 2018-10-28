<?php

namespace app\teach\validate;

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
        'xingming|姓名'     =>  'require|chs|length:2,8',
        'quanpin|姓名全拼'     =>  'require|chs|length:1,30',
        'shoupin|姓名首拼'     =>  'require|chs|length:1,5',
        'sex|性别'        =>      'require|number|max:2',
        'danwei|单位'        =>      'require|number',
        'shengri|出生日期'        =>      'number',
        'zhiwu|职务'      =>      'number',
        'zhicheng|职称'     =>  'number',
        'xueli|学历'    =>  'number',
        'biye|毕业院校'    =>  'length:1,50',
        'zhuanye|专业'     =>  'length:1,20',
        'worktime|参加工作时间'     =>  'length:1,20',
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [];
}
