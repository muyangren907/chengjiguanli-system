<?php

use think\migration\Seeder;

class School extends Seeder
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
                'id' => 1
                ,'title' => '大连长岛经济区文教中心'
                ,'jiancheng' => '文教中心'
                ,'biaoshi' => ''
                ,'jibie_id' => 10204
                ,'xueduan_id'  =>  10303
                ,'paixu' => 10
                ,'kaoshi' => 1
                ,'xingzhi_id' => 10107
            ],
        ];
        // 保存数据
        $this->table('school')->insert($rows)->save();
    }
}
