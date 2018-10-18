<?php

namespace app\admin\model;

use think\Model;

class Admin extends Model
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
    public function setShenriAttr($value)
    {
        return strtotime($value);
    }
}
