<?php

use think\migration\Migrator;
use think\migration\db\Column;

class AuthRule extends Migrator
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
        $table = $this->table('auth_rule');

        // 添加当前表字段
        $table
            ->addColumn('name','string',['limit'=>80,'default'=>'','null'=>true,'comment'=>'规则唯一标识'])
            ->addColumn('title','string',['limit'=>80,'default'=>'','null'=>true,'comment'=>'规则中文名'])
            ->addColumn('type','boolean',['default'=>false,'null'=>false,'comment'=>'是否是菜单'])
            ->addColumn('status','boolean',['default'=>true,'null'=>true,'comment'=>'规则状态'])
            ->addColumn('condition','string',['limit'=>100,'default'=>'','null'=>false,'comment'=>'规则表达式'])
            ->addColumn('delete_time','integer',['limit'=>11,'default'=>'','null'=>false,'comment'=>'删除时间'])
            ->addIndex(array('name'), array('unique' => true))
            ->create();
    }
}
