<?php
declare (strict_types = 1);

namespace app\kaoshi\model;

// 引用数据模型基类
use \app\BaseModel;

/**
 * @mixin \think\Model
 */
class TongjiXiangmu extends BaseModel
{
    // 查询记录
    public function search($srcfrom)
    {
        $src = [
            'searchval' => ''
        ];
        // 用新值替换初始值
        $src = array_cover($srcfrom, $src);

        // 查询数据
        $data = $this
            ->when(strlen($src['searchval']) > 0, function($query) use($src){
                    $query->where('title|biaoshi', 'like', '%' . $src['searchval']. ' %');
                })
            ->with([
                'tjxmCategory' => function ($q) {
                    $q->field('id,title');
                }
            ])
            ->select();

        return $data;
    }


    // 统计获取器
    public function getTongjiAttr($value)
    {
        $jg = 0;
        if($value === 1)
        {
            $jg = '参与';
        }else{
            $jg = '不参与';
        }
        return $jg;
    }


    // 查询统计
    public function srcTongji()
    {
        $data = $this->where('status', 1)
                ->where('tongji', 1)
                ->field('title, biaoshi')
                ->order(['paixu'])
                ->select()
                ->toArray();
        return $data;
    }


    // 类别关联
    public function tjxmCategory()
    {
        return $this->belongsTo('\app\system\model\Category', 'category_id', 'id');
    }
}
