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
	    Route::rule('delete','xueqi/delete','delete');		# 删除信息
	    Route::rule('status','xueqi/setStatus','post');		# 删除信息
	    Route::rule('srcxueqi','Xueqi/srcXueqi','post');				# 获取数据
	});

// 班级管理
Route::group('banji', function () {
	    Route::rule('','banji/index','get');						# 信息列表
        Route::rule('student/<banji_id>','banji/student','get');                        # 信息列表
	    Route::rule('data','banji/ajaxdata','post');				# 获取数据
	    Route::rule('create','banji/create','get');				# 添加信息
	    Route::rule('save','banji/save','post');					# 保存信息
	    Route::rule('delete','banji/delete','delete');		# 删除信息
	    Route::rule('status','banji/setStatus','post');		# 删除信息
	    Route::rule('yidong/<id>','banji/yidong','post');		# 删除信息
	    Route::rule('mybanji','banji/mybanji','post');		# 删除信息
	    Route::rule('mybanjis','banji/banjiList','post');		# 删除信息
        Route::rule('alias','banji/setAlias','put');       # 删除信息
        Route::rule('njlist','banji/njList','post');                # 获取年级列表

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
	    Route::rule('delete','subject/delete','delete');		# 删除信息
	    Route::rule('status','subject/setStatus','post');		# 删除信息
	    Route::rule('kaoshi','subject/kaoshi','post');		# 删除信息
	    Route::rule('srccy','subject/srcsbj','post');				# 获取数据
	});


// 班主任管理
Route::group('banzhuren', function () {
        Route::rule('index/<banji_id>','BanZhuRen/index','get');                        # 信息列表
        Route::rule('data','BanZhuRen/ajaxdata','post');                # 获取数据
        Route::rule('create/<banji_id>','BanZhuRen/create','get');             # 添加信息
        Route::rule('save','BanZhuRen/save','post');                    # 保存信息
        Route::rule('edit/<id>','BanZhuRen/edit','get');                # 修改信息
        Route::rule('update/<id>','BanZhuRen/update','put');            # 更新信息
        Route::rule('delete','BanZhuRen/delete','delete');     # 删除信息
        Route::rule('status','BanZhuRen/setStatus','post');     # 删除信息
    });



