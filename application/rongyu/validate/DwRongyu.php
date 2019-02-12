<?php

namespace app\rongyu\validate;

use think\Validate;

class DwRongyu extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
        // 'url|请先上传荣誉图片'     =>  'require',
        'id|请先上传荣誉图片'     =>  'require',
        'title|荣誉标题'     =>  'length:1,40',
        'category|荣誉类型'     =>  'require|number',
        'hjschool|获奖单位'     =>  'require|number',
        'fzshijian|发证时间'     =>  'require|date',
        'fzschool|发证单位'     =>  'require|number',
        'jiangxiang|奖项'     =>  'require|number',
        'teachers|参与人'      =>'array',
    ];

    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [];
}
