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
                'title'=>'大连长兴岛经济区教研科研培训中心',
                'jiancheng'=>'教科培中心',
                'biaoshi'=>'',
                'jibie'=>'3',
            ],
        ];
        // 保存数据
        $this->table('school')->insert($rows)->save();
    }
}