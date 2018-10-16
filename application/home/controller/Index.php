<?php

namespace app\home\controller;

// 引用控制器基类
use app\common\controller\Base;

class Index extends Base
{

    /**
     * 操作成功跳转
     *
     * @return \think\Response
     */
    public function mysuccess($msg = '操作成功~')
    {
        // 模版赋值   
        $this->assign('msg',$msg);

        // 跳转页面
        return $this->fetch();
    }


    /**
     * 操作失败跳转
     *
     * @return \think\Response
     */
    public function notfound ($msg = '不好意思，您访问的页面不存在~' )
    {
        if (session('?msg'))
        {
            $msg = session('msg');
            session('msg', null);
        }


        // 模版赋值   
        $this->assign('msg',$msg);

        // 跳转页面
        return $this->fetch();
    }

   
    
}
