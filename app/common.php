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
	function categoryChildren($p_id = 0)
	{
		// 查询类别
        $category = new \app\system\model\Category;
        $list = $category->srcChild($p_id);
		// 返回类别列表
		return $list;
	}


	function nianJiNameList($value = 'str', $riqi = 0)
	{
		// 实例化年级控制器
        $bj = new \app\teach\model\Banji;
        $njList= $bj->gradeName($value, $riqi);
		return $njList;
	}


	// 班级列表
	function banJiNamelist()
	{
		// 实例化年级控制器
        $bj = new \app\teach\model\Banji;
        $njList= $bj->banJiNamelist();
        return $njList;
	}

	// 单位列表
	function danweiJibie($low = '班级', $high = '其它级', $order = 'asc')
	{
		// 实例化单位模型
		$sch = new \app\system\model\School;
		$data = $sch->srcJibie($low, $high, $order);
		return $data;
	}


    // // 单位列表
    // function schoolXueduan($low = '幼儿园', $high = '其它学段', $order = 'asc')
    // {
    //     // 实例化单位模型
    //     $sch = new \app\system\model\School;
    //     $data = $sch->srcSchool($low, $high, $order);
    //     return $data;
    // }


    // //  获取单位列表
    // function srcSchool($src)
    // {
    //     // 实例化单位模型
    //     $sch = new \app\system\model\School;
    //     $data = $sch->srcSchool($low, $high, $order);
    //     return $data;
    // }


    // 可以组织考试的单位列表
    function kaoshiSchoolList()
    {
        // 实例化单位模型
        $sch = new \app\system\model\School;
        $schlist = $sch->kaoshi();
        return $schlist;
    }


	// 整理教师名
	function teacherNames($list = array())
	{
		if (count($list) == 0) {
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


    /*
     * 根据键值，用数组2的值替换数组1的值
     * $cover 覆盖数组，存储新值的数组
     * $covered 被覆盖数组，被更改值的数组
     * 返回 新arr1
     */
    function array_cover($cover = array(), $covered = array())
    {
        $arr = \app\facade\Tools::array_cover($cover, $covered);
    	return $arr;
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
        $data = \app\facade\Tools::strToArray($str);
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
        $data = \app\facade\Tools::reSetObject($obj, $srcfrom);
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
        $data = \app\facade\Tools::reSetArray($arr, $srcfrom);
        return $data;
    }


    // 定义EXCEL列名
    function excelColumnName()
    {
        $liemingarr = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ','BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW'];
        return $liemingarr;
    }


    // 多字段排序
    function sortArrByManyField($arr, $srcfrom)
    {
        $data = \app\facade\Tools::sortArrByManyField($arr, $srcfrom);
        return $data;
    }


    // 学科列表
    function subjectKaoshiList()
    {
        $sbj = new \app\teach\model\Subject;
        $subject = $sbj->kaoshi();
        return $subject;
    }
