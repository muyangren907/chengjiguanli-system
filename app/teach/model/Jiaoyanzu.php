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


    // 根据条件查询教研组
    public function search($srcfrom)
    {
        // 整理变量
        $src = [
            'category_id' => ''
            ,'searchval' => ''
            ,'status' => ''
        ];
        $src = array_cover($srcfrom, $src) ;

        $njlist = \app\facade\Tools::nianJiNameList(time(), 'str');
        $njlist[] = 0;

        // 查询数据
        $data = $this
            ->where('ruxuenian', 'in', $njlist)
            ->when(strlen($src['searchval']) > 0, function($query) use($src){
                    $query->where('title|xuenian', 'like', '%' . $src['searchval'] . '%');
                })
            ->when(strlen($src['category_id']) > 0, function($query) use($src){
                    $query->where('category_id', $src['category_id']);
                })
            ->when(strlen($src['status']) > 0, function($query) use($src){
                    $query->where('status', $src['status']);
                })
            ->with(
                [
                    'glCategory'=>function($query){
                        $query->field('id, title');
                    },
                ]
            )
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
}
