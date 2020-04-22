<?php
declare (strict_types = 1);

namespace app\event;

use \app\kaoshi\model\Kaoshi;
use \app\kaoshi\model\TongjiLog;
use \app\Chengji\model\Chengji;

class MyEvent
{

    // 获取考试状态
    public function ksInfo($kaoshi_id = 0)
    {
        $kaoshi = new Kaoshi;
        $ksinfo = $kaoshi->kaoshiInfo($kaoshi_id);
        return $ksinfo;
    }


    // 添加考试统计日志
    public function addTongjiLog($kaoshi_id, $category)
    {
        // 添加统计日志
        $tjLog = new TongjiLog;
        $log = $tjLog::withTrashed()
                ->where('kaoshi_id', $kaoshi_id)
                ->where('category', $category)
                ->find();

        if(true == $log)
        {
            if($log->delete_time > 0)
            {
                $log->restore();
            }
            $log->update_time = time();
            $log->user_id = session('userid');
            $data = $log->save();
        }else{
            $data = $tjLog->save([
                'kaoshi_id' => $kaoshi_id,
                'category' => $category,
                'user_id' => session('userid'),
            ]);
        }

        $data ? $data = ['msg' => '更新成功', 'val' => 1]
            : $data = ['msg' => '数据处理错误', 'val' => 0];

        return $data;
    }

}
