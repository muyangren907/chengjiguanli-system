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
            'school_id' => ''
            ,'ruxuenian' => ''
            ,'status' => ''
        ];
        $src = array_cover($srcfrom, $src);
        $src['school_id'] = strToarray($src['school_id']);
        $src['ruxuenian'] = strToarray($src['ruxuenian']);

        // 查询数据
        $data = $this
            ->when(count($src['school_id']) > 0, function($query) use($src){
                    $query->where('school_id', 'in', $src['school_id']);
                })
            ->when(count($src['ruxuenian']) > 0, function($query) use($src){
                    $query->where('ruxuenian', 'in', $src['ruxuenian']);
                })
            ->when(strlen($src['status']) > 0, function($query) use($src){
                    $query->where('status', $src['status']);
                })
            ->with(
                [
                    'glSchool'=>function($query){
                        $query->field('id, title, jiancheng');
                    },
                ]
            )
            ->withCount([
                'glStudent'=>function($query){
                    $query->where('status', 1);
                }
            ])
            ->append(['banjiTitle', 'banTitle'])
            ->select();

        return $data;
    }


    // 以年级分组查询班级
    public function searchNjGroup($srcfrom)
    {
        // 整理变量
        $src = [
            'school_id' => ''
            ,'ruxuenian' => ''
            ,'status' => ''
            ,'field' => 'paixu'
            ,'order' => 'asc'
        ];
        $src = array_cover($srcfrom, $src) ;
        $src['ruxuenian'] = strToarray($src['ruxuenian']);

        // 查询年级数据
        $data = self:: where('school_id', $src['school_id'])
        ->where('ruxuenian', 'in', $src['ruxuenian'])
        ->where('status', $src['status'])
        ->group('ruxuenian')
        ->field('ruxuenian')
        ->with([
            'njBanji'=>function($query)use($src){
                $query->where('status',1)
                ->where('school_id', $src['school_id'])
                ->field('id, ruxuenian, paixu')
                ->where('status', 1)
                ->order('paixu')
                ->append(['banjiTitle', 'banTitle']);
            }
        ])
        ->order([$src['field'] => $src['order']])
        ->select();

        return $data;
    }


    // 学校关联模型
    public function glSchool(){
        return $this->belongsTo('\app\system\model\School', 'school_id', 'id');
    }


    // 学校关联模型
    public function glStudent(){
        return $this->hasMany('\app\renshi\model\Student', 'banji_id', 'id');
    }


    // 班级名获取器
    public function getNumTitleAttr()
    {
    	// 获取基础信息
        $njname = nianjilist();     # 年级名对应表
    	$nj = $this->getAttr('ruxuenian');
    	$bj = $this->getAttr('paixu');
        $numnj = array_flip(array_keys($njname));

        if(array_key_exists($nj, $numnj))
        {
            $numname = ($numnj[$nj] + 1) . '.' . $bj;
        }else{
            $numname = $nj . '.' . $bj;
        }

    	return $numname;
    }


    // 班级名获取器
    public function getBanjiTitleAttr()
    {
        //获取班级、年级列表
        $njlist = nianJiNameList();
        $bjlist = banJiNamelist();

        $nj = $this->getAttr('ruxuenian');
        $bj = $this->getAttr('paixu');

        // 获取班级名
        if( array_key_exists($nj,$njlist) == true )
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
        if( array_key_exists($bj,$bjname) == true )
        {
            $title = $bjname[$bj];
        }else{
            $title = $bj . '班';
        }


        $del = $this->getAttr('delete_time');
        $del == null ?  $title : $title = $title & '(删)' ;

        return $title;
    }


    // 年级-班级关联表
    public function njBanji()
    {
        return $this->hasMany('Banji', 'ruxuenian', 'ruxuenian');
    }


    /**
     * 获取考试时的班级名称(文本格式-一年级十一班)
     * $jdshijian 考试开始时间
     * $ruxuenian 年级
     * $paixu 班级
     * 返回 $str 班级名称
     * */
    public function myBanjiTitle($bjid, $jdshijian=0)
    {
        // 查询班级信息
        $bjinfo = $this::withTrashed()
            ->where('id', $bjid)
            ->field('id, ruxuenian, paixu, delete_time')
            ->find();

        //获取班级、年级列表
        $njlist = nianjiList($jdshijian);
        $bjlist = banjinamelist();

        if(array_key_exists($bjinfo->ruxuenian, $njlist))
        {
            $bjtitle = $njlist[$bjinfo->ruxuenian] . $bjlist[$bjinfo->paixu];
        }else{
            $bjtitle = $bjinfo->ruxuenian . '界' . $bjinfo->paixu . '班';
        }

        // 如果该班级被删除，则标删除
        if($bjinfo->delete_time != null)
        {
            $bjtitle = $bjtitle . '(删)';
        }

        return $bjtitle;
    }


    /**
    * 将“一年级一班”格式的班级名转换成入学年和班级排序
    * $str是原文件格式
    * 返回班级ID
    */
    public function srcBanJiID($str, $school_id)
    {
        if(stristr($str,'年级', true) === false  || stristr($str, '班' , true) === false)
        {
            return false;
        }
        // 获取年级、班级列表
        $njlist = nianJiNameList();
        $bjlist = banJiNameList();

        $nj = substr($str, 0, 9);
        $bj = substr($str, 9, strlen($str) - 9);

        $nj = array_search($nj, $njlist);
        $bj = array_search($bj, $bjlist);

        // 查询班级id
        $banji = new \app\teach\model\Banji;
        $id = $banji->where('ruxuenian', $nj)
                ->where('paixu', $bj)
                ->where('school_id', $school_id)
                ->value('id');

        return $id;
    }


}
