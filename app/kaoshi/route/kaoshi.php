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
    Route::rule('more/<kaoshi_id>','Index/moreAction','get');				# 修改信息
    Route::rule('cyschool','Index/cySchool','post');				# 获取参加考试班级
    Route::rule('cynianji','Index/cyNianji','post');				# 获取参加考试班级
    Route::rule('cybanji','Index/cyBanji','post');				# 获取参加考试班级
    Route::rule('cysubject','Index/cySubject','post');				# 获取参加考试学科
    Route::rule('kaoshiinfo/<id>','Index/kaoshiInfo','post');				# 获取参加考试的学校、学科、班级、年级等信息
    Route::rule('luru','Index/luru','post');     # 删除信息
});


// 考试设置
Route::group('kaoshiset', function () {
    Route::rule('index/<kaoshi_id>','KaoshiSet/index','get');						# 信息列表
    Route::rule('data','KaoshiSet/ajaxdata','post');				# 获取数据
    Route::rule('create/<kaoshi_id>','KaoshiSet/create','get');		# 添加信息
    Route::rule('save','KaoshiSet/save','post');					# 保存信息
    Route::rule('edit/<id>','KaoshiSet/edit','get');				# 修改信息
    Route::rule('update/<id>','KaoshiSet/update','put');			# 更新信息
    Route::rule('delete/<id>','KaoshiSet/delete','delete');		# 删除信息
    Route::rule('status','KaoshiSet/setStatus','post');		# 删除信息
});


// 考试设置
Route::group('tjlog', function () {
    Route::rule('index/<kaoshi_id>','TongjiLog/index','get');
    Route::rule('data','TongjiLog/ajaxData','post');
});










