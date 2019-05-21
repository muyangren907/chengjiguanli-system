<?php

namespace app\chengji\model;

use think\Model;

class Tongji extends Model
{

    // 查询学生成绩
    public function srcChengji($kaoshi,$banji=array(),$nianji=array(),$school=array())
    {
        $kh = new \app\kaoshi\model\Kaohao;

        $khlist = $kh->where('kaoshi',$kaoshi)
                ->field('id,nianji,banji')
                ->when(count($school)>0,function($query) use($school){
                    $query->where('school','in',$school);
                })
                ->when(count($nianji)>0,function($query) use($nianji){
                    $query->where('nianji','in',$nianji);
                })
                ->when(count($banji)>0,function($query) use($banji){
                    $query->where('banji','in',$banji);
                })
                ->with([
                    'ksChengji'=>function($query){
                        $query->field('kaohao_id,subject_id,defen');
                    }
                ])
                ->select();
        if($khlist->isEmpty())
        {
            return $data = array();
        }

        // 获取参考学科
        $ks = new \app\kaoshi\model\Kaoshi;
        $ksinfo = $ks->where('id',$kaoshi)
                    ->with([
                        'ksSubject'=>function($query){
                            $query->field('kaoshiid,subjectid,lieming');
                        }
                    ])
                    ->find();
        if($ksinfo->ks_subject->isEmpty())
        {
            return $data = array();
        }
        $xk = array();
        foreach ($ksinfo->ks_subject as $key => $value) {
            $xk[$value->subjectid] = $value->lieming;
        }

        // 整理数据
        $data = array();
        foreach ($khlist as $key => $value) {
            if(count($value->ks_chengji)== 0)
            {
                continue;
            }
            $data[$key]['sum'] = 0;
            $sbjcnt = 0;
            foreach ($value->ks_chengji as $k => $val) {
                $data[$key][$xk[$val->subject_id]] = $val->defen*1;
                $data[$key]['sum'] = ($data[$key]['sum'] + $val->defen) * 1;
                $sbjcnt ++ ;
            }
            $data[$key]['sum'] == 0 ? $data[$key]['avg'] = 0 :  $data[$key]['sum'] / $sbjcnt;
        }
        return $data;
    }



    // 统计成绩
    public function tongji($cj=array(),$kaoshi)
    {   
        
        $ks = new \app\kaoshi\model\Kaoshi;
        $ksinfo = $ks->where('id',$kaoshi)
                ->field('id')
                ->with('ksSubject')
                ->find();
        $data = array();
        $allcj = array();
        foreach ($ksinfo->ks_subject as $key => $value) {
            $cjcol = array_column($cj,$value->lieming);
            $allcj = array_merge($allcj,$cjcol);
            $temp = array();
            $temp['cnt'] = count($cjcol);
            $temp['sum'] = array_sum($cjcol);
            $temp['cnt']>0 ? $temp['avg'] = $temp['sum']/$temp['cnt'] : $temp['avg']=0;
            $temp['biaozhuncha'] = round($this->getVariance($temp['avg'], $cjcol,true),2);
            $temp['avg'] = round($temp['avg'],2);
            $temp['youxiu'] = $this->rate($cjcol,$value->youxiu);
            $temp['jige'] = $this->rate($cjcol,$value->jige);
            $temp['sifenwei'] = $this->quartile($cjcol);
            $data[$value->lieming] = $temp;
        }
        $cjcol = array_column($cj,'sum');
        $data['cnt'] = count($cjcol);
        $data['sum'] = array_sum($cjcol);
        $data['cnt']>0 ? $data['avg'] = round($data['sum']/$data['cnt'],2) : $data['avg']=0;
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
            return '';
        }

    }


    // 全科及格率
    public function rateAll($cj = array(), $sbj=array())
    {
        $jige = 0;  # 总及格人数
        // 开始循环每个人的成绩
        foreach ($cj as $key => $value) {
            $temjige = 0; #记录学生及格的学科数
            // 开始循环这个学生的每个学科成绩
            foreach ($sbj as $k => $val) {
                if(isset($value[$val->lieming]))
                {
                    if($value[$val->lieming]>=$val->jige)
                    {
                       $temjige++; 
                    }
                }
            }
            // 如果这个学生及格学科数等于学科总数，那么全科及格总数加1
            $temjige == count($value) && $temjige>0 ? $jige++ : $jige ;
        }


        if(count($cj)>0)
        {
            return round($jige/count($cj)*100,2);
        }else{
            return '';
        }
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
