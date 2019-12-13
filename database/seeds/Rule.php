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
                ['id'=>101,'title'=>'扫码录入','name'=>'chengji/Index/malu','paixu'=>1,'ismenu' =>1,'pid' =>1,'url'=>'/chengji/malu',],
                ['id'=>102,'title'=>'表格录入','name'=>'chengji/Index/biaolu','paixu'=>2,'ismenu' =>1,'pid' =>1,'url'=>'/chengji/biaolu',],
                // 成绩统计
                ['id'=>201,'title'=>'班级成绩','name'=>'tongji/Index/banji','paixu'=>1,'ismenu' =>1,'pid' =>2,'url'=>'/tongji',],
                // 考试管理
                ['id'=>301,'title'=>'考试列表','name'=>'kaoshi/Index/index','paixu'=>1,'ismenu' =>1,'pid' =>3,'url'=>'/kaoshi',],
                ['id'=>302,'title'=>'考试操作','name'=>'Kaoshi/Index/MoreAction','paixu'=>2,'ismenu' =>0,'pid' =>3],

                // 师生名单
                ['id'=>401,'title'=>'学生列表','name'=>'renshi/Student/index','paixu'=>1,'ismenu' =>1,'pid' =>4,'url'=>'/renshi/student',],
                ['id'=>402,'title'=>'教师列表','name'=>'renshi/Index/index','paixu'=>2,'ismenu' =>1,'pid' =>4,'url'=>'/renshi/teacher',],

                // 教务管理
                ['id'=>501,'title'=>'学期列表','name'=>'teach/Xueqi/index','paixu'=>1,'ismenu' =>1,'pid' =>5,'url'=>'/teach/xueqi',],
                ['id'=>502,'title'=>'班级列表','name'=>'teach/Banji/index','paixu'=>2,'ismenu' =>1,'pid' =>5,'url'=>'/teach/banji',],
                ['id'=>503,'title'=>'学科列表','name'=>'teach/Subject/index','paixu'=>3,'ismenu' =>1,'pid' =>5,'url'=>'/teach/subject',],
                

                // 管理员管理
                ['id'=>601,'title'=>'管理员列表','name'=>'admin/Index/index','paixu'=>1,'ismenu' =>1,'pid' =>6,'url'=>'/admin/index',],
                ['id'=>602,'title'=>'权限列表','name'=>'admin/AuthRule/index','paixu'=>2,'ismenu' =>1,'pid' =>6,'url'=>'/admin/authrule',],
                ['id'=>603,'title'=>'角色列表','name'=>'admin/AuthGroup/index','paixu'=>3,'ismenu' =>1,'pid' =>6,'url'=>'/admin/authgroup',],
                
                // 系统设置
                ['id'=>701,'title'=>'类别管理','name'=>'system/Category/index','paixu'=>1,'ismenu' =>1,'pid' =>7,'url'=>'/system/category',],
                ['id'=>702,'title'=>'单位管理','name'=>'system/School/index','paixu'=>2,'ismenu' =>1,'pid' =>7,'url'=>'/system/school',],
                ['id'=>703,'title'=>'文件管理','name'=>'system/Fields/index','paixu'=>3,'ismenu' =>1,'pid' =>7,'url'=>'/system/file',],
                ['id'=>704,'title'=>'系统设置','name'=>'system/SystemBase/edit','paixu'=>10,'ismenu' =>1,'pid' =>7,'url'=>'/system/',],
                


                // 荣誉管理
                ['id'=>801,'title'=>'单位荣誉','name'=>'rongyu/Danwei/index','paixu'=>1,'ismenu' =>1,'pid' =>8,'url'=>'/danwei',],
                ['id'=>802,'title'=>'教师荣誉册','name'=>'rongyu/Jiaoshi/index','paixu'=>2,'ismenu' =>1,'pid' =>8,'url'=>'/jiaoshi',],
                ['id'=>803,'title'=>'教师荣誉信息','name'=>'rongyu/JsRongyuInfo/index','paixu'=>3,'ismenu' =>1,'pid' =>8,'url'=>'/jsryinfo',],
                // ['id'=>804,'title'=>'学生荣誉','name'=>'rongyu/StuRongyu/index','paixu'=>7,'ismenu' =>1,'pid' =>8,'url'=>'/xsry','status'=>0],

                // 荣誉管理
                ['id'=>901,'title'=>'课题册','name'=>'keti/Ketice/index','paixu'=>1,'ismenu' =>1,'pid' =>9,'url'=>'/keti/ketice',],
                ['id'=>902,'title'=>'课题列表','name'=>'keti/KetiInfo/index','paixu'=>2,'ismenu' =>1,'pid' =>9,'url'=>'/keti/ketiinfo',],
                
                
                
                    
                    // 三级-权限


                    // 扫码录入
                    ['title'=>'扫码查询','name'=>'Chengji/Index/read','paixu' =>1,'pid'=>101,'id'=>1000000],
                    ['title'=>'扫码保存','name'=>'Chengji/Index/malusave','paixu' =>2,'pid'=>101],
                    // 表格录入
                    ['title'=>'表格保存','name'=>'Chengji/Index/saveAll','paixu' =>3,'pid'=>102],
                    ['title'=>'表格上传','name'=>'Chengji/Index/upload','paixu' =>4,'pid'=>102],
                    ['title'=>'成绩更新','name'=>'Chengji/Index/update','paixu' =>5,'pid'=>102],

                    
                    // 考试管理
                    ['title'=>'添加','name'=>'Kaoshi/Index/create','paixu' =>1,'pid'=>301],
                    ['title'=>'删除','name'=>'Kaoshi/Index/delete','paixu'=>2,'pid'=>301],
                    ['title'=>'编辑','name'=>'Kaoshi/Index/edit','paixu'=>3,'pid'=>301,],
                    ['title'=>'更新','name'=>'Kaoshi/Index/update','paixu'=>4,'pid'=>301,],
                    ['title'=>'保存','name'=>'Kaoshi/Index/save','paixu'=>5,'pid'=>301,],
                    ['title'=>'状态','name'=>'Kaoshi/Index/setStatus','paixu'=>6,'pid'=>301],
                    ['title'=>'设置','name'=>'Kaoshi/Index/kaoshiset','paixu'=>7,'pid'=>301],
                    // 考试操作
                    ['title'=>'生成考号','name'=>'kaoshi/Kaohao/create','paixu'=>1,'pid'=>302],
                    ['title'=>'已录成绩数量','name'=>'Chengji/Tongji/yiluCnt','paixu'=>2,'pid'=>302],
                    ['title'=>'保存考号','name'=>'kaoshi/Kaohao/save','paixu'=>3,'pid'=>302],
                    ['title'=>'考号删除','name'=>'kaoshi/Kaohao/delete','paixu'=>4,'pid'=>302],
                    ['title'=>'下载试卷标签信息','name'=>'kaoshi/Kaohao/biaoqian','paixu'=>5,'pid'=>302],
                    ['title'=>'下载成绩采集表','name'=>'kaoshi/Kaohao/caiji','paixu'=>6,'pid'=>302],
                    ['title'=>'成绩列表','name'=>'Chengji/Index/index','paixu'=>7,'pid'=>302],
                        ['title'=>'录入人信息','name'=>'Chengji/Index/readAdd','paixu'=>8,'pid'=>302],
                        ['title'=>'删除成绩','name'=>'Chengji/Index/delete','paixu'=>9,'pid'=>302],
                        ['title'=>'成绩状态','name'=>'Chengji/Index/setStatus','paixu'=>10,'pid'=>302],
                    // 学生成绩
                    ['title'=>'下载学生成绩','name'=>'chengji/Index/dwChengji','paixu'=>21,'pid'=>302],
                    // 班级成绩
                    ['title'=>'班级成绩统计','name'=>'Chengji/Bjtongji/biaoge','paixu'=>41,'pid'=>302],
                    ['title'=>'下载班级成绩统计表','name'=>'chengji/Bjtongji/dwBanji','paixu'=>42,'pid'=>302],
                    // 年级成绩
                    ['title'=>'年级成绩统计','name'=>'Chengji/Njtongji/biaoge','paixu'=>61,'pid'=>302],
                    ['title'=>'下载年级成绩统计表','name'=>'chengji/Njtongji/dwNianji','paixu'=>62,'pid'=>302],



                    // 师生管理
                    // 学生管理权限
                    ['title'=>'添加','name'=>'renshi/Student/create','paixu' =>1,'pid'=>401],
                    ['title'=>'保存','name'=>'renshi/Student/save','paixu'=>2,'pid'=>401,],
                    ['title'=>'删除','name'=>'renshi/Student/delete','paixu'=>3,'pid'=>401],
                    ['title'=>'编辑','name'=>'renshi/Student/edit','paixu'=>4,'pid'=>401,],
                    ['title'=>'更新','name'=>'renshi/Student/update','paixu'=>5,'pid'=>401,],
                    ['title'=>'查看','name'=>'renshi/Student/read','paixu'=>6,'pid'=>401,],
                    ['title'=>'状态','name'=>'renshi/Student/setStatus','paixu'=>7,'pid'=>401],
                    ['title'=>'下载模板','name'=>'renshi/Student/download','paixu'=>8,'pid'=>401],
                    ['title'=>'批量上传','name'=>'renshi/Student/createAll','paixu'=>9,'pid'=>401],
                    ['title'=>'批量保存','name'=>'renshi/Student/saveAll','paixu'=>10,'pid'=>401],
                    ['title'=>'校对','name'=>'renshi/Student/jiaodui','paixu'=>11,'pid'=>401],
                    ['title'=>'校对删除','name'=>'renshi/Student/jiaoduiDel','paixu'=>12,'pid'=>401],

                    // 教师管理权限
                    ['title'=>'添加','name'=>'renshi/Index/create','paixu' =>1,'pid'=>402],
                    ['title'=>'保存','name'=>'renshi/Index/save','paixu' =>2,'pid'=>402],
                    ['title'=>'删除','name'=>'renshi/Index/delete','paixu'=>3,'pid'=>402],
                    ['title'=>'编辑','name'=>'renshi/Index/edit','paixu'=>7,'pid'=>402,],
                    ['title'=>'更新','name'=>'renshi/Index/update','paixu' =>5,'pid'=>402],
                    ['title'=>'查看','name'=>'renshi/Index/read','paixu'=>6,'pid'=>402,],
                    ['title'=>'状态','name'=>'renshi/Index/setStatus','paixu'=>7,'pid'=>402],
                    ['title'=>'查询教师','name'=>'renshi/Index/srcTeacher','paixu'=>8,'pid'=>402],
                    ['title'=>'批量上传','name'=>'renshi/Index/createAll','paixu'=>9,'pid'=>402],
                    ['title'=>'批量保存','name'=>'renshi/Index/saveAll','paixu'=>10,'pid'=>402],
                    ['title'=>'表格模板下载','name'=>'renshi/Index/download','paixu'=>11,'pid'=>402],
                    ['title'=>'姓名转换VBA下载','name'=>'renshi/Index/downloadVba','paixu'=>12,'pid'=>402],


                    // 教务管理
                    // 学期管理权限
                    ['title'=>'添加','name'=>'teach/Xueqi/create','paixu' =>1,'pid'=>501],
                    ['title'=>'保存','name'=>'teach/Xueqi/save','paixu' =>2,'pid'=>501],
                    ['title'=>'删除','name'=>'teach/Xueqi/delete','paixu'=>3,'pid'=>501],
                    ['title'=>'编辑','name'=>'teach/Xueqi/edit','paixu'=>4,'pid'=>501,],
                    ['title'=>'更新','name'=>'teach/Xueqi/update','paixu' =>5,'pid'=>501],
                    ['title'=>'查看','name'=>'teach/Xueqi/read','paixu'=>6,'pid'=>501,],
                    ['title'=>'状态','name'=>'teach/Xueqi/setStatus','paixu'=>7,'pid'=>501],
                    // 班级列表权限
                    ['title'=>'添加','name'=>'teach/Banji/create','paixu' =>1,'pid'=>502],
                    ['title'=>'保存','name'=>'teach/Banji/save','paixu' =>2,'pid'=>502],
                    ['title'=>'移动','name'=>'teach/Banji/yidong','paixu'=>3,'pid'=>502],
                    ['title'=>'状态','name'=>'teach/Banji/setStatus','paixu'=>4,'pid'=>502],
                    // 学科列表权限
                    ['title'=>'添加','name'=>'teach/Subject/create','paixu' =>1,'pid'=>503],
                    ['title'=>'保存','name'=>'teach/Subject/save','paixu' =>2,'pid'=>503],
                    ['title'=>'删除','name'=>'teach/Subject/delete','paixu'=>3,'pid'=>503],
                    ['title'=>'编辑','name'=>'teach/Subject/edit','paixu'=>4,'pid'=>503,],
                    ['title'=>'更新','name'=>'teach/Subject/update','paixu' =>5,'pid'=>503],
                    ['title'=>'查看','name'=>'teach/Subject/read','paixu'=>6,'pid'=>503,],
                    ['title'=>'状态','name'=>'teach/Subject/setStatus','paixu'=>7,'pid'=>503],


                    //管理员管理
                    // 管理员列表权限
                    ['title'=>'添加','name'=>'admin/Index/create','paixu' =>1,'pid'=>601],
                    ['title'=>'保存','name'=>'admin/Index/save','paixu' =>2,'pid'=>601],
                    ['title'=>'删除','name'=>'admin/Index/delete','paixu'=>3,'pid'=>601],
                    ['title'=>'编辑','name'=>'admin/Index/edit','paixu'=>4,'pid'=>601,],
                    ['title'=>'更新','name'=>'admin/Index/update','paixu' =>5,'pid'=>601],
                    ['title'=>'查看','name'=>'admin/Index/read','paixu'=>6,'pid'=>601,],
                    ['title'=>'状态','name'=>'admin/Index/setStatus','paixu'=>7,'pid'=>601],
                    ['title'=>'重置密码','name'=>'admin/Index/resetpassword','paixu' =>8,'pid'=>601],
                    // 权限列表权限
                    ['title'=>'添加','name'=>'admin/AuthRule/create','paixu' =>1,'pid'=>602],
                    ['title'=>'保存','name'=>'admin/AuthRule/save','paixu' =>2,'pid'=>602],
                    ['title'=>'删除','name'=>'admin/AuthRule/delete','paixu'=>3,'pid'=>602],
                    ['title'=>'编辑','name'=>'admin/AuthRule/edit','paixu'=>4,'pid'=>602,],
                    ['title'=>'更新','name'=>'admin/AuthRule/update','paixu' =>5,'pid'=>602],
                    ['title'=>'查看','name'=>'admin/AuthRule/read','paixu'=>6,'pid'=>602,],
                    ['title'=>'状态','name'=>'admin/AuthRule/setStatus','paixu'=>7,'pid'=>602],
                    // 角色列表权限
                    ['title'=>'添加','name'=>'admin/AuthGroup/create','paixu' =>1,'pid'=>603],
                    ['title'=>'保存','name'=>'admin/AuthGroup/save','paixu' =>2,'pid'=>603],
                    ['title'=>'删除','name'=>'admin/AuthGroup/delete','paixu'=>3,'pid'=>603],
                    ['title'=>'编辑','name'=>'admin/AuthGroup/edit','paixu'=>4,'pid'=>603,],
                    ['title'=>'更新','name'=>'admin/AuthGroup/update','paixu' =>5,'pid'=>603],
                    ['title'=>'查看','name'=>'admin/AuthGroup/read','paixu'=>6,'pid'=>603,],
                    ['title'=>'状态','name'=>'admin/AuthGroup/setStatus','paixu'=>7,'pid'=>603],

                    // 系统设置
                    // 类别管理权限
                    ['title'=>'添加','name'=>'system/Category/create','paixu' =>1,'pid'=>701],
                    ['title'=>'保存','name'=>'system/Category/save','paixu' =>2,'pid'=>701],
                    ['title'=>'删除','name'=>'system/Category/delete','paixu'=>3,'pid'=>701],
                    ['title'=>'编辑','name'=>'system/Category/edit','paixu'=>4,'pid'=>701,],
                    ['title'=>'更新','name'=>'system/Category/update','paixu' =>5,'pid'=>701],
                    ['title'=>'查看','name'=>'system/Category/read','paixu'=>6,'pid'=>701,],
                    ['title'=>'状态','name'=>'system/Category/setStatus','paixu'=>7,'pid'=>701],
                    // 单位管理权限
                    ['title'=>'添加','name'=>'system/School/create','paixu' =>1,'pid'=>702],
                    ['title'=>'保存','name'=>'system/School/save','paixu' =>2,'pid'=>702],
                    ['title'=>'删除','name'=>'system/School/delete','paixu'=>3,'pid'=>702],
                    ['title'=>'编辑','name'=>'system/School/edit','paixu'=>4,'pid'=>702],
                    ['title'=>'更新','name'=>'system/School/update','paixu' =>5,'pid'=>702],
                    ['title'=>'查看','name'=>'system/School/read','paixu'=>6,'pid'=>702,],
                    ['title'=>'状态','name'=>'system/School/setStatus','paixu'=>7,'pid'=>702],
                    // 文件管理权限
                    ['title'=>'删除','name'=>'system/Fields/delete','paixu'=>1,'pid'=>703],
                    ['title'=>'下载','name'=>'system/Fields/download','paixu'=>2,'pid'=>703,],
                    // 系统设置
                    ['title'=>'更新','name'=>'system/SystemBase/update','paixu'=>1,'pid' =>704],

                    // 荣誉管理
                    // 单位荣誉管理
                    ['title'=>'添加','name'=>'rongyu/Danwei/create','paixu' =>1,'pid'=>801],
                    ['title'=>'保存','name'=>'rongyu/Danwei/save','paixu' =>2,'pid'=>801],
                    ['title'=>'删除','name'=>'rongyu/Danwei/delete','paixu'=>3,'pid'=>801],
                    ['title'=>'编辑','name'=>'rongyu/Danwei/edit','paixu'=>4,'pid'=>801,],
                    ['title'=>'更新','name'=>'rongyu/Danwei/update','paixu' =>5,'pid'=>801],
                    ['title'=>'查看','name'=>'rongyu/Danwei/read','paixu'=>6,'pid'=>801,],
                    ['title'=>'状态','name'=>'rongyu/Danwei/setStatus','paixu'=>7,'pid'=>801],
                    ['title'=>'批量上传','name'=>'rongyu/Danwei/createAll','paixu'=>8,'pid'=>801],
                    ['title'=>'批量保存','name'=>'rongyu/Danwei/saveAll','paixu'=>9,'pid'=>801],
                    // 教师荣誉册管理
                    ['title'=>'添加','name'=>'rongyu/Jiaoshi/create','paixu' =>1,'pid'=>802],
                    ['title'=>'保存','name'=>'rongyu/Jiaoshi/save','paixu' =>2,'pid'=>802],
                    ['title'=>'删除','name'=>'rongyu/Jiaoshi/delete','paixu'=>3,'pid'=>802],
                    ['title'=>'编辑','name'=>'rongyu/Jiaoshi/edit','paixu'=>7,'pid'=>802,],
                    ['title'=>'更新','name'=>'rongyu/Jiaoshi/update','paixu' =>8,'pid'=>802],
                    ['title'=>'查看','name'=>'rongyu/Jiaoshi/read','paixu'=>6,'pid'=>802,],
                    ['title'=>'状态','name'=>'rongyu/Jiaoshi/setStatus','paixu'=>7,'pid'=>802],
                    ['title'=>'查看荣誉信息','name'=>'rongyu/JsRongyuInfo/rongyuList','paixu'=>6,'pid'=>802],
                    ['title'=>'下载表格','name'=>'rongyu/JsRongyuInfo/outXlsx','paixu'=>8,'pid'=>802],


                    // 教师荣誉信息管理
                    ['title'=>'添加','name'=>'rongyu/JsRongyuInfo/create','paixu' =>1,'pid'=>803],
                    ['title'=>'保存','name'=>'rongyu/JsRongyuInfo/save','paixu' =>2,'pid'=>803],
                    ['title'=>'删除','name'=>'rongyu/JsRongyuInfo/delete','paixu'=>3,'pid'=>803],
                    ['title'=>'编辑','name'=>'rongyu/JsRongyuInfo/edit','paixu'=>4,'pid'=>803,],
                    ['title'=>'更新','name'=>'rongyu/JsRongyuInfo/update','paixu' =>5,'pid'=>803],
                    ['title'=>'查看','name'=>'rongyu/JsRongyuInfo/read','paixu'=>6,'pid'=>803,],
                    ['title'=>'状态','name'=>'rongyu/JsRongyuInfo/setStatus','paixu'=>7,'pid'=>803],
                    ['title'=>'批量上传','name'=>'rongyu/JsRongyuInfo/createAll','paixu'=>8,'pid'=>803],
                    ['title'=>'批量保存','name'=>'rongyu/JsRongyuInfo/saveAll','paixu'=>9,'pid'=>803],
                    

                    // 课题管理
                    // 课题册
                    ['title'=>'添加','name'=>'keti/Ketice/create','paixu' =>1,'pid'=>901],
                    ['title'=>'保存','name'=>'keti/Ketice/save','paixu' =>2,'pid'=>901],
                    ['title'=>'删除','name'=>'keti/Ketice/delete','paixu'=>3,'pid'=>901],
                    ['title'=>'编辑','name'=>'keti/Ketice/edit','paixu'=>4,'pid'=>901,],
                    ['title'=>'更新','name'=>'keti/Ketice/update','paixu' =>5,'pid'=>901],
                    // ['title'=>'课题信息','name'=>'keti/ketiinfo/KetiCe','paixu'=>6,'pid'=>901,],
                    ['title'=>'查看','name'=>'keti/Ketice/read','paixu'=>7,'pid'=>901,],
                    ['title'=>'状态','name'=>'keti/Ketice/setStatus','paixu'=>8,'pid'=>901],
                    ['title'=>'查看课题信息','name'=>'keti/ketiinfo/ketiList','paixu'=>9,'pid'=>901],
                    // 课题信息
                    ['title'=>'添加','name'=>'keti/ketiinfo/create','paixu' =>1,'pid'=>902],
                    ['title'=>'保存','name'=>'keti/ketiinfo/save','paixu' =>2,'pid'=>902],
                    ['title'=>'删除','name'=>'keti/ketiinfo/delete','paixu'=>3,'pid'=>902],
                    ['title'=>'编辑','name'=>'keti/ketiinfo/edit','paixu'=>4,'pid'=>902,],
                    ['title'=>'更新','name'=>'keti/ketiinfo/update','paixu' =>5,'pid'=>902],
                    ['title'=>'查看','name'=>'keti/ketiinfo/read','paixu'=>6,'pid'=>902,],
                    ['title'=>'状态','name'=>'keti/ketiinfo/setStatus','paixu'=>7,'pid'=>902],
                    ['title'=>'批量上传','name'=>'keti/ketiinfo/createAll','paixu'=>8,'pid'=>902],
                    ['title'=>'批量保存','name'=>'keti/ketiinfo/saveAll','paixu'=>9,'pid'=>902],
                    ['title'=>'结题','name'=>'keti/ketiinfo/jieTi','paixu'=>10,'pid'=>902],
                    ['title'=>'下载','name'=>'keti/KetiInfo/outXlsx','paixu'=>11,'pid'=>902],
            
        ];
        // 保存数据
        $this->table('auth_rule')->insert($rows)->save();
    }
}