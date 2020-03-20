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


// 学期管理
Route::group('xueqi', function () {
	    Route::rule('','xueqi/index','get');						# 信息列表
	    Route::rule('data','xueqi/ajaxdata','post');				# 获取数据
	    Route::rule('create','xueqi/create','get');				# 添加信息
	    Route::rule('save','xueqi/save','post');					# 保存信息
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
	    Route::rule('delete/<id>','banji/delete','delete');		# 删除信息
	    Route::rule('status','banji/setStatus','post');		# 删除信息
	    Route::rule('yidong/<id>','banji/yidong','post');		# 删除信息
	    Route::rule('mybanji','banji/mybanji','post');		# 删除信息
	    Route::rule('mybanjis','banji/banjiList','post');		# 删除信息
	});


// 班级管理
Route::group('banjicj', function () {
        Route::rule('index/<banji>','BanjiChengji/index','get');                        # 信息列表
        Route::rule('data','BanjiChengji/ajaxData','post');         # 获取成绩
        Route::rule('datatx','BanjiChengji/ajaxDataTiaoXing','post');         # 获取成绩
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



