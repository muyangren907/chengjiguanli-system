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
    	$category = $search['category'];
    	$fzschool = $search['fzschool'];
    	$order_field = $search['order_field'];
    	$order = $search['order'];
    	$category = $search['category'];
    	$search = $search['search'];

    	$data = $this->order([$order_field =>$order])
    		->when(!empty($lxdanweiid),function($query) use($lxdanweiid){
                	$query->where('lxdanweiid','in',$lxdanweiid);
                })
    		->when(!empty($category),function($query) use($category){
                	$query->where('category','in',$category);
                })
    		->when(!empty($fzschool),function($query) use($fzschool){
                	$query->where('title','in',$fzschool);
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
            // ->append(['ktcnt','jtcnt'])
    		->select();


    	return $data;
    }
}
