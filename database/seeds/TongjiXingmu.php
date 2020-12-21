<?php

use think\migration\Seeder;

class TongjiXingmu extends Seeder
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
        $rows = [
            [
                'id' =>  1
                ,'title' => '学号数'
                ,'biaoshi' => 'stu_cnt'
                ,'admin_web' => 0
                ,'paixu' => 1
            ]
            ,[
                'id'    =>  2
                ,'title'      =>  '成绩数'
                ,'biaoshi'   =>  'chengji_cnt'
                ,'admin_web'        =>  1
                ,'paixu' => 2
            ]
            ,[
                'id'    =>  3
                ,'title'      =>  '总分'
                ,'biaoshi'   =>  'sum'
                ,'admin_web'        =>  0
                ,'paixu' => 3
            ]
            ,[
                'id'    =>  4
                ,'title'      =>  '平均分'
                ,'biaoshi'   =>  'avg'
                ,'admin_web'        =>  1
                ,'paixu' => 4
            ]
            ,[
                'id'    =>  5
                ,'title'      =>  '得分率'
                ,'biaoshi'   =>  'defenlv'
                ,'admin_web'        =>  0
                ,'paixu' => 5
            ]
            ,[
                'id'    =>  6
                ,'title'      =>  '标准差'
                ,'biaoshi'   =>  'biaozhuncha'
                ,'admin_web'        =>  0
                ,'paixu' => 6
            ]
            ,[
                'id'    =>  7
                ,'title'      =>  '优秀人数'
                ,'biaoshi'   =>  'youxiu'
                ,'admin_web'        =>  0
                ,'paixu' => 7
            ]
            ,[
                'id'    =>  8
                ,'title'      =>  '优秀率'
                ,'biaoshi'   =>  'youxiulv'
                ,'admin_web'     =>  1
                ,'paixu' => 8
            ]
            ,[
                'id'    =>  9
                ,'title'      =>  '及格人数'
                ,'biaoshi'   =>  'jige'
                ,'admin_web'    =>  0
                ,'paixu' => 9
            ]
            ,[
                'id'    =>  10
                ,'title'      =>  '及格率'
                ,'biaoshi'   =>  'jigelv'
                ,'admin_web'    =>  1
                ,'paixu' => 10
            ]
            ,[
                'id'    =>  11
                ,'title'      =>  '最高分'
                ,'biaoshi'   =>  'max'
                ,'admin_web'    =>  0
                ,'paixu' => 11
            ]
            ,[
                'id'    =>  12
                ,'title'      =>  '最低分'
                ,'biaoshi'   =>  'min'
                ,'admin_web'    =>  0
                ,'paixu' => 12
            ]
            ,[
                'id'    =>  13
                ,'title'      =>  'Q1'
                ,'biaoshi'   =>  'q1'
                ,'admin_web'        =>  0
                ,'paixu' => 13
            ]
            ,[
                'id'    =>  14
                ,'title'      =>  'Q2'
                ,'biaoshi'   =>  'q2'
                ,'admin_web'    =>  0
                ,'paixu' => 14
            ]
            ,[
                'id'    =>  15
                ,'title'      =>  'Q3'
                ,'biaoshi'   =>  'q3'
                ,'admin_web'    =>  0
                ,'paixu' => 15
            ]
            ,[
                'id'    =>  16
                ,'title'      =>  '众数'
                ,'biaoshi'   =>  'zhongshu'
                ,'admin_web'    =>  0
                ,'paixu' => 16
            ]
            ,[

                'id'    =>  17
                ,'title'      =>  '中位数'
                ,'biaoshi'   =>  'zhongweishu'
                ,'admin_web'    =>  0
                ,'paixu' => 17
            ]
            ,[

                'id'    =>  18
                ,'title'      =>  '差生率'
                ,'biaoshi'   =>  'chashenglv'
                ,'admin_web'    =>  0
                ,'paixu' => 18
            ]
    ];
        // 保存数据
        $this->table('tongji_xiangmu')->insert($rows)->save();
    }
}
