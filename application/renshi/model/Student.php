<?php

namespace app\renshi\model;

// 引用数据模型基类
use app\common\model\Base;
// 引用班级数据模型类
use app\teach\model\Banji;

class Student extends Base
{
    // 班级关联
    public function stuNanji()
    {
        return $this->belongsTo('\app\teach\model\Banji','banji','id')->bind(['myruxuenian'=>'ruxuenian']);
    }
    // 班级关联
    public function stuBanji()
    {
        return $this->belongsTo('\app\teach\model\Banji','banji','id');
    }

    // 年龄获取器
    public function getAgeAttr()
    {
    	return getAgeByBirth($this->getdata('shengri'),2);
    }

    // 年级、班级名称获取器
    public function getBanjititleAttr()
    {
    	$bj = Banji::get($this->banji);
    	$bj = $bj->append(['title']);
    	return $bj->title;
    }

    // 学校获取器
    public function getSchoolAttr($value)
    {
        return db('school')->where('id',$value)->value('title');
    }

    // 生日修改器
    public function setShengriAttr($value)
    {
        return strtotime($value);
    }

    // 生日获取器
    public function getShengriAttr($value)
    {
        return date('Y-m-d',$value);
    }

    // 性别获取器
    public function getSexAttr($value)
    {
        $sex = array('0'=>'女','1'=>'男','2'=>'保密');
        return $sex[$value];
    }

    // // 获取入学年
    // public function getNianjiAttr()
    // {
    //     return $this->stuBanji()->ruxuenian;
    // }

    
}
