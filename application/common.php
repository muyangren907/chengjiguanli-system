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


function nianjiList()
{
	// 定义学年时间节点日期为每年的8月10日
	// $yd = '8-10';
	$jiedian = strtotime(date('Y').'-8-10');

	$time = new think\helper\Time();

	$thisday = $time->today();

	if($thisday[0]<=$jiedian)
	{
		$str = 1;
	}else{
		$str = 0;
	}

	$nian = date('Y') - $str;

	$njlist = array();

	$njlist[$nian]='一年级';
	$njlist[$nian-1]='二年级';
	$njlist[$nian-2]='三年级';
	$njlist[$nian-3]='四年级';
	$njlist[$nian-4]='五年级';
	$njlist[$nian-5]='六年级';

	return $njlist;
}


// 班级列表
function banjinamelist()
{
	$bjarr = array(
		'1'=>'一班',
		'2'=>'二班',
		'3'=>'三班',
		'4'=>'四班',
		'5'=>'五班',
		'6'=>'六班',
		'7'=>'七班',
		'8'=>'八班',
		'9'=>'九班',
		'10'=>'十班',
		'11'=>'十一班',
		'12'=>'十二班',
		'13'=>'十三班',
		'14'=>'十四班',
		'15'=>'十五班',
	);

	return $bjarr;
}


/**
* $date是时间戳
* $type为1的时候是虚岁,2的时候是周岁
*/
function getAgeByBirth($date,$type = 1){
   $nowYear = date("Y",time());
   $nowMonth = date("m",time());
   $nowDay = date("d",time());
   $birthYear = date("Y",$date);
   $birthMonth = date("m",$date);
   $birthDay = date("d",$date);
   if($type == 1){
    $age = $nowYear - ($birthYear - 1);
   }elseif($type == 2){
    if($nowMonth<$birthMonth){
     $age = $nowYear - $birthYear - 1;
    }elseif($nowMonth==$birthMonth){
     if($nowDay<$birthDay){
      $age = $nowYear - $birthYear - 1;
     }else{
      $age = $nowYear - $birthYear;
     }
    }else{
     $age = $nowYear - $birthYear;
    }
   }
   return $age;
}
