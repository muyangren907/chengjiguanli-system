<?php
declare (strict_types = 1);

namespace app\event;

use \app\kaoshi\model\Kaoshi;

class KaoshiStatus
{
	
	use \liliuwei\think\Jump; 

	// 判断考试状态，如果状态为0，则跳转页面
	public function getKsStatus($kaoshiid=0)
	{
		$kaoshi = new Kaoshi;
		$ksinfo = $kaoshi->kaoshiInfo($kaoshiid);
		if($ksinfo->status == 0)
        {
            return $this->error('考试状态为禁用，不允许操作！','/login/err');
        }
        return $ksinfo;
	}

}
