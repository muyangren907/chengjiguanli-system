<?php

use think\migration\Seeder;

class Admin extends Seeder
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
        // 初始化超级管理员
        $rows = [
            [
                'id'        =>  1,
                'xingming'  =>  '超级管理员1',
                'username'  =>  'admin',
                'school'    =>  1,
                'password'  =>  '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1',
            ],
            [
                'id'        =>  2,
                'xingming'  =>  '超级管理员2',
                'username'  =>  'admin1',
                'school'    =>  1,
                'password'  =>  '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1',
            ],

    ];
        // 保存数据
        $this->table('admin')->insert($rows)->save();
    }

}