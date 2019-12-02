<?php
declare (strict_types = 1);

namespace app\middleware;

use think\exception\HttpResponseException;
use think\Auth AS AuthHandle;
use traits\controller\Jump;

class Auth
{
    use Jump;
    /**
     * 处理请求
     *
     * @param \think\Request $request
     * @param \Closure       $next
     * @return Response
     */
    public function handle($request, \Closure $next)
    {
        // 白名单
        $allow = ['user/login'];

        $rule = strtolower("{$request->controller()}/{$request->action()}");
        
        // 初始化 user_id
        $user_id = is_login();

        // 权限检查
        $check = AuthHandle::check($rule, $user_id);
        if (false === $check) {
            $this->error('[403] 未授权访问');
        }

        return $next($request);
    }
}
