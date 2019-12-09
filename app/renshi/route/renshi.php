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


// 学生管理
Route::group('student', function () {
	    Route::rule('','student/index','get');						# 信息列表
	    Route::rule('data','student/ajaxdata','post');				# 获取数据
	    Route::rule('create','student/create','get');				# 添加信息
	    Route::rule('save','student/save','post');					# 保存信息
	    // Route::rule('read/<id>','student/read','get');				# 读取信息
	    Route::rule('edit/<id>','student/edit','get');				# 修改信息
	    Route::rule('update/<id>','student/update','put');			# 更新信息
	    Route::rule('delete/<id>','student/delete','delete');		# 删除信息
	    Route::rule('status','student/setStatus','post');		# 删除信息
	    Route::rule('createall','student/createAll','get');				# 批量导入
	    Route::rule('saveall','student/saveAll','post');				# 批量保存
		Route::rule('jiaodui','student/jiaoDui','get');					# 批量保存
		Route::rule('jiaoduidel','student/jiaoduiDel','post');				# 批量保存
	});


// 教师管理
Route::group('teacher', function () {
	    Route::rule('','teacher/index','get');						# 信息列表
	    Route::rule('data','teacher/ajaxdata','post');				# 获取数据
	    Route::rule('create','teacher/create','get');				# 添加信息
	    Route::rule('save','teacher/save','post');					# 保存信息
	    Route::rule('read/<id>','teacher/read','get');				# 读取信息
	    Route::rule('edit/<id>','teacher/edit','get');				# 修改信息
	    Route::rule('update/<id>','teacher/update','put');			# 更新信息
	    Route::rule('delete/<id>','teacher/delete','delete');		# 删除信息
	    Route::rule('status','teacher/setStatus','post');		# 删除信息
	    Route::rule('createall','teacher/createAll','get');				# 批量导入
	    Route::rule('saveall','teacher/saveAll','post');					# 批量保存
	    Route::rule('upload','teacher/upload','post');				# 批量导入
	    Route::rule('srcteacher','teacher/srcTeacher','post');		# 查询教师
	    Route::rule('downloadxls','teacher/downloadXls','get');		# 下载模板
	    Route::rule('downloadvba','teacher/downloadVba','get');		# 下载模板
	    Route::rule('srcry/<teacherid>','teacher/srcRy','post');		# 查询荣誉
	    Route::rule('srckt/<teacherid>','teacher/srcKt','post');		# 查询课题
	});
