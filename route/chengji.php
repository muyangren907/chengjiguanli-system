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
Route::get('chengji/:kaoshi/stuChengjilist','chengji/Index/index');
// Route::delete('chengji/:kaoshi/cj','chengji/Index/delete');  # 删除考试成绩
Route::get('readcjadd/:kaohao','chengji/Index/readAdd');  # 查看录入成绩人信息

// 成绩统计表
Route::get('cjtongji/:kaoshi/banji','chengji/Tongji/tjBanji');	# 班级成绩统计列表
Route::get('cjtongji/:kaoshi/nianji','chengji/Tongji/tjNianji');	# 年级成绩统计列表
Route::get('cjtongji/:kaoshi/yilucnt','chengji/Tongji/yiluCnt');	# 年级成绩统计列表

// 下载学生成绩
Route::get('chengji/:kaoshi/dwChengji','chengji/Index/dwChengji');
Route::post('chengji/dwChengji','chengji/Index/dwchengjixls'); 
 
// 下载班级成绩统计表
Route::get('cjtongji/:kaoshi/dwBanji','chengji/Tongji/dwBanji');	
Route::post('cjtongji/dwBanji','chengji/Tongji/dwBanjixls');	

// 下载年级成绩统计表
Route::get('cjtongji/:kaoshi/dwNianji','chengji/Tongji/dwNianji');	
Route::post('cjtongji/dwNanji','chengji/Tongji/dwNianjixls');





