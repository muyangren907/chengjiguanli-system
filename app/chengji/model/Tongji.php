<?php

namespace app\chengji\model;

// 引用基类
use app\common\model\Base;

class Tongji extends Base
{

    /**  
    * 取出学生原始成绩 
    * 信息包括：各学科成绩、平均分、总分
    * 用于学生成绩统计
    * @access public 
    * @param number $kaoshi 考试id
    * @param array $banji 班级
    * @param number $nianji 年级 
    * @param array $school 学校 
    * @return array 返回类型
    */
    // public function srcChengji($srcfrom)
    // {

    //     // 初始化参数 
    //     $src = array(
    //         'kaoshi'=>'',
    //         'banji'=>array('0'),
    //         'nianji'=>'',
    //         'school'=>array(),
    //     );

    //     // 用新值替换初始值
    //     $src = array_cover( $srcfrom , $src ) ;
    //     $banji = $src['banji'];
    //     $school = $src['school'];
    //     $nianji = $src['nianji'];

    //     $kh = new \app\kaoshi\model\Kaohao;

    //     $khlist = $kh->where('kaoshi',$src['kaoshi'])
    //             ->field('id,nianji,banji')
    //             ->when(count($school)>0,function($query) use($school){
    //                 $query->where('school','in',$school);
    //             })
    //             ->when(strlen($nianji)>0,function($query) use($nianji){
    //                 $query->where('ruxuenian',$nianji);
    //             })
    //             ->when(count($banji)>0,function($query) use($banji){
    //                 $query->where('banji','in',$banji);
    //             })
    //             ->with([
    //                 'ksChengji'=>function($query){
    //                     $query->field('kaohao_id,subject_id,defen');
    //                 }
    //             ])
    //             ->select();
    //     if($khlist->isEmpty())
    //     {
    //         return $data = array();
    //     }

    //     halt($khlist->toArray());

    //     // 获取参考学科
    //     $ks = new \app\kaoshi\model\Kaoshi;
    //     $ksinfo = $ks->where('id',$kaoshi)
    //                 ->with([
    //                     'ksSubject'=>function($query){
    //                         $query->field('kaoshiid,subjectid,lieming');
    //                     }
    //                 ])
    //                 ->find();
    //     if($ksinfo->ks_subject->isEmpty())
    //     {
    //         return $data = array();
    //     }
    //     $xk = array();
    //     foreach ($ksinfo->ks_subject as $key => $value) {
    //         $xk[$value->subjectid] = $value->lieming;
    //     }

    //     // 整理数据
    //     $data = array();
    //     foreach ($khlist as $key => $value) {
    //         if(count($value->ks_chengji)== 0)
    //         {
    //             continue;
    //         }
    //         $data[$key]['sum'] = 0;
    //         $sbjcnt = 0;
    //         foreach ($value->ks_chengji as $k => $val) {
    //             $data[$key][$xk[$val->subject_id]] = $val->defen*1;
    //             $data[$key]['sum'] = ($data[$key]['sum'] + $val->defen) * 1;
    //             $sbjcnt ++ ;
    //         }
    //         $data[$key]['sum'] == 0 ? $data[$key]['avg'] = 0 :  $data[$key]['sum'] / $sbjcnt;
    //     }

    //     return $data;
    // }



    // 统计成绩
    public function tongji($cj=array(),$kaoshi)
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
            $stucnt = count($cjcol);
            $cjcol = array_filter($cjcol,function($item){
                return $item !== null; 
            });

            $temp = array();

            if($cjcol==null)
            {
                $temp = [
                    'xkcnt'=>0,
                    'sum'=>'',
                    'biaozhuncha'=>'',
                    'avg'=>'',
                    'youxiu'=>'',
                    'jige'=>'',
                    'sifenwei'=>[
                        '0'=>'',
                        '1'=>'',
                        '2'=>''
                    ],
                    'max'=>'',
                    'min'=>''
                ];
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
            }
            $data[$value->lieming] = $temp;
        }
        $cjcol = array_column($cj,'sum');
        $cjcol = array_filter($cjcol,function($item){
                return $item !== null; 
            });
        $data['stucnt'] = count($cj);
        $data['bmcnt'] = count($cjcol);   # 报名人数
        $data['sum'] = array_sum($cjcol);
        if($data['bmcnt']>0)
        {
            $data['sum'] = array_sum($cjcol);
            $data['avg'] = round($data['sum']/$data['bmcnt'],2);
        }else{
            $data['sum'] = '';
            $data['avg'] = '';
        }
        foreach ($cj as $key => $value) {
            unset($cj[$key]['avg']);
            unset($cj[$key]['sum']);
        }
        $data['rate'] = $this->rateAll($cj,$ksinfo->ks_subject); #全科及格率
        
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
        if ($items == null || $length == 0) return $result = [0=>'-',1=>'-',2=>'-'];
        
        if ($length < 5) return $result = [0=>'-',1=>'-',2=>'-'];
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
