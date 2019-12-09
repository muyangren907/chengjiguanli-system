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
// Route::resource('dwry','rongyu/DwRongyu');
// Route::resource('jsry','rongyu/JsRongyu');
// Route::resource('jsryinfo','rongyu/JsRongyuInfo');
// Route::get('dwry/createall','rongyu/DwRongyu/createAll');
// Route::post('dwry/createall','rongyu/DwRongyu/saveall');
// // 荣誉册中荣誉信息列表
// Route::get('rylist/:rongyuce','rongyu/JsRongyuInfo/rongyuList');
// Route::get('ryout/:rongyuce','rongyu/JsRongyuInfo/outXlsx');

// Route::get('jsryinfoadd/:rongyuce','rongyu/JsRongyuInfo/create');
// Route::get('jsryinfoaddall/:rongyuce','rongyu/JsRongyuInfo/createAll');
// Route::post('jsryinfoaddall/:rongyuce','rongyu/JsRongyuInfo/saveall');



// 单位荣誉管理
Route::group('dwry', function () {
	    Route::rule('','DwRongyu/index','get');						# 信息列表
	    Route::rule('data','DwRongyu/ajaxdata','post');				# 获取数据
	    Route::rule('create','DwRongyu/create','get');				# 添加信息
	    Route::rule('save','DwRongyu/save','post');					# 保存信息
	    // Route::rule('read/<id>','DwRongyu/read','get');				# 读取信息
	    Route::rule('edit/<id>','DwRongyu/edit','get');				# 修改信息
	    Route::rule('update/<id>','DwRongyu/update','put');			# 更新信息
	    Route::rule('delete/<id>','DwRongyu/delete','delete');		# 删除信息
	    Route::rule('status','DwRongyu/setStatus','post');		# 删除信息
	});



// 老师荣誉册管理
Route::group('jsry', function () {
	    Route::rule('','jsry/index','get');						# 信息列表
	    Route::rule('data','jsry/ajaxdata','post');				# 获取数据
	    Route::rule('create','jsry/create','get');				# 添加信息
	    Route::rule('save','jsry/save','post');					# 保存信息
	    // Route::rule('read/<id>','jsry/read','get');				# 读取信息
	    Route::rule('edit/<id>','jsry/edit','get');				# 修改信息
	    Route::rule('update/<id>','jsry/update','put');			# 更新信息
	    Route::rule('delete/<id>','jsry/delete','delete');		# 删除信息
	    Route::rule('status','jsry/setStatus','post');		# 删除信息
	});



// 教师荣誉信息
Route::group('jsryinfo', function () {
	    Route::rule('','jsryinfo/index','get');						# 信息列表
	    Route::rule('data','jsryinfo/ajaxdata','post');				# 获取数据
	    Route::rule('create','jsryinfo/create','get');				# 添加信息
	    Route::rule('save','jsryinfo/save','post');					# 保存信息
	    // Route::rule('read/<id>','jsryinfo/read','get');				# 读取信息
	    Route::rule('edit/<id>','jsryinfo/edit','get');				# 修改信息
	    Route::rule('update/<id>','jsryinfo/update','put');			# 更新信息
	    Route::rule('delete/<id>','jsryinfo/delete','delete');		# 删除信息
	    Route::rule('status','jsryinfo/setStatus','post');		# 删除信息
	});