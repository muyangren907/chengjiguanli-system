<?php

use think\migration\Migrator;
use think\migration\db\Column;

class TeacherToAdmin extends Migrator
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
        $table = $this->table('admin');
        $column = $table->hasColumn('worktime');
        if (!$column) {
            $this->execute('UPDATE cj_admin set phone=null where id>0');
            $table
            ->addColumn('worktime','integer',['limit'=>11,'null'=>true,'comment'=>'工作时间'])
            ->addColumn('zhiwu_id','integer',['limit'=>11,'null'=>true,'comment'=>'职务'])
            ->addColumn('zhicheng_id','integer',['limit'=>11,'null'=>true,'comment'=>'职称'])
            ->addColumn('biye','string',['limit'=>50,'null'=>true,'comment'=>'毕业学校'])
            ->addColumn('zhuanye','string',['limit'=>20,'null'=>true,'comment'=>'专业'])
            ->addColumn('xueli_id','integer',['limit'=>11,'null'=>true,'comment'=>'学历'])
            ->addColumn('subject_id','integer',['limit'=>11,'null'=>true,'comment'=>'学科'])
            ->addColumn('quanpin','string',['limit'=>30,'default'=>'a','null'=>false,'comment'=>'全拼'])
            ->addColumn('shoupin','string',['limit'=>5,'default'=>'a','null'=>false,'comment'=>'简拼'])
            ->addColumn('tuixiu','boolean',['limit'=>1,'default'=>0,'null'=>false,'comment'=>'是否已经退休'])
            // ->addIndex(array('phone'), array('unique' => true))
            ->update();
        }

        $table = $this->table('system_base');
        $column = $table->hasColumn('kaoshifanwei');
        if (!$column) {
            $table
            ->addColumn('kaoshifanwei','boolean',['limit'=>1,'default'=>0,'null'=>false,'comment'=>'默认不限制']);
        }

        $table = $this->table('kaoshi');
        $column = $table->hasColumn('user_id');
        if (!$column) {
            $table
            ->addColumn('user_id','integer',['after' => 'category_id','limit'=>11,'default'=>0,'null'=>false,'comment'=>'用户ID']);
        }
    }


    //版本退回
    public function down()
    {
        $table = $this->table('admin');
        $table
            ->removeColumn('worktime')
            ->removeColumn('zhiwu_id')
            ->removeColumn('zhicheng_id')
            ->removeColumn('biye')
            ->removeColumn('zhuanye')
            ->removeColumn('xueli_id')
            ->removeColumn('subject_id')
            ->removeColumn('quanpin')
            ->removeColumn('shoupin')
            ->removeColumn('worktime')
            ->removeColumn('tuixiu')
            ->update();

        $table = $this->table('system_base');
        $table
            ->removeColumn('kaoshifanwei')
            ->update();
    }


}
