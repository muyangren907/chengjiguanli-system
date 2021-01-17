<?php

use think\migration\Migrator;
use think\migration\db\Column;

class RuleAddsystemreset extends Migrator
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
        $singleRow = [
            ['id' => 70502
                ,'title' => '初始化'
                ,'name' => 'system/systembase/resetmayi'
                ,'paixu' => 2
                ,'pid'  => 705
            ],
        ];

        // this is a handy shortcut
        $this->insert('auth_rule',  $singleRow);
    }

    public function down()
    {
        $this->execute('DELETE FROM cj_auth_rule where id=707');
    }
}
