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
	    Route::rule('','Student/index','get');						# 信息列表
	    Route::rule('data','Student/ajaxdata','post');				# 获取数据
	    Route::rule('create','Student/create','get');				# 添加信息
	    Route::rule('save','Student/save','post');					# 保存信息
	    Route::rule('edit/<id>','Student/edit','get');				# 修改信息
	    Route::rule('update/<id>','Student/update','put');			# 更新信息
        Route::rule('read/<id>','Student/read','get');              # 读取信息
	    Route::rule('delete/<id>','Student/delete','delete');		# 删除信息
	    Route::rule('status','Student/setStatus','post');		# 删除信息
	    Route::rule('createall','Student/createAll','get');				# 批量导入
	    Route::rule('saveall','Student/saveAll','post');				# 批量保存
		Route::rule('deletes','Student/deletes','get');					# 批量保存
		Route::rule('deleteall','Student/deleteXlsx','post');				# 批量保存
		Route::rule('download','Student/download','get');				# 批量保存
		Route::rule('srcstudent','Student/srcStudent','post');		# 获取学生成绩
		Route::rule('redel/<id>','Student/reDel','delete');		# 恢复删除的学生
		Route::rule('kaoshi','Student/setKaoshi','post');		# 删除信息
	});


// 学生成绩列表
Route::group('studentcj', function () {
        Route::rule('<id>','StudentChengji/index','get');              # 读取信息
	    Route::rule('data','StudentChengji/ajaxData','post');       # 获取学生成绩列表
        Route::rule('chengjitubiao','StudentChengji/ajaxOneStudentChengjiTuBiao','post');       # 获取学生成绩列表
        Route::rule('chengjileida','StudentChengji/ajaxOneStudentChengjiLeiDa','post');       # 获取学生成绩列表
	});


// 学生管理
Route::group('student', function () {
        Route::rule('bylist','Student/byList','get');                       # 信息列表
        Route::rule('databy','Student/ajaxdataBy','post');              # 获取数据
        Route::rule('dellist','Student/delList','get');                     # 信息列表
        Route::rule('datadel','Student/ajaxdataDel','post');                # 获取数据
    });


// 教师管理
Route::group('teacher', function () {
	    Route::rule('','Teacher/index','get');						# 信息列表
	    Route::rule('data','Teacher/ajaxdata','post');				# 获取数据
	    Route::rule('create','Teacher/create','get');				# 添加信息
	    Route::rule('save','Teacher/save','post');					# 保存信息
	    Route::rule('read/<id>','Teacher/read','get');				# 读取信息
	    Route::rule('edit/<id>','Teacher/edit','get');				# 修改信息
	    Route::rule('update/<id>','Teacher/update','put');			# 更新信息
	    Route::rule('delete/<id>','Teacher/delete','delete');		# 删除信息
	    Route::rule('status','Teacher/setStatus','post');		# 删除信息
	    Route::rule('createall','Teacher/createAll','get');				# 批量导入
	    Route::rule('saveall','Teacher/saveAll','post');					# 批量保存
	    Route::rule('upload','Teacher/upload','post');				# 批量导入
	    Route::rule('srcteacher','Teacher/srcTeacher','post');		# 查询教师
	    Route::rule('downloadxls','Teacher/downloadXls','get');		# 下载模板
	    Route::rule('srcry','Teacher/srcRy','post');		# 查询荣誉
	    Route::rule('srckt','Teacher/srcKt','post');		# 查询课题
	});

// 教师管理
Route::group('teacher', function () {
	    Route::rule('dellist','Teacher/delList','get');						# 信息列表
	    Route::rule('datadel','Teacher/ajaxDataDel','post');				# 获取数据
	    Route::rule('redel/<id>','Teacher/reDel','delete');		# 获取学生成绩
	});
