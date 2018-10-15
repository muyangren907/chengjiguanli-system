<?php

namespace app\member\model;

use think\Model;

class Member extends Model
{
    // 密码验证
    // $data = ['username'=>'aa,'password'=>'bb']
    public function check( $data = [] )
    {
    	// 验证用户名与密码是否匹配
    	$list = $this
    		->where('username',$data['username'])
    		->where('password',$data['password'])
    		->count();dump($list);

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
