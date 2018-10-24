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
        // 初始化超级管理员
        $rows= [
            [
                'id'        =>  1,
                'title'     =>  '系统管理',
                'name'      =>  'admin',
                'paixu'     =>  1,
                'ismenu'    =>  true,
                'font'      =>  '.Hui-iconfont-system',
                'pid'       =>  0,
                'url'       =>  '',
            ],
                [
                    'id'        =>  2,
                    'title'     =>  '管理员列表',
                    'name'      =>  '/admin',
                    'paixu'     =>  1,
                    'ismenu'    =>  true,
                    'font'      =>  '',
                    'pid'       =>  0,
                    'url'       =>  '/admin',
                ],
                    [
                        'id'        =>  3,
                        'title'     =>  '添加',
                        'name'      =>  'admin/index/create',
                        'paixu'     =>  1,
                        'ismenu'    =>  false,
                        'font'      =>  '',
                        'pid'       =>  2,
                        'url'       =>  '',
                    ],
                    [
                        'id'        =>  4,
                        'title'     =>  '删除',
                        'name'      =>  'admin/index/delete',
                        'paixu'     =>  5,
                        'ismenu'    =>  false,
                        'font'      =>  '',
                        'pid'       =>  2,
                        'url'       =>  '',
                    ],
                    [
                        'id'        =>  5,
                        'title'     =>  '编辑',
                        'name'      =>  'admin/index/edit',
                        'paixu'     =>  3,
                        'ismenu'    =>  false,
                        'font'      =>  '',
                        'pid'       =>  2,
                        'url'       =>  '',
                    ],
                    [
                        'id'        =>  6,
                        'title'     =>  '查看',
                        'name'      =>  'admin/index/read',
                        'paixu'     =>  4,
                        'ismenu'    =>  false,
                        'font'      =>  '',
                        'pid'       =>  2,
                        'url'       =>  '',
                    ],
            
        ];
        // 保存数据
        $this->table('auth_rule')->insert($rows)->save();
    }
}