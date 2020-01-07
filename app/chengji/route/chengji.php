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


// 成绩管理
Route::group('index', function () {
	    Route::rule('malu','Index/malu','get');			# 扫码界面
	    Route::rule('malusave','Index/malusave','put');		# 扫码保存
	    Route::rule('read','Index/read','post');		# 成绩读取
	    Route::rule('biaolu','Index/biaolu','get');					# 保存信息
	    Route::rule('saveall','Index/saveAll','post');				# 读取信息
	    Route::rule('edit/<id>','Index/edit','get');				# 修改信息
	    Route::rule('update/<id>','Index/update','put');				# 更新信息
	    Route::rule('list/<kaoshi>','Index/index','get');				# 成绩列表
	    Route::rule('data','Index/ajaxData','post');			# 成绩获取
	    Route::rule('readcjadd/<kaohao>','Index/readAdd','get');				# 成绩录入列表
	    Route::rule('dataadd','Index/ajaxaddinfo','post');				# 成绩录入列表数据
	    Route::rule('delete/<id>','Index/delete','delete');				# 成绩删除
	    Route::rule('deletecjs/<kaoshi>','Index/deletecjs','get');				# 成绩删除
	    Route::rule('deletecjmore','Index/deletecjmore','post');				# 成绩删除
		Route::rule('dwchengji/<kaoshi>','Index/dwChengji','get');				# 成绩删除
		Route::rule('dwxlsx','Index/dwchengjixlsx','post');				# 成绩删除
		Route::rule('dwchengjitiao/<kaoshi>','Index/dwChengjitiao','get');				# 成绩删除
		Route::rule('dwcjtiaoxlsx','Index/dwchengjitiaoxlsx','post');				# 成绩删除
	});


// 成绩统计
Route::group('tongji', function () {
		Route::rule('yilucnt/<kaoshi>','Tongji/yiluCnt');			# 更新信息
	});


// 班级统计
Route::group('bjtj', function () {
	    Route::rule('biaoge/<kaoshi>','Bjtongji/biaoge','get');			# 班级表格
	    Route::rule('data','Bjtongji/ajaxData','post');			# 扫码界面
	    Route::rule('dwbiaoge/<kaoshi>','Bjtongji/dwBiaoge','get');		# 扫码保存
	    Route::rule('dwxlsx','Bjtongji/dwBanjixls','post');		# 扫码保存
	    Route::rule('tongji','Bjtongji/tongji','post');		# 统计各班级成绩
	});


// 学校年级统计
Route::group('njtj', function () {
	    Route::rule('biaoge/<kaoshi>','Njtongji/biaoge','get');			# 班级表格
	    Route::rule('data','Njtongji/ajaxData','post');			# 扫码界面
	    Route::rule('dwbiaoge/<kaoshi>','Njtongji/dwBiaoge','get');		# 扫码保存
	    Route::rule('dwxlsx','Njtongji/dwNianjixlsx','post');		# 扫码保存
	    Route::rule('tongji','Njtongji/tongji','post');		# 统计各年级成绩
	});

// 全年级统计
Route::group('schtj', function () {
	    Route::rule('tongji','Schtongji/tongji','post');		# 统计各年级成绩
	});