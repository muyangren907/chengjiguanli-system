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
// Route::resource('dwry','rongyu/DwRongyu');
// Route::resource('jsry','rongyu/JsRongyu');
// Route::resource('jsryinfo','rongyu/JsRongyuInfo');
// Route::get('dwry/createall','rongyu/DwRongyu/createAll');
// Route::post('dwry/createall','rongyu/DwRongyu/saveall');
// // 荣誉册中荣誉信息列表
// Route::get('rylist/:rongyuce','rongyu/JsRongyuInfo/rongyuList');
// Route::get('ryout/:rongyuce','rongyu/JsRongyuInfo/outXlsx');

// Route::get('jsryinfoadd/:rongyuce','rongyu/JsRongyuInfo/create');
// Route::get('jsryinfoaddall/:rongyuce','rongyu/JsRongyuInfo/createAll');
// Route::post('jsryinfoaddall/:rongyuce','rongyu/JsRongyuInfo/saveall');



// 单位荣誉管理
Route::group('danwei', function () {
	    Route::rule('','Danwei/index','get');						# 信息列表
	    Route::rule('data','Danwei/ajaxdata','post');				# 获取数据
	    Route::rule('create','Danwei/create','get');				# 添加信息
	    Route::rule('save','Danwei/save','post');					# 保存信息
	    // Route::rule('read/<id>','Danwei/read','get');				# 读取信息
	    Route::rule('edit/<id>','Danwei/edit','get');				# 修改信息
	    Route::rule('update/<id>','Danwei/update','put');			# 更新信息
	    Route::rule('delete/<id>','Danwei/delete','delete');		# 删除信息
	    Route::rule('status','Danwei/setStatus','post');		# 删除信息
	    Route::rule('upload','Danwei/upload','post');		# 上传图片
	    Route::rule('createall','Danwei/createAll','get');				# 批量导入
	    Route::rule('saveall','Danwei/saveAll','post');					# 批量保存
	});



// 老师荣誉册管理
Route::group('jiaoshi', function () {
	    Route::rule('','Jiaoshi/index','get');						# 信息列表
	    Route::rule('data','Jiaoshi/ajaxdata','post');				# 获取数据
	    Route::rule('create','Jiaoshi/create','get');				# 添加信息
	    Route::rule('save','Jiaoshi/save','post');					# 保存信息
	    // Route::rule('read/<id>','Jiaoshi/read','get');				# 读取信息
	    Route::rule('edit/<id>','Jiaoshi/edit','get');				# 修改信息
	    Route::rule('update/<id>','Jiaoshi/update','put');			# 更新信息
	    Route::rule('delete/<id>','Jiaoshi/delete','delete');		# 删除信息
	    Route::rule('status','Jiaoshi/setStatus','post');		# 删除信息

	});



// 教师荣誉信息
Route::group('jsryinfo', function () {
	    Route::rule('','JsRongyuInfo/index','get');						# 信息列表
	    Route::rule('data','JsRongyuInfo/ajaxdata','post');				# 获取数据
	    Route::rule('create/<rongyuce>','JsRongyuInfo/create','get');				# 添加信息
	    Route::rule('save','JsRongyuInfo/save','post');					# 保存信息
	    // Route::rule('read/<id>','JsRongyuInfo/read','get');				# 读取信息
	    Route::rule('edit/<id>','JsRongyuInfo/edit','get');				# 修改信息
	    Route::rule('update/<id>','JsRongyuInfo/update','put');			# 更新信息
	    Route::rule('delete/<id>','JsRongyuInfo/delete','delete');		# 删除信息
	    Route::rule('status','JsRongyuInfo/setStatus','post');		# 删除信息
	    Route::rule('createall/<rongyuce>','JsRongyuInfo/createAll','get');				# 批量导入
	    Route::rule('saveall','JsRongyuInfo/saveAll','post');					# 批量保存
	    Route::rule('list/<rongyuce>','JsRongyuInfo/rongyuList','get');					# 批量保存


	});