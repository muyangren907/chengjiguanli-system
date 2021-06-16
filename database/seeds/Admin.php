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
                'xingming'  =>  '超级管理员一',
                'sex' => 1,
                'shengri' => "486489600",
                'username'  =>  'admin',
                'password'  =>  '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1',
                'school_id' =>  1,
                'phone' => "13190180000",
                'worktime' => "486489600",
                'zhicheng_id' => "10603",
                "xueli_id" => "10503",
                "quanpin" => "chaojiyi",
                "shoupin" => "cjy",
                "tuixiu" => 0,
            ],
            [
                'id'        =>  2,
                'xingming'  =>  '超级管理员二',
                'sex' => 1,
                'shengri' => "486489600",
                'username'  =>  'admin1',
                'password'  =>  '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1',
                'school_id' =>  1,
                'phone' => "13190180001",
                'worktime' => "486489600",
                'zhicheng_id' => "10603",
                "xueli_id" => "10503",
                "quanpin" => "chaojier",
                "shoupin" => "cje",
                "tuixiu" => 0,
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
