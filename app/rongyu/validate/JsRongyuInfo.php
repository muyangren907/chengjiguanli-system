<?php

namespace app\rongyu\validate;

use think\Validate;

class JsRongyuInfo extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */
	protected $rule = [
        'id|请先上传图片'      =>    'require',
        'rongyuce_id|荣誉册ID丢失'      =>    'require',
        'title|荣册标题'     =>  'require|length:1,50',
        'hjteachers_id|获奖人'     =>  'require|array',
        'hjschool_id|荣誉所在单位'     =>  'require|number',
        'subject_id|荣誉所属学科'     =>  'require|number',
        'hjshijian|发证时间'     =>  'require|date',
        'jiangxiang_id|奖项'     =>  'require|number',
        'cyteachers_id|参与人'    =>  'array',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */
    protected $message = [];

    // 验证场景
    protected $scene = [
        'create'  =>  ['rongyuce_id', 'title', 'hjteachers_id', 'hjschool_id', 'subject_id', 'hjshijian', 'jiangxiang_id', 'cyteachers_id', 'pic'],
        'edit'  =>  ['id','title', 'hjteachers_id', 'hjschool_id', 'subject_id', 'hjshijian', 'jiangxiang_id', 'cyteachers_id', 'pic'],
    ];
}
