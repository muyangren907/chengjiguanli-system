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
Route::resource('dwry','rongyu/DwRongyu');
Route::resource('jsry','rongyu/JsRongyu');
Route::resource('jsryinfo','rongyu/JsRongyuInfo');
Route::get('dwry/createall','rongyu/DwRongyu/createall');
// Route::get('jsry/:id/createall','rongyu/JsRongyu/createall');
Route::get('jsryinfoadd/:id','rongyu/JsRongyuInfo/create');
Route::get('jsryinfoaddall/:id','rongyu/JsRongyuInfo/createall');