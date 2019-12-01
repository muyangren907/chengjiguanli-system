<?php

namespace app\keti\model;

use think\Model;

class KetiCanyu extends Model
{
    // 课题册关联
    public function keti()
    {
    	return $this->belongsTo('\app\keti\model\Keti','ketiinfoid','id');
    }

    // 教师关联
    public function teacher()
    {
    	return $this->belongsTo('\app\renshi\model\Teacher','teacherid','id');
    }
}
