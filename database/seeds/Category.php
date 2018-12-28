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
            ['id'=>102,'title'=>'单位级别','pid'=>0,'paixu' =>2],
            ['id'=>103,'title'=>'大学段','pid'=>0,'paixu' =>3],
            ['id'=>104,'title'=>'小学段','pid'=>0,'paixu' =>4],
            ['id'=>105,'title'=>'学历','pid'=>0,'paixu'=>5],
            ['id'=>106,'title'=>'职称','pid'=>0,'paixu'=>6],
            ['id'=>107,'title'=>'职务','pid'=>0,'paixu'=>7],
            ['id'=>108,'title'=>'学期','pid'=>0,'paixu'=>8],
            ['id'=>109,'title'=>'考试','pid'=>0,'paixu'=>9],
            ['id'=>110,'title'=>'学科','pid'=>0,'paixu'=>10],
            ['id'=>111,'title'=>'文件','pid'=>0,'paixu'=>11],
            ['id'=>112,'title'=>'单位荣誉','pid'=>0,'paixu'=>12],
            ['id'=>113,'title'=>'单位荣誉奖项','pid'=>0,'paixu'=>13],

            // 二级类别
                //  大学科
                ['id'=>1011001,'title'=>'语文','pid'=>110,'paixu'=>1],
                ['id'=>1011002,'title'=>'数学','pid'=>110,'paixu'=>2],
                ['id'=>1011003,'title'=>'外语','pid'=>110,'paixu'=>3],
                ['id'=>1011004,'title'=>'品德','pid'=>110,'paixu'=>4],
                ['id'=>1011005,'title'=>'历史与社会','pid'=>110,'paixu'=>5],
                ['id'=>1011006,'title'=>'科学','pid'=>110,'paixu'=>6],
                ['id'=>1011007,'title'=>'体育与健康','pid'=>110,'paixu'=>7],
                ['id'=>1011008,'title'=>'艺术','pid'=>110,'paixu'=>8],
                ['id'=>1011009,'title'=>'综合实践活动','pid'=>110,'paixu'=>9],
                ['id'=>1011010,'title'=>'地方校本课程','pid'=>110,'paixu'=>10],
                ['id'=>1011011,'title'=>'其它','pid'=>110,'paixu'=>11],
                //  文件
                ['id'=>1011101,'title'=>'教师名单','pid'=>111,'paixu'=>1],
                ['id'=>1011102,'title'=>'学生名单','pid'=>111,'paixu'=>2],
                ['id'=>1011103,'title'=>'考试成绩','pid'=>111,'paixu'=>3],

                // 单位性质
                ['id'=>20000000,'title'=>'幼儿园','pid'=>101,'paixu'=>1],
                ['title'=>'小学','pid'=>101,'paixu'=>2],
                ['title'=>'九年一贯','pid'=>101,'paixu'=>3],
                ['title'=>'初中','pid'=>101,'paixu'=>4],
                ['title'=>'高中','pid'=>101,'paixu'=>5],
                ['title'=>'中等职业技术学校','pid'=>101,'paixu'=>6],
                ['title'=>'科研机构(教师进修学校)','pid'=>101,'paixu'=>7],
                ['title'=>'教育行政部门','pid'=>101,'paixu'=>8],
                ['title'=>'其他教育机构','pid'=>101,'paixu'=>9],
                // 单位级别
                ['title'=>'班级','pid'=>102,'paixu'=>1],
                ['title'=>'教研组','pid'=>102,'paixu'=>2],
                ['title'=>'校级','pid'=>102,'paixu'=>3],
                ['title'=>'区级','pid'=>102,'paixu'=>4],
                ['title'=>'市级','pid'=>102,'paixu'=>5],
                ['title'=>'省级','pid'=>102,'paixu'=>6],
                ['title'=>'部级','pid'=>102,'paixu'=>7],
                ['title'=>'其它级','pid'=>102,'paixu'=>8],
                // 大学段
                ['title'=>'幼儿园','pid'=>103,'paixu'=>1],
                ['title'=>'小学','pid'=>103,'paixu'=>2],
                ['title'=>'中小学','pid'=>103,'paixu'=>3],
                ['title'=>'初中','pid'=>103,'paixu'=>4],
                ['title'=>'高中','pid'=>103,'paixu'=>5],
                ['title'=>'其他学段','pid'=>103,'paixu'=>6],
                // 大学段
                ['title'=>'低年级','pid'=>104,'paixu'=>1],
                ['title'=>'中年级','pid'=>104,'paixu'=>2],
                ['title'=>'高级年','pid'=>104,'paixu'=>3],
                ['title'=>'其他学段','pid'=>104,'paixu'=>4],
                // 学历
                ['title'=>'高中/中专','pid'=>105,'paixu'=>1],
                ['title'=>'专科','pid'=>105,'paixu'=>2],
                ['title'=>'本科','pid'=>105,'paixu'=>3],
                ['title'=>'硕士研究生','pid'=>105,'paixu'=>4],
                ['title'=>'博士研究生','pid'=>105,'paixu'=>5],
                ['title'=>'其他学历','pid'=>105,'paixu'=>6],
                // 职称
                ['title'=>'正高级','pid'=>106,'paixu'=>1],
                ['title'=>'高级','pid'=>106,'paixu'=>2],
                ['title'=>'一级','pid'=>106,'paixu'=>3],
                ['title'=>'二级','pid'=>106,'paixu'=>4],
                ['title'=>'三级','pid'=>106,'paixu'=>5],
                ['title'=>'其他','pid'=>106,'paixu'=>6],
                // 职务
                ['title'=>'校长','pid'=>107,'paixu'=>1],
                ['title'=>'副校长','pid'=>107,'paixu'=>2],
                ['title'=>'主任','pid'=>107,'paixu'=>3],
                ['title'=>'教研组长','pid'=>107,'paixu'=>4],
                ['title'=>'教师','pid'=>107,'paixu'=>5],
                ['title'=>'其他','pid'=>107,'paixu'=>6],
                //  学期
                ['title'=>'第一学期','pid'=>108,'paixu'=>1],
                ['title'=>'第二学期','pid'=>108,'paixu'=>2],
                //  考试分类
                ['title'=>'期末考试','pid'=>109,'paixu'=>1],
                ['title'=>'期中考试','pid'=>109,'paixu'=>2],
                ['title'=>'单项测试','pid'=>109,'paixu'=>3],
                //  单位荣誉分类
                ['title'=>'科研','pid'=>112,'paixu'=>1],
                ['title'=>'特色','pid'=>112,'paixu'=>2],
                //  单位荣誉奖项
                ['title'=>'先进单位','pid'=>113,'paixu'=>1],
                ['title'=>'一等奖','pid'=>113,'paixu'=>2],
                ['title'=>'二等奖','pid'=>113,'paixu'=>3],
                ['title'=>'三等奖','pid'=>113,'paixu'=>3],
                ['title'=>'优秀奖','pid'=>113,'paixu'=>3],

                
        ];
        // 保存数据
        $this->table('category')->insert($rows)->save();
    }
}