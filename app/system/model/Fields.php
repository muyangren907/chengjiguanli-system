<?php

namespace app\system\model;

use app\common\model\Base;

class Fields extends Base
{

    // 编辑时间获取器
    public function getBianjitimeAttr($value)
    {
        return date('Y-m-d',$value);
    }

    // 查询文件是否重复上传
    public function hasHash($str=""){
    	$hasHash = 0;
    	$list = $this->where('hash',$str)->find();
    	if($list){
    		$hasHash = 1;
    	}
    	return $hasHash;
    }


    // 查询所有单位
    public function search($src)
    {
        // 查询数据
        $data = $this
            ->order([$src['field'] =>$src['type']])
            ->with([
                'flUser'=>function($query){
                    $query
                    ->field('id,xingming,school')
                        ->with([
                            'adSchool'=>function($q){
                                $q->field('id,jiancheng');
                            }
                        ]);
                }
                ,'flCategory'=>function($query){
                    $query
                    ->field('id,title');
                }
            ])
            ->select();

        return $data;
    }

    // 上传人数据关联
    public function  flUser()
    {
        return $this->belongsTo('\app\admin\model\Admin','userid','id');
    }

    // 文件种类数模型关联
    public function  flCategory()
    {
        return $this->belongsTo('\app\system\model\Category','category','id');
    }

}
