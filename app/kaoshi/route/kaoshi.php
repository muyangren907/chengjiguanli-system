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


// //系统设置路由
// Route::resource('kaoshi','kaoshi/Index');
// Route::resource('kaohao','kaoshi/Kaohao');
// // 考试更多操作
// Route::get('kaoshi/:kaoshi/more','kaoshi/Index/moreAction');
// // 考试设置保存
// Route::get('kaoshiset/:id','kaoshi/Index/kaoshiset');
// Route::put('kaoshiset/:id','kaoshi/Index/updateset');
// // 考号保存
// Route::get('kaoshi/:kaoshi/kaohao','kaoshi/Kaohao/index');
// Route::post('kaoshi/kaohao','kaoshi/Kaohao/save');
// // 下载成绩采集表
// Route::get('kaoshi/:kaoshi/caiji','kaoshi/Kaohao/caiji');
// Route::post('kaoshi/caiji','kaoshi/Kaohao/dwcaiji');
// // 下载试卷标签
// Route::get('kaoshi/:kaoshi/biaoqian','kaoshi/Kaohao/biaoqian');
// Route::post('kaoshi/:kaoshi/biaoqianXls','kaoshi/Kaohao/biaoqianXls');

// 考试管理
Route::group('index', function () {
	    Route::rule('','Index/index','get');						# 信息列表
	    Route::rule('data','Index/ajaxdata','post');				# 获取数据
	    Route::rule('create','Index/create','get');				# 添加信息
	    Route::rule('save','Index/save','post');					# 保存信息
	    // Route::rule('read/<id>','Index/read','get');				# 读取信息
	    Route::rule('edit/<id>','Index/edit','get');				# 修改信息
	    Route::rule('update/<id>','Index/update','put');			# 更新信息
	    Route::rule('delete/<id>','Index/delete','delete');		# 删除信息
	    Route::rule('status','Index/setStatus','post');		# 删除信息
	    Route::rule('set/<id>','Index/kaoshiSet','get');				# 修改信息
	    Route::rule('updateset/<id>','Index/updateSet','put');			# 更新信息
	    Route::rule('more/<kaoshi>','Index/moreAction','get');				# 修改信息
	});


// 考号管理
Route::group('kaohao', function () {
	    Route::rule('create/<kaoshi>','Kaohao/create','get');						# 信息列表
	    Route::rule('save','Kaohao/save','post');					# 保存信息
	    // Route::rule('read/<id>','Kaohao/read','get');				# 读取信息
	    // Route::rule('edit/<id>','Kaohao/edit','get');				# 修改信息
	    // Route::rule('update/<id>','Kaohao/update','put');			# 更新信息
	    // Route::rule('delete/<id>','Kaohao/delete','delete');		# 删除信息
	    // Route::rule('status','Kaohao/setStatus','post');		# 删除信息
	});



