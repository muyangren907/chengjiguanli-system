<?php

use think\migration\Seeder;

class Teacher extends Seeder
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
        // 设置数据
        $rows= [
            [
                'xingming' => '嬴政'
                ,'sex' => 1
                ,'shengri' => 533491200
                ,'worktime' => 1188144000
                ,'danwei_id' =>2
                ,'quanpin' => 'yingzheng'
                ,'shoupin' => 'yz'
                ,'phone' => 13190180000
                ,'password' => '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1'
            ]
        ];

        // 保存数据
        $this->table('teacher')->insert($rows)->save();
    }
}