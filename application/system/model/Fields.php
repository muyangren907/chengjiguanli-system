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

}
