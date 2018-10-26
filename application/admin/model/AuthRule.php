<?php

namespace app\admin\model;

// 引用用户数据模型
use app\common\model\Base;

class AuthRule extends Base
{

    // 顶级权限列表
    public function getRule($pid = 0)
    {
    	return $this
    			->where('pid',$pid)
                ->where('status',1)
    			->field('id,title')
                ->order(['paixu'])
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


    // 获取二级菜单
    public function getMymenuAttr($value)
    {
        return $this
            ->where('pid',$this->getAttr('id'))
            ->where('status&ismenu',1)
            ->field('title,url')
            ->order(['paixu'])
            ->select();
    }


  

}
