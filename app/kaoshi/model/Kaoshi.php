<?php

namespace app\kaoshi\model;

// 引用数据模型基类
use app\common\model\Base;


class Kaoshi extends Base
{
    // 查询所有单位
    public function search($srcfrom)
    {
        $src = [
            'field'=>'id',
            'order'=>'desc',
            'searchval'=>''
        ];
        // 用新值替换初始值
        $src = array_cover( $srcfrom , $src ) ;

        // 整理变量
        // $xingzhi = $src['xingzhi'];
        $searchval = $src['searchval'];

        // 查询数据
        $data = $this
            ->order([$src['field'] =>$src['order']])
            ->when(strlen($searchval)>0,function($query) use($searchval){
                    $query->where('title','like','%'.$searchval.'%');
                })
            ->with(
                [
                    'ksCategory'=>function($query){
                        $query->field('id,title');
                    }
                    ,'ksZuzhi'=>function($q)
                    {
                        $q->field('id,title,jiancheng');
                    }
                ]
            )
            ->append(['ckSubject','ckNianji'])
            ->select();

        return $data;
    }


    // 考试参加考试的学校、学科、年级、班级
    public function kaoshiInfo($kaoshi=0)
    {

        // 获取参考年级
        $kaoshiList = $this->where('id',$kaoshi)
                ->field('id,title')
                // ->with([
                //     'ksNianji'
                //     ,'ksSubject'=>function($query){
                //                 $query->field('id,subjectid,kaoshiid')
                //                     ->with(['subjectName'=>function($q){
                //                         $q->field('id,title');
                //                     }]
                //                 );
                //             }
                // ])
                ->where('enddate','>=',time())
                ->find()
                ->toArray();

        // 获取参加考试信息
        $kh = new \app\kaoshi\model\Kaohao;
        $list = array();
        $list['subject'] = $kaoshiList['ksSubject'];
        $list['nianji'] = $kaoshiList['ksNianji'];
        $nianji = array_column($list['nianji'], 'nianji');
        $list['school'] = $kh->cySchool(['kaoshi'=>$kaoshiList['id'],'ruxuenian'=>$nianji]);

        return $list;
    }
  


    // 开始时间修改器
    public function setBfdateAttr($value)
    {
        return strtotime($value);
    }  

    // 开始时间获取器
    public function getBfdateAttr($value)
    {
        return date('Y-m-d',$value);
    }

    // 结束时间修改器
    public function setEnddateAttr($value)
    {
        // 设置结束时间为当年的最后1秒
        $sj = $value.' 23:59:59';
        return strtotime($sj);
    }

    // 结束时间获取器
    public function getEnddateAttr($value)
    {
        return date('Y-m-d',$value);
    }

    // 参考学科获取器
    public function getCkSubjectAttr($value)
    {
        // 查询参考学科
        $ksset = new \app\kaoshi\model\KaoshiSet;
        $subject = $ksset->srcSubject($this->getAttr('id'),'','');
        // 重新整理数据
        $str = '';
        foreach ($subject as $key => $value) {
            if($key==0)
            {
                $str = $value['jiancheng'];
            }else{
                $str = $str.'、'.$value['jiancheng'];
            }
        }
        return $str;
    }

    // 参考年级获取器
    public function getCkNianjiAttr($value)
    {
        // 查询参考年级
        $ksset = new \app\kaoshi\model\KaoshiSet;
        $data = $ksset->srcNianji($this->getAttr('id'));
        // 重新整理数据
        $str = '';
        foreach ($data as $key => $value) {
            $temp = substr($value['nianjiname'], 0,3);
            if($key==0)
            {
                $str = $temp;
            }else{
                $str = $str.'、'.$temp;
            }
        }
        return $str;
    }

    // 考试设置关联表
    public function ksSet()
    {
        return $this->hasMany('KaoshiSet','kaoshi_id','id');
    }
    // // 考试设置关联表
    // public function ksSubject()
    // {
    //     return $this->hasMany('KaoshiSet','kaoshi_id','id')->gooup('subject_id');
    // }
    // // 考试设置关联表
    // public function ksNianji()
    // {
    //     return $this->hasMany('KaoshiSet','kaoshi_id','id')->gooup('nianji');
    // }
    // 参考类别关联表
    public function ksCategory()
    {
        return $this->belongsTo('\app\system\model\Category','category','id');
    }

    // 考试成绩关联表
    public function ksChengji()
    {
        return $this->hasMany('\app\chengji\model\Chengji','kaoshi','id');
    }

    // 考试组织单位关联表
    public function ksZuzhi()
    {
        return $this->belongsTo('\app\system\model\School','zuzhi','id');
    }




}
