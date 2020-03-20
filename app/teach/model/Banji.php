<?php

namespace app\teach\model;

// 引用数据模型基类
use app\BaseModel;

class Banji extends BaseModel
{

    // 查询所有班级
    public function search($srcfrom)
    {
        // 整理变量
        $src = [
            'banji_school_id' => ''
            ,'banji_ruxuenian' => ''
            ,'banji_status' => ''
        ];
        $src = array_cover($srcfrom, $src) ;
        $src['banji_school_id'] = strToarray($src['banji_school_id']);
        $src['banji_ruxuenian'] = strToarray($src['banji_ruxuenian']);

        // 查询数据
        $data = $this
            ->when(count($src['banji_school_id']) > 0, function($query) use($src){
                    $query->where('school_id', 'in', $src['banji_school_id']);
                })
            ->when(count($src['banji_ruxuenian']) > 0, function($query) use($src){
                    $query->where('ruxuenian', 'in', $src['banji_ruxuenian']);
                })
            ->when(strlen($src['banji_status']) > 0, function($query) use($src){
                    $query->where('status', $src['banji_status']);
                })
            ->with(
                [
                    'glSchool'=>function($query){
                        $query->field('id, title');
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


    // 以年级分组查询班级
    public function searchNjGroup($srcfrom)
    {
        // 整理变量
        $src = [
            'banji_school_id' => ''
            ,'banji_ruxuenian' => ''
            ,'banji_status' => ''
        ];
        $src = array_cover($srcfrom, $src) ;
        $src['banji_ruxuenian'] = strToarray($src['banji_ruxuenian']);

        // 查询年级数据
        $data = self:: where('school_id',$src['banji_school_id'])
        ->where('ruxuenian','in',$src['banji_ruxuenian'])
        ->where('status',$src['banji_status'])
        ->group('ruxuenian')
        ->field('ruxuenian')
        ->with([
            'njBanji'=>function($query)use($src){
                $query->where('status',1)
                ->where('school_id',$src['banji_school_id'])
                ->field('id,ruxuenian,paixu')
                ->where('status',1)
                ->order('paixu')
                ->append(['banjiTitle','banTitle']);
            }
        ])
        ->select();

        return $data;
    }


    // 学校关联模型
    public function glSchool(){
        return $this->belongsTo('\app\system\model\School','school_id','id');
    }

    // 学校关联模型
    public function glStudent(){
        return $this->hasMany('\app\renshi\model\Student','banji','id');
    }


    // 班级名获取器
    public function getNumTitleAttr()
    {
    	// 获取基础信息
        $njname = nianjilist();     # 年级名对应表
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
        //获取班级、年级列表
        $njlist = nianjiList();
        $bjlist = banjinamelist();

        $nj = $this->getAttr('ruxuenian');
        $bj = $this->getAttr('paixu');

        // 获取班级名
        if( array_key_exists($nj,$njlist)==true )
        {
            $title = $njlist[$nj] . $bjlist[$bj];
        }else{
            $title = $nj . '届' . $bj . '班';
        }

        return $title;
    }

    // 班名获取器
    public function getBanTitleAttr()
    {
        $bjname = banjinamelist();
        $bj = $this->getAttr('paixu');

        // 获取班级名
        if( array_key_exists($bj,$bjname)==true )
        {
            $title = $bjname[$bj];
        }else{
            $title = $bj . '班';
        }


        $del = $this->getAttr('delete_time');
        $del==null ?  $title : $title=$title&'(删)' ;

        return $title;
    }


    // 年级-班级关联表
    public function njBanji()
    {
        return $this->hasMany('Banji','ruxuenian','ruxuenian');
    }


    /**
     * 获取考试时的班级名称(文本格式-一年级十一班)
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

        // 如果该班级被删除，则标删除
        if($bjinfo->delete_time != null)
        {
            $bjtitle = $bjtitle.'(删)';
        }

        return $bjtitle;
    }


}