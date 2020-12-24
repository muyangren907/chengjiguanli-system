<?php

use think\migration\Seeder;

class AuthGroup extends Seeder
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $auth = new \app\admin\model\AuthRule;
        $authList = $auth
                ->where('status', 1)
                ->column('id');
        $authList = implode(',', $authList);

        // 设置数据
        $rows= [
            [
                'title' => '管理员'
                ,'rules' => $authList
                ,'miaoshu' => '拥有所有权限'
            ]
        ];

        // 保存数据
        $this->table('auth_group')->insert($rows)->save();
    }
}