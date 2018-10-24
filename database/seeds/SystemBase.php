<?php

use think\migration\Seeder;

class SystemBase extends Seeder
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
        $rows[] = [
            'create_time'   =>  time(),
            'update_time'   =>  time(),
            'title'         =>  '学生成绩统计系统',
            'keywords'      =>  '成绩统计,成绩管理',
            'description'   =>  '这是我们自己开发的系统',
            'copyright'     =>  '2018-2018',
            'thinks'        =>  'H-ui前端框架、ThinkPhp框架',
        ];
        // 保存数据
        $this->table('system_base')->insert($rows)->save();
    }
}