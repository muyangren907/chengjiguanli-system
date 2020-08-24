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
Route::group('index', function () {
    Route::rule('index','Index/index','get');						# 信息列表
    Route::rule('welcome','Index/welcome','get');                       # 信息列表
    Route::rule('read/<kaohao_id>', 'Index/read', 'get');             # 读取信息
    Route::rule('editpassword','Index/editpassword','get');						# 信息列表
    Route::rule('updatepassword/<teacher_id>','Index/updatePassword','put');			# 信息列表
    Route::rule('banji','Index/banji','get');                       # 信息列表
    Route::rule('banjidata','Index/ajaxDataBanji','post');                # 获取数据
});
