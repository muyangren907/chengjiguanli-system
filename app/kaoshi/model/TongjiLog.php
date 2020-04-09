<?php
declare (strict_types = 1);

namespace app\Kaoshi\model;

// 引用数据模型基类
use app\BaseModel;

/**
 * @mixin think\Model
 */
class TongjiLog extends BaseModel
{
    // 查询统计记录
    public function search($srcfrom)
    {
        $src = [
            'kaoshi_id' => '',
            'cjlast' => 0,
        ];
        $src = array_cover($srcfrom, $src) ;
        $src['date'] = date('Y-m-d h:i:s', $src['cjlast']);

        $logList = self::where('kaoshi_id',$src['kaoshi_id'])
                    ->with([
                        'userName'=>function($query){
                            $query->field('id, xingming');
                        }
                    ])
                    ->append(['url'])
                    ->select();

        foreach ($logList as $key => $value) {
            $logList[$key]->cjlast = $src['date'];
        }

        return $logList;
    }

    // 开始时间获取器
    public function getCategoryIdAttr($value)
    {
        $src = [
            'bjtj' => '班级统计'
            ,'njtj' => '年级统计'
            ,'schtj' => '区统计'
            ,'bjwz' => '班级位置'
            ,'njwz' => '年级位置'
            ,'schwz' => '区位置'
        ];

        return $src[$value];
    }

    // 开始时间获取器
    public function getUrlAttr()
    {
        $src = [
            'bjtj' => '/chengji/bjtj/tongji',
            'njtj' => '/chengji/njtj/tongji',
            'schtj' => '/chengji/schtj/tongji',
            'bjwz' => '/chengji/bjtj/bjorder',
            'njwz' => '/chengji/njtj/njorder',
            'schwz' => '/chengji/schtj/schorder',
        ];

        $val = $this->getData('category_id');

        return $src[$val];
    }

    // 学科关联
    public function userName()
    {
        return $this->belongsTo('\app\admin\model\Admin', 'user_id', 'id');
    }

}
