<?php

use think\migration\Migrator;
use think\migration\db\Column;

class AuthGroup extends Migrator
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
        // 定义数据表名称
        $table = $this->table('auth_rule_group');

        // 添加当前表字段
        $table
            ->addColumn('title','string',['limit'=>100,'default'=>'','null'=>true,'comment'=>'用户组中文名称'])
            ->addColumn('rules','string',['limit'=>300,'default'=>'','null'=>true,'comment'=>'用户组拥有的规则id'])
            ->addColumn('status','boolean',['default'=>true,'null'=>true,'comment'=>'用户组状态'])
            ->addColumn('delete_time','integer',['limit'=>11,'null'=>false,'comment'=>'删除时间'])
            ->create();
    }
}
