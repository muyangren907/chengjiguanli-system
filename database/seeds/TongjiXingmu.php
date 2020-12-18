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
                ,'tongji' => 0
            ]
            ,[
                'id'    =>  2,
                'title'      =>  '成绩数',
                'biaoshi'   =>  'chengji_cnt',
                'tongji'        =>  1
            ]
            ,[
                'id'    =>  3,
                'title'      =>  '总分',
                'biaoshi'   =>  'sum',
                'tongji'        =>  0
            ]
            ,[
                'id'    =>  4,
                'title'      =>  '平均分',
                'biaoshi'   =>  'avg',
                'tongji'        =>  1
            ]
            ,[
                'id'    =>  5,
                'title'      =>  '得分率',
                'biaoshi'   =>  'defenlv',
                'tongji'        =>  0
            ]
            ,[
                'id'    =>  6,
                'title'      =>  '标准差',
                'biaoshi'   =>  'biaozhunchan',
                'tongji'        =>  0
            ]
            ,[
                'id'    =>  7,
                'title'      =>  '优秀人数',
                'biaoshi'   =>  'youxiu',
                'tongji'        =>  0
            ]
            ,[
                'id'    =>  8,
                'title'      =>  '优秀率',
                'biaoshi'   =>  'youxiulv',
                'tongji'     =>  1
            ]
            ,[
                'id'    =>  9,
                'title'      =>  '及格人数',
                'biaoshi'   =>  'jige',
                'tongji'    =>  0
            ]
            ,[
                'id'    =>  10,
                'title'      =>  '及格率',
                'biaoshi'   =>  'jigelv',
                'tongji'    =>  1
            ]
            ,[
                'id'    =>  11,
                'title'      =>  '最高分',
                'biaoshi'   =>  'max',
                'tongji'    =>  0
            ]
            ,[
                'id'    =>  12,
                'title'      =>  '最低分',
                'biaoshi'   =>  'min',
                'tongji'    =>  0
            ]
            ,[
                'id'    =>  13,
                'title'      =>  'Q1',
                'biaoshi'   =>  'q1',
                'tongji'        =>  0,
            ]
            ,[
                'id'    =>  14,
                'title'      =>  'Q2',
                'biaoshi'   =>  'q2',
                'tongji'    =>  0
            ]
            ,[
                'id'    =>  15,
                'title'      =>  'Q3',
                'biaoshi'   =>  'q3',
                'tongji'    =>  0
            ]
            ,[
                'id'    =>  16,
                'title'      =>  '众数',
                'biaoshi'   =>  'zhongshu',
                'tongji'    =>  0
            ]
            ,[

                'id'    =>  17,
                'title'      =>  '中位数',
                'biaoshi'   =>  'zhongweishu',
                'tongji'    =>  0
            ]
    ];
        // 保存数据
        $this->table('tongji_xiangmu')->insert($rows)->save();
    }
}
