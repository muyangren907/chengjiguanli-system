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
		Route::rule('','Index/index','get');
		Route::rule('','Index/yanzheng','post');
		Route::rule('log','Index/shangmaLog','get');		# 配置更新
		Route::rule('err','Index/myerror','get');			//错误页
		Route::rule('weihu','Index/weihu','get');			//错误页
});

// 学生查询成绩登录
Route::group('student', function () {
		Route::rule('','Student/index','get');
		Route::rule('','Student/yanzheng','post');
});

// 学生查询成绩登录
Route::group('teacher', function () {
		Route::rule('','Teacher/index','get');
		Route::rule('','Teacher/yanzheng','post');
});

