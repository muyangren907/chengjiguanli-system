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
    

    // 查询所有角色
    public function search($src)
    {
        // 整理变量
        $searchval = $src['searchval'];

        // 查询数据
        $data = $this
            ->order([$src['field'] =>$src['order']])
            ->when(strlen($searchval)>0,function($query) use($searchval){
                    $query->where('title|name','like','%'.$searchval.'%');
                })
            ->with(['authPid'=>function($query){
                $query->field('id,title');
            }])
            ->select();
        return $data;
    }


    // 递归权限
    public function srcChildren($arr=array())
    {
        if(count($arr)==0 && $pid==0)
        {
            $arr = $this->where('pid',0)
                ->where('status',1)
                ->field('id,name,title,condition,paixu,ismenu,url,pid,type')
                ->select()
                ->toArray();
        }

        $getArr = array();

        foreach ($arr as $key => $value) {
            $temp = $this->where('pid',$value['pid'])
                ->where('status',1)
                ->field('id,name,title,condition,paixu,ismenu,url,pid,type')
                ->select()
                ->toArray();
            if(count($temp)>0)
            {
                // $getArr['pid'] = $this->srcChildren($temp,$value['pid']);
            }else{
               // $getArr['pid'] = $temp; 
            }
        }

        $getArr[$value['pid']] = $temp;
      
        return $getArr;
    }
}
