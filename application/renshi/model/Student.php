<?php

namespace app\renshi\model;

// 引用数据模型基类
use app\common\model\Base;
// 引用班级数据模型类
use app\teach\model\Banji;

class Student extends Base
{
    // 班级关联
    public function stuNanji()
    {
        return $this->belongsTo('\app\teach\model\Banji','banji','id')->bind(['myruxuenian'=>'ruxuenian']);
    }
    // 班级关联
    public function stuBanji()
    {
        return $this->belongsTo('\app\teach\model\Banji','banji','id');
    }

    // 学校获取器
    public function stuSchool()
    {
        return $this->belongsTo('\app\system\model\School','school','id');
    }

    // 年龄获取器
    public function getAgeAttr()
    {
    	return getAgeByBirth($this->getdata('shengri'),2);
    }


    // 生日修改器
    public function setShengriAttr($value)
    {
        return strtotime($value);
    }

    // 生日获取器
    public function getShengriAttr($value)
    {
        return date('Y-m-d',$value);
    }

    // 性别获取器
    public function getSexAttr($value)
    {
        $sex = array('0'=>'女','1'=>'男','2'=>'保密');
        return $sex[$value];
    }

    // // 获取入学年
    // public function getNianjiAttr()
    // {
    //     return $this->stuBanji()->ruxuenian;
    // }

    // 数据筛选
    public function searchMany($search)
    {
        // 设置变量
        $schoolid = $search['school'];
        $banji = $search['banji'];
        $order = $search['order'];
        $order_field = $search['order_field'];
        $search = $search['search'];



        $data = $this->field('id,xingming,sex,shengri,banji,school,status')
                ->when(!empty($schoolid),function($query) use($schoolid){
                    $query->where('school','in',$schoolid);
                })
                ->when(!empty($banji),function($query) use($banji){
                    $query->where('banji','in',$banji);
                })
                ->when(!empty($search),function($query) use($search){
                        $query->where('xingming','like','%'.$search.'%')->field('id');
                })
                ->order([$order_field=>$order])
                ->select();

        return $data;
    }


    // 获取全部数据
    public function searchAll()
    {
        return $this->select();
    }




    
}
