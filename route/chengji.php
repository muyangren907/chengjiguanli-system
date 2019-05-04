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


// 扫码录入成绩
Route::get('chengji/malu','chengji/Index/malu');
Route::put('chengji/malu','chengji/Index/malusave');
Route::post('chengji/read','chengji/Index/read');
// 表格录入成绩
Route::get('chengji/biaolu','chengji/Index/biaolu');
Route::post('chengji/biaolu','chengji/Index/saveAll');
// 获取学生成绩列表
Route::get('chengji/:id/stuChengjilist','chengji/Index/index');
Route::delete('chengji/:id/cj','chengji/Index/deletecj');  #只清空成绩
Route::get('cjtongji/:id/banji','chengji/Tongji/tjBanji');	# 班级成绩统计列表
Route::get('cjtongji/:id/nianji','chengji/Tongji/tjNianji');	# 年级成绩统计列表

// 下载学生成绩
Route::get('chengji/:id/dwChengji','chengji/Index/dwChengji');
Route::post('chengji/dwChengji','chengji/Index/dwchengjixls');
 
// 下载班级成绩统计表
Route::get('cjtongji/:id/dwBanji','chengji/Tongji/dwBanji');	
Route::post('cjtongji/:id/dwBanji','chengji/Tongji/dwBanjixls');	

// 下载年级成绩统计表
Route::get('cjtongji/:id/dwNianji','chengji/Tongji/dwNianji');	
Route::post('cjtongji/:id/dwNanji','chengji/Tongji/dwNianjixls');




