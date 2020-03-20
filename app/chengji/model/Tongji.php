<?php

namespace app\chengji\model;

// 引用基类
use app\BaseModel;

class Tongji extends BaseModel
{

    // 统计成绩
    public function tongjiCnt($cj=array(),$subject)
    {
        $data = array();

        // 循环统计各学科成绩
        foreach ($subject as $key => $value) {
            $cjcol = array_column($cj,$value['lieming']);

            $cjcol = array_filter($cjcol,function($item){
                return $item != null;
            });
            $temp = array();
            $temp['xkcnt'] = count($cjcol);
            $data[$value['lieming']] = $temp;
        }

        $data['stucnt'] = count($cj);

        return $data;
    }




    // 统计成绩
    public function tongjiSubject($cj=array(),$subject)
    {

        // 设置默认值
        $tempNull = [
            'xkcnt'=>0,
            'sum'=>null,
            'biaozhuncha'=>null,
            'avg'=>null,
            'youxiu'=>null,
            'jige'=>null,
            'sifenwei'=>[
                '0'=>null,
                '1'=>null,
                '2'=>null
            ],
            'max'=>null,
            'min'=>null,
            'zhongshu'=>null,
            'defenlv'=>null,
        ];

        $data = array();
        $sbjdefencnt = 0;   #记录试卷满分


        // 循环统计各学科成绩
        foreach ($subject as $key => $value) {
            $sbjdefencnt = $sbjdefencnt + $value['fenshuxian']['manfen'];
            $cjcol = array_column($cj,$value['lieming']);
            $stucnt = count($cjcol);
            $cjcol = array_filter($cjcol,function($item){
                return $item !== null;
            });

            $temp = $tempNull;
            $temp['id'] = $value['id'];
            $temp['stucnt'] = $stucnt;

            if($cjcol!=null)
            {
                $temp['xkcnt'] = count($cjcol);
                $temp['sum'] = array_sum($cjcol);
                if( $temp['xkcnt']>0)
                {
                    $temp['avg'] = $temp['sum']/$temp['xkcnt'];
                    $temp['defenlv'] = $temp['avg'] / $value['fenshuxian']['manfen'];
                }
                $temp['biaozhuncha'] = round($this->getVariance($temp['avg'], $cjcol,true),2);
                $temp['avg'] = round($temp['avg'],2);
                $temp['youxiu'] = $this->rate($cjcol,$value['fenshuxian']['youxiu']);
                $temp['jige'] = $this->rate($cjcol,$value['fenshuxian']['jige']);
                $temp['max'] = max($cjcol);
                $temp['min'] = min($cjcol);
                $temp['sifenwei'] = $this->myquartile($cjcol);
                $temp['zhongshu'] = '';
                $temp['defenlv'] = round($temp['defenlv'] * 100,2);
            }
            $data['cj'][$value['lieming']] = $temp;
        }


        $temp = $tempNull;
        $cjcol = array_column($cj,'sum');
        $stucnt = count($cjcol);
        $cjcol = array_filter($cjcol,function($item){
                return $item !== null;
            });
        $temp['id'] = 0;
        $temp['stucnt'] = $stucnt;
        if($cjcol!=null){
            $temp['xkcnt'] = count($cjcol);   # 报名人数
            $temp['sum'] = array_sum($cjcol);
            if( $temp['xkcnt']>0)
            {
                $temp['avg'] = $temp['sum']/$temp['xkcnt'];
                $temp['defenlv'] = $temp['avg'] / $sbjdefencnt;
            }
            $temp['biaozhuncha'] = round($this->getVariance($temp['avg'], $cjcol,true),2);
            $temp['avg'] = round($temp['avg'],2);
            $temp['max'] = max($cjcol);
            $temp['min'] = min($cjcol);
            $temp['youxiu'] = null;
            $temp['jige'] = $this->rateAll($cj,$subject); #全科及格率
            $temp['sifenwei'] = $this->myquartile($cjcol);
            $temp['zhongshu'] = '';
            $temp['defenlv'] = round($temp['defenlv'] * 100,2);
        }
        $data['cj']['all'] = $temp;

        return $data;
    }


