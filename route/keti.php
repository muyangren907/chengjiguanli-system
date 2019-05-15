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

// 课题册中课题列表
Route::get('ktlist/:ketice/:title','keti/KetiInfo/ketilist');
Route::get('ktout/:ketice','keti/KetiInfo/outXlsx');
// 结题编辑
Route::get('ktjt/:id/edit','keti/KetiInfo/jieTi');
Route::put('ktjt/:id','keti/KetiInfo/jtUpdate');
// 添加立项信息
Route::get('ktinfoadd/:ketice','keti/KetiInfo/create');
// 批量添加立项图片
Route::get('ktinfoaddall/:ketice','keti/KetiInfo/createAll');
Route::post('ktinfoaddall/:ketice','keti/KetiInfo/saveall');





