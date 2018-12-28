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

}
