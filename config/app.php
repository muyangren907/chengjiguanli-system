<?php
// +----------------------------------------------------------------------
// | 应用设置
// +----------------------------------------------------------------------

use think\facade\Env;

return [
    // 应用地址
    'app_host'         => Env::get('app.host', ''),
    // 应用的命名空间
    'app_namespace'    => '',
    // 是否启用路由
    'with_route'       => true,
    // 是否启用事件
    'with_event'       => true,
    // 开启应用快速访问
    'app_express'    =>    true,
    // 默认应用
    'default_app'      => 'index',
    // 默认时区
    'default_timezone' => 'Asia/Shanghai',

    // 应用映射（自动多应用模式有效）
    'app_map'          => [],
    // 域名绑定（自动多应用模式有效）
    'domain_bind'      => [],
    // 禁止URL访问的应用列表（自动多应用模式有效）
    'deny_app_list'    => [],

    // 异常页面的模板文件
    'exception_tmpl'   => app()->getThinkPath() . 'tpl/think_exception.tpl',

    // 错误显示信息,非调试模式有效
    'error_message'    => '页面错误！请稍后再试～',
    // 显示错误信息
    'show_error_msg'   => true,
    // 版本号
    'chengji'               => [
        'version'       =>      '1.5',
    ],
    // Auth权限验证公共配置
    'auth'  => [
        'auth_on'           => 1, // 权限开关
        'auth_type'         => 1, // 认证方式，1为实时认证；2为登录认证。
        'auth_group'        => 'cj_auth_group', // 用户组数据不带前缀表名
        'auth_group_access' => 'cj_auth_group_access', // 用户-用户组关系不带前缀表
        'auth_rule'         => 'cj_auth_rule', // 权限规则不带前缀表
        'auth_user'         => 'cj_member', // 用户信息不带前缀表
        'administrator'     =>  [1,2],   // 超级管理员列表
    ],
];
