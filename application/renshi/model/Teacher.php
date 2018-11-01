<?php

namespace app\renshi\model;

use app\common\model\Base;


class Teacher extends Base
{
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

    // 参加工作时间获取器
    public function getWorktimeAttr($value)
    {
    	return date('Y-m-d',$value);
    }

    // 参加工作时间修改器
    public function setWorktimeAttr($value)
    {
    	return strtotime($value);
    }


    // 性别获取器
    public function getSexAttr($value)
    {
        $sex = array('0'=>'女','1'=>'男','2'=>'保密');
        return $sex[$value];
    }


    // 获取类别名
    public function getcategory($id)
    {
        return db('category')
            ->where('id',$id)
            ->value('title');
    }


    // 单位获取器
    public function getDanweiAttr($value)
    {
        return db('school')->where('id',$value)->value('jiancheng');
    }

    // 职务获取器
    public function getZhiwuAttr($value)
    {
        return $this->getcategory($value);
    }

    // 职称获取器
    public function getZhichengAttr($value)
    {
        return $this->getcategory($value);
    }


    // 学历获取器
    public function getXueliAttr($value)
    {
        return $this->getcategory($value);
    }


}
