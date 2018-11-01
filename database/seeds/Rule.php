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
            ['id'=>1,'title'=>'系统管理','name' =>'system','paixu' =>5,'ismenu'=>true,'font' =>'Hui-iconfont-system'],
            ['id'=>2,'title' =>'管理员管理','name'=>'admin','paixu' =>4,'ismenu' =>true,'font'=>'Hui-iconfont-root'],
            ['id'=>3,'title' =>'教务管理','name'=>'teach','paixu' =>3,'ismenu' =>true,'font'=>'Hui-iconfont-yuyin2'],
                // 二级菜单
                // 系统设置
                ['id'=>11,'title'=>'类别管理','name'=>'system/Category/index','paixu'=>1,'ismenu' =>true,'pid' =>1,'url'=>'/category',],
                ['id'=>12,'title'=>'单位管理','name'=>'system/School/index','paixu'=>2,'ismenu' =>true,'pid' =>1,'url'=>'/school',],
                ['id'=>13,'title'=>'系统设置','name'=>'system/SystemBase/index','paixu'=>3,'ismenu' =>true,'pid' =>1,'url'=>'/sysbase',],
                // 管理员管理
                ['id'=>21,'title'=>'管理员列表','name'=>'admin/Index/index','paixu'=>1,'ismenu' =>true,'pid' =>2,'url'=>'/admin',],
                ['id'=>22,'title'=>'权限列表','name'=>'admin/AuthRule/index','paixu'=>2,'ismenu' =>true,'pid' =>2,'url'=>'/authrule',],
                ['id'=>23,'title'=>'角色列表','name'=>'admin/AuthGroup/index','paixu'=>3,'ismenu' =>true,'pid' =>2,'url'=>'/authgroup',],
                // 教务管理
                ['id'=>31,'title'=>'考试列表','name'=>'teach/Kaoshi/index','paixu'=>1,'ismenu' =>true,'pid' =>3,'url'=>'/kaoshi',],
                ['id'=>32,'title'=>'教师列表','name'=>'teach/Index/index','paixu'=>2,'ismenu' =>true,'pid' =>3,'url'=>'/teacher',],
                ['id'=>33,'title'=>'学生列表','name'=>'teach/Studen/index','paixu'=>3,'ismenu' =>true,'pid' =>3,'url'=>'/teacher',],
                ['id'=>34,'title'=>'学期列表','name'=>'teach/Xueqi/index','paixu'=>4,'ismenu' =>true,'pid' =>3,'url'=>'/xueqi',],
                ['id'=>35,'title'=>'学科列表','name'=>'teach/Subject/index','paixu'=>5,'ismenu' =>true,'pid' =>3,'url'=>'/subject',],
                
                    
                    // 教务管理
                    // 考试管理权限
                    ['title'=>'添加','name'=>'teach/Kaoshi/create','paixu' =>1,'pid'=>31],
                    ['title'=>'删除','name'=>'teach/Kaoshi/delete','paixu'=>2,'pid'=>31],
                    ['title'=>'编辑','name'=>'teach/Kaoshi/edit','paixu'=>3,'pid'=>31,],
                    ['title'=>'查看','name'=>'teach/Kaoshi/read','paixu'=>4,'pid'=>31,],
                    ['title'=>'状态','name'=>'teach/Kaoshi/status','paixu'=>5,'pid'=>31],
                    // 教师管理权限
                    ['title'=>'添加','name'=>'teach/Index/create','paixu' =>1,'pid'=>32],
                    ['title'=>'删除','name'=>'teach/Index/delete','paixu'=>2,'pid'=>32],
                    ['title'=>'编辑','name'=>'teach/Index/edit','paixu'=>3,'pid'=>32,],
                    ['title'=>'查看','name'=>'teach/Index/read','paixu'=>4,'pid'=>32,],
                    ['title'=>'状态','name'=>'teach/Index/status','paixu'=>5,'pid'=>32],
                    // 学生管理权限
                    ['title'=>'添加','name'=>'teach/Student/create','paixu' =>1,'pid'=>33],
                    ['title'=>'删除','name'=>'teach/Student/delete','paixu'=>2,'pid'=>33],
                    ['title'=>'编辑','name'=>'teach/Student/edit','paixu'=>3,'pid'=>33,],
                    ['title'=>'查看','name'=>'teach/Student/read','paixu'=>4,'pid'=>33,],
                    ['title'=>'状态','name'=>'teach/Student/status','paixu'=>5,'pid'=>33],
                    // 学期管理权限
                    ['title'=>'添加','name'=>'teach/Xueqi/create','paixu' =>1,'pid'=>34],
                    ['title'=>'删除','name'=>'teach/Xueqi/delete','paixu'=>2,'pid'=>34],
                    ['title'=>'编辑','name'=>'teach/Xueqi/edit','paixu'=>3,'pid'=>34,],
                    ['title'=>'查看','name'=>'teach/Xueqi/read','paixu'=>4,'pid'=>34,],
                    ['title'=>'状态','name'=>'teach/Xueqi/status','paixu'=>5,'pid'=>34],
                    // 学科列表权限
                    ['title'=>'添加','name'=>'admin/Subject/create','paixu' =>1,'pid'=>35],
                    ['title'=>'删除','name'=>'admin/Subject/delete','paixu'=>2,'pid'=>35],
                    ['title'=>'编辑','name'=>'admin/Subject/edit','paixu'=>3,'pid'=>35,],
                    ['title'=>'查看','name'=>'admin/Subject/read','paixu'=>4,'pid'=>35,],
                    ['title'=>'状态','name'=>'admin/Subject/status','paixu'=>5,'pid'=>35],


                    // 系统设置
                    // 类别管理权限
                    ['title'=>'添加','name'=>'system/Category/create','paixu' =>1,'pid'=>11],
                    ['title'=>'删除','name'=>'system/Category/delete','paixu'=>2,'pid'=>11],
                    ['title'=>'编辑','name'=>'system/Category/edit','paixu'=>3,'pid'=>11,],
                    ['title'=>'查看','name'=>'system/Category/read','paixu'=>4,'pid'=>11,],
                    ['title'=>'状态','name'=>'system/Category/status','paixu'=>5,'pid'=>11],
                    // 单位管理权限
                    ['title'=>'添加','name'=>'system/School/create','paixu' =>1,'pid'=>12],
                    ['title'=>'删除','name'=>'system/School/delete','paixu'=>2,'pid'=>12],
                    ['title'=>'编辑','name'=>'system/School/edit','paixu'=>3,'pid'=>12,],
                    ['title'=>'查看','name'=>'system/School/read','paixu'=>4,'pid'=>12,],
                    ['title'=>'状态','name'=>'system/School/status','paixu'=>5,'pid'=>12],
                    // 系统设置权限
                    ['title'=>'编辑','name'=>'system/SystemBase/edit','paixu'=>1,'pid'=>13,],
                    

                    //管理员管理
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