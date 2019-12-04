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
Route::resource('/','chengji/Index');


// 扫码录入成绩
Route::get('chengji/malu','chengji/Index/malu');
Route::put('chengji/malu','chengji/Index/malusave');
Route::post('chengji/read','chengji/Index/read');
// 表格录入成绩
Route::get('chengji/biaolu','chengji/Index/biaolu');
Route::post('chengji/biaolu','chengji/Index/saveAll');
// 已录成绩统计
Route::get('cjtongji/:kaoshi/yilucnt','chengji/Tongji/yiluCnt');	# 年级成绩统计列表


// 获取学生成绩列表
Route::get('chengji/:kaoshi/stuChengjilist','chengji/Index/index');
// Route::delete('chengji/:kaoshi/cj','chengji/Index/delete');  # 删除考试成绩
Route::get('readcjadd/:kaohao','chengji/Index/readAdd');  # 查看录入成绩人信息
// 下载学生成绩
Route::get('chengji/:kaoshi/dwChengji','chengji/Index/dwChengji');
Route::post('chengji/dwChengji','chengji/Index/dwchengjixls'); 
// 批量删除学生成绩
Route::get('deletecjs/:kaoshi','chengji/Index/deletecjs');
Route::post('deletecjmore','chengji/Index/deletecjmore');



// 班级成绩统计表格
Route::get('bjtongji/:kaoshi/biaoge','chengji/Bjtongji/Biaoge');	# 班级成绩统计列表
// 下载班级成绩统计表格
Route::get('bjtongji/:kaoshi/dwBanji','chengji/Bjtongji/dwBanji');	
Route::post('bjtongji/dwBanji','chengji/Bjtongji/dwBanjixls');



// 年级成绩统计表格
Route::get('njtongji/:kaoshi/biaoge','chengji/Njtongji/Biaoge');	# 年级成绩统计列表
// 下载年级成绩统计表格
Route::get('njtongji/:kaoshi/dwNianji','chengji/Njtongji/dwNianji');	
Route::post('njtongji/dwNanji','chengji/Njtongji/dwNianjixls');



 
	







