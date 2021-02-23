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
Route::group('index', function () {
    Route::rule('index','Index/index','get');						# 信息列表
    Route::rule('data','Index/ajaxdata','post');				# 获取数据
    Route::rule('create','Index/create','get');				# 添加信息
    Route::rule('save','Index/save','post');					# 保存信息
    Route::rule('read/<id>','Index/read','get');				# 读取信息
    Route::rule('edit/<id>','Index/edit','get');				# 修改信息
    Route::rule('update/<id>','Index/update','put');			# 更新信息
    Route::rule('delete/<id>','Index/delete','delete');		# 删除信息
    Route::rule('status','Index/setStatus','post');		# 删除信息
    Route::rule('createall','Index/createAll','get');				# 批量导入
    Route::rule('saveall','Index/saveAll','post');					# 批量保存
    Route::rule('upload','Index/upload','post');				# 批量导入
    Route::rule('srcteacher','Index/srcTeacher','post');		# 查询教师
    Route::rule('downloadxls','Index/downloadXls','get');		# 下载模板
    Route::rule('srcry','Index/srcRy','post');		# 查询荣誉
    Route::rule('srckt','Index/srcKt','post');		# 查询课题
    Route::rule('dellist','Index/delList','get');						# 信息列表
    Route::rule('datadel','Index/ajaxDataDel','post');				# 获取数据
    Route::rule('redel/<id>','Index/reDel','delete');		# 获取学生成绩
    Route::rule('resetpassword/<id>','Index/resetpassword','post');       # 重置教师密码

    Route::rule('tongbu','Index/tongbu','get');             # 添加信息
});
