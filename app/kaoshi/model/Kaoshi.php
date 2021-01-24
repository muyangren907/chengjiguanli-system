<?php

namespace app\kaoshi\model;

// 引用数据模型基类
use \app\BaseModel;


class Kaoshi extends BaseModel
{
    // 查询所有考试
    public function search($srcfrom)
    {
        $src = [
            'field' => 'id'
            ,'order' => 'desc'
            ,'zuzhi_id' => array()
            ,'xueqi_id' => ''
            ,'category_id' => array()
            ,'searchval' => ''
            ,'user_group' => 'everyone'
            ,'user_id' => ''
        ];
        // 用新值替换初始值
        $src = array_cover($srcfrom, $src);
        $src['zuzhi_id'] = strToarray($src['zuzhi_id']);
        $src['xueqi_id'] = strToarray($src['xueqi_id']);
        $src['category_id'] = strToarray($src['category_id']);

        // 查询数据
        $data = $this
            ->order([$src['field'] =>$src['order']])
            ->when(strlen($src['searchval']) > 0, function($query) use($src){
                    $query->where('title', 'like', '%' . $src['searchval']. ' %');
                })
            ->when(strlen($src['user_group']) > 0, function($query) use($src){
                    $query->where('user_group', $src['user_group'])
                        ->when($src['user_group'] == 'teacher', function($q) use($src){
                            $q->where('user_id', $src['user_id']);
                    });
                })
            ->when(count($src['zuzhi_id']) > 0, function($query) use($src){
                    $query->where('zuzhi_id', 'in', $src['zuzhi_id']);
                })
            ->when(count($src['xueqi_id']) > 0, function($query) use($src){
                    $query->where('xueqi_id', 'in', function($q)use($src){
                        $q->name('xueqi')
                            ->where('category_id', 'in', $src['xueqi_id'])
                            ->field('id');
                    });
                })
            ->when(count($src['category_id']) > 0, function($query) use($src){
                    $query->where('category_id', 'in', $src['category_id']);
                })
            ->with(
                [
                    'ksCategory' => function ($query) {
                        $query->field('id, title');
                    }
                    ,'ksZuzhi' => function ($query) {
                        $query->field('id, title, jiancheng');
                    }
                    ,'ksXueqi' => function ($query) {
                        $query->field('id, title');
                    }
                ]
            )
            ->append(['ckSubject', 'ckNianji'])
            ->select();

        return $data;
    }


    // 本次考试信息，包含ID、标题、状态、是否允许编辑成绩
    public function kaoshiInfo($id = 0)
    {
        // 获取参考年级
        $kaoshiList = $this->where('id', $id)
                ->field('id, title, status, luru, bfdate, enddate')
                ->find();
        return $kaoshiList;
    }


    // 开始时间修改器
    public function setBfdateAttr($value)
    {
        return strtotime($value);
    }


    // 开始时间获取器
    public function getBfdateAttr($value)
    {
        return date('Y-m-d', $value);
    }


    // 结束时间修改器
    public function setEnddateAttr($value)
    {
        // 设置结束时间为当年的最后1秒
        $sj = $value . ' 23:59:59';
        return strtotime($sj);
    }


    // 结束时间获取器
    public function getEnddateAttr($value)
    {
        return date('Y-m-d', $value);
    }


    // 参考学科获取器
    public function getCkSubjectAttr($value)
    {
        // 查询参考学科
        $ksset = new \app\kaoshi\model\KaoshiSet;
        $src = [
            'kaoshi_id' => $this->getAttr('id')
        ];
        $subject = $ksset->srcSubject($src);
        // 重新整理数据
        $str = '';
        if(isset($subject))
        {
            $i = 0;
            foreach ($subject as $key => $value) {
                if($i == 0)
                {
                    $str = $value['jiancheng'];
                }else{
                    $str = $str . '、' . $value['jiancheng'];
                }
                $i = $i + 1;
            }
        }

        return $str;
    }


    // 参考年级获取器
    public function getCkNianjiAttr($value)
    {
        // 查询参考年级
        $ksset = new \app\kaoshi\model\KaoshiSet;
        $data = $ksset->srcGrade($this->getAttr('id'));
        // 重新整理数据
        $str = '';
        if(isset($data))
        {
            $i = 0;
            foreach ($data as $key => $value) {
                $temp = substr($value['nianjiname'], 0, 3);
                if($i == 0)
                {
                    $str = $temp;
                }else{
                    $str = $str . '、' . $temp;
                }
                $i = $i + 1;
            }
        }
        return $str;
    }


    // 考试设置关联表
    public function ksSet()
    {
        return $this->hasMany('KaoshiSet', 'kaoshi_id', 'id');
    }


    // 参考类别关联表
    public function ksCategory()
    {
        return $this->belongsTo('\app\system\model\Category', 'category_id', 'id');
    }


    // 考试成绩关联表
    public function ksChengji()
    {
        return $this->hasMany('\app\chengji\model\Chengji', 'kaoshi_id', 'id');
    }


    // 考试组织单位关联表
    public function ksZuzhi()
    {
        return $this->belongsTo('\app\system\model\School', 'zuzhi_id', 'id');
    }


    // 学期
    public function ksXueqi()
    {
        return $this->belongsTo('\app\teach\model\Xueqi', 'xueqi_id', 'id');
    }



}
