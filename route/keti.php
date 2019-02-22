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
Route::resource('kt','keti/Index');
Route::resource('ktinfo','keti/KetiInfo');
// 课题册中的课题信息
Route::get('ktinfo/:id/ketice','keti/KetiInfo/ketiCe');
// 添加立项信息
Route::get('ktinfo/:id/create','keti/KetiInfo/create');
// 批量添加立项图片
Route::get('ktinfoall/:id/createall','keti/KetiInfo/createall');




