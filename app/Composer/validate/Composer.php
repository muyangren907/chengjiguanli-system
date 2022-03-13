<?php
declare (strict_types = 1);

namespace app\composer\validate;

use think\Validate;

class Composer extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名' =>  ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'teacher_id|使用人' => 'require|number',
        'url|原文件地址' =>  'require',
        'xinghao|电脑型号' =>  'require',
        'xuliehao|主板序列号' =>  'require',
        'mac|物理网卡地址' =>  'require',
        'weizhi|存放位置'  => 'require|length:2,80',
        'ip|现IP地址' => 'require|ip',
        'biaoqian_time|标签时间' => 'require|date',
        'shangchuan_id|上传信息人' => 'require|number',
        'info|电脑概览' => 'require',
        'infos|电脑配置' => 	'require',
        'xitong|操作系统' =>	'require|length:2,80',
        'xitong_time|安装操作系统时间' => 'require|date'
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名' =>  '错误信息'
     *
     * @var array
     */
    protected $message = [];
}
