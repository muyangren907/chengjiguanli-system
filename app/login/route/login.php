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

// Route::rule('/','index/index','get');
// Route::rule('/','index/yanzheng','post');
// Route::rule('log','index/shangmaLog','get');		# 配置更新
// Route::rule('myerror','index/myerror','get');			//错误页

// 系统设置systembase
Route::group('', function () {
		Route::rule('','index/index','get');
		Route::rule('yz','index/yanzheng','post');
		Route::rule('log','index/shangmaLog','get');		# 配置更新
		Route::rule('err','index/myerror','get');			//错误页

});

