<?php

use think\migration\Migrator;
use think\migration\db\Column;

class Fields extends Migrator
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
        $table = $this->table('fields');

        // 添加当前表字段
        $table
            ->addColumn('text','string',['limit'=>100,'null'=>false,'comment'=>'文件内容'])
            ->addColumn('oldname','string',['limit'=>100,'null'=>false,'comment'=>'原文件名'])
            ->addColumn('bianjitime','integer',['limit'=>11,'null'=>false,'comment'=>'最后编辑时间'])
            ->addColumn('newname','string',['limit'=>100,'null'=>false,'comment'=>'新文件名'])
            ->addColumn('category','string',['limit'=>100,'null'=>false,'comment'=>'文件类型'])
            ->addColumn('fieldsize','integer',['limit'=>11,'null'=>false,'comment'=>'文件大小'])
            ->addColumn('hash','integer',['string'=>100,'null'=>false,'comment'=>'散列值'])
            ->addColumn('userid','integer',['limit'=>11,'null'=>false,'comment'=>'用户ID'])
            ->addColumn('url','string',['limit'=>100,'null'=>true,'comment'=>'文件储存位置'])
            ->addColumn('create_time','integer',['limit'=>11,'null'=>true,'comment'=>'创建时间'])
            ->addColumn('update_time','integer',['limit'=>11,'null'=>true,'comment'=>'更新时间'])
            ->addColumn('delete_time','integer',['limit'=>11,'null'=>true,'comment'=>'删除时间'])
            ->create();
    }
}
