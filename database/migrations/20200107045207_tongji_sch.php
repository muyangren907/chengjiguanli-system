<?php

use think\migration\Migrator;
use think\migration\db\Column;

class TongjiSch extends Migrator
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
        $table = $this->table('tongji_sch');

        // 添加当前表字段
        $table
            ->addColumn('kaoshi_id','integer',['limit'=>11,'null'=>false,'default'=>Null,'comment'=>'考试'])
            ->addColumn('ruxuenian','integer',['limit'=>11,'null'=>false,'default'=>Null,'comment'=>'入学年'])
            ->addColumn('subject_id','string',['limit'=>11,'null'=>false,'default'=>Null,'comment'=>'学科'])
            ->addColumn('stu_cnt','integer',['limit'=>11,'null'=>false,'default'=>Null,'comment'=>'参加考试人数'])
            ->addColumn('chengji_cnt','integer',['limit'=>11,'null'=>false,'default'=>Null,'comment'=>'有成绩数'])
            ->addColumn('sum','decimal',['precision'=>10,'scale'=>1,'default'=>Null,'null'=>true,'comment'=>'总分'])
            ->addColumn('avg','decimal',['precision'=>4,'scale'=>1,'default'=>Null,'null'=>true,'comment'=>'平均分'])
            ->addColumn('biaozhuncha','decimal',['precision'=>4,'scale'=>1,'default'=>Null,'null'=>true,'comment'=>'标准差'])
            ->addColumn('youxiu','decimal',['precision'=>4,'scale'=>1,'default'=>Null,'null'=>true,'comment'=>'优秀'])
            ->addColumn('jige','decimal',['precision'=>4,'scale'=>1,'default'=>Null,'null'=>true,'comment'=>'及格'])
            ->addColumn('max','decimal',['precision'=>4,'scale'=>1,'default'=>Null,'null'=>true,'comment'=>'最大'])
            ->addColumn('min','decimal',['precision'=>4,'scale'=>1,'default'=>Null,'null'=>true,'comment'=>'最小'])
            ->addColumn('qian','decimal',['precision'=>4,'scale'=>1,'default'=>Null,'null'=>true,'comment'=>'前25%'])
            ->addColumn('zhong','decimal',['precision'=>4,'scale'=>1,'default'=>Null,'null'=>true,'comment'=>'中间%25'])
            ->addColumn('hou','decimal',['precision'=>4,'scale'=>1,'default'=>Null,'null'=>true,'comment'=>'后面25%'])
            ->addColumn('zhongshu','decimal',['precision'=>4,'scale'=>1,'default'=>Null,'null'=>true,'comment'=>'众数'])
            ->addColumn('create_time','integer',['limit'=>11,'null'=>true,'comment'=>'创建时间'])
            ->addColumn('delete_time','integer',['limit'=>11,'null'=>true,'comment'=>'删除时间'])
            ->addColumn('update_time','integer',['limit'=>11,'null'=>true,'comment'=>'更新时间'])
            ->addColumn('status','boolean',['limit'=>1,'default'=>'1','null'=>false,'comment'=>'0=禁用，1=正常'])
            ->addIndex(array('kaoshi_id','subject_id','ruxuenian'), array('unique' => true))
            ->create();
    }
}
