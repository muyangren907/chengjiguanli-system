<?php

namespace app\chengji\model;

// 引用基类
use app\common\model\Base;

class Tongji extends Base
{

    // 统计成绩
    public function tongjiCnt($cj=array(),$kaoshi)
    {   
        // 获取考试信息
        $ks = new \app\kaoshi\model\Kaoshi;
        $ksinfo = $ks->where('id',$kaoshi)
                ->field('id')
                ->with(['ksSubject'=>function($query){
                    $query->field('id,kaoshiid,subjectid,lieming,youxiu,jige');
                }])
                ->find();
        $data = array();

        // 循环统计各学科成绩
        foreach ($ksinfo->ksSubject as $key => $value) {
            $cjcol = array_column($cj,$value->lieming);
            // $stucnt = count($cjcol);
            $cjcol = array_filter($cjcol,function($item){
                return $item !== null; 
            });

            $temp = array();

            $temp['xkcnt'] = count($cjcol);
            $data[$value->lieming] = $temp;
        }
        $cjcol = array_column($cj,'sum');
        $cjcol = array_filter($cjcol,function($item){
                return $item !== null; 
            });
        $data['stucnt'] = count($cj);
        $data['bmcnt'] = count($cjcol);   # 报名人数
       
        return $data;
    }




    // 统计成绩
    public function tongjiSubject($cj=array(),$kaoshi)
    {   
        // 获取考试信息
        $ks = new \app\kaoshi\model\Kaoshi;
        $ksinfo = $ks->where('id',$kaoshi)
                ->field('id')
                ->with(['ksSubject'=>function($query){
                    $query->field('id,kaoshiid,subjectid,lieming,youxiu,jige');
                }])
                ->find();
        $data = array();
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
                ];


        // 循环统计各学科成绩
        foreach ($ksinfo->ksSubject as $key => $value) {
            $cjcol = array_column($cj,$value->lieming);
            $stucnt = count($cjcol);
            $cjcol = array_filter($cjcol,function($item){
                return $item !== null; 
            });

            $temp = array();

            if($cjcol==null)
            {
                $temp = $tempNull;
                $temp['stucnt'] = $stucnt;
                $temp['id'] = $value->subjectid;
            }else{
                $temp['xkcnt'] = count($cjcol);
                $temp['sum'] = array_sum($cjcol);
                $temp['xkcnt']>0 ? $temp['avg'] = $temp['sum']/$temp['xkcnt'] : $temp['avg']=0;
                $temp['biaozhuncha'] = round($this->getVariance($temp['avg'], $cjcol,true),2);
                $temp['avg'] = round($temp['avg'],2);
                $temp['youxiu'] = $this->rate($cjcol,$value->youxiu);
                $temp['jige'] = $this->rate($cjcol,$value->jige);
                $temp['max'] = max($cjcol);
                $temp['min'] = min($cjcol);
                $temp['sifenwei'] = $this->quartile($cjcol);
                $temp['zhongshu'] = '';
                $temp['stucnt'] = $stucnt;
                $temp['id'] = $value->subjectid;
            }
            $data['cj'][$value->lieming] = $temp;
        }


        $temp = array();
        $cjcol = array_column($cj,'sum');
        $$stucnt = count($cjcol);
        $cjcol = array_filter($cjcol,function($item){
                return $item !== null; 
            });
        if($cjcol==null){
            $temp = $tempNull;
            $temp['stucnt'] = $stucnt;
            $temp['id'] = 0;
        }else{
            $temp['xkcnt'] = count($cjcol);   # 报名人数
            $temp['sum'] = array_sum($cjcol);
            $temp['xkcnt']>0 ? $temp['avg'] = $temp['sum']/$temp['xkcnt'] : $temp['avg']=0;
            $temp['biaozhuncha'] = round($this->getVariance($temp['avg'], $cjcol,true),2);
            $temp['avg'] = round($temp['avg'],2);
            $temp['max'] = max($cjcol);
            $temp['min'] = min($cjcol);
            $temp['youxiu'] = null;
            $temp['jige'] = $this->rateAll($cj,$ksinfo->ks_subject); #全科及格率
            $temp['sifenwei'] = $this->quartile($cjcol);
            $temp['zhongshu'] = '';
            $temp['stucnt'] = $stucnt;
            $temp['id'] = 0;
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
            $temjige = 0; #记录学生及格的学科数
            $col = 0; #记录这个学生是不是有成绩
            // 开始循环这个学生的每个学科成绩
            foreach ($sbj as $k => $val) {
                if(isset($value[$val->lieming]))
                {
                       if($value[$val->lieming]>=$val->jige){
                            $temjige++;
                       }
                       if($value[$val->lieming] !== null)
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


    // 四分位
    public function quartile($items) {
        // 获取数组长度
        $length = count($items);
        if ($items == null || $length == 0) return $result = [0=>'',1=>'',2=>''];
        
        if ($length < 5) return $result = [0=>'',1=>'',2=>''];
        $result = array();
        
        sort($items);
        
        if ($length % 2 == 0) {//偶数
            $result[1] =  ($items[$length/2 - 1] + $items[$length/2]) / 2;
        } else {//奇数
            $result[1] =  $items[($length + 1)/2 - 1];
        }
        
        if ($length % 4 == 0) {
            $result[0] =  ($items[$length/4 - 1] + $items[$length/4]) / 2;
            $result[2] =  ($items[3*$length/4 - 1] + $items[3*$length/4]) / 2;
        } else {
            $result[0] =  $items[$length/4];
            $result[2] =  $items[3*$length/4];
        }
        
        return $result;
    }

    
}
