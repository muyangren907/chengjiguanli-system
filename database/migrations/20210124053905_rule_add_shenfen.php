<?php

use think\migration\Migrator;
use think\migration\db\Column;

class RuleAddShenfen extends Migrator
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
        $table = $this->table('auth_rule');

        $table
            ->addColumn('teacher','boolean',['after' => 'type', 'limit'=>1,'default'=>0,'null'=>false,'comment'=>'0=禁用，1=正常'])
            ->addColumn('student','boolean',['after' => 'teacher', 'limit'=>1,'default'=>0,'null'=>false,'comment'=>'0=禁用，1=正常'])
            ->update();

        $this->execute('DELETE FROM cj_auth_rule where id=707');
    }


    public function down()
    {
        // 定义数据表名称
        $table = $this->table('auth_rule');

        $table
            ->removeColumn('teacher')
            ->removeColumn('student')
            ->update();
    }
}
