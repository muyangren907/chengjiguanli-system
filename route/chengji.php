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

//系统设置路由
Route::resource('chengji','Chengji/Index');
Route::delete('chengji/:id/cj','chengji/Index/deletecj');  #只删除成绩
Route::get('chengji/malu','chengji/Index/malu');
Route::post('chengji/malu','chengji/Index/malusave');
Route::post('chengji/read','chengji/Index/read');
Route::get('chengji/biaolu','chengji/Index/biaolu');
Route::post('chengji/biaolu','chengji/Index/saveAll');
Route::get('chengji/:id/chengjilist','chengji/Index/chengjilist');
Route::get('chengji/:id/download','chengji/Index/download');
Route::post('chengji/chengjixls','chengji/Index/chengjixls');
 
Route::get('cjtongji/:id/nianji','chengji/Tongji/tjnianji');	# 年级成绩统计列表
Route::get('cjtongji/:id/downloadnj','chengji/Tongji/downloadnj');	# 年级成绩统计下载页面
Route::post('cjtongji/:id/downloadnj','chengji/Tongji/downloadxls');	# 年级成绩统计下载页面

Route::get('cjtongji/:id/school','chengji/Tongji/tjschool');	# 年级成绩统计列表




