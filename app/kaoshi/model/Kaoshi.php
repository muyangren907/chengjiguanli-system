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
                    ,'ksSubject'=>function($query){
                        $query->field('kaoshiid,subjectid')
                            ->with(['subjectName'=>function($q){
                                $q->field('id,jiancheng');
                            }]
                        );
                    }
                    ,'ksNianji'
                ]
            )
            ->select();
        return $data;
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

    //参考年级关联表
    public function ksNianji()
    {
        return $this->hasMany('KaoshiNianji','kaoshiid','id')->field('kaoshiid,nianji,nianjiname');
    } 

    // 参考学科关联表
    public function ksSubject()
    {
        return $this->hasMany('KaoshiSubject','kaoshiid','id');
    }
    // 参考学科关联表
    public function ksCategory()
    {
        return $this->belongsTo('\app\system\model\Category','category','id');
    }

    // 考试成绩关联表
    public function ksChengji()
    {
        return $this->hasMany('\app\chengji\model\Chengji','kaoshi','id');
    }




}
