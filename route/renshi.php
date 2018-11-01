<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

//系统设置路由
Route::resource('teacher','renshi/Index');
Route::get('teacher/createall','renshi/Index/createAll'); // 定义GET请求路由规则
Route::post('teacher/createall','renshi/Index/saveAll'); // 定义POST请求路由规则
Route::resource('student','renshi/Student');
