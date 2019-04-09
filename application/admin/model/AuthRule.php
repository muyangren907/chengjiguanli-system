<?php

namespace app\admin\model;

// 引用用户数据模型
use app\common\model\Base;

class AuthRule extends Base
{

    // 父级菜单数据模型关联
    public function authPid()
    {
        return $this->belongsTo('AuthRule','pid','id');
    }


    // 子菜单数据模型关联
    public function authCid()
    {
        return $this->hasMany('AuthRule','pid','id');
    }
    

    // 获取全部权限列表
    public function all()
    {
        return $this
            ->where('status',1)
            ->where('pid',0)
            ->with(['authCid'=>function($query){
                $query->with(['authCid'=>function($q){
                    $q->field('id,title,pid,paixu');
                }])->field('id,title,pid,paixu');
            }])
            ->field('id,title,pid,paixu')
            ->order(['paixu'])
            ->select();
    }
}
