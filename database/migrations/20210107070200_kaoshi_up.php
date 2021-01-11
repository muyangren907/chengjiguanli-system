<?php

use think\migration\Migrator;
use think\migration\db\Column;

class KaoshiUp extends Migrator
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
    public function up()
    {
        // 定义数据表名称
        $table = $this->table('kaoshi');

        $table
            ->addColumn('user_id','integer',['after' => 'category_id', 'limit'=>11,'default'=>0,'null'=>false,'comment'=>'用户ID'])
            ->addColumn('user_group','string',['after' => 'user_id', 'limit'=>25,'default'=>'admin','null'=>false,'comment'=>'用户组'])
            ->update();
    }


    public function down()
    {
        // 定义数据表名称
        $table = $this->table('kaoshi');

        $table
            ->removeColumn('user_id')
            ->removeColumn('user_group')
            ->update();
    }
}
