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
            'keywords'      =>  '成绩统计,成绩管理,成绩分析',
            'description'   =>  '适合的才是好用的。',
            'thinks'        =>  'ThinkPHP,X-admin,百度Echarts,jquery。',
            'danwei'        =>  '大连长兴岛经济区教科培中心',
        ];
        // 保存数据
        $this->table('system_base')->insert($rows)->save();
    }
}