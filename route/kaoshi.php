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
Route::get('kaoshi/:id/more','kaoshi/MoreAction/index');
Route::get('kaoshi/:id/kaohao','kaoshi/MoreAction/kaohao');
Route::post('kaoshi/kaohao','kaoshi/MoreAction/kaohaosave');
Route::get('kaoshi/:id/biaoqian','kaoshi/MoreAction/biaoqian');
Route::get('kaoshi/:id/caiji','kaoshi/MoreAction/caiji');
Route::post('kaoshi/caiji','kaoshi/MoreAction/cankaomingdan');



