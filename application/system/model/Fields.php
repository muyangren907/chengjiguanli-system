<?php

namespace app\system\model;

use app\common\model\Base;

class Fields extends Base
{
	// 最后编辑时间修改器
	public function setBianjitimeAttr($value)
	{
		return strtotime($value);
	}  

    // 编辑时间获取器
    public function getBianjitimeAttr($value)
    {
        return date('Y-m-d',$value);
    }

}
