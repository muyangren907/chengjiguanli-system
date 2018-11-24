<?php

use think\migration\Seeder;

class Subject extends Seeder
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        // 设置数据
        $rows= [
            ['title'=>'语文','jiancheng'=>'语','category'=>1011001,'lieming'=>'yuwen','paixu'=>1],
            ['title'=>'数学','jiancheng'=>'数','category'=>1011002,'lieming'=>'shuxue','paixu'=>2],
            ['title'=>'外语','jiancheng'=>'外','category'=>1011003,'lieming'=>'waiyu','paixu'=>3],
            ['title'=>'物理','jiancheng'=>'物','category'=>1011006,'paixu'=>4],
            ['title'=>'化学','jiancheng'=>'化','category'=>1011006,'paixu'=>5],
            ['title'=>'体育与健康','jiancheng'=>'体','category'=>1011007,'paixu'=>6],
            ['title'=>'音乐','jiancheng'=>'音','category'=>1011008,'paixu'=>7],
            ['title'=>'美术','jiancheng'=>'美','category'=>1011008,'paixu'=>8],
            ['title'=>'信息技术','jiancheng'=>'信','category'=>1011009,'paixu'=>9],
            ['title'=>'科学','jiancheng'=>'科','category'=>1011006,'paixu'=>10],
            ['title'=>'品德与生活/社会','jiancheng'=>'品','category'=>1011004,'paixu'=>11],
            ['title'=>'历史','jiancheng'=>'史','category'=>1011005,'paixu'=>12],
            ['title'=>'地理','jiancheng'=>'地','category'=>1011005,'paixu'=>13],
            ['title'=>'思想品德','jiancheng'=>'品','category'=>1011004,'paixu'=>14],
            ['title'=>'生物','jiancheng'=>'生','category'=>1011006,'paixu'=>15],
            ['title'=>'地方课程','jiancheng'=>'地','category'=>1011010,'paixu'=>16],
            ['title'=>'校本课程','jiancheng'=>'校','category'=>1011010,'paixu'=>17],
            ['title'=>'劳动与技术','jiancheng'=>'劳','category'=>1011009,'paixu'=>18],
            ['title'=>'研究性学习/社区服务、实践','jiancheng'=>'社','category'=>1011009,'paixu'=>19],

        ];
        // 保存数据
        $this->table('subject')->insert($rows)->save();
    }
}