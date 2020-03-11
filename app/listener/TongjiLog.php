<?php
declare (strict_types = 1);

namespace app\listener;

use \app\event\MyEvent;

class TongjiLog
{
    /**
     * 事件监听处理
     *
     * @return mixed
     */
    public function handle($srcfrom)
    {
        $src = [
            'kaoshi_id' => '',
            'category' => '',
        ];
        // 用新值替换初始值
        $src = array_cover($srcfrom, $src) ;
        $event = new MyEvent;
        $tjLog = $event->addTongjiLog($src['kaoshi_id'], $src['category']);

        return true;
    }
}
