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

// 管理员管理
Route::group('index', function () {
	    Route::rule('','index/index','get');						# 信息列表
	    Route::rule('data','index/ajaxdata','post');				# 获取数据
	    Route::rule('create','index/create','get');				# 添加信息
	    Route::rule('save','index/save','post');					# 保存信息
	    Route::rule('read/<id>','index/read','get');				# 读取信息
	    Route::rule('edit/<id>','index/edit','get');				# 修改信息
	    Route::rule('update/<id>','index/update','put');			# 更新信息
	    Route::rule('delete/<id>','index/delete','delete');		# 删除信息
	    Route::rule('status','index/setStatus','post');		# 删除信息

	    Route::rule('resetpassword/<id>','admin/Index/resetpassword','post');		# 重置密码
	    Route::rule('editpassword','admin/Index/editPassword','get');		# 修改密码
	    Route::rule('updatepassword/<id>','admin/Index/updatePassword','put');		# 更新密码
	    Route::rule('myinfo','admin/Index/myinfo','get');		# 用户信息

	});

// 权限管理
Route::group('authrule', function () {
	    Route::rule('','authrule/index','get');						# 信息列表
	    Route::rule('data','authrule/ajaxdata','post');				# 获取数据
	    Route::rule('create','authrule/create','get');				# 添加信息
	    Route::rule('save','authrule/save','post');					# 保存信息
	    // Route::rule('read/<id>','authrule/read','get');				# 读取信息
	    Route::rule('edit/<id>','authrule/edit','get');				# 修改信息
	    Route::rule('update/<id>','authrule/update','put');			# 更新信息
	    Route::rule('delete/<id>','authrule/delete','delete');		# 删除信息
	    Route::rule('status','authrule/setStatus','post');		# 删除信息
	});

// 角色管理
Route::group('authgroup', function () {
	    Route::rule('','authgroup/index','get');						# 信息列表
	    Route::rule('data','authgroup/ajaxdata','post');				# 获取数据
	    Route::rule('create','authgroup/create','get');				# 添加信息
	    Route::rule('save','authgroup/save','post');					# 保存信息
	    // Route::rule('read/<id>','authgroup/read','get');				# 读取信息
	    Route::rule('edit/<id>','authgroup/edit','get');				# 修改信息
	    Route::rule('update/<id>','authgroup/update','put');			# 更新信息
	    Route::rule('delete/<id>','authgroup/delete','delete');		# 删除信息
	    Route::rule('status','authgroup/setStatus','post');		# 删除信息
	});