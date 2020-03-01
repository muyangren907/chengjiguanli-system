<?php

use think\migration\Migrator;
use think\migration\db\Column;

class KaoshiSet extends Migrator
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
        $table = $this->table('kaoshi_set');

        // 添加当前表字段
        $table
            ->addColumn('kaoshi_id','integer',['limit'=>11,'default'=>0,'null'=>false,'comment'=>'考试id'])
            ->addColumn('nianji','integer',['limit'=>80,'default'=>0,'null'=>false,'comment'=>'年级'])
            ->addColumn('nianjiname','string',['limit'=>10,'default'=>'a','null'=>false,'comment'=>'年级名'])
            ->addColumn('subject_id','integer',['limit'=>11,'default'=>0,'null'=>false,'comment'=>'学科id'])
            ->addColumn('manfen','integer',['limit'=>3,'default'=>100,'null'=>false,'comment'=>'满分'])
            ->addColumn('youxiu','integer',['limit'=>3,'default'=>90,'null'=>false,'comment'=>'优秀'])
            ->addColumn('jige','integer',['limit'=>3,'default'=>00,'null'=>false,'comment'=>'及格'])
            ->addColumn('status','boolean',['default'=>1,'null'=>false,'comment'=>'状态'])
            ->addColumn('create_time','integer',['limit'=>11,'default'=>'1539158918','null'=>false,'comment'=>'创建时间'])
            ->addColumn('update_time','integer',['limit'=>11,'default'=>'1539158918','null'=>false,'comment'=>'更新时间'])
            ->addColumn('delete_time','integer',['limit'=>11,'null'=>true,'comment'=>'删除时间'])
            ->create();
    }
}
