<?php

use think\migration\Migrator;
use think\migration\db\Column;

class DwRongyu extends Migrator
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
        $table = $this->table('dw_rongyu');

        // 添加当前表字段
        $table
            ->addColumn('title','string',['limit'=>30,'null'=>false,'comment'=>'单位荣誉名称'])
            ->addColumn('hjschool','integer',['limit'=>11,'null'=>false,'comment'=>'获奖单位'])
            ->addColumn('fzschool','integer',['limit'=>11,'null'=>false,'comment'=>'发证单位'])
            ->addColumn('fzshijian','integer',['limit'=>11,'null'=>false,'comment'=>'发证时间'])
            ->addColumn('category','string',['limit'=>100,'null'=>false,'comment'=>'荣誉图片'])
            ->addColumn('pic','integer',['limit'=>15,'null'=>false,'comment'=>'荣誉类型'])
            ->addColumn('create_time','integer',['limit'=>11,'null'=>true,'comment'=>'创建时间'])
            ->addColumn('delete_time','integer',['limit'=>11,'null'=>true,'comment'=>'删除时间'])
            ->addColumn('update_time','integer',['limit'=>11,'null'=>true,'comment'=>'更新时间'])
            ->addColumn('status','boolean',['limit'=>1,'default'=>'1','null'=>false,'comment'=>'0=禁用，1=正常'])
            ->create();

    }
}