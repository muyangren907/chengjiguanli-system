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
Route::resource('xueqi','teach/Xueqi');
Route::resource('kaoshi','teach/Kaoshi');
Route::resource('subject','teach/Subject');
Route::resource('banji','teach/Banji');
Route::post('banji/:id/yidong','teach/Banji/yidong'); // 定义班级移动post规则
Route::post('banji/mybanji','teach/Banji/mybanji'); // 定义GET请求路由规则
Route::post('banji/banjilist','teach/Banji/banjilist'); // 定义GET请求路由规则



