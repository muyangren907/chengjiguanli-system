<?php
namespace app\facade;

use think\Facade;

class OnLine extends Facade
{
    protected static function getFacadeClass()
    {
    	return '\app\formattools\controller\OnLine';
    }
}
