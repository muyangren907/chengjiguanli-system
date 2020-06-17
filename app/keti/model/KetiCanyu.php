<?php

namespace app\keti\model;

use app\BaseModel;

class KetiCanyu extends BaseModel
{
    // 课题册关联
    public function keti()
    {
    	return $this->belongsTo('\app\keti\model\Keti', 'ketiinfo_id', 'id');
    }


    // 教师关联
    public function teacher()
    {
    	return $this->belongsTo('\app\teacher\model\Teacher', 'teacher_id', 'id');
    }
}
