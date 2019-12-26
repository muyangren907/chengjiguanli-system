<?php

// 性别
function srcSex($str)
{
	if($str == '男')
            {
                $sex = 1;
            }else if($str == '女'){
                $sex = 0;
            }else{
                $sex = 2;
            }
    return $sex;
}


// 查找学科
function srcSubject($str)
{
	// 实例化学科数据模型
	$subject = new \app\teach\model\Subject;

	// 查询学科id
	$subjectId = $subject->where('title',$str)->value('id');

	return $subjectId;
}

// 查找职务
function srcZw($str)
{
	// 实例化类型数据模型
	$category = new \app\system\model\Category;

	// 查询学科id
	$categoryId = $category->where('pid',107)->where('title',$str)->value('id');

	return $categoryId;
}


// 查找学历
function srcXl($str)
{
	// 实例化类型数据模型
	$category = new \app\system\model\Category;

	// 查询学科id
	$categoryId = $category->where('pid',105)->where('title',$str)->value('id');

	return $categoryId;
}

// 查找职称
function srcZc($str)
{
	// 实例化类型数据模型
	$category = new \app\system\model\Category;

	// 查询学科id
	$categoryId = $category->where('pid',106)->where('title',$str)->value('id');

	return $categoryId;
}



/**
* 将“一年级一班”格式的班级名转换成入学年和班级排序
* $str是原文件格式
* 返回班级ID
*/
function strBjmArray($str,$school)
{
	
	if(stristr($str,'年级',true)==false  || stristr($str,'班',true)==false)
	{
		$data = array('ruxuenian'=>'','paixu'=>'');
		return $data;
	}


	// 获取年级、班级列表
	$njlist = nianjiList();
	$bjlist = banjinamelist();

	$nj = substr($str,0,9);
	$bj = substr($str,9,strlen($str)-9);

	$nj = array_search($nj,$njlist);
	$bj = array_search($bj, $bjlist);


	// 查询班级id
	$banji = new \app\teach\model\Banji;
	$id = $banji->where('ruxuenian',$nj)
			->where('paixu',$bj)
			->where('school',$school)
			->value('id');

	return $id;
}