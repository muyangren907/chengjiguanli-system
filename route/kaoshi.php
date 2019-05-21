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
Route::resource('kaoshi','kaoshi/Index');
Route::resource('kaohao','kaoshi/Kaohao');
// 考试更多操作
Route::get('kaoshi/:kaoshi/more','kaoshi/Index/moreAction');
// 考试设置保存
Route::get('kaoshiset/:id','kaoshi/Index/kaoshiset');
Route::put('kaoshiset/:id','kaoshi/Index/updateset');
// 考号保存
Route::get('kaoshi/:kaoshi/kaohao','kaoshi/Kaohao/index');
Route::post('kaoshi/kaohao','kaoshi/Kaohao/save');
// 下载成绩采集表
Route::get('kaoshi/:kaoshi/caiji','kaoshi/Kaohao/caiji');
Route::post('kaoshi/caiji','kaoshi/Kaohao/dwcaiji');
// 下载试卷标签
Route::get('kaoshi/:kaoshi/biaoqian','kaoshi/Kaohao/biaoqian');
Route::post('kaoshi/:kaoshi/biaoqianXls','kaoshi/Kaohao/biaoqianXls');



