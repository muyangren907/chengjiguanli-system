<?php

use think\migration\Migrator;
use think\migration\db\Column;

class Member extends Migrator
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
        $table = $this->table('member');

        // 添加当前表字段
        $table
            ->addColumn('xingming','string',['limit'=>15,'null'=>false,'comment'=>'用户姓名'])
            ->addColumn('xingbie','boolean',['limit'=>1,'default'=>'2','null'=>false,'comment'=>'0=女，1=男，2=未知'])
            ->addColumn('shengri','integer',['limit'=>11,'null'=>true,'comment'=>'出生日期'])
            ->addColumn('username','string',['limit'=>12,'null'=>false,'comment'=>'用户帐号'])
            ->addColumn('password','string',['limit'=>37,'null'=>false,'comment'=>'登录密码'])
            ->addColumn('miyao','string',['limit'=>8,'null'=>false,'comment'=>'密钥'])
            ->addColumn('denglucishu','integer',['limit'=>5,'default'=>0,'null'=>false,'comment'=>'登录次数'])
            ->addColumn('lastip','string',['limit'=>55,'default'=>'127.0.0.1','null'=>false,'comment'=>'最后一次登录IP'])
            ->addColumn('ip','string',['limit'=>55,'default'=>'127.0.0.1','null'=>false,'comment'=>'登录IP'])
            ->addColumn('lasttime','integer',['limit'=>11,'null'=>false,'comment'=>'最后登录时间'])
            ->addColumn('thistime','integer',['limit'=>11,'null'=>false,'comment'=>'本次登录时间'])
            ->addColumn('status','boolean',['limit'=>1,'default'=>'1','null'=>false,'comment'=>'0=禁用，1=正常'])
            ->addColumn('create_time','integer',['limit'=>11,'default'=>'1539158918','null'=>false,'comment'=>'创建时间'])
            ->addColumn('update_time','integer',['limit'=>11,'default'=>'1539158918','null'=>false,'comment'=>'更新时间'])
            ->addColumn('delete_time','integer',['limit'=>11,'null'=>true,'comment'=>'删除时间'])
            ->addIndex(array('username'), array('unique' => true))
            ->create();
    }
}
