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
function getCategory($str = 0)
{

	$category = new \app\system\model\Category;

	// 如果参数格式不为数字的时候查询$pid
	if(is_numeric($str) == false)
	{
		// 根据父级id查询类别列表
		$str = $category
			->where('title',$str)
			->value('id');
	}


	$str == '' || $str == null ? $str=0 :$str=$str;


	// 根据父级id查询类别列表
	$list = $category
		->where('pid',$str)
		->where('status',1)
		->field('id,title')
		// ->fetchSql(true)
		->select();

	
	// 返回类别列表
	return $list;
}


function nianjiList($riqi=0)
{
	// 定义学年时间节点日期为每年的8月1日
	// $yd = '8-1';
	if($riqi == 0)
	{
		$jiedian = strtotime(date('Y').'-8-1');
		$thisday = time();
	}else{
		$jiedian = strtotime(date('Y',$riqi).'-8-1');
		$thisday = $riqi;
	}


	if($thisday<=$jiedian)
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
		'16'=>'十六班',
		'17'=>'十七班',
		'18'=>'十八班',
		'19'=>'十九班',
		'20'=>'二十班',
		'21'=>'二十一班',
		'22'=>'二十二班',
		'23'=>'二十三班',
		'24'=>'二十四班',
		'25'=>'二十五班',
	);

	return $bjarr;
}




