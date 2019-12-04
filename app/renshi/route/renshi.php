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
use think\facade\Route;


//系统设置路由
Route::resource('teacher','renshi/Index');
Route::get('teacher/createall','renshi/Index/createAll'); // 定义GET请求路由规则
Route::post('teacher/createall','renshi/Index/saveAll'); // 定义POST请求路由规则
Route::post('srcteacher','renshi/Index/srcTeacher'); // 定义POST请求路由规则
Route::post('srcry/:teacherid','renshi/Index/srcRy'); // 定义POST请求路由规则
Route::post('srckt/:teacherid','renshi/Index/srcKt'); // 定义POST请求路由规则



Route::resource('student','renshi/Student');
Route::get('student/createall','renshi/Student/createAll'); // 定义GET请求路由规则
Route::post('student/createall','renshi/Student/saveAll'); // 定义POST请求路由规则

Route::get('student/jiaodui','renshi/Student/jiaodui'); // 定义GET请求路由规则
Route::post('student/jiaodui','renshi/Student/JiaoduiDel'); // 定义POST请求路由规则

// Route::post('student/download','renshi/Student/download'); // 定义POST请求路由规则
