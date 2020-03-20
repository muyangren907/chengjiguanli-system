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
            'keywords'      =>  '码蚁成绩,成绩统计,成绩管理,成绩分析,成绩查询',
            'description'   =>  '前端采用X-admin，后端采用Thinkphp。寻找最方便的录入成绩方法，提供最丰富的统计项目。',
            'thinks'        =>  'ThinkPHP,X-admin,百度Echarts,jquery，同时感谢为码蚁提出意见或建议的朋友，和正在使用码蚁系统的朋友们。',
            'danwei'        =>  '大连长兴岛经济区',
        ];
        // 保存数据
        $this->table('system_base')->insert($rows)->save();
    }
}
