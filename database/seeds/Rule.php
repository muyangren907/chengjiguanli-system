<?php

use think\migration\Seeder;

class Rule extends Seeder
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
        // 01010101 1-2一级、3-4二级、5-6三级、7-8四级
        // 初始化超级管理员
        $rows = [
            /*======================================================================
             * 成绩采集
             */
            ['id' => 1 #01
                ,'title'  => '成绩采集'
                ,'name' => 'chengji'
                ,'paixu'  => 1
                ,'ismenu'  => 1
                ,'font' => '&#xe6c9;'
            ],
            ['id' => 101
                ,'title' => '扫码录入'
                ,'name' => 'chengji/luru/malu'
                ,'paixu' => 1
                ,'ismenu'  => 1
                ,'p_id'  => 1
                ,'url' => '/chengji/luru/malu'
            ],
                ['id' => 10101
                    ,'title' => '扫码查询'
                    ,'name' => 'Chengji/Luru/read'
                    ,'paixu'  => 1
                    ,'p_id' => 101
                ]
                ,['id' => 10102
                    ,'title' => '扫码保存'
                    ,'name' => 'Chengji/Luru/malusave'
                    ,'paixu'  => 2
                    ,'p_id' => 101
                ],
            ['id' => 102
                ,'title' => '表格录入'
                ,'name' => 'chengji/luru/biaolu'
                ,'paixu' => 2
                ,'ismenu'  => 1
                ,'p_id'  => 1
                ,'url' => '/chengji/luru/biaolu'
            ],
                ['id' => 10201
                    ,'title' => '表格保存'
                    ,'name' => 'Chengji/Luru/saveAll'
                    ,'paixu'  => 1
                    ,'p_id' => 102
                ],
                ['id' => 10202
                    ,'title' => '表格上传'
                    ,'name' => 'Chengji/Luru/upload'
                    ,'paixu'  => 2
                    ,'p_id' => 102
                ],
            ['id' => 103
                ,'title' => '已录列表'
                ,'name' => 'chengji/luru/index'
                ,'paixu' => 2
                ,'ismenu'  => 1
                ,'p_id'  => 1
                ,'url' => '/chengji/luru/index'
            ],
                ['id' => 10301
                    ,'title' => '成绩更新'
                    ,'name' => 'Chengji/Luru/update'
                    ,'paixu'  => 1
                    ,'p_id' => 103
                ],
                // 成绩状态
                ['id' => 10302
                    ,'title' => '成绩状态'
                    ,'name' => 'Chengji/Index/setStatus'
                    ,'paixu' => 2
                    ,'p_id' => 103
                ],

            /*======================================================================
             * 考试管理
             */
            ['id' => 3
                ,'title'  => '考试管理'
                ,'name' => 'kaoshi'
                ,'paixu'  => 2
                ,'ismenu'  => 1
                ,'font' => '&#xe6ee;'
            ],
            ['id' => 301
                ,'title' => '考试列表'
                ,'name' => 'kaoshi/Index/index'
                ,'paixu' => 1
                ,'ismenu'  => 1
                ,'p_id'  => 3
                ,'url' => '/kaoshi/index'
            ],
                ['id' => 30101
                    ,'title' => '添加'
                    ,'name' => 'Kaoshi/Index/create'
                    ,'paixu'  => 1
                    ,'p_id' => 301
                ],
                ['id' => 30102
                    ,'title' => '删除'
                    ,'name' => 'Kaoshi/Index/delete'
                    ,'paixu' => 2
                    ,'p_id' => 301
                ],
                ['id' => 30103
                    ,'title' => '编辑'
                    ,'name' => 'Kaoshi/Index/edit'
                    ,'paixu' => 3
                    ,'p_id' => 301
                ],
                ['id' => 30104
                    ,'title' => '更新'
                    ,'name' => 'Kaoshi/Index/update'
                    ,'paixu' => 4
                    ,'p_id' => 301
                ],
                ['id' => 30105
                    ,'title' => '保存'
                    ,'name' => 'Kaoshi/Index/save'
                    ,'paixu' => 5
                    ,'p_id' => 301
                ],
                ['id' => 30106
                    ,'title' => '状态'
                    ,'name' => 'Kaoshi/Index/setStatus'
                    ,'paixu' => 6
                    ,'p_id' => 301
                ],
                ['id' => 30107
                    ,'title' => '操作成绩权限'
                    ,'name' => 'Kaoshi/Index/luru'
                    ,'paixu' => 7
                    ,'p_id' => 301
                ],
            ['id' => 302
                ,'title' => '考试操作'
                ,'name' => 'Kaoshi/Index/MoreAction'
                ,'paixu' => 2
                ,'ismenu'  => 0
                ,'p_id'  => 3
            ],
                ['id' => 30201
                    ,'title' => '前期操作'
                    ,'name' => 'yiqianqi'
                    ,'paixu' => 1
                    ,'p_id' => 302
                ],
                    ['id' => 3020101
                        ,'title' => '考试设置'
                        ,'name' => 'zhanwei_3020101'
                        ,'paixu' => 1
                        ,'p_id' => 30201
                    ],
                        ['id' => 302010101
                            ,'title' => '考试设置'
                            ,'name' => 'kaoshi/kaoshiset/index'
                            ,'paixu' => 1
                            ,'p_id' => 3020101
                        ],
                        ['id' => 302010102
                            ,'title' => '新建'
                            ,'name' => 'kaoshi/kaoshiset/create'
                            ,'paixu' => 1
                            ,'p_id' => 3020101
                        ],
                        ['id' => 302010103
                            ,'title' => '保存'
                            ,'name' => 'kaoshi/kaoshiset/save'
                            ,'paixu' => 2
                            ,'p_id' => 3020101
                        ],
                        ['id' => 302010104
                            ,'title' => '删除'
                            ,'name' => 'kaoshi/kaoshiset/delete'
                            ,'paixu' => 3
                            ,'p_id' => 3020101
                        ],
                        ['id' => 302010105
                            ,'title' => '编辑'
                            ,'name' => 'kaoshi/kaoshiset/edit'
                            ,'paixu' => 4
                            ,'p_id' => 3020101
                        ],
                        ['id' => 302010106
                            ,'title' => '更新'
                            ,'name' => 'kaoshi/kaoshiset/update'
                            ,'paixu' => 5
                            ,'p_id' => 3020101
                        ],
                        ['id' => 302010107
                            ,'title' => '状态'
                            ,'name' => 'kaoshi/kaoshiset/setStatus'
                            ,'paixu' => 6
                            ,'p_id' => 3020101
                        ],
                    ['id' => 3020102
                        ,'title' => '生成考号'
                        ,'name' => 'kaoshi/Kaohao/createall'
                        ,'paixu' => 1
                        ,'p_id' => 30201
                    ],
                        ['id' => 302010201
                            ,'title' => '生成考号备用'
                            ,'name' => 'zhanwei_302010201'
                            ,'paixu' => 2
                            ,'p_id' => 3020102
                        ],

                    ['id' => 3020103
                        ,'title' => '下载试卷标签信息'
                        ,'name' => 'kaoshi/Kaohao/biaoqian'
                        ,'paixu' => 4
                        ,'p_id' => 30201
                    ],
                        ['id' => 302010301
                            ,'title' => '生成考号备用'
                            ,'name' => 'zhanwei_302010301'
                            ,'paixu' => 2
                            ,'p_id' => 3020102
                        ],
                ['id' => 30202
                    ,'title' => '成绩录入'
                    ,'name' => 'erluru'
                    ,'paixu' => 2
                    ,'p_id' => 302
                ],
                    // 录入成绩
                    ['id' => 3020201
                        ,'title' => '下载成绩采集表'
                        ,'name' => 'kaoshi/Kaohao/caiji'
                        ,'paixu' => 1
                        ,'p_id' => 30202
                    ],
                    ['id' => 3020202
                        ,'title' => '已录成绩数量'
                        ,'name' => 'Chengji/Tongji/yiluCnt'
                        ,'paixu' => 2
                        ,'p_id' => 30202
                    ],
                ['id' => 30203
                    ,'title' => '成绩统计'
                    ,'name' => 'santongji'
                    ,'paixu' => 4
                    ,'p_id' => 302
                ],
                    ['id' => 3020301
                        ,'title' => '以班级为单位统计成绩'
                        ,'name' => 'chengji/Bjtongji/tongji'
                        ,'paixu' => 1
                        ,'p_id' => 30203
                    ],
                    ['id' => 3020302
                        ,'title' => '以学校为单位统计成绩'
                        ,'name' => 'chengji/Njtongji/tongji'
                        ,'paixu' => 2
                        ,'p_id' => 30203
                    ],
                    ['id' => 3020303
                        ,'title' => '以全部成绩为单位统计成绩'
                        ,'name' => 'chengji/Schtongji/tongji'
                        ,'paixu' => 3
                        ,'p_id' => 30203
                    ],
                    ['id' => 3020304
                        ,'title' => '统计学生成绩在班级位置'
                        ,'name' => 'chengji/Bjtongji/bjorder'
                        ,'paixu' => 4
                        ,'p_id' => 30203
                    ],
                    ['id' => 3020305
                        ,'title' => '统计学生成绩在学校位置'
                        ,'name' => 'chengji/Njtongji/njorder'
                        ,'paixu' => 5
                        ,'p_id' => 30203
                    ],
                    ['id' => 3020306
                        ,'title' => '统计学生成绩在区位置'
                        ,'name' => 'chengji/Schtongji/schorder'
                        ,'paixu' => 6
                        ,'p_id' => 30203
                    ],
                    ['id' => 3020307
                        ,'title' => '检测统计结果'
                        ,'name' => 'kaoshi/tjlog/index'
                        ,'paixu' => 7
                        ,'p_id' => 30203
                    ],
                ['id' => 30204
                    ,'title' => '统计结果'
                    ,'name' => 'sijieguo'
                    ,'paixu' => 4
                    ,'p_id' => 302
                ],
                    ['id' => 3020401
                        ,'title' => '学生成绩'
                        ,'name' => 'Chengji/Index/index'
                        ,'paixu' => 1
                        ,'p_id' => 30204
                    ],
                        ['id' => 302040101
                            ,'title' => '录入人信息'
                            ,'name' => 'Chengji/Index/readAdd'
                            ,'paixu' => 1
                            ,'p_id' => 3020401
                        ],
                        ['id' => 302040102
                            ,'title' => '考号删除'
                            ,'name' => 'kaoshi/Kaohao/delete'
                            ,'paixu' => 2
                            ,'p_id' => 3020401
                        ],
                            ['title' => '批量删除成绩'
                                ,'name' => 'Chengji/Index/delete'
                                ,'paixu' => 3
                                ,'p_id' => 3020401
                            ],
                        ['id' => 302040103
                            ,'title' => '批量删除界面'
                            ,'name' => 'Chengji/Index/deletecjs'
                            ,'paixu' => 4
                            ,'p_id' => 3020401
                        ],
                        ['id' => 302040104
                            ,'title' => '批量删除'
                            ,'name' => 'Chengji/Index/deletecjmore'
                            ,'paixu' => 5
                            ,'p_id' => 3020401
                        ],
                        ['id' => 302040105
                            ,'title' => '下载学生成绩条'
                            ,'name' => 'Chengji/Index/dwChengjitiao'
                            ,'paixu' => 6
                            ,'p_id' => 3020401
                        ],
                        ['id' => 302040106
                            ,'title' => '添加单个考号'
                            ,'name' => 'Kaoshi/Kaohao/create'
                            ,'paixu' => 7
                            ,'p_id' => 3020401
                        ],
                        ['id' => 302040107
                            ,'title' => '保存单个考号'
                            ,'name' => 'Kaoshi/Kaohao/save'
                            ,'paixu' => 8
                            ,'p_id' => 3020401
                        ],
                        ['id' => 302040108
                            ,'title' => '学生成绩图表'
                            ,'name' => 'kaoshi/kaohao/read'
                            ,'paixu' => 9
                            ,'p_id' => 3020401
                        ],
                        ['id' => 302040109
                            ,'title' => '下载学生成绩'
                            ,'name' => 'chengji/Index/dwChengji'
                            ,'paixu' => 10
                            ,'p_id' => 3020401
                        ],
                    // 班级成绩统计表
                    ['id' => 3020402
                        ,'title' => '班级成绩'
                        ,'name' => 'banjichengji'
                        ,'paixu' => 2
                        ,'p_id' => 30204
                    ],
                        ['id' => 302040201
                            ,'title' => '班级成绩统计'
                            ,'name' => 'Chengji/Bjtongji/biaoge'
                            ,'paixu' => 1
                            ,'p_id' => 3020402
                        ],
                        ['id' => 302040202
                            ,'title' => '下载班级成绩统计表'
                            ,'name' => 'chengji/Bjtongji/dwBiaoge'
                            ,'paixu' => 2
                            ,'p_id' => 3020402
                        ],
                        ['id' => 302040203
                            ,'title' => '条形统计图'
                            ,'name' => 'chengji/Bjtongji/myavg'
                            ,'paixu' => 3
                            ,'p_id' => 3020402
                        ],
                        ['id' => 302040204
                            ,'title' => '箱体图'
                            ,'name' => 'chengji/Bjtongji/myxiangti'
                            ,'paixu' => 4
                            ,'p_id' => 3020402
                        ],
                    // 年级成绩统计表
                    ['id' => 3020403
                        ,'title' => '年级成绩'
                        ,'name' => 'nianjichengji'
                        ,'paixu' => 3
                        ,'p_id' => 30204
                    ],
                        ['id' => 302040301
                            ,'title' => '年级成绩统计'
                            ,'name' => 'Chengji/Njtongji/biaoge'
                            ,'paixu' => 1
                            ,'p_id' => 3020403
                        ],
                        ['id' => 302040302
                            ,'title' => '下载年级成绩统计表'
                            ,'name' => 'chengji/Njtongji/dwBiaoge'
                            ,'paixu' => 2
                            ,'p_id' => 3020403
                        ],
                        ['id' => 302040303
                            ,'title' => '条形统计图'
                            ,'name' => 'chengji/Njtongji/myavg'
                            ,'paixu' => 3
                            ,'p_id' => 3020403
                        ],
                        ['id' => 302040304
                            ,'title' => '箱体图'
                            ,'name' => 'chengji/Njtongji/myxiangti'
                            ,'paixu' => 4
                            ,'p_id' => 3020403
                        ],
                    // 统计记录
                    ['id' => 3020404
                        ,'title' => '统计记录'
                        ,'name' => 'kaoshi/TongjiLog/index'
                        ,'paixu' => 4
                        ,'p_id' => 30204
                    ],

            /*======================================================================
             * 考试管理
             */
            ['id' => 4
                ,'title'  => '师生名单'
                ,'name' => 'renshi'
                ,'paixu'  => 3
                ,'ismenu'  => 1
                ,'font' => '&#xe699;'
            ],
            ['id' => 401
                ,'title' => '学生列表'
                ,'name' => 'renshi/Student/index'
                ,'paixu' => 1
                ,'ismenu'  => 1
                ,'p_id'  => 4
                ,'url' => '/renshi/student'
            ],
                // 学生管理权限
                ['id' => 40101
                    ,'title' => '添加'
                    ,'name' => 'renshi/Student/create'
                    ,'paixu'  => 1
                    ,'p_id' => 401
                ],
                ['id' => 40102
                    ,'title' => '保存'
                    ,'name' => 'renshi/Student/save'
                    ,'paixu' => 2
                    ,'p_id' => 401
                ],
                ['id' => 40103
                    ,'title' => '删除'
                    ,'name' => 'renshi/Student/delete'
                    ,'paixu' => 3
                    ,'p_id' => 401
                ],
                ['id' => 40104
                    ,'title' => '编辑'
                    ,'name' => 'renshi/Student/edit'
                    ,'paixu' => 4
                    ,'p_id' => 401
                ],
                ['id' => 40105
                    ,'title' => '更新'
                    ,'name' => 'renshi/Student/update'
                    ,'paixu' => 5
                    ,'p_id' => 401
                ],
                ['id' => 40106
                    ,'title' => '查看信息'
                    ,'name' => 'renshi/Student/read'
                    ,'paixu' => 6
                    ,'p_id' => 401
                ]
                ,['id' => 40107
                   ,'title' => '状态'
                    ,'name' => 'renshi/Student/setStatus'
                    ,'paixu' => 7
                    ,'p_id' => 401
                ],
                ['id' => 40108
                    ,'title' => '是否参加考试'
                    ,'name' => 'renshi/Student/setKaoshi'
                    ,'paixu' => 8
                    ,'p_id' => 401
                ],
                ['id' => 40109
                    ,'title' => '下载模板'
                    ,'name' => 'renshi/Student/download'
                    ,'paixu' => 9
                    ,'p_id' => 401
                ],
                ['id' => 40110
                    ,'title' => '校对导入'
                    ,'name' => 'renshi/Student/createAll'
                    ,'paixu' => 10
                    ,'p_id' => 401
                ],
                ['id' => 4011
                    ,'title' => '批量保存'
                    ,'name' => 'renshi/Student/saveAll'
                    ,'paixu' => 11
                    ,'p_id' => 401
                ],
                ['id' => 40112
                    ,'title' => '表格删除页面'
                    ,'name' => 'renshi/Student/deletes'
                    ,'paixu' => 12
                    ,'p_id' => 401
                ],
                ['id' => 40113
                    ,'title' => '表格删除数据'
                    ,'name' => 'renshi/Student/deleteXlsx'
                    ,'paixu' => 13
                    ,'p_id' => 401
                ],
                ['id' => 40114
                    ,'title' => '查看成绩'
                    ,'name' => 'renshi/StudentChengji/index'
                    ,'paixu' => 14
                    ,'p_id' => 401
                ],
            // 师生名单
            ['id' => 402
                ,'title' => '毕业学生'
                ,'name' => 'renshi/Student/byList'
                ,'paixu' => 2
                ,'ismenu'  => 1
                ,'p_id'  => 4
                ,'url' => '/renshi/student/bylist'
            ],
                // 毕业学生
                ['id' => 40201
                    ,'title' => '格式占位'
                    ,'name' => 'biyexueshengzhanwei'
                    ,'paixu'  => 1
                    ,'p_id' => 402
                ],
            // 师生名单
            ['id' => 403
                ,'title' => '删除学生'
                ,'name' => 'renshi/Student/delList'
                ,'paixu' => 3
                ,'ismenu'  => 1
                ,'p_id'  => 4
                ,'url' => '/renshi/student/dellist'
            ],
                // 删除学生
                ['id' => 40301
                    ,'title' => '恢复删除'
                    ,'name' => 'renshi/Student/reDel'
                    ,'paixu' => 1
                    ,'p_id' => 403
                ],
            ['id' => 404
                ,'title' => '教师列表'
                ,'name' => 'renshi/Teacher/index'
                ,'paixu' => 4
                ,'ismenu'  => 1
                ,'p_id'  => 4
                ,'url' => '/renshi/teacher'
            ],
                // 教师管理权限
                ['id' => 40401
                    ,'title' => '添加'
                    ,'name' => 'renshi/Teacher/create'
                    ,'paixu'  => 1
                    ,'p_id' => 404
                ],
                ['id' => 40402
                    ,'title' => '保存'
                    ,'name' => 'renshi/Teacher/save'
                    ,'paixu'  => 2
                    ,'p_id' => 404
                ],
                ['id' => 40403
                    ,'title' => '删除'
                    ,'name' => 'renshi/Teacher/delete'
                    ,'paixu' => 3
                    ,'p_id' => 404
                ],
                ['id' => 40404
                    ,'title' => '编辑'
                    ,'name' => 'renshi/Teacher/edit'
                    ,'paixu' => 4
                    ,'p_id' => 404
                ],
                ['id' => 40405
                    ,'title' => '更新'
                    ,'name' => 'renshi/Teacher/update'
                    ,'paixu'  => 5
                    ,'p_id' => 404
                ],
                ['id' => 40406
                    ,'title' => '查看'
                    ,'name' => 'renshi/Teacher/read'
                    ,'paixu' => 6
                    ,'p_id' => 404
                ],
                ['id' => 40407
                    ,'title' => '状态'
                    ,'name' => 'renshi/Teacher/setStatus'
                    ,'paixu' => 7
                    ,'p_id' => 404
                ],
                ['id' => 40408
                    ,'title' => '查询教师'
                    ,'name' => 'renshi/Teacher/srcTeacher'
                    ,'paixu' => 8
                    ,'p_id' => 404
                ],
                ['id' => 40409
                    ,'title' => '批量上传'
                    ,'name' => 'renshi/Teacher/createAll'
                    ,'paixu' => 9
                    ,'p_id' => 404
                ],
                ['id' => 40410
                    ,'title' => '批量保存'
                    ,'name' => 'renshi/Teacher/saveAll'
                    ,'paixu' => 10
                    ,'p_id' => 404
                ],
                ['id' => 40411
                    ,'title' => '表格模板下载'
                    ,'name' => 'renshi/Teacher/downloadXls'
                    ,'paixu' => 11
                    ,'p_id' => 404
                ],
            ['id' => 405
                ,'title' => '删除教师'
                ,'name' => 'renshi/Teacher/delList'
                ,'paixu' => 5
                ,'ismenu'  => 1
                ,'p_id'  => 4
                ,'url' => '/renshi/teacher/dellist'
            ],
                // 删除教师
                ['id' => 40501
                    ,'title' => '恢复删除'
                    ,'name' => 'renshi/Teacher/reDel'
                    ,'paixu' => 1
                    ,'p_id' => 405
                ],

            /*======================================================================
             * 考试管理
             */
            ['id' => 5
                ,'title'  => '教务管理'
                ,'name' => 'teach'
                ,'paixu'  => 4
                ,'ismenu'  => 1
                ,'font' => '&#xe6da;'
            ],
            ['id' => 501
                ,'title' => '学期列表'
                ,'name' => 'teach/Xueqi/index'
                ,'paixu' => 1
                ,'ismenu'  => 1
                ,'p_id'  => 5
                ,'url' => '/teach/xueqi'
            ],
                ['id' => 50101
                    ,'title' => '添加'
                    ,'name' => 'teach/Xueqi/create'
                    ,'paixu'  => 1
                    ,'p_id' => 501
                ],
                ['id' => 50102
                    ,'title' => '保存'
                    ,'name' => 'teach/Xueqi/save'
                    ,'paixu'  => 2
                    ,'p_id' => 501
                ],
                ['id' => 50103
                    ,'title' => '删除'
                    ,'name' => 'teach/Xueqi/delete'
                    ,'paixu' => 3
                    ,'p_id' => 501
                ],
                ['id' => 50104
                    ,'title' => '编辑'
                    ,'name' => 'teach/Xueqi/edit'
                    ,'paixu' => 4
                    ,'p_id' => 501
                ],
                ['id' => 50105
                    ,'title' => '更新'
                    ,'name' => 'teach/Xueqi/update'
                    ,'paixu'  => 5
                    ,'p_id' => 501
                ],
                ['id' => 50106
                    ,'title' => '查看'
                    ,'name' => 'teach/Xueqi/read'
                    ,'paixu' => 6
                    ,'p_id' => 501
                ],
                ['id' => 50107
                    ,'title' => '状态'
                    ,'name' => 'teach/Xueqi/setStatus'
                    ,'paixu' => 7
                    ,'p_id' => 501
                ],
            ['id' => 502
                ,'title' => '班级列表'
                ,'name' => 'teach/Banji/index'
                ,'paixu' => 2
                ,'ismenu'  => 1
                ,'p_id'  => 5
                ,'url' => '/teach/banji'
            ],
                ['id' => 500201
                    ,'title' => '添加'
                    ,'name' => 'teach/Banji/create'
                    ,'paixu'  => 1
                    ,'p_id' => 502
                ],
                ['id' => 500202
                    ,'title' => '保存'
                    ,'name' => 'teach/Banji/save'
                    ,'paixu'  => 2
                    ,'p_id' => 502
                ],
                ['id' => 500203
                    ,'title' => '移动'
                    ,'name' => 'teach/Banji/yidong'
                    ,'paixu' => 3
                    ,'p_id' => 502
                ],
                ['id' => 500204
                    ,'title' => '删除'
                    ,'name' => 'teach/Banji/delete'
                    ,'paixu' => 4
                    ,'p_id' => 502
                ],
                ['id' => 500205
                    ,'title' => '状态'
                    ,'name' => 'teach/Banji/setStatus'
                    ,'paixu' => 5
                    ,'p_id' => 502
                ],
                ['id' => 500206
                    ,'title' => '成绩查看'
                    ,'name' => 'teach/BanjiChengji/index'
                    ,'paixu' => 6
                    ,'p_id' => 502
                ],
            ['id' => 503
                ,'title' => '学科列表'
                ,'name' => 'teach/Subject/index'
                ,'paixu' => 3
                ,'ismenu'  => 1
                ,'p_id'  => 5
                ,'url' => '/teach/subject'
            ],
                // 学科列表权限
                ['id' => 50301
                    ,'title' => '添加'
                    ,'name' => 'teach/Subject/create'
                    ,'paixu'  => 1
                    ,'p_id' => 503
                ],
                ['id' => 50302
                    ,'title' => '保存'
                    ,'name' => 'teach/Subject/save'
                    ,'paixu'  => 2
                    ,'p_id' => 503
                ],
                ['id' => 50303
                    ,'title' => '删除'
                    ,'name' => 'teach/Subject/delete'
                    ,'paixu' => 3
                    ,'p_id' => 503
                ],
                ['id' => 50304
                    ,'title' => '编辑'
                    ,'name' => 'teach/Subject/edit'
                    ,'paixu' => 4
                    ,'p_id' => 503
                ],
                ['id' => 50305
                    ,'title' => '更新'
                    ,'name' => 'teach/Subject/update'
                    ,'paixu'  => 5
                    ,'p_id' => 503
                ],
                ['id' => 50306
                    ,'title' => '查看'
                    ,'name' => 'teach/Subject/read'
                    ,'paixu' => 6
                    ,'p_id' => 503
                ],
                ['id' => 50307
                    ,'title' => '状态'
                    ,'name' => 'teach/Subject/setStatus'
                    ,'paixu' => 7
                    ,'p_id' => 503
                ],
                ['id' => 50308
                    ,'title' => '参加考试'
                    ,'name' => 'teach/subject/kaoshi'
                    ,'paixu' => 8
                    ,'p_id' => 503
                ],

            /*======================================================================
             * 考试管理
             */
            ['id' => 6
                ,'title'  => '管理员管理'
                ,'name' => 'admin'
                ,'paixu'  => 5
                ,'ismenu'  => 1
                ,'font' => '&#xe6b8;'
            ],
            /*====================================*/
            ['id' => 601
                ,'title' => '管理员列表'
                ,'name' => 'admin/Index/index'
                ,'paixu' => 1
                ,'ismenu'  => 1
                ,'p_id'  => 6
                ,'url' => '/admin/index'
            ],
                // 管理员列表权限
                ['id' => 60101
                    ,'title' => '添加'
                    ,'name' => 'admin/Index/create'
                    ,'paixu'  => 1
                    ,'p_id' => 601
                ],
                ['id' => 60102
                    ,'title' => '保存'
                    ,'name' => 'admin/Index/save'
                    ,'paixu'  => 2
                    ,'p_id' => 601
                ],
                ['id' => 60103
                    ,'title' => '删除'
                    ,'name' => 'admin/Index/delete'
                    ,'paixu' => 3
                    ,'p_id' => 601
                ],
                ['id' => 60104
                    ,'title' => '编辑'
                    ,'name' => 'admin/Index/edit'
                    ,'paixu' => 4
                    ,'p_id' => 601
                ],
                ['id' => 60105
                    ,'title' => '更新'
                    ,'name' => 'admin/Index/update'
                    ,'paixu'  => 5
                    ,'p_id' => 601
                ],
                ['id' => 60106
                    ,'title' => '查看'
                    ,'name' => 'admin/Index/read'
                    ,'paixu' => 6
                    ,'p_id' => 601
                ],
                ['id' => 60107
                    ,'title' => '状态'
                    ,'name' => 'admin/Index/setStatus'
                    ,'paixu' => 7
                    ,'p_id' => 601
                ],
                ['id' => 60108
                    ,'title' => '重置密码'
                    ,'name' => 'admin/Index/resetpassword'
                    ,'paixu'  => 8
                    ,'p_id' => 601
                ],
            ['id' => 602
                ,'title' => '权限列表'
                ,'name' => 'admin/AuthRule/index'
                ,'paixu' => 2
                ,'ismenu'  => 1
                ,'p_id'  => 6
                ,'url' => '/admin/Authrule'
            ],
                ['id' => 60201
                    ,'title' => '添加'
                    ,'name' => 'admin/AuthRule/create'
                    ,'paixu'  => 1
                    ,'p_id' => 602
                ],
                ['id' => 60202
                    ,'title' => '保存'
                    ,'name' => 'admin/AuthRule/save'
                    ,'paixu'  => 2
                    ,'p_id' => 602
                ],
                ['id' => 60203
                    ,'title' => '删除'
                    ,'name' => 'admin/AuthRule/delete'
                    ,'paixu' => 3
                    ,'p_id' => 602
                ],
                ['id' => 60204
                    ,'title' => '编辑'
                    ,'name' => 'admin/AuthRule/edit'
                    ,'paixu' => 4
                    ,'p_id' => 602
                ],
                ['id' => 60205
                    ,'title' => '更新'
                    ,'name' => 'admin/AuthRule/update'
                    ,'paixu'  => 5
                    ,'p_id' => 602
                ],
                ['id' => 60206
                    ,'title' => '查看'
                    ,'name' => 'admin/AuthRule/read'
                    ,'paixu' => 6
                    ,'p_id' => 602
                ],
                ['id' => 60207
                    ,'title' => '状态'
                    ,'name' => 'admin/AuthRule/setStatus'
                    ,'paixu' => 7
                    ,'p_id' => 602
                ],

            ['id' => 603
                ,'title' => '角色列表'
                ,'name' => 'admin/AuthGroup/index'
                ,'paixu' => 3
                ,'ismenu'  => 1
                ,'p_id'  => 6
                ,'url' => '/admin/authgroup'
            ],
                ['id' => 60301
                    ,'title' => '添加'
                    ,'name' => 'admin/AuthGroup/create'
                    ,'paixu'  => 1
                    ,'p_id' => 603
                ],
                ['id' => 60302
                    ,'title' => '保存'
                    ,'name' => 'admin/AuthGroup/save'
                    ,'paixu'  => 2
                    ,'p_id' => 603
                ],
                ['id' => 60303
                    ,'title' => '删除'
                    ,'name' => 'admin/AuthGroup/delete'
                    ,'paixu' => 3
                    ,'p_id' => 603
                ],
                ['id' => 60304
                    ,'title' => '编辑'
                    ,'name' => 'admin/AuthGroup/edit'
                    ,'paixu' => 4
                    ,'p_id' => 603
                ],
                ['id' => 60305
                    ,'title' => '更新'
                    ,'name' => 'admin/AuthGroup/update'
                    ,'paixu'  => 5
                    ,'p_id' => 603
                ],
                ['id' => 60306
                    ,'title' => '查看'
                    ,'name' => 'admin/AuthGroup/read'
                    ,'paixu' => 6
                    ,'p_id' => 603
                ],
                ['id' => 60307
                    ,'title' => '状态'
                    ,'name' => 'admin/AuthGroup/setStatus'
                    ,'paixu' => 7
                    ,'p_id' => 603
                ],

            /*======================================================================
             * 考试管理
             */
            ['id' => 7
                ,'title' => '系统管理'
                ,'name'  => 'system'
                ,'paixu'  => 8
                ,'ismenu'  => 1
                ,'font'  => '&#xe6ae;'
            ],
            /*====================================*/
            ['id' => 701
                ,'title' => '类别管理'
                ,'name' => 'system/Category/index'
                ,'paixu' => 1
                ,'ismenu'  => 1
                ,'p_id'  => 7
                ,'url' => '/system/category'
            ],
                ['id' => 70101
                    ,'title' => '添加'
                    ,'name' => 'system/Category/create'
                    ,'paixu'  => 1
                    ,'p_id' => 701
                ],
                ['id' => 70102
                    ,'title' => '保存'
                    ,'name' => 'system/Category/save'
                    ,'paixu'  => 2
                    ,'p_id' => 701
                ],
                ['id' => 70103
                    ,'title' => '删除'
                    ,'name' => 'system/Category/delete'
                    ,'paixu' => 3
                    ,'p_id' => 701
                ],
                ['id' => 70104
                    ,'title' => '编辑'
                    ,'name' => 'system/Category/edit'
                    ,'paixu' => 4
                    ,'p_id' => 701
                ],
                ['id' => 70105
                    ,'title' => '更新'
                    ,'name' => 'system/Category/update'
                    ,'paixu'  => 5
                    ,'p_id' => 701
                ],
                ['id' => 70106
                    ,'title' => '查看'
                    ,'name' => 'system/Category/read'
                    ,'paixu' => 6
                    ,'p_id' => 701
                ],
                ['id' => 70107
                    ,'title' => '状态'
                    ,'name' => 'system/Category/setStatus'
                    ,'paixu' => 7
                    ,'p_id' => 701
                ],
            ['id' => 702
                ,'title' => '单位管理'
                ,'name' => 'system/School/index'
                ,'paixu' => 2
                ,'ismenu'  => 1
                ,'p_id'  => 7
                ,'url' => '/system/school'
            ],
                ['id' => 70201
                    ,'title' => '添加'
                    ,'name' => 'system/School/create'
                    ,'paixu'  => 1
                    ,'p_id' => 702
                ],
                ['id' => 70202
                    ,'title' => '保存'
                    ,'name' => 'system/School/save'
                    ,'paixu'  => 2
                    ,'p_id' => 702
                ],
                ['id' => 70203
                    ,'title' => '删除'
                    ,'name' => 'system/School/delete'
                    ,'paixu' => 3
                    ,'p_id' => 702
                ],
                ['id' => 70204
                    ,'title' => '编辑'
                    ,'name' => 'system/School/edit'
                    ,'paixu' => 4
                    ,'p_id' => 702
                ],
                ['id' => 70205
                    ,'title' => '更新'
                    ,'name' => 'system/School/update'
                    ,'paixu'  => 5
                    ,'p_id' => 702
                ],
                ['id' => 70206
                    ,'title' => '查看'
                    ,'name' => 'system/School/read'
                    ,'paixu' => 6
                    ,'p_id' => 702
                ],
                ['id' => 70207
                    ,'title' => '状态'
                    ,'name' => 'system/School/setStatus'
                    ,'paixu' => 7
                    ,'p_id' => 702
                ],
            ['id' => 703
                ,'title' => '文件管理'
                ,'name' => 'system/Fields/index'
                ,'paixu' => 3
                ,'ismenu'  => 1
                ,'p_id'  => 7
                ,'url' => '/system/file'
            ],
                ['id' => 70301
                    ,'title' => '删除'
                    ,'name' => 'system/Fields/delete'
                    ,'paixu' => 1
                    ,'p_id' => 703
                ],
                ['id' => 70302
                    ,'title' => '下载'
                    ,'name' => 'system/Fields/download'
                    ,'paixu' => 2
                    ,'p_id' => 703
                ],
            ['id' => 704
                ,'title' => '系统设置'
                ,'name' => 'system/SystemBase/edit'
                ,'paixu' => 10
                ,'ismenu'  => 1
                ,'p_id'  => 7
                ,'url' => '/system/'
            ],
                ['id' => 70401
                    ,'title' => '更新'
                    ,'name' => 'system/SystemBase/update'
                    ,'paixu' => 1
                    ,'p_id'  => 704
                ],

            /*======================================================================
             * 考试管理
             */
            ['id' => 8
                ,'title' => '荣誉管理'
                ,'name'  => 'rongyu'
                ,'paixu'  => 6
                ,'ismenu'  => 1
                ,'font'  => '&#xe6e4;'
                ,'status' => 0
            ],
            /*====================================*/
            ['id' => 801
                ,'title' => '单位荣誉'
                ,'name' => 'rongyu/Danwei/index'
                ,'paixu' => 1
                ,'ismenu'  => 1
                ,'p_id'  => 8
                ,'url' => '/rongyu/danwei'
            ],
                ['id' => 80101
                    ,'title' => '添加'
                    ,'name' => 'rongyu/Danwei/create'
                    ,'paixu'  => 1
                    ,'p_id' => 801
                ],
                ['id' => 80102
                    ,'title' => '保存'
                    ,'name' => 'rongyu/Danwei/save'
                    ,'paixu'  => 2
                    ,'p_id' => 801
                ],
                ['id' => 80103
                    ,'title' => '删除'
                    ,'name' => 'rongyu/Danwei/delete'
                    ,'paixu' => 3
                    ,'p_id' => 801
                ],
                ['id' => 80104
                    ,'title' => '编辑'
                    ,'name' => 'rongyu/Danwei/edit'
                    ,'paixu' => 4
                    ,'p_id' => 801
                ],
                ['id' => 80105
                    ,'title' => '更新'
                    ,'name' => 'rongyu/Danwei/update'
                    ,'paixu'  => 5
                    ,'p_id' => 801
                ],
                ['id' => 80106
                    ,'title' => '查看'
                    ,'name' => 'rongyu/Danwei/read'
                    ,'paixu' => 6
                    ,'p_id' => 801
                ],
                ['id' => 80107
                    ,'title' => '状态'
                    ,'name' => 'rongyu/Danwei/setStatus'
                    ,'paixu' => 7
                    ,'p_id' => 801
                ]
                ,['title' => '批量上传'
                    ,'id' => 80108
                    ,'name' => 'rongyu/Danwei/createAll'
                    ,'paixu' => 8
                    ,'p_id' => 801
                ],
                ['id' => 80109
                    ,'title' => '批量保存'
                    ,'name' => 'rongyu/Danwei/saveAll'
                    ,'paixu' => 9
                    ,'p_id' => 801
                ],
            ['id' => 802
                ,'title' => '教师荣誉册'
                ,'name' => 'rongyu/Jiaoshi/index'
                ,'paixu' => 2
                ,'ismenu'  => 1
                ,'p_id'  => 8
                ,'url' => '/rongyu/jiaoshi'
            ],
                ['id' => 80201
                    ,'title' => '添加'
                    ,'name' => 'rongyu/Jiaoshi/create'
                    ,'paixu'  => 1
                    ,'p_id' => 802
                ],
                ['id' => 80202
                    ,'title' => '保存'
                    ,'name' => 'rongyu/Jiaoshi/save'
                    ,'paixu'  => 2
                    ,'p_id' => 802
                ],
                ['id' => 80203
                    ,'title' => '删除'
                    ,'name' => 'rongyu/Jiaoshi/delete'
                    ,'paixu' => 3
                    ,'p_id' => 802
                ],
                ['id' => 80204
                    ,'title' => '编辑'
                    ,'name' => 'rongyu/Jiaoshi/edit'
                    ,'paixu' => 4
                    ,'p_id' => 802
                ],
                ['id' => 80205
                    ,'title' => '更新'
                    ,'name' => 'rongyu/Jiaoshi/update'
                    ,'paixu'  => 5
                    ,'p_id' => 802
                ],
                ['id' => 80206
                    ,'title' => '查看'
                    ,'name' => 'rongyu/Jiaoshi/read'
                    ,'paixu' => 6
                    ,'p_id' => 802
                ],
                ['id' => 80207
                    ,'title' => '状态'
                    ,'name' => 'rongyu/Jiaoshi/setStatus'
                    ,'paixu' => 6
                    ,'p_id' => 802
                ],
                ['id' => 80208
                    ,'title' => '查看荣誉信息'
                    ,'name' => 'rongyu/JsRongyuInfo/rongyuList'
                    ,'paixu' => 7
                    ,'p_id' => 802
                ],
                ['id' => 80209
                    ,'title' => '下载表格'
                    ,'name' => 'rongyu/JsRongyuInfo/outXlsx'
                    ,'paixu' => 8
                    ,'p_id' => 802
                ],
            ['id' => 803
                ,'title' => '教师荣誉信息'
                ,'name' => 'rongyu/JsRongyuInfo/index'
                ,'paixu' => 3
                ,'ismenu'  => 1
                ,'p_id'  => 8
                ,'url' => '/rongyu/jsryinfo'
            ],
                ['id' => 80301
                    ,'title' => '添加'
                    ,'name' => 'rongyu/JsRongyuInfo/create'
                    ,'paixu'  => 1
                    ,'p_id' => 803
                ],
                ['id' => 80302
                    ,'title' => '保存'
                    ,'name' => 'rongyu/JsRongyuInfo/save'
                    ,'paixu'  => 2
                    ,'p_id' => 803
                ],
                ['id' => 80303
                    ,'title' => '删除'
                    ,'name' => 'rongyu/JsRongyuInfo/delete'
                    ,'paixu' => 3
                    ,'p_id' => 803
                ],
                ['id' => 80304
                    ,'title' => '编辑'
                    ,'name' => 'rongyu/JsRongyuInfo/edit'
                    ,'paixu' => 4
                    ,'p_id' => 803
                ],
                ['id' => 80305
                    ,'title' => '更新'
                    ,'name' => 'rongyu/JsRongyuInfo/update'
                    ,'paixu'  => 5
                    ,'p_id' => 803
                ],
                ['id' => 80306
                    ,'title' => '查看'
                    ,'name' => 'rongyu/JsRongyuInfo/read'
                    ,'paixu' => 6
                    ,'p_id' => 803
                ],
                ['id' => 80307
                    ,'title' => '状态'
                    ,'name' => 'rongyu/JsRongyuInfo/setStatus'
                    ,'paixu' => 7
                    ,'p_id' => 803
                ],
                ['id' => 80308
                    ,'title' => '批量上传'
                    ,'name' => 'rongyu/JsRongyuInfo/createAll'
                    ,'paixu' => 8
                    ,'p_id' => 803
                ],
                ['id' => 80309
                    ,'title' => '批量保存'
                    ,'name' => 'rongyu/JsRongyuInfo/saveAll'
                    ,'paixu' => 9
                    ,'p_id' => 803
                ],



            /*======================================================================
             * 考试管理
             */
            ['id' => 9
                ,'title' => '课题管理'
                ,'name'  => 'keti'
                ,'paixu'  => 7
                ,'ismenu'  => 1
                ,'font'  => '&#xe6b3;'
                ,'status' => 0
            ],
            /*====================================*/
            ['id' => 901
                ,'title' => '课题册'
                ,'name' => 'keti/Ketice/index'
                ,'paixu' => 1
                ,'ismenu'  => 1
                ,'p_id'  => 9
                ,'url' => '/keti/ketice'
            ],
                ['id' => 90101
                    ,'title' => '添加'
                    ,'name' => 'keti/Ketice/create'
                    ,'paixu'  => 1
                    ,'p_id' => 901
                ],
                ['id' => 90102
                    ,'title' => '保存'
                    ,'name' => 'keti/Ketice/save'
                    ,'paixu'  => 2
                    ,'p_id' => 901
                ],
                ['id' => 90103
                    ,'title' => '删除'
                    ,'name' => 'keti/Ketice/delete'
                    ,'paixu' => 3
                    ,'p_id' => 901
                ],
                ['id' => 90104
                    ,'title' => '编辑'
                    ,'name' => 'keti/Ketice/edit'
                    ,'paixu' => 4
                    ,'p_id' => 901
                ],
                ['id' => 90105
                    ,'title' => '更新'
                    ,'name' => 'keti/Ketice/update'
                    ,'paixu'  => 5
                    ,'p_id' => 901
                ],
                ['id' => 90106
                    ,'title' => '查看'
                    ,'name' => 'keti/Ketice/read'
                    ,'paixu' => 6
                    ,'p_id' => 901
                ],
                ['id' => 90107
                    ,'title' => '状态'
                    ,'name' => 'keti/Ketice/setStatus'
                    ,'paixu' => 7
                    ,'p_id' => 901
                ],
                ['id' => 90108
                    ,'title' => '查看课题信息'
                    ,'name' => 'keti/ketiinfo/ketiList'
                    ,'paixu' => 8
                    ,'p_id' => 901
                ],
            ['id' => 902
                ,'title' => '课题列表'
                ,'name' => 'keti/KetiInfo/index'
                ,'paixu' => 2
                ,'ismenu'  => 1
                ,'p_id'  => 9
                ,'url' => '/keti/ketiinfo'
            ],
                // 课题信息
                ['id' => 90201
                    ,'title' => '添加'
                    ,'name' => 'keti/ketiinfo/create'
                    ,'paixu'  => 1
                    ,'p_id' => 902
                ],
                ['id' => 90202
                    ,'title' => '保存'
                    ,'name' => 'keti/ketiinfo/save'
                    ,'paixu'  => 2
                    ,'p_id' => 902
                ],
                ['id' => 90203
                    ,'title' => '删除'
                    ,'name' => 'keti/ketiinfo/delete'
                    ,'paixu' => 3
                    ,'p_id' => 902
                ],
                ['id' => 90204
                    ,'title' => '编辑'
                    ,'name' => 'keti/ketiinfo/edit'
                    ,'paixu' => 4
                    ,'p_id' => 902
                ],
                ['id' => 90205
                    ,'title' => '更新'
                    ,'name' => 'keti/ketiinfo/update'
                    ,'paixu'  => 5
                    ,'p_id' => 902
                ],
                ['id' => 90206
                    ,'title' => '查看'
                    ,'name' => 'keti/ketiinfo/read'
                    ,'paixu' => 6
                    ,'p_id' => 902
                ],
                ['id' => 90207
                    ,'title' => '状态'
                    ,'name' => 'keti/ketiinfo/setStatus'
                    ,'paixu' => 7
                    ,'p_id' => 902
                ],
                ['id' => 90208
                    ,'title' => '批量上传'
                    ,'name' => 'keti/ketiinfo/createAll'
                    ,'paixu' => 8
                    ,'p_id' => 902
                ],
                ['id' => 90209
                    ,'title' => '批量保存'
                    ,'name' => 'keti/ketiinfo/saveAll'
                    ,'paixu' => 9
                    ,'p_id' => 902
                ],
                ['id' => 90210
                    ,'title' => '结题编辑'
                    ,'name' => 'keti/ketiinfo/jieTi'
                    ,'paixu' => 10
                    ,'p_id' => 902
                ],
                ['id' => 90211
                    ,'title' => '结题更新'
                    ,'name' => 'keti/ketiinfo/jtUpdate'
                    ,'paixu' => 11
                    ,'p_id' => 902
                ],
                ['id' => 90212
                    ,'title' => '下载'
                    ,'name' => 'keti/KetiInfo/outXlsx'
                    ,'paixu' => 12
                    ,'p_id' => 902
                ],

        ];
        // 保存数据
        $this->table('auth_rule')->insert($rows)->save();
    }
}
