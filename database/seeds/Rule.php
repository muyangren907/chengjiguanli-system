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
            // 一级菜单 1
            ['id'=>1,'title'=>'系统管理','name' =>'system','paixu' =>5,'ismenu'=>true,'font' =>'ui-iconfont-system'],
            // 一级菜单 2
            ['id'=>2,'title' =>'管理员管理','name'=>'admin','paixu' =>4,'ismenu' =>true,'font'=>'.Hui-iconfont-root'],
                // 二级菜单 3
                ['id'=>3,'title'=>'管理员列表','name'=>'admin','paixu'=>1,'ismenu' =>true,'font'=>'','pid' =>2,'url'=>'/admin',],
                ['id'=>4,'title'=>'权限列表','name'=>'admin','paixu'=>1,'ismenu' =>true,'font'=>'','pid' =>2,'url'=>'/admin',],
                ['id'=>5,'title'=>'角色列表','name'=>'admin','paixu'=>1,'ismenu' =>true,'font'=>'','pid' =>2,'url'=>'/admin',],
                    // 权限
                    ['id'=>4,'title'=>'添加','name'=>'admin/Index/create','paixu' =>1,'ismenu'=>false,'font'=>'','pid'=>3,'url'=>''],
                    ['id'=>5,'title'=>'删除','name'=>'admin/Index/delete','paixu'=>5,'ismenu'=>false,'font'=>'','pid'=>3,'url'=>''],
                    ['id'=>6,'title'=>'编辑','name'=>'admin/Index/edit','paixu'=>3,'ismenu'=>false,'font'=>'','pid'=>3,'url'=>'',],
                    ['id' =>7,'title'=>'查看','name'=>'admin/Index/read','paixu'=>4,'ismenu'=>false,'font'=>'','pid'=>3,'url'=>'',],
                
            
        ];
        // 保存数据
        $this->table('auth_rule')->insert($rows)->save();
    }
}