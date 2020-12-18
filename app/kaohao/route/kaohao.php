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

// 考号管理
Route::group('index', function () {
    Route::rule('create/<kaoshi_id>', 'Index/create', 'get');						# 信息列表
    Route::rule('save', 'Index/save', 'post');					# 保存信息
    Route::rule('delete/<kaoshi_id>', 'Index/delete', 'delete');  # 成绩采集下载
    Route::rule('createall/<kaoshi_id>', 'Index/createAll', 'get');   # 信息列表
    Route::rule('saveall', 'Index/saveAll', 'post');					# 保存信息
    Route::rule('read/<id>', 'Index/read', 'get');             # 读取信息
});


// 考号管理
Route::group('excel', function () {
    Route::rule('biaoqian/<kaoshi_id>', 'Excel/biaoqian', 'get'); # 信息列表
    Route::rule('biaoqianxls', 'Excel/biaoqianXls', 'post');  # 信息列表
    Route::rule('caiji/<kaoshi_id>', 'Excel/caiji', 'get');   # 成绩采集下载页面
});
