<?php
// 命令空间
namespace app\kaohao\model;

// 引用数据模型基类
use \app\kaoshi\model\KaoshiBase;

class Kaohao extends KaoshiBase
{
    // 班级成绩关联
    public function banjiKaohao()
    {
        return $this->hasMany('\app\kaohao\model\Kaohao', 'banji_id', 'banji_id');
    }


    // 学校信息关联表
    public function cjSchool()
    {
    	return $this->belongsTo('\app\system\model\School', 'school_id', 'id');
    }


    // 班级信息关联表
    public function cjBanji()
    {
    	return $this->belongsTo('\app\teach\model\Banji', 'banji_id', 'id');
    }


    // 学生信息关联
    public function cjStudent()
    {
    	return $this->belongsTo('\app\student\model\Student', 'student_id', 'id');
    }


    // 考试关联
    public function cjKaoshi()
    {
    	return $this->belongsTo('\app\kaoshi\model\Kaoshi', 'kaoshi_id', 'id');
    }


    // 考试成绩
    public function ksChengji()
    {
        return $this->hasMany('\app\chengji\model\Chengji', 'kaohao_id', 'id');
    }


    // 获取参加考试的班级全名
    public function getBanjiTitleAttr()
    {
        $bj = banJiNamelist();
        $title = $this->getAttr('nianji') . $bj[$this->getAttr('paixu')];
        return $title;
    }


    // 获取不带年级的班级名
    public function getBanTitleAttr()
    {
        $bj = banJiNamelist();
        $title = $bj[$this->getAttr('paixu')];
        return $title;
    }
}





