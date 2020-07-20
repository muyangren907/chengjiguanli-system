<?php

use think\migration\Migrator;
use think\migration\db\Column;

class SystemBase extends Migrator
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up()
    {
        // 定义表的名称
        $table = $this->table('system_base');

        // 给当前表添加字段
        $table
            ->addColumn('keywords','string',['limit'=>60,'null'=>false,'default'=>'尚码成绩管理,录入,统计,查询,管理','comment'=>'关键词'])
            ->addColumn('description','string',['limit'=>100,'null'=>false,'default'=>'尚码成绩统计系统，包含成绩采集、成绩统计、成绩查询等功能。适合一线的成绩统计系统才是好系统。','comment'=>'网站说明'])
            ->addColumn('thinks','string',['limit'=>80,'null'=>false,'default'=>'ThinkPHP,X-admin,百度Echarts,jquery','comment'=>'网站感谢'])
            ->addColumn('classmax','integer',['limit'=>11,'null'=>false,'default'=>'25','comment'=>'最大班级数'])
            ->addColumn('danwei','string',['limit'=>20,'null'=>false,'default'=>'大连长兴岛','comment'=>'使用单位'])
            ->addColumn('create_time','integer',['limit'=>11,'null'=>false,'default'=>1539158918,'comment'=>'创建时间'])
            ->addColumn('update_time','integer',['limit'=>11,'null'=>false,'default'=>1539158918,'comment'=>'更新时间'])
            ->addColumn('delete_time','integer',['limit'=>11,'null'=>true,'comment'=>'删除时间'])
            ->create();
    }
}