/**
* $date是时间戳
* $type为1的时候是虚岁,2的时候是周岁
*/
function getAgeByBirth($date = 0,$type = 1){
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


// EXCEL表格列名
function excelLieming()
{
	$liemingarr = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF'];
	return $liemingarr;
}



// 单位列表
function schlist($low='班级',$high='其它级',$xueduan=array())
{

	// 实例化单位模型
	$sch = new \app\system\model\School;
	// 实例化类别数据模型
	$cat = new \app\system\model\Category;
	// 获取获取级别列表
	$catlist = $cat->where('pid',102)
		->where('status',1)
		->column('id','title');

	// 获取学段列表
	if(count($xueduan)>0){
		$xdlist = $cat->where('pid',103)
			->where('status',1)
			->where('title','in',$xueduan)
			->column('id');
	}else{
		$xdlist = $cat->where('pid',103)
			->where('status',1)
			->column('id');
	}


	// 查询学校
	$schlist = $sch->where('jibie','between',[$catlist[$low],$catlist[$high]])
					->where('status',1)
					->where('xueduan','in',$xdlist)
					->order(['paixu'])
					->field('id,title,jiancheng')
					->select();

	return $schlist;
}


// 整理教师名
function teacherNames($list = array())
{
	if(count($list) == 0 )
	{
		return '';
	}


	$names = '';
	foreach ($list as $key => $value) {
		if($key == 0)
		{
			$names = $value['teacher']['xingming'];
		}else{
			$names = $names . '、'. $value['teacher']['xingming'];
		}
	}

	return $names;
}




/**
     * 获取文件信息并保存
     *
     * @param  file对象  $file
     * @param  array()  $list 文件信息
     *         str      $list['text']    文件分类标识
     *         str      $list['serurl']  文件存储位置
     *         file     $file  文件对象
     * @return array  $data
     *         str      $data['msg']  返回信息提示
     *         str      $data['val']  返回信息
     *         str      $data['url']  文件路径
     */
    function saveFileInfo($file,$list,$isSave=false)
    {
    	$hash = $file->hash('sha1');
    	$f = new \app\system\model\Fields;
    	$serFile = $f::where('hash',$hash)->find();
    	if($serFile)
    	{
    		$data['msg'] = '文件已经存在';
    		$data['val'] = true;
    		$data['url'] = $serFile->url;
    		return $data;
    	}

    	// 上传文件到本地服务器
        $savename = \think\facade\Filesystem::disk('public')->putFile($list['serurl'], $file);
        // 重新组合文件路径
        $savename = str_replace("/","\\",$savename);

	    if($isSave==true){
	    	$list['url'] = $savename;
		    $list['newname'] = substr($savename,strripos($savename,'\\')+1,strlen($savename)-strripos($savename,'\\')); 
		    $list['hash'] = $file->hash('sha1');
		    $list['userid'] = session('userid');
		    $list['oldname'] = $file->getOriginalName();
		    $list['fieldsize'] = $file->getSize();
		    $list['category'] = $list['category'];
		    $list['bianjitime'] = $file->getMTime();
		    $list['extension'] = $file->getOriginalExtension();
		    
	    	$saveinfo = $f::create($list);
	    }
	    

		$data['msg'] = '上传成功';
    	$data['val'] = true;
    	$data['url'] = $savename;
	    
	    return $data;
    }





/**
 * 数组重新排序
 * $array 要排序的数组
 * $field 排序字段
 * $sort 排序方式 SORT_DESC 降序；SORT_ASC 升序
 * */
function arraySequence($data, $field = 'id', $sort = 'desc') {
	// 排序方式
	$sort == 'desc' ? $sort = SORT_DESC : $sort = SORT_ASC;
	// 获取参考列
	$column = array_column($data, $field);
	// 排序
	array_multisort($column, $sort, $data);

	return $data;
}




/**
 * 根据键值，用数组2的值替换数组1的值
 * $cover 覆盖数组，存储新值的数组
 * $covered 被覆盖数组，被更改值的数组
 * 返回 新arr1
 * */
function array_cover( $cover = array(), $covered = array() )
{
	foreach ($cover as $key => $value) {
		if(isset($covered[$key]) == true)
		{
			$covered[$key] = $cover[$key];
		}
	}
	return $covered;
}


/**
 * 根据考试ID值，判断考试开始或者结束时间是否已过
 * $kaoshiid 考试ID
 * $str      统计项目
 * 返回 $data 
 * */ 
function kaoshiDate($kaoshiid,$str='enddate')
{
	$ks = new app\kaoshi\model\Kaoshi;
    $enddate = $ks->where('id',$kaoshiid)->value('enddate');

    $thistime = time();
    if( $thistime > $enddate )
    {
        $data = true;
    }else{
    	$data = false;
    }
    return $data;
}



/**
 * 获取参加考试的学科
 * 返回 $data 
 * */ 
function subjectList()
{
	$sbj = new \app\teach\model\Subject;
	$data = $sbj::where('status',1)
                    ->where('kaoshi',1)
                    ->field('id,title,jiancheng,lieming')
                    ->select();
    return $data;
}


/**  
    * 把request到的参数转换成数组，并删除空值 
    * 
    * @access public 
    * @param str或array $str 表单中获取的参数 
    * @return array 返回类型
    */ 
function strToarray($str)
{
	// 如果str是字符串，则转换成数组
	if(is_array($str)==false)
	{
		$str = explode(',', $str);
	}
	// 循环数组，删除空元素
	foreach ($str as $key => $value) {
		if($value == "" && $value == null){
			unset($str[$key]);
		}
	}
	return $str;
}



/**  
    * 下载文件 
    * 
    * @access public 
    * @param $url  文件地址 
    * @param $newname    新文件名 
    * @return array 返回类型
    */ 
function smDownload($url,$newname='')
{
	$file = $url;

	if(strlen($newname)==0)
	{
		$newname = filesize($file);
	}


	if (file_exists($file)) { 
		header('Content-Description: File Transfer'); 
		header('Content-Type: application/octet-stream'); 
		header('Content-Disposition: attachment; filename='.$newname); 
		header('Content-Transfer-Encoding: binary'); 
		header('Expires: 0'); 
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0'); 
		header('Pragma: public'); 
		header('Content-Length: ' . filesize($file)); 
		ob_clean(); 
		flush(); 
		readfile($file); 
		exit;
	}

	return true;
} 






