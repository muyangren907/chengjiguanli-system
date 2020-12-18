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

// 课题册管理
Route::group('ketice', function () {
	    Route::rule('','Ketice/index','get');						# 信息列表
	    Route::rule('data','Ketice/ajaxdata','post');				# 获取数据
	    Route::rule('create','Ketice/create','get');				# 添加信息
	    Route::rule('save','Ketice/save','post');					# 保存信息
	    Route::rule('edit/<id>','Ketice/edit','get');				# 修改信息
	    Route::rule('update/<id>','Ketice/update','put');			# 更新信息
	    Route::rule('delete/<id>','Ketice/delete','delete');		# 删除信息
	    Route::rule('status','Ketice/setStatus','post');		# 删除信息
	});

// 课题信息管理
Route::group('ketiinfo', function () {
	    Route::rule('','KetiInfo/index','get');						# 信息列表
	    Route::rule('data','KetiInfo/ajaxdata','post');				# 获取数据
	    Route::rule('create/<ketice_id>','KetiInfo/create','get');				# 添加信息
	    Route::rule('save','KetiInfo/save','post');					# 保存信息
	    Route::rule('edit/<id>','KetiInfo/edit','get');				# 修改信息
	    Route::rule('update/<id>','KetiInfo/update','put');			# 更新信息
	    Route::rule('delete/<id>','KetiInfo/delete','delete');		# 删除信息
	    Route::rule('status','KetiInfo/setStatus','post');		# 删除信息
	    Route::rule('list/<ketice_id>','KetiInfo/ketiList','get');		# 课题册列表
	    Route::rule('createall/<ketice_id>','KetiInfo/createAll','get');				# 批量导入
	    Route::rule('saveall/<ketice_id>','KetiInfo/saveAll','post');					# 批量保存
	    Route::rule('jieti/<id>','KetiInfo/jieTi','get');					# 批量保存
	    Route::rule('jietiupdate/<id>','KetiInfo/jtUpdate','put');					# 批量保存
	    Route::rule('download/<ketice_id>','KetiInfo/outXlsx','get');					# 批量保存
	});





