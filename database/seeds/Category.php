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
            ['id'=>101,'title'=>'单位性质','pid'=>0,'paixu' =>1],
            ['id'=>201,'title'=>'单位级别','pid'=>0,'paixu' =>2],
            ['id'=>301,'title'=>'大学段','pid'=>0,'paixu' =>3],
            ['id'=>401,'title'=>'小学段','pid'=>0,'paixu' =>4],
            ['id'=>501,'title'=>'学历','pid'=>0,'paixu'=>5],
            ['id'=>601,'title'=>'职称','pid'=>0,'paixu'=>6],
            ['id'=>701,'title'=>'职务','pid'=>0,'paixu'=>7],
            ['id'=>801,'title'=>'学期','pid'=>0,'paixu'=>8],
            ['id'=>901,'title'=>'考试','pid'=>0,'paixu'=>9],
            ['id'=>1001,'title'=>'学科','pid'=>0,'paixu'=>10],

            // 二级类别
            //  大学科
                ['id'=>2011,'title'=>'语文','pid'=>1001,'paixu'=>1],
                ['id'=>2012,'title'=>'数学','pid'=>1001,'paixu'=>2],
                ['id'=>2013,'title'=>'外语','pid'=>1001,'paixu'=>3],
                ['id'=>2014,'title'=>'品德','pid'=>1001,'paixu'=>4],
                ['id'=>2015,'title'=>'历史与社会','pid'=>1001,'paixu'=>5],
                ['id'=>2016,'title'=>'科学','pid'=>1001,'paixu'=>6],
                ['id'=>2017,'title'=>'体育与健康','pid'=>1001,'paixu'=>7],
                ['id'=>2018,'title'=>'艺术','pid'=>1001,'paixu'=>8],
                ['id'=>2019,'title'=>'综合实践活动','pid'=>1001,'paixu'=>9],
                ['id'=>2020,'title'=>'地方校本课程','pid'=>1001,'paixu'=>10],
                ['id'=>2021,'title'=>'其它','pid'=>1001,'paixu'=>11],

                // 单位性质
                ['id'=>10000,'title'=>'幼儿园','pid'=>101,'paixu'=>1],
                ['title'=>'小学','pid'=>101,'paixu'=>2],
                ['title'=>'九年一贯','pid'=>101,'paixu'=>3],
                ['title'=>'初中','pid'=>101,'paixu'=>4],
                ['title'=>'高中','pid'=>101,'paixu'=>5],
                ['title'=>'中等职业技术学校','pid'=>101,'paixu'=>6],
                ['title'=>'科研机构(教师进修学校)','pid'=>101,'paixu'=>7],
                ['title'=>'教育行政部门','pid'=>101,'paixu'=>8],
                ['title'=>'其他教育机构','pid'=>101,'paixu'=>9],
                // 单位级别
                ['title'=>'校级','pid'=>201,'paixu'=>1],
                ['title'=>'区级','pid'=>201,'paixu'=>2],
                ['title'=>'市级','pid'=>201,'paixu'=>3],
                ['title'=>'省级','pid'=>201,'paixu'=>4],
                ['title'=>'部级','pid'=>201,'paixu'=>5],
                ['title'=>'其它级','pid'=>201,'paixu'=>6],
                // 大学段
                ['title'=>'幼儿园','pid'=>301,'paixu'=>1],
                ['title'=>'小学','pid'=>301,'paixu'=>2],
                ['title'=>'中小学','pid'=>301,'paixu'=>3],
                ['title'=>'初中','pid'=>301,'paixu'=>4],
                ['title'=>'高中','pid'=>301,'paixu'=>5],
                ['title'=>'其他学段','pid'=>301,'paixu'=>6],
                // 大学段
                ['title'=>'低年级','pid'=>401,'paixu'=>1],
                ['title'=>'中年级','pid'=>401,'paixu'=>2],
                ['title'=>'高级年','pid'=>401,'paixu'=>3],
                ['title'=>'其他学段','pid'=>401,'paixu'=>4],
                // 学历
                ['title'=>'高中/中专','pid'=>501,'paixu'=>1],
                ['title'=>'专科','pid'=>501,'paixu'=>2],
                ['title'=>'本科','pid'=>501,'paixu'=>3],
                ['title'=>'硕士研究生','pid'=>501,'paixu'=>4],
                ['title'=>'博士研究生','pid'=>501,'paixu'=>5],
                ['title'=>'其他学历','pid'=>501,'paixu'=>6],
                // 职称
                ['title'=>'正高级','pid'=>601,'paixu'=>1],
                ['title'=>'高级','pid'=>601,'paixu'=>2],
                ['title'=>'一级','pid'=>601,'paixu'=>3],
                ['title'=>'二级','pid'=>601,'paixu'=>4],
                ['title'=>'三级','pid'=>601,'paixu'=>5],
                ['title'=>'其他','pid'=>601,'paixu'=>6],
                // 职务
                ['title'=>'校长','pid'=>701,'paixu'=>1],
                ['title'=>'副校长','pid'=>701,'paixu'=>2],
                ['title'=>'主任','pid'=>701,'paixu'=>3],
                ['title'=>'教研组长','pid'=>701,'paixu'=>4],
                ['title'=>'教师','pid'=>701,'paixu'=>5],
                ['title'=>'其他','pid'=>701,'paixu'=>6],
                //  学期
                ['title'=>'第一学期','pid'=>801,'paixu'=>1],
                ['title'=>'第二学期','pid'=>801,'paixu'=>2],
                //  考试分类
                ['title'=>'期末考试','pid'=>901,'paixu'=>1],
                ['title'=>'期中考试','pid'=>901,'paixu'=>2],
                ['title'=>'单项测试','pid'=>901,'paixu'=>3],
                
        ];
        // 保存数据
        $this->table('category')->insert($rows)->save();
    }
}