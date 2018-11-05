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
             ['id'=>4,'title' =>'师生名单','name'=>'renshi','paixu' =>2,'ismenu' =>true,'font'=>'Hui-iconfont-user-group'],
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
                ['id'=>32,'title'=>'学期列表','name'=>'teach/Xueqi/index','paixu'=>2,'ismenu' =>true,'pid' =>3,'url'=>'/xueqi',],
                ['id'=>33,'title'=>'学科列表','name'=>'teach/Subject/index','paixu'=>3,'ismenu' =>true,'pid' =>3,'url'=>'/subject',],
                ['id'=>34,'title'=>'班级列表','name'=>'teach/Banji/index','paixu'=>4,'ismenu' =>true,'pid' =>3,'url'=>'/banji',],
                // 人事管理
                ['id'=>41,'title'=>'教师列表','name'=>'renshi/Index/index','paixu'=>1,'ismenu' =>true,'pid' =>4,'url'=>'/teacher',],
                ['id'=>42,'title'=>'学生列表','name'=>'renshi/Student/index','paixu'=>2,'ismenu' =>true,'pid' =>4,'url'=>'/student',],
                
                    
                    // 教务管理
                    // 考试管理权限
                    ['title'=>'添加','name'=>'teach/Kaoshi/create','paixu' =>1,'pid'=>31],
                    ['title'=>'删除','name'=>'teach/Kaoshi/delete','paixu'=>2,'pid'=>31],
                    ['title'=>'编辑','name'=>'teach/Kaoshi/edit','paixu'=>3,'pid'=>31,],
                    ['title'=>'查看','name'=>'teach/Kaoshi/read','paixu'=>4,'pid'=>31,],
                    ['title'=>'状态','name'=>'teach/Kaoshi/status','paixu'=>5,'pid'=>31],
                    // 学期管理权限
                    ['title'=>'添加','name'=>'teach/Xueqi/create','paixu' =>1,'pid'=>32],
                    ['title'=>'删除','name'=>'teach/Xueqi/delete','paixu'=>2,'pid'=>32],
                    ['title'=>'编辑','name'=>'teach/Xueqi/edit','paixu'=>3,'pid'=>32,],
                    ['title'=>'查看','name'=>'teach/Xueqi/read','paixu'=>4,'pid'=>32,],
                    ['title'=>'状态','name'=>'teach/Xueqi/status','paixu'=>5,'pid'=>32],
                    // 学科列表权限
                    ['title'=>'添加','name'=>'admin/Subject/create','paixu' =>1,'pid'=>33],
                    ['title'=>'删除','name'=>'admin/Subject/delete','paixu'=>2,'pid'=>33],
                    ['title'=>'编辑','name'=>'admin/Subject/edit','paixu'=>3,'pid'=>33,],
                    ['title'=>'查看','name'=>'admin/Subject/read','paixu'=>4,'pid'=>33,],
                    ['title'=>'状态','name'=>'admin/Subject/status','paixu'=>5,'pid'=>33],
                    // 班级列表权限
                    ['title'=>'添加','name'=>'admin/Banji/create','paixu' =>1,'pid'=>34],
                    ['title'=>'移动','name'=>'admin/Banji/yidong','paixu'=>2,'pid'=>34],
                    ['title'=>'状态','name'=>'admin/Banji/status','paixu'=>3,'pid'=>34],
                    // ['title'=>'删除','name'=>'admin/Banji/delete','paixu'=>2,'pid'=>34],
                    // ['title'=>'编辑','name'=>'admin/Banji/edit','paixu'=>3,'pid'=>34,],
                    // ['title'=>'查看','name'=>'admin/Banji/read','paixu'=>4,'pid'=>34,],
                    // ['title'=>'状态','name'=>'admin/Banji/status','paixu'=>5,'pid'=>34],


                    // 人事管理
                    // 教师管理权限
                    ['title'=>'添加','name'=>'renshi/Index/create','paixu' =>1,'pid'=>41],
                    ['title'=>'删除','name'=>'renshi/Index/delete','paixu'=>2,'pid'=>41],
                    ['title'=>'编辑','name'=>'renshi/Index/edit','paixu'=>3,'pid'=>41,],
                    ['title'=>'查看','name'=>'renshi/Index/read','paixu'=>4,'pid'=>41,],
                    ['title'=>'状态','name'=>'renshi/Index/status','paixu'=>5,'pid'=>41],
                    ['title'=>'批传','name'=>'renshi/Index/createAll','paixu'=>6,'pid'=>41],

                    // 学生管理权限
                    ['title'=>'添加','name'=>'renshi/Student/create','paixu' =>1,'pid'=>42],
                    ['title'=>'删除','name'=>'renshi/Student/delete','paixu'=>2,'pid'=>42],
                    ['title'=>'编辑','name'=>'renshi/Student/edit','paixu'=>3,'pid'=>42,],
                    ['title'=>'查看','name'=>'renshi/Student/read','paixu'=>4,'pid'=>42,],
                    ['title'=>'状态','name'=>'renshi/Student/status','paixu'=>5,'pid'=>42],
                    ['title'=>'批传','name'=>'renshi/Student/createAll','paixu'=>'6','pid'=>42],


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