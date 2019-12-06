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
            ->order([$src['field'] =>$src['type']])
            ->where('id','>',2)
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
            ->hidden(['password','create_time','update_time','delete_time'])
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


    // // 最后登录时间取器
    // public function getLasttimeAttr($value)
    // {
    //     return date('Y年m月d日 H:i:s',$value);
    // }

    // 本次登录时间取器
    public function getThistimeAttr($value)
    {
        return date('Y年m月d日 H:i:s',$value);
    }


    // 角色关联
    public function authGroup()
    {
        return $this->hasMany('AuthGroupAccess','uid','id')->field('id,uid,group_id');
    }


    // 获取角色名称
    public function getGroupnames($userid)
    {
        // 如果用户ID为1或2，则为超级管理员
        if($userid == 1 || $userid == 2)
        {
            return '超级管理员';
        }

        // 查询用户拥有的权限
        $admininfo = $this->where('id',$userid)
                        ->field('id')
                        ->with([
                            'glGroup'=>function($query){
                                $query->where('status',1)->field('title');
                            }
                        ])
                        ->find();
        $groupname = '';
        foreach ($admininfo->gl_group as $key => $value) {
            if($key == 0){
                $groupname = $value->title;
            }else{
                $groupname = $groupname.'、'.$value->title;
            }
        }

        // 返回角色名
        return $groupname;
    }

    // 单位关联模型
    public function adSchool()
    {
        return $this->belongsTo('\app\system\model\School','school','id');
    }



}
