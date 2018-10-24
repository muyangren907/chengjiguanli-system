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
            ['id'=>2,'title' =>'管理员管理','name'=>'admin','paixu' =>4,'ismenu' =>true,'font'=>'.Hui-iconfont-root'],
                // 二级菜单
                // 系统设置
                ['id'=>11,'title'=>'系统设置','name'=>'system/SystemBase/index','paixu'=>1,'ismenu' =>true,'pid' =>1,'url'=>'/sysbase',],
                // 管理员管理
                ['id'=>21,'title'=>'管理员列表','name'=>'admin/Index/index','paixu'=>1,'ismenu' =>true,'pid' =>2,'url'=>'/admin',],
                ['id'=>22,'title'=>'权限列表','name'=>'admin/AuthRule/index','paixu'=>2,'ismenu' =>true,'pid' =>2,'url'=>'/authrule',],
                ['id'=>23,'title'=>'角色列表','name'=>'admin/AuthGroup/index','paixu'=>3,'ismenu' =>true,'pid' =>2,'url'=>'/authgroup',],
                    // 管理员列表权限
                    ['title'=>'添加','name'=>'admin/Index/create','paixu' =>1,'pid'=>21],
                    ['title'=>'删除','name'=>'admin/Index/delete','paixu'=>2,'pid'=>21],
                    ['title'=>'编辑','name'=>'admin/Index/edit','paixu'=>3,'pid'=>21,],
                    ['title'=>'查看','name'=>'admin/Index/read','paixu'=>4,'pid'=>21,],
                    ['title'=>'状态','name'=>'admin/Index/status','paixu'=>5,'pid'=>21],
                    ['title'=>'重置密码','name'=>'admin/Index/resetpassword','paixu' =>6,'pid'=>21],
                    // 权限列表权限
                    ['title'=>'添加','name'=>'admin/AuthRule/create','paixu' =>1,'pid'=>22],
                    ['title'=>'删除','name'=>'admin/AuthRule/delete','paixu'=>2,'pid'=>22],
                    ['title'=>'编辑','name'=>'admin/AuthRule/edit','paixu'=>3,'pid'=>22,],
                    ['title'=>'查看','name'=>'admin/AuthRule/read','paixu'=>4,'pid'=>22,],
                    ['title'=>'状态','name'=>'admin/AuthRule/status','paixu'=>5,'pid'=>22],
                    // 角色列表权限
                    ['title'=>'添加','name'=>'admin/AuthGroup/create','paixu' =>1,'pid'=>23],
                    ['title'=>'删除','name'=>'admin/AuthGroup/delete','paixu'=>2,'pid'=>23],
                    ['title'=>'编辑','name'=>'admin/AuthGroup/edit','paixu'=>3,'pid'=>23,],
                    ['title'=>'查看','name'=>'admin/AuthGroup/read','paixu'=>4,'pid'=>23,],
                    ['title'=>'状态','name'=>'admin/AuthGroup/status','paixu'=>5,'pid'=>23],
               
            
        ];
        // 保存数据
        $this->table('auth_rule')->insert($rows)->save();
    }
}