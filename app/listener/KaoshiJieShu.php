<?php
declare (strict_types = 1);

namespace app\listener;

// 实例化考试状态事件
use \app\event\MyEvent;

class KaoshiJieShu
{
    /**
     * 事件监听处理
     *
     * @return mixed
     */

    use \liliuwei\think\Jump;

    public function handle($kaoshi_id)
    {
        $event = new MyEvent;
        $ksInfo = $event->ksInfo($kaoshi_id);
        if($ksInfo->status == 0)
        {
            return $this->error('本次考试已经结束，不能操作！','/login/err');
        }

        return $ksInfo;
    }
}
