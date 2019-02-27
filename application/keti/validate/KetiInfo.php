<?php

namespace app\keti\validate;

use think\Validate;

class KetiInfo extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
        'id|请先上传立项通知书图片'      =>    'require',
        'ketice|课题册ID丢失'      =>    'require',
        'title|课题名称'     =>  'require|length:1,60',
        'bianhao|课题编号'     =>  'require|length:1,11',
        'hjteachers|课题主持人'     =>  'require|array',
        'fzdanweiid|课题负责单位'     =>  'require|number',
        'subject|课题所属学科'     =>  'require|number',
        'category|课题研究类型'     =>  'require|number',
        'jhjtshijian|计划结题时间'     =>  'require|date',
        'cyteachers|参与人'    =>  'array',
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
        'add'  =>  ['ketice','title','bianhao','fzdanweiid','subject','category','jhjtshijian','hjteachers'],
        'edit'  =>  ['id','title','hjteachers','hjschool','subject','hjshijian','jiangxiang','cyteachers'],
    ];
}
