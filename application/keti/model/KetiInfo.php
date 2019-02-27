<?php

namespace app\Keti\model;

// 引用数据模型基类
use app\common\model\Base;

class KetiInfo extends Base
{
    //搜索课题册
    public function search($search)
    {
    	// 获取参数
    	$lxdanweiid = $search['lxdanweiid'];
    	$lxcategory = $search['lxcategory'];
    	$fzdanweiid = $search['fzdanweiid'];
        $subject = $search['subject'];
        $category = $search['category'];
    	$order_field = $search['order_field'];
    	$order = $search['order'];
    	$search = $search['search'];

    	$data = $this->order([$order_field =>$order])
    		->when(!empty($lxdanweiid),function($query) use($lxdanweiid){
                	$query->where('ketice','in',function ($q) use($lxdanweiid){
                        $q->name('keti')->where('lxdanweiid','in',$lxdanweiid)->field('id');
                    });
                })
    		->when(!empty($lxcategory),function($query) use($lxcategory){
                	$query->where('ketice','in',function($q) use($lxcategory){
                        $q->name('keti')->where('category','in',$lxcategory)->field('id');
                    });
                })
    		->when(!empty($fzdanweiid),function($query) use($fzdanweiid){
                	$query->where('fzdanweiid','in',$fzdanweiid);
                })
            ->when(!empty($subject),function($query) use($subject){
                    $query->where('subject','in',$subject);
                })
            ->when(!empty($category),function($query) use($category){
                    $query->where('category','in',$category);
                })
    		->when(!empty($search),function($query) use($search){
                	$query->where('title','like',$search);
                })
            // ->with(
            //     [
            //         'ktCategory'=>function($query){
            //             $query->field('id,title');
            //         },
            //         'ktLxdanwei'=>function($query){
            //             $query->field('id,title');
            //         },
            //     ]
            // )
            ->append(['zcrName'])
    		->select();


    	return $data;
    }


    // 课题主持人关联
    public function ktZcr()
    {
        return $this->hasMany('\app\keti\model\KetiCanyu','ketiinfoid','id')->where('category',1);
    }


    // 课题主持人名单整理
    public function getZcrNameAttr($value)
    {
        $teacherList = $this->getAttr('ktZcr');
        $teachNames = "";
        $i = 0;
        foreach ($teacherList as $key => $value) {
            # code...
            if($i == 0)
            {
                $teachNames = $value['teacher']['xingming'];
            }else{
                $teachNames = $teachNames . '、' .$value['teacher']['xingming'];
            }
            $i++;
        }

        return $teachNames;

    }



}
