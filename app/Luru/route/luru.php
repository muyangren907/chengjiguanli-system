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

// 录入
Route::group('index', function () {
    Route::rule('malu', 'Index/malu', 'get');			# 扫码界面
    Route::rule('malusave', 'Index/malusave', 'put');		# 扫码保存
    Route::rule('read', 'Index/read', 'post');		# 扫码后读取成绩
    Route::rule('biaolu', 'Index/biaolu', 'get');					# 表格录入界面
    Route::rule('saveall', 'Index/saveAll', 'post');				# 保存表格录入信息
    Route::rule('edit/<id>', 'Index/edit', 'get');				# 修改信息
    Route::rule('update/<id>', 'Index/update', 'put');				# 更新信息
    Route::rule('index', 'Index/index', 'get');			# 成绩获取
    Route::rule('data', 'Index/ajaxData', 'post');			# 成绩获取
});

