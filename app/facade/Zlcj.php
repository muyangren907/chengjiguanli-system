<?php
namespace app\facade;

use think\Facade;

class Zlck extends Facade
{
    protected static function getFacadeClass()
    {
    	return 'app\zhengli\ZlOne';
    }
}
