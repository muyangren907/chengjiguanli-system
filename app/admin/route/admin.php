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

// 管理员管理
Route::group('index', function () {
    Route::rule('', 'Index/index', 'get');						# 信息列表
    Route::rule('data', 'Index/ajaxData', 'post');				# 获取数据
    Route::rule('create', 'Index/create', 'get');				# 添加信息
    Route::rule('save' ,'Index/save', 'post');					# 保存信息
    Route::rule('read/<id>', 'Index/read', 'get');				# 读取信息
    Route::rule('edit/<id>', 'Index/edit', 'get');				# 修改信息
    Route::rule('update/<id>', 'Index/update', 'put');			# 更新信息
    Route::rule('delete/<id>', 'Index/delete', 'delete');		# 删除信息
    Route::rule('status', 'Index/setStatus', 'post');		# 删除信息
    Route::rule('resetpassword/<id>', 'Index/resetPassword', 'post');		# 重置密码
    Route::rule('editpassword', 'Index/editPassword', 'get');		# 修改密码
    Route::rule('updatepassword/<id>', 'Index/updatePassword', 'put');		# 更新密码
    Route::rule('myinfo', 'Index/myInfo', 'get');		# 用户信息
    Route::rule('adminlist', 'Index/adminList', 'post');       # 用户信息
});


// 权限管理
Route::group('authrule', function () {
    Route::rule('', 'AuthRule/index', 'get');						# 信息列表
    Route::rule('data', 'AuthRule/ajaxData', 'post');				# 获取数据
    Route::rule('create', 'AuthRule/create', 'get');				# 添加信息
    Route::rule('save', 'AuthRule/save', 'post');					# 保存信息
    Route::rule('edit/<id>', 'AuthRule/edit', 'get');				# 修改信息
    Route::rule('update/<id>', 'AuthRule/update', 'put');			# 更新信息
    Route::rule('delete/<id>', 'AuthRule/delete', 'delete');		# 删除信息
    Route::rule('status', 'AuthRule/setStatus', 'post');		# 删除信息
    Route::rule('menu/<user_id>', 'AuthRule/menu', 'get');        # 删除信息
});


// 角色管理
Route::group('authgroup', function () {
    Route::rule('','AuthGroup/index','get');						# 信息列表
    Route::rule('data','AuthGroup/ajaxData','post');				# 获取数据
    Route::rule('create','AuthGroup/create','get');				# 添加信息
    Route::rule('save','AuthGroup/save','post');					# 保存信息
    Route::rule('edit/<id>','AuthGroup/edit','get');				# 修改信息
    Route::rule('update/<id>','AuthGroup/update','put');			# 更新信息
    Route::rule('delete/<id>','AuthGroup/delete','delete');		# 删除信息
    Route::rule('status','AuthGroup/setStatus','post');		# 删除信息
});


// 角色用户对应表
Route::group('authgroupaccess', function () {
    Route::rule('index/<group_id>','AuthGroupAccess/index','get');                        # 信息列表
    Route::rule('data','AuthGroupAccess/ajaxData','post');                # 获取数据
    Route::rule('create/<group_id>','AuthGroupAccess/create','get');             # 添加信息
    Route::rule('save','AuthGroupAccess/save','post');                    # 保存信息
    Route::rule('delete/<id>','AuthGroupAccess/delete','delete');     # 删除信息
});
