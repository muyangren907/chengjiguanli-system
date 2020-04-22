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
Route::group('admin', function () {
	    Route::rule('index','admin/index','get');                      # 信息列表
        Route::rule('admin','admin/admin','get');                      # 信息列表
        Route::rule('banji','admin/banji','get');                      # 信息列表
        Route::rule('chengji','admin/chengji','get');                      # 信息列表
        Route::rule('dwrongyu','admin/dwrongyu','get');                      # 信息列表
        Route::rule('dwrongyucanyu','admin/dwrongyucanyu','get');                      # 信息列表
        Route::rule('fields','admin/fields','get');                      # 信息列表
        Route::rule('jsrongyu','admin/jsrongyu','get');                      # 信息列表
        Route::rule('jsrongyucanyu','admin/jsrongyucanyu','get');                      # 信息列表
        Route::rule('jsrongyuinfo','admin/jsrongyuinfo','get');                      # 信息列表
        Route::rule('kaohao/<page>','admin/kaohao','get');                      # 信息列表
        Route::rule('kaoshi','admin/kaoshi','get');                      # 信息列表
        Route::rule('keti','admin/keti','get');                      # 信息列表
        Route::rule('keticanyu','admin/keticanyu','get');                      # 信息列表
        Route::rule('ketiinfo','admin/ketiinfo','get');                      # 信息列表
        Route::rule('school','admin/school','get');                      # 信息列表
        Route::rule('student/<page>','admin/student','get');                      # 信息列表
        Route::rule('teacher/<page>','admin/teacher','get');                      # 信息列表
        Route::rule('xueqi','admin/xueqi','get');                      # 信息列表
	});

