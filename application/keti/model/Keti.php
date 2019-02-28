<?php

namespace app\keti\model;

// 引用数据模型基类
use app\common\model\Base;


class Keti extends Base
{
    //搜索课题册
    public function search($search)
    {
    	// 获取参数
    	$lxdanweiid = $search['lxdanweiid'];
    	$category = $search['category'];
    	$order_field = $search['order_field'];
    	$order = $search['order'];
    	$category = $search['category'];
    	$search = $search['search'];

    	$data = $this->order([$order_field =>$order])
    		->when(strlen($lxdanweiid)>0,function($query) use($lxdanweiid){
                	$query->where('lxdanweiid','in',$lxdanweiid);
                })
    		->when(strlen($category)>0,function($query) use($category){
                	$query->where('category','in',$category);
                })
    		->when(strlen($search)>0,function($query) use($search){
                	$query->where('title','like',$search);
                })
            ->with(
                [
                    'ktCategory'=>function($query){
                        $query->field('id,title');
                    },
                    'ktLxdanwei'=>function($query){
                        $query->field('id,title');
                    },
                ]
            )
            ->append(['ktcnt','jtcnt'])
    		->select();


    	return $data;
    }


    // 类型关联
    public function ktCategory()
    {
    	return $this->belongsTo('\app\system\model\Category','category','id');
    }


    // 立项单位关联
    public function ktLxdanwei()
    {
    	return $this->belongsTo('\app\system\model\School','lxdanweiid','id');
    }


    // 课题信息关联
    public function ktInfo()
    {
    	return $this->hasMany('KetiInfo','ketice','id');
    }


    // 立项时间获取器
    public function getLxshijianAttr($value)
    {
    	if ($value>0)
        {
            $value = date('Y-m-d',$value);
        }else{
            $value = "";
        }
        return $value;
    }


    // 立项时间
    public function setLxshijianAttr($value)
    {
    	return strtotime($value);
    }


    // 课题数量
    public function getKtcntAttr()
    {
    	return $this->ktInfo->count();
    }


    // 结题课题数量
    public function getJtcntAttr()
    {
    	return $this->ktInfo->where('jddengji','>',0)->where('jtshijian','>',0)->count();
    }
}
