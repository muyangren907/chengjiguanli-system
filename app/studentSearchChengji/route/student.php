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

// 学生管理
Route::group('index', function () {
    Route::rule('index','Index/index','get');						# 信息列表
    Route::rule('yibiao','Index/ajaxOneStudentChengjiYiBiao','post');						# 信息列表
    Route::rule('leida','Index/ajaxOneStudentChengjiLeiDa','post');						# 信息列表
    Route::rule('xkcj','Index/ajaxOneStudentSubjectChengji','post');						# 信息列表
    Route::rule('xkdfl','Index/ajaxOneStudentSubjectDefenlv','post');						# 信息列表
    Route::rule('xkwz','Index/ajaxOneStudentSubjectWeizhi','post');						# 信息列表
    Route::rule('oldcj','Index/ajaxOneStudentOldChengji','post');						# 信息列表
    Route::rule('editpassword','Index/editpassword','get');						# 信息列表
    Route::rule('updatepassword/<id>','Index/updatePassword','put');						# 信息列表

});
