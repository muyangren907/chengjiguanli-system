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
        // 定义表的名称
        $rows = [
            [
                'id'        =>  1,
                'xingming'  =>  '超级管理员1',
                'username'  =>  'admin',
                'school_id' =>  1,
                'password'  =>  '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1',
            ],
            [
                'id'        =>  2,
                'xingming'  =>  '超级管理员2',
                'username'  =>  'admin1',
                'school_id'    =>  1,
                'password'  =>  '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1',
            ],
        ];

        $serRows = $this->fetchAll('select * from cj_admin');
        if(is_array($serRows) && count($serRows) > 0)
        {
            $rows = array();
            return true;
        }
        
        // 保存数据
        $this->table('admin')->insert($rows)->update();
    }

}
