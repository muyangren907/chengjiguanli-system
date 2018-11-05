<?php

namespace app\teach\model;

use app\common\model\Base;

class Banji extends Base
{
    // 班级名获取器
    public function getTitleAttr()
    {
    	$njname = nianjilist();
    	$bjname = banjinamelist();
    	$nj = $this->getAttr('ruxuenian');
    	$bj = $this->getAttr('paixu');

        $njkeys = array_keys($njname);
        $bjkeys = array_keys($bjname);

        in_array($nj,$njkeys) ? $title = $njname[$nj] : $title = $nj.'届';
        in_array($bj,$bjkeys) ? $title = $title.$bjname[$bj] : $title = $title.$bj.'班';

    	return $title;
    }

    // 学校获取器
    public function getSchoolAttr($value)
    {
    	// 查询学校名称
    	$schoolname = db('school')->where('id',$value)->value('title');
    	// 返回学校名称
    	return $schoolname;
    }



    // 班级学生数
    public function getStusumAttr()
    {
        // 返回学校名称
        return db('student')->where('banji',$this->getData('id'))->count();
    }
}
