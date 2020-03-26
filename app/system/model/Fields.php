<?php

namespace app\system\model;

use app\BaseModel;

class Fields extends BaseModel
{

    // 编辑时间获取器
    public function getBianjitimeAttr($value)
    {
        return date('Y-m-d H:i:s', $value);
    }


    // 查询文件是否重复上传
    public function hasHash($str=""){
    	$hasHash = 0;
    	$list = $this->where('hash', $str)->find();
    	if($list){
    		$hasHash = 1;
    	}
    	return $hasHash;
    }


    // 查询所有单位
    public function search($srcfrom)
    {
        // 整理条件
        $src = [
            'searchval' => ''
        ];
        $src = array_cover($srcfrom, $src) ;

        // 查询数据
        $data = $this
            ->when(strlen($src['searchval']) > 0, function($query) use($src){
                    $query->where('oldname', 'like', '%' . $src['searchval'] . '%');
                })
            ->with([
                'flUser' => function($query){
                    $query
                    ->field('id, xingming, school_id')
                        ->with([
                            'adSchool' => function($q){
                                $q->field('id, jiancheng');
                            }
                        ]);
                }
                ,'flCategory' => function($query){
                    $query
                    ->field('id, title');
                }

            ])
            ->select();

        return $data;
    }

    // 上传人数据关联
    public function  flUser()
    {
        return $this->belongsTo('\app\admin\model\Admin', 'user_id', 'id');
    }

    // 文件种类数模型关联
    public function  flCategory()
    {
        return $this->belongsTo('\app\system\model\Category', 'category_id', 'id');
    }

}
