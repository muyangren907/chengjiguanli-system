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
            // 管理员-班级-网页
            [
                'title' => '学号数'
                ,'biaoshi' => 'stu_cnt'
                ,'tongji' => 0
                ,'paixu' => 1
                ,'category_id' => 12201
            ]
            ,[
                'title'      =>  '成绩数'
                ,'biaoshi'   =>  'chengji_cnt'
                ,'tongji'        =>  1
                ,'paixu' => 2
                ,'category_id' => 12201
            ]
            ,[
                'title'      =>  '总分'
                ,'biaoshi'   =>  'sum'
                ,'tongji'        =>  0
                ,'paixu' => 3
                ,'category_id' => 12201
            ]
            ,[
                'title'      =>  '平均分'
                ,'biaoshi'   =>  'avg'
                ,'tongji'        =>  1
                ,'paixu' => 4
                ,'category_id' => 12201
            ]
            ,[
                'title'      =>  '得分率'
                ,'biaoshi'   =>  'defenlv'
                ,'tongji'        =>  0
                ,'paixu' => 5
                ,'category_id' => 12201
            ]
            ,[
                'title'      =>  '标准差'
                ,'biaoshi'   =>  'biaozhuncha'
                ,'tongji'        =>  0
                ,'paixu' => 6
                ,'category_id' => 12201
            ]
            ,[
                'title'      =>  '优秀人数'
                ,'biaoshi'   =>  'youxiu'
                ,'tongji'        =>  0
                ,'paixu' => 7
                ,'category_id' => 12201
            ]
            ,[
                'title'      =>  '优秀率'
                ,'biaoshi'   =>  'youxiulv'
                ,'tongji'     =>  1
                ,'paixu' => 8
                ,'category_id' => 12201
            ]
            ,[
                'title'      =>  '及格人数'
                ,'biaoshi'   =>  'jige'
                ,'tongji'    =>  0
                ,'paixu' => 9
                ,'category_id' => 12201
            ]
            ,[
                'title'      =>  '及格率'
                ,'biaoshi'   =>  'jigelv'
                ,'tongji'    =>  1
                ,'paixu' => 10
                ,'category_id' => 12201
            ]
            ,[
                'title'      =>  '最高分'
                ,'biaoshi'   =>  'max'
                ,'tongji'    =>  0
                ,'paixu' => 11
                ,'category_id' => 12201
            ]
            ,[
                'title'      =>  '最低分'
                ,'biaoshi'   =>  'min'
                ,'tongji'    =>  0
                ,'paixu' => 12
                ,'category_id' => 12201
            ]
            ,[
                'title'      =>  'Q1'
                ,'biaoshi'   =>  'q1'
                ,'tongji'        =>  0
                ,'paixu' => 13
                ,'category_id' => 12201
            ]
            ,[
                'title'      =>  'Q2'
                ,'biaoshi'   =>  'q2'
                ,'tongji'    =>  0
                ,'paixu' => 14
                ,'category_id' => 12201
            ]
            ,[
                'title'      =>  'Q3'
                ,'biaoshi'   =>  'q3'
                ,'tongji'    =>  0
                ,'paixu' => 15
                ,'category_id' => 12201
            ]
            ,[
                'title'      =>  '众数'
                ,'biaoshi'   =>  'zhongshu'
                ,'tongji'    =>  0
                ,'paixu' => 16
                ,'category_id' => 12201
            ]
            ,[
                'title'      =>  '中位数'
                ,'biaoshi'   =>  'zhongweishu'
                ,'tongji'    =>  0
                ,'paixu' => 17
                ,'category_id' => 12201
            ]
            ,[
                'title'      =>  '差生率'
                ,'biaoshi'   =>  'chashenglv'
                ,'tongji'    =>  0
                ,'paixu' => 18
                ,'category_id' => 12201
            ]

            // 管理员-班级-下载
            ,[
                'title' => '学号数'
                ,'biaoshi' => 'stu_cnt'
                ,'tongji' => 0
                ,'paixu' => 1
                ,'category_id' => 12202
            ]
            ,[
                'title'      =>  '成绩数'
                ,'biaoshi'   =>  'chengji_cnt'
                ,'tongji'        =>  1
                ,'paixu' => 2
                ,'category_id' => 12202
            ]
            ,[
                'title'      =>  '总分'
                ,'biaoshi'   =>  'sum'
                ,'tongji'        =>  0
                ,'paixu' => 3
                ,'category_id' => 12202
            ]
            ,[
                'title'      =>  '平均分'
                ,'biaoshi'   =>  'avg'
                ,'tongji'        =>  1
                ,'paixu' => 4
                ,'category_id' => 12202
            ]
            ,[
                'title'      =>  '得分率'
                ,'biaoshi'   =>  'defenlv'
                ,'tongji'        =>  0
                ,'paixu' => 5
                ,'category_id' => 12202
            ]
            ,[
                'title'      =>  '标准差'
                ,'biaoshi'   =>  'biaozhuncha'
                ,'tongji'        =>  0
                ,'paixu' => 6
                ,'category_id' => 12202
            ]
            ,[
                'title'      =>  '优秀人数'
                ,'biaoshi'   =>  'youxiu'
                ,'tongji'        =>  0
                ,'paixu' => 7
                ,'category_id' => 12202
            ]
            ,[
                'title'      =>  '优秀率'
                ,'biaoshi'   =>  'youxiulv'
                ,'tongji'     =>  1
                ,'paixu' => 8
                ,'category_id' => 12202
            ]
            ,[
                'title'      =>  '及格人数'
                ,'biaoshi'   =>  'jige'
                ,'tongji'    =>  0
                ,'paixu' => 9
                ,'category_id' => 12202
            ]
            ,[
                'title'      =>  '及格率'
                ,'biaoshi'   =>  'jigelv'
                ,'tongji'    =>  1
                ,'paixu' => 10
                ,'category_id' => 12202
            ]
            ,[
                'title'      =>  '最高分'
                ,'biaoshi'   =>  'max'
                ,'tongji'    =>  0
                ,'paixu' => 11
                ,'category_id' => 12202
            ]
            ,[
                'title'      =>  '最低分'
                ,'biaoshi'   =>  'min'
                ,'tongji'    =>  0
                ,'paixu' => 12
                ,'category_id' => 12202
            ]
            ,[
                'title'      =>  'Q1'
                ,'biaoshi'   =>  'q1'
                ,'tongji'        =>  0
                ,'paixu' => 13
                ,'category_id' => 12202
            ]
            ,[
                'title'      =>  'Q2'
                ,'biaoshi'   =>  'q2'
                ,'tongji'    =>  0
                ,'paixu' => 14
                ,'category_id' => 12202
            ]
            ,[
                'title'      =>  'Q3'
                ,'biaoshi'   =>  'q3'
                ,'tongji'    =>  0
                ,'paixu' => 15
                ,'category_id' => 12202
            ]
            ,[
                'title'      =>  '众数'
                ,'biaoshi'   =>  'zhongshu'
                ,'tongji'    =>  0
                ,'paixu' => 16
                ,'category_id' => 12202
            ]
            ,[
                'title'      =>  '中位数'
                ,'biaoshi'   =>  'zhongweishu'
                ,'tongji'    =>  0
                ,'paixu' => 17
                ,'category_id' => 12202
            ]
            ,[
                'title'      =>  '差生率'
                ,'biaoshi'   =>  'chashenglv'
                ,'tongji'    =>  0
                ,'paixu' => 18
                ,'category_id' => 12202
            ]

            // 管理员-学校-网页
            ,[
                'title' => '学号数'
                ,'biaoshi' => 'stu_cnt'
                ,'tongji' => 0
                ,'paixu' => 1
                ,'category_id' => 12203
            ]
            ,[
                'title'      =>  '成绩数'
                ,'biaoshi'   =>  'chengji_cnt'
                ,'tongji'        =>  1
                ,'paixu' => 2
                ,'category_id' => 12203
            ]
            ,[
                'title'      =>  '总分'
                ,'biaoshi'   =>  'sum'
                ,'tongji'        =>  0
                ,'paixu' => 3
                ,'category_id' => 12203
            ]
            ,[
                'title'      =>  '平均分'
                ,'biaoshi'   =>  'avg'
                ,'tongji'        =>  1
                ,'paixu' => 4
                ,'category_id' => 12203
            ]
            ,[
                'title'      =>  '得分率'
                ,'biaoshi'   =>  'defenlv'
                ,'tongji'        =>  0
                ,'paixu' => 5
                ,'category_id' => 12203
            ]
            ,[
                'title'      =>  '标准差'
                ,'biaoshi'   =>  'biaozhuncha'
                ,'tongji'        =>  0
                ,'paixu' => 6
                ,'category_id' => 12203
            ]
            ,[
                'title'      =>  '优秀人数'
                ,'biaoshi'   =>  'youxiu'
                ,'tongji'        =>  0
                ,'paixu' => 7
                ,'category_id' => 12203
            ]
            ,[
                'title'      =>  '优秀率'
                ,'biaoshi'   =>  'youxiulv'
                ,'tongji'     =>  1
                ,'paixu' => 8
                ,'category_id' => 12203
            ]
            ,[
                'title'      =>  '及格人数'
                ,'biaoshi'   =>  'jige'
                ,'tongji'    =>  0
                ,'paixu' => 9
                ,'category_id' => 12203
            ]
            ,[
                'title'      =>  '及格率'
                ,'biaoshi'   =>  'jigelv'
                ,'tongji'    =>  1
                ,'paixu' => 10
                ,'category_id' => 12203
            ]
            ,[
                'title'      =>  '最高分'
                ,'biaoshi'   =>  'max'
                ,'tongji'    =>  0
                ,'paixu' => 11
                ,'category_id' => 12203
            ]
            ,[
                'title'      =>  '最低分'
                ,'biaoshi'   =>  'min'
                ,'tongji'    =>  0
                ,'paixu' => 12
                ,'category_id' => 12203
            ]
            ,[
                'title'      =>  'Q1'
                ,'biaoshi'   =>  'q1'
                ,'tongji'        =>  0
                ,'paixu' => 13
                ,'category_id' => 12203
            ]
            ,[
                'title'      =>  'Q2'
                ,'biaoshi'   =>  'q2'
                ,'tongji'    =>  0
                ,'paixu' => 14
                ,'category_id' => 12203
            ]
            ,[
                'title'      =>  'Q3'
                ,'biaoshi'   =>  'q3'
                ,'tongji'    =>  0
                ,'paixu' => 15
                ,'category_id' => 12203
            ]
            ,[
                'title'      =>  '众数'
                ,'biaoshi'   =>  'zhongshu'
                ,'tongji'    =>  0
                ,'paixu' => 16
                ,'category_id' => 12203
            ]
            ,[

                'title'      =>  '中位数'
                ,'biaoshi'   =>  'zhongweishu'
                ,'tongji'    =>  0
                ,'paixu' => 17
                ,'category_id' => 12203
            ]
            ,[

                'title'      =>  '差生率'
                ,'biaoshi'   =>  'chashenglv'
                ,'tongji'    =>  0
                ,'paixu' => 18
                ,'category_id' => 12203
            ]

            // 管理员-学校-下载
            ,[
                'title' => '学号数'
                ,'biaoshi' => 'stu_cnt'
                ,'tongji' => 0
                ,'paixu' => 1
                ,'category_id' => 12204
            ]
            ,[
                'title'      =>  '成绩数'
                ,'biaoshi'   =>  'chengji_cnt'
                ,'tongji'        =>  1
                ,'paixu' => 2
                ,'category_id' => 12204
            ]
            ,[
                'title'      =>  '总分'
                ,'biaoshi'   =>  'sum'
                ,'tongji'        =>  0
                ,'paixu' => 3
                ,'category_id' => 12204
            ]
            ,[
                'title'      =>  '平均分'
                ,'biaoshi'   =>  'avg'
                ,'tongji'        =>  1
                ,'paixu' => 4
                ,'category_id' => 12204
            ]
            ,[
                'title'      =>  '得分率'
                ,'biaoshi'   =>  'defenlv'
                ,'tongji'        =>  0
                ,'paixu' => 5
                ,'category_id' => 12204
            ]
            ,[
                'title'      =>  '标准差'
                ,'biaoshi'   =>  'biaozhuncha'
                ,'tongji'        =>  0
                ,'paixu' => 6
                ,'category_id' => 12204
            ]
            ,[
                'title'      =>  '优秀人数'
                ,'biaoshi'   =>  'youxiu'
                ,'tongji'        =>  0
                ,'paixu' => 7
                ,'category_id' => 12204
            ]
            ,[
                'title'      =>  '优秀率'
                ,'biaoshi'   =>  'youxiulv'
                ,'tongji'     =>  1
                ,'paixu' => 8
                ,'category_id' => 12204
            ]
            ,[
                'title'      =>  '及格人数'
                ,'biaoshi'   =>  'jige'
                ,'tongji'    =>  0
                ,'paixu' => 9
                ,'category_id' => 12204
            ]
            ,[
                'title'      =>  '及格率'
                ,'biaoshi'   =>  'jigelv'
                ,'tongji'    =>  1
                ,'paixu' => 10
                ,'category_id' => 12204
            ]
            ,[
                'title'      =>  '最高分'
                ,'biaoshi'   =>  'max'
                ,'tongji'    =>  0
                ,'paixu' => 11
                ,'category_id' => 12204
            ]
            ,[
                'title'      =>  '最低分'
                ,'biaoshi'   =>  'min'
                ,'tongji'    =>  0
                ,'paixu' => 12
                ,'category_id' => 12204
            ]
            ,[
                'title'      =>  'Q1'
                ,'biaoshi'   =>  'q1'
                ,'tongji'        =>  0
                ,'paixu' => 13
                ,'category_id' => 12204
            ]
            ,[
                'title'      =>  'Q2'
                ,'biaoshi'   =>  'q2'
                ,'tongji'    =>  0
                ,'paixu' => 14
                ,'category_id' => 12204
            ]
            ,[
                'title'      =>  'Q3'
                ,'biaoshi'   =>  'q3'
                ,'tongji'    =>  0
                ,'paixu' => 15
                ,'category_id' => 12204
            ]
            ,[
                'title'      =>  '众数'
                ,'biaoshi'   =>  'zhongshu'
                ,'tongji'    =>  0
                ,'paixu' => 16
                ,'category_id' => 12204
            ]
            ,[
                'title'      =>  '中位数'
                ,'biaoshi'   =>  'zhongweishu'
                ,'tongji'    =>  0
                ,'paixu' => 17
                ,'category_id' => 12204
            ]
            ,[

                'title'      =>  '差生率'
                ,'biaoshi'   =>  'chashenglv'
                ,'tongji'    =>  0
                ,'paixu' => 18
                ,'category_id' => 12204
            ]

            // 教师-学科-网页
            ,[
                'title' => '学号数'
                ,'biaoshi' => 'stu_cnt'
                ,'tongji' => 0
                ,'paixu' => 1
                ,'category_id' => 12207
            ]
            ,[
                'title'      =>  '成绩数'
                ,'biaoshi'   =>  'chengji_cnt'
                ,'tongji'        =>  1
                ,'paixu' => 2
                ,'category_id' => 12207
            ]
            ,[
                'title'      =>  '总分'
                ,'biaoshi'   =>  'sum'
                ,'tongji'        =>  0
                ,'paixu' => 3
                ,'category_id' => 12207
            ]
            ,[
                'title'      =>  '平均分'
                ,'biaoshi'   =>  'avg'
                ,'tongji'        =>  1
                ,'paixu' => 4
                ,'category_id' => 12207
            ]
            ,[
                'title'      =>  '得分率'
                ,'biaoshi'   =>  'defenlv'
                ,'tongji'        =>  0
                ,'paixu' => 5
                ,'category_id' => 12207
            ]
            ,[
                'title'      =>  '标准差'
                ,'biaoshi'   =>  'biaozhuncha'
                ,'tongji'        =>  0
                ,'paixu' => 6
                ,'category_id' => 12207
            ]
            ,[
                'title'      =>  '优秀人数'
                ,'biaoshi'   =>  'youxiu'
                ,'tongji'        =>  0
                ,'paixu' => 7
                ,'category_id' => 12207
            ]
            ,[
                'title'      =>  '优秀率'
                ,'biaoshi'   =>  'youxiulv'
                ,'tongji'     =>  1
                ,'paixu' => 8
                ,'category_id' => 12207
            ]
            ,[
                'title'      =>  '及格人数'
                ,'biaoshi'   =>  'jige'
                ,'tongji'    =>  0
                ,'paixu' => 9
                ,'category_id' => 12207
            ]
            ,[
                'title'      =>  '及格率'
                ,'biaoshi'   =>  'jigelv'
                ,'tongji'    =>  1
                ,'paixu' => 10
                ,'category_id' => 12207
            ]
            ,[
                'title'      =>  '最高分'
                ,'biaoshi'   =>  'max'
                ,'tongji'    =>  0
                ,'paixu' => 11
                ,'category_id' => 12207
            ]
            ,[
                'title'      =>  '最低分'
                ,'biaoshi'   =>  'min'
                ,'tongji'    =>  0
                ,'paixu' => 12
                ,'category_id' => 12207
            ]
            ,[
                'title'      =>  'Q1'
                ,'biaoshi'   =>  'q1'
                ,'tongji'        =>  0
                ,'paixu' => 13
                ,'category_id' => 12207
            ]
            ,[
                'title'      =>  'Q2'
                ,'biaoshi'   =>  'q2'
                ,'tongji'    =>  0
                ,'paixu' => 14
                ,'category_id' => 12207
            ]
            ,[
                'title'      =>  'Q3'
                ,'biaoshi'   =>  'q3'
                ,'tongji'    =>  0
                ,'paixu' => 15
                ,'category_id' => 12207
            ]
            ,[
                'title'      =>  '众数'
                ,'biaoshi'   =>  'zhongshu'
                ,'tongji'    =>  0
                ,'paixu' => 16
                ,'category_id' => 12207
            ]
            ,[
                'title'      =>  '中位数'
                ,'biaoshi'   =>  'zhongweishu'
                ,'tongji'    =>  0
                ,'paixu' => 17
                ,'category_id' => 12207
            ]
            ,[

                'title'      =>  '差生率'
                ,'biaoshi'   =>  'chashenglv'
                ,'tongji'    =>  0
                ,'paixu' => 18
                ,'category_id' => 12207
            ]

            // 管理员-学生-下载
            ,[
                'title' => '学号数'
                ,'biaoshi' => 'stu_cnt'
                ,'tongji' => 0
                ,'paixu' => 1
                ,'category_id' => 12207
            ]
            ,[
                'title'      =>  '成绩数'
                ,'biaoshi'   =>  'chengji_cnt'
                ,'tongji'        =>  1
                ,'paixu' => 2
                ,'category_id' => 12207
            ]
            ,[
                'title'      =>  '总分'
                ,'biaoshi'   =>  'sum'
                ,'tongji'        =>  0
                ,'paixu' => 3
                ,'category_id' => 12207
            ]
            ,[
                'title'      =>  '平均分'
                ,'biaoshi'   =>  'avg'
                ,'tongji'        =>  1
                ,'paixu' => 4
                ,'category_id' => 12207
            ]
            ,[
                'title'      =>  '得分率'
                ,'biaoshi'   =>  'defenlv'
                ,'tongji'        =>  0
                ,'paixu' => 5
                ,'category_id' => 12207
            ]
            ,[
                'title'      =>  '标准差'
                ,'biaoshi'   =>  'biaozhuncha'
                ,'tongji'        =>  0
                ,'paixu' => 6
                ,'category_id' => 12207
            ]
            ,[
                'title'      =>  '优秀人数'
                ,'biaoshi'   =>  'youxiu'
                ,'tongji'        =>  0
                ,'paixu' => 7
                ,'category_id' => 12207
            ]
            ,[
                'title'      =>  '优秀率'
                ,'biaoshi'   =>  'youxiulv'
                ,'tongji'     =>  1
                ,'paixu' => 8
                ,'category_id' => 12207
            ]
            ,[
                'title'      =>  '及格人数'
                ,'biaoshi'   =>  'jige'
                ,'tongji'    =>  0
                ,'paixu' => 9
                ,'category_id' => 12207
            ]
            ,[
                'title'      =>  '及格率'
                ,'biaoshi'   =>  'jigelv'
                ,'tongji'    =>  1
                ,'paixu' => 10
                ,'category_id' => 12207
            ]
            ,[
                'title'      =>  '最高分'
                ,'biaoshi'   =>  'max'
                ,'tongji'    =>  0
                ,'paixu' => 11
                ,'category_id' => 12207
            ]
            ,[
                'title'      =>  '最低分'
                ,'biaoshi'   =>  'min'
                ,'tongji'    =>  0
                ,'paixu' => 12
                ,'category_id' => 12207
            ]
            ,[
                'title'      =>  'Q1'
                ,'biaoshi'   =>  'q1'
                ,'tongji'        =>  0
                ,'paixu' => 13
                ,'category_id' => 12207
            ]
            ,[
                'title'      =>  'Q2'
                ,'biaoshi'   =>  'q2'
                ,'tongji'    =>  0
                ,'paixu' => 14
                ,'category_id' => 12207
            ]
            ,[
                'title'      =>  'Q3'
                ,'biaoshi'   =>  'q3'
                ,'tongji'    =>  0
                ,'paixu' => 15
                ,'category_id' => 12207
            ]
            ,[
                'title'      =>  '众数'
                ,'biaoshi'   =>  'zhongshu'
                ,'tongji'    =>  0
                ,'paixu' => 16
                ,'category_id' => 12207
            ]
            ,[
                'title'      =>  '中位数'
                ,'biaoshi'   =>  'zhongweishu'
                ,'tongji'    =>  0
                ,'paixu' => 17
                ,'category_id' => 12207
            ]
            ,[
                'title'      =>  '差生率'
                ,'biaoshi'   =>  'chashenglv'
                ,'tongji'    =>  0
                ,'paixu' => 18
                ,'category_id' => 12207
            ]

            // 管理员-学生-下载左
            ,[
                'title' => '平均分'
                ,'biaoshi' => 'avg'
                ,'tongji' => 1
                ,'paixu' => 1
                ,'category_id' => 12210
            ]
            ,[
                'title' => '总分'
                ,'biaoshi' => 'sum'
                ,'tongji' => 1
                ,'paixu' => 2
                ,'category_id' => 12210
            ]
            ,[
                'title' => '班排序'
                ,'biaoshi' => 'bpaixu'
                ,'tongji' => 0
                ,'paixu' => 3
                ,'category_id' => 12210
            ]
            ,[
                'title' => '年级排序'
                ,'biaoshi' => 'npaixu'
                ,'tongji' => 0
                ,'paixu' => 4
                ,'category_id' => 12210
            ]
            ,[
                'title' => '班位置'
                ,'biaoshi' => 'bpaixu'
                ,'tongji' => 1
                ,'paixu' => 5
                ,'category_id' => 12210
            ]
            ,[
                'title' => '年级位置'
                ,'biaoshi' => 'npaixu'
                ,'tongji' => 1
                ,'paixu' => 6
                ,'category_id' => 12210
            ]

            // 管理员-学生-网页
            ,[
                'title' => '平均分'
                ,'biaoshi' => 'avg'
                ,'tongji' => 1
                ,'paixu' => 1
                ,'category_id' => 12210
            ]
            ,[
                'title' => '总分'
                ,'biaoshi' => 'sum'
                ,'tongji' => 1
                ,'paixu' => 2
                ,'category_id' => 12210
            ]
            ,[
                'title' => '班排序'
                ,'biaoshi' => 'bpaixu'
                ,'tongji' => 0
                ,'paixu' => 3
                ,'category_id' => 12210
            ]
            ,[
                'title' => '年级排序'
                ,'biaoshi' => 'npaixu'
                ,'tongji' => 0
                ,'paixu' => 4
                ,'category_id' => 12210
            ]
            ,[
                'title' => '班位置'
                ,'biaoshi' => 'bpaixu'
                ,'tongji' => 1
                ,'paixu' => 5
                ,'category_id' => 12210
            ]
            ,[
                'title' => '年级位置'
                ,'biaoshi' => 'npaixu'
                ,'tongji' => 1
                ,'paixu' => 6
                ,'category_id' => 12210
            ]


    ];
        // 保存数据
        $this->table('tongji_xiangmu')->insert($rows)->save();
    }
}
