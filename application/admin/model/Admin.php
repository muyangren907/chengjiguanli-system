<?php

namespace app\admin\model;

use think\Model;

class Admin extends Model
{
    // 密码验证
    public function check( $username ,$password )
    {
    	// 验证用户名与密码是否匹配
    	$list = $this
    		->where('username',$username)
    		->where('password',$password)
    		->value('id');

    	return $list;
    }

    public function miyao($username)
    {
    	// 查询数据 
    	$miyao = $this
    		->where('username',$username)
    		->value('miyao');

    	// 返回数据
    	return $miyao;
    }
}
