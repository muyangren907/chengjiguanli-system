<?php

namespace app\renshi\model;

// 引用数据模型基类
use app\common\model\Base;
// 引用班级数据模型类
use app\teach\model\Banji;

class Student extends Base
{
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
    	if(strlen($this->getData('shengri')) == 0){
            return '';
        };
        return getAgeByBirth($this->getData('shengri'),2);
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


    // 数据筛选
    public function search($src)
    {
        // 获取参数
        $school = $src['school'];
        $banji = $src['banji'];
        $searchval = $src['searchval'];


        $data = $this
                ->order([$src['field'] =>$src['type']])
                ->when(count($school)>0,function($query) use($school){
                    $query->where('school','in',$school);
                })
                ->when(strlen($searchval)>0,function($query) use($searchval){
                        $query->where('xingming','like','%'.$searchval.'%')->field('id');
                })
                ->where('banji','in',$banji)
                ->with([
                    'stuSchool'=>function($query){
                        $query->field('id,title');
                    },
                    'stuBanji'=>function($query){
                        $query->field('id,ruxuenian,paixu')->append(['banjiTitle']);
                    }
                ])
                ->field('id,xingming,school,sex,shengri')
                ->append(['age'])
                ->select();

        return $data;
    }


    // 获取全部数据
    public function searchAll()
    {
        return $this->select();
    }




    
}
