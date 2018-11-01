<?php

use think\migration\Migrator;
use think\migration\db\Column;

class Subject extends Migrator
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
        $table = $this->table('subject');

        // 添加当前表字段
        $table
            ->addColumn('title','string',['limit'=>25,'null'=>false,'comment'=>'学科名称'])
            ->addColumn('jiancheng','string',['limit'=>6,'null'=>false,'comment'=>'简称'])
            ->addColumn('category','string',['limit'=>11,'null'=>false,'comment'=>'大学科类别'])
            ->addColumn('paixu','integer',['limit'=>4,'default'=>'999','null'=>false,'comment'=>'排序'])
            ->addColumn('status','boolean',['limit'=>1,'default'=>'1','null'=>false,'comment'=>'0=禁用，1=正常'])
            ->addColumn('create_time','integer',['limit'=>11,'null'=>true,'comment'=>'创建时间'])
            ->addColumn('update_time','integer',['limit'=>11,'null'=>true,'comment'=>'更新时间'])
            ->addColumn('delete_time','integer',['limit'=>11,'null'=>true,'comment'=>'删除时间'])
            ->addColumn('beizhu','string',['limit'=>80,'null'=>true,'comment'=>'备注'])
            ->create();
    }
}