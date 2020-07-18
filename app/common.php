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
		// 定义学年时间节点日期为每年的8月1日
		// $yd = '8-1';
		if($riqi == 0)
		{
			$jiedian = strtotime(date('Y') . '-8-1');
			$thisday = time();
			$nian = date('Y');
		}else{
			$jiedian = strtotime(date('Y', $riqi) . '-8-1');
			$thisday = $riqi;
			$nian = date('Y', $riqi);
		}

		$thisday <= $jiedian ? $str = 1 : $str = 0;
		$nian = $nian - $str;

		$njlist = array();
		$njlist[$nian] = '一年级';
		$njlist[$nian - 1] = '二年级';
		$njlist[$nian - 2] = '三年级';
		$njlist[$nian - 3] = '四年级';
		$njlist[$nian - 4] = '五年级';
		$njlist[$nian - 5] = '六年级';

		return $njlist;
	}


	// 班级列表
	function banJiNamelist()
	{
		$banji = new \app\teach\model\Banji;
        $max = $banji->where('status', 1)->max('paixu');
        $cnfMax = config('shangma.classmax');
        $cnt = 0;
        $max > $cnfMax ? $cnt = $max : $cnt = $cnfMax;

        $bjarr = array();
        for($i = 1; $i <= $cnt; $i++)
        {
            $bjarr[$i] = numToWord($i) . '班';
        }
        return $bjarr;

        $cnfMax = config('shangma.classmax');
        $bjarr = array();
        for($i = 1; $i <= $cnfMax; $i++)
        {
            $bjarr[$i] = numToWord($i) . '班';
        }
		return $bjarr;
	}


	/**
	* $date是时间戳
	* $type为1的时候是虚岁,2的时候是周岁
	*/
	function getAgeByBirth($date = 0, $type = 1){
        $nowYear = date("Y", time());
        $nowMonth = date("m", time());
        $nowDay = date("d", time());
        $birthYear = date("Y", $date);
        $birthMonth = date("m", $date);
        $birthDay = date("d", $date);
        if($type == 1){
            $age = $nowYear - ($birthYear - 1);
        }elseif($type == 2){
            if($nowMonth < $birthMonth){
                $age = $nowYear - $birthYear - 1;
            }elseif($nowMonth == $birthMonth){
                if($nowDay < $birthDay){
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
	function excelColumnName()
	{
		$liemingarr = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ','BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW'];
		return $liemingarr;
	}


	// 单位列表
	function schoolList($low = '班级', $high = '其它级', $order = 'asc')
	{
		// 实例化单位模型
		$sch = new \app\system\model\School;
		// 实例化类别数据模型
		$cat = new \app\system\model\Category;
		// 获取获取级别列表
		$catlist = $cat->where('p_id', 102)
			->where('status', 1)
			->column('id', 'title');

		// 查询学校
		$schlist = $sch->where('jibie_id', 'between', [$catlist[$low], $catlist[$high]])
            ->where('status', 1)
			->order(['jibie_id'=>$order,'paixu'])
			->field('id, title, jiancheng')
			->select();

		return $schlist;
	}


    // 可以组织考试的单位列表
    function kaoshiSchoolList()
    {
        // 实例化单位模型
        $sch = new \app\system\model\School;
        $schlist = $sch->where('status&kaoshi', 1)
            ->order(['paixu'])
            ->field('id, title, jiancheng')
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
    function saveFileInfo($file, $list, $isSave = false)
    {
    	$hash = $file->hash('sha1');
    	$f = new \app\system\model\Fields;
    	$serFile = $f::where('hash', $hash)->find();

    	if($serFile)
    	{
    		$serFile->user_id = session('userid');
            $serFile->save();
            $data['msg'] = '文件已经存在';
    		$data['val'] = true;
    		$data['url'] = $serFile->url;
    		return $data;
    	}

    	// 上传文件到本地服务器
        $savename = \think\facade\Filesystem::disk('public')
            ->putFile($list['serurl'], $file);
        // 重新组合文件路径
        $savename = str_replace("/", "\\", $savename);

	    if($isSave==true){
	    	$list['url'] = $savename;
		    $list['newname'] = substr($savename
                ,strripos($savename, '\\') + 1
                ,strlen($savename) - strripos($savename
                ,'\\'));
		    $list['hash'] = $file->hash('sha1');
		    $list['user_id'] = session('userid');
		    $list['oldname'] = $file->getOriginalName();
		    $list['fieldsize'] = $file->getSize();
		    $list['category_id'] = $list['category_id'];
		    $list['bianjitime'] = $file->getMTime();
		    $list['extension'] = $file->getOriginalExtension();

	    	$saveinfo = $f::create($list);
	    }

		$data['msg'] = '上传成功';
    	$data['val'] = true;
    	$data['url'] = $savename;

	    return $data;
    }


    // 给数组按多条件排序
    function sortArrByManyField(){
      $args = func_get_args();
      if(empty($args)){
        return null;
      }
      $arr = array_shift($args);
      if(!is_array($arr)){
        throw new Exception("第一个参数不为数组");
      }

      foreach($args as $key => $field){
        if(is_string($field)){
          $temp = array();
          foreach($arr as $index => $val){
            $temp[$index] = $val[$field];
          }
          $args[$key] = $temp;
        }
      }
      $args[] = &$arr;//引用值
      $keys = array_keys($args[0]);
      call_user_func_array('array_multisort', $args);

      return array_pop($args);;
    }


    /**
     * 根据键值，用数组2的值替换数组1的值
     * $cover 覆盖数组，存储新值的数组
     * $covered 被覆盖数组，被更改值的数组
     * 返回 新arr1
     * */
    function array_cover($cover = array(), $covered = array())
    {
    	foreach ($cover as $key => $value) {
    		if(isset($covered[$key]) == true)
    		{
    			$covered[$key] = $cover[$key];
    		}
    	}
    	return $covered;
    }


    // /**
    //  * 根据考试ID值，判断考试开始或者结束时间是否已过
    //  * $kaoshiid 考试ID
    //  * $str      统计项目
    //  * 返回 $data
    //  * */
    // function kaoShiDate($kaoshiid, $str='enddate')
    // {
    // 	$ks = new app\kaoshi\model\Kaoshi;
    //     $enddate = $ks->where('id', $kaoshiid)
    //         ->value($str);

    //     $thistime = time();
    //     if( $thistime > $enddate )
    //     {
    //         $data = true;
    //     }else{
    //     	$data = false;
    //     }
    //     return $data;
    // }


    /**
     * 获取参加考试的学科
     * 返回 $data
     * */
    function subjectList($status = '', $kaoshi = '')
    {
    	$src = [
            'status' => $status
            ,'kaoshi' => $kaoshi
        ];

        $sbj = new \app\teach\model\Subject;
        $data = $sbj->search($src);

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
    	// 如果str是字符串，则转换成数组
    	if(is_array($str) == false)
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
    * 把重新整理从数据模型中返回的对象
    * @access public
    * @param str或array $str 表单中获取的参数
    * @return array 返回类型
    */
    function reSetObject($obj, $srcfrom)
    {
        // 整理变量
        $src = [
            'field' => 'update_time'
            ,'order' => 'desc'
            ,'page' => 1
            ,'limit' => 10
        ];
        $src = array_cover($srcfrom, $src) ;
        $str1 = $src['field'];
        $str2 = $src['order'];

        // 整理数据
        $cnt = $obj->count();
        $obj = $obj->order($src['field'], $src['order']);

        $limit_start = $src['page'] * $src['limit'] - $src['limit'];
        $limit_length = $src['limit'];
        $obj = $obj->slice($limit_start, $limit_length);
        $data = [
            'code' => 0  // ajax请求次数，作为标识符
            ,'msg' => ""  // 获取到的结果数(每页显示数量)
            ,'count' => $cnt // 符合条件的总数据量
            ,'data' => $obj //获取到的数据结果
        ];

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
        // 整理变量
        $src = [
            'field' => 'update_time'
            ,'order' => 'desc'
            ,'page' => 1
            ,'limit' => 10
        ];
        $src = array_cover($srcfrom, $src) ;

        // 重新整理数据
        $cnt = count($arr);    # 记录总数
        if($cnt > 0){
            $src['order'] == 'desc' ? $src['order'] = SORT_DESC
                : $src['order'] = SORT_ASC;   # 数据排序
            $arr = sortArrByManyField($arr, $src['field'], $src['order']);
        }
        $limit_start = $src['page'] * $src['limit'] - $src['limit']; # 获取当前页数据
        $limit_length = $src['limit'];
        $arr = array_slice($arr, $limit_start, $limit_length);
        $data = [   # 数据合并
            'code' => 0 , # ajax请求次数，作为标识符
            'msg' => "",  # 获取到的结果数(每页显示数量)
            'count' => $cnt, # 符合条件的总数据量
            'data' => $arr, # 获取到的数据结果
        ];

        return $data;
    }


    function numToWord($num)
    {
        if(!preg_match("/^[1-9][0-9]*$/", $num))
        {
            return '';
        }
        $chiUni = array('', '万', '亿', '万');
        $cnt = strlen($num);  #取数字长度
        $num = (string)$num;
        $chiStr = '';

        //分割数组
        $x = 0;
        $y = 0;
        for ($i=$cnt - 1; $i >= 0; $i--) {
            if($x<4)
            {
                $arr[$y][$x] = $num[$i];
            }else{
                $x = 0;
                $y = $y + 1;
                $arr[$y][$x] = $num[$i];
            }
            $x = $x + 1;
        }

        foreach ($arr as $key => $value) {
            // 判断有几位数
            $cnt = count($value);
            $thisStr = numTo($value, $key);

            if($thisStr == '零')
            {
                $chiStr = numTo($value, $key) . $chiStr;
            }else{
                $chiStr = numTo($value, $key) . $chiUni[$key] . $chiStr;
            }
        }
        $chiStr = str_replace("零零", "零", $chiStr);
        return $chiStr;
    }


    function numTo($arr = array(), $key = 0)
    {
        $cnt = count($arr);
        $chiNum = array('零', '一', '二', '三', '四', '五', '六', '七', '八', '九');
        $chiUni = array('','十', '百', '千');
        $chiStr = '';
        $zero = true;  # 上一个数字是否为0
        $key = $key * 4;
        if($cnt == 0 || array_sum($arr) == 0)
        {
            return $chiNum[0];
        }
        switch ($cnt) {
            case 2:
                $temp = $arr[1];
                if($temp == 1)
                {
                    $chiStr = $chiUni[1];
                }else{
                    $chiStr = $chiNum[$temp] . $chiUni[1];
                }
                $temp = $arr[0];
                $temp != 0 ? $chiStr = $chiStr . $chiNum[$temp] : '' ;
                break;
            default:
                for($i = 0; $i<$cnt; $i++)
                {
                    $temp = $arr[$i];
                    if($temp == 0)
                    {
                        if($zero != true)
                        {
                            $chiStr = $chiNum[$temp] .$chiStr;
                        }
                        $zero = true;
                    }else{
                        $chiStr = $chiNum[$temp] . $chiUni[$i] .$chiStr;
                        $zero = false;
                    }
                }
                break;
        }
        return $chiStr;
    }
