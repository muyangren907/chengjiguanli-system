<?php

use think\migration\Seeder;

class Category extends Seeder
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
        // 初始化类别
        $rows= [
            // 一级类别
            ['id'=>1,'title'=>'单位性质','pid'=>0,'paixu' =>1],
            ['id'=>2,'title'=>'单位级别','pid'=>0,'paixu' =>2],
            ['id'=>3,'title'=>'大学段','pid'=>0,'paixu' =>3],
            ['id'=>4,'title'=>'小学段','pid'=>0,'paixu' =>4],
            ['id'=>5,'title'=>'学历','pid'=>0,'paixu'=>5],
            ['id'=>6,'title'=>'职称','pid'=>0,'paixu'=>6],
            ['id'=>7,'title'=>'职务','pid'=>0,'paixu'=>7],

                // 二级类别
                // 单位性质
                ['title'=>'幼儿园','pid'=>1,'paixu'=>1],
                ['title'=>'小学','pid'=>1,'paixu'=>2],
                ['title'=>'九年一贯','pid'=>1,'paixu'=>3],
                ['title'=>'初中','pid'=>1,'paixu'=>4],
                ['title'=>'高中','pid'=>1,'paixu'=>5],
                ['title'=>'中等职业技术学校','pid'=>1,'paixu'=>6],
                ['title'=>'科研机构(教师进修学校)','pid'=>1,'paixu'=>7],
                ['title'=>'教育行政部门','pid'=>1,'paixu'=>8],
                ['title'=>'其他教育机构','pid'=>1,'paixu'=>9],
                // 单位级别
                ['title'=>'校级','pid'=>2,'paixu'=>1],
                ['title'=>'区级','pid'=>2,'paixu'=>2],
                ['title'=>'市级','pid'=>2,'paixu'=>3],
                ['title'=>'省级','pid'=>2,'paixu'=>4],
                ['title'=>'部级','pid'=>2,'paixu'=>5],
                ['title'=>'其它级','pid'=>2,'paixu'=>6],
                // 大学段
                ['title'=>'幼儿园','pid'=>3,'paixu'=>1],
                ['title'=>'小学','pid'=>3,'paixu'=>2],
                ['title'=>'中小学','pid'=>3,'paixu'=>3],
                ['title'=>'初中','pid'=>3,'paixu'=>4],
                ['title'=>'高中','pid'=>3,'paixu'=>5],
                ['title'=>'其他学段','pid'=>3,'paixu'=>6],
                // 大学段
                ['title'=>'低年级','pid'=>4,'paixu'=>1],
                ['title'=>'中年级','pid'=>4,'paixu'=>2],
                ['title'=>'高级年','pid'=>4,'paixu'=>3],
                ['title'=>'其他学段','pid'=>4,'paixu'=>4],
                // 学历
                ['title'=>'高中/中专','pid'=>5,'paixu'=>1],
                ['title'=>'专科','pid'=>5,'paixu'=>2],
                ['title'=>'本科','pid'=>5,'paixu'=>3],
                ['title'=>'硕士研究生','pid'=>5,'paixu'=>4],
                ['title'=>'博士研究生','pid'=>5,'paixu'=>5],
                ['title'=>'其他学历','pid'=>5,'paixu'=>6],
                // 职称
                ['title'=>'正高级','pid'=>6,'paixu'=>1],
                ['title'=>'高级','pid'=>6,'paixu'=>2],
                ['title'=>'一级','pid'=>6,'paixu'=>3],
                ['title'=>'二级','pid'=>6,'paixu'=>4],
                ['title'=>'三级','pid'=>6,'paixu'=>5],
                ['title'=>'其他','pid'=>6,'paixu'=>6],
                // 职务
                ['title'=>'校长','pid'=>7,'paixu'=>1],
                ['title'=>'副校长','pid'=>7,'paixu'=>2],
                ['title'=>'主任','pid'=>7,'paixu'=>3],
                ['title'=>'教研组长','pid'=>7,'paixu'=>4],
                ['title'=>'教师','pid'=>7,'paixu'=>5],
                ['title'=>'其他','pid'=>7,'paixu'=>6],
        ];
        // 保存数据
        $this->table('category')->insert($rows)->save();
    }
}