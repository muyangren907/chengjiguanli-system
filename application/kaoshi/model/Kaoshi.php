<?php

namespace app\kaoshi\model;

// 引用数据模型基类
use app\common\model\Base;


class Kaoshi extends Base
{
    // 查询所有单位
    public function search($src)
    {
        // 整理变量
        // $xingzhi = $src['xingzhi'];
        $searchval = $src['searchval'];

        // 查询数据
        $data = $this
            ->order([$src['field'] =>$src['order']])
            // ->when(count($xingzhi)>0,function($query) use($xingzhi){
            //         $query->where('xingzhi','in',$xingzhi);
            //     })
            ->when(strlen($searchval)>0,function($query) use($searchval){
                    $query->where('title','like','%'.$searchval.'%');
                })
            ->with(
                [
                    'ksCategory'=>function($query){
                        $query->field('id,title');
                    }
                    ,'ksSubject'=>function($query){
                        $query->with(['subjectName'=>function($q){
                            $q->field('id,jiancheng');
                        }]);
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
        return strtotime($value);
    }

    // 结束时间获取器
    public function getEnddateAttr($value)
    {
        return date('Y-m-d',$value);
    }

    //参考年级关联表
    public function ksNianji()
    {
        return $this->hasMany('KaoshiNianji','kaoshiid','id')->field('id,kaoshiid,nianji,nianjiname');
    } 

    // 参考学科关联表
    public function ksSubject()
    {
        return $this->hasMany('KaoshiSubject','kaoshiid','id')->field('kaoshiid,subjectid,manfen,youxiu,jige,lieming');
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
