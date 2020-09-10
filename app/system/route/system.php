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

// 系统设置systembase
Route::group('/', function () {
	    Route::rule('', 'SystemBase/edit', 'get');		# 系统配置页面
	    Route::rule('update/<id>', 'SystemBase/update', 'put');		# 配置更新
	});

// 文件管理
Route::group('file', function () {
	    Route::rule('','Fields/index', 'get');		# 文件列表
		Route::rule('data','Fields/ajaxData', 'post');			# 获取数据
		Route::rule('delete/<id>', 'Fields/delete', 'delete');		# 删除记录
		Route::rule('download/<id>', 'Fields/download', 'get');		# 文件下载
	});

// 单位管理
Route::group('school', function () {
	    Route::rule('', 'School/index', 'get');						# 信息列表
	    Route::rule('data', 'School/ajaxData', 'post');				# 获取数据
	    Route::rule('create', 'School/create', 'get');				# 添加信息
	    Route::rule('save', 'School/save', 'post');					# 保存信息
	    Route::rule('edit/<id>', 'School/edit', 'get');				# 修改信息
	    Route::rule('update/<id>', 'School/update', 'put');			# 更新信息
	    Route::rule('delete/<id>', 'School/delete', 'delete');		# 删除信息
	    Route::rule('status', 'School/setStatus', 'post');		# 删除信息
        Route::rule('kaoshi', 'School/setKaoshi', 'post');        # 删除信息
	});

// 类别管理
Route::group('category', function () {
	    Route::rule('', 'Category/index', 'get');						# 信息列表
	    Route::rule('data', 'Category/ajaxData', 'post');				# 获取数据
	    Route::rule('create', 'Category/create', 'get');				# 添加信息
	    Route::rule('save', 'Category/save', 'post');					# 保存信息
	    Route::rule('edit/<id>', 'Category/edit', 'get');				# 修改信息
	    Route::rule('update/<id>', 'Category/update', 'put');			# 更新信息
	    Route::rule('delete/<id>', 'Category/delete', 'delete');		# 删除信息
	    Route::rule('status', 'Category/setStatus', 'post');		# 删除信息
	});


// 类别管理
Route::group('backup', function () {
	    Route::rule('index', 'BackUp/index', 'get');				# 获取数据
	    Route::rule('create', 'BackUp/create', 'post');				# 获取数据
	    Route::rule('data', 'BackUp/ajaxData', 'post');				# 获取数据
	    Route::rule('delete/<time>', 'BackUp/delete', 'post');				# 获取数据
	});


