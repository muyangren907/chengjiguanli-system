<?php

namespace app\renshi\model;

// 引用数据模型基类
use app\BaseModel;
// 引用班级数据模型类
use app\teach\model\Banji;

class Student extends BaseModel
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

    // 性别获取器
    public function getKaoshiAttr($value)
    {
        $sex = array('0'=>'不参加','1'=>'参加','2'=>'未知');
        return $sex[$value];
    }


    // 数据筛选
    public function search($srcfrom)
    {

        $src = [
            'field'=>'update_time',
            'order'=>'desc',
            'school'=>array(),
            'ruxuenian'=>array(),
            'banji'=>array(),
            'searchval'=>''
        ];

        // 用新值替换初始值
        $src = array_cover( $srcfrom , $src ) ;

        // 获取参数
        $school = $src['school'];
        $banji = $src['banji'];
        $searchval = $src['searchval'];

        $data = $this
                ->order([$src['field'] =>$src['order']])
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
                ->field('id,xingming,school,sex,shengri,banji,kaoshi,status')
                ->append(['age'])
                ->select();

        return $data;
    }


    // 查询毕业学生信息
    public function searchBy($srcfrom)
    {

        $src = [
            'field'=>'update_time',
            'order'=>'desc',
            'school'=>array(),
            'searchval'=>''
        ];

        // 用新值替换初始值
        $src = array_cover( $srcfrom , $src ) ;

        // 获取参数
        $school = $src['school'];
        $searchval = $src['searchval'];

        $njlist = array_keys(nianjiList());

        $bj = new \app\teach\model\Banji;
        $banji = $bj->where('ruxuenian','not in',$njlist)->column('id');

        $data = $this
                ->order([$src['field'] =>$src['order']])
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
                ->field('id,xingming,school,sex,shengri,banji,status')
                ->append(['age'])
                ->select();

        return $data;
    }


    // 查询删除学生信息
    public function searchDel($srcfrom)
    {

        $src = [
            'field'=>'update_time',
            'order'=>'desc',
            'school'=>array(),
            'ruxuenian'=>array(),
            'banji'=>array(),
            'searchval'=>''
        ];

        // 用新值替换初始值
        $src = array_cover( $srcfrom , $src ) ;

        // 获取参数
        $school = $src['school'];
        $banji = $src['banji'];
        $searchval = $src['searchval'];

        $data = $this::onlyTrashed()
                ->order([$src['field'] =>$src['order']])
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
                ->field('id,xingming,school,sex,shengri,banji,status')
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