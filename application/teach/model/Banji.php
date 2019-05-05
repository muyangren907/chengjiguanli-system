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
                ]
            )
            ->withCount([
                'glStudent'=>function($query){
                    $query->where('status',1);
                }
            ])
            ->append(['banjiTitle'])
            ->select();
        return $data;
    }


    // 学校关联模型
    public function glSchool(){
        return $this->belongsTo('\app\system\model\School','school','id');
    }

    // 学校关联模型
    public function glStudent(){
        return $this->hasMany('\app\renshi\model\Student','banji','id');
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
    public function getBanjiTitleAttr()
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

    // 班级名获取器
    public function getBanTitleAttr()
    {
        $bjname = banjinamelist();
        $bj = $this->getAttr('paixu');

        $bjkeys = array_keys($bjname);

        in_array($bj,$bjkeys) ? $title = $bjname[$bj] : $title = $bj.'班';

        return $title;
    }


    // 年级-班级关联表
    public function njBanji()
    {
        return $this->hasMany('Banji','ruxuenian','ruxuenian');
    }

}
