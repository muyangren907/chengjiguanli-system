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

// 荣誉册中课题列表
Route::get('ktlist/:id','keti/KetiInfo/ketilist');
// 添加立项信息
Route::get('ktinfoadd/:id','keti/KetiInfo/create');
// 批量添加立项图片
Route::get('ktinfoaddall/:id','keti/KetiInfo/createall');




