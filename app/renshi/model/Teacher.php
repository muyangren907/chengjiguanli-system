<?php

namespace app\renshi\model;

use app\common\model\Base;


class Teacher extends Base
{
    

    //搜索单位获奖荣誉
    public function search($srcfrom)
    {
        $src = [
            'field'=>'update_time',
            'type'=>'desc',
            'zhiwu'=>array(),
            'danwei'=>array(),
            'xueli'=>array(),
            'tuixiu'=>0,
            'searchval'=>'',
        ];
        // 用新值替换初始值
        $src = array_cover( $srcfrom , $src ) ;



        // 获取参数
        $zhiwu = $src['zhiwu'];
        $danwei = $src['danwei'];
        $xueli = $src['xueli'];
        $searchval = $src['searchval'];


        $data = $this->order([$src['field'] =>$src['type']])
            ->when(count($danwei)>0,function($query) use($danwei){
                    $query->where('danwei','in',$danwei);
                })
            ->when(count($zhiwu)>0,function($query) use($zhiwu){
                    $query->where('zhiwu','in',$zhiwu);
                })
            ->when(count($xueli)>0,function($query) use($xueli){
                    $query->where('xueli','in',$xueli);
                })
            ->where('tuixiu',$src['tuixiu'])
            ->when(strlen($searchval)>0,function($query) use($searchval){
                    $query->where('xingming|quanpin|shoupin','like','%'.$searchval.'%');
                })
            ->with(
                [
                    'jsDanwei'=>function($query){
                        $query->field('id,jiancheng');
                    },
                    'jsZhiwu'=>function($query){
                        $query->field('id,title');
                    },
                    'jsZhicheng'=>function($query){
                        $query->field('id,title');
                    },
                    'jsXueli'=>function($query){
                        $query->field('id,title');
                    },
                    'jsSubject'=>function($query){
                        $query->field('id,title');
                    },
                ]
            )
            ->append(['age','gongling'])
            ->select();


        return $data;
    }



    //搜索单位获奖荣誉
    public function searchDel($srcfrom)
    {
        $src = [
            'field'=>'update_time',
            'type'=>'desc',
            'zhiwu'=>array(),
            'danwei'=>array(),
            'xueli'=>array(),
            'searchval'=>''
        ];
        // 用新值替换初始值
        $src = array_cover( $srcfrom , $src ) ;



        // 获取参数
        $zhiwu = $src['zhiwu'];
        $danwei = $src['danwei'];
        $xueli = $src['xueli'];
        $searchval = $src['searchval'];


        $data = $this::onlyTrashed()
            ->order([$src['field'] =>$src['type']])
            ->when(count($danwei)>0,function($query) use($danwei){
                    $query->where('danwei','in',$danwei);
                })
            ->when(count($zhiwu)>0,function($query) use($zhiwu){
                    $query->where('zhiwu','in',$zhiwu);
                })
            ->when(count($xueli)>0,function($query) use($xueli){
                    $query->where('xueli','in',$xueli);
                })
            ->when(strlen($searchval)>0,function($query) use($searchval){
                    $query->where('xingming|quanpin|shoupin','like','%'.$searchval.'%');
                })
            ->with(
                [
                    'jsDanwei'=>function($query){
                        $query->field('id,jiancheng');
                    },
                    'jsZhiwu'=>function($query){
                        $query->field('id,title');
                    },
                    'jsZhicheng'=>function($query){
                        $query->field('id,title');
                    },
                    'jsXueli'=>function($query){
                        $query->field('id,title');
                    },
                    'jsSubject'=>function($query){
                        $query->field('id,title');
                    },
                ]
            )
            ->append(['age','gongling'])
            ->select();


        return $data;
    }


    // 职务关联模型
    public function jsZhiwu()
    {
        return $this->belongsTo('\app\system\model\Category','zhiwu','id');
    }


    // 职称关联模型
    public function jsZhicheng()
    {
        return $this->belongsTo('\app\system\model\Category','zhicheng','id');
    }

    // 学历关联模型
    public function jsXueli()
    {
        return $this->belongsTo('\app\system\model\Category','xueli','id');
    }

    // 单位关联模型
    public function jsDanwei()
    {
        return $this->belongsTo('\app\system\model\School','danwei','id');
    }

    // 学科关联模型
    public function jsSubject()
    {
        return $this->belongsTo('\app\teach\model\Subject','subject','id');
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

    // 参加工作时间获取器
    public function getWorktimeAttr($value)
    {
    	return date('Y-m-d',$value);
    }

    // 参加工作时间修改器
    public function setWorktimeAttr($value)
    {
    	return strtotime($value);
    }


    // 性别获取器
    public function getSexAttr($value)
    {
        $sex = array('0'=>'女','1'=>'男','2'=>'未知');
        return $sex[$value];
    }

    // 退休获取器
    public function getTuixiuAttr($value)
    {
        $sex = array('0'=>'否','1'=>'是','2'=>'未知');
        return $sex[$value];
    }


    
    // 年龄获取器
    public function getAgeAttr()
    {
        return getAgeByBirth($this->getdata('shengri'),2);
    }


    // 工龄获取器
    public function getGonglingAttr()
    {
        return getAgeByBirth($this->getdata('worktime'),2);
    }


    


}
