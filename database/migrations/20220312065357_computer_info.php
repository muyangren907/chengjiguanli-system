<?php

use think\migration\Migrator;
use think\migration\db\Column;

class ComputerInfo extends Migrator
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
        $table = $this->table('composer_info');

        // 添加当前表字段
        $table
            ->addColumn('composer_id','integer',['limit'=>11,'default'=>0,'null'=>false,'comment'=>'计算机id'])
            ->addColumn('xitong','string',['limit'=>40,'default'=>0,'null'=>false,'comment'=>'操作系统'])
            ->addColumn('xitong_time','integer',['limit'=>11,'default'=>'1539158918','null'=>false,'comment'=>'系统安装时间'])
            ->addColumn('teacher_id','integer',['limit'=>11,'default'=>0,'null'=>false,'comment'=>'使用人id'])
            ->addColumn('weizhi','string',['limit'=>40,'default'=>0,'null'=>false,'comment'=>'存放位置'])
            ->addColumn('ip','string',['limit'=>20,'default'=>'0.0.0.0','null'=>false,'comment'=>'IP地址'])
            ->addColumn('biaoqian_time','integer',['limit'=>11,'default'=>'1539158918','null'=>false,'comment'=>'标签时间'])
            ->addColumn('info','text',['null'=>false,'comment'=>'电脑概览'])
            ->addColumn('infos','text',['null'=>false,'comment'=>'电脑详细信息'])
            ->addColumn('shangchuan_id','integer',['limit'=>11,'default'=>0,'null'=>false,'comment'=>'上传信息人id'])
            ->addColumn('beizhu','text',['null'=>false,'comment'=>'备注'])
            ->addColumn('create_time','integer',['limit'=>11,'default'=>'1539158918','null'=>false,'comment'=>'创建时间'])
            ->addColumn('update_time','integer',['limit'=>11,'default'=>'1539158918','null'=>false,'comment'=>'更新时间'])
            ->addColumn('delete_time','integer',['limit'=>11,'null'=>true,'comment'=>'删除时间'])
            ->create();
    }
}
