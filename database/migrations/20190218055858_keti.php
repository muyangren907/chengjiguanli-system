<?php

use think\migration\Migrator;
use think\migration\db\Column;

class Keti extends Migrator
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
        $table = $this->table('keti');

        // 添加当前表字段
        $table
            ->addColumn('title','integer',['limit'=>1,'null'=>false,'default'=>0,'comment'=>'课题名称'])
            ->addColumn('bianhao','string',['limit'=>11,'null'=>false,'comment'=>'课题编号'])
            ->addColumn('lxpic','string',['limit'=>100,'null'=>false,'comment'=>'立项证书图片'])
            ->addColumn('lxshijian','integer',['limit'=>11,'null'=>false,'comment'=>'立项时间'])
            ->addColumn('subject','integer',['limit'=>11,'null'=>false,'comment'=>'学科分类'])
            ->addColumn('fzdanweiid','integer',['limit'=>11,'null'=>false,'comment'=>'负责单位id'])
            ->addColumn('lxdanweiid','integer',['limit'=>11,'null'=>false,'comment'=>'立项单位id'])
            ->addColumn('category','integer',['limit'=>11,'null'=>false,'comment'=>'课题类型'])
            ->addColumn('fangxiang','integer',['limit'=>11,'null'=>false,'comment'=>'研究方向'])
            ->addColumn('jhjtshijian','integer',['limit'=>11,'null'=>false,'comment'=>'计划结题时间'])
            ->addColumn('jtshijian','integer',['limit'=>11,'null'=>false,'comment'=>'结题时间'])
            ->addColumn('jddengji','integer',['limit'=>11,'null'=>false,'comment'=>'鉴定等级'])
            ->addColumn('jtpic','string',['limit'=>100,'null'=>false,'comment'=>'结题证书图片'])
            ->create();
    }
}
