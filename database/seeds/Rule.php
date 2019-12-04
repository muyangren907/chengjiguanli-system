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
            ['id'=>1,'title' =>'成绩采集','name'=>'chengji','paixu' =>1,'ismenu' =>1,'font'=>'&#xe6c9;'],
            ['id'=>3,'title' =>'考试管理','name'=>'kaoshi','paixu' =>3,'ismenu' =>1,'font'=>'&#xe6ee;'],
            ['id'=>4,'title' =>'师生名单','name'=>'renshi','paixu' =>4,'ismenu' =>1,'font'=>'&#xe699;'],
            ['id'=>5,'title' =>'教务管理','name'=>'teach','paixu' =>5,'ismenu' =>1,'font'=>'&#xe6da;'],
            ['id'=>6,'title' =>'管理员管理','name'=>'admin','paixu' =>8,'ismenu' =>1,'font'=>'&#xe6b8;'],
            ['id'=>7,'title'=>'系统管理','name' =>'system','paixu' =>9,'ismenu' =>1,'font' =>'&#xe6ae;'],
            ['id'=>8,'title'=>'荣誉管理','name' =>'rongyu','paixu' =>6,'ismenu' =>1,'font' =>'&#xe6e4;','status'=>0],
            ['id'=>9,'title'=>'课题管理','name' =>'keti','paixu' =>7,'ismenu' =>1,'font' =>'&#xe6b3;','status'=>0],
                // 二级菜单
                // 成绩采集
                ['id'=>101,'title'=>'扫码录入','name'=>'chengji/index/malu','paixu'=>1,'ismenu' =>1,'pid' =>1,'url'=>'/chengji/malu',],
                ['id'=>102,'title'=>'表格录入','name'=>'chengji/index/biaolu','paixu'=>2,'ismenu' =>1,'pid' =>1,'url'=>'/chengji/biaolu',],
                // 成绩统计
                ['id'=>201,'title'=>'班级成绩','name'=>'tongji/index/banji','paixu'=>1,'ismenu' =>1,'pid' =>2,'url'=>'/tongji',],
                // 考试管理
                ['id'=>301,'title'=>'考试列表','name'=>'kaoshi/index/index','paixu'=>1,'ismenu' =>1,'pid' =>3,'url'=>'/kaoshi',],
                ['id'=>302,'title'=>'考试操作','name'=>'Kaoshi/index/moreaction','paixu'=>2,'ismenu' =>0,'pid' =>3],

                // 师生名单
                ['id'=>401,'title'=>'学生列表','name'=>'renshi/student/index','paixu'=>1,'ismenu' =>1,'pid' =>4,'url'=>'/student',],
                ['id'=>402,'title'=>'教师列表','name'=>'renshi/index/index','paixu'=>2,'ismenu' =>1,'pid' =>4,'url'=>'/teacher',],

                // 教务管理
                ['id'=>501,'title'=>'学期列表','name'=>'teach/xueqi/index','paixu'=>1,'ismenu' =>1,'pid' =>5,'url'=>'/xueqi',],
                ['id'=>502,'title'=>'班级列表','name'=>'teach/banji/index','paixu'=>2,'ismenu' =>1,'pid' =>5,'url'=>'/banji',],
                ['id'=>503,'title'=>'学科列表','name'=>'teach/subject/index','paixu'=>3,'ismenu' =>1,'pid' =>5,'url'=>'/subject',],
                

                // 管理员管理
                ['id'=>601,'title'=>'管理员列表','name'=>'admin/index/index','paixu'=>1,'ismenu' =>1,'pid' =>6,'url'=>'/admin',],
                ['id'=>602,'title'=>'权限列表','name'=>'admin/authRule/index','paixu'=>2,'ismenu' =>1,'pid' =>6,'url'=>'/authrule',],
                ['id'=>603,'title'=>'角色列表','name'=>'admin/authGroup/index','paixu'=>3,'ismenu' =>1,'pid' =>6,'url'=>'/authgroup',],
                
                // 系统设置
                ['id'=>701,'title'=>'类别管理','name'=>'system/category/index','paixu'=>1,'ismenu' =>1,'pid' =>7,'url'=>'/category',],
                ['id'=>702,'title'=>'单位管理','name'=>'system/school/index','paixu'=>2,'ismenu' =>1,'pid' =>7,'url'=>'/school',],
                ['id'=>703,'title'=>'文件管理','name'=>'system/fields/index','paixu'=>3,'ismenu' =>1,'pid' =>7,'url'=>'/fields',],
                ['id'=>704,'title'=>'系统设置','name'=>'system/systembase/edit','paixu'=>10,'ismenu' =>1,'pid' =>7,'url'=>'/sysbase/1/edit',],
                


                // 荣誉管理
                ['id'=>801,'title'=>'单位荣誉','name'=>'rongyu/dwrongyu/index','paixu'=>1,'ismenu' =>1,'pid' =>8,'url'=>'/dwry',],
                ['id'=>802,'title'=>'教师荣誉册','name'=>'rongyu/jsrongyu/index','paixu'=>2,'ismenu' =>1,'pid' =>8,'url'=>'/jsry',],
                ['id'=>803,'title'=>'教师荣誉信息','name'=>'rongyu/jsrongyuInfo/index','paixu'=>3,'ismenu' =>1,'pid' =>8,'url'=>'/jsryinfo',],
                // ['id'=>804,'title'=>'学生荣誉','name'=>'rongyu/StuRongyu/index','paixu'=>7,'ismenu' =>1,'pid' =>8,'url'=>'/xsry','status'=>0],

                // 荣誉管理
                ['id'=>901,'title'=>'课题册','name'=>'keti/index/index','paixu'=>1,'ismenu' =>1,'pid' =>9,'url'=>'/kt',],
                ['id'=>902,'title'=>'课题列表','name'=>'keti/ketiinfo/index','paixu'=>2,'ismenu' =>1,'pid' =>9,'url'=>'/ktinfo',],
                
                
                
                    
                    // 三级-权限


                    // 扫码录入
                    ['title'=>'扫码查询','name'=>'Chengji/index/read','paixu' =>1,'pid'=>101,'id'=>1000000],
                    ['title'=>'扫码保存','name'=>'Chengji/index/malusave','paixu' =>2,'pid'=>101],
                    // 表格录入
                    ['title'=>'表格保存','name'=>'Chengji/index/saveall','paixu' =>3,'pid'=>102],
                    ['title'=>'表格上传','name'=>'Chengji/index/upload','paixu' =>4,'pid'=>102],
                    ['title'=>'成绩更新','name'=>'Chengji/index/update','paixu' =>5,'pid'=>102],

                    
                    // 考试管理
                    ['title'=>'添加','name'=>'Kaoshi/index/create','paixu' =>1,'pid'=>301],
                    ['title'=>'删除','name'=>'Kaoshi/index/delete','paixu'=>2,'pid'=>301],
                    ['title'=>'编辑','name'=>'Kaoshi/index/edit','paixu'=>3,'pid'=>301,],
                    ['title'=>'更新','name'=>'Kaoshi/index/update','paixu'=>4,'pid'=>301,],
                    ['title'=>'保存','name'=>'Kaoshi/index/save','paixu'=>5,'pid'=>301,],
                    ['title'=>'状态','name'=>'Kaoshi/index/setstatus','paixu'=>6,'pid'=>301],
                    ['title'=>'设置','name'=>'Kaoshi/index/kaoshiset','paixu'=>7,'pid'=>301],
                    // 考试操作
                    ['title'=>'生成考号','name'=>'kaoshi/kaohao/index','paixu'=>1,'pid'=>302],
                    ['title'=>'已录成绩数量','name'=>'chengji/tongji/yilucnt','paixu'=>2,'pid'=>302],
                    ['title'=>'保存考号','name'=>'kaoshi/kaohao/save','paixu'=>3,'pid'=>302],
                    ['title'=>'考号删除','name'=>'kaoshi/kaohao/delete','paixu'=>4,'pid'=>302],
                    ['title'=>'下载试卷标签信息','name'=>'kaoshi/kaohao/biaoqian','paixu'=>5,'pid'=>302],
                    ['title'=>'下载成绩采集表','name'=>'kaoshi/kaohao/caiji','paixu'=>6,'pid'=>302],
                    ['title'=>'成绩列表','name'=>'chengji/index/index','paixu'=>7,'pid'=>302],
                        ['title'=>'录入人信息','name'=>'chengji/index/readadd','paixu'=>8,'pid'=>302],
                        ['title'=>'删除成绩','name'=>'chengji/index/delete','paixu'=>9,'pid'=>302],
                        ['title'=>'成绩状态','name'=>'chengji/index/setstatus','paixu'=>10,'pid'=>302],
                    // 学生成绩
                    ['title'=>'下载学生成绩','name'=>'chengji/index/dwchengji','paixu'=>21,'pid'=>302],
                    // 班级成绩
                    ['title'=>'班级成绩统计','name'=>'chengji/bjtongji/biaoge','paixu'=>41,'pid'=>302],
                    ['title'=>'下载班级成绩统计表','name'=>'chengji/bjtongji/dwbanji','paixu'=>42,'pid'=>302],
                    // 年级成绩
                    ['title'=>'年级成绩统计','name'=>'Chengji/njtongji/biaoge','paixu'=>61,'pid'=>302],
                    ['title'=>'下载年级成绩统计表','name'=>'chengji/njtongji/dwNianji','paixu'=>62,'pid'=>302],



                    // 师生管理
                    // 学生管理权限
                    ['title'=>'添加','name'=>'renshi/student/create','paixu' =>1,'pid'=>401],
                    ['title'=>'保存','name'=>'renshi/student/save','paixu'=>2,'pid'=>401,],
                    ['title'=>'删除','name'=>'renshi/student/delete','paixu'=>3,'pid'=>401],
                    ['title'=>'编辑','name'=>'renshi/student/edit','paixu'=>4,'pid'=>401,],
                    ['title'=>'更新','name'=>'renshi/student/update','paixu'=>5,'pid'=>401,],
                    ['title'=>'查看','name'=>'renshi/student/read','paixu'=>6,'pid'=>401,],
                    ['title'=>'状态','name'=>'renshi/student/setstatus','paixu'=>7,'pid'=>401],
                    ['title'=>'下载模板','name'=>'renshi/student/download','paixu'=>8,'pid'=>401],
                    ['title'=>'批量上传','name'=>'renshi/student/createall','paixu'=>9,'pid'=>401],
                    ['title'=>'批量保存','name'=>'renshi/student/saveall','paixu'=>10,'pid'=>401],
                    ['title'=>'校对','name'=>'renshi/student/jiaodui','paixu'=>11,'pid'=>401],
                    ['title'=>'校对删除','name'=>'renshi/student/jiaoduidel','paixu'=>12,'pid'=>401],

                    // 教师管理权限
                    ['title'=>'添加','name'=>'renshi/index/create','paixu' =>1,'pid'=>402],
                    ['title'=>'保存','name'=>'renshi/index/save','paixu' =>2,'pid'=>402],
                    ['title'=>'删除','name'=>'renshi/index/delete','paixu'=>3,'pid'=>402],
                    ['title'=>'编辑','name'=>'renshi/index/edit','paixu'=>7,'pid'=>402,],
                    ['title'=>'更新','name'=>'renshi/index/update','paixu' =>5,'pid'=>402],
                    ['title'=>'查看','name'=>'renshi/index/read','paixu'=>6,'pid'=>402,],
                    ['title'=>'状态','name'=>'renshi/index/setstatus','paixu'=>7,'pid'=>402],
                    ['title'=>'查询教师','name'=>'renshi/index/srcteacher','paixu'=>8,'pid'=>402],
                    ['title'=>'批量上传','name'=>'renshi/index/createall','paixu'=>9,'pid'=>402],
                    ['title'=>'批量保存','name'=>'renshi/index/saveall','paixu'=>10,'pid'=>402],
                    ['title'=>'表格模板下载','name'=>'renshi/index/download','paixu'=>11,'pid'=>402],
                    ['title'=>'姓名转换VBA下载','name'=>'renshi/index/downloadvba','paixu'=>12,'pid'=>402],


                    // 教务管理
                    // 学期管理权限
                    ['title'=>'添加','name'=>'teach/xueqi/create','paixu' =>1,'pid'=>501],
                    ['title'=>'保存','name'=>'teach/xueqi/save','paixu' =>2,'pid'=>501],
                    ['title'=>'删除','name'=>'teach/xueqi/delete','paixu'=>3,'pid'=>501],
                    ['title'=>'编辑','name'=>'teach/xueqi/edit','paixu'=>4,'pid'=>501,],
                    ['title'=>'更新','name'=>'teach/xueqi/update','paixu' =>5,'pid'=>501],
                    ['title'=>'查看','name'=>'teach/xueqi/read','paixu'=>6,'pid'=>501,],
                    ['title'=>'状态','name'=>'teach/xueqi/setstatus','paixu'=>7,'pid'=>501],
                    // 班级列表权限
                    ['title'=>'添加','name'=>'teach/banji/create','paixu' =>1,'pid'=>502],
                    ['title'=>'保存','name'=>'teach/banji/save','paixu' =>2,'pid'=>502],
                    ['title'=>'移动','name'=>'teach/banji/yidong','paixu'=>3,'pid'=>502],
                    ['title'=>'状态','name'=>'teach/banji/setStatus','paixu'=>4,'pid'=>502],
                    // 学科列表权限
                    ['title'=>'添加','name'=>'teach/subject/create','paixu' =>1,'pid'=>503],
                    ['title'=>'保存','name'=>'teach/subject/save','paixu' =>2,'pid'=>503],
                    ['title'=>'删除','name'=>'teach/subject/delete','paixu'=>3,'pid'=>503],
                    ['title'=>'编辑','name'=>'teach/subject/edit','paixu'=>4,'pid'=>503,],
                    ['title'=>'更新','name'=>'teach/subject/update','paixu' =>5,'pid'=>503],
                    ['title'=>'查看','name'=>'teach/subject/read','paixu'=>6,'pid'=>503,],
                    ['title'=>'状态','name'=>'teach/subject/setstatus','paixu'=>7,'pid'=>503],


                    //管理员管理
                    // 管理员列表权限
                    ['title'=>'添加','name'=>'admin/index/create','paixu' =>1,'pid'=>601],
                    ['title'=>'保存','name'=>'admin/index/save','paixu' =>2,'pid'=>601],
                    ['title'=>'删除','name'=>'admin/index/delete','paixu'=>3,'pid'=>601],
                    ['title'=>'编辑','name'=>'admin/index/edit','paixu'=>4,'pid'=>601,],
                    ['title'=>'更新','name'=>'admin/index/update','paixu' =>5,'pid'=>601],
                    ['title'=>'查看','name'=>'admin/index/read','paixu'=>6,'pid'=>601,],
                    ['title'=>'状态','name'=>'admin/index/setstatus','paixu'=>7,'pid'=>601],
                    ['title'=>'重置密码','name'=>'admin/index/resetpassword','paixu' =>8,'pid'=>601],
                    // 权限列表权限
                    ['title'=>'添加','name'=>'admin/authrule/create','paixu' =>1,'pid'=>602],
                    ['title'=>'保存','name'=>'admin/authrule/save','paixu' =>2,'pid'=>602],
                    ['title'=>'删除','name'=>'admin/authrule/delete','paixu'=>3,'pid'=>602],
                    ['title'=>'编辑','name'=>'admin/authrule/edit','paixu'=>4,'pid'=>602,],
                    ['title'=>'更新','name'=>'admin/authrule/update','paixu' =>5,'pid'=>602],
                    ['title'=>'查看','name'=>'admin/authrule/read','paixu'=>6,'pid'=>602,],
                    ['title'=>'状态','name'=>'admin/authrule/setstatus','paixu'=>7,'pid'=>602],
                    // 角色列表权限
                    ['title'=>'添加','name'=>'admin/authgroup/create','paixu' =>1,'pid'=>603],
                    ['title'=>'保存','name'=>'admin/authgroup/save','paixu' =>2,'pid'=>603],
                    ['title'=>'删除','name'=>'admin/authgroup/delete','paixu'=>3,'pid'=>603],
                    ['title'=>'编辑','name'=>'admin/authgroup/edit','paixu'=>4,'pid'=>603,],
                    ['title'=>'更新','name'=>'admin/authgroup/update','paixu' =>5,'pid'=>603],
                    ['title'=>'查看','name'=>'admin/authgroup/read','paixu'=>6,'pid'=>603,],
                    ['title'=>'状态','name'=>'admin/authgroup/setstatus','paixu'=>7,'pid'=>603],

                    // 系统设置
                    // 类别管理权限
                    ['title'=>'添加','name'=>'system/category/create','paixu' =>1,'pid'=>701],
                    ['title'=>'保存','name'=>'system/category/save','paixu' =>2,'pid'=>701],
                    ['title'=>'删除','name'=>'system/category/delete','paixu'=>3,'pid'=>701],
                    ['title'=>'编辑','name'=>'system/category/edit','paixu'=>4,'pid'=>701,],
                    ['title'=>'更新','name'=>'system/category/update','paixu' =>5,'pid'=>701],
                    ['title'=>'查看','name'=>'system/category/read','paixu'=>6,'pid'=>701,],
                    ['title'=>'状态','name'=>'system/category/setstatus','paixu'=>7,'pid'=>701],
                    // 单位管理权限
                    ['title'=>'添加','name'=>'system/school/create','paixu' =>1,'pid'=>702],
                    ['title'=>'保存','name'=>'system/school/save','paixu' =>2,'pid'=>702],
                    ['title'=>'删除','name'=>'system/school/delete','paixu'=>3,'pid'=>702],
                    ['title'=>'编辑','name'=>'system/school/edit','paixu'=>4,'pid'=>702],
                    ['title'=>'更新','name'=>'system/school/update','paixu' =>5,'pid'=>702],
                    ['title'=>'查看','name'=>'system/school/read','paixu'=>6,'pid'=>702,],
                    ['title'=>'状态','name'=>'system/school/setstatus','paixu'=>7,'pid'=>702],
                    // 文件管理权限
                    ['title'=>'删除','name'=>'system/fields/delete','paixu'=>1,'pid'=>703],
                    ['title'=>'下载','name'=>'system/fields/download','paixu'=>2,'pid'=>703,],
                    // 系统设置
                    ['title'=>'更新','name'=>'system/systembase/update','paixu'=>1,'pid' =>704],

                    // 荣誉管理
                    // 单位荣誉管理
                    ['title'=>'添加','name'=>'rongyu/dwrongyu/create','paixu' =>1,'pid'=>801],
                    ['title'=>'保存','name'=>'rongyu/dwrongyu/save','paixu' =>2,'pid'=>801],
                    ['title'=>'删除','name'=>'rongyu/dwrongyu/delete','paixu'=>3,'pid'=>801],
                    ['title'=>'编辑','name'=>'rongyu/dwrongyu/edit','paixu'=>4,'pid'=>801,],
                    ['title'=>'更新','name'=>'rongyu/dwrongyu/update','paixu' =>5,'pid'=>801],
                    ['title'=>'查看','name'=>'rongyu/dwrongyu/read','paixu'=>6,'pid'=>801,],
                    ['title'=>'状态','name'=>'rongyu/dwrongyu/setStatus','paixu'=>7,'pid'=>801],
                    ['title'=>'批量上传','name'=>'rongyu/dwrongyu/createall','paixu'=>8,'pid'=>801],
                    ['title'=>'批量保存','name'=>'rongyu/dwrongyu/saveall','paixu'=>9,'pid'=>801],
                    // 教师荣誉册管理
                    ['title'=>'添加','name'=>'rongyu/jsrongyu/create','paixu' =>1,'pid'=>802],
                    ['title'=>'保存','name'=>'rongyu/jsrongyu/save','paixu' =>2,'pid'=>802],
                    ['title'=>'删除','name'=>'rongyu/jsrongyu/delete','paixu'=>3,'pid'=>802],
                    ['title'=>'编辑','name'=>'rongyu/jsrongyu/edit','paixu'=>7,'pid'=>802,],
                    ['title'=>'更新','name'=>'rongyu/jsrongyu/update','paixu' =>8,'pid'=>802],
                    ['title'=>'查看','name'=>'rongyu/jsrongyu/read','paixu'=>6,'pid'=>802,],
                    ['title'=>'状态','name'=>'rongyu/jsrongyu/setstatus','paixu'=>7,'pid'=>802],
                    ['title'=>'查看荣誉信息','name'=>'rongyu/jsrongyuinfo/rongyulist','paixu'=>6,'pid'=>802],
                    ['title'=>'下载表格','name'=>'rongyu/jsrongyuInfo/outxlsx','paixu'=>8,'pid'=>802],


                    // 教师荣誉信息管理
                    ['title'=>'添加','name'=>'rongyu/jsrongyuinfo/create','paixu' =>1,'pid'=>803],
                    ['title'=>'保存','name'=>'rongyu/jsrongyuinfo/save','paixu' =>2,'pid'=>803],
                    ['title'=>'删除','name'=>'rongyu/jsrongyuinfo/delete','paixu'=>3,'pid'=>803],
                    ['title'=>'编辑','name'=>'rongyu/jsrongyuinfo/edit','paixu'=>4,'pid'=>803,],
                    ['title'=>'更新','name'=>'rongyu/jsrongyuinfo/update','paixu' =>5,'pid'=>803],
                    ['title'=>'查看','name'=>'rongyu/jsrongyuinfo/read','paixu'=>6,'pid'=>803,],
                    ['title'=>'状态','name'=>'rongyu/jsrongyuinfo/setstatus','paixu'=>7,'pid'=>803],
                    ['title'=>'批量上传','name'=>'rongyu/jsrongyuinfo/createall','paixu'=>8,'pid'=>803],
                    ['title'=>'批量保存','name'=>'rongyu/jsrongyuinfo/saveall','paixu'=>9,'pid'=>803],
                    

                    // 课题管理
                    // 课题册
                    ['title'=>'添加','name'=>'keti/index/create','paixu' =>1,'pid'=>901],
                    ['title'=>'保存','name'=>'keti/index/save','paixu' =>2,'pid'=>901],
                    ['title'=>'删除','name'=>'keti/index/delete','paixu'=>3,'pid'=>901],
                    ['title'=>'编辑','name'=>'keti/index/edit','paixu'=>4,'pid'=>901,],
                    ['title'=>'更新','name'=>'keti/index/update','paixu' =>5,'pid'=>901],
                    ['title'=>'课题信息','name'=>'keti/ketiinfo/ketice','paixu'=>6,'pid'=>901,],
                    ['title'=>'查看','name'=>'keti/index/read','paixu'=>7,'pid'=>901,],
                    ['title'=>'状态','name'=>'keti/index/setstatus','paixu'=>8,'pid'=>901],
                    ['title'=>'查看课题信息','name'=>'keti/ketiinfo/ketilist','paixu'=>9,'pid'=>901],
                    // 课题信息
                    ['title'=>'添加','name'=>'keti/ketiinfo/create','paixu' =>1,'pid'=>902],
                    ['title'=>'保存','name'=>'keti/ketiinfo/save','paixu' =>2,'pid'=>902],
                    ['title'=>'删除','name'=>'keti/ketiinfo/delete','paixu'=>3,'pid'=>902],
                    ['title'=>'编辑','name'=>'keti/ketiinfo/edit','paixu'=>4,'pid'=>902,],
                    ['title'=>'更新','name'=>'keti/ketiinfo/update','paixu' =>5,'pid'=>902],
                    ['title'=>'查看','name'=>'keti/ketiinfo/read','paixu'=>6,'pid'=>902,],
                    ['title'=>'状态','name'=>'keti/ketiinfo/setStatus','paixu'=>7,'pid'=>902],
                    ['title'=>'批量上传','name'=>'keti/ketiinfo/createall','paixu'=>8,'pid'=>902],
                    ['title'=>'批量保存','name'=>'keti/ketiinfo/saveall','paixu'=>9,'pid'=>902],
                    ['title'=>'结题','name'=>'keti/ketiinfo/jieti','paixu'=>10,'pid'=>902],
                    ['title'=>'下载','name'=>'keti/KetiInfo/outxlsx','paixu'=>11,'pid'=>902],
            
        ];
        // 保存数据
        $this->table('auth_rule')->insert($rows)->save();
    }
}