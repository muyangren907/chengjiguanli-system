<?php

use think\migration\Migrator;
use think\migration\db\Column;

class JsRongyuCanyu extends Migrator
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
        $table = $this->table('js_rongyu_canyu');

        // 添加当前表字段
        $table
            ->addColumn('category','integer',['limit'=>1,'null'=>false,'default'=>0,'comment'=>'获奖人或参与人,1=>获奖人,2=>参与人'])
            ->addColumn('rongyuid','integer',['limit'=>11,'null'=>false,'comment'=>'荣誉id'])// rongyuid应该改成rongyuinfoid
            ->addColumn('teacherid','integer',['limit'=>11,'null'=>false,'comment'=>'教师id'])
            ->create();
    }
}