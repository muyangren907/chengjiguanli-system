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
// Route::get('/','systembase/edit');
// Route::group('sys', function () {
//     Route::get('/', 'systembase/edit');
//     // Route::rule(':name', 'blog/read');
// })->ext('html')->pattern(['id' => '\d+', 'name' => '\w+']);
// Route::resource('sysbase','system/SystemBase');
// Route::resource('category','system/Category');
// Route::resource('school','system/School');
// Route::resource('fields','system/Fields');

// systembase
Route::rule('/','systembase/edit','get');
Route::rule('/<id>','systembase/update','put');

// fields
Route::rule('file','fields/index','get');
Route::rule('file','fields/ajaxdata','ajax');
Route::rule('file/<id>','fields/delete','delete');
Route::rule('filedownload/<id>','fields/download','get');


