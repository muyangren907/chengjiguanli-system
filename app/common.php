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
	function getCategory($p_id = 0)
	{
		// 查询类别
        $category = new \app\system\model\Category;
        $list = $category->srcChild($p_id);

		// 返回类别列表
		return $list;
	}


	function nianJiNameList($riqi=0)
	{
		// 实例化年级控制器
        $bj = new \app\teach\model\Banji;
        $njList= $bj->gradeName($riqi);
		return $njList;
	}


	// 班级列表
	function banJiNamelist()
	{
		// 实例化年级控制器
        $bj = new \app\tools\controller\Banji;
        $njList= $bj->banJiNamelist();
        return $njList;
	}


	/**
	* $date是时间戳
	* $type为1的时候是虚岁,2的时候是周岁
	*/
	function getAgeByBirth($date = 0, $type = 1){
        $tearch = new \app\teacher\model\Tearcher;
        $age = $tearch->fBirth($data, $type);
	   return $age;
	}


	// EXCEL表格列名
	function excelColumnName()
	{
		$excel = new \app\tools\controller\Excel;
        $data = $excel->excelColumnName();
        return $data;
	}


	// 单位列表
	function schoolList($low = '班级', $high = '其它级', $order = 'asc')
	{
		// 实例化单位模型
		$sch = new \app\system\model\School;
		$data = $sch->srcJibie($low, $high, $order);
		return $data;
	}


    // 可以组织考试的单位列表
    function kaoshiSchoolList()
    {
        // 实例化单位模型
        $sch = new \app\system\model\School;
        $schlist = $sch->kaoshi();
        return $schlist;
    }


	// // 整理教师名
	// function teacherNames($list = array())
	// {
	// 	if(count($list) == 0 )
	// 	{
	// 		return '';
	// 	}

	// 	$names = '';
	// 	foreach ($list as $key => $value) {
	// 		if($key == 0)
	// 		{
	// 			$names = $value['teacher']['xingming'];
	// 		}else{
	// 			$names = $names . '、'. $value['teacher']['xingming'];
	// 		}
	// 	}

	// 	return $names;
	// }


    // 给数组按多条件排序
    function sortArrByManyField(){
      $args = func_get_args();
      $tools = new \app\tools\controller\Index;
      $arr = $tools->sortArrByManyField($args);
      return $arr;
    }


    /**
     * 根据键值，用数组2的值替换数组1的值
     * $cover 覆盖数组，存储新值的数组
     * $covered 被覆盖数组，被更改值的数组
     * 返回 新arr1
     * */
    function array_cover($cover = array(), $covered = array())
    {
    	$tools = new \app\tools\controller\Index;
        $arr = $tools->array_cover($cover, $covered);
    	return $arr;
    }
    

    /**
     * 获取参加考试的学科
     * 返回 $data
     * */
    function subjectList()
    {
        $sbj = new \app\teach\model\Subject;
        $data = $sbj->kaoshi();

        return $data;
    }


    /**
    * 把request到的参数转换成数组，并删除空值
    *
    * @access public
    * @param str或array $str 表单中获取的参数
    * @return array 返回类型
    */
    function strToArray($str)
    {
    	$tools = new \app\tools\controller\Index;
        $data = $tools->strToArray($str);
        return $data;
    }


    /**
    * 把重新整理从数据模型中返回的对象
    * @access public
    * @param str或array $str 表单中获取的参数
    * @return array 返回类型
    */
    function reSetObject($obj, $srcfrom)
    {
        $tools = new \app\tools\controller\Index;
        $data = $tools->reSetObject($obj, $srcfrom);
        return $data;
    }


    /**
    * 把重新整理从数据模型中返回的对象
    * @access public
    * @param str或array $str 表单中获取的参数
    * @return array 返回类型
    */
    function reSetArray($arr, $srcfrom)
    {
        $tools = new \app\tools\controller\Index;
        $data = $tools->reSetArray($arr, $srcfrom);
        return $data;
    }
