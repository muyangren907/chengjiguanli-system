<?php

namespace app\http\middleware;
// 引用权限验证类
// use \php4world;
use think\Controller;

class YanZheng  extends Controller
{
    public function handle($request, \Closure $next)
    {
    	// 实例化权限验证类
    	$auth = new \php4world\Auth();

		
		if( $auth->check('student', '1') ){// 第一个参数是规则名称,第二个参数是用户UID
		    dump('验证通过');
		}else{
		    dump('验证不通过');
		}



    	return $next($request);
    }
}
