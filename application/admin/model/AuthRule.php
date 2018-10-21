<?php

namespace app\admin\model;

// 引用用户数据模型
use app\common\model\Base;

class AuthRule extends Base
{
    // 状态获取器
    public function getStatusAttr($value)
    {
        $status =array('1'=>'已启用','0'=>'已停用');
        return $status[$value];
    }

    // 顶级权限列表
    public function topRule()
    {
    	return $this
    			->where('pid',0)
    			->field('id,title')
    			->select();
    }


    // 是否是菜单获取器
    public function getIsmenuAttr($value)
    {
        $arr = array('0'=>'否','1'=>'是');

        return $arr[$value];
    }


    // 父级菜单名获取器
    public function getPidAttr($value)
    {

        return $this->where('id',$value)->value('title');
    }
}
