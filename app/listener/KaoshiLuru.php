<?php
declare (strict_types = 1);

namespace app\listener;

// 实例化考试状态事件
use \app\event\MyEvent;

class KaoshiLuru
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
        if($ksInfo->luru == 0)
        {
            return $this->error('本次考试已经不允许操作！','/login/err');
        }

        return $ksInfo;

    }
}
