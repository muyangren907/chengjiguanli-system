<?php

// 分数验证
function manfenvalidate($defen, $manfen)
{
	$data['val'] = 1;
	$data['msg'] = '验证通过';

	if ($manfen == "") {
		$data['val'] = 0;
		$data['msg'] = '本学科不参加考试';
		return $data;
	}

	if (is_numeric($defen) == false) {
		$data['val'] = 0;
		$data['msg'] = '得分必须是数字';
		return $data;
	}

	if ( $defen < 0 ) {
		$data['val'] = 0;
		$data['msg'] = '得分必须大于等于0';
		return $data;
	}

	if ($defen > $manfen) {
		$data['val'] = 0;
		$data['msg'] = '得分必须必须小于等于'.$manfen;
		return $data;
	}

	// if ( ($defen*10)%5 != 0 ) {
	// 	$data['val'] = 0;
	// 	$data['msg'] = '得分必须只能是x.5';
	// 	return $data;
	// }

	return $data;
}



    /**
    * 从统计结果中获取条形统计图中需要的各项目成绩
    *
    * @access public
    * @param arr 统计结果
    * @param xm 要统计的项目
    * @return array 返回类型
    */
    function tiaoxingOnexiangmu($jg, $xm)
    {
        $chengji = array();
        $series = array();
        foreach ($jg as $key => $value) {
            if($key ==0)
            {
                $chengji[$key][] = '项目';
                foreach ($value['chengji'] as $k => $val) {
                    $chengji[$key][] = $val['title'];
                    $series[] = ['type'=>'bar'];
                }
            }
            # code...
            if( isset($value['banji_title']))
            {
                $temp = $value['school_jiancheng'].$value['banji_title'];
            }else{
                $temp = $value['school_jiancheng'];
            }
            $chengji[$key+1][] = $temp;
            foreach ($value['chengji'] as $k => $val) {
                $chengji[$key+1][] = $val[$xm];
            }
        }
        $data = [
            'data'=>$chengji,
            'series'=>$series,
        ];

        return $data;
    }


    /**
    * 从统计结果中获取条形箱体图需要的各项目成绩
    *
    * @access public
    * @param arr 统计结果
    * @param xm 要统计的项目
    * @return array 返回类型
    */
    function xiangti($jg)
    {
        $data = array();
        $axisData = array();
        $chengji = array();
        $category = array();

        foreach ($jg as $key => $value) {
            if ($key ==0) {
                foreach ($value['chengji'] as $k => $val) {
                    $category[$k] = $val['title'];
                }
            }

            foreach ($value['chengji'] as $k => $val) {
                $chengji[$k][$key][0] = $val['sifenwei']['min'];
                $chengji[$k][$key][1] = $val['sifenwei']['q1'];
                $chengji[$k][$key][2] = $val['sifenwei']['q2'];
                $chengji[$k][$key][3] = $val['sifenwei']['q3'];
                $chengji[$k][$key][4] = $val['sifenwei']['max'];
            }

            if (isset($value['banji_title'])) {
                $temp = $value['school_jiancheng'] . $value['banji_title'];
            } else {
                $temp = $value['school_jiancheng'];
            }

            $axisData[] = $temp;
        }

        $data = [
            'axisData' => $axisData
            ,'boxData' => $chengji
            ,'category' => $category
        ];

        return $data;
    }

    /**
    * 把给定的成绩进行排序
    * @access public
    * @param array $arr 要计算的一维数组成绩
    * @return array $result 返回成绩排序结果
    */
    function tjOrder($cj,$type = 'desc')
    {
        if ($type == 'desc') {
            arsort($cj);
        } else {
            asort($cj);
        }

        return $cj;
    }