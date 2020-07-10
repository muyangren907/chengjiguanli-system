<?php
declare (strict_types = 1);

namespace app\Kaoshi\model;

// 引用数据模型基类
use \app\kaoshi\model\KaoshiBase;

/**
 * @mixin think\Model
 */
class TongjiLog extends KaoshiBase
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
                        'userName' => function ($query) {
                            $query->field('id, xingming');
                        }
                        ,'tjCategory' => function ($query) {
                            $query->field('id, title');
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
    public function getUrlAttr()
    {
        $src = [
            12001 => '/chengji/bjtj/tongji',
            12003 => '/chengji/njtj/tongji',
            12005 => '/chengji/schtj/tongji',
            12002 => '/chengji/bjtj/bjorder',
            12004 => '/chengji/njtj/njorder',
            12006 => '/chengji/schtj/schorder',
        ];

        $val = $this->getData('category_id');

        return $src[$val];
    }


    // 学科关联
    public function userName()
    {
        return $this->belongsTo('\app\admin\model\Admin', 'user_id', 'id');
    }


    // 考试成绩关联表
    public function tjCategory()
    {
        return $this->belongsTo('\app\system\model\Category', 'category_id', 'id');
    }

}
