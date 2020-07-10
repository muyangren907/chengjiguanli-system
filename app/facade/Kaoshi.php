<?php
namespace app\facade;

use think\Facade;

class Kaoshi extends Facade
{
    protected static function getFacadeClass()
    {
    	return 'app\searchtools\Kaoshi';
    }
}
