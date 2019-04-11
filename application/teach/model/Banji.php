<?php

namespace app\teach\model;

// 引用数据模型基类
use app\common\model\Base;

class Banji extends Base
{
    
    // 查询所有班级
    public function search($src)
    {
        // 整理变量
        $school = $src['school'];
        $ruxuenian = $src['ruxuenian'];
        $searchval = $src['searchval'];

        // 查询数据
        $data = $this
            ->order([$src['field'] =>$src['order']])
            ->when(strlen($school)>0,function($query) use($school){
                    $query->where('school',$school);
                })
            ->when(strlen($ruxuenian)>0,function($query) use($ruxuenian){
                    $query->where('ruxuenian',$ruxuenian);
                })
            ->when(strlen($searchval)>0,function($query) use($searchval){
                    $query->where('title','like','%'.$searchval.'%');
                })
            ->with(
                [
                    'glSchool'=>function($query){
                        $query->field('id,title');
                    },
                    'glStudent'=>function($query){
                        $query->count();
                    },
                    // 'dwXueduan'=>function($query){
                    //     $query->field('id,title');
                    // },
                ]
            )
            ->append(['title'])
            ->select();
        return $data;
    }


    // 学校关联模型
    public function glSchool(){
        return $this->belongsTo('\app\system\model\School','school','id');
    }

    // 学校关联模型
    public function glStudent(){
        return $this->belongsTo('\app\renshi\model\Student','school','id');
    }


    // 班级名获取器
    public function getNumTitleAttr()
    {
    	$njname = nianjilist();
    	// $bjname = banjinamelist();
    	$nj = $this->getAttr('ruxuenian');
    	$bj = $this->getAttr('paixu');

        $numnj = array_flip(array_keys($njname));

        $numname = ($numnj[$nj] + 1).'.'.$bj;

    	return $numname;
    }



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
    // public function getSchoolAttr($value)
    // {
    // 	// 查询学校名称
    // 	$schoolname = db('school')->where('id',$value)->value('title');
    // 	// 返回学校名称
    // 	return $schoolname;
    // }



    // 班级学生数
    public function getStusumAttr()
    {
        // 返回学校名称
        return db('student')->where('banji',$this->getData('id'))->count();
    }


    // 根据学校和年级获取班级id
    public function getBanjiidsAttr()
    {
        return $this
            ->where('school',$this->getData('school'))
            ->where('ruxuenian',$this->getData('ruxuenian'))
            ->column('id,paixu');
    }
}
