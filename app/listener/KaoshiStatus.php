<?php
declare (strict_types = 1);

namespace app\listener;

// 实例化考试状态事件
// use \app\event\KaoshiStatus as ksset;
use \app\kaoshi\model\Kaoshi;

class KaoshiStatus
{
    /**
     * 事件监听处理
     *
     * @return mixed
     */
    public function handle(\app\event\KaoshiStatus $event,$kaoshiid)
    {
    	$event->getKsStatus($kaoshiid);
    }    
}
