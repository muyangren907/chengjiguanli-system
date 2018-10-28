<?php

namespace app\admin\model;

// 引用用户数据模型
use app\common\model\Base;

class Admin extends Base
{
    // 获取密码
    public function password($username)
    {
    	// 查询数据 
    	$pasW = $this
    		->where('username',$username)
    		->value('password');

    	// 返回数据
    	return $pasW;
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

    // 创建时间获取器
    public function getCreateTimeAttr($value)
    {
        return date('Y-m-d',$value);
    }

    // 性别获取器
    public function getSexAttr($value)
    {
        $sex = array('0'=>'女','1'=>'男','2'=>'保密');
        return $sex[$value];
    }



}
