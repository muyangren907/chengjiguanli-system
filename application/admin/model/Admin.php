<?php

namespace app\admin\model;

// 引用用户数据模型
use app\common\model\Base;

class Admin extends Base
{
    // 查询所有角色
    public function search($src)
    {
        // 整理变量
        $searchval = $src['searchval'];

        // 查询数据
        $data = $this
            ->order([$src['field'] =>$src['order']])
            ->when(strlen($searchval)>0,function($query) use($searchval){
                    $query->where('xingming|username','like','%'.$searchval.'%');
                })
            ->with([
                'adSchool'=>function($query){
                    $query->field('id,jiancheng');
                }
                ,'glGroup'=>function($query){
                    $query->where('status',1)->field('title,rules,miaoshu');
                }
                    ])
            ->select();
        return $data;
    }

    public function glGroup()
    {
        return $this->belongsToMany('AuthGroup','AuthGroupAccess','group_id','uid');
    }


    // 用户角色获取器
    public function userGroup()
    {
        return $this->belongsToMany('AuthGroup','AuthGroupAccess','id','uid');
    }


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


    // 最后登录时间取器
    public function getLasttimeAttr($value)
    {
        return date('Y年m月d日 h:i:s',$value);
    }

    // 本次登录时间取器
    public function getThistimeAttr($value)
    {
        return date('Y年m月d日 h:i:s',$value);
    }


    // 角色关联
    public function authGroup()
    {
        return $this->hasMany('AuthGroupAccess','uid','id')->field('id,uid,group_id');
    }


    // // 获取角色id表
    // public function getGroupidsAttr()
    // {
    //     // 获取当前当前管理员信息
    //     $admin = $this->get($this->getAttr('id'));
    //     // 获取角色id
    //     $list = $admin->authgroup()->column('group_id');

    //     $str = '';
    //     // 将角色id转换成数组
    //     foreach ($list as $key => $value) {
    //         $key == 0 ? $str =$value : $str = $str.','.$value;
    //     }

    //     // 返回值
    //     return $str;
    // }

    // // 获取角色名称
    // public function getGroupnamesAttr()
    // {
    //     // 获取角色id
    //     $group = $this->get($this->getAttr('id'))->append(['groupids']);

    //     $str = '';
    //     // 查询角色名称
    //     $grouplist= db('AuthGroup')->where('id','in',$group->groupids)->column('title');
    //     // 重组角色名
    //     foreach ($grouplist as $key => $value) {
    //         if($key == 0){
    //             $str = $value;
    //         }else{
    //             $str = $str.'、'.$value;
    //         }
    //     }
    //     // 返回角色名
    //     return $str;
    // }

    // 单位关联模型
    public function adSchool()
    {
        return $this->belongsTo('\app\system\model\School','school','id');
    }



}
