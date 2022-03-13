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

// 类别管理
Route::group('index', function () {
	    Route::rule('', 'Index/index', 'get');						# 信息列表
	    Route::rule('data', 'Index/ajaxData', 'post');				# 获取数据
	    Route::rule('create', 'Index/create', 'get');				# 添加信息
	    Route::rule('save', 'Index/save', 'post');					# 保存信息
	    Route::rule('edit/<id>', 'Index/edit', 'get');				# 修改信息
	    Route::rule('update/<id>', 'Index/update', 'put');			# 更新信息
	    Route::rule('delete', 'Index/delete', 'delete');		# 删除信息
	    // Route::rule('status', 'Index/setStatus', 'post');		# 删除信息
	});
