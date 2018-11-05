<?php

namespace app\renshi\model;

use app\common\model\Base;
use app\teach\model\Banji;

class Student extends Base
{
    // 年龄获取器
    public function getAgeAttr()
    {
    	return getAgeByBirth($this->getdata('shengri'),2);
    }

    // 班级获取器
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

    // 性别获取器
    public function setSexAttr($value)
    {
        $sex = array('0'=>'女','1'=>'男','2'=>'保密');
        $val = array_search($value,$sex);
        return $val;
    }


}
