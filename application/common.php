<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

// 获取类别列表
function getCategory($id = '0')
{
	// 根据父级id查询类别列表
	$list = db('category')
		->where('pid','in',$id)
		->where('status',1)
		->field('id,title')
		->select();

	// 返回类别列表
	return $list;
}


// 获取类别名称
function getCategoryTitle($id)
{
	// 根据id查询类别名
	$value = db('category')
		->where('id',$id)
		->vlaue('title');
	// 返回类别名
	return $value;
}