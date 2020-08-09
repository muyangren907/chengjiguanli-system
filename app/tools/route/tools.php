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

// 教师管理
Route::group('kscy', function () {
    Route::rule('school','KsCanyu/school','post');    # 参与学科
    Route::rule('grade','KsCanyu/grade','post');    # 参与学科
    Route::rule('class','KsCanyu/class','post');    # 参与学科
    Route::rule('subject','KsCanyu/subject','post');    # 参与学科
});

// 教师管理
Route::group('file', function () {
    Route::rule('upload','File/upload','post');    # 上传文件
});

// 某个学生成绩
Route::group('onestudentchengji', function () {
    // Route::rule('data','OneStudentChengji/ajaxData','post');    # 上传文件
    Route::rule('oldcj','OneStudentChengji/ajaxOldChengji','post');    # 上传文件
    Route::rule('leida','OneStudentChengji/ajaxLeiDa','post');    # 上传文件
    Route::rule('yibiao','OneStudentChengji/ajaxYiBiao','post');    # 上传文件
    Route::rule('xkcj','OneStudentChengji/ajaxSubjectChengji','post');    # 上传文件
    Route::rule('xkdfl','OneStudentChengji/ajaxSubjectDeFenLv','post');    # 上传文件
    Route::rule('xkwz','OneStudentChengji/ajaxSubjectWeiZhi','post');    # 上传文件
    Route::rule('xkold','OneStudentChengji/ajaxOldSubject','post');    # 上传文件
});