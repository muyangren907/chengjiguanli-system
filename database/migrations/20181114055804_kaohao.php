<?php

use think\migration\Migrator;
use think\migration\db\Column;

class Kaohao extends Migrator
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
        $table = $this->table('kaohao');

        // 添加当前表字段
        $table
            ->addColumn('kaoshi','integer',['limit'=>11,'null'=>false,'comment'=>'考试'])
            ->addColumn('school','integer',['limit'=>11,'null'=>false,'comment'=>'学校'])
            ->addColumn('ruxuenian','integer',['limit'=>4,'null'=>false,'comment'=>'入学年'])
            ->addColumn('nianji','string',['limit'=>4,'null'=>false,'comment'=>'年级'])
            ->addColumn('banji','integer',['limit'=>11,'null'=>false,'comment'=>'班级'])
            ->addColumn('paixu','integer',['limit'=>11,'null'=>false,'comment'=>'班级排序'])
            ->addColumn('student','integer',['limit'=>11,'null'=>false,'comment'=>'学生'])
            ->addColumn('create_time','integer',['limit'=>11,'null'=>true,'comment'=>'创建时间'])
            ->addColumn('delete_time','integer',['limit'=>11,'null'=>true,'comment'=>'删除时间'])
            ->addColumn('update_time','integer',['limit'=>11,'null'=>true,'comment'=>'更新时间'])
            ->addColumn('status','boolean',['limit'=>1,'default'=>'1','null'=>false,'comment'=>'0=禁用，1=正常'])
            ->addIndex(array('kaoshi','student'), array('unique' => true))
            ->create();
    }
}
