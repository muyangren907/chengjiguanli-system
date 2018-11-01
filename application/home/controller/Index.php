<?php

namespace app\home\controller;

// 引用控制器基类
use app\common\controller\Base;

class Index extends Base
{
	public function index()
	{
		$this->error('不好意思，您访问的页面不存在~');
	}
}
