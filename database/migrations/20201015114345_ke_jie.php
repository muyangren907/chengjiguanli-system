<?php

use think\migration\Migrator;
use think\migration\db\Column;

class KeJieShiJian extends Migrator
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
        $table = $this->table('ke_jie');

        // 添加当前表字段
        $table
            ->addColumn('title','string',['limit'=>100,'default'=>'a','null'=>false,'default'=>0,'comment'=>'课节名称'])
            ->addColumn('paike','boolean',['default'=>1,'null'=>false,'comment'=>'是否排课，默认排课'])
            ->addColumn('status','boolean',['default'=>1,'null'=>false,'comment'=>'状态'])
            ->addColumn('create_time','integer',['limit'=>11,'default'=>'1539158918','null'=>false,'comment'=>'创建时间'])
            ->addColumn('update_time','integer',['limit'=>11,'default'=>'1539158918','null'=>false,'comment'=>'更新时间'])
            ->addColumn('delete_time','integer',['limit'=>11,'null'=>true,'comment'=>'删除时间'])
            ->addColumn('beizhu','string',['limit'=>80,'null'=>true,'comment'=>'备注'])
            ->create();
    }
}
