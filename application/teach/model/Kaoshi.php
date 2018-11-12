<?php

namespace app\teach\model;

// 引用数据模型基类
use app\common\model\Base;


class Kaoshi extends Base
{
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
    public function kaoshinianji()
    {
        return $this->hasMany('KaoshiNianji','kaoshiid','id')->field('id,kaoshiid,nianji,nianjiname');
    } 

    // 参考学科关联表
    public function kaoshisubject()
    {
        return $this->hasMany('KaoshiSubject','kaoshiid','id')->field('kaoshiid,subjectid,manfen');
    }

    // 类别获取器
    public function getCategoryAttr($value)
    {
        return db('category')->where('id',$value)->value('title');
    }

    // 学期获取器
    public function getXueqiAttr($value)
    {
        return db('xueqi')->where('id',$value)->value('title');
    }

    // 组织考试单位获取器
    public function getZuzhiAttr($value)
    {
        return db('school')->where('id',$value)->value('title');
    }

    // 获取参考年级列表并返回nianji字段值
    public function getNianjiidsAttr()
    {
        $list = $this->get($this->getAttr('id'));
        $nianji = $list->kaoshinianji;

        foreach ($nianji as $key => $value) {
            $key == 0 ? $str = $value['nianji'] : $str = $str.','.$value['nianji'];
        }
        return $str;
    }

    // 获取参考学科并返回学科id
    public function getSubjectidsAttr()
    {
        $list = $this->get($this->getAttr('id'));
        $nianji = $list->kaoshisubject;

        foreach ($nianji as $key => $value) {
            $key == 0 ? $str = $value['subjectid'] : $str = $str.','.$value['subjectid'];
        }
        return $str;
    }

    // 获取参考年级，并返回年级名称
    public function getNianjinamesAttr()
    {
        $list = $this->get($this->getAttr('id'));
        $nianji = $list->kaoshinianji;

        foreach ($nianji as $key => $value) {
            $key == 0 ? $str = $value['nianjiname'] : $str = $str.'、'.$value['nianjiname'];
        }
        return $str;
    }

    // 获取参考学科，并返回学科简称
    public function getSubjectnamesAttr()
    {
        $subject = $this->get($this->getAttr('id'))->append(['subjectids']);

        $subject= db('subject')->where('id','in',$subject->subjectids)->column('jiancheng');
        foreach ($subject as $key => $value) {
            if($key == 0){
                $str = $value;
            }else{
                $str = $str.'、'.$value;
            }
        }
        return $str;
    }

    // 满分编辑数据
    public function getManfeneditAttr()
    {
        // 获取各学科满分信息
        $subject = $this->with('kaoshisubject')->get($this->getAttr('id'));

        $manfenlist = array();
        // 重新组成数组
        foreach ($subject->kaoshisubject as $key => $value) {
             $manfenlist[$value->subjectid] = $value->manfen;
        }
        // 返回数组
        return $manfenlist;
    }
}
