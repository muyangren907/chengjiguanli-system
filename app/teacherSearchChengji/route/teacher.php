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
    Route::rule('updatepassword/<teacher_id>','Index/updatePassword','put');		# 信息列表
    Route::rule('banji','Index/banji','get');                       # 信息列表
    Route::rule('banjidata','Index/ajaxDataBanji','post');          # 获取数据

    Route::rule('detail/<bjtj_id>','Index/detail','get');			# 信息列表
    Route::rule('detaildata','Index/ajaxDataDetail','post');		# 信息列表

    Route::rule('rongyu','Index/rongyu','get');           # 信息列表
    Route::rule('keti','Index/keti','get');           # 信息列表
});

// 考试管理
Route::group('kaoshi', function () {
    Route::rule('','Kaoshi/index','get');                        # 信息列表
    Route::rule('data','Kaoshi/ajaxData','post');                # 获取数据
    Route::rule('create','Kaoshi/create','get');             # 添加信息
    Route::rule('save','Kaoshi/save','post');                    # 保存信息
    Route::rule('edit/<id>','Kaoshi/edit','get');                # 修改信息
    Route::rule('update/<id>','Kaoshi/update','put');            # 更新信息
    Route::rule('delete/<id>','Kaoshi/delete','delete');     # 删除信息
    Route::rule('status','Kaoshi/setStatus','post');     # 删除信息
    Route::rule('more/<kaoshi_id>','Kaoshi/moreAction','get');               # 修改信息
    Route::rule('luru','Kaoshi/luru','post');     # 考试编辑状态设置
});


// 考试设置
Route::group('kaoshiset', function () {
    Route::rule('index/<kaoshi_id>','KaoshiSet/index','get');                       # 信息列表
    Route::rule('data','KaoshiSet/ajaxdata','post');                # 获取数据
    Route::rule('create/<kaoshi_id>','KaoshiSet/create','get');     # 添加信息
    Route::rule('save','KaoshiSet/save','post');                    # 保存信息
    Route::rule('edit/<id>','KaoshiSet/edit','get');                # 修改信息
    Route::rule('update/<id>','KaoshiSet/update','put');            # 更新信息
    Route::rule('delete/<id>','KaoshiSet/delete','delete');     # 删除信息
    Route::rule('status','KaoshiSet/setStatus','post');     # 修改状态
});


// 考试设置
Route::group('tjlog', function () {
    Route::rule('index/<kaoshi_id>','TongjiLog/index','get');
    Route::rule('data','TongjiLog/ajaxData','post');
});
