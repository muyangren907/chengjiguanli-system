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

// 系统设置systembase

Route::group('/', function () {
	    Route::rule('','systembase/edit','get');		# 系统配置页面
	    Route::rule('update/<id>','systembase/update','put');		# 配置更新
	});

// 文件管理fields
Route::group('file', function () {
	    Route::rule('','fields/index','get');		# 文件列表
		Route::rule('data','fields/ajaxdata','post');			# 获取数据
		Route::rule('delete/<id>','fields/delete','delete');		# 删除记录
		Route::rule('download/<id>','fields/download','get');		# 文件下载
	});


// 单位管理fields
Route::group('school', function () {
	    Route::rule('','school/index','get');						# 信息列表
	    Route::rule('data','school/ajaxdata','post');				# 获取数据
	    Route::rule('create','school/create','get');				# 添加信息
	    Route::rule('save','school/save','post');					# 保存信息
	    // Route::rule('read<id>','school/read','get');				# 读取信息
	    Route::rule('edit/<id>','school/edit','get');				# 修改信息
	    Route::rule('update/<id>','school/update','put');			# 更新信息
	    Route::rule('delete/<id>','school/delete','delete');		# 删除信息
	    Route::rule('status','school/setStatus','post');		# 删除信息
	});


// 类别管理category
Route::group('category', function () {
	    Route::rule('','category/index','get');						# 信息列表
	    Route::rule('data','category/ajaxdata','post');				# 获取数据
	    Route::rule('create','category/create','get');				# 添加信息
	    Route::rule('save','category/save','post');					# 保存信息
	    // Route::rule('read<id>','category/read','get');				# 读取信息
	    Route::rule('edit/<id>','category/edit','get');				# 修改信息
	    Route::rule('update/<id>','category/update','put');			# 更新信息
	    Route::rule('delete/<id>','category/delete','delete');		# 删除信息
	    Route::rule('status','category/setStatus','post');		# 删除信息
	});


