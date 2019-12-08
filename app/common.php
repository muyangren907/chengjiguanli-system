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
	
	$category = new \app\system\model\Category;

	// 根据父级id查询类别列表
	$list = $category
		->where('pid',$id)
		->where('status',1)
		->field('id,title')
		->select();
		
	// 返回类别列表
	return $list;
}


// 获取类别名称
function getCategoryTitle($id)
{
	$category = new \app\system\model\Category;
	// 根据id查询类别名
	$value = $category
		->where('id',$id)
		->vlaue('title');
	// 返回类别名
	return $value;
}


function nianjiList($riqi=0)
{
	// 定义学年时间节点日期为每年的8月10日
	// $yd = '8-10';
	if($riqi == 0)
	{
		$jiedian = strtotime(date('Y').'-8-1');
		$thisday = time();
	}else{
		$jiedian = strtotime(date('Y',$riqi).'-8-1');
		$thisday = $riqi;
	}


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
					->column('id,title,jiancheng');

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
     * @param  array()
     *         str      $list['text']    文件分类标识
     *         str      $list['serurl']  文件存储位置
     *		   str      $list['oldname']  文件存储位置
     * @return \think\Response
     */
    function saveFileInfo($file,$list)
    {

    	

    	// 上传文件到本地服务器
        $savename = \think\facade\Filesystem::putFile($list['serurl'], $file);
        // 重新组合文件路径
        $savename = str_replace("/","\\",$savename);
        $savename = str_replace($list['serurl'].'\\', "", $savename);

        $a = config('filesystem.disks.public.root');
        $b = app()->getRootPath();
        dump($a);

        dump($file);

        // 获取文件信息
	    // $list['category'] = $file->fileExt();
	    $list['url'] = $savename;
	    $list['newname'] = $file->getFilename(); 
	    $list['hash'] = $file->hash('sha1');
	    $list['userid'] = session('userid');
	    $list['oldname'] = $list['oldname'];
	    $list['fieldsize'] = $file->getSize();
	    $list['text'] = $list['text'];
	    $list['bianjitime'] = $file->getMTime();
	    halt($list);

	    return $list;
    }



/**  
* 上传文件，并返回文件存储地址 
* 
* @access public 
* @param array $list 文件信息
* @param mixed $list['serurl'] 文件要存到哪儿  
* @param mixed $list[''] 文件要存到哪儿 
* @param mixed $file 文件 
* @param array $isSave 是否将文件信息保存到数据库 
* @return array 返回类型  数组
* @return msg string  提示
* @return val string  结果
* @return url string  如果保存到数据库，返回完整路径，否则保存部分路径。
*/  
function upload($list,$file,$isSave=false)
{
    // 声明默认目录
    $myrul = '..\public\uploads\\';

    // 实例化文件数据模型
    $field = new \app\system\model\Fields;


    // 移动到框架应用根目录/uploads/ 目录下
    $info = $file->move($myrul.$list['serurl']);


    // 如果上传成功
    if(!$info){
    	// 上传失败获取错误信息
        $data = array('msg'=>$file->getError(),'val'=>false,'url'=>null);
        return $data;
    }


    // 成功上传后 获取上传信息
    $list['category'] = $info->getExtension();
    $list['url'] = $list['serurl'].$info->getSaveName();
    $list['newname'] = $info->getFilename(); 
    $list['hash'] = $info->hash('sha1');
    $list['userid'] = session('userid');
    $list['oldname'] = $info->getInfo('name');
    $list['fieldsize'] = $info->getInfo('size');
    // $list['bianjitime'] = Null;

    
    // 如果需要保存文件 
    if($isSave == true){

	    //将文件信息保存
		$data = $field->create($list);

		if($data){
	        $data = array(
	            'msg'=>'上传成功'
	            ,'val'=>true
	            ,'url'=>$myrul.$list['serurl'].$info->getSaveName()
	        );
	    }else{
	        $data = array(
	            'msg'=>'保存文件信息失败'
	            ,'val'=>false
	        );
	    }
	}else{
		$data = array(
            'msg'=>'上传成功'
            ,'val'=>true
            ,'url'=>$info->getSaveName()
        );
	}

    

    // 返回信息
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
 * 根据考试ID值，判断考试是否已经结束
 * $kaoshiid 考试ID
 * 返回 $data 
 * */ 
function enddate($kaoshiid)
{
	$ks = new app\kaoshi\model\Kaoshi;
    $enddate = $ks->where('id',$kaoshiid)->value('enddate');

    $thistime = time();
    if($enddate<time())
    {
        $data = true;
    }else{
    	$data = false;
    }

    return $data;

}
