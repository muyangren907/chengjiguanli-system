<?php

use think\migration\Migrator;
use think\migration\db\Column;

class KaoshiNianji extends Migrator
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
        $table = $this->table('kaoshi_nianji');

        // 添加当前表字段
        $table
            ->addColumn('kaoshiid','integer',['limit'=>11,'null'=>false,'comment'=>'考试id'])
            ->addColumn('nianji','integer',['limit'=>80,'null'=>false,'comment'=>'年级'])
            ->addColumn('nianjiname','string',['limit'=>10,'null'=>false,'comment'=>'年级名'])
            ->addColumn('delete_time','integer',['limit'=>11,'null'=>true,'comment'=>'删除时间'])
            ->create();
    }
}
