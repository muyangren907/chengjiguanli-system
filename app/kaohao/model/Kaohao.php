<?php
// 命令空间
namespace app\kaohao\model;

// 引用数据模型基类
use \app\BaseModel;

class Kaohao extends BaseModel
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
        $title = $this->getAttr('nianji') . self::getBanTitleAttr();
        return $title;
    }


    // 获取该班级各学科成绩满分
    public function getBanjiFenshuxianAttr()
    {
        $ksset = new \app\kaoshi\model\KaoshiSet;
        $srcfrom = [
            'kaoshi_id' => $this->kaoshi_id
            ,'ruxuenian' => $this->ruxuenian
        ];

        // 初始化参数
        $src = array(
            'kaoshi_id' => '0'
            ,'ruxuenian' => array()
            ,'subject_id' => array()
            ,'searchval' => ''
        );
        $src = array_cover($srcfrom, $src);
        $src['ruxuenian'] = strToarray($src['ruxuenian']);
        $src['subject_id'] = strToarray($src['subject_id']);

        $manfen = $ksset->search($src)
                ->visible([
                    'subject_id'
                    ,'youxiu'
                    ,'jige'
                ])
                ->toArray();

        return $manfen;
    }


    // 获取不带年级的班级名
    public function getBanTitleAttr()
    {
        $bj = new \app\teach\model\Banji;
        $alias = \app\facade\System::sysClass();
        if($alias->classalias)
        {
            $title = $bj->where('id', $this->getAttr('banji_id'))->value('alias');
            if($title == '')
            {
                $title = $bj->numToWord($this->getAttr('paixu')) . '班';
            }else{
                $title = $title . '班';
            }
        }else{
            $title = $bj->numToWord($this->getAttr('paixu')) . '班';
        }
        return $title;
    }


    // 获取参加考试班级数字名
    public function getNumBanjiTitleAttr()
    {
        $njList = array_values(\app\facade\Tools::nianJiNameList('str', time()));
        $nianji = array_search($this->getAttr('nianji'), $njList);
        if ($nianji)
        {
            $title = $nianji . '.' . $this->getAttr('paixu');
        } else {
            $title = $this->getAttr('ruxuenian') . $this->getAttr('paixu');
        }

        return $title;
    }
}





