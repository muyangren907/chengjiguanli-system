<?php

namespace app\teacher\validate;

use think\Validate;

class Teacher extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */
	protected $rule = [
        'id|ID'         =>     'require|number',
        'xingming|姓名'     =>  'require|chs|length:2,8',
        'quanpin|姓名全拼'     =>  'require|alpha|length:1,30',
        'shoupin|姓名首拼'     =>  'require|alpha|length:1,5',
        'sex|性别'        =>      'require|number|max:2',
        'danwei_id|单位'        =>      'require|number',
        'shengri|出生日期'        =>      'date',
        'phone|手机号'         =>      'require|mobile',
        'zhiwu_id|职务'      =>      'number',
        'zhicheng_id|职称'     =>  'number',
        'xueli_id|学历'    =>  'number',
        'biye|毕业院校'    =>  'length:1,50',
        'zhuanye|专业'     =>  'length:1,20',
        'worktime|参加工作时间'     =>  'date',
        'tuixiu|退休'        =>      'require|number|max:2',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */
    protected $message = [];

    protected $scene = [
        'create'  =>  [
            'xingming'
            ,'quanpin'
            ,'shoupin'
            ,'sex'
            ,'danwei_id'
            ,'shengri'
            ,'phone'
            ,'zhiwu_id'
            ,'zhicheng_id'
            ,'xueli_id'
            ,'biye'
            ,'zhuanye'
            ,'worktime'
            ,'tuixiu'
        ],
        'edit'  =>  [
            'id'
            ,'xingming'
            ,'quanpin'
            ,'shoupin'
            ,'sex'
            ,'danwei_id'
            ,'shengri'
            ,'phone'
            ,'zhiwu_id'
            ,'zhicheng_id'
            ,'xueli_id'
            ,'biye'
            ,'zhuanye'
            ,'worktime'
            ,'tuixiu'
        ],
    ];
}
