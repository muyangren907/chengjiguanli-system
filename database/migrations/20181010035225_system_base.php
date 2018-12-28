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
    public function change()
    {
        // 定义表的名称
        $table = $this->table('system_base');

        // 给当前表添加字段
        $table
            ->addColumn('create_time','integer',['limit'=>11,'null'=>false,'comment'=>'创建时间'])
            ->addColumn('update_time','integer',['limit'=>11,'null'=>false,'comment'=>'更新时间'])
            ->addColumn('title','string',['limit'=>50,'null'=>false,'comment'=>'网站名称'])
            ->addColumn('keywords','string',['limit'=>60,'null'=>false,'comment'=>'关键词'])
            ->addColumn('description','string',['limit'=>100,'null'=>false,'comment'=>'网站说明'])
            ->addColumn('thinks','string',['limit'=>80,'null'=>false,'comment'=>'网站感谢'])
            ->addColumn('danwei','string',['limit'=>20,'null'=>false,'comment'=>'使用单位'])
            ->addColumn('delete_time','integer',['limit'=>11,'null'=>true,'comment'=>'删除时间'])
            ->create();
    }
}
