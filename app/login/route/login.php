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


// 系统设置systembase
Route::group('', function () {
<<<<<<< HEAD
		Route::rule('','index/index','get');
		Route::rule('yz','index/yanzheng','post');
		Route::rule('log','index/shangmaLog','get');		# 配置更新
		Route::rule('err','index/myerror','get');			//错误页
=======
		Route::rule('','Index/index','get');
		Route::rule('','Index/yanzheng','post');
		Route::rule('log','Index/shangmaLog','get');		# 配置更新
		Route::rule('err','Index/myerror','get');			//错误页
>>>>>>> auth

});

