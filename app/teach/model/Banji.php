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
        if(count($src['ruxuenian']) == 0)
        {
            $njname = $this->gradeName('num', time());     # 年级名对应表
            $src['ruxuenian'] = array_values($njname);
        }

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
                    'glSchool' => function($query){
                        $query->field('id, title, jiancheng');
                    },
                    // 'glBanZhuRen' => function ($query) {
                    //     $query->field('id, teacher_id, banji_id, bfdate');
                    // }
                ]
            )
            ->withCount([
                'glStudent'=>function($query){
                    $query->where('status', 1);
                }
            ])
            ->append(['banjiTitle', 'banTitle', 'grade', 'ban','bzr'])
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
            ,'status' => '1'
        ];
        $src = array_cover($srcfrom, $src) ;
        $src['ruxuenian'] = strToarray($src['ruxuenian']);

        // 查询年级数据
        $data = self:: where('school_id', $src['school_id'])
        ->where('ruxuenian', 'in', $src['ruxuenian'])
        ->where('status', $src['status'])
        ->distinct(true)
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
        ->select();

        return $data;
    }


    // 学校关联模型
    public function glSchool(){
        return $this->belongsTo('\app\system\model\School', 'school_id', 'id');
    }


    // 学校关联模型
    public function glStudent(){
        return $this->hasMany('\app\student\model\Student', 'banji_id', 'id');
    }


    // 年级-班级关联表
    public function njBanji()
    {
        return $this->hasMany('Banji', 'ruxuenian', 'ruxuenian');
    }


    // 年级-班级关联表
    public function glBanZhuRen()
    {
        return $this->hasMany('BanZhuRen', 'banji_id', 'id')
            ->order(['bfdate'=>'desc', 'update_time'=>'desc']);
    }


    // 班级名获取器
    public function getNumTitleAttr()
    {
    	// 获取基础信息
        $njname = $this->gradeName('str', time());     # 年级名对应表
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
        $title = self::getGradeAttr() . self::getBanTitleAttr();
        return $title;
    }


    // 班名获取器
    public function getBanTitleAttr()
    {

        $alias = \app\facade\System::sysClass();
        if($alias->classalias)
        {
            $title = $this->alias;
            if($title == '')
            {
                $bj = $this->getAttr('paixu');
                $title = self::numToWord($bj) . '班';
                $del = $this->getAttr('delete_time');
                $del == null ?  $title : $title = $title & '(删)' ;
            }else{
                $title = $title . '班';
            }
        }else{
            $bj = $this->getAttr('paixu');
            $title = self::numToWord($bj) . '班';
            $del = $this->getAttr('delete_time');
            $del == null ?  $title : $title = $title & '(删)' ;
        }

        return $title;
    }


    // 班级名获取器
    public function getGradeAttr()
    {
        $njList = $this->gradeName('str', time());
        if(isset($njList[$this->getAttr('ruxuenian')]))
        {
            $title = $njList[$this->getAttr('ruxuenian')];
        }else{
            $title = $this->getAttr('ruxuenian') . '界';
        }
        return $title;
    }


    // 班名获取器
    public function getBanAttr()
    {
        $bj = $this->getAttr('paixu');
        $title = self::numToWord($bj) . '班';

        $del = $this->getAttr('delete_time');
        $del == null ?  $title : $title = $title & '(删)' ;

        return $title;
    }


    // 班主任获取器
    public function getBzrAttr()
    {
        $bzrList = $this->glBanZhuRen;
        $str = '';
        if (isset($bzrList[0]))
        {
            $str = $bzrList[0]->glTeacher->xingming;
        }

        return $str;
    }


    // /**
    //  * 获取考试时的班级名称(文本格式-一年级十一班)
    //  * $jdshijian 考试开始时间
    //  * $ruxuenian 年级
    //  * $paixu 班级
    //  * 返回 $str 班级名称
    //  * */
    // public function myBanjiTitle($bjid, $jdshijian=0)
    // {
    //     // 查询班级信息
    //     $bjinfo = $this::withTrashed()
    //         ->where('id', $bjid)
    //         ->field('id, ruxuenian, paixu, delete_time')
    //         ->find();

    //     //获取班级、年级列表
    //     $njlist = $this->gradeName($jdshijian);

    //     if(array_key_exists($bjinfo->ruxuenian, $njlist))
    //     {
    //         $bjtitle = $njlist[$bjinfo->ruxuenian] . self::numToWord($bjinfo->paixu) . '班';
    //     }else{
    //         $bjtitle = $bjinfo->ruxuenian . '界' . self::numToWord($bjinfo->paixu) . '班';
    //     }

    //     // 如果该班级被删除，则标删除
    //     if($bjinfo->delete_time != null)
    //     {
    //         $bjtitle = $bjtitle . '(删)';
    //     }

    //     return $bjtitle;
    // }


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
        $njlist = $this->gradeName('str', time());
        $bjlist = $this->className();

        $find = strpos($str,"级") + 3;
        $nj = substr($str, 0, $find);
        $bj = substr($str, $find, strlen($str) - $find);

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


    /**
    * 格式化班级名称
    * $grade  入学年
    * $paixu   班级排序
    * $category 是否返回汉字
    * 返回班级ID
    */
    public function fClassTitle($grade = 1950, $jiedian = 0, $paixu = 1, $category = true)
    {
        //获取班级、年级列表
        $njlist = $this->gradeName('str', $jiedian);
        $title = '';
        if( isset($njlist[$grade]) )
        {
            switch ($category) {
                case true:
                    $title = $njlist[$grade] . self::numToWord($paixu) . '班';
                    break;
                default:
                    $njlist = array_flip(array_keys($njlist));
                    $title = $njlist[$grade].''.$paixu;
                    break;
            }
        }else{
            switch ($category) {
                case true:
                    $title = $grade . '界' . self::numToWord($paixu) . '班';
                    break;
                default:
                    $njlist = array_flip(array_keys($njlist));
                    $title = $njlist[$grade].'.'.$paixu;
                    break;
            }
        }

        return $title;
    }


    // 生成年级名
    public function gradeName($value = 'str', $riqi=0)
    {
        // 定义学年时间节点日期为每年的8月1日
        // $yd = '8-1';
        $sysClass = \app\facade\System::sysClass();
        $jd = date('-m-d', $sysClass->getData('xuenian'));

        if($riqi == 0)
        {
            $jiedian = strtotime(date('Y') . $jd);
            $thisday = time();
            $nian = date('Y');
        }else{
            $jiedian = strtotime(date('Y', $riqi) . $jd);
            $thisday = $riqi;
            $nian = date('Y', $riqi);
        }

        $thisday <= $jiedian ? $str = 1 : $str = 0;
        $nian = $nian - $str;

        // 获取年级最大数
        $gradelist = explode('|', $sysClass->gradelist);
        $gradeMax = count($gradelist);

        $njlist = array();
        if($value != 'str')
        {
            for($i = 0; $i < $gradeMax; $i ++)
            {
                $njlist[$gradelist[$i]] = $nian - $i;
            }
        }else{
            for($i = 0; $i < $gradeMax; $i ++)
            {
                $njlist[$nian - $i] = $gradelist[$i];
            }
        }
        return $njlist;
    }


    // 班级列表
    public function className()
    {

        $sys = \app\facade\System::sysClass();
        $classmax = $sys->classmax;

        $bjarr = array();
        for($i = 1; $i <= $classmax; $i++)
        {
            $bjarr[$i] = self::numToWord($i) . '班';
        }
        return $bjarr;
    }


    public function numToWord($num)
    {
        if(!preg_match("/^[1-9][0-9]*$/", $num))
        {
            return '';
        }
        $chiUni = array('', '万', '亿', '万');
        $cnt = strlen($num);  #取数字长度
        $num = (string)$num;
        $chiStr = '';

        //分割数组
        $x = 0;
        $y = 0;
        for ($i = $cnt - 1; $i >= 0; $i --) {
            if($x < 4)
            {
                $arr[$y][$x] = $num[$i];
            }else{
                $x = 0;
                $y = $y + 1;
                $arr[$y][$x] = $num[$i];
            }
            $x = $x + 1;
        }

        foreach ($arr as $key => $value) {
            // 判断有几位数
            $cnt = count($value);
            $thisStr = self::numTo($value, $key);

            if($thisStr == '零')
            {
                $chiStr = self::numTo($value, $key) . $chiStr;
            }else{
                $chiStr = self::numTo($value, $key) . $chiUni[$key] . $chiStr;
            }
        }

        $chiStr = str_replace("零零", "零", $chiStr);
        return $chiStr;
    }


    private function numTo($arr = array(), $key = 0)
    {
        $cnt = count($arr);
        $chiNum = array('零', '一', '二', '三', '四', '五', '六', '七', '八', '九');
        $chiUni = array('','十', '百', '千');
        $chiStr = '';
        $zero = true;  # 上一个数字是否为0
        $key = $key * 4;
        if($cnt == 0 || array_sum($arr) == 0)
        {
            return $chiNum[0];
        }
        switch ($cnt) {
            case 2:
                $temp = $arr[1];
                if($temp == 1)
                {
                    $chiStr = $chiUni[1];
                }else{
                    $chiStr = $chiNum[$temp] . $chiUni[1];
                }
                $temp = $arr[0];
                $temp != 0 ? $chiStr = $chiStr . $chiNum[$temp] : '' ;
                break;
            default:
                for($i = 0; $i<$cnt; $i++)
                {
                    $temp = $arr[$i];
                    if($temp == 0)
                    {
                        if($zero != true)
                        {
                            $chiStr = $chiNum[$temp] .$chiStr;
                        }
                        $zero = true;
                    }else{
                        $chiStr = $chiNum[$temp] . $chiUni[$i] .$chiStr;
                        $zero = false;
                    }
                }
                break;
        }
        return $chiStr;
    }


}
