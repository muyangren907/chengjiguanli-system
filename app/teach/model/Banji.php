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
            // ->order('school','ruxuenian','paixu')
            ->order([$src['field'] =>$src['type']])
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

        if(array_key_exists($nj,$numnj))
        {
            $numname = ($numnj[$nj] + 1).'.'.$bj;
        }else{
            $numname = $nj.'.'.$bj;
        }
        

    	return $numname;
    }



    // 班级名获取器
    public function getBanjiTitleAttr()
    {
        // 获取班级名
        $title = $this->myBanjiTitle($this->getAttr('id'));
        return $title;
    }

    // 班名获取器
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


    /**
     * 获取考试时的班级名称
     * $jdshijian 考试开始时间
     * $ruxuenian 年级
     * $paixu 班级
     * 返回 $str 班级名称 
     * */ 
    public function myBanjiTitle($bjid,$jdshijian=0)
    {
        // 查询班级信息
        $bjinfo = $this::withTrashed()
            ->where('id',$bjid)
            ->field('id,ruxuenian,paixu,delete_time')
            ->find();


        //获取班级、年级列表
        $njlist = nianjiList($jdshijian);
        $bjlist = banjinamelist();

        if(array_key_exists($bjinfo->ruxuenian,$njlist))
        {
            $bjtitle = $njlist[$bjinfo->ruxuenian].$bjlist[$bjinfo->paixu];
        }else{
            $bjtitle = $bjinfo->ruxuenian.'界'.$bjinfo->paixu.'班';
        }

        // 如果该班级被删除，则瓢删除
        if($bjinfo->delete_time != null)
        {
            $bjtitle = $bjtitle.'(删)';
        }

        return $bjtitle;
    }

}
