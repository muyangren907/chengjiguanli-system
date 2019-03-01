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
            ['title'=>'语文','jiancheng'=>'语','category'=>1011001,'lieming'=>'yuwen','kaoshi'=>true,'paixu'=>1],
            ['title'=>'数学','jiancheng'=>'数','category'=>1011002,'lieming'=>'shuxue','kaoshi'=>true,'paixu'=>2],
            ['title'=>'外语','jiancheng'=>'外','category'=>1011003,'lieming'=>'waiyu','kaoshi'=>true,'paixu'=>3],
            ['title'=>'体育与健康','jiancheng'=>'体','category'=>1011007,'paixu'=>4],
            ['title'=>'科学','jiancheng'=>'科','category'=>1011006,'lieming'=>'kexue','kaoshi'=>false,'paixu'=>5],
            ['title'=>'生物','jiancheng'=>'生','category'=>1011006,'paixu'=>6],
            ['title'=>'物理','jiancheng'=>'理','category'=>1011006,'lieming'=>'wuli','paixu'=>7],
            ['title'=>'化学','jiancheng'=>'化','category'=>1011006,'lieming'=>'huaxue','paixu'=>8],
            ['title'=>'音乐','jiancheng'=>'音','category'=>1011008,'paixu'=>9],
            ['title'=>'美术','jiancheng'=>'美','category'=>1011008,'paixu'=>10],
            ['title'=>'信息技术','jiancheng'=>'信息','category'=>1011009,'paixu'=>11],
            ['title'=>'研究性学习/社区服务、实践','jiancheng'=>'社区','category'=>1011009,'paixu'=>12],
            ['title'=>'劳动与技术','jiancheng'=>'劳动','category'=>1011009,'paixu'=>13],
            ['title'=>'品德与生活/社会','jiancheng'=>'品德','category'=>1011004,'lieming'=>'pinshe','kaoshi'=>false,'paixu'=>14],
            ['title'=>'思想品德','jiancheng'=>'品社','category'=>1011004,'paixu'=>15],
            ['title'=>'历史','jiancheng'=>'史','category'=>1011005,'paixu'=>16],
            ['title'=>'地理','jiancheng'=>'地理','category'=>1011005,'paixu'=>17],
            ['title'=>'地方课程','jiancheng'=>'地方','category'=>1011010,'paixu'=>18],
            ['title'=>'校本课程','jiancheng'=>'校本','category'=>1011010,'paixu'=>19],
            ['title'=>'幼儿园全科','jiancheng'=>'幼儿园','category'=>1011011,'paixu'=>20],
            ['title'=>'其他','jiancheng'=>'其他','category'=>1011012,'paixu'=>21],

        ];
        // 保存数据
        $this->table('subject')->insert($rows)->save();
    }
}