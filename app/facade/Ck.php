<?php
namespace app\facade;

use think\Facade;

class Ck extends Facade
{
    protected static function getFacadeClass()
    {
    	return 'app\format\controller\CanKao';
    }
}
