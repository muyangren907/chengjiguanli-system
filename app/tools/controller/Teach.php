<?php
namespace app\tools\controller;

// 引用控制器基类
use app\BaseController;

class Teach extends BaseController
{

    // 获取类别列表
    public function srcChildren()
    {
        // 获取表单数据
        $src = request()->only([
            'limit' => '100'
            ,'p_id'
        ], 'post');
        // 查询类别
        $category = new \app\system\model\Category;
        $data = $category->srcChild($src)
            ->visible([
                'id'
                ,'title'
            ]);
        $data = reSetObject($data, $src);

        return json($data);
    }
}
