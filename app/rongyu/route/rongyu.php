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
Route::resource('dwry','rongyu/DwRongyu');
Route::resource('jsry','rongyu/JsRongyu');
Route::resource('jsryinfo','rongyu/JsRongyuInfo');
Route::get('dwry/createall','rongyu/DwRongyu/createAll');
Route::post('dwry/createall','rongyu/DwRongyu/saveall');
// 荣誉册中荣誉信息列表
Route::get('rylist/:rongyuce','rongyu/JsRongyuInfo/rongyuList');
Route::get('ryout/:rongyuce','rongyu/JsRongyuInfo/outXlsx');

Route::get('jsryinfoadd/:rongyuce','rongyu/JsRongyuInfo/create');
Route::get('jsryinfoaddall/:rongyuce','rongyu/JsRongyuInfo/createAll');
Route::post('jsryinfoaddall/:rongyuce','rongyu/JsRongyuInfo/saveall');