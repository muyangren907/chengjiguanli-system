<?php
declare (strict_types = 1);

namespace app\listener;

// 实例化考试状态事件
use \app\event\MyEvent;

class MyBanjiIds
{
    // 调用跳转类
    use \liliuwei\think\Jump;

    /**
     * 事件监听处理
     *
     * @return mixed
     */
    public function handle($event)
    {
        $event = new MyEvent;
        $banji = $event->userInfo();
        return $banji;
    }
}
