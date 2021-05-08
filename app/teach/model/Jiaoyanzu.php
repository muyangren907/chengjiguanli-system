<?php

namespace app\teach\model;

use app\BaseModel;


/**
 * @mixin \think\Model
 */
class Jiaoyanzu extends BaseModel
{
    // 分类关联
    public function glCategory()
    {
        return $this->belongsTo('\app\system\model\Category', 'category_id', 'id');
    }


    // 教研组关联
    public function glSchool()
    {
        return $this->belongsTo('\app\system\model\School', 'school_id', 'id');
    }


    // 根据条件查询教研组
    public function search($srcfrom)
    {
        // 整理变量
        $src = [
            'category_id' => ''
            ,'searchval' => ''
            ,'school_id' => ''
            ,'status' => ''
        ];
        $src = array_cover($srcfrom, $src) ;
        $src['school_id'] = strToarray($src['school_id']);

        $njlist = \app\facade\Tools::nianJiNameList(time(), 'str');

        // 查询数据
        $data = $this
            ->where(function ($query) use($njlist) {
                $query
                    ->whereOr('ruxuenian', 'in', $njlist)
                    ->whereOr('ruxuenian', null);
            })
            ->when(strlen($src['searchval']) > 0, function($query) use($src){
                    $query->where('title|xuenian', 'like', '%' . $src['searchval'] . '%');
                })
            ->when(strlen($src['category_id']) > 0, function($query) use($src){
                    $query->where('category_id', $src['category_id']);
                })
            ->when(count($src['school_id']) > 0, function($query) use($src){
                    $query->where('school_id', $src['school_id']);
                })
            ->when(strlen($src['status']) > 0, function($query) use($src){
                    $query->where('status', $src['status']);
                })
            ->with(
                [
                    'glCategory'=>function($query){
                        $query->field('id, title');
                    },
                    'glSchool'=>function($query){
                        $query->field('id, title');
                    },
                ]
            )
            ->append(['zuzhang'])
            ->select();

        return $data;
    }

    // 学科修改器
    public function setsubjectIdAttr($value)
    {
        $value = implode('|', $value);
        return $value;
    }


    // 学科获取器
    public function getsubjectIdAttr($value)
    {
        $value = explode('|', $value);
        $subject = new \app\teach\model\Subject;
        $list = $subject
            ->where('id', 'in', $value)
            ->field('id, title, jiancheng')
            ->select();
        $str = '';
        foreach ($list as $key => $value) {
            $key == 0 ? $str = $value->title : $str = $str . '、'. $value->title;
        }
        return $str;
    }


    // 获取教研组名
    public function getTitleAttr($value)
    {
        $title = $value;
        if($this->category_id == 12501)
        {
            $njlist = \app\facade\Tools::nianJiNameList('str');
            $title = $njlist[$this->ruxuenian] . '组';
        }
        return $title;
    }


    // 获取组长
    public function getZuzhangAttr($value)
    {
        $zh = new \app\teach\model\JiaoyanZuzhang;
        $zhInfo = $zh->where('jiaoyanzu_id', $this->id)
            ->order(['bfdate' => 'desc'])
            ->with([
                'glTeacher' => function ($query) {
                    $query->field('id, xingming');
                }
            ])
            ->find(); 
            
        $str = ['id', 'xingming'];
        if ($zhInfo) {
            $str = [
                'id' => $zhInfo->teacher_id
                ,'xingming' => $zhInfo->glTeacher->xingming
            ];
        }

        return $str;
    }
}
