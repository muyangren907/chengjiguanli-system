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
Route::resource('admin','admin/Index');
Route::resource('authgroup','admin/AuthGroup');
Route::resource('authrule','admin/AuthRule');
Route::resource('authgroup','admin/AuthGroup');
Route::get('resetpassword/:id','admin/Index/resetpassword');
Route::get('editpassword/:id/edit','admin/Index/editPassword');
Route::put('editpassword/:id','admin/Index/updatePassword');
Route::get('myinfo','admin/Index/myinfo');