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
            ->select();

        return $data;
    }
}