    // 统计优秀、及格率
    public function rate($cj = array(),$fenshuxian)
    {
        $cnt = 0;
        foreach ($cj as $key => $value) {
            if($value>=$fenshuxian)
            {
                $cnt++;
            }
        }
        if(count($cj)>0)
        {
            return round($cnt/count($cj)*100,2);
        }else{
            return '0';
        }

    }


    // 全科及格率
    public function rateAll($cj = array(), $sbj=array())
    {
        $jige = 0;  # 总及格人数
        $row = 0; #记录有成绩的学生数
        $sbjcnt = count($sbj);
        // 开始循环每个人的成绩
        foreach ($cj as $key => $value) {
            $temjige = 0; # 记录学生及格的学科数
            $col = 0; # 记录有成绩的学生数
            // 开始循环这个学生的每个学科成绩
            foreach ($sbj as $k => $val) {
                if(isset($value[$val['lieming']]))
                {
                    if($value[$val['lieming']]>=$val['fenshuxian']['jige']){
                        $temjige++;
                    }
                    if($value[$val['lieming']] !== null)
                    {
                        $col++;
                    }
                }
            }
            $col>0 ? $row++ : $row;
            // 如果这个学生及格学科数等于学科总数，那么全科及格总数加1
            $temjige == $sbjcnt && $temjige>0 ? $jige++ : $jige ;
        }

        $row>0 ? $rate = round($jige/count($cj)*100,2) : $rate='';
        return $rate;
    }




    /**
     * 得到数组的标准差
     * @param unknown type $avg
     * @param Array $list
     * @param Boolen $isSwatch
     * @return unknown type
     */
    public static  function getVariance($avg, $list, $isSwatch  = FALSE) {
            $arrayCount = count($list);
            if($arrayCount == 1 && $isSwatch == TRUE){
                    return '-';
            }elseif($arrayCount > 0 ){
                    $total_var = 0;
                    foreach ($list as $lv)
                            $total_var += pow(($lv - $avg), 2);
                    if($arrayCount == 1 && $isSwatch == TRUE)
                            return FALSE;
                    return $isSwatch?sqrt($total_var / (count($list) - 1 )):sqrt($total_var / count($list));
            }
            else
                    return '-';
    }


    /**
    * 计算四分位（ Quartile ） Q1、Q2、Q3的值
    * @access public
    * @param array $arr 要计算的一维数组
    * @return array $result 下标0-2 分别对应Q1、Q2、Q3
    */
    public function myquartile($arr)
    {
        // 获取数组长度
        $length = count($arr);

        // 如果数组为空或数组长度小于5时，返回空。
        if ($arr == null || $length == 0) return $result = [0=>'',1=>'',2=>''];
        if ($length < 5) return $result = [0=>'',1=>'',2=>''];

        // 数组排序
        sort($arr);

        // 初始化变量
        $result = array();  #储存结果
        $q = array();       #储存位置

        // 确定位置
        // 计算方法参考百度百科
        // 使用n-1方法。
        $q[0] = 1 + ($length - 1 ) * 0.25;
        $q[1] = 1 + ($length - 1 ) * 0.5;
        $q[2] = 1 + ($length - 1 ) * 0.75;
        // n+1方法结果也对，但是与excel不相同
        // $q[0] = ($length + 1 ) * 0.25;
        // $q[1] = ($length + 1 ) * 0.5;
        // $q[2] = ($length + 1 ) * 0.75;

        // 计算每个位置对应的值
        foreach ($q as $key => $value) {
            if(is_int($value))      # 如果位置是整数，则直接取位置对应的值
            {
                $result[$key] = $arr[$value-1];
            }else{
            # 如果位置不是整数。计算公式:大数*位置小数 + 小数*(1-位置小数)
                $tempNum = $value;
                $temp = intval($tempNum);
                $tempNum = $tempNum - $temp;
                $result[$key] = $arr[$temp] * $tempNum + $arr[$temp-1] * (1-$tempNum);
                $result[$key] = round($result[$key],2);
            }
        }

        return $result;
    }

}
