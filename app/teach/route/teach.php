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
// Route::resource('xueqi','teach/Xueqi');
// Route::resource('kaoshi','teach/Kaoshi');
// Route::resource('subject','teach/Subject');
// Route::resource('banji','teach/Banji');
// Route::post('banji/:id/yidong','teach/Banji/yidong'); // 定义班级移动post规则
// Route::post('banji/njbanji','teach/Banji/mybanji'); // 定义GET请求路由规则
// Route::post('banji/schbanji','teach/Banji/banjilist'); // 定义GET请求路由规则
// Route::get('kaoshi/:id/kaohao','teach/Kaoshi/kaohao');
// Route::post('kaoshi/kaohao','teach/Kaoshi/kaohaosave');
// Route::get('kaoshi/:id/biaoqian','teach/Kaoshi/biaoqian');
// Route::get('kaoshi/:id/caiji','teach/Kaoshi/caiji');
// Route::post('kaoshi/caiji','teach/Kaoshi/cankaomingdan');

// 学期管理
Route::group('xueqi', function () {
	    Route::rule('','xueqi/index','get');						# 信息列表
	    Route::rule('data','xueqi/ajaxdata','post');				# 获取数据
	    Route::rule('create','xueqi/create','get');				# 添加信息
	    Route::rule('save','xueqi/save','post');					# 保存信息
	    // Route::rule('read/<id>','xueqi/read','get');				# 读取信息
	    Route::rule('edit/<id>','xueqi/edit','get');				# 修改信息
	    Route::rule('update/<id>','xueqi/update','put');			# 更新信息
	    Route::rule('delete/<id>','xueqi/delete','delete');		# 删除信息
	    Route::rule('status','xueqi/setStatus','post');		# 删除信息
	});

// 班级管理
Route::group('banji', function () {
	    Route::rule('','banji/index','get');						# 信息列表
	    Route::rule('data','banji/ajaxdata','post');				# 获取数据
	    Route::rule('create','banji/create','get');				# 添加信息
	    Route::rule('save','banji/save','post');					# 保存信息
	    // Route::rule('read/<id>','banji/read','get');				# 读取信息
	    Route::rule('edit/<id>','banji/edit','get');				# 修改信息
	    Route::rule('update/<id>','banji/update','put');			# 更新信息
	    Route::rule('delete/<id>','banji/delete','delete');		# 删除信息
	    Route::rule('status','banji/setStatus','post');		# 删除信息
	    Route::rule('yidong/<id>','banji/yidong','post');		# 删除信息
	    Route::rule('mybanji','banji/mybanji','post');		# 删除信息
	    Route::rule('mybanjis','banji/mybanji','post');		# 删除信息
	});


// 学科管理
Route::group('subject', function () {
	    Route::rule('','subject/index','get');						# 信息列表
	    Route::rule('data','subject/ajaxdata','post');				# 获取数据
	    Route::rule('create','subject/create','get');				# 添加信息
	    Route::rule('save','subject/save','post');					# 保存信息
	    // Route::rule('read/<id>','subject/read','get');				# 读取信息
	    Route::rule('edit/<id>','subject/edit','get');				# 修改信息
	    Route::rule('update/<id>','subject/update','put');			# 更新信息
	    Route::rule('delete/<id>','subject/delete','delete');		# 删除信息
	    Route::rule('status','subject/setStatus','post');		# 删除信息
	    Route::rule('kaoshi','subject/kaoshi','post');		# 删除信息
	});



