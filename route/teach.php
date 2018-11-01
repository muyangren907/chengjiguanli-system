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
Route::resource('teacher','teach/Index');
Route::resource('xueqi','teach/Xueqi');
Route::resource('kaoshi','teach/Kaoshi');
Route::resource('subject','teach/Subject');
Route::get('teacher/createall','teach/Index/createAll'); // 定义GET请求路由规则
Route::post('teacher/createall','teach/Index/saveAll'); // 定义POST请求路由规则
