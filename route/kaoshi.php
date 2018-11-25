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
Route::get('kaoshi/:id/kaohao','kaoshi/Index/kaohao');
Route::post('kaoshi/kaohao','kaoshi/Index/kaohaosave');
Route::get('kaoshi/:id/biaoqian','kaoshi/Index/biaoqian');
Route::get('kaoshi/:id/caiji','kaoshi/Index/caiji');
Route::post('kaoshi/caiji','kaoshi/Index/cankaomingdan');



