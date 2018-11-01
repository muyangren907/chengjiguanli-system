<?php

use think\migration\Migrator;
use think\migration\db\Column;

class Category extends Migrator
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
        $table = $this->table('category');

        // 添加当前表字段
        $table
            ->addColumn('title','string',['limit'=>15,'null'=>false,'comment'=>'类型标题'])
            ->addColumn('pid','integer',['limit'=>4,'default'=>'0','null'=>false,'comment'=>'父级ID'])
            ->addColumn('status','boolean',['limit'=>1,'default'=>'1','null'=>false,'comment'=>'0=禁用，1=正常'])
            ->addColumn('paixu','integer',['limit'=>4,'default'=>'999','null'=>false,'comment'=>'排序'])
            ->addColumn('delete_time','integer',['limit'=>11,'null'=>true,'comment'=>'删除时间'])
            ->addColumn('beizhu','string',['limit'=>80,'null'=>true,'comment'=>'备注'])
            ->create();
    }
}