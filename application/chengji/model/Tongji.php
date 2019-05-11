<?php

namespace app\chengji\model;

use think\Model;

class Tongji extends Model
{
    // //统计成绩
    // public function tongji($cjlist,$fenshuxian)
    // {
    //     // 循环计算各科成绩
    //     foreach ($fenshuxian as $key => $value) {
    //         // 获取列名
    //         $lieming = $value['lieming'];
    //         // 获取学科成绩
    //         $xkchengji = $cjlist->column($value['lieming']);

    //         // 过滤空元素
    //         $xkchengji = array_filter($xkchengji);
    //         // 获取成绩个数
    //         $cnt = count($xkchengji);


    //         // 获取优秀人数
    //         $yx = $value['youxiu'];
    //         $youxiu = array_filter($xkchengji,function($var) use($yx){
    //             if( $var<$yx )
    //             {
    //                 return false;
    //             }else{
    //                 return true;
    //             };
    //         });
    //         $youxiu = count($youxiu);

    //         // 获取及格人数
    //         $jg = $value['jige'];
    //         $jg = array_filter($xkchengji,function($var) use($jg){
    //             if( $var<$jg )
    //             {
    //                 return false;
    //             }else{
    //                 return true;
    //             }
    //         });
    //         $jige = count($jg);

    //         // 计算成绩
    //         $data[$value['lieming']] = $this->tjxueke($xkchengji,$cnt,$youxiu,$jige);
    //     }        
    	
    // 	return $data;
    // }


    // 查询学生成绩
    public function srcChengji($kaoshi,$banji=array(),$nianji=array())
    {
        $kh = new \app\kaoshi\model\Kaohao;

        $khlist = $kh->where('kaoshi',$kaoshi)
                ->field('id,nianji,banji')
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

        // 获取参考学科
        $ks = new \app\kaoshi\model\Kaoshi;
        $ksinfo = $ks->where('id',$kaoshi)
                    ->with([
                        'ksSubject'=>function($query){
                            $query->field('kaoshiid,subjectid,lieming');
                        }
                    ])
                    ->find();
        $xk = array();
        foreach ($ksinfo->ks_subject as $key => $value) {
            $xk[$value->subjectid] = $value->lieming;
        }

        // 整理数据
        $data = array();
        foreach ($khlist as $key => $value) {
            foreach ($value->ks_chengji as $k => $val) {
                $data[$key][$xk[$val->subject_id]] = $val->defen*1;
            }
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
            $temp['avg'] = round($temp['avg'],1);
            $temp['youxiu'] = $this->rate($cjcol,$value->youxiu);
            $temp['jige'] = $this->rate($cjcol,$value->jige);
            $temp['sifenwei'] = $this->quartile($cjcol);
            $data[$value->lieming] = $temp;
        }
        $data['cnt'] = count($allcj);
        $data['sum'] = array_sum($allcj);
        $data['cnt']>0 ? $data['avg'] = $data['sum']/$data['cnt'] : $data['avg']=0;
        

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

        return round($cnt/count($cj)*100);
    }






    // // 统计全区各学校的年级成绩
    // public function tjschool($kaoshiid,$ruxuenian)
    // {
    //     // 实例化成绩数据模型
    //     $cj = new \app\chengji\model\Chengji;
    //     // 根据考试号和年级获取考试成绩
    //     $cjlist = $cj->searchNianji($kaoshiid,'',$ruxuenian);

    //     // 获取学校列表
    //     $sch = schlist($low='校级',$high='校级');


    //     // 获取统计成绩参数
    //     $canshu = $this->getCanshu($kaoshiid);

        

    //     // 循环获取各班级成绩
    //     $i = 0;
    //     foreach ($sch as $key => $value) {
    //         $data[$i]['id'] = $i+1;
    //         $data[$i]['title'] = $value['jiancheng'];
    //         $bjlist = $cjlist->where('school',$value['id']);
    //         $data[$i]['data'] = $this->tongji($bjlist,$canshu);
    //         $i++;
    //     }

    //     $data[$i]['id'] = $i+1;
    //     $data[$i]['title'] = '合计';
    //     $data[$i]['data'] = $this->tongji($cjlist,$canshu);

    //     return $data;
    // }



    // // 统计学科成绩
    // public function tjxueke($xkchengji,$cnt,$youxiu,$jige)
    // {
      
    //     // 如果没有数据则返回空数组
    //     if($cnt == 0)
    //     {
    //         $data = ['cnt'=>0,'sum'=>'-','avg'=>'-','youxiu'=>'-','jige'=>'-','max'=>'-','min'=>'-','biaozhuncha'=>'-','sifenwei'=>array()];
    //         return $data;
    //     }

    //     // 计算数据
    //     $sum = array_sum($xkchengji);
    //     $avg = round($sum/$cnt,1);
    //     $youxiulv = round($youxiu/$cnt*100,1);
    //     $jigelv = round($jige/$cnt*100,1);
    //     $max = max($xkchengji);
    //     $min = min($xkchengji);
    //     $biaozhuncha = round($this->getVariance($avg,$xkchengji,true),1);
    //     $sifenwei = $this->quartile($xkchengji);
    //     // 数组赋值
    //     $data = [
    //         'cnt'=>$cnt,
    //         'sum'=>$sum,
    //         'avg'=>$avg,
    //         'youxiu'=>$youxiulv,
    //         'jige'=>$jigelv,
    //         'max'=>$max,
    //         'min'=>$min,
    //         'biaozhuncha'=>$biaozhuncha,
    //         'sifenwei'=>$sifenwei,
    //     ];

    //     // 返回计算结果
    //     return $data;
    // }


    // // 获取统计成绩需要的参数
    // public function getCanshu($kaoshiid)
    // {
    //     // 获取学科信息
    //     $xk = new \app\teach\model\Subject;
    //     $xk = $xk->where('id','<',4)->select();
    //     $xkTitle = $xk->column('title','id');
    //     $xkLieming = $xk->column('lieming','id');

    //     // 获取参加考试学科满分
    //     $kssub = new \app\kaoshi\model\KaoshiSubject;

    //     $fenshuxian = $kssub ->where('kaoshiid',$kaoshiid)->append(['subject.title','subject.lieming'])->select();

    //     // 循环取出优秀和及格分数线
    //     foreach ($fenshuxian as $key => $value) {
    //         $fsx[$value['subjectid']]['youxiu']=$value['youxiu'];
    //         $fsx[$value['subjectid']]['jige']=$value['jige'];
    //         $fsx[$value['subjectid']]['title']=$value['subject']['title'];
    //         $fsx[$value['subjectid']]['lieming']=$value['subject']['lieming'];
    //         $fsx[$value['subjectid']]['manfen']=$value['manfen'];
    //     }

    //     // 返回数据
    //     return $fsx;
    // }


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
