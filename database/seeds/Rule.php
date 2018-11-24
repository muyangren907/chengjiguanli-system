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
            ['id'=>1,'title' =>'成绩采集','name'=>'chengji','paixu' =>1,'ismenu' =>true,'font'=>'Hui-iconfont-yuedu'],
            ['id'=>2,'title' =>'成绩统计','name'=>'tongji','paixu' =>2,'ismenu' =>true,'font'=>'Hui-iconfont-shujutongji'],
            ['id'=>3,'title' =>'考试管理','name'=>'kaoshi','paixu' =>3,'ismenu' =>true,'font'=>'Hui-iconfont-canshu'],
            ['id'=>4,'title' =>'师生名单','name'=>'renshi','paixu' =>4,'ismenu' =>true,'font'=>'Hui-iconfont-user-group'],
            ['id'=>5,'title' =>'教务管理','name'=>'teach','paixu' =>5,'ismenu' =>true,'font'=>'Hui-iconfont-yuyin2'],
            ['id'=>6,'title' =>'管理员管理','name'=>'admin','paixu' =>6,'ismenu' =>true,'font'=>'Hui-iconfont-root'],
            ['id'=>7,'title'=>'系统管理','name' =>'system','paixu' =>7,'ismenu'=>true,'font' =>'Hui-iconfont-system'],
                // 二级菜单
                // 成绩采集
                ['id'=>101,'title'=>'扫码录入','name'=>'chengji/Index/malu','paixu'=>1,'ismenu' =>true,'pid' =>1,'url'=>'/chengji/malu',],
                ['id'=>102,'title'=>'表格录入','name'=>'chengji/Index/biaolu','paixu'=>2,'ismenu' =>true,'pid' =>1,'url'=>'/chengji/biaolu',],
                // 成绩统计
                ['id'=>201,'title'=>'班级成绩','name'=>'tongji/Index/banji','paixu'=>1,'ismenu' =>true,'pid' =>2,'url'=>'/tongji',],
                // 考试管理
                ['id'=>301,'title'=>'考试列表','name'=>'teach/Kaoshi/index','paixu'=>1,'ismenu' =>true,'pid' =>3,'url'=>'/kaoshi',],

                // 师生名单
                ['id'=>401,'title'=>'学生列表','name'=>'renshi/Student/index','paixu'=>1,'ismenu' =>true,'pid' =>4,'url'=>'/student',],
                ['id'=>402,'title'=>'教师列表','name'=>'renshi/Index/index','paixu'=>2,'ismenu' =>true,'pid' =>4,'url'=>'/teacher',],

                // 教务管理
                ['id'=>501,'title'=>'学期列表','name'=>'teach/Xueqi/index','paixu'=>1,'ismenu' =>true,'pid' =>5,'url'=>'/xueqi',],
                ['id'=>502,'title'=>'班级列表','name'=>'teach/Banji/index','paixu'=>2,'ismenu' =>true,'pid' =>5,'url'=>'/banji',],
                ['id'=>503,'title'=>'学科列表','name'=>'teach/Subject/index','paixu'=>3,'ismenu' =>true,'pid' =>5,'url'=>'/subject',],
                

                // 管理员管理
                ['id'=>601,'title'=>'管理员列表','name'=>'admin/Index/index','paixu'=>1,'ismenu' =>true,'pid' =>6,'url'=>'/admin',],
                ['id'=>602,'title'=>'权限列表','name'=>'admin/AuthRule/index','paixu'=>2,'ismenu' =>true,'pid' =>6,'url'=>'/authrule',],
                ['id'=>603,'title'=>'角色列表','name'=>'admin/AuthGroup/index','paixu'=>3,'ismenu' =>true,'pid' =>6,'url'=>'/authgroup',],
                
                // 系统设置
                ['id'=>701,'title'=>'类别管理','name'=>'system/Category/index','paixu'=>1,'ismenu' =>true,'pid' =>7,'url'=>'/category',],
                ['id'=>702,'title'=>'单位管理','name'=>'system/School/index','paixu'=>2,'ismenu' =>true,'pid' =>7,'url'=>'/school',],
                ['id'=>703,'title'=>'系统设置','name'=>'system/SystemBase/index','paixu'=>3,'ismenu' =>true,'pid' =>7,'url'=>'/sysbase',],
                
                
                
                
                    
                    // 三级-权限
                    
                    // 考试管理
                    ['title'=>'添加','name'=>'teach/Kaoshi/create','paixu' =>1,'pid'=>301,'id'=>1000000],
                    ['title'=>'删除','name'=>'teach/Kaoshi/delete','paixu'=>2,'pid'=>301],
                    ['title'=>'编辑','name'=>'teach/Kaoshi/edit','paixu'=>3,'pid'=>301,],
                    ['title'=>'查看','name'=>'teach/Kaoshi/read','paixu'=>4,'pid'=>301,],
                    ['title'=>'状态','name'=>'teach/Kaoshi/status','paixu'=>5,'pid'=>301],
                    ['title'=>'生成考号','name'=>'teach/Kaoshi/kaohao','paixu'=>6,'pid'=>301],

                    // 师生管理
                    // 学生管理权限
                    ['title'=>'添加','name'=>'renshi/Student/create','paixu' =>1,'pid'=>401],
                    ['title'=>'删除','name'=>'renshi/Student/delete','paixu'=>2,'pid'=>401],
                    ['title'=>'编辑','name'=>'renshi/Student/edit','paixu'=>3,'pid'=>401,],
                    ['title'=>'查看','name'=>'renshi/Student/read','paixu'=>4,'pid'=>401,],
                    ['title'=>'状态','name'=>'renshi/Student/status','paixu'=>5,'pid'=>401],
                    ['title'=>'批传','name'=>'renshi/Student/createAll','paixu'=>'6','pid'=>401],
                    // 教师管理权限
                    ['title'=>'添加','name'=>'renshi/Index/create','paixu' =>1,'pid'=>402],
                    ['title'=>'删除','name'=>'renshi/Index/delete','paixu'=>2,'pid'=>402],
                    ['title'=>'编辑','name'=>'renshi/Index/edit','paixu'=>3,'pid'=>402,],
                    ['title'=>'查看','name'=>'renshi/Index/read','paixu'=>4,'pid'=>402,],
                    ['title'=>'状态','name'=>'renshi/Index/status','paixu'=>5,'pid'=>402],
                    ['title'=>'批传','name'=>'renshi/Index/createAll','paixu'=>6,'pid'=>402],
                    

                    // 教务管理
                    // 学期管理权限
                    ['title'=>'添加','name'=>'teach/Xueqi/create','paixu' =>1,'pid'=>501],
                    ['title'=>'删除','name'=>'teach/Xueqi/delete','paixu'=>2,'pid'=>501],
                    ['title'=>'编辑','name'=>'teach/Xueqi/edit','paixu'=>3,'pid'=>501,],
                    ['title'=>'查看','name'=>'teach/Xueqi/read','paixu'=>4,'pid'=>501,],
                    ['title'=>'状态','name'=>'teach/Xueqi/status','paixu'=>5,'pid'=>501],
                                        // 班级列表权限
                    ['title'=>'添加','name'=>'admin/Banji/create','paixu' =>1,'pid'=>502],
                    ['title'=>'移动','name'=>'admin/Banji/yidong','paixu'=>2,'pid'=>502],
                    ['title'=>'状态','name'=>'admin/Banji/status','paixu'=>3,'pid'=>502],
                    // 学科列表权限
                    ['title'=>'添加','name'=>'admin/Subject/create','paixu' =>1,'pid'=>503],
                    ['title'=>'删除','name'=>'admin/Subject/delete','paixu'=>2,'pid'=>503],
                    ['title'=>'编辑','name'=>'admin/Subject/edit','paixu'=>3,'pid'=>503,],
                    ['title'=>'查看','name'=>'admin/Subject/read','paixu'=>4,'pid'=>503,],
                    ['title'=>'状态','name'=>'admin/Subject/status','paixu'=>5,'pid'=>503],


                    //管理员管理
                    // 管理员列表权限
                    ['title'=>'添加','name'=>'admin/Index/create','paixu' =>1,'pid'=>601],
                    ['title'=>'删除','name'=>'admin/Index/delete','paixu'=>2,'pid'=>601],
                    ['title'=>'编辑','name'=>'admin/Index/edit','paixu'=>3,'pid'=>601,],
                    ['title'=>'查看','name'=>'admin/Index/read','paixu'=>4,'pid'=>601,],
                    ['title'=>'状态','name'=>'admin/Index/status','paixu'=>5,'pid'=>601],
                    ['title'=>'重置密码','name'=>'admin/Index/resetpassword','paixu' =>6,'pid'=>601],
                    // 权限列表权限
                    ['title'=>'添加','name'=>'admin/AuthRule/create','paixu' =>1,'pid'=>602],
                    ['title'=>'删除','name'=>'admin/AuthRule/delete','paixu'=>2,'pid'=>602],
                    ['title'=>'编辑','name'=>'admin/AuthRule/edit','paixu'=>3,'pid'=>602,],
                    ['title'=>'查看','name'=>'admin/AuthRule/read','paixu'=>4,'pid'=>602,],
                    ['title'=>'状态','name'=>'admin/AuthRule/status','paixu'=>5,'pid'=>602],
                    // 角色列表权限
                    ['title'=>'添加','name'=>'admin/AuthGroup/create','paixu' =>1,'pid'=>603],
                    ['title'=>'删除','name'=>'admin/AuthGroup/delete','paixu'=>2,'pid'=>603],
                    ['title'=>'编辑','name'=>'admin/AuthGroup/edit','paixu'=>3,'pid'=>603,],
                    ['title'=>'查看','name'=>'admin/AuthGroup/read','paixu'=>4,'pid'=>603,],
                    ['title'=>'状态','name'=>'admin/AuthGroup/status','paixu'=>5,'pid'=>603],

                    // 系统设置
                    // 类别管理权限
                    ['title'=>'添加','name'=>'system/Category/create','paixu' =>1,'pid'=>701],
                    ['title'=>'删除','name'=>'system/Category/delete','paixu'=>2,'pid'=>701],
                    ['title'=>'编辑','name'=>'system/Category/edit','paixu'=>3,'pid'=>701,],
                    ['title'=>'查看','name'=>'system/Category/read','paixu'=>4,'pid'=>701,],
                    ['title'=>'状态','name'=>'system/Category/status','paixu'=>5,'pid'=>701],
                    // 单位管理权限
                    ['title'=>'添加','name'=>'system/School/create','paixu' =>1,'pid'=>702],
                    ['title'=>'删除','name'=>'system/School/delete','paixu'=>2,'pid'=>702],
                    ['title'=>'编辑','name'=>'system/School/edit','paixu'=>3,'pid'=>702,],
                    ['title'=>'查看','name'=>'system/School/read','paixu'=>4,'pid'=>702,],
                    ['title'=>'状态','name'=>'system/School/status','paixu'=>5,'pid'=>702],
                    // 系统设置权限
                    ['title'=>'编辑','name'=>'system/SystemBase/edit','paixu'=>1,'pid'=>703,],
            
        ];
        // 保存数据
        $this->table('auth_rule')->insert($rows)->save();
    }
}