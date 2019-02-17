<?php

namespace app\kaoshi\model;

use app\common\model\Base;

class KaoshiSubject extends Base
{
    // 关联学科
    public function subject()
    {
    	return $this->belongsTo('\app\teach\model\Subject','subjectid','id');
    }
}