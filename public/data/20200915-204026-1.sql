
-- -----------------------------
-- Table structure for `cj_admin`
-- -----------------------------
DROP TABLE IF EXISTS `cj_admin`;
CREATE TABLE `cj_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `xingming` varchar(15) NOT NULL DEFAULT 'a' COMMENT '用户姓名',
  `sex` tinyint(1) NOT NULL DEFAULT '2' COMMENT '0=女，1=男，2=未知',
  `shengri` int(11) DEFAULT NULL COMMENT '出生日期',
  `username` varchar(20) NOT NULL DEFAULT 'a' COMMENT '用户帐号',
  `password` varchar(137) NOT NULL DEFAULT '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1' COMMENT '登录密码',
  `teacher_id` varchar(11) DEFAULT NULL COMMENT '教师编号',
  `school_id` int(11) NOT NULL DEFAULT '0' COMMENT '所在单位',
  `phone` varchar(11) DEFAULT NULL COMMENT '联系方式',
  `denglucishu` int(5) NOT NULL DEFAULT '0' COMMENT '登录次数',
  `lastip` varchar(55) NOT NULL DEFAULT '127.0.0.1' COMMENT '最后一次登录IP',
  `ip` varchar(55) NOT NULL DEFAULT '127.0.0.1' COMMENT '登录IP',
  `lasttime` int(11) NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `thistime` int(11) NOT NULL DEFAULT '0' COMMENT '本次登录时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0=禁用，1=正常',
  `create_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '更新时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  `beizhu` varchar(80) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- -----------------------------
-- Records of `cj_admin`
-- -----------------------------
INSERT INTO `cj_admin` VALUES ('1', '超级管理员1', '2', '', 'admin', '$apr1$vL8P2KRu$duJW3kLmY2izPx4T9KTZl/', '', '1', '', '18', '127.0.0.1', '127.0.0.1', '1600172868', '1600172870', '1', '1539158918', '1600172870', '', '');
INSERT INTO `cj_admin` VALUES ('2', '超级管理员2', '2', '', 'admin1', '$apr1$aCyUsoTU$CVOYioPjP2Em/jUp.OBO1/', '', '1', '', '1', '127.0.0.1', '39.152.145.243', '0', '1599022143', '1', '1539158918', '1599022161', '', '');
INSERT INTO `cj_admin` VALUES ('3', '小测', '1', '327168000', 'test1', '$apr1$Ep/9wlZP$xUK0teNTMrLFV74C1jWJi/', '1', '1', '', '2828', '101.229.77.34', '58.18.253.11', '1599718773', '1599722216', '1', '1599022608', '1599722216', '', '');
INSERT INTO `cj_admin` VALUES ('4', '大连巴掌', '1', '1598976000', 'cxdwsh', '$apr1$XligZ8DY$gb9YuZ4lFlfw4PtszDrDG0', '2', '2', '', '121', '127.0.0.1', '127.0.0.1', '1600173625', '1600173626', '1', '1599022892', '1600173626', '', '');

-- -----------------------------
-- Table structure for `cj_auth_group`
-- -----------------------------
DROP TABLE IF EXISTS `cj_auth_group`;
CREATE TABLE `cj_auth_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '测试用户组' COMMENT '用户组中文名称',
  `rules` varchar(10000) NOT NULL DEFAULT '0' COMMENT '用户组拥有的规则id',
  `miaoshu` varchar(200) NOT NULL DEFAULT '测试用户组' COMMENT '用户组功能描述',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '用户组状态',
  `create_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '更新时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- -----------------------------
-- Records of `cj_auth_group`
-- -----------------------------
INSERT INTO `cj_auth_group` VALUES ('1', '测试组', '1,101,10101,10102,102,10201,10202,103,10301,3,301,30101,30103,30107,302,30201,3020101,302010101,302010102,302010103,302010105,302010108,302010109,3020102,302010201,3020103,302010301,302010302,302010303,302010304,3020104,290000000,30202,3020201,3020202,30203,3020301,3020302,3020303,3020304,3020305,3020306,3020307,30204,3020401,302040101,302040103,302040105,302040106,302040107,302040108,302040109,3020402,302040201,302040202,302040203,302040204,3020403,302040301,302040302,302040303,302040304,3020404,302040401,3020405,302040501,4,401,40101,40104,40106,40109,40112,40114,402,403,5,501,50101,50104,50106,502,500201,500203,500206,500207,500208,500209,503,50301,50304,50306,6,601,60101,60104,60106,602,60201,60204,60206,603,60301,60304,60306,604,60401,7,701,70101,70104,70106,702,70201,70204,70206,703,70301,704,10,1001,100101,100104,100106,100108,100109,100110,100111,1002', '拥有部分权限', '1', '1599022494', '1599022494', '');
INSERT INTO `cj_auth_group` VALUES ('2', '系统管理员', '1,101,10101,10102,102,10201,10202,103,10301,10302,3,301,30101,30102,30103,30104,30105,30106,30107,302,30201,3020101,302010102,302010103,302010104,302010105,302010106,302010107,302010108,302010109,3020102,302010201,3020103,302010301,302010302,302010303,302010304,3020104,290000000,30202,3020201,3020202,30203,3020301,3020302,3020303,3020304,3020305,3020306,3020307,30204,3020401,30204011,302040101,302040102,302040103,302040104,302040105,302040106,302040107,302040108,302040109,3020402,302040201,302040202,302040203,302040204,3020403,302040301,302040302,302040303,302040304,3020404,302040401,3020405,302040501,4,401,4011,40101,40102,40103,40104,40105,40106,40107,40108,40109,40110,40112,40113,40114,40115,402,40201,403,40301,5,501,50101,50102,50103,50104,50105,50106,50107,502,500201,500202,500203,500204,500205,500206,500207,500208,500209,503,50301,50302,50303,50304,50305,50306,50307,50308,6,601,60101,60102,60103,60104,60105,60106,60107,60108,602,60201,60202,60203,60204,60205,60206,60207,603,60301,60302,60303,60304,60305,60306,60307,604,60401,60402,60403,7,701,70101,70102,70103,70104,70105,70106,70107,702,70201,70202,70203,70204,70205,70206,70207,70208,703,70301,70302,704,70401,705,70501,70502,10,1001,100101,100102,100103,100104,100105,100106,100107,100108,100109,100110,100111,100112,1002,100201', '拥有所有权限', '1', '1599022787', '1599022787', '');

-- -----------------------------
-- Table structure for `cj_auth_group_access`
-- -----------------------------
DROP TABLE IF EXISTS `cj_auth_group_access`;
CREATE TABLE `cj_auth_group_access` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '用户id',
  `group_id` int(11) NOT NULL COMMENT '用户组id',
  `create_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '更新时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- -----------------------------
-- Records of `cj_auth_group_access`
-- -----------------------------
INSERT INTO `cj_auth_group_access` VALUES ('1', '3', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_group_access` VALUES ('2', '4', '2', '1539158918', '1539158918', '');

-- -----------------------------
-- Table structure for `cj_auth_rule`
-- -----------------------------
DROP TABLE IF EXISTS `cj_auth_rule`;
CREATE TABLE `cj_auth_rule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL DEFAULT 'a' COMMENT '规则唯一标识',
  `title` varchar(80) NOT NULL DEFAULT 'a' COMMENT '规则中文名',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '规则状态',
  `condition` varchar(100) DEFAULT NULL COMMENT '规则表达式',
  `paixu` int(11) NOT NULL DEFAULT '999' COMMENT '排序',
  `ismenu` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否是菜单',
  `font` varchar(40) DEFAULT NULL COMMENT '菜单字体',
  `url` varchar(40) DEFAULT NULL COMMENT '菜单地址',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父ID',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '备用',
  `create_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '更新时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=302040502 DEFAULT CHARSET=utf8;

-- -----------------------------
-- Records of `cj_auth_rule`
-- -----------------------------
INSERT INTO `cj_auth_rule` VALUES ('1', 'chengji', '成绩采集', '1', '', '1', '1', '&#xe6c9;', '', '0', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('3', 'kaoshi', '考试管理', '1', '', '2', '1', '&#xe6ee;', '', '0', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('4', 'student', '学生管理', '1', '', '3', '1', '&#xe753;', '', '0', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('5', 'teach', '教务管理', '1', '', '7', '1', '&#xe6da;', '', '0', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('6', 'admin', '管理员管理', '1', '', '8', '1', '&#xe6b8;', '', '0', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('7', 'system', '系统管理', '1', '', '10', '1', '&#xe6ae;', '', '0', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('8', 'rongyu', '荣誉管理', '0', '', '5', '1', '&#xe6e4;', '', '0', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('9', 'keti', '课题管理', '0', '', '6', '1', '&#xe6b3;', '', '0', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('10', 'teacher', '教师管理', '1', '', '4', '1', '&#xe83a;', '', '0', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('101', 'luru/index/malu', '扫码录入', '1', '', '1', '1', '', '/luru/index/malu', '1', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('102', 'luru/index/biaolu', '表格录入', '1', '', '2', '1', '', '/luru/index/biaolu', '1', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('103', 'luru/index/index', '已录列表', '1', '', '2', '1', '', '/luru/index/index', '1', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('301', 'kaoshi/index/index', '考试列表', '1', '', '1', '1', '', '/kaoshi/index', '3', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('302', 'kaoshi/index/moreaction', '考试操作', '1', '', '2', '0', '', '', '3', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('401', 'student/index/index', '学生列表', '1', '', '1', '1', '', '/student/index/index', '4', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('402', 'student/index/bylist', '毕业学生', '1', '', '2', '1', '', '/student/index/bylist', '4', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('403', 'student/index/dellist', '删除学生', '1', '', '3', '1', '', '/student/index/dellist', '4', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('501', 'teach/xueqi/index', '学期列表', '1', '', '1', '1', '', '/teach/xueqi', '5', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('502', 'teach/banji/index', '班级列表', '1', '', '2', '1', '', '/teach/banji', '5', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('503', 'teach/subject/index', '学科列表', '1', '', '3', '1', '', '/teach/subject', '5', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('601', 'admin/index/index', '管理员列表', '1', '', '3', '1', '', '/admin/index', '6', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('602', 'admin/authrule/index', '权限列表', '1', '', '1', '1', '', '/admin/authrule', '6', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('603', 'admin/authgroup/index', '角色列表', '1', '', '2', '1', '', '/admin/authgroup', '6', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('604', 'admin/authgroupaccess/index', '角色用户对应表', '1', '', '2', '0', '', '/admin/authgroupaccess', '6', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('701', 'system/category/index', '类别管理', '1', '', '1', '1', '', '/system/category', '7', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('702', 'system/school/index', '单位管理', '1', '', '2', '1', '', '/system/school', '7', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('703', 'system/fields/index', '文件管理', '1', '', '3', '1', '', '/system/file', '7', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('704', 'system/systembase/edit', '系统设置', '1', '', '10', '1', '', '/system/', '7', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('705', 'system/backup/index', '数据备份', '1', '', '11', '1', '', '/system/backup/index', '7', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('801', 'rongyu/danwei/index', '单位荣誉', '1', '', '1', '1', '', '/rongyu/danwei', '8', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('802', 'rongyu/jiaoshi/index', '教师荣誉册', '1', '', '2', '1', '', '/rongyu/jiaoshi', '8', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('803', 'rongyu/jsrongyuinfo/index', '教师荣誉信息', '1', '', '3', '1', '', '/rongyu/jsryinfo', '8', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('901', 'keti/ketice/index', '课题册', '1', '', '1', '1', '', '/keti/ketice', '9', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('902', 'keti/ketiinfo/index', '课题列表', '1', '', '2', '1', '', '/keti/ketiinfo', '9', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('903', 'keti/ketiinfo/tongji', '课题统计', '1', '', '3', '1', '', '/keti/ketiinfo/tongji', '9', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('1001', 'teacher/index/index', '教师列表', '1', '', '1', '1', '', '/teacher/index/index', '10', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('1002', 'teacher/index/dellist', '删除教师', '1', '', '2', '1', '', '/teacher/index/dellist', '10', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('4011', 'student/index/saveall', '批量保存', '1', '', '11', '0', '', '', '401', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('10101', 'luru/index/read', '扫码查询', '1', '', '1', '0', '', '', '101', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('10102', 'luru/index/malusave', '扫码保存', '1', '', '2', '0', '', '', '101', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('10201', 'luru/index/saveall', '表格保存', '1', '', '1', '0', '', '', '102', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('10202', 'luru/index/upload', '表格上传', '1', '', '2', '0', '', '', '102', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('10301', 'luru/index/update', '成绩更新', '1', '', '1', '0', '', '', '103', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('10302', 'chengji/index/setstatus', '成绩状态', '1', '', '2', '0', '', '', '103', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('30101', 'kaoshi/index/create', '添加', '1', '', '1', '0', '', '', '301', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('30102', 'kaoshi/index/delete', '删除', '1', '', '2', '0', '', '', '301', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('30103', 'kaoshi/index/edit', '编辑', '1', '', '3', '0', '', '', '301', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('30104', 'kaoshi/index/update', '更新', '1', '', '4', '0', '', '', '301', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('30105', 'kaoshi/index/save', '保存', '1', '', '5', '0', '', '', '301', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('30106', 'kaoshi/index/setstatus', '状态', '1', '', '6', '0', '', '', '301', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('30107', 'kaoshi/index/luru', '成绩编辑', '1', '', '7', '0', '', '', '301', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('30201', 'yiqianqi', '前期操作', '1', '', '1', '0', '', '', '302', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('30202', 'erluru', '成绩录入', '1', '', '2', '0', '', '', '302', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('30203', 'santongji', '成绩统计', '1', '', '4', '0', '', '', '302', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('30204', 'sijieguo', '统计结果', '1', '', '4', '0', '', '', '302', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('40101', 'student/index/create', '添加', '1', '', '1', '0', '', '', '401', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('40102', 'student/index/save', '保存', '1', '', '2', '0', '', '', '401', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('40103', 'student/index/delete', '删除', '1', '', '3', '0', '', '', '401', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('40104', 'student/index/edit', '编辑', '1', '', '4', '0', '', '', '401', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('40105', 'student/index/update', '更新', '1', '', '5', '0', '', '', '401', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('40106', 'student/index/read', '查看信息', '1', '', '6', '0', '', '', '401', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('40107', 'student/index/setstatus', '状态', '1', '', '7', '0', '', '', '401', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('40108', 'student/index/setkaoshi', '是否参加考试', '1', '', '8', '0', '', '', '401', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('40109', 'student/index/download', '下载模板', '1', '', '9', '0', '', '', '401', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('40110', 'student/index/createall', '校对导入', '1', '', '10', '0', '', '', '401', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('40112', 'student/index/deletes', '表格删除页面', '1', '', '12', '0', '', '', '401', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('40113', 'student/index/deletexlsx', '表格删除数据', '1', '', '13', '0', '', '', '401', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('40114', 'student/chengji/index', '查看成绩', '1', '', '14', '0', '', '', '401', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('40115', 'student/index/resetpassword', '重置密码', '1', '', '15', '0', '', '', '401', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('40201', 'zhanwei_40201', '格式占位', '1', '', '1', '0', '', '', '402', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('40301', 'student/index/redel', '恢复删除', '1', '', '1', '0', '', '', '403', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('50101', 'teach/xueqi/create', '添加', '1', '', '1', '0', '', '', '501', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('50102', 'teach/xueqi/save', '保存', '1', '', '2', '0', '', '', '501', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('50103', 'teach/xueqi/delete', '删除', '1', '', '3', '0', '', '', '501', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('50104', 'teach/xueqi/edit', '编辑', '1', '', '4', '0', '', '', '501', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('50105', 'teach/xueqi/update', '更新', '1', '', '5', '0', '', '', '501', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('50106', 'teach/xueqi/read', '查看', '1', '', '6', '0', '', '', '501', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('50107', 'teach/xueqi/setstatus', '状态', '1', '', '7', '0', '', '', '501', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('50301', 'teach/subject/create', '添加', '1', '', '1', '0', '', '', '503', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('50302', 'teach/subject/save', '保存', '1', '', '2', '0', '', '', '503', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('50303', 'teach/subject/delete', '删除', '1', '', '3', '0', '', '', '503', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('50304', 'teach/subject/edit', '编辑', '1', '', '4', '0', '', '', '503', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('50305', 'teach/subject/update', '更新', '1', '', '5', '0', '', '', '503', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('50306', 'teach/subject/read', '查看', '1', '', '6', '0', '', '', '503', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('50307', 'teach/subject/setstatus', '状态', '1', '', '7', '0', '', '', '503', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('50308', 'teach/subject/kaoshi', '参加考试', '1', '', '8', '0', '', '', '503', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('60101', 'admin/index/create', '添加', '1', '', '1', '0', '', '', '601', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('60102', 'admin/index/save', '保存', '1', '', '2', '0', '', '', '601', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('60103', 'admin/index/delete', '删除', '1', '', '3', '0', '', '', '601', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('60104', 'admin/index/edit', '编辑', '1', '', '4', '0', '', '', '601', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('60105', 'admin/index/update', '更新', '1', '', '5', '0', '', '', '601', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('60106', 'admin/index/read', '查看', '1', '', '6', '0', '', '', '601', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('60107', 'admin/index/setstatus', '状态', '1', '', '7', '0', '', '', '601', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('60108', 'admin/index/resetpassword', '重置密码', '1', '', '8', '0', '', '', '601', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('60201', 'admin/authrule/create', '添加', '1', '', '1', '0', '', '', '602', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('60202', 'admin/authrule/save', '保存', '1', '', '2', '0', '', '', '602', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('60203', 'admin/authrule/delete', '删除', '1', '', '3', '0', '', '', '602', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('60204', 'admin/authrule/edit', '编辑', '1', '', '4', '0', '', '', '602', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('60205', 'admin/authrule/update', '更新', '1', '', '5', '0', '', '', '602', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('60206', 'admin/authrule/read', '查看', '1', '', '6', '0', '', '', '602', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('60207', 'admin/authrule/setstatus', '状态', '1', '', '7', '0', '', '', '602', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('60301', 'admin/authgroup/create', '添加', '1', '', '1', '0', '', '', '603', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('60302', 'admin/authgroup/save', '保存', '1', '', '2', '0', '', '', '603', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('60303', 'admin/authgroup/delete', '删除', '1', '', '3', '0', '', '', '603', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('60304', 'admin/authgroup/edit', '编辑', '1', '', '4', '0', '', '', '603', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('60305', 'admin/authgroup/update', '更新', '1', '', '5', '0', '', '', '603', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('60306', 'admin/authgroup/read', '查看', '1', '', '6', '0', '', '', '603', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('60307', 'admin/authgroup/setstatus', '状态', '1', '', '7', '0', '', '', '603', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('60401', 'admin/authgroupaccess/create', '添加', '1', '', '1', '0', '', '', '604', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('60402', 'admin/authgroupaccess/save', '保存', '1', '', '2', '0', '', '', '604', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('60403', 'admin/authgroupaccess/delete', '删除', '1', '', '3', '0', '', '', '604', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('70101', 'system/category/create', '添加', '1', '', '1', '0', '', '', '701', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('70102', 'system/category/save', '保存', '1', '', '2', '0', '', '', '701', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('70103', 'system/category/delete', '删除', '1', '', '3', '0', '', '', '701', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('70104', 'system/category/edit', '编辑', '1', '', '4', '0', '', '', '701', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('70105', 'system/category/update', '更新', '1', '', '5', '0', '', '', '701', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('70106', 'system/category/read', '查看', '1', '', '6', '0', '', '', '701', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('70107', 'system/category/setstatus', '状态', '1', '', '7', '0', '', '', '701', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('70201', 'system/school/create', '添加', '1', '', '1', '0', '', '', '702', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('70202', 'system/school/save', '保存', '1', '', '2', '0', '', '', '702', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('70203', 'system/school/delete', '删除', '1', '', '3', '0', '', '', '702', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('70204', 'system/school/edit', '编辑', '1', '', '4', '0', '', '', '702', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('70205', 'system/school/update', '更新', '1', '', '5', '0', '', '', '702', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('70206', 'system/school/read', '查看', '1', '', '6', '0', '', '', '702', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('70207', 'system/school/setstatus', '状态', '1', '', '7', '0', '', '', '702', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('70208', 'system/school/setkaoshi', '能否组织考试', '1', '', '8', '0', '', '', '702', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('70301', 'system/fields/delete', '删除', '1', '', '1', '0', '', '', '703', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('70302', 'system/fields/download', '下载', '1', '', '2', '0', '', '', '703', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('70401', 'system/systembase/update', '更新', '1', '', '1', '0', '', '', '704', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('70501', 'system/backup/create', '创建', '1', '', '1', '0', '', '', '705', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('70502', 'system/backup/delete', '删除', '1', '', '1', '0', '', '', '705', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('80101', 'rongyu/danwei/create', '添加', '1', '', '1', '0', '', '', '801', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('80102', 'rongyu/danwei/save', '保存', '1', '', '2', '0', '', '', '801', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('80103', 'rongyu/danwei/delete', '删除', '1', '', '3', '0', '', '', '801', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('80104', 'rongyu/danwei/edit', '编辑', '1', '', '4', '0', '', '', '801', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('80105', 'rongyu/danwei/update', '更新', '1', '', '5', '0', '', '', '801', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('80106', 'rongyu/danwei/read', '查看', '1', '', '6', '0', '', '', '801', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('80107', 'rongyu/danwei/setstatus', '状态', '1', '', '7', '0', '', '', '801', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('80108', 'rongyu/danwei/createall', '批量上传', '1', '', '8', '0', '', '', '801', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('80109', 'rongyu/danwei/saveall', '批量保存', '1', '', '9', '0', '', '', '801', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('80201', 'rongyu/jiaoshi/create', '添加', '1', '', '1', '0', '', '', '802', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('80202', 'rongyu/jiaoshi/save', '保存', '1', '', '2', '0', '', '', '802', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('80203', 'rongyu/jiaoshi/delete', '删除', '1', '', '3', '0', '', '', '802', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('80204', 'rongyu/jiaoshi/edit', '编辑', '1', '', '4', '0', '', '', '802', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('80205', 'rongyu/jiaoshi/update', '更新', '1', '', '5', '0', '', '', '802', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('80206', 'rongyu/jiaoshi/read', '查看', '1', '', '6', '0', '', '', '802', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('80207', 'rongyu/jiaoshi/setstatus', '状态', '1', '', '6', '0', '', '', '802', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('80208', 'rongyu/jsrongyuinfo/rongyulist', '查看荣誉信息', '1', '', '7', '0', '', '', '802', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('80209', 'rongyu/jsrongyuinfo/outxlsx', '下载表格', '1', '', '8', '0', '', '', '802', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('80301', 'rongyu/jsrongyuinfo/create', '添加', '1', '', '1', '0', '', '', '803', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('80302', 'rongyu/jsrongyuinfo/save', '保存', '1', '', '2', '0', '', '', '803', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('80303', 'rongyu/jsrongyuinfo/delete', '删除', '1', '', '3', '0', '', '', '803', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('80304', 'rongyu/jsrongyuinfo/edit', '编辑', '1', '', '4', '0', '', '', '803', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('80305', 'rongyu/jsrongyuinfo/update', '更新', '1', '', '5', '0', '', '', '803', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('80306', 'rongyu/jsrongyuinfo/read', '查看', '1', '', '6', '0', '', '', '803', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('80307', 'rongyu/jsrongyuinfo/setstatus', '状态', '1', '', '7', '0', '', '', '803', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('80308', 'rongyu/jsrongyuinfo/createall', '批量上传', '1', '', '8', '0', '', '', '803', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('80309', 'rongyu/jsrongyuinfo/saveall', '批量保存', '1', '', '9', '0', '', '', '803', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('90101', 'keti/ketice/create', '添加', '1', '', '1', '0', '', '', '901', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('90102', 'keti/ketice/save', '保存', '1', '', '2', '0', '', '', '901', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('90103', 'keti/ketice/delete', '删除', '1', '', '3', '0', '', '', '901', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('90104', 'keti/ketice/edit', '编辑', '1', '', '4', '0', '', '', '901', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('90105', 'keti/ketice/update', '更新', '1', '', '5', '0', '', '', '901', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('90106', 'keti/ketice/read', '查看', '1', '', '6', '0', '', '', '901', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('90107', 'keti/ketice/setstatus', '状态', '1', '', '7', '0', '', '', '901', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('90108', 'keti/ketiinfo/ketilist', '查看课题信息', '1', '', '8', '0', '', '', '901', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('90201', 'keti/ketiinfo/create', '添加', '1', '', '1', '0', '', '', '902', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('90202', 'keti/ketiinfo/save', '保存', '1', '', '2', '0', '', '', '902', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('90203', 'keti/ketiinfo/delete', '删除', '1', '', '3', '0', '', '', '902', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('90204', 'keti/ketiinfo/edit', '编辑', '1', '', '4', '0', '', '', '902', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('90205', 'keti/ketiinfo/update', '更新', '1', '', '5', '0', '', '', '902', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('90206', 'keti/ketiinfo/read', '查看', '1', '', '6', '0', '', '', '902', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('90207', 'keti/ketiinfo/setstatus', '状态', '1', '', '7', '0', '', '', '902', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('90208', 'keti/ketiinfo/createall', '批量上传', '1', '', '8', '0', '', '', '902', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('90209', 'keti/ketiinfo/saveall', '批量保存', '1', '', '9', '0', '', '', '902', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('90210', 'keti/ketiinfo/jieti', '结题编辑', '1', '', '10', '0', '', '', '902', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('90211', 'keti/ketiinfo/jtupdate', '结题更新', '1', '', '11', '0', '', '', '902', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('90212', 'keti/ketiinfo/outxlsx', '下载', '1', '', '12', '0', '', '', '902', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('100101', 'teacher/index/create', '添加', '1', '', '1', '0', '', '', '1001', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('100102', 'teacher/index/save', '保存', '1', '', '2', '0', '', '', '1001', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('100103', 'teacher/index/delete', '删除', '1', '', '3', '0', '', '', '1001', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('100104', 'teacher/index/edit', '编辑', '1', '', '4', '0', '', '', '1001', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('100105', 'teacher/index/update', '更新', '1', '', '5', '0', '', '', '1001', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('100106', 'teacher/index/read', '查看', '1', '', '6', '0', '', '', '1001', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('100107', 'teacher/index/setstatus', '状态', '1', '', '7', '0', '', '', '1001', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('100108', 'teacher/index/srcteacher', '查询教师', '1', '', '8', '0', '', '', '1001', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('100109', 'teacher/index/createall', '批量上传', '1', '', '9', '0', '', '', '1001', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('100110', 'teacher/index/saveall', '批量保存', '1', '', '10', '0', '', '', '1001', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('100111', 'teacher/index/downloadxls', '表格模板下载', '1', '', '11', '0', '', '', '1001', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('100112', 'teacher/index/resetpassword', '重置密码', '1', '', '7', '0', '', '', '1001', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('100201', 'teacher/index/redel', '恢复删除', '1', '', '1', '0', '', '', '1002', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('500201', 'teach/banji/create', '添加', '1', '', '1', '0', '', '', '502', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('500202', 'teach/banji/save', '保存', '1', '', '2', '0', '', '', '502', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('500203', 'teach/banji/yidong', '移动', '1', '', '3', '0', '', '', '502', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('500204', 'teach/banji/delete', '删除', '1', '', '4', '0', '', '', '502', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('500205', 'teach/banji/setstatus', '状态', '1', '', '5', '0', '', '', '502', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('500206', 'teach/banjichengji/index', '成绩查看', '1', '', '6', '0', '', '', '502', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('500207', 'teach/banji/setalias', '设置别名', '1', '', '7', '0', '', '', '502', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('500208', 'teach/banji/banzhuren', '编辑班主任', '1', '', '8', '0', '', '', '502', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('500209', 'teach/banji/updatebanzhuren', '更新班主任', '1', '', '9', '0', '', '', '502', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('3020101', 'kaoshi/kaoshiset/index', '考试设置', '1', '', '1', '0', '', '', '30201', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('3020102', 'kaohao/index/createall', '生成考号', '1', '', '1', '0', '', '', '30201', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('3020103', 'chengji/bjtongji/renke', '任课教师', '1', '', '1', '0', '', '', '30201', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('3020104', 'kaohao/excel/biaoqian', '下载试卷标签信息', '1', '', '4', '0', '', '', '30201', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('3020201', 'kaohao/excel/caiji', '下载成绩采集表', '1', '', '1', '0', '', '', '30202', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('3020202', 'chengji/tongji/yilucnt', '已录成绩数量', '1', '', '2', '0', '', '', '30202', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('3020301', 'chengji/bjtongji/tongji', '以班级为单位统计成绩', '1', '', '1', '0', '', '', '30203', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('3020302', 'chengji/njtongji/tongji', '以学校为单位统计成绩', '1', '', '2', '0', '', '', '30203', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('3020303', 'chengji/schtongji/tongji', '以全部成绩为单位统计成绩', '1', '', '3', '0', '', '', '30203', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('3020304', 'chengji/bjtongji/bjorder', '统计学生成绩在班级位置', '1', '', '4', '0', '', '', '30203', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('3020305', 'chengji/njtongji/njorder', '统计学生成绩在学校位置', '1', '', '5', '0', '', '', '30203', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('3020306', 'chengji/schtongji/schorder', '统计学生成绩在区位置', '1', '', '6', '0', '', '', '30203', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('3020307', 'kaoshi/tjlog/index', '检测统计结果', '1', '', '7', '0', '', '', '30203', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('3020401', 'chengji/index/index', '学生成绩', '1', '', '1', '0', '', '', '30204', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('3020402', 'banjichengji', '班级成绩', '1', '', '2', '0', '', '', '30204', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('3020403', 'nianjichengji', '年级成绩', '1', '', '3', '0', '', '', '30204', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('3020404', 'kaoshi/tongjiLog/index', '统计记录', '1', '', '4', '0', '', '', '30204', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('3020405', 'chengji/bjtongji/fenshuduan', '各分数段统计', '1', '', '5', '0', '', '', '30204', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('30204011', 'chengji/index/delete', '批量删除成绩', '1', '', '3', '0', '', '', '3020401', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('200000000', 'zhanwei_200000000', '新建权限起始位置', '0', '', '12', '0', '', '', '902', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('290000000', 'zhanwei_302010401', '生成考号备用', '1', '', '2', '0', '', '', '3020104', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('302010102', 'kaoshi/kaoshiset/create', '新建', '1', '', '1', '0', '', '', '3020101', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('302010103', 'kaoshi/kaoshiset/save', '保存', '1', '', '2', '0', '', '', '3020101', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('302010104', 'kaoshi/kaoshiset/delete', '删除', '1', '', '3', '0', '', '', '3020101', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('302010105', 'kaoshi/kaoshiset/edit', '编辑', '1', '', '4', '0', '', '', '3020101', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('302010106', 'kaoshi/kaoshiset/update', '更新', '1', '', '5', '0', '', '', '3020101', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('302010107', 'kaoshi/kaoshiset/setstatus', '状态', '1', '', '6', '0', '', '', '3020101', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('302010108', 'chengji/tongji/editdefenlv', '统计得分率', '1', '', '4', '0', '', '', '3020101', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('302010109', 'chengji/tongji/updatedefenLv', '更新得分率', '1', '', '5', '0', '', '', '3020101', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('302010201', 'zhanwei_302010201', '生成考号备用', '1', '', '2', '0', '', '', '3020102', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('302010301', 'chengji/bjtongji/renkeedit', '编辑', '1', '', '2', '0', '', '', '3020103', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('302010302', 'chengji/bjtongji/renkeupdate', '更新编辑', '1', '', '2', '0', '', '', '3020103', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('302010303', 'chengji/bjtongji/renkeeditteacher', '设置', '1', '', '2', '0', '', '', '3020103', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('302010304', 'chengji/bjtongji/renkeupdateteacher', '更新设置', '1', '', '2', '0', '', '', '3020103', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('302040101', 'chengji/index/readadd', '录入人信息', '1', '', '1', '0', '', '', '3020401', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('302040102', 'kaohao/index/delete', '考号删除', '1', '', '2', '0', '', '', '3020401', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('302040103', 'chengji/index/deletecjs', '批量删除界面', '1', '', '4', '0', '', '', '3020401', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('302040104', 'chengji/index/deletecjmore', '批量删除', '1', '', '5', '0', '', '', '3020401', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('302040105', 'chengji/index/dwchengjitiao', '下载学生成绩条', '1', '', '6', '0', '', '', '3020401', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('302040106', 'kaohao/index/create', '添加单个考号', '1', '', '7', '0', '', '', '3020401', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('302040107', 'kaohao/index/save', '保存单个考号', '1', '', '8', '0', '', '', '3020401', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('302040108', 'kaohao/index/read', '学生成绩图表', '1', '', '9', '0', '', '', '3020401', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('302040109', 'chengji/index/dwchengji', '下载学生成绩', '1', '', '10', '0', '', '', '3020401', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('302040201', 'chengji/bjtongji/biaoge', '班级成绩统计', '1', '', '1', '0', '', '', '3020402', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('302040202', 'chengji/bjtongji/dwBiaoge', '下载班级成绩统计表', '1', '', '2', '0', '', '', '3020402', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('302040203', 'chengji/bjtongji/myavg', '条形统计图', '1', '', '3', '0', '', '', '3020402', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('302040204', 'chengji/bjtongji/myxiangti', '箱体图', '1', '', '4', '0', '', '', '3020402', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('302040301', 'chengji/njtongji/biaoge', '年级成绩统计', '1', '', '1', '0', '', '', '3020403', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('302040302', 'chengji/njtongji/dwBiaoge', '下载年级成绩统计表', '1', '', '2', '0', '', '', '3020403', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('302040303', 'chengji/njtongji/myavg', '条形统计图', '1', '', '3', '0', '', '', '3020403', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('302040304', 'chengji/njtongji/myxiangti', '箱体图', '1', '', '4', '0', '', '', '3020403', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('302040401', 'tongjiLog1', '占位', '1', '', '1', '0', '', '', '3020404', '1', '1539158918', '1539158918', '');
INSERT INTO `cj_auth_rule` VALUES ('302040501', 'fenshudua', '点位', '1', '', '1', '0', '', '', '3020405', '1', '1539158918', '1539158918', '');

-- -----------------------------
-- Table structure for `cj_banji`
-- -----------------------------
DROP TABLE IF EXISTS `cj_banji`;
CREATE TABLE `cj_banji` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `school_id` int(11) NOT NULL DEFAULT '0' COMMENT '学校',
  `ruxuenian` int(4) DEFAULT NULL COMMENT '入学年',
  `xuanduan_id` int(11) DEFAULT NULL COMMENT '学段',
  `paixu` int(3) NOT NULL DEFAULT '100' COMMENT '排序',
  `banzhuren` int(11) DEFAULT NULL COMMENT '班主任',
  `alias` varchar(24) DEFAULT NULL COMMENT '班级别名',
  `create_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '更新时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0=禁用，1=正常',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- -----------------------------
-- Records of `cj_banji`
-- -----------------------------
INSERT INTO `cj_banji` VALUES ('1', '2', '2020', '', '1', '', '', '1599023054', '1599023054', '', '1');
INSERT INTO `cj_banji` VALUES ('2', '2', '2020', '', '2', '', '', '1599023054', '1599023054', '', '1');
INSERT INTO `cj_banji` VALUES ('3', '2', '2020', '', '3', '', '', '1599023054', '1599023054', '', '1');
INSERT INTO `cj_banji` VALUES ('4', '3', '2020', '', '1', '', '', '1599023063', '1599023063', '', '1');
INSERT INTO `cj_banji` VALUES ('5', '3', '2020', '', '2', '', '', '1599023063', '1599023063', '', '1');
INSERT INTO `cj_banji` VALUES ('6', '2', '2019', '', '1', '', '', '1599023095', '1599023095', '', '1');
INSERT INTO `cj_banji` VALUES ('7', '3', '2019', '', '1', '', '', '1599024023', '1599024023', '', '1');

-- -----------------------------
-- Table structure for `cj_category`
-- -----------------------------
DROP TABLE IF EXISTS `cj_category`;
CREATE TABLE `cj_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL DEFAULT 'a' COMMENT '类型标题',
  `p_id` int(11) NOT NULL DEFAULT '0' COMMENT '父级ID',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0=禁用，1=正常',
  `paixu` int(4) NOT NULL DEFAULT '999' COMMENT '排序',
  `isupdate` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0=不允许更新，1=允许更新',
  `beizhu` varchar(80) DEFAULT NULL COMMENT '备注',
  `create_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '更新时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12103 DEFAULT CHARSET=utf8;

-- -----------------------------
-- Records of `cj_category`
-- -----------------------------
INSERT INTO `cj_category` VALUES ('101', '单位性质', '0', '1', '1', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('102', '单位级别', '0', '1', '2', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('103', '大学段', '0', '1', '3', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('104', '小学段', '0', '1', '4', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('105', '学历', '0', '1', '5', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('106', '职称', '0', '1', '6', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('107', '职务', '0', '1', '7', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('108', '学期', '0', '1', '8', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('109', '考试', '0', '1', '9', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('110', '学科', '0', '1', '10', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('111', '文件', '0', '1', '11', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('112', '单位荣誉类型', '0', '1', '12', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('113', '荣誉奖项', '0', '1', '13', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('114', '教师荣誉类型', '0', '1', '14', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('115', '课题立项类型', '0', '1', '15', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('116', '课题研究所属学科分类', '0', '1', '16', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('117', '研究类型', '0', '1', '17', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('118', '课题状态', '0', '1', '18', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('119', '课题或荣誉角色', '0', '1', '19', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('120', '成绩统计分类', '0', '1', '20', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('121', '成绩录入用户类型', '0', '1', '21', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('10101', '幼儿园', '101', '1', '1', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('10102', '小学', '101', '1', '2', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('10103', '九年一贯', '101', '1', '3', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('10104', '初中', '101', '1', '4', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('10105', '高中', '101', '1', '5', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('10106', '中等职业技术学校', '101', '1', '6', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('10107', '科研机构(教师进修学校)', '101', '1', '7', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('10108', '教育行政部门', '101', '1', '8', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('10109', '其他教育机构', '101', '1', '9', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('10201', '班级', '102', '0', '1', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('10202', '教研组', '102', '1', '2', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('10203', '校级', '102', '1', '3', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('10204', '区级', '102', '1', '4', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('10205', '市级', '102', '1', '5', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('10206', '省级', '102', '1', '6', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('10207', '部级', '102', '1', '7', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('10208', '其它级', '102', '1', '8', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('10301', '幼儿园', '103', '1', '1', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('10302', '小学', '103', '1', '2', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('10303', '中小学', '103', '1', '3', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('10304', '初中', '103', '1', '4', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('10305', '高中', '103', '1', '5', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('10306', '其他学段', '103', '1', '6', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('10401', '低段', '104', '1', '1', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('10402', '中段', '104', '1', '2', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('10403', '高段', '104', '1', '3', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('10404', '其他学段', '104', '1', '4', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('10501', '高中/中专', '105', '1', '1', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('10502', '专科', '105', '1', '2', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('10503', '本科', '105', '1', '3', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('10504', '硕士研究生', '105', '1', '4', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('10505', '博士研究生', '105', '1', '5', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('10506', '其他学历', '105', '1', '6', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('10601', '正高级', '106', '1', '1', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('10602', '高级', '106', '1', '2', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('10603', '一级', '106', '1', '3', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('10604', '二级', '106', '1', '4', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('10605', '三级', '106', '1', '5', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('10606', '其他', '106', '1', '6', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('10701', '校长', '107', '1', '1', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('10702', '书记', '107', '1', '2', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('10703', '副书记', '107', '1', '3', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('10704', '副校长', '107', '1', '4', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('10705', '主任', '107', '1', '5', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('10706', '教研组长', '107', '1', '6', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('10707', '班主任', '107', '1', '7', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('10708', '课任', '107', '1', '8', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('10709', '其他', '107', '1', '9', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('10801', '第一学期', '108', '1', '1', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('10802', '第二学期', '108', '1', '2', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('10901', '期末考试', '109', '1', '1', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('10902', '期中考试', '109', '1', '2', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('10903', '单项测试', '109', '1', '3', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('11001', '语文', '110', '1', '1', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('11002', '数学', '110', '1', '2', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('11003', '外语', '110', '1', '3', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('11004', '品德', '110', '1', '4', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('11005', '历史与社会', '110', '1', '5', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('11006', '科学', '110', '1', '6', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('11007', '体育与健康', '110', '1', '7', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('11008', '艺术', '110', '1', '8', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('11009', '综合实践活动', '110', '1', '9', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('11010', '地方/校本课程', '110', '1', '10', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('11011', '幼儿园全科', '110', '1', '11', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('11012', '其它', '110', '1', '12', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('11101', '教师名单', '111', '1', '1', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('11102', '学生名单', '111', '1', '2', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('11103', '考试成绩', '111', '1', '3', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('11201', '科研', '112', '1', '1', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('11202', '特色', '112', '1', '2', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('11203', '教研', '112', '1', '3', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('11301', '先进(个人/单位)', '113', '1', '1', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('11302', '一等奖', '113', '1', '2', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('11303', '二等奖', '113', '1', '3', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('11304', '三等奖', '113', '1', '4', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('11305', '优秀奖', '113', '1', '5', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('11306', '百十佳', '113', '1', '6', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('11307', '指导奖', '113', '1', '7', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('11308', '其他', '113', '1', '8', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('11401', '优质课', '114', '1', '1', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('11402', '技能大赛', '114', '1', '2', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('11403', '论文', '114', '1', '3', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('11404', '教科研', '114', '1', '4', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('11405', '荣誉称号', '114', '1', '5', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('11406', '培训', '114', '1', '6', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('11407', '展示课', '114', '1', '7', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('11501', '一般课题', '115', '1', '1', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('11502', '专项课题', '115', '1', '2', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('11503', '重大或重点课题', '115', '1', '3', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('11504', '子课题', '115', '1', '4', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('11601', 'A. 教育政策研究(含教育发展战略)', '116', '1', '1', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('11602', 'B. 基础教育', '116', '1', '2', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('11603', 'C. 职业教育与成人教育(含终身教育、社会教育)', '116', '1', '3', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('11604', 'D.其他', '116', '1', '3', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('11701', 'A.基础研究', '117', '1', '1', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('11702', 'B.应用研究', '117', '1', '2', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('11703', 'C.综合研究', '117', '1', '3', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('11801', '研究中', '118', '1', '1', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('11802', '合格', '118', '1', '2', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('11803', '优秀', '118', '1', '3', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('11804', '流失', '118', '1', '3', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('11901', '主持人', '119', '1', '1', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('11902', '参与人', '119', '1', '2', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('12001', '班级统计', '120', '1', '1', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('12002', '班级排序', '120', '1', '2', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('12003', '学校统计', '120', '1', '3', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('12004', '学校排序', '120', '1', '4', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('12005', '区统计', '120', '1', '5', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('12006', '区排序', '120', '1', '6', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('12101', '班级统计', '121', '1', '1', '0', '', '1539158918', '1539158918', '');
INSERT INTO `cj_category` VALUES ('12102', '班级排序', '121', '1', '2', '0', '', '1539158918', '1539158918', '');

-- -----------------------------
-- Table structure for `cj_chengji`
-- -----------------------------
DROP TABLE IF EXISTS `cj_chengji`;
CREATE TABLE `cj_chengji` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kaohao_id` int(11) NOT NULL DEFAULT '0' COMMENT '考试',
  `subject_id` int(11) NOT NULL DEFAULT '0' COMMENT '学科',
  `user_group` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '用户组',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户',
  `defen` decimal(5,1) NOT NULL COMMENT '得分',
  `defenlv` decimal(6,2) NOT NULL COMMENT '得分率',
  `bpaixu` int(4) DEFAULT NULL COMMENT '班级排序',
  `bweizhi` decimal(6,2) DEFAULT NULL COMMENT '班级位置',
  `xpaixu` int(4) DEFAULT NULL COMMENT '学校排序',
  `xweizhi` decimal(6,2) DEFAULT NULL COMMENT '学校位置',
  `qpaixu` int(4) DEFAULT NULL COMMENT '区排序',
  `qweizhi` decimal(6,2) DEFAULT NULL COMMENT '区位置',
  `create_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '更新时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0=禁用，1=正常',
  PRIMARY KEY (`id`),
  UNIQUE KEY `kaohao_id` (`kaohao_id`,`subject_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3096 DEFAULT CHARSET=utf8;

-- -----------------------------
-- Records of `cj_chengji`
-- -----------------------------
INSERT INTO `cj_chengji` VALUES ('1', '1', '101', '', '0', '14.0', '14.00', '17', '27.27', '59', '19.44', '89', '20.00', '1599025869', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('2', '2', '101', '', '0', '76.0', '76.00', '6', '77.27', '17', '77.78', '24', '79.09', '1599025869', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('3', '3', '101', '', '0', '18.0', '18.00', '14', '40.91', '54', '26.39', '83', '25.45', '1599025869', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('4', '4', '101', '', '0', '31.0', '31.00', '12', '50.00', '45', '38.89', '68', '39.09', '1599025869', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('5', '5', '101', '', '0', '68.0', '68.00', '7', '72.73', '21', '72.22', '32', '71.82', '1599025869', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('6', '6', '101', '', '0', '92.0', '92.00', '2', '95.45', '6', '93.06', '9', '92.73', '1599025869', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('7', '7', '101', '', '0', '52.0', '52.00', '9', '63.64', '33', '55.56', '49', '56.36', '1599025869', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('8', '8', '101', '', '0', '89.0', '89.00', '3', '90.91', '7', '91.67', '11', '90.91', '1599025869', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('9', '9', '101', '', '0', '15.0', '15.00', '16', '31.82', '58', '20.83', '88', '20.91', '1599025869', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('10', '10', '101', '', '0', '14.0', '14.00', '17', '27.27', '59', '19.44', '89', '20.00', '1599025869', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('11', '11', '101', '', '0', '7.0', '7.00', '20', '13.64', '66', '9.72', '101', '9.09', '1599025869', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('12', '12', '101', '', '0', '33.0', '33.00', '11', '54.55', '43', '41.67', '64', '42.73', '1599025869', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('13', '13', '101', '', '0', '51.0', '51.00', '10', '59.09', '34', '54.17', '50', '55.45', '1599025869', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('14', '14', '101', '', '0', '98.0', '98.00', '1', '100.00', '3', '97.22', '3', '98.18', '1599025869', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('15', '15', '101', '', '0', '57.0', '57.00', '8', '68.18', '32', '56.94', '47', '58.18', '1599025869', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('16', '16', '101', '', '0', '22.0', '22.00', '13', '45.45', '51', '30.56', '80', '28.18', '1599025869', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('17', '17', '101', '', '0', '86.0', '86.00', '5', '81.82', '10', '87.50', '16', '86.36', '1599025869', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('18', '18', '101', '', '0', '16.0', '16.00', '15', '36.36', '57', '22.22', '86', '22.73', '1599025869', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('19', '19', '101', '', '0', '8.0', '8.00', '19', '18.18', '64', '12.50', '98', '11.82', '1599025869', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('20', '20', '101', '', '0', '4.0', '4.00', '21', '9.09', '67', '8.33', '104', '6.36', '1599025869', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('21', '21', '101', '', '0', '3.0', '3.00', '22', '4.55', '69', '5.56', '106', '4.55', '1599025869', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('22', '22', '101', '', '0', '88.0', '88.00', '4', '86.36', '9', '88.89', '14', '88.18', '1599025869', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('23', '23', '101', '', '0', '32.0', '32.00', '12', '31.25', '44', '40.28', '66', '40.91', '1599025869', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('24', '24', '101', '', '0', '81.0', '81.00', '3', '87.50', '13', '83.33', '20', '82.73', '1599025869', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('25', '25', '101', '', '0', '93.0', '93.00', '1', '100.00', '5', '94.44', '8', '93.64', '1599025869', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('26', '26', '101', '', '0', '59.0', '59.00', '8', '56.25', '28', '62.50', '43', '61.82', '1599025869', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('27', '27', '101', '', '0', '3.0', '3.00', '15', '12.50', '69', '5.56', '106', '4.55', '1599025869', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('28', '28', '101', '', '0', '68.0', '68.00', '6', '68.75', '21', '72.22', '32', '71.82', '1599025869', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('29', '29', '101', '', '0', '74.0', '74.00', '5', '75.00', '18', '76.39', '25', '78.18', '1599025869', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('30', '30', '101', '', '0', '47.0', '47.00', '10', '43.75', '37', '50.00', '56', '50.00', '1599025869', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('31', '31', '101', '', '0', '78.0', '78.00', '4', '81.25', '15', '80.56', '22', '80.91', '1599025869', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('32', '32', '101', '', '0', '14.0', '14.00', '13', '25.00', '59', '19.44', '89', '20.00', '1599025869', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('33', '33', '101', '', '0', '37.0', '37.00', '11', '37.50', '42', '43.06', '63', '43.64', '1599025869', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('34', '34', '101', '', '0', '66.0', '66.00', '7', '62.50', '24', '68.06', '35', '69.09', '1599025869', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('35', '35', '101', '', '0', '3.0', '3.00', '15', '12.50', '69', '5.56', '106', '4.55', '1599025869', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('36', '36', '101', '', '0', '49.0', '49.00', '9', '50.00', '36', '51.39', '54', '51.82', '1599025869', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('37', '37', '101', '', '0', '9.0', '9.00', '14', '18.75', '63', '13.89', '97', '12.73', '1599025870', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('38', '38', '101', '', '0', '89.0', '89.00', '2', '93.75', '7', '91.67', '11', '90.91', '1599025870', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('39', '39', '101', '', '0', '100.0', '100.00', '1', '100.00', '1', '100.00', '1', '100.00', '1599025870', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('40', '40', '101', '', '0', '67.0', '67.00', '10', '73.53', '23', '69.44', '34', '70.00', '1599025870', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('41', '41', '101', '', '0', '42.0', '42.00', '19', '47.06', '39', '47.22', '58', '48.18', '1599025870', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('42', '42', '101', '', '0', '1.0', '1.00', '34', '2.94', '72', '1.39', '110', '0.91', '1599025870', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('43', '43', '101', '', '0', '39.0', '39.00', '21', '41.18', '41', '44.44', '61', '45.45', '1599025870', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('44', '44', '101', '', '0', '95.0', '95.00', '3', '94.12', '4', '95.83', '7', '94.55', '1599025870', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('45', '45', '101', '', '0', '8.0', '8.00', '32', '8.82', '64', '12.50', '98', '11.82', '1599025870', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('46', '46', '101', '', '0', '100.0', '100.00', '1', '100.00', '1', '100.00', '1', '100.00', '1599025870', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('47', '47', '101', '', '0', '41.0', '41.00', '20', '44.12', '40', '45.83', '59', '47.27', '1599025870', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('48', '48', '101', '', '0', '28.0', '28.00', '24', '32.35', '48', '34.72', '73', '34.55', '1599025870', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('49', '49', '101', '', '0', '31.0', '31.00', '22', '38.24', '45', '38.89', '68', '39.09', '1599025870', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('50', '50', '101', '', '0', '59.0', '59.00', '14', '61.76', '28', '62.50', '43', '61.82', '1599025870', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('51', '51', '101', '', '0', '59.0', '59.00', '14', '61.76', '28', '62.50', '43', '61.82', '1599025870', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('52', '52', '101', '', '0', '17.0', '17.00', '29', '17.65', '55', '25.00', '84', '24.55', '1599025870', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('53', '53', '101', '', '0', '4.0', '4.00', '33', '5.88', '67', '8.33', '104', '6.36', '1599025870', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('54', '54', '101', '', '0', '21.0', '21.00', '27', '23.53', '52', '29.17', '81', '27.27', '1599025870', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('55', '55', '101', '', '0', '45.0', '45.00', '18', '50.00', '38', '48.61', '57', '49.09', '1599025870', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('56', '56', '101', '', '0', '77.0', '77.00', '7', '82.35', '16', '79.17', '23', '80.00', '1599025870', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('57', '57', '101', '', '0', '31.0', '31.00', '22', '38.24', '45', '38.89', '68', '39.09', '1599025870', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('58', '58', '101', '', '0', '17.0', '17.00', '29', '17.65', '55', '25.00', '84', '24.55', '1599025870', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('59', '59', '101', '', '0', '82.0', '82.00', '5', '88.24', '12', '84.72', '19', '83.64', '1599025870', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('60', '60', '101', '', '0', '19.0', '19.00', '28', '20.59', '53', '27.78', '82', '26.36', '1599025870', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('61', '61', '101', '', '0', '14.0', '14.00', '31', '11.76', '59', '19.44', '89', '20.00', '1599025870', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('62', '62', '101', '', '0', '25.0', '25.00', '26', '26.47', '50', '31.94', '76', '31.82', '1599025870', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('63', '63', '101', '', '0', '84.0', '84.00', '4', '91.18', '11', '86.11', '18', '84.55', '1599025870', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('64', '64', '101', '', '0', '72.0', '72.00', '9', '76.47', '20', '73.61', '29', '74.55', '1599025870', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('65', '65', '101', '', '0', '74.0', '74.00', '8', '79.41', '18', '76.39', '25', '78.18', '1599025870', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('66', '66', '101', '', '0', '51.0', '51.00', '17', '52.94', '34', '54.17', '50', '55.45', '1599025870', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('67', '67', '101', '', '0', '27.0', '27.00', '25', '29.41', '49', '33.33', '75', '32.73', '1599025870', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('68', '68', '101', '', '0', '61.0', '61.00', '13', '64.71', '27', '63.89', '41', '63.64', '1599025870', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('69', '69', '101', '', '0', '65.0', '65.00', '11', '70.59', '25', '66.67', '37', '67.27', '1599025870', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('70', '70', '101', '', '0', '58.0', '58.00', '16', '55.88', '31', '58.33', '46', '59.09', '1599025870', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('71', '71', '101', '', '0', '63.0', '63.00', '12', '67.65', '26', '65.28', '39', '65.45', '1599025870', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('72', '72', '101', '', '0', '81.0', '81.00', '6', '85.29', '13', '83.33', '20', '82.73', '1599025870', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('73', '1', '102', '', '0', '27.0', '27.00', '15', '36.36', '48', '34.72', '75', '32.73', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('74', '2', '102', '', '0', '88.0', '88.00', '4', '86.36', '5', '94.44', '7', '94.55', '1599025870', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('75', '3', '102', '', '0', '15.0', '15.00', '19', '18.18', '61', '16.67', '96', '13.64', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('76', '4', '102', '', '0', '14.0', '14.00', '20', '13.64', '63', '13.89', '98', '11.82', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('77', '5', '102', '', '0', '74.0', '74.00', '8', '68.18', '16', '79.17', '25', '78.18', '1599025870', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('78', '6', '102', '', '0', '2.0', '2.00', '22', '4.55', '71', '2.78', '109', '1.82', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('79', '7', '102', '', '0', '85.0', '85.00', '6', '77.27', '7', '91.67', '10', '91.82', '1599025870', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('80', '8', '102', '', '0', '94.0', '94.00', '3', '90.91', '3', '97.22', '5', '96.36', '1599025870', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('81', '9', '102', '', '0', '11.0', '11.00', '21', '9.09', '68', '6.94', '103', '7.27', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('82', '10', '102', '', '0', '19.0', '19.00', '18', '22.73', '58', '20.83', '88', '20.91', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('83', '11', '102', '', '0', '65.0', '65.00', '10', '59.09', '23', '69.44', '37', '67.27', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('84', '12', '102', '', '0', '95.0', '95.00', '2', '95.45', '2', '98.61', '3', '98.18', '1599025870', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('85', '13', '102', '', '0', '61.0', '61.00', '12', '50.00', '26', '65.28', '41', '63.64', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('86', '14', '102', '', '0', '21.0', '21.00', '17', '27.27', '56', '23.61', '85', '23.64', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('87', '15', '102', '', '0', '28.0', '28.00', '14', '40.91', '47', '36.11', '74', '33.64', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('88', '16', '102', '', '0', '81.0', '81.00', '7', '72.73', '13', '83.33', '18', '84.55', '1599025870', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('89', '17', '102', '', '0', '63.0', '63.00', '11', '54.55', '24', '68.06', '38', '66.36', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('90', '18', '102', '', '0', '56.0', '56.00', '13', '45.45', '29', '61.11', '45', '60.00', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('91', '19', '102', '', '0', '22.0', '22.00', '16', '31.82', '54', '26.39', '83', '25.45', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('92', '20', '102', '', '0', '87.0', '87.00', '5', '81.82', '6', '93.06', '8', '93.64', '1599025870', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('93', '21', '102', '', '0', '99.0', '99.00', '1', '100.00', '1', '100.00', '1', '100.00', '1599025870', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('94', '22', '102', '', '0', '72.0', '72.00', '9', '63.64', '19', '75.00', '29', '74.55', '1599025870', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('95', '23', '102', '', '0', '26.0', '26.00', '11', '37.50', '49', '33.33', '78', '30.00', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('96', '24', '102', '', '0', '3.0', '3.00', '15', '12.50', '70', '4.17', '108', '2.73', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('97', '25', '102', '', '0', '36.0', '36.00', '9', '50.00', '41', '44.44', '66', '40.91', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('98', '26', '102', '', '0', '52.0', '52.00', '5', '75.00', '33', '55.56', '50', '55.45', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('99', '27', '102', '', '0', '44.0', '44.00', '7', '62.50', '37', '50.00', '59', '47.27', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('100', '28', '102', '', '0', '14.0', '14.00', '14', '18.75', '63', '13.89', '98', '11.82', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('101', '29', '102', '', '0', '29.0', '29.00', '10', '43.75', '46', '37.50', '73', '34.55', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('102', '30', '102', '', '0', '46.0', '46.00', '6', '68.75', '34', '54.17', '54', '51.82', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('103', '31', '102', '', '0', '71.0', '71.00', '2', '93.75', '20', '73.61', '31', '72.73', '1599025870', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('104', '32', '102', '', '0', '73.0', '73.00', '1', '100.00', '17', '77.78', '27', '76.36', '1599025870', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('105', '33', '102', '', '0', '41.0', '41.00', '8', '56.25', '39', '47.22', '61', '45.45', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('106', '34', '102', '', '0', '26.0', '26.00', '11', '37.50', '49', '33.33', '78', '30.00', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('107', '35', '102', '', '0', '1.0', '1.00', '16', '6.25', '72', '1.39', '110', '0.91', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('108', '36', '102', '', '0', '63.0', '63.00', '3', '87.50', '24', '68.06', '38', '66.36', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('109', '37', '102', '', '0', '15.0', '15.00', '13', '25.00', '61', '16.67', '96', '13.64', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('110', '38', '102', '', '0', '61.0', '61.00', '4', '81.25', '26', '65.28', '41', '63.64', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('111', '39', '102', '', '0', '24.0', '24.00', '25', '29.41', '52', '29.17', '81', '27.27', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('112', '40', '102', '', '0', '77.0', '77.00', '8', '79.41', '15', '80.56', '23', '80.00', '1599025870', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('113', '41', '102', '', '0', '53.0', '53.00', '14', '61.76', '31', '58.33', '48', '57.27', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('114', '42', '102', '', '0', '13.0', '13.00', '32', '8.82', '66', '9.72', '101', '9.09', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('115', '43', '102', '', '0', '55.0', '55.00', '13', '64.71', '30', '59.72', '46', '59.09', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('116', '44', '102', '', '0', '41.0', '41.00', '19', '47.06', '39', '47.22', '61', '45.45', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('117', '45', '102', '', '0', '53.0', '53.00', '14', '61.76', '31', '58.33', '48', '57.27', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('118', '46', '102', '', '0', '46.0', '46.00', '16', '55.88', '34', '54.17', '54', '51.82', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('119', '47', '102', '', '0', '14.0', '14.00', '31', '11.76', '63', '13.89', '98', '11.82', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('120', '48', '102', '', '0', '25.0', '25.00', '24', '32.35', '51', '30.56', '80', '28.18', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('121', '49', '102', '', '0', '21.0', '21.00', '28', '20.59', '56', '23.61', '85', '23.64', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('122', '50', '102', '', '0', '82.0', '82.00', '6', '85.29', '12', '84.72', '17', '85.45', '1599025870', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('123', '51', '102', '', '0', '85.0', '85.00', '2', '97.06', '7', '91.67', '10', '91.82', '1599025870', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('124', '52', '102', '', '0', '73.0', '73.00', '9', '76.47', '17', '77.78', '27', '76.36', '1599025870', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('125', '53', '102', '', '0', '16.0', '16.00', '30', '14.71', '60', '18.06', '94', '15.45', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('126', '54', '102', '', '0', '71.0', '71.00', '10', '73.53', '20', '73.61', '31', '72.73', '1599025870', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('127', '55', '102', '', '0', '33.0', '33.00', '20', '44.12', '42', '43.06', '67', '40.00', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('128', '56', '102', '', '0', '6.0', '6.00', '34', '2.94', '69', '5.56', '106', '4.55', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('129', '57', '102', '', '0', '85.0', '85.00', '2', '97.06', '7', '91.67', '10', '91.82', '1599025870', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('130', '58', '102', '', '0', '23.0', '23.00', '26', '26.47', '53', '27.78', '82', '26.36', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('131', '59', '102', '', '0', '81.0', '81.00', '7', '82.35', '13', '83.33', '18', '84.55', '1599025870', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('132', '60', '102', '', '0', '91.0', '91.00', '1', '100.00', '4', '95.83', '6', '95.45', '1599025870', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('133', '61', '102', '', '0', '44.0', '44.00', '18', '50.00', '37', '50.00', '59', '47.27', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('134', '62', '102', '', '0', '13.0', '13.00', '32', '8.82', '66', '9.72', '101', '9.09', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('135', '63', '102', '', '0', '22.0', '22.00', '27', '23.53', '54', '26.39', '83', '25.45', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('136', '64', '102', '', '0', '18.0', '18.00', '29', '17.65', '59', '19.44', '90', '19.09', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('137', '65', '102', '', '0', '83.0', '83.00', '4', '91.18', '10', '87.50', '15', '87.27', '1599025870', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('138', '66', '102', '', '0', '33.0', '33.00', '20', '44.12', '42', '43.06', '67', '40.00', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('139', '67', '102', '', '0', '57.0', '57.00', '12', '67.65', '28', '62.50', '43', '61.82', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('140', '68', '102', '', '0', '32.0', '32.00', '22', '38.24', '44', '40.28', '69', '38.18', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('141', '69', '102', '', '0', '45.0', '45.00', '17', '52.94', '36', '51.39', '56', '50.00', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('142', '70', '102', '', '0', '83.0', '83.00', '4', '91.18', '10', '87.50', '15', '87.27', '1599025870', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('143', '71', '102', '', '0', '69.0', '69.00', '11', '70.59', '22', '70.83', '33', '70.91', '1599025870', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('144', '72', '102', '', '0', '32.0', '32.00', '22', '38.24', '44', '40.28', '69', '38.18', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('145', '1', '103', '', '0', '32.0', '32.00', '15', '36.36', '51', '30.56', '74', '33.64', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('146', '2', '103', '', '0', '74.0', '74.00', '5', '81.82', '19', '75.00', '23', '80.00', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('147', '3', '103', '', '0', '5.0', '5.00', '22', '4.55', '69', '5.56', '105', '5.45', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('148', '4', '103', '', '0', '51.0', '51.00', '10', '59.09', '33', '55.56', '48', '57.27', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('149', '5', '103', '', '0', '55.0', '55.00', '9', '63.64', '30', '59.72', '43', '61.82', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('150', '6', '103', '', '0', '50.0', '50.00', '11', '54.55', '34', '54.17', '51', '54.55', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('151', '7', '103', '', '0', '95.0', '95.00', '1', '100.00', '5', '94.44', '6', '95.45', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('152', '8', '103', '', '0', '7.0', '7.00', '20', '13.64', '67', '8.33', '103', '7.27', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('153', '9', '103', '', '0', '20.0', '20.00', '16', '31.82', '58', '20.83', '88', '20.91', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('154', '10', '103', '', '0', '86.0', '86.00', '2', '95.45', '9', '88.89', '10', '91.82', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('155', '11', '103', '', '0', '7.0', '7.00', '20', '13.64', '67', '8.33', '103', '7.27', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('156', '12', '103', '', '0', '60.0', '60.00', '8', '68.18', '25', '66.67', '35', '69.09', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('157', '13', '103', '', '0', '12.0', '12.00', '17', '27.27', '64', '12.50', '97', '12.73', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('158', '14', '103', '', '0', '72.0', '72.00', '6', '77.27', '21', '72.22', '27', '76.36', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('159', '15', '103', '', '0', '77.0', '77.00', '4', '86.36', '15', '80.56', '18', '84.55', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('160', '16', '103', '', '0', '48.0', '48.00', '12', '50.00', '36', '51.39', '54', '51.82', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('161', '17', '103', '', '0', '65.0', '65.00', '7', '72.73', '23', '69.44', '31', '72.73', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('162', '18', '103', '', '0', '46.0', '46.00', '13', '45.45', '39', '47.22', '59', '47.27', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('163', '19', '103', '', '0', '10.0', '10.00', '19', '18.18', '66', '9.72', '100', '10.00', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('164', '20', '103', '', '0', '39.0', '39.00', '14', '40.91', '45', '38.89', '66', '40.91', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('165', '21', '103', '', '0', '79.0', '79.00', '3', '90.91', '12', '84.72', '15', '87.27', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('166', '22', '103', '', '0', '12.0', '12.00', '17', '27.27', '64', '12.50', '97', '12.73', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('167', '23', '103', '', '0', '54.0', '54.00', '8', '56.25', '31', '58.33', '45', '60.00', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('168', '24', '103', '', '0', '48.0', '48.00', '9', '50.00', '36', '51.39', '54', '51.82', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('169', '25', '103', '', '0', '79.0', '79.00', '3', '87.50', '12', '84.72', '15', '87.27', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('170', '26', '103', '', '0', '64.0', '64.00', '7', '62.50', '24', '68.06', '33', '70.91', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('171', '27', '103', '', '0', '39.0', '39.00', '11', '37.50', '45', '38.89', '66', '40.91', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('172', '28', '103', '', '0', '68.0', '68.00', '6', '68.75', '22', '70.83', '30', '73.64', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('173', '29', '103', '', '0', '18.0', '18.00', '13', '25.00', '59', '19.44', '90', '19.09', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('174', '30', '103', '', '0', '76.0', '76.00', '4', '81.25', '16', '79.17', '19', '83.64', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('175', '31', '103', '', '0', '47.0', '47.00', '10', '43.75', '38', '48.61', '57', '49.09', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('176', '32', '103', '', '0', '74.0', '74.00', '5', '75.00', '19', '75.00', '23', '80.00', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('177', '33', '103', '', '0', '17.0', '17.00', '14', '18.75', '60', '18.06', '91', '18.18', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('178', '34', '103', '', '0', '15.0', '15.00', '16', '6.25', '62', '15.28', '94', '15.45', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('179', '35', '103', '', '0', '36.0', '36.00', '12', '31.25', '47', '36.11', '69', '38.18', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('180', '36', '103', '', '0', '16.0', '16.00', '15', '12.50', '61', '16.67', '93', '16.36', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('181', '37', '103', '', '0', '82.0', '82.00', '2', '93.75', '11', '86.11', '13', '89.09', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('182', '38', '103', '', '0', '88.0', '88.00', '1', '100.00', '7', '91.67', '8', '93.64', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('183', '39', '103', '', '0', '27.0', '27.00', '27', '23.53', '54', '26.39', '80', '28.18', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('184', '40', '103', '', '0', '3.0', '3.00', '32', '8.82', '70', '4.17', '107', '3.64', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('185', '41', '103', '', '0', '33.0', '33.00', '24', '32.35', '50', '31.94', '73', '34.55', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('186', '42', '103', '', '0', '49.0', '49.00', '16', '55.88', '35', '52.78', '53', '52.73', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('187', '43', '103', '', '0', '87.0', '87.00', '6', '85.29', '8', '90.28', '9', '92.73', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('188', '44', '103', '', '0', '22.0', '22.00', '30', '14.71', '57', '22.22', '86', '22.73', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('189', '45', '103', '', '0', '40.0', '40.00', '21', '41.18', '44', '40.28', '65', '41.82', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('190', '46', '103', '', '0', '53.0', '53.00', '15', '58.82', '32', '56.94', '46', '59.09', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('191', '47', '103', '', '0', '59.0', '59.00', '11', '70.59', '26', '65.28', '36', '68.18', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('192', '48', '103', '', '0', '97.0', '97.00', '2', '97.06', '2', '98.61', '2', '99.09', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('193', '49', '103', '', '0', '32.0', '32.00', '25', '29.41', '51', '30.56', '74', '33.64', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('194', '50', '103', '', '0', '34.0', '34.00', '22', '38.24', '48', '34.72', '71', '36.36', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('195', '51', '103', '', '0', '42.0', '42.00', '18', '50.00', '41', '44.44', '61', '45.45', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('196', '52', '103', '', '0', '58.0', '58.00', '13', '64.71', '28', '62.50', '39', '65.45', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('197', '53', '103', '', '0', '78.0', '78.00', '8', '79.41', '14', '81.94', '17', '85.45', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('198', '54', '103', '', '0', '95.0', '95.00', '5', '88.24', '5', '94.44', '6', '95.45', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('199', '55', '103', '', '0', '0.0', '0.00', '33', '5.88', '71', '2.78', '109', '1.82', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('200', '56', '103', '', '0', '23.0', '23.00', '29', '17.65', '56', '23.61', '85', '23.64', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('201', '57', '103', '', '0', '76.0', '76.00', '9', '76.47', '16', '79.17', '19', '83.64', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('202', '58', '103', '', '0', '97.0', '97.00', '2', '97.06', '2', '98.61', '2', '99.09', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('203', '59', '103', '', '0', '58.0', '58.00', '13', '64.71', '28', '62.50', '39', '65.45', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('204', '60', '103', '', '0', '75.0', '75.00', '10', '73.53', '18', '76.39', '21', '81.82', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('205', '61', '103', '', '0', '96.0', '96.00', '4', '91.18', '4', '95.83', '4', '97.27', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('206', '62', '103', '', '0', '59.0', '59.00', '11', '70.59', '26', '65.28', '36', '68.18', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('207', '63', '103', '', '0', '34.0', '34.00', '22', '38.24', '48', '34.72', '71', '36.36', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('208', '64', '103', '', '0', '41.0', '41.00', '20', '44.12', '43', '41.67', '64', '42.73', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('209', '65', '103', '', '0', '84.0', '84.00', '7', '82.35', '10', '87.50', '11', '90.91', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('210', '66', '103', '', '0', '15.0', '15.00', '31', '11.76', '62', '15.28', '94', '15.45', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('211', '67', '103', '', '0', '45.0', '45.00', '17', '52.94', '40', '45.83', '60', '46.36', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('212', '68', '103', '', '0', '42.0', '42.00', '18', '50.00', '41', '44.44', '61', '45.45', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('213', '69', '103', '', '0', '0.0', '0.00', '33', '5.88', '71', '2.78', '109', '1.82', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('214', '70', '103', '', '0', '28.0', '28.00', '26', '26.47', '53', '27.78', '79', '29.09', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('215', '71', '103', '', '0', '25.0', '25.00', '28', '20.59', '55', '25.00', '83', '25.45', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('216', '72', '103', '', '0', '98.0', '98.00', '1', '100.00', '1', '100.00', '1', '100.00', '1599025870', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('217', '73', '101', '', '0', '99.0', '99.00', '2', '95.83', '2', '95.83', '2', '97.06', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('218', '74', '101', '', '0', '100.0', '100.00', '1', '100.00', '1', '100.00', '1', '100.00', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('219', '75', '101', '', '0', '78.0', '78.00', '7', '75.00', '7', '75.00', '9', '76.47', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('220', '76', '101', '', '0', '56.0', '56.00', '13', '50.00', '13', '50.00', '17', '52.94', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('221', '77', '101', '', '0', '48.0', '48.00', '16', '37.50', '16', '37.50', '21', '41.18', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('222', '78', '101', '', '0', '1.0', '1.00', '24', '4.17', '24', '4.17', '34', '2.94', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('223', '79', '101', '', '0', '54.0', '54.00', '14', '45.83', '14', '45.83', '19', '47.06', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('224', '80', '101', '', '0', '95.0', '95.00', '3', '91.67', '3', '91.67', '3', '94.12', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('225', '81', '101', '', '0', '93.0', '93.00', '4', '87.50', '4', '87.50', '4', '91.18', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('226', '82', '101', '', '0', '47.0', '47.00', '17', '33.33', '17', '33.33', '22', '38.24', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('227', '83', '101', '', '0', '81.0', '81.00', '6', '79.17', '6', '79.17', '8', '79.41', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('228', '84', '101', '', '0', '30.0', '30.00', '21', '16.67', '21', '16.67', '28', '20.59', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('229', '85', '101', '', '0', '57.0', '57.00', '12', '54.17', '12', '54.17', '16', '55.88', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('230', '86', '101', '', '0', '10.0', '10.00', '23', '8.33', '23', '8.33', '32', '8.82', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('231', '87', '101', '', '0', '62.0', '62.00', '10', '62.50', '10', '62.50', '12', '67.65', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('232', '88', '101', '', '0', '34.0', '34.00', '20', '20.83', '20', '20.83', '25', '29.41', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('233', '89', '101', '', '0', '84.0', '84.00', '5', '83.33', '5', '83.33', '7', '82.35', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('234', '90', '101', '', '0', '65.0', '65.00', '9', '66.67', '9', '66.67', '11', '70.59', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('235', '91', '101', '', '0', '53.0', '53.00', '15', '41.67', '15', '41.67', '20', '44.12', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('236', '92', '101', '', '0', '43.0', '43.00', '18', '29.17', '18', '29.17', '23', '35.29', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('237', '93', '101', '', '0', '66.0', '66.00', '8', '70.83', '8', '70.83', '10', '73.53', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('238', '94', '101', '', '0', '62.0', '62.00', '10', '62.50', '10', '62.50', '12', '67.65', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('239', '95', '101', '', '0', '43.0', '43.00', '18', '29.17', '18', '29.17', '23', '35.29', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('240', '96', '101', '', '0', '17.0', '17.00', '22', '12.50', '22', '12.50', '31', '11.76', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('241', '73', '102', '', '0', '36.0', '36.00', '18', '29.17', '18', '29.17', '25', '29.41', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('242', '74', '102', '', '0', '93.0', '93.00', '5', '83.33', '5', '83.33', '5', '88.24', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('243', '75', '102', '', '0', '1.0', '1.00', '24', '4.17', '24', '4.17', '34', '2.94', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('244', '76', '102', '', '0', '63.0', '63.00', '12', '54.17', '12', '54.17', '17', '52.94', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('245', '77', '102', '', '0', '98.0', '98.00', '1', '100.00', '1', '100.00', '1', '100.00', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('246', '78', '102', '', '0', '97.0', '97.00', '4', '87.50', '4', '87.50', '4', '91.18', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('247', '79', '102', '', '0', '88.0', '88.00', '6', '79.17', '6', '79.17', '7', '82.35', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('248', '80', '102', '', '0', '30.0', '30.00', '19', '25.00', '19', '25.00', '26', '26.47', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('249', '81', '102', '', '0', '62.0', '62.00', '13', '50.00', '13', '50.00', '18', '50.00', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('250', '82', '102', '', '0', '55.0', '55.00', '14', '45.83', '14', '45.83', '20', '44.12', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('251', '83', '102', '', '0', '8.0', '8.00', '22', '12.50', '22', '12.50', '30', '14.71', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('252', '84', '102', '', '0', '77.0', '77.00', '7', '75.00', '7', '75.00', '8', '79.41', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('253', '85', '102', '', '0', '64.0', '64.00', '10', '62.50', '10', '62.50', '15', '58.82', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('254', '86', '102', '', '0', '4.0', '4.00', '23', '8.33', '23', '8.33', '31', '11.76', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('255', '87', '102', '', '0', '77.0', '77.00', '7', '75.00', '7', '75.00', '8', '79.41', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('256', '88', '102', '', '0', '45.0', '45.00', '15', '41.67', '15', '41.67', '22', '38.24', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('257', '89', '102', '', '0', '30.0', '30.00', '19', '25.00', '19', '25.00', '26', '26.47', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('258', '90', '102', '', '0', '98.0', '98.00', '1', '100.00', '1', '100.00', '1', '100.00', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('259', '91', '102', '', '0', '21.0', '21.00', '21', '16.67', '21', '16.67', '29', '17.65', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('260', '92', '102', '', '0', '45.0', '45.00', '15', '41.67', '15', '41.67', '22', '38.24', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('261', '93', '102', '', '0', '64.0', '64.00', '10', '62.50', '10', '62.50', '15', '58.82', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('262', '94', '102', '', '0', '71.0', '71.00', '9', '66.67', '9', '66.67', '11', '70.59', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('263', '95', '102', '', '0', '98.0', '98.00', '1', '100.00', '1', '100.00', '1', '100.00', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('264', '96', '102', '', '0', '40.0', '40.00', '17', '33.33', '17', '33.33', '24', '32.35', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('265', '73', '103', '', '0', '100.0', '100.00', '1', '100.00', '1', '100.00', '1', '100.00', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('266', '74', '103', '', '0', '5.0', '5.00', '23', '8.33', '23', '8.33', '33', '5.88', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('267', '75', '103', '', '0', '46.0', '46.00', '18', '29.17', '18', '29.17', '21', '41.18', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('268', '76', '103', '', '0', '71.0', '71.00', '7', '75.00', '7', '75.00', '8', '79.41', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('269', '77', '103', '', '0', '97.0', '97.00', '4', '87.50', '4', '87.50', '4', '91.18', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('270', '78', '103', '', '0', '0.0', '0.00', '24', '4.17', '24', '4.17', '34', '2.94', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('271', '79', '103', '', '0', '63.0', '63.00', '12', '54.17', '12', '54.17', '13', '64.71', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('272', '80', '103', '', '0', '65.0', '65.00', '11', '58.33', '11', '58.33', '12', '67.65', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('273', '81', '103', '', '0', '23.0', '23.00', '19', '25.00', '19', '25.00', '25', '29.41', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('274', '82', '103', '', '0', '20.0', '20.00', '20', '20.83', '20', '20.83', '27', '23.53', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('275', '83', '103', '', '0', '70.0', '70.00', '8', '70.83', '8', '70.83', '9', '76.47', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('276', '84', '103', '', '0', '98.0', '98.00', '3', '91.67', '3', '91.67', '3', '94.12', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('277', '85', '103', '', '0', '100.0', '100.00', '1', '100.00', '1', '100.00', '1', '100.00', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('278', '86', '103', '', '0', '17.0', '17.00', '21', '16.67', '21', '16.67', '28', '20.59', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('279', '87', '103', '', '0', '57.0', '57.00', '16', '37.50', '16', '37.50', '18', '50.00', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('280', '88', '103', '', '0', '88.0', '88.00', '5', '83.33', '5', '83.33', '5', '88.24', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('281', '89', '103', '', '0', '49.0', '49.00', '17', '33.33', '17', '33.33', '20', '44.12', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('282', '90', '103', '', '0', '61.0', '61.00', '13', '50.00', '13', '50.00', '15', '58.82', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('283', '91', '103', '', '0', '70.0', '70.00', '8', '70.83', '8', '70.83', '9', '76.47', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('284', '92', '103', '', '0', '61.0', '61.00', '13', '50.00', '13', '50.00', '15', '58.82', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('285', '93', '103', '', '0', '59.0', '59.00', '15', '41.67', '15', '41.67', '17', '52.94', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('286', '94', '103', '', '0', '75.0', '75.00', '6', '79.17', '6', '79.17', '7', '82.35', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('287', '95', '103', '', '0', '67.0', '67.00', '10', '62.50', '10', '62.50', '11', '70.59', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('288', '96', '103', '', '0', '9.0', '9.00', '22', '12.50', '22', '12.50', '31', '11.76', '1599025875', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('289', '97', '101', '', '0', '8.0', '8.00', '19', '18.18', '35', '10.53', '98', '11.82', '1599025880', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('290', '98', '101', '', '0', '50.0', '50.00', '9', '63.64', '17', '57.89', '52', '53.64', '1599025880', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('291', '99', '101', '', '0', '97.0', '97.00', '1', '100.00', '1', '100.00', '4', '97.27', '1599025880', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('292', '100', '101', '', '0', '73.0', '73.00', '4', '86.36', '8', '81.58', '27', '76.36', '1599025880', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('293', '101', '101', '', '0', '6.0', '6.00', '20', '13.64', '36', '7.89', '102', '8.18', '1599025880', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('294', '102', '101', '', '0', '24.0', '24.00', '15', '36.36', '27', '31.58', '77', '30.91', '1599025880', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('295', '103', '101', '', '0', '85.0', '85.00', '3', '90.91', '7', '84.21', '17', '85.45', '1599025880', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('296', '104', '101', '', '0', '70.0', '70.00', '5', '81.82', '10', '76.32', '30', '73.64', '1599025880', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('297', '105', '101', '', '0', '30.0', '30.00', '12', '50.00', '24', '39.47', '71', '36.36', '1599025880', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('298', '106', '101', '', '0', '16.0', '16.00', '16', '31.82', '30', '23.68', '86', '22.73', '1599025880', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('299', '107', '101', '', '0', '13.0', '13.00', '17', '27.27', '31', '21.05', '93', '16.36', '1599025880', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('300', '108', '101', '', '0', '28.0', '28.00', '14', '40.91', '26', '34.21', '73', '34.55', '1599025880', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('301', '109', '101', '', '0', '65.0', '65.00', '7', '72.73', '13', '68.42', '37', '67.27', '1599025880', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('302', '110', '101', '', '0', '32.0', '32.00', '11', '54.55', '23', '42.11', '66', '40.91', '1599025880', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('303', '111', '101', '', '0', '91.0', '91.00', '2', '95.45', '4', '92.11', '10', '91.82', '1599025880', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('304', '112', '101', '', '0', '11.0', '11.00', '18', '22.73', '33', '15.79', '95', '14.55', '1599025880', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('305', '113', '101', '', '0', '30.0', '30.00', '12', '50.00', '24', '39.47', '71', '36.36', '1599025880', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('306', '114', '101', '', '0', '66.0', '66.00', '6', '77.27', '12', '71.05', '35', '69.09', '1599025880', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('307', '115', '101', '', '0', '6.0', '6.00', '20', '13.64', '36', '7.89', '102', '8.18', '1599025880', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('308', '116', '101', '', '0', '60.0', '60.00', '8', '68.18', '15', '63.16', '42', '62.73', '1599025880', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('309', '117', '101', '', '0', '49.0', '49.00', '10', '59.09', '19', '52.63', '54', '51.82', '1599025880', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('310', '118', '101', '', '0', '2.0', '2.00', '22', '4.55', '38', '2.63', '109', '1.82', '1599025880', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('311', '119', '101', '', '0', '50.0', '50.00', '9', '50.00', '17', '57.89', '52', '53.64', '1599025880', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('312', '120', '101', '', '0', '73.0', '73.00', '5', '75.00', '8', '81.58', '27', '76.36', '1599025880', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('313', '121', '101', '', '0', '89.0', '89.00', '3', '87.50', '5', '89.47', '11', '90.91', '1599025880', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('314', '122', '101', '', '0', '23.0', '23.00', '14', '18.75', '29', '26.32', '79', '29.09', '1599025880', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('315', '123', '101', '', '0', '33.0', '33.00', '12', '31.25', '22', '44.74', '64', '42.73', '1599025880', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('316', '124', '101', '', '0', '87.0', '87.00', '4', '81.25', '6', '86.84', '15', '87.27', '1599025880', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('317', '125', '101', '', '0', '70.0', '70.00', '6', '68.75', '10', '76.32', '30', '73.64', '1599025880', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('318', '126', '101', '', '0', '63.0', '63.00', '7', '62.50', '14', '65.79', '39', '65.45', '1599025880', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('319', '127', '101', '', '0', '24.0', '24.00', '13', '25.00', '27', '31.58', '77', '30.91', '1599025880', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('320', '128', '101', '', '0', '41.0', '41.00', '10', '43.75', '20', '50.00', '59', '47.27', '1599025880', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('321', '129', '101', '', '0', '38.0', '38.00', '11', '37.50', '21', '47.37', '62', '44.55', '1599025880', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('322', '130', '101', '', '0', '53.0', '53.00', '8', '56.25', '16', '60.53', '48', '57.27', '1599025880', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('323', '131', '101', '', '0', '96.0', '96.00', '1', '100.00', '2', '97.37', '5', '96.36', '1599025880', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('324', '132', '101', '', '0', '10.0', '10.00', '16', '6.25', '34', '13.16', '96', '13.64', '1599025880', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('325', '133', '101', '', '0', '13.0', '13.00', '15', '12.50', '31', '21.05', '93', '16.36', '1599025880', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('326', '134', '101', '', '0', '96.0', '96.00', '1', '100.00', '2', '97.37', '5', '96.36', '1599025880', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('327', '97', '102', '', '0', '41.0', '41.00', '14', '40.91', '23', '42.11', '61', '45.45', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('328', '98', '102', '', '0', '74.0', '74.00', '7', '72.73', '10', '76.32', '25', '78.18', '1599025880', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('329', '99', '102', '', '0', '49.0', '49.00', '10', '59.09', '19', '52.63', '52', '53.64', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('330', '100', '102', '', '0', '27.0', '27.00', '17', '27.27', '28', '28.95', '75', '32.73', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('331', '101', '102', '', '0', '85.0', '85.00', '4', '86.36', '4', '92.11', '10', '91.82', '1599025880', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('332', '102', '102', '', '0', '67.0', '67.00', '8', '68.18', '12', '71.05', '34', '70.00', '1599025880', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('333', '103', '102', '', '0', '18.0', '18.00', '19', '18.18', '32', '18.42', '90', '19.09', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('334', '104', '102', '', '0', '99.0', '99.00', '1', '100.00', '1', '100.00', '1', '100.00', '1599025880', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('335', '105', '102', '', '0', '31.0', '31.00', '15', '36.36', '26', '34.21', '71', '36.36', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('336', '106', '102', '', '0', '20.0', '20.00', '18', '22.73', '30', '23.68', '87', '21.82', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('337', '107', '102', '', '0', '8.0', '8.00', '21', '9.09', '36', '7.89', '104', '6.36', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('338', '108', '102', '', '0', '67.0', '67.00', '8', '68.18', '12', '71.05', '34', '70.00', '1599025880', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('339', '109', '102', '', '0', '95.0', '95.00', '2', '95.45', '2', '97.37', '3', '98.18', '1599025880', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('340', '110', '102', '', '0', '45.0', '45.00', '12', '50.00', '21', '47.37', '56', '50.00', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('341', '111', '102', '', '0', '45.0', '45.00', '12', '50.00', '21', '47.37', '56', '50.00', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('342', '112', '102', '', '0', '6.0', '6.00', '22', '4.55', '38', '2.63', '106', '4.55', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('343', '113', '102', '', '0', '85.0', '85.00', '4', '86.36', '4', '92.11', '10', '91.82', '1599025880', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('344', '114', '102', '', '0', '87.0', '87.00', '3', '90.91', '3', '94.74', '8', '93.64', '1599025880', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('345', '115', '102', '', '0', '31.0', '31.00', '15', '36.36', '26', '34.21', '71', '36.36', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('346', '116', '102', '', '0', '18.0', '18.00', '19', '18.18', '32', '18.42', '90', '19.09', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('347', '117', '102', '', '0', '47.0', '47.00', '11', '54.55', '20', '50.00', '53', '52.73', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('348', '118', '102', '', '0', '79.0', '79.00', '6', '77.27', '7', '84.21', '21', '81.82', '1599025880', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('349', '119', '102', '', '0', '57.0', '57.00', '7', '62.50', '16', '60.53', '43', '61.82', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('350', '120', '102', '', '0', '66.0', '66.00', '5', '75.00', '14', '65.79', '36', '68.18', '1599025880', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('351', '121', '102', '', '0', '19.0', '19.00', '13', '25.00', '31', '21.05', '88', '20.91', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('352', '122', '102', '', '0', '41.0', '41.00', '10', '43.75', '23', '42.11', '61', '45.45', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('353', '123', '102', '', '0', '18.0', '18.00', '14', '18.75', '32', '18.42', '90', '19.09', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('354', '124', '102', '', '0', '7.0', '7.00', '16', '6.25', '37', '5.26', '105', '5.45', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('355', '125', '102', '', '0', '81.0', '81.00', '1', '100.00', '6', '86.84', '18', '84.55', '1599025880', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('356', '126', '102', '', '0', '72.0', '72.00', '4', '81.25', '11', '73.68', '29', '74.55', '1599025880', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('357', '127', '102', '', '0', '77.0', '77.00', '3', '87.50', '9', '78.95', '23', '80.00', '1599025880', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('358', '128', '102', '', '0', '27.0', '27.00', '12', '31.25', '28', '28.95', '75', '32.73', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('359', '129', '102', '', '0', '50.0', '50.00', '9', '50.00', '18', '55.26', '51', '54.55', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('360', '130', '102', '', '0', '78.0', '78.00', '2', '93.75', '8', '81.58', '22', '80.91', '1599025880', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('361', '131', '102', '', '0', '40.0', '40.00', '11', '37.50', '25', '36.84', '65', '41.82', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('362', '132', '102', '', '0', '16.0', '16.00', '15', '12.50', '35', '10.53', '94', '15.45', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('363', '133', '102', '', '0', '55.0', '55.00', '8', '56.25', '17', '57.89', '46', '59.09', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('364', '134', '102', '', '0', '63.0', '63.00', '6', '68.75', '15', '63.16', '38', '66.36', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('365', '97', '103', '', '0', '47.0', '47.00', '11', '54.55', '20', '50.00', '57', '49.09', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('366', '98', '103', '', '0', '51.0', '51.00', '9', '63.64', '16', '60.53', '48', '57.27', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('367', '99', '103', '', '0', '17.0', '17.00', '19', '18.18', '32', '18.42', '91', '18.18', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('368', '100', '103', '', '0', '11.0', '11.00', '21', '9.09', '34', '13.16', '99', '10.91', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('369', '101', '103', '', '0', '83.0', '83.00', '1', '100.00', '2', '97.37', '12', '90.00', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('370', '102', '103', '', '0', '26.0', '26.00', '16', '31.82', '28', '28.95', '82', '26.36', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('371', '103', '103', '', '0', '31.0', '31.00', '14', '40.91', '24', '39.47', '76', '31.82', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('372', '104', '103', '', '0', '70.0', '70.00', '3', '90.91', '8', '81.58', '29', '74.55', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('373', '105', '103', '', '0', '80.0', '80.00', '2', '95.45', '3', '94.74', '14', '88.18', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('374', '106', '103', '', '0', '55.0', '55.00', '7', '72.73', '14', '65.79', '43', '61.82', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('375', '107', '103', '', '0', '8.0', '8.00', '22', '4.55', '35', '10.53', '101', '9.09', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('376', '108', '103', '', '0', '58.0', '58.00', '5', '81.82', '12', '71.05', '39', '65.45', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('377', '109', '103', '', '0', '39.0', '39.00', '13', '45.45', '22', '44.74', '66', '40.91', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('378', '110', '103', '', '0', '24.0', '24.00', '17', '27.27', '29', '26.32', '84', '24.55', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('379', '111', '103', '', '0', '48.0', '48.00', '10', '59.09', '19', '52.63', '54', '51.82', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('380', '112', '103', '', '0', '57.0', '57.00', '6', '77.27', '13', '68.42', '42', '62.73', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('381', '113', '103', '', '0', '53.0', '53.00', '8', '68.18', '15', '63.16', '46', '59.09', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('382', '114', '103', '', '0', '42.0', '42.00', '12', '50.00', '21', '47.37', '61', '45.45', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('383', '115', '103', '', '0', '13.0', '13.00', '20', '13.64', '33', '15.79', '96', '13.64', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('384', '116', '103', '', '0', '65.0', '65.00', '4', '86.36', '9', '78.95', '31', '72.73', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('385', '117', '103', '', '0', '30.0', '30.00', '15', '36.36', '26', '34.21', '78', '30.00', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('386', '118', '103', '', '0', '21.0', '21.00', '18', '22.73', '30', '23.68', '87', '21.82', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('387', '119', '103', '', '0', '74.0', '74.00', '3', '87.50', '5', '89.47', '23', '80.00', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('388', '120', '103', '', '0', '8.0', '8.00', '14', '18.75', '35', '10.53', '101', '9.09', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('389', '121', '103', '', '0', '27.0', '27.00', '12', '31.25', '27', '31.58', '80', '28.18', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('390', '122', '103', '', '0', '4.0', '4.00', '15', '12.50', '37', '5.26', '106', '4.55', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('391', '123', '103', '', '0', '51.0', '51.00', '8', '56.25', '16', '60.53', '48', '57.27', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('392', '124', '103', '', '0', '75.0', '75.00', '2', '93.75', '4', '92.11', '21', '81.82', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('393', '125', '103', '', '0', '50.0', '50.00', '9', '50.00', '18', '55.26', '51', '54.55', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('394', '126', '103', '', '0', '73.0', '73.00', '4', '81.25', '6', '86.84', '26', '77.27', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('395', '127', '103', '', '0', '71.0', '71.00', '5', '75.00', '7', '84.21', '28', '75.45', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('396', '128', '103', '', '0', '36.0', '36.00', '10', '43.75', '23', '42.11', '69', '38.18', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('397', '129', '103', '', '0', '59.0', '59.00', '7', '62.50', '11', '73.68', '36', '68.18', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('398', '130', '103', '', '0', '20.0', '20.00', '13', '25.00', '31', '21.05', '88', '20.91', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('399', '131', '103', '', '0', '3.0', '3.00', '16', '6.25', '38', '2.63', '107', '3.64', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('400', '132', '103', '', '0', '96.0', '96.00', '1', '100.00', '1', '100.00', '4', '97.27', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('401', '133', '103', '', '0', '61.0', '61.00', '6', '68.75', '10', '76.32', '34', '70.00', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('402', '134', '103', '', '0', '31.0', '31.00', '11', '37.50', '24', '39.47', '76', '31.82', '1599025880', '1599030232', '', '1');
INSERT INTO `cj_chengji` VALUES ('403', '135', '101', '', '0', '21.0', '21.00', '8', '30.00', '8', '30.00', '29', '17.65', '1599025883', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('404', '136', '101', '', '0', '32.0', '32.00', '7', '40.00', '7', '40.00', '27', '23.53', '1599025883', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('405', '137', '101', '', '0', '20.0', '20.00', '9', '20.00', '9', '20.00', '30', '14.71', '1599025883', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('406', '138', '101', '', '0', '93.0', '93.00', '1', '100.00', '1', '100.00', '4', '91.18', '1599025883', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('407', '139', '101', '', '0', '3.0', '3.00', '10', '10.00', '10', '10.00', '33', '5.88', '1599025883', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('408', '140', '101', '', '0', '56.0', '56.00', '5', '60.00', '5', '60.00', '17', '52.94', '1599025883', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('409', '141', '101', '', '0', '61.0', '61.00', '3', '80.00', '3', '80.00', '14', '61.76', '1599025883', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('410', '142', '101', '', '0', '58.0', '58.00', '4', '70.00', '4', '70.00', '15', '58.82', '1599025883', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('411', '143', '101', '', '0', '33.0', '33.00', '6', '50.00', '6', '50.00', '26', '26.47', '1599025883', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('412', '144', '101', '', '0', '90.0', '90.00', '2', '90.00', '2', '90.00', '6', '85.29', '1599025883', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('413', '135', '102', '', '0', '22.0', '22.00', '8', '30.00', '8', '30.00', '28', '20.59', '1599025883', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('414', '136', '102', '', '0', '71.0', '71.00', '3', '80.00', '3', '80.00', '11', '70.59', '1599025883', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('415', '137', '102', '', '0', '3.0', '3.00', '9', '20.00', '9', '20.00', '32', '8.82', '1599025883', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('416', '138', '102', '', '0', '50.0', '50.00', '7', '40.00', '7', '40.00', '21', '41.18', '1599025883', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('417', '139', '102', '', '0', '3.0', '3.00', '9', '20.00', '9', '20.00', '32', '8.82', '1599025883', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('418', '140', '102', '', '0', '68.0', '68.00', '5', '60.00', '5', '60.00', '14', '61.76', '1599025883', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('419', '141', '102', '', '0', '57.0', '57.00', '6', '50.00', '6', '50.00', '19', '47.06', '1599025883', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('420', '142', '102', '', '0', '92.0', '92.00', '1', '100.00', '1', '100.00', '6', '85.29', '1599025883', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('421', '143', '102', '', '0', '69.0', '69.00', '4', '70.00', '4', '70.00', '13', '64.71', '1599025883', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('422', '144', '102', '', '0', '77.0', '77.00', '2', '90.00', '2', '90.00', '8', '79.41', '1599025883', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('423', '135', '103', '', '0', '14.0', '14.00', '8', '30.00', '8', '30.00', '29', '17.65', '1599025883', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('424', '136', '103', '', '0', '79.0', '79.00', '1', '100.00', '1', '100.00', '6', '85.29', '1599025883', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('425', '137', '103', '', '0', '62.0', '62.00', '2', '90.00', '2', '90.00', '14', '61.76', '1599025883', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('426', '138', '103', '', '0', '9.0', '9.00', '10', '10.00', '10', '10.00', '31', '11.76', '1599025883', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('427', '139', '103', '', '0', '37.0', '37.00', '6', '50.00', '6', '50.00', '24', '32.35', '1599025883', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('428', '140', '103', '', '0', '12.0', '12.00', '9', '20.00', '9', '20.00', '30', '14.71', '1599025883', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('429', '141', '103', '', '0', '43.0', '43.00', '5', '60.00', '5', '60.00', '23', '35.29', '1599025883', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('430', '142', '103', '', '0', '53.0', '53.00', '3', '80.00', '3', '80.00', '19', '47.06', '1599025883', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('431', '143', '103', '', '0', '23.0', '23.00', '7', '40.00', '7', '40.00', '25', '29.41', '1599025883', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('432', '144', '103', '', '0', '45.0', '45.00', '4', '70.00', '4', '70.00', '22', '38.24', '1599025883', '1599030231', '', '1');
INSERT INTO `cj_chengji` VALUES ('433', '145', '101', '', '0', '66.0', '66.00', '3', '90.91', '25', '66.67', '32', '71.82', '1599027007', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('434', '146', '101', '', '0', '18.0', '18.00', '19', '18.18', '62', '15.28', '89', '20.00', '1599027007', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('435', '147', '101', '', '0', '98.0', '98.00', '2', '95.45', '3', '97.22', '4', '97.27', '1599027007', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('436', '148', '101', '', '0', '9.0', '9.00', '20', '13.64', '66', '9.72', '98', '11.82', '1599027007', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('437', '149', '101', '', '0', '39.0', '39.00', '9', '63.64', '43', '41.67', '64', '42.73', '1599027007', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('438', '150', '101', '', '0', '66.0', '66.00', '3', '90.91', '25', '66.67', '32', '71.82', '1599027007', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('439', '151', '101', '', '0', '63.0', '63.00', '5', '81.82', '27', '63.89', '34', '70.00', '1599027007', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('440', '152', '101', '', '0', '47.0', '47.00', '8', '68.18', '37', '50.00', '56', '50.00', '1599027007', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('441', '153', '101', '', '0', '2.0', '2.00', '22', '4.55', '70', '4.17', '108', '2.73', '1599027007', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('442', '154', '101', '', '0', '21.0', '21.00', '18', '22.73', '61', '16.67', '87', '21.82', '1599027007', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('443', '155', '101', '', '0', '7.0', '7.00', '21', '9.09', '68', '6.94', '104', '6.36', '1599027007', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('444', '156', '101', '', '0', '24.0', '24.00', '17', '27.27', '60', '18.06', '86', '22.73', '1599027007', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('445', '157', '101', '', '0', '36.0', '36.00', '11', '54.55', '48', '34.72', '71', '36.36', '1599027007', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('446', '158', '101', '', '0', '61.0', '61.00', '6', '77.27', '28', '62.50', '38', '66.36', '1599027007', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('447', '159', '101', '', '0', '38.0', '38.00', '10', '59.09', '44', '40.28', '65', '41.82', '1599027007', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('448', '160', '101', '', '0', '26.0', '26.00', '16', '31.82', '59', '19.44', '85', '23.64', '1599027007', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('449', '161', '101', '', '0', '33.0', '33.00', '12', '50.00', '53', '27.78', '76', '31.82', '1599027007', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('450', '162', '101', '', '0', '29.0', '29.00', '15', '36.36', '57', '22.22', '82', '26.36', '1599027007', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('451', '163', '101', '', '0', '99.0', '99.00', '1', '100.00', '1', '100.00', '2', '99.09', '1599027007', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('452', '164', '101', '', '0', '33.0', '33.00', '12', '50.00', '53', '27.78', '76', '31.82', '1599027007', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('453', '165', '101', '', '0', '30.0', '30.00', '14', '40.91', '55', '25.00', '80', '28.18', '1599027007', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('454', '166', '101', '', '0', '53.0', '53.00', '7', '72.73', '32', '56.94', '48', '57.27', '1599027007', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('455', '167', '101', '', '0', '75.0', '75.00', '4', '81.25', '18', '76.39', '22', '80.91', '1599027007', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('456', '168', '101', '', '0', '2.0', '2.00', '15', '12.50', '70', '4.17', '108', '2.73', '1599027007', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('457', '169', '101', '', '0', '42.0', '42.00', '8', '56.25', '38', '48.61', '58', '48.18', '1599027007', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('458', '170', '101', '', '0', '1.0', '1.00', '16', '6.25', '72', '1.39', '110', '0.91', '1599027007', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('459', '171', '101', '', '0', '36.0', '36.00', '11', '37.50', '48', '34.72', '71', '36.36', '1599027007', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('460', '172', '101', '', '0', '74.0', '74.00', '5', '75.00', '19', '75.00', '23', '80.00', '1599027007', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('461', '173', '101', '', '0', '13.0', '13.00', '14', '18.75', '65', '11.11', '95', '14.55', '1599027007', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('462', '174', '101', '', '0', '83.0', '83.00', '3', '87.50', '13', '83.33', '15', '87.27', '1599027007', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('463', '175', '101', '', '0', '52.0', '52.00', '7', '62.50', '35', '52.78', '52', '53.64', '1599027007', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('464', '176', '101', '', '0', '94.0', '94.00', '2', '93.75', '5', '94.44', '6', '95.45', '1599027007', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('465', '177', '101', '', '0', '37.0', '37.00', '10', '43.75', '46', '37.50', '68', '39.09', '1599027007', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('466', '178', '101', '', '0', '16.0', '16.00', '13', '25.00', '63', '13.89', '92', '17.27', '1599027007', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('467', '179', '101', '', '0', '42.0', '42.00', '8', '56.25', '38', '48.61', '58', '48.18', '1599027007', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('468', '180', '101', '', '0', '99.0', '99.00', '1', '100.00', '1', '100.00', '2', '99.09', '1599027007', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('469', '181', '101', '', '0', '53.0', '53.00', '6', '68.75', '32', '56.94', '48', '57.27', '1599027007', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('470', '182', '101', '', '0', '34.0', '34.00', '12', '31.25', '50', '31.94', '73', '34.55', '1599027007', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('471', '183', '101', '', '0', '52.0', '52.00', '22', '38.24', '35', '52.78', '52', '53.64', '1599027007', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('472', '184', '101', '', '0', '53.0', '53.00', '21', '41.18', '32', '56.94', '48', '57.27', '1599027007', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('473', '185', '101', '', '0', '81.0', '81.00', '9', '76.47', '14', '81.94', '16', '86.36', '1599027007', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('474', '186', '101', '', '0', '3.0', '3.00', '34', '2.94', '69', '5.56', '107', '3.64', '1599027007', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('475', '187', '101', '', '0', '72.0', '72.00', '13', '64.71', '20', '73.61', '25', '78.18', '1599027007', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('476', '188', '101', '', '0', '68.0', '68.00', '16', '55.88', '23', '69.44', '29', '74.55', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('477', '189', '101', '', '0', '15.0', '15.00', '32', '8.82', '64', '12.50', '93', '16.36', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('478', '190', '101', '', '0', '70.0', '70.00', '15', '58.82', '22', '70.83', '28', '75.45', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('479', '191', '101', '', '0', '38.0', '38.00', '26', '26.47', '44', '40.28', '65', '41.82', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('480', '192', '101', '', '0', '34.0', '34.00', '28', '20.59', '50', '31.94', '73', '34.55', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('481', '193', '101', '', '0', '92.0', '92.00', '4', '91.18', '8', '90.28', '9', '92.73', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('482', '194', '101', '', '0', '27.0', '27.00', '31', '11.76', '58', '20.83', '83', '25.45', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('483', '195', '101', '', '0', '80.0', '80.00', '11', '70.59', '16', '79.17', '19', '83.64', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('484', '196', '101', '', '0', '42.0', '42.00', '23', '35.29', '38', '48.61', '58', '48.18', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('485', '197', '101', '', '0', '87.0', '87.00', '7', '82.35', '11', '86.11', '13', '89.09', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('486', '198', '101', '', '0', '68.0', '68.00', '16', '55.88', '23', '69.44', '29', '74.55', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('487', '199', '101', '', '0', '56.0', '56.00', '19', '47.06', '30', '59.72', '42', '62.73', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('488', '200', '101', '', '0', '34.0', '34.00', '28', '20.59', '50', '31.94', '73', '34.55', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('489', '201', '101', '', '0', '81.0', '81.00', '9', '76.47', '14', '81.94', '16', '86.36', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('490', '202', '101', '', '0', '93.0', '93.00', '2', '97.06', '6', '93.06', '7', '94.55', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('491', '203', '101', '', '0', '78.0', '78.00', '12', '67.65', '17', '77.78', '20', '82.73', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('492', '204', '101', '', '0', '91.0', '91.00', '6', '85.29', '10', '87.50', '11', '90.91', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('493', '205', '101', '', '0', '41.0', '41.00', '25', '29.41', '42', '43.06', '62', '44.55', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('494', '206', '101', '', '0', '37.0', '37.00', '27', '23.53', '46', '37.50', '68', '39.09', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('495', '207', '101', '', '0', '30.0', '30.00', '30', '14.71', '55', '25.00', '80', '28.18', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('496', '208', '101', '', '0', '93.0', '93.00', '2', '97.06', '6', '93.06', '7', '94.55', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('497', '209', '101', '', '0', '60.0', '60.00', '18', '50.00', '29', '61.11', '40', '64.55', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('498', '210', '101', '', '0', '71.0', '71.00', '14', '61.76', '21', '72.22', '27', '76.36', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('499', '211', '101', '', '0', '55.0', '55.00', '20', '44.12', '31', '58.33', '44', '60.91', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('500', '212', '101', '', '0', '92.0', '92.00', '4', '91.18', '8', '90.28', '9', '92.73', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('501', '213', '101', '', '0', '98.0', '98.00', '1', '100.00', '3', '97.22', '4', '97.27', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('502', '214', '101', '', '0', '42.0', '42.00', '23', '35.29', '38', '48.61', '58', '48.18', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('503', '215', '101', '', '0', '9.0', '9.00', '33', '5.88', '66', '9.72', '98', '11.82', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('504', '216', '101', '', '0', '86.0', '86.00', '8', '79.41', '12', '84.72', '14', '88.18', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('505', '145', '102', '', '0', '82.0', '82.00', '4', '86.36', '10', '87.50', '16', '86.36', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('506', '146', '102', '', '0', '48.0', '48.00', '11', '54.55', '38', '48.61', '58', '48.18', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('507', '147', '102', '', '0', '91.0', '91.00', '2', '95.45', '4', '95.83', '8', '93.64', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('508', '148', '102', '', '0', '77.0', '77.00', '5', '81.82', '13', '83.33', '21', '81.82', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('509', '149', '102', '', '0', '26.0', '26.00', '17', '27.27', '54', '26.39', '82', '26.36', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('510', '150', '102', '', '0', '65.0', '65.00', '8', '68.18', '22', '70.83', '33', '70.91', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('511', '151', '102', '', '0', '73.0', '73.00', '7', '72.73', '17', '77.78', '26', '77.27', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('512', '152', '102', '', '0', '3.0', '3.00', '19', '18.18', '67', '8.33', '104', '6.36', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('513', '153', '102', '', '0', '61.0', '61.00', '9', '63.64', '26', '65.28', '38', '66.36', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('514', '154', '102', '', '0', '75.0', '75.00', '6', '77.27', '15', '80.56', '23', '80.00', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('515', '155', '102', '', '0', '1.0', '1.00', '22', '4.55', '71', '2.78', '108', '2.73', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('516', '156', '102', '', '0', '84.0', '84.00', '3', '90.91', '9', '88.89', '14', '88.18', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('517', '157', '102', '', '0', '37.0', '37.00', '13', '45.45', '44', '40.28', '67', '40.00', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('518', '158', '102', '', '0', '35.0', '35.00', '15', '36.36', '48', '34.72', '73', '34.55', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('519', '159', '102', '', '0', '2.0', '2.00', '21', '9.09', '70', '4.17', '107', '3.64', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('520', '160', '102', '', '0', '44.0', '44.00', '12', '50.00', '40', '45.83', '63', '43.64', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('521', '161', '102', '', '0', '36.0', '36.00', '14', '40.91', '46', '37.50', '70', '37.27', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('522', '162', '102', '', '0', '3.0', '3.00', '19', '18.18', '67', '8.33', '104', '6.36', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('523', '163', '102', '', '0', '28.0', '28.00', '16', '31.82', '53', '27.78', '81', '27.27', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('524', '164', '102', '', '0', '5.0', '5.00', '18', '22.73', '66', '9.72', '101', '9.09', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('525', '165', '102', '', '0', '100.0', '100.00', '1', '100.00', '1', '100.00', '1', '100.00', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('526', '166', '102', '', '0', '49.0', '49.00', '10', '59.09', '35', '52.78', '54', '51.82', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('527', '167', '102', '', '0', '65.0', '65.00', '5', '75.00', '22', '70.83', '33', '70.91', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('528', '168', '102', '', '0', '72.0', '72.00', '4', '81.25', '18', '76.39', '27', '76.36', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('529', '169', '102', '', '0', '32.0', '32.00', '12', '31.25', '52', '29.17', '77', '30.91', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('530', '170', '102', '', '0', '81.0', '81.00', '3', '87.50', '11', '86.11', '17', '85.45', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('531', '171', '102', '', '0', '34.0', '34.00', '10', '43.75', '50', '31.94', '75', '32.73', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('532', '172', '102', '', '0', '100.0', '100.00', '1', '100.00', '1', '100.00', '1', '100.00', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('533', '173', '102', '', '0', '91.0', '91.00', '2', '93.75', '4', '95.83', '8', '93.64', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('534', '174', '102', '', '0', '22.0', '22.00', '14', '18.75', '58', '20.83', '88', '20.91', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('535', '175', '102', '', '0', '36.0', '36.00', '9', '50.00', '46', '37.50', '70', '37.27', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('536', '176', '102', '', '0', '25.0', '25.00', '13', '25.00', '56', '23.61', '84', '24.55', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('537', '177', '102', '', '0', '3.0', '3.00', '16', '6.25', '67', '8.33', '104', '6.36', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('538', '178', '102', '', '0', '6.0', '6.00', '15', '12.50', '65', '11.11', '99', '10.91', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('539', '179', '102', '', '0', '59.0', '59.00', '6', '68.75', '30', '59.72', '44', '60.91', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('540', '180', '102', '', '0', '49.0', '49.00', '7', '62.50', '35', '52.78', '54', '51.82', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('541', '181', '102', '', '0', '33.0', '33.00', '11', '37.50', '51', '30.56', '76', '31.82', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('542', '182', '102', '', '0', '48.0', '48.00', '8', '56.25', '38', '48.61', '58', '48.18', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('543', '183', '102', '', '0', '43.0', '43.00', '22', '38.24', '42', '43.06', '65', '41.82', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('544', '184', '102', '', '0', '72.0', '72.00', '8', '79.41', '18', '76.39', '27', '76.36', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('545', '185', '102', '', '0', '59.0', '59.00', '16', '55.88', '30', '59.72', '44', '60.91', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('546', '186', '102', '', '0', '16.0', '16.00', '31', '11.76', '62', '15.28', '94', '15.45', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('547', '187', '102', '', '0', '51.0', '51.00', '19', '47.06', '34', '54.17', '51', '54.55', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('548', '188', '102', '', '0', '86.0', '86.00', '3', '94.12', '7', '91.67', '12', '90.00', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('549', '189', '102', '', '0', '54.0', '54.00', '18', '50.00', '33', '55.56', '49', '56.36', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('550', '190', '102', '', '0', '21.0', '21.00', '28', '20.59', '59', '19.44', '89', '20.00', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('551', '191', '102', '', '0', '79.0', '79.00', '5', '88.24', '12', '84.72', '19', '83.64', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('552', '192', '102', '', '0', '35.0', '35.00', '25', '29.41', '48', '34.72', '73', '34.55', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('553', '193', '102', '', '0', '68.0', '68.00', '10', '73.53', '21', '72.22', '32', '71.82', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('554', '194', '102', '', '0', '37.0', '37.00', '24', '32.35', '44', '40.28', '67', '40.00', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('555', '195', '102', '', '0', '60.0', '60.00', '13', '64.71', '27', '63.89', '39', '65.45', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('556', '196', '102', '', '0', '63.0', '63.00', '11', '70.59', '24', '68.06', '35', '69.09', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('557', '197', '102', '', '0', '23.0', '23.00', '27', '23.53', '57', '22.22', '86', '22.73', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('558', '198', '102', '', '0', '17.0', '17.00', '30', '14.71', '61', '16.67', '92', '17.27', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('559', '199', '102', '', '0', '26.0', '26.00', '26', '26.47', '54', '26.39', '82', '26.36', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('560', '200', '102', '', '0', '11.0', '11.00', '32', '8.82', '63', '13.89', '96', '13.64', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('561', '201', '102', '', '0', '95.0', '95.00', '1', '100.00', '3', '97.22', '5', '96.36', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('562', '202', '102', '', '0', '74.0', '74.00', '7', '82.35', '16', '79.17', '24', '79.09', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('563', '203', '102', '', '0', '7.0', '7.00', '33', '5.88', '64', '12.50', '97', '12.73', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('564', '204', '102', '', '0', '57.0', '57.00', '17', '52.94', '32', '56.94', '47', '58.18', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('565', '205', '102', '', '0', '1.0', '1.00', '34', '2.94', '71', '2.78', '108', '2.73', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('566', '206', '102', '', '0', '71.0', '71.00', '9', '76.47', '20', '73.61', '29', '74.55', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('567', '207', '102', '', '0', '49.0', '49.00', '20', '44.12', '35', '52.78', '54', '51.82', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('568', '208', '102', '', '0', '86.0', '86.00', '3', '94.12', '7', '91.67', '12', '90.00', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('569', '209', '102', '', '0', '90.0', '90.00', '2', '97.06', '6', '93.06', '10', '91.82', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('570', '210', '102', '', '0', '76.0', '76.00', '6', '85.29', '14', '81.94', '22', '80.91', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('571', '211', '102', '', '0', '60.0', '60.00', '13', '64.71', '27', '63.89', '39', '65.45', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('572', '212', '102', '', '0', '19.0', '19.00', '29', '17.65', '60', '18.06', '90', '19.09', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('573', '213', '102', '', '0', '39.0', '39.00', '23', '35.29', '43', '41.67', '66', '40.91', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('574', '214', '102', '', '0', '60.0', '60.00', '13', '64.71', '27', '63.89', '39', '65.45', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('575', '215', '102', '', '0', '63.0', '63.00', '11', '70.59', '24', '68.06', '35', '69.09', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('576', '216', '102', '', '0', '44.0', '44.00', '21', '41.18', '40', '45.83', '63', '43.64', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('577', '145', '103', '', '0', '81.0', '81.00', '2', '95.45', '16', '79.17', '23', '80.00', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('578', '146', '103', '', '0', '87.0', '87.00', '1', '100.00', '13', '83.33', '18', '84.55', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('579', '147', '103', '', '0', '2.0', '2.00', '21', '9.09', '70', '4.17', '107', '3.64', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('580', '148', '103', '', '0', '59.0', '59.00', '7', '72.73', '30', '59.72', '43', '61.82', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('581', '149', '103', '', '0', '74.0', '74.00', '5', '81.82', '20', '73.61', '28', '75.45', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('582', '150', '103', '', '0', '34.0', '34.00', '14', '40.91', '50', '31.94', '73', '34.55', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('583', '151', '103', '', '0', '36.0', '36.00', '13', '45.45', '48', '34.72', '69', '38.18', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('584', '152', '103', '', '0', '38.0', '38.00', '12', '50.00', '47', '36.11', '65', '41.82', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('585', '153', '103', '', '0', '28.0', '28.00', '15', '36.36', '52', '29.17', '77', '30.91', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('586', '154', '103', '', '0', '45.0', '45.00', '11', '54.55', '45', '38.89', '61', '45.45', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('587', '155', '103', '', '0', '51.0', '51.00', '9', '63.64', '40', '45.83', '55', '50.91', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('588', '156', '103', '', '0', '54.0', '54.00', '8', '68.18', '36', '51.39', '51', '54.55', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('589', '157', '103', '', '0', '24.0', '24.00', '17', '27.27', '56', '23.61', '81', '27.27', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('590', '158', '103', '', '0', '46.0', '46.00', '10', '59.09', '44', '40.28', '59', '47.27', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('591', '159', '103', '', '0', '26.0', '26.00', '16', '31.82', '55', '25.00', '80', '28.18', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('592', '160', '103', '', '0', '15.0', '15.00', '19', '18.18', '63', '13.89', '92', '17.27', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('593', '161', '103', '', '0', '67.0', '67.00', '6', '77.27', '26', '65.28', '37', '67.27', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('594', '162', '103', '', '0', '0.0', '0.00', '22', '4.55', '71', '2.78', '109', '1.82', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('595', '163', '103', '', '0', '80.0', '80.00', '3', '90.91', '18', '76.39', '25', '78.18', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('596', '164', '103', '', '0', '22.0', '22.00', '18', '22.73', '58', '20.83', '84', '24.55', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('597', '165', '103', '', '0', '8.0', '8.00', '20', '13.64', '67', '8.33', '101', '9.09', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('598', '166', '103', '', '0', '78.0', '78.00', '4', '86.36', '19', '75.00', '26', '77.27', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('599', '167', '103', '', '0', '67.0', '67.00', '7', '62.50', '26', '65.28', '37', '67.27', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('600', '168', '103', '', '0', '70.0', '70.00', '6', '68.75', '23', '69.44', '32', '71.82', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('601', '169', '103', '', '0', '53.0', '53.00', '11', '37.50', '37', '50.00', '52', '53.64', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('602', '170', '103', '', '0', '97.0', '97.00', '1', '100.00', '2', '98.61', '3', '98.18', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('603', '171', '103', '', '0', '96.0', '96.00', '2', '93.75', '3', '97.22', '4', '97.27', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('604', '172', '103', '', '0', '94.0', '94.00', '3', '87.50', '4', '95.83', '6', '95.45', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('605', '173', '103', '', '0', '20.0', '20.00', '14', '18.75', '60', '18.06', '87', '21.82', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('606', '174', '103', '', '0', '18.0', '18.00', '15', '12.50', '61', '16.67', '89', '20.00', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('607', '175', '103', '', '0', '90.0', '90.00', '4', '81.25', '8', '90.28', '11', '90.91', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('608', '176', '103', '', '0', '72.0', '72.00', '5', '75.00', '22', '70.83', '30', '73.64', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('609', '177', '103', '', '0', '57.0', '57.00', '9', '50.00', '33', '55.56', '46', '59.09', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('610', '178', '103', '', '0', '14.0', '14.00', '16', '6.25', '64', '12.50', '94', '15.45', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('611', '179', '103', '', '0', '23.0', '23.00', '13', '25.00', '57', '22.22', '83', '25.45', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('612', '180', '103', '', '0', '66.0', '66.00', '8', '56.25', '28', '62.50', '39', '65.45', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('613', '181', '103', '', '0', '56.0', '56.00', '10', '43.75', '35', '52.78', '48', '57.27', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('614', '182', '103', '', '0', '36.0', '36.00', '12', '31.25', '48', '34.72', '69', '38.18', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('615', '183', '103', '', '0', '13.0', '13.00', '30', '14.71', '65', '11.11', '95', '14.55', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('616', '184', '103', '', '0', '52.0', '52.00', '19', '47.06', '38', '48.61', '53', '52.73', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('617', '185', '103', '', '0', '49.0', '49.00', '21', '41.18', '41', '44.44', '56', '50.00', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('618', '186', '103', '', '0', '34.0', '34.00', '25', '29.41', '50', '31.94', '73', '34.55', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('619', '187', '103', '', '0', '52.0', '52.00', '19', '47.06', '38', '48.61', '53', '52.73', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('620', '188', '103', '', '0', '27.0', '27.00', '27', '23.53', '54', '26.39', '79', '29.09', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('621', '189', '103', '', '0', '99.0', '99.00', '1', '100.00', '1', '100.00', '2', '99.09', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('622', '190', '103', '', '0', '70.0', '70.00', '13', '64.71', '23', '69.44', '32', '71.82', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('623', '191', '103', '', '0', '47.0', '47.00', '23', '35.29', '43', '41.67', '58', '48.18', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('624', '192', '103', '', '0', '4.0', '4.00', '32', '8.82', '68', '6.94', '104', '6.36', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('625', '193', '103', '', '0', '22.0', '22.00', '28', '20.59', '58', '20.83', '84', '24.55', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('626', '194', '103', '', '0', '93.0', '93.00', '3', '94.12', '6', '93.06', '8', '93.64', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('627', '195', '103', '', '0', '17.0', '17.00', '29', '17.65', '62', '15.28', '91', '18.18', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('628', '196', '103', '', '0', '91.0', '91.00', '4', '91.18', '7', '91.67', '10', '91.82', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('629', '197', '103', '', '0', '94.0', '94.00', '2', '97.06', '4', '95.83', '6', '95.45', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('630', '198', '103', '', '0', '89.0', '89.00', '5', '88.24', '9', '88.89', '13', '89.09', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('631', '199', '103', '', '0', '86.0', '86.00', '10', '73.53', '15', '80.56', '20', '82.73', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('632', '200', '103', '', '0', '49.0', '49.00', '21', '41.18', '41', '44.44', '56', '50.00', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('633', '201', '103', '', '0', '59.0', '59.00', '16', '55.88', '30', '59.72', '43', '61.82', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('634', '202', '103', '', '0', '57.0', '57.00', '18', '50.00', '33', '55.56', '46', '59.09', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('635', '203', '103', '', '0', '3.0', '3.00', '33', '5.88', '69', '5.56', '105', '5.45', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('636', '204', '103', '', '0', '88.0', '88.00', '7', '82.35', '11', '86.11', '15', '87.27', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('637', '205', '103', '', '0', '39.0', '39.00', '24', '32.35', '46', '37.50', '64', '42.73', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('638', '206', '103', '', '0', '28.0', '28.00', '26', '26.47', '52', '29.17', '77', '30.91', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('639', '207', '103', '', '0', '58.0', '58.00', '17', '52.94', '32', '56.94', '45', '60.00', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('640', '208', '103', '', '0', '88.0', '88.00', '7', '82.35', '11', '86.11', '15', '87.27', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('641', '209', '103', '', '0', '0.0', '0.00', '34', '2.94', '71', '2.78', '109', '1.82', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('642', '210', '103', '', '0', '89.0', '89.00', '5', '88.24', '9', '88.89', '13', '89.09', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('643', '211', '103', '', '0', '11.0', '11.00', '31', '11.76', '66', '9.72', '98', '11.82', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('644', '212', '103', '', '0', '63.0', '63.00', '15', '58.82', '29', '61.11', '41', '63.64', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('645', '213', '103', '', '0', '81.0', '81.00', '11', '70.59', '16', '79.17', '23', '80.00', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('646', '214', '103', '', '0', '87.0', '87.00', '9', '76.47', '13', '83.33', '18', '84.55', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('647', '215', '103', '', '0', '68.0', '68.00', '14', '61.76', '25', '66.67', '36', '68.18', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('648', '216', '103', '', '0', '74.0', '74.00', '12', '67.65', '20', '73.61', '28', '75.45', '1599027008', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('649', '217', '101', '', '0', '71.0', '71.00', '10', '62.50', '10', '62.50', '11', '70.59', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('650', '218', '101', '', '0', '96.0', '96.00', '3', '91.67', '3', '91.67', '3', '94.12', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('651', '219', '101', '', '0', '79.0', '79.00', '7', '75.00', '7', '75.00', '8', '79.41', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('652', '220', '101', '', '0', '26.0', '26.00', '22', '12.50', '22', '12.50', '28', '20.59', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('653', '221', '101', '', '0', '67.0', '67.00', '11', '58.33', '11', '58.33', '14', '61.76', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('654', '222', '101', '', '0', '13.0', '13.00', '24', '4.17', '24', '4.17', '32', '8.82', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('655', '223', '101', '', '0', '58.0', '58.00', '15', '41.67', '15', '41.67', '19', '47.06', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('656', '224', '101', '', '0', '49.0', '49.00', '19', '25.00', '19', '25.00', '23', '35.29', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('657', '225', '101', '', '0', '97.0', '97.00', '1', '100.00', '1', '100.00', '1', '100.00', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('658', '226', '101', '', '0', '66.0', '66.00', '12', '54.17', '12', '54.17', '15', '58.82', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('659', '227', '101', '', '0', '61.0', '61.00', '14', '45.83', '14', '45.83', '18', '50.00', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('660', '228', '101', '', '0', '29.0', '29.00', '21', '16.67', '21', '16.67', '26', '26.47', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('661', '229', '101', '', '0', '54.0', '54.00', '17', '33.33', '17', '33.33', '21', '41.18', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('662', '230', '101', '', '0', '56.0', '56.00', '16', '37.50', '16', '37.50', '20', '44.12', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('663', '231', '101', '', '0', '84.0', '84.00', '5', '83.33', '5', '83.33', '6', '85.29', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('664', '232', '101', '', '0', '84.0', '84.00', '5', '83.33', '5', '83.33', '6', '85.29', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('665', '233', '101', '', '0', '23.0', '23.00', '23', '8.33', '23', '8.33', '29', '17.65', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('666', '234', '101', '', '0', '77.0', '77.00', '8', '70.83', '8', '70.83', '9', '76.47', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('667', '235', '101', '', '0', '72.0', '72.00', '9', '66.67', '9', '66.67', '10', '73.53', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('668', '236', '101', '', '0', '95.0', '95.00', '4', '87.50', '4', '87.50', '4', '91.18', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('669', '237', '101', '', '0', '97.0', '97.00', '1', '100.00', '1', '100.00', '1', '100.00', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('670', '238', '101', '', '0', '62.0', '62.00', '13', '50.00', '13', '50.00', '17', '52.94', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('671', '239', '101', '', '0', '51.0', '51.00', '18', '29.17', '18', '29.17', '22', '38.24', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('672', '240', '101', '', '0', '39.0', '39.00', '20', '20.83', '20', '20.83', '24', '32.35', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('673', '217', '102', '', '0', '77.0', '77.00', '6', '79.17', '6', '79.17', '9', '76.47', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('674', '218', '102', '', '0', '52.0', '52.00', '15', '41.67', '15', '41.67', '20', '44.12', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('675', '219', '102', '', '0', '68.0', '68.00', '9', '66.67', '9', '66.67', '12', '67.65', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('676', '220', '102', '', '0', '96.0', '96.00', '2', '95.83', '2', '95.83', '2', '97.06', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('677', '221', '102', '', '0', '86.0', '86.00', '3', '91.67', '3', '91.67', '4', '91.18', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('678', '222', '102', '', '0', '16.0', '16.00', '21', '16.67', '21', '16.67', '29', '17.65', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('679', '223', '102', '', '0', '66.0', '66.00', '10', '62.50', '10', '62.50', '14', '61.76', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('680', '224', '102', '', '0', '75.0', '75.00', '7', '75.00', '7', '75.00', '10', '73.53', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('681', '225', '102', '', '0', '3.0', '3.00', '24', '4.17', '24', '4.17', '33', '5.88', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('682', '226', '102', '', '0', '46.0', '46.00', '16', '37.50', '16', '37.50', '21', '41.18', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('683', '227', '102', '', '0', '64.0', '64.00', '11', '58.33', '11', '58.33', '15', '58.82', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('684', '228', '102', '', '0', '15.0', '15.00', '22', '12.50', '22', '12.50', '30', '14.71', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('685', '229', '102', '', '0', '8.0', '8.00', '23', '8.33', '23', '8.33', '31', '11.76', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('686', '230', '102', '', '0', '23.0', '23.00', '18', '29.17', '18', '29.17', '26', '26.47', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('687', '231', '102', '', '0', '69.0', '69.00', '8', '70.83', '8', '70.83', '11', '70.59', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('688', '232', '102', '', '0', '19.0', '19.00', '20', '20.83', '20', '20.83', '28', '20.59', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('689', '233', '102', '', '0', '79.0', '79.00', '5', '83.33', '5', '83.33', '8', '79.41', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('690', '234', '102', '', '0', '23.0', '23.00', '18', '29.17', '18', '29.17', '26', '26.47', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('691', '235', '102', '', '0', '28.0', '28.00', '17', '33.33', '17', '33.33', '24', '32.35', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('692', '236', '102', '', '0', '80.0', '80.00', '4', '87.50', '4', '87.50', '7', '82.35', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('693', '237', '102', '', '0', '54.0', '54.00', '13', '50.00', '13', '50.00', '17', '52.94', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('694', '238', '102', '', '0', '62.0', '62.00', '12', '54.17', '12', '54.17', '16', '55.88', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('695', '239', '102', '', '0', '54.0', '54.00', '13', '50.00', '13', '50.00', '17', '52.94', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('696', '240', '102', '', '0', '98.0', '98.00', '1', '100.00', '1', '100.00', '1', '100.00', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('697', '217', '103', '', '0', '0.0', '0.00', '24', '4.17', '24', '4.17', '34', '2.94', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('698', '218', '103', '', '0', '34.0', '34.00', '16', '37.50', '16', '37.50', '21', '41.18', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('699', '219', '103', '', '0', '80.0', '80.00', '3', '91.67', '3', '91.67', '5', '88.24', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('700', '220', '103', '', '0', '8.0', '8.00', '20', '20.83', '20', '20.83', '29', '17.65', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('701', '221', '103', '', '0', '27.0', '27.00', '17', '33.33', '17', '33.33', '22', '38.24', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('702', '222', '103', '', '0', '59.0', '59.00', '7', '75.00', '7', '75.00', '10', '73.53', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('703', '223', '103', '', '0', '2.0', '2.00', '23', '8.33', '23', '8.33', '33', '5.88', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('704', '224', '103', '', '0', '22.0', '22.00', '19', '25.00', '19', '25.00', '26', '26.47', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('705', '225', '103', '', '0', '72.0', '72.00', '6', '79.17', '6', '79.17', '8', '79.41', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('706', '226', '103', '', '0', '57.0', '57.00', '10', '62.50', '10', '62.50', '14', '61.76', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('707', '227', '103', '', '0', '59.0', '59.00', '7', '75.00', '7', '75.00', '10', '73.53', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('708', '228', '103', '', '0', '47.0', '47.00', '13', '50.00', '13', '50.00', '17', '52.94', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('709', '229', '103', '', '0', '93.0', '93.00', '2', '95.83', '2', '95.83', '2', '97.06', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('710', '230', '103', '', '0', '24.0', '24.00', '18', '29.17', '18', '29.17', '25', '29.41', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('711', '231', '103', '', '0', '76.0', '76.00', '5', '83.33', '5', '83.33', '7', '82.35', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('712', '232', '103', '', '0', '59.0', '59.00', '7', '75.00', '7', '75.00', '10', '73.53', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('713', '233', '103', '', '0', '4.0', '4.00', '21', '16.67', '21', '16.67', '30', '14.71', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('714', '234', '103', '', '0', '38.0', '38.00', '15', '41.67', '15', '41.67', '20', '44.12', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('715', '235', '103', '', '0', '50.0', '50.00', '12', '54.17', '12', '54.17', '16', '55.88', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('716', '236', '103', '', '0', '55.0', '55.00', '11', '58.33', '11', '58.33', '15', '58.82', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('717', '237', '103', '', '0', '45.0', '45.00', '14', '45.83', '14', '45.83', '18', '50.00', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('718', '238', '103', '', '0', '4.0', '4.00', '21', '16.67', '21', '16.67', '30', '14.71', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('719', '239', '103', '', '0', '79.0', '79.00', '4', '87.50', '4', '87.50', '6', '85.29', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('720', '240', '103', '', '0', '98.0', '98.00', '1', '100.00', '1', '100.00', '1', '100.00', '1599027015', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('721', '279', '101', '', '0', '92.0', '92.00', '1', '100.00', '1', '100.00', '5', '88.24', '1599027019', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('722', '280', '101', '', '0', '68.0', '68.00', '3', '80.00', '3', '80.00', '13', '64.71', '1599027019', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('723', '281', '101', '', '0', '38.0', '38.00', '5', '60.00', '5', '60.00', '25', '29.41', '1599027019', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('724', '282', '101', '', '0', '18.0', '18.00', '7', '40.00', '7', '40.00', '30', '14.71', '1599027019', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('725', '283', '101', '', '0', '17.0', '17.00', '8', '30.00', '8', '30.00', '31', '11.76', '1599027019', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('726', '284', '101', '', '0', '65.0', '65.00', '4', '70.00', '4', '70.00', '16', '55.88', '1599027019', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('727', '285', '101', '', '0', '29.0', '29.00', '6', '50.00', '6', '50.00', '26', '26.47', '1599027019', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('728', '286', '101', '', '0', '13.0', '13.00', '9', '20.00', '9', '20.00', '32', '8.82', '1599027019', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('729', '287', '101', '', '0', '6.0', '6.00', '10', '10.00', '10', '10.00', '34', '2.94', '1599027019', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('730', '288', '101', '', '0', '69.0', '69.00', '2', '90.00', '2', '90.00', '12', '67.65', '1599027019', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('731', '279', '102', '', '0', '7.0', '7.00', '9', '20.00', '9', '20.00', '32', '8.82', '1599027019', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('732', '280', '102', '', '0', '53.0', '53.00', '5', '60.00', '5', '60.00', '19', '47.06', '1599027019', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('733', '281', '102', '', '0', '34.0', '34.00', '7', '40.00', '7', '40.00', '23', '35.29', '1599027019', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('734', '282', '102', '', '0', '44.0', '44.00', '6', '50.00', '6', '50.00', '22', '38.24', '1599027019', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('735', '283', '102', '', '0', '85.0', '85.00', '3', '80.00', '3', '80.00', '6', '85.29', '1599027019', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('736', '284', '102', '', '0', '25.0', '25.00', '8', '30.00', '8', '30.00', '25', '29.41', '1599027019', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('737', '285', '102', '', '0', '94.0', '94.00', '1', '100.00', '1', '100.00', '3', '94.12', '1599027019', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('738', '286', '102', '', '0', '86.0', '86.00', '2', '90.00', '2', '90.00', '4', '91.18', '1599027019', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('739', '287', '102', '', '0', '67.0', '67.00', '4', '70.00', '4', '70.00', '13', '64.71', '1599027019', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('740', '288', '102', '', '0', '1.0', '1.00', '10', '10.00', '10', '10.00', '34', '2.94', '1599027019', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('741', '279', '103', '', '0', '15.0', '15.00', '8', '30.00', '8', '30.00', '27', '23.53', '1599027019', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('742', '280', '103', '', '0', '4.0', '4.00', '10', '10.00', '10', '10.00', '30', '14.71', '1599027019', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('743', '281', '103', '', '0', '89.0', '89.00', '2', '90.00', '2', '90.00', '4', '91.18', '1599027019', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('744', '282', '103', '', '0', '58.0', '58.00', '4', '70.00', '4', '70.00', '13', '64.71', '1599027019', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('745', '283', '103', '', '0', '27.0', '27.00', '6', '50.00', '6', '50.00', '22', '38.24', '1599027019', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('746', '284', '103', '', '0', '63.0', '63.00', '3', '80.00', '3', '80.00', '9', '76.47', '1599027019', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('747', '285', '103', '', '0', '90.0', '90.00', '1', '100.00', '1', '100.00', '3', '94.12', '1599027019', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('748', '286', '103', '', '0', '13.0', '13.00', '9', '20.00', '9', '20.00', '28', '20.59', '1599027019', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('749', '287', '103', '', '0', '25.0', '25.00', '7', '40.00', '7', '40.00', '24', '32.35', '1599027019', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('750', '288', '103', '', '0', '39.0', '39.00', '5', '60.00', '5', '60.00', '19', '47.06', '1599027019', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('751', '241', '101', '', '0', '56.0', '56.00', '9', '63.64', '13', '68.42', '42', '62.73', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('752', '242', '101', '', '0', '72.0', '72.00', '5', '81.82', '6', '86.84', '25', '78.18', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('753', '243', '101', '', '0', '55.0', '55.00', '10', '59.09', '14', '65.79', '44', '60.91', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('754', '244', '101', '', '0', '53.0', '53.00', '12', '50.00', '17', '57.89', '48', '57.27', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('755', '245', '101', '', '0', '57.0', '57.00', '8', '68.18', '12', '71.05', '41', '63.64', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('756', '246', '101', '', '0', '10.0', '10.00', '19', '18.18', '32', '18.42', '97', '12.73', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('757', '247', '101', '', '0', '12.0', '12.00', '18', '22.73', '31', '21.05', '96', '13.64', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('758', '248', '101', '', '0', '63.0', '63.00', '6', '77.27', '8', '81.58', '34', '70.00', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('759', '249', '101', '', '0', '54.0', '54.00', '11', '54.55', '15', '63.16', '46', '59.09', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('760', '250', '101', '', '0', '9.0', '9.00', '20', '13.64', '33', '15.79', '98', '11.82', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('761', '251', '101', '', '0', '31.0', '31.00', '16', '31.82', '25', '36.84', '79', '29.09', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('762', '252', '101', '', '0', '77.0', '77.00', '3', '90.91', '4', '92.11', '21', '81.82', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('763', '253', '101', '', '0', '32.0', '32.00', '15', '36.36', '24', '39.47', '78', '30.00', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('764', '254', '101', '', '0', '9.0', '9.00', '20', '13.64', '33', '15.79', '98', '11.82', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('765', '255', '101', '', '0', '41.0', '41.00', '14', '40.91', '21', '47.37', '62', '44.55', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('766', '256', '101', '', '0', '63.0', '63.00', '6', '77.27', '8', '81.58', '34', '70.00', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('767', '257', '101', '', '0', '15.0', '15.00', '17', '27.27', '30', '23.68', '93', '16.36', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('768', '258', '101', '', '0', '74.0', '74.00', '4', '86.36', '5', '89.47', '23', '80.00', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('769', '259', '101', '', '0', '100.0', '100.00', '1', '100.00', '1', '100.00', '1', '100.00', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('770', '260', '101', '', '0', '8.0', '8.00', '22', '4.55', '36', '7.89', '103', '7.27', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('771', '261', '101', '', '0', '45.0', '45.00', '13', '45.45', '20', '50.00', '57', '49.09', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('772', '262', '101', '', '0', '89.0', '89.00', '2', '95.45', '2', '97.37', '12', '90.00', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('773', '263', '101', '', '0', '6.0', '6.00', '15', '12.50', '37', '5.26', '105', '5.45', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('774', '264', '101', '', '0', '62.0', '62.00', '3', '87.50', '10', '76.32', '37', '67.27', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('775', '265', '101', '', '0', '6.0', '6.00', '15', '12.50', '37', '5.26', '105', '5.45', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('776', '266', '101', '', '0', '50.0', '50.00', '7', '62.50', '19', '52.63', '55', '50.91', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('777', '267', '101', '', '0', '81.0', '81.00', '1', '100.00', '3', '94.74', '16', '86.36', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('778', '268', '101', '', '0', '9.0', '9.00', '14', '18.75', '33', '15.79', '98', '11.82', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('779', '269', '101', '', '0', '21.0', '21.00', '11', '37.50', '27', '31.58', '87', '21.82', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('780', '270', '101', '', '0', '38.0', '38.00', '8', '56.25', '22', '44.74', '65', '41.82', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('781', '271', '101', '', '0', '61.0', '61.00', '4', '81.25', '11', '73.68', '38', '66.36', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('782', '272', '101', '', '0', '18.0', '18.00', '12', '31.25', '28', '28.95', '89', '20.00', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('783', '273', '101', '', '0', '67.0', '67.00', '2', '93.75', '7', '84.21', '31', '72.73', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('784', '274', '101', '', '0', '27.0', '27.00', '10', '43.75', '26', '34.21', '83', '25.45', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('785', '275', '101', '', '0', '54.0', '54.00', '5', '75.00', '15', '63.16', '46', '59.09', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('786', '276', '101', '', '0', '37.0', '37.00', '9', '50.00', '23', '42.11', '68', '39.09', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('787', '277', '101', '', '0', '52.0', '52.00', '6', '68.75', '18', '55.26', '52', '53.64', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('788', '278', '101', '', '0', '18.0', '18.00', '12', '31.25', '28', '28.95', '89', '20.00', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('789', '241', '102', '', '0', '79.0', '79.00', '5', '81.82', '8', '81.58', '19', '83.64', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('790', '242', '102', '', '0', '17.0', '17.00', '18', '22.73', '32', '18.42', '92', '17.27', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('791', '243', '102', '', '0', '12.0', '12.00', '19', '18.18', '33', '15.79', '95', '14.55', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('792', '244', '102', '', '0', '71.0', '71.00', '7', '72.73', '10', '76.32', '29', '74.55', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('793', '245', '102', '', '0', '49.0', '49.00', '12', '50.00', '20', '50.00', '54', '51.82', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('794', '246', '102', '', '0', '89.0', '89.00', '3', '90.91', '5', '89.47', '11', '90.91', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('795', '247', '102', '', '0', '97.0', '97.00', '1', '100.00', '2', '97.37', '4', '97.27', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('796', '248', '102', '', '0', '84.0', '84.00', '4', '86.36', '6', '86.84', '14', '88.18', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('797', '249', '102', '', '0', '7.0', '7.00', '20', '13.64', '34', '13.16', '97', '12.73', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('798', '250', '102', '', '0', '51.0', '51.00', '11', '54.55', '18', '55.26', '51', '54.55', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('799', '251', '102', '', '0', '23.0', '23.00', '17', '27.27', '30', '23.68', '86', '22.73', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('800', '252', '102', '', '0', '74.0', '74.00', '6', '77.27', '9', '78.95', '24', '79.09', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('801', '253', '102', '', '0', '62.0', '62.00', '9', '63.64', '12', '71.05', '37', '67.27', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('802', '254', '102', '', '0', '70.0', '70.00', '8', '68.18', '11', '73.68', '31', '72.73', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('803', '255', '102', '', '0', '92.0', '92.00', '2', '95.45', '4', '92.11', '7', '94.55', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('804', '256', '102', '', '0', '6.0', '6.00', '21', '9.09', '35', '10.53', '99', '10.91', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('805', '257', '102', '', '0', '29.0', '29.00', '15', '36.36', '28', '28.95', '80', '28.18', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('806', '258', '102', '', '0', '55.0', '55.00', '10', '59.09', '16', '60.53', '48', '57.27', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('807', '259', '102', '', '0', '30.0', '30.00', '14', '40.91', '27', '31.58', '79', '29.09', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('808', '260', '102', '', '0', '36.0', '36.00', '13', '45.45', '25', '36.84', '70', '37.27', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('809', '261', '102', '', '0', '5.0', '5.00', '22', '4.55', '36', '7.89', '101', '9.09', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('810', '262', '102', '', '0', '25.0', '25.00', '16', '31.82', '29', '26.32', '84', '24.55', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('811', '263', '102', '', '0', '45.0', '45.00', '10', '43.75', '22', '44.74', '61', '45.45', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('812', '264', '102', '', '0', '100.0', '100.00', '1', '100.00', '1', '100.00', '1', '100.00', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('813', '265', '102', '', '0', '19.0', '19.00', '14', '18.75', '31', '21.05', '90', '19.09', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('814', '266', '102', '', '0', '95.0', '95.00', '2', '93.75', '3', '94.74', '5', '96.36', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('815', '267', '102', '', '0', '59.0', '59.00', '6', '68.75', '15', '63.16', '44', '60.91', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('816', '268', '102', '', '0', '31.0', '31.00', '13', '25.00', '26', '34.21', '78', '30.00', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('817', '269', '102', '', '0', '5.0', '5.00', '15', '12.50', '36', '7.89', '101', '9.09', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('818', '270', '102', '', '0', '37.0', '37.00', '12', '31.25', '24', '39.47', '67', '40.00', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('819', '271', '102', '', '0', '81.0', '81.00', '3', '87.50', '7', '84.21', '17', '85.45', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('820', '272', '102', '', '0', '1.0', '1.00', '16', '6.25', '38', '2.63', '108', '2.73', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('821', '273', '102', '', '0', '48.0', '48.00', '9', '50.00', '21', '47.37', '58', '48.18', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('822', '274', '102', '', '0', '60.0', '60.00', '4', '81.25', '13', '68.42', '39', '65.45', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('823', '275', '102', '', '0', '60.0', '60.00', '4', '81.25', '13', '68.42', '39', '65.45', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('824', '276', '102', '', '0', '45.0', '45.00', '10', '43.75', '22', '44.74', '61', '45.45', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('825', '277', '102', '', '0', '50.0', '50.00', '8', '56.25', '19', '52.63', '53', '52.73', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('826', '278', '102', '', '0', '53.0', '53.00', '7', '62.50', '17', '57.89', '50', '55.45', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('827', '241', '103', '', '0', '70.0', '70.00', '6', '77.27', '10', '76.32', '32', '71.82', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('828', '242', '103', '', '0', '45.0', '45.00', '12', '50.00', '17', '57.89', '61', '45.45', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('829', '243', '103', '', '0', '88.0', '88.00', '3', '90.91', '5', '89.47', '15', '87.27', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('830', '244', '103', '', '0', '56.0', '56.00', '9', '63.64', '14', '65.79', '48', '57.27', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('831', '245', '103', '', '0', '21.0', '21.00', '17', '27.27', '27', '31.58', '86', '22.73', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('832', '246', '103', '', '0', '3.0', '3.00', '22', '4.55', '37', '5.26', '105', '5.45', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('833', '247', '103', '', '0', '18.0', '18.00', '18', '22.73', '29', '26.32', '89', '20.00', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('834', '248', '103', '', '0', '38.0', '38.00', '13', '45.45', '19', '52.63', '65', '41.82', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('835', '249', '103', '', '0', '69.0', '69.00', '7', '72.73', '11', '73.68', '35', '69.09', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('836', '250', '103', '', '0', '55.0', '55.00', '10', '59.09', '15', '63.16', '50', '55.45', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('837', '251', '103', '', '0', '31.0', '31.00', '15', '36.36', '25', '36.84', '76', '31.82', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('838', '252', '103', '', '0', '95.0', '95.00', '1', '100.00', '2', '97.37', '5', '96.36', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('839', '253', '103', '', '0', '72.0', '72.00', '5', '81.82', '9', '78.95', '30', '73.64', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('840', '254', '103', '', '0', '85.0', '85.00', '4', '86.36', '6', '86.84', '21', '81.82', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('841', '255', '103', '', '0', '12.0', '12.00', '19', '18.18', '32', '18.42', '97', '12.73', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('842', '256', '103', '', '0', '8.0', '8.00', '21', '9.09', '35', '10.53', '101', '9.09', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('843', '257', '103', '', '0', '66.0', '66.00', '8', '68.18', '12', '71.05', '39', '65.45', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('844', '258', '103', '', '0', '24.0', '24.00', '16', '31.82', '26', '34.21', '81', '27.27', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('845', '259', '103', '', '0', '90.0', '90.00', '2', '95.45', '4', '92.11', '11', '90.91', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('846', '260', '103', '', '0', '9.0', '9.00', '20', '13.64', '34', '13.16', '100', '10.00', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('847', '261', '103', '', '0', '46.0', '46.00', '11', '54.55', '16', '60.53', '59', '47.27', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('848', '262', '103', '', '0', '35.0', '35.00', '14', '40.91', '23', '42.11', '72', '35.45', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('849', '263', '103', '', '0', '13.0', '13.00', '13', '25.00', '31', '21.05', '95', '14.55', '1599027023', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('850', '264', '103', '', '0', '76.0', '76.00', '4', '81.25', '8', '81.58', '27', '76.36', '1599027024', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('851', '265', '103', '', '0', '37.0', '37.00', '8', '56.25', '21', '47.37', '68', '39.09', '1599027024', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('852', '266', '103', '', '0', '32.0', '32.00', '10', '43.75', '24', '39.47', '75', '32.73', '1599027024', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('853', '267', '103', '', '0', '2.0', '2.00', '16', '6.25', '38', '2.63', '107', '3.64', '1599027024', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('854', '268', '103', '', '0', '63.0', '63.00', '5', '75.00', '13', '68.42', '41', '63.64', '1599027024', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('855', '269', '103', '', '0', '15.0', '15.00', '12', '31.25', '30', '23.68', '92', '17.27', '1599027024', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('856', '270', '103', '', '0', '36.0', '36.00', '9', '50.00', '22', '44.74', '69', '38.18', '1599027024', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('857', '271', '103', '', '0', '38.0', '38.00', '7', '62.50', '19', '52.63', '65', '41.82', '1599027024', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('858', '272', '103', '', '0', '10.0', '10.00', '14', '18.75', '33', '15.79', '99', '10.91', '1599027024', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('859', '273', '103', '', '0', '84.0', '84.00', '3', '87.50', '7', '84.21', '22', '80.91', '1599027024', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('860', '274', '103', '', '0', '100.0', '100.00', '1', '100.00', '1', '100.00', '1', '100.00', '1599027024', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('861', '275', '103', '', '0', '41.0', '41.00', '6', '68.75', '18', '55.26', '63', '43.64', '1599027024', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('862', '276', '103', '', '0', '92.0', '92.00', '2', '93.75', '3', '94.74', '9', '92.73', '1599027024', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('863', '277', '103', '', '0', '6.0', '6.00', '15', '12.50', '36', '7.89', '103', '7.27', '1599027024', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('864', '278', '103', '', '0', '19.0', '19.00', '11', '37.50', '28', '28.95', '88', '20.91', '1599027024', '1599030246', '', '1');
INSERT INTO `cj_chengji` VALUES ('865', '363', '101', '', '0', '43.0', '43.00', '14', '40.91', '14', '40.91', '20', '40.63', '1599028326', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('866', '364', '101', '', '0', '90.0', '90.00', '4', '86.36', '4', '86.36', '4', '90.63', '1599028326', '1599030259', '', '1');
INSERT INTO `cj_chengji` VALUES ('867', '365', '101', '', '0', '64.0', '64.00', '12', '50.00', '12', '50.00', '16', '53.13', '1599028326', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('868', '366', '101', '', '0', '23.0', '23.00', '20', '13.64', '20', '13.64', '27', '18.75', '1599028326', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('869', '367', '101', '', '0', '92.0', '92.00', '2', '95.45', '2', '95.45', '2', '96.88', '1599028326', '1599030259', '', '1');
INSERT INTO `cj_chengji` VALUES ('870', '368', '101', '', '0', '73.0', '73.00', '9', '63.64', '9', '63.64', '12', '65.63', '1599028326', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('871', '369', '101', '', '0', '9.0', '9.00', '22', '4.55', '22', '4.55', '30', '9.38', '1599028326', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('872', '370', '101', '', '0', '10.0', '10.00', '21', '9.09', '21', '9.09', '29', '12.50', '1599028326', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('873', '371', '101', '', '0', '48.0', '48.00', '13', '45.45', '13', '45.45', '18', '46.88', '1599028326', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('874', '372', '101', '', '0', '87.0', '87.00', '6', '77.27', '6', '77.27', '6', '84.38', '1599028326', '1599030259', '', '1');
INSERT INTO `cj_chengji` VALUES ('875', '373', '101', '', '0', '84.0', '84.00', '7', '72.73', '7', '72.73', '8', '78.13', '1599028326', '1599030259', '', '1');
INSERT INTO `cj_chengji` VALUES ('876', '374', '101', '', '0', '37.0', '37.00', '15', '36.36', '15', '36.36', '22', '34.38', '1599028326', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('877', '375', '101', '', '0', '71.0', '71.00', '11', '54.55', '11', '54.55', '14', '59.38', '1599028326', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('878', '376', '101', '', '0', '72.0', '72.00', '10', '59.09', '10', '59.09', '13', '62.50', '1599028326', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('879', '377', '101', '', '0', '36.0', '36.00', '17', '27.27', '17', '27.27', '24', '28.13', '1599028326', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('880', '378', '101', '', '0', '90.0', '90.00', '4', '86.36', '4', '86.36', '4', '90.63', '1599028326', '1599030259', '', '1');
INSERT INTO `cj_chengji` VALUES ('881', '379', '101', '', '0', '91.0', '91.00', '3', '90.91', '3', '90.91', '3', '93.75', '1599028326', '1599030259', '', '1');
INSERT INTO `cj_chengji` VALUES ('882', '380', '101', '', '0', '34.0', '34.00', '18', '22.73', '18', '22.73', '25', '25.00', '1599028326', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('883', '381', '101', '', '0', '99.0', '99.00', '1', '100.00', '1', '100.00', '1', '100.00', '1599028326', '1599030259', '', '1');
INSERT INTO `cj_chengji` VALUES ('884', '382', '101', '', '0', '83.0', '83.00', '8', '68.18', '8', '68.18', '9', '75.00', '1599028326', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('885', '383', '101', '', '0', '37.0', '37.00', '15', '36.36', '15', '36.36', '22', '34.38', '1599028326', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('886', '384', '101', '', '0', '25.0', '25.00', '19', '18.18', '19', '18.18', '26', '21.88', '1599028326', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('887', '365', '102', '', '0', '1.0', '1.00', '20', '5.00', '20', '5.00', '29', '6.67', '1599028326', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('888', '366', '102', '', '0', '24.0', '24.00', '15', '30.00', '15', '30.00', '23', '26.67', '1599028326', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('889', '367', '102', '', '0', '48.0', '48.00', '9', '60.00', '9', '60.00', '16', '50.00', '1599028326', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('890', '368', '102', '', '0', '23.0', '23.00', '16', '25.00', '16', '25.00', '24', '23.33', '1599028326', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('891', '369', '102', '', '0', '43.0', '43.00', '11', '50.00', '11', '50.00', '18', '43.33', '1599028326', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('892', '370', '102', '', '0', '69.0', '69.00', '5', '80.00', '5', '80.00', '11', '66.67', '1599028326', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('893', '371', '102', '', '0', '51.0', '51.00', '8', '65.00', '8', '65.00', '14', '56.67', '1599028326', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('894', '372', '102', '', '0', '44.0', '44.00', '10', '55.00', '10', '55.00', '17', '46.67', '1599028326', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('895', '373', '102', '', '0', '86.0', '86.00', '4', '85.00', '4', '85.00', '6', '83.33', '1599028326', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('896', '374', '102', '', '0', '60.0', '60.00', '7', '70.00', '7', '70.00', '13', '60.00', '1599028326', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('897', '375', '102', '', '0', '35.0', '35.00', '14', '35.00', '14', '35.00', '21', '33.33', '1599028326', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('898', '376', '102', '', '0', '96.0', '96.00', '1', '100.00', '1', '100.00', '1', '100.00', '1599028326', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('899', '377', '102', '', '0', '2.0', '2.00', '19', '10.00', '19', '10.00', '28', '10.00', '1599028326', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('900', '378', '102', '', '0', '39.0', '39.00', '13', '40.00', '13', '40.00', '20', '36.67', '1599028326', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('901', '379', '102', '', '0', '91.0', '91.00', '3', '90.00', '3', '90.00', '5', '86.67', '1599028326', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('902', '380', '102', '', '0', '92.0', '92.00', '2', '95.00', '2', '95.00', '2', '96.67', '1599028326', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('903', '381', '102', '', '0', '13.0', '13.00', '17', '20.00', '17', '20.00', '25', '20.00', '1599028326', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('904', '382', '102', '', '0', '11.0', '11.00', '18', '15.00', '18', '15.00', '27', '13.33', '1599028326', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('905', '383', '102', '', '0', '68.0', '68.00', '6', '75.00', '6', '75.00', '12', '63.33', '1599028326', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('906', '384', '102', '', '0', '40.0', '40.00', '12', '45.00', '12', '45.00', '19', '40.00', '1599028326', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('907', '368', '103', '', '0', '31.0', '31.00', '12', '35.29', '12', '35.29', '17', '40.74', '1599028326', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('908', '369', '103', '', '0', '44.0', '44.00', '9', '52.94', '9', '52.94', '14', '51.85', '1599028326', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('909', '370', '103', '', '0', '39.0', '39.00', '10', '47.06', '10', '47.06', '15', '48.15', '1599028326', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('910', '371', '103', '', '0', '51.0', '51.00', '6', '70.59', '6', '70.59', '10', '66.67', '1599028326', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('911', '372', '103', '', '0', '51.0', '51.00', '6', '70.59', '6', '70.59', '10', '66.67', '1599028326', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('912', '373', '103', '', '0', '6.0', '6.00', '16', '11.76', '16', '11.76', '24', '14.81', '1599028326', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('913', '374', '103', '', '0', '25.0', '25.00', '15', '17.65', '15', '17.65', '20', '29.63', '1599028326', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('914', '375', '103', '', '0', '31.0', '31.00', '12', '35.29', '12', '35.29', '17', '40.74', '1599028326', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('915', '376', '103', '', '0', '58.0', '58.00', '4', '82.35', '4', '82.35', '8', '74.07', '1599028326', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('916', '377', '103', '', '0', '61.0', '61.00', '3', '88.24', '3', '88.24', '7', '77.78', '1599028326', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('917', '378', '103', '', '0', '52.0', '52.00', '5', '76.47', '5', '76.47', '9', '70.37', '1599028326', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('918', '379', '103', '', '0', '31.0', '31.00', '12', '35.29', '12', '35.29', '17', '40.74', '1599028326', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('919', '380', '103', '', '0', '51.0', '51.00', '6', '70.59', '6', '70.59', '10', '66.67', '1599028326', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('920', '381', '103', '', '0', '78.0', '78.00', '1', '100.00', '1', '100.00', '2', '96.30', '1599028326', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('921', '382', '103', '', '0', '36.0', '36.00', '11', '41.18', '11', '41.18', '16', '44.44', '1599028326', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('922', '383', '103', '', '0', '69.0', '69.00', '2', '94.12', '2', '94.12', '3', '92.59', '1599028326', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('923', '384', '103', '', '0', '6.0', '6.00', '16', '11.76', '16', '11.76', '24', '14.81', '1599028326', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('924', '291', '101', '', '0', '62.0', '62.00', '6', '75.00', '23', '68.57', '36', '67.59', '1599028328', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('925', '292', '101', '', '0', '70.0', '70.00', '2', '95.00', '17', '77.14', '29', '74.07', '1599028328', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('926', '293', '101', '', '0', '39.0', '39.00', '10', '55.00', '44', '38.57', '68', '37.96', '1599028328', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('927', '294', '101', '', '0', '67.0', '67.00', '4', '85.00', '19', '74.29', '31', '72.22', '1599028328', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('928', '295', '101', '', '0', '33.0', '33.00', '13', '40.00', '49', '31.43', '77', '29.63', '1599028328', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('929', '296', '101', '', '0', '31.0', '31.00', '15', '30.00', '52', '27.14', '80', '26.85', '1599028328', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('930', '297', '101', '', '0', '52.0', '52.00', '9', '60.00', '33', '54.29', '52', '52.78', '1599028328', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('931', '298', '101', '', '0', '38.0', '38.00', '11', '50.00', '45', '37.14', '69', '37.04', '1599028328', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('932', '299', '101', '', '0', '15.0', '15.00', '17', '20.00', '61', '14.29', '94', '13.89', '1599028328', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('933', '300', '101', '', '0', '10.0', '10.00', '19', '10.00', '64', '10.00', '99', '9.26', '1599028328', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('934', '301', '101', '', '0', '37.0', '37.00', '12', '45.00', '46', '35.71', '70', '36.11', '1599028328', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('935', '302', '101', '', '0', '6.0', '6.00', '20', '5.00', '65', '8.57', '101', '7.41', '1599028328', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('936', '303', '101', '', '0', '57.0', '57.00', '8', '65.00', '28', '61.43', '44', '60.19', '1599028328', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('937', '304', '101', '', '0', '66.0', '66.00', '5', '80.00', '21', '71.43', '33', '70.37', '1599028328', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('938', '305', '101', '', '0', '70.0', '70.00', '2', '95.00', '17', '77.14', '29', '74.07', '1599028328', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('939', '306', '101', '', '0', '29.0', '29.00', '16', '25.00', '53', '25.71', '82', '25.00', '1599028328', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('940', '307', '101', '', '0', '15.0', '15.00', '17', '20.00', '61', '14.29', '94', '13.89', '1599028328', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('941', '308', '101', '', '0', '93.0', '93.00', '1', '100.00', '4', '95.71', '8', '93.52', '1599028328', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('942', '309', '101', '', '0', '61.0', '61.00', '7', '70.00', '25', '65.71', '39', '64.81', '1599028328', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('943', '310', '101', '', '0', '32.0', '32.00', '14', '35.00', '51', '28.57', '79', '27.78', '1599028328', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('944', '311', '101', '', '0', '35.0', '35.00', '9', '50.00', '48', '32.86', '74', '32.41', '1599028328', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('945', '312', '101', '', '0', '99.0', '99.00', '1', '100.00', '1', '100.00', '2', '99.07', '1599028328', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('946', '313', '101', '', '0', '67.0', '67.00', '6', '68.75', '19', '74.29', '31', '72.22', '1599028328', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('947', '314', '101', '', '0', '33.0', '33.00', '10', '43.75', '49', '31.43', '77', '29.63', '1599028328', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('948', '315', '101', '', '0', '2.0', '2.00', '16', '6.25', '70', '1.43', '106', '2.78', '1599028328', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('949', '316', '101', '', '0', '71.0', '71.00', '5', '75.00', '15', '80.00', '26', '76.85', '1599028328', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('950', '317', '101', '', '0', '25.0', '25.00', '11', '37.50', '54', '24.29', '84', '23.15', '1599028328', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('951', '318', '101', '', '0', '88.0', '88.00', '2', '93.75', '7', '91.43', '11', '90.74', '1599028328', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('952', '319', '101', '', '0', '42.0', '42.00', '8', '56.25', '41', '42.86', '64', '41.67', '1599028329', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('953', '320', '101', '', '0', '83.0', '83.00', '4', '81.25', '11', '85.71', '17', '85.19', '1599028329', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('954', '321', '101', '', '0', '87.0', '87.00', '3', '87.50', '9', '88.57', '13', '88.89', '1599028329', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('955', '322', '101', '', '0', '50.0', '50.00', '7', '62.50', '35', '51.43', '54', '50.93', '1599028329', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('956', '323', '101', '', '0', '19.0', '19.00', '13', '25.00', '56', '21.43', '86', '21.30', '1599028329', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('957', '324', '101', '', '0', '16.0', '16.00', '14', '18.75', '59', '17.14', '92', '15.74', '1599028329', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('958', '325', '101', '', '0', '23.0', '23.00', '12', '31.25', '55', '22.86', '85', '22.22', '1599028329', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('959', '326', '101', '', '0', '4.0', '4.00', '15', '12.50', '67', '5.71', '103', '5.56', '1599028329', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('960', '327', '101', '', '0', '88.0', '88.00', '5', '88.24', '7', '91.43', '11', '90.74', '1599028329', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('961', '328', '101', '', '0', '36.0', '36.00', '27', '23.53', '47', '34.29', '72', '34.26', '1599028329', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('962', '329', '101', '', '0', '59.0', '59.00', '13', '64.71', '26', '64.29', '40', '63.89', '1599028329', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('963', '330', '101', '', '0', '71.0', '71.00', '10', '73.53', '15', '80.00', '26', '76.85', '1599028329', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('964', '331', '101', '', '0', '45.0', '45.00', '24', '32.35', '40', '44.29', '62', '43.52', '1599028329', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('965', '332', '101', '', '0', '4.0', '4.00', '33', '5.88', '67', '5.71', '103', '5.56', '1599028329', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('966', '333', '101', '', '0', '47.0', '47.00', '22', '38.24', '38', '47.14', '59', '46.30', '1599028329', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('967', '334', '101', '', '0', '54.0', '54.00', '16', '55.88', '30', '58.57', '47', '57.41', '1599028329', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('968', '335', '101', '', '0', '19.0', '19.00', '28', '20.59', '56', '21.43', '86', '21.30', '1599028329', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('969', '336', '101', '', '0', '55.0', '55.00', '15', '58.82', '29', '60.00', '46', '58.33', '1599028329', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('970', '337', '101', '', '0', '78.0', '78.00', '8', '79.41', '13', '82.86', '22', '80.56', '1599028329', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('971', '338', '101', '', '0', '16.0', '16.00', '30', '14.71', '59', '17.14', '92', '15.74', '1599028329', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('972', '339', '101', '', '0', '97.0', '97.00', '1', '100.00', '2', '98.57', '3', '98.15', '1599028329', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('973', '340', '101', '', '0', '62.0', '62.00', '12', '67.65', '23', '68.57', '36', '67.59', '1599028329', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('974', '341', '101', '', '0', '89.0', '89.00', '4', '91.18', '6', '92.86', '10', '91.67', '1599028329', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('975', '342', '101', '', '0', '72.0', '72.00', '9', '76.47', '14', '81.43', '25', '77.78', '1599028329', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('976', '343', '101', '', '0', '94.0', '94.00', '2', '97.06', '3', '97.14', '7', '94.44', '1599028329', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('977', '344', '101', '', '0', '53.0', '53.00', '17', '52.94', '31', '57.14', '48', '56.48', '1599028329', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('978', '345', '101', '', '0', '48.0', '48.00', '21', '41.18', '37', '48.57', '58', '47.22', '1599028329', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('979', '346', '101', '', '0', '18.0', '18.00', '29', '17.65', '58', '18.57', '88', '19.44', '1599028329', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('980', '347', '101', '', '0', '83.0', '83.00', '7', '82.35', '11', '85.71', '17', '85.19', '1599028329', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('981', '348', '101', '', '0', '40.0', '40.00', '26', '26.47', '43', '40.00', '67', '38.89', '1599028329', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('982', '349', '101', '', '0', '59.0', '59.00', '13', '64.71', '26', '64.29', '40', '63.89', '1599028329', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('983', '350', '101', '', '0', '52.0', '52.00', '19', '47.06', '33', '54.29', '52', '52.78', '1599028329', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('984', '351', '101', '', '0', '6.0', '6.00', '32', '8.82', '65', '8.57', '101', '7.41', '1599028329', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('985', '352', '101', '', '0', '12.0', '12.00', '31', '11.76', '63', '11.43', '97', '11.11', '1599028329', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('986', '353', '101', '', '0', '4.0', '4.00', '33', '5.88', '67', '5.71', '103', '5.56', '1599028329', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('987', '354', '101', '', '0', '64.0', '64.00', '11', '70.59', '22', '70.00', '35', '68.52', '1599028329', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('988', '355', '101', '', '0', '53.0', '53.00', '17', '52.94', '31', '57.14', '48', '56.48', '1599028329', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('989', '356', '101', '', '0', '93.0', '93.00', '3', '94.12', '4', '95.71', '8', '93.52', '1599028329', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('990', '357', '101', '', '0', '46.0', '46.00', '23', '35.29', '39', '45.71', '61', '44.44', '1599028329', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('991', '358', '101', '', '0', '42.0', '42.00', '25', '29.41', '41', '42.86', '64', '41.67', '1599028329', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('992', '359', '101', '', '0', '50.0', '50.00', '20', '44.12', '35', '51.43', '54', '50.93', '1599028329', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('993', '360', '101', '', '0', '86.0', '86.00', '6', '85.29', '10', '87.14', '14', '87.96', '1599028329', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('994', '289', '102', '', '0', '49.0', '49.00', '9', '57.89', '32', '55.07', '51', '53.27', '1599028329', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('995', '290', '102', '', '0', '13.0', '13.00', '17', '15.79', '56', '20.29', '86', '20.56', '1599028329', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('996', '294', '102', '', '0', '65.0', '65.00', '6', '73.68', '24', '66.67', '37', '66.36', '1599028329', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('997', '295', '102', '', '0', '74.0', '74.00', '4', '84.21', '16', '78.26', '22', '80.37', '1599028329', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('998', '296', '102', '', '0', '26.0', '26.00', '14', '31.58', '52', '26.09', '75', '30.84', '1599028329', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('999', '297', '102', '', '0', '25.0', '25.00', '15', '26.32', '53', '24.64', '78', '28.04', '1599028329', '1599030260', '', '1');
INSERT INTO `cj_chengji` VALUES ('1000', '298', '102', '', '0', '46.0', '46.00', '10', '52.63', '35', '50.72', '55', '49.53', '1599028329', '1599030260', '', '1');

-- -----------------------------
-- Table structure for `cj_dw_rongyu`
-- -----------------------------
DROP TABLE IF EXISTS `cj_dw_rongyu`;
CREATE TABLE `cj_dw_rongyu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project` varchar(100) NOT NULL DEFAULT 'a' COMMENT '项目名称',
  `title` varchar(100) NOT NULL DEFAULT 'a' COMMENT '荣誉内容名称',
  `hjschool_id` int(11) NOT NULL DEFAULT '0' COMMENT '获奖单位',
  `fzschool_id` int(11) NOT NULL DEFAULT '0' COMMENT '发证单位',
  `fzshijian` int(11) NOT NULL DEFAULT '1539158918' COMMENT '发证时间',
  `url` varchar(100) NOT NULL DEFAULT 'a' COMMENT '荣誉图片',
  `jiangxiang_id` int(11) NOT NULL DEFAULT '0' COMMENT '奖项',
  `category_id` int(11) NOT NULL DEFAULT '0' COMMENT '荣誉类型',
  `create_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '更新时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0=禁用，1=正常',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- -----------------------------
-- Table structure for `cj_dw_rongyu_canyu`
-- -----------------------------
DROP TABLE IF EXISTS `cj_dw_rongyu_canyu`;
CREATE TABLE `cj_dw_rongyu_canyu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rongyu_id` int(11) NOT NULL DEFAULT '0' COMMENT '荣誉id',
  `teacher_id` int(11) NOT NULL DEFAULT '0' COMMENT '获奖单位',
  `create_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '更新时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- -----------------------------
-- Table structure for `cj_fields`
-- -----------------------------
DROP TABLE IF EXISTS `cj_fields`;
CREATE TABLE `cj_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL DEFAULT '0' COMMENT '文件分类',
  `oldname` varchar(100) NOT NULL DEFAULT 'a' COMMENT '原文件名',
  `bianjitime` int(11) DEFAULT NULL COMMENT '最后编辑时间',
  `newname` varchar(100) NOT NULL DEFAULT 'a' COMMENT '新文件名',
  `extension` varchar(100) NOT NULL DEFAULT '.a' COMMENT '文件扩展名',
  `fieldsize` int(11) NOT NULL DEFAULT '0' COMMENT '文件大小',
  `hash` varchar(100) NOT NULL DEFAULT 'a' COMMENT '散列值',
  `user_group` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '用户身份',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `url` varchar(100) DEFAULT NULL COMMENT '文件储存位置',
  `create_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '更新时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

-- -----------------------------
-- Records of `cj_fields`
-- -----------------------------
INSERT INTO `cj_fields` VALUES ('1', '11102', '前山小学一、二年级学生名单.xlsx', '1599023976', '707d7383c855f0e9e33893ba3a913fe5.xlsx', 'xlsx', '19943', '0b67de3cdb7555dc44e5d870375d016b15c6f042', '', '0', 'student\\20200902\\707d7383c855f0e9e33893ba3a913fe5.xlsx', '1599023976', '1599023976', '');
INSERT INTO `cj_fields` VALUES ('2', '11102', '后海小学一、二年级学生名单.xlsx', '1599024226', 'd6c5535fa606e91fdad02e1ce62e8ed0.xlsx', 'xlsx', '12710', 'e9551eee27a37030e8ee4b1afe774cada4228bdc', '', '0', 'student\\20200902\\d6c5535fa606e91fdad02e1ce62e8ed0.xlsx', '1599024226', '1599024226', '');
INSERT INTO `cj_fields` VALUES ('3', '11103', '考试一（全参加考试）成绩采集表200902134725.xlsx', '1599025868', '60524e5d26a4cd1b5203f48ff32d8a10.xlsx', 'xlsx', '15029', 'f712c8f12d369c75a0dd1474d5474b58bdc2a0af', '', '0', 'chengji\\20200902\\60524e5d26a4cd1b5203f48ff32d8a10.xlsx', '1599025868', '1599025868', '');
INSERT INTO `cj_fields` VALUES ('4', '11103', '考试一（全参加考试）成绩采集表200902134744.xlsx', '1599025872', 'e1ecb6dab83fa2cfba69c6320549d5d9.xlsx', 'xlsx', '11438', '62e6834fe0d34719a85b85095e3660c1bdbe269e', '', '0', 'chengji\\20200902\\e1ecb6dab83fa2cfba69c6320549d5d9.xlsx', '1599025872', '1599025872', '');
INSERT INTO `cj_fields` VALUES ('5', '11103', '考试一（全参加考试）成绩采集表200902134754.xlsx', '1599025877', '45a81c4ef19a7cb1482a5bbdd8865faa.xlsx', 'xlsx', '12505', '25a6fbee1c8c011708297c226202ce3e19423210', '', '0', 'chengji\\20200902\\45a81c4ef19a7cb1482a5bbdd8865faa.xlsx', '1599025877', '1599025877', '');
INSERT INTO `cj_fields` VALUES ('6', '11103', '考试一（全参加考试）成绩采集表200902134800.xlsx', '1599025882', 'a0593255d8af10282637c0aa6dea26b4.xlsx', 'xlsx', '10295', '90fbe71becbb7ab70a278172c7fadb4e96c2d256', '', '0', 'chengji\\20200902\\a0593255d8af10282637c0aa6dea26b4.xlsx', '1599025882', '1599025882', '');
INSERT INTO `cj_fields` VALUES ('7', '11103', '考试二（全参加考试）成绩采集表200902140714.xlsx', '1599027006', '3b17a7a46b2382eeacfb7e8c95eeb017.xlsx', 'xlsx', '15202', 'a3eb4fc28ce9aab6f00d4124ca5f9f0f0a92e043', '', '0', 'chengji\\20200902\\3b17a7a46b2382eeacfb7e8c95eeb017.xlsx', '1599027006', '1599027006', '');
INSERT INTO `cj_fields` VALUES ('8', '11103', '考试二（全参加考试）成绩采集表200902140722.xlsx', '1599027014', '8757761de71f8a4d17d85141284bb9fe.xlsx', 'xlsx', '11442', '4efe1b6b3044717f09cbd188f34753e5334a30e2', '', '0', 'chengji\\20200902\\8757761de71f8a4d17d85141284bb9fe.xlsx', '1599027014', '1599027014', '');
INSERT INTO `cj_fields` VALUES ('9', '11103', '考试二（全参加考试）成绩采集表200902140731.xlsx', '1599027018', '95e719e3582a3e742056991126cb2e53.xlsx', 'xlsx', '10290', '46496a6931f386195876d63cb9a72e511dd7b638', '', '0', 'chengji\\20200902\\95e719e3582a3e742056991126cb2e53.xlsx', '1599027018', '1599027018', '');
INSERT INTO `cj_fields` VALUES ('10', '11103', '考试二（全参加考试）成绩采集表200902140738.xlsx', '1599027022', 'be019fb3f330c5e9adc7f25e047d0128.xlsx', 'xlsx', '12499', '604015a9042d6c01a539f27b2e240d6c22c0f71b', '', '0', 'chengji\\20200902\\be019fb3f330c5e9adc7f25e047d0128.xlsx', '1599027022', '1599027022', '');
INSERT INTO `cj_fields` VALUES ('11', '11103', '考试三（全参加考试）成绩采集表200902142744.xlsx', '1599028325', '8bfa1dfb615be88744322068c5a9ae40.xlsx', 'xlsx', '11346', '899f75866c4d7f21db79097a05be08f83d1925b8', '', '0', 'chengji\\20200902\\8bfa1dfb615be88744322068c5a9ae40.xlsx', '1599028325', '1599028325', '');
INSERT INTO `cj_fields` VALUES ('12', '11103', '考试三（全参加考试）成绩采集表200902142750.xlsx', '1599028327', 'bbe85b72c06167f109b4e2b0b0bab4a6.xlsx', 'xlsx', '12954', '776a6da9c0ee673cd1da188e4223b7bacb129d6b', '', '0', 'chengji\\20200902\\bbe85b72c06167f109b4e2b0b0bab4a6.xlsx', '1599028328', '1599028328', '');
INSERT INTO `cj_fields` VALUES ('13', '11103', '考试三（全参加考试）成绩采集表200902142758.xlsx', '1599028330', '4b61e10423b1f2e5ba3e7f54466ae02d.xlsx', 'xlsx', '10294', '9553b955ff712cd8f728c9276928a1695329ee23', '', '0', 'chengji\\20200902\\4b61e10423b1f2e5ba3e7f54466ae02d.xlsx', '1599028330', '1599028330', '');
INSERT INTO `cj_fields` VALUES ('14', '11103', '考试三（全参加考试）成绩采集表200902142802.xlsx', '1599028332', '8f542b6894e2d39477d860e029bd3760.xlsx', 'xlsx', '12514', '0af82585154acbed0d019b60f0bb0b75cef62f4c', '', '0', 'chengji\\20200902\\8f542b6894e2d39477d860e029bd3760.xlsx', '1599028332', '1599028332', '');
INSERT INTO `cj_fields` VALUES ('15', '11103', '考试四（全部参加考试）成绩采集表200902143326.xlsx', '1599028620', '0af0d3b56c6395b438f99f01ac5b2b1a.xlsx', 'xlsx', '12927', '60d16361293f7f542a1b22103ebe32092208f14c', '', '0', 'chengji\\20200902\\0af0d3b56c6395b438f99f01ac5b2b1a.xlsx', '1599028620', '1599028620', '');
INSERT INTO `cj_fields` VALUES ('16', '11103', '考试四（全部参加考试）成绩采集表200902143339.xlsx', '1599028623', '84e92ab2e9ac21f119ba8f50655e9f8e.xlsx', 'xlsx', '11427', '274c7e5ceed521264f179f988914fb75da5d6b97', '', '0', 'chengji\\20200902\\84e92ab2e9ac21f119ba8f50655e9f8e.xlsx', '1599028624', '1599028624', '');
INSERT INTO `cj_fields` VALUES ('17', '11103', '考试四（全部参加考试）成绩采集表200902143350.xlsx', '1599028626', 'db7a5bffe7a1511f1263b350ba0b7277.xlsx', 'xlsx', '10292', '9e842b426104acb1c711e93083620f3d1ff897f4', '', '0', 'chengji\\20200902\\db7a5bffe7a1511f1263b350ba0b7277.xlsx', '1599028626', '1599028626', '');
INSERT INTO `cj_fields` VALUES ('18', '11103', '考试四（全部参加考试）成绩采集表200902143355.xlsx', '1599028628', '240ced4836721d7a09d075ff6746be03.xlsx', 'xlsx', '12500', 'd435fa5499f7d3a2c522f229ff56993779895e7c', '', '0', 'chengji\\20200902\\240ced4836721d7a09d075ff6746be03.xlsx', '1599028629', '1599028629', '');
INSERT INTO `cj_fields` VALUES ('19', '11103', '考试五（部分学科参加考试）成绩采集表200902143733.xlsx', '1599028804', '482c0f0211ce0f115424819cc6acbfc4.xlsx', 'xlsx', '11058', '1f29e02065fc2b9e124ba4d041b707c4b6697e6f', '', '0', 'chengji\\20200902\\482c0f0211ce0f115424819cc6acbfc4.xlsx', '1599028805', '1599028805', '');
INSERT INTO `cj_fields` VALUES ('20', '11103', '考试五（部分学科参加考试）成绩采集表200902143738.xlsx', '1599028807', 'b56e9c78e4775d847a32d0b0095e981b.xlsx', 'xlsx', '14189', '31ee80108137eb7506b5672023cb222e04cc457b', '', '0', 'chengji\\20200902\\b56e9c78e4775d847a32d0b0095e981b.xlsx', '1599028807', '1599028807', '');
INSERT INTO `cj_fields` VALUES ('21', '11103', '考试五（部分学科参加考试）成绩采集表200902143745.xlsx', '1599028810', 'c3fec41e9b3a2588530cf6ec3df5fe94.xlsx', 'xlsx', '10096', 'f2f4184994cc44c64d21fb8a8bff811ba46ee4ff', '', '0', 'chengji\\20200902\\c3fec41e9b3a2588530cf6ec3df5fe94.xlsx', '1599028810', '1599028810', '');
INSERT INTO `cj_fields` VALUES ('22', '11103', '考试五（部分学科参加考试）成绩采集表200902143751.xlsx', '1599028812', '450021b982032550619b8e21c14d8718.xlsx', 'xlsx', '11986', 'ddce31cb1624d1554938f99b9318002dcdfbb05e', '', '0', 'chengji\\20200902\\450021b982032550619b8e21c14d8718.xlsx', '1599028813', '1599028813', '');
INSERT INTO `cj_fields` VALUES ('23', '11103', '考试七（所有学科部分班级参加考试）成绩采集表200902144034.xlsx', '1599028910', '2c84208e17da1ab60a0eeeaf68b9153c.xlsx', 'xlsx', '13967', '5b1fd029b40bfadf4d9a75c2f7c730485f5f7829', '', '0', 'chengji\\20200902\\2c84208e17da1ab60a0eeeaf68b9153c.xlsx', '1599028910', '1599028910', '');
INSERT INTO `cj_fields` VALUES ('24', '11103', '考试七（所有学科部分班级参加考试）成绩采集表200902144043.xlsx', '1599028912', '7b8cb6a72ffd2281e9e28ea4d95f598a.xlsx', 'xlsx', '10815', '3e76b8cdd8c8d7b47812c6de92ae62c600c3b2bb', '', '0', 'chengji\\20200902\\7b8cb6a72ffd2281e9e28ea4d95f598a.xlsx', '1599028912', '1599028912', '');
INSERT INTO `cj_fields` VALUES ('25', '11103', '考试六（全部参加考试但满分不同）成绩采集表200902144207.xlsx', '1599029866', 'baa32fd5cc005b245bd2f2f61a62945a.xlsx', 'xlsx', '15545', 'a8c682e01cd5412a9100b7c7acbc1f638a1f11fd', '', '0', 'chengji\\20200902\\baa32fd5cc005b245bd2f2f61a62945a.xlsx', '1599029866', '1599029866', '');
INSERT INTO `cj_fields` VALUES ('26', '11103', '考试六（全部参加考试但满分不同）成绩采集表200902144219.xlsx', '1599029869', 'c1eb76656f3fba778424ad967075fbdb.xlsx', 'xlsx', '12742', '2bdfd1a7f114d54ca163560ee48deb9b23395f52', '', '0', 'chengji\\20200902\\c1eb76656f3fba778424ad967075fbdb.xlsx', '1599029869', '1599029869', '');
INSERT INTO `cj_fields` VALUES ('27', '11103', '考试六（全部参加考试但满分不同）成绩采集表200902150103.xlsx', '1599030195', 'a6d504c19201e0b43dec9e94c9bfe91b.xlsx', 'xlsx', '11485', 'ec6f31cd1610a1ef606853599ebc875e648ceb32', '', '0', 'chengji\\20200902\\a6d504c19201e0b43dec9e94c9bfe91b.xlsx', '1599030195', '1599030195', '');
INSERT INTO `cj_fields` VALUES ('28', '11103', '考试六（全部参加考试但满分不同）成绩采集表200902150109.xlsx', '1599030198', '47e46d047af345424a9841a8ab175f0a.xlsx', 'xlsx', '10324', '2cbb0c0214ab467cc1320b3cb5e5b08cc4b7c403', '', '0', 'chengji\\20200902\\47e46d047af345424a9841a8ab175f0a.xlsx', '1599030198', '1599030198', '');
INSERT INTO `cj_fields` VALUES ('29', '11103', '考试九(统计成绩测试)成绩采集表200902153710.xlsx', '1599032417', '4d46d9773f3b526688bcd28161b6396d.xlsx', 'xlsx', '15247', '626dd34ad85fe0583b26d31f31fb70797a0c072e', '', '0', 'chengji\\20200902\\4d46d9773f3b526688bcd28161b6396d.xlsx', '1599032417', '1599032417', '');
INSERT INTO `cj_fields` VALUES ('30', '11103', '考试九(统计成绩测试)成绩采集表200902153730.xlsx', '1599032422', '6274c28142afd1c0e5ad3eb4ef2103f1.xlsx', 'xlsx', '11430', '3f3c97aafabc5c9f381e713b807b2d68596195d9', '', '0', 'chengji\\20200902\\6274c28142afd1c0e5ad3eb4ef2103f1.xlsx', '1599032422', '1599032422', '');
INSERT INTO `cj_fields` VALUES ('31', '11103', '考试九(统计成绩测试)成绩采集表200902153737.xlsx', '1599032426', 'ee6478230432b31d29efe6b9d416c289.xlsx', 'xlsx', '10285', '5da58cc74415cead99f7ab16e154f0d39aac5252', '', '0', 'chengji\\20200902\\ee6478230432b31d29efe6b9d416c289.xlsx', '1599032426', '1599032426', '');
INSERT INTO `cj_fields` VALUES ('32', '11103', '考试九(统计成绩测试)成绩采集表200902153743.xlsx', '1599032430', 'd2b797d6c91dd568c3466dab0612967f.xlsx', 'xlsx', '12890', '728f2008b2be6019acc210cf787483465a8b6f43', '', '0', 'chengji\\20200902\\d2b797d6c91dd568c3466dab0612967f.xlsx', '1599032430', '1599032430', '');
INSERT INTO `cj_fields` VALUES ('33', '11103', '考试八(学生测试)成绩采集表200905162412.xlsx', '1599294306', '57c693145c5e92a868b8a8822efa34b7.xlsx', 'xlsx', '11048', 'b79b02224faceda7a558e875be5d733d89a020ab', '', '0', 'chengji\\20200905\\57c693145c5e92a868b8a8822efa34b7.xlsx', '1599294307', '1599294307', '');
INSERT INTO `cj_fields` VALUES ('34', '11103', '考试八(学生测试)成绩采集表200910151848.xlsx', '1599722422', '676a482d38c48124399af065afa1b426.xlsx', 'xlsx', '8697', '3e9a3a319cc72d125ad5d1aef70fec088824446c', 'admin', '3', 'chengji\\20200910\\676a482d38c48124399af065afa1b426.xlsx', '1599722422', '1599722422', '');
INSERT INTO `cj_fields` VALUES ('35', '11103', '2019～2020学年度第一学期成绩采集表200906093011.xlsx', '1600169561', 'f25add50f2920f6219056b94995bfe82.xlsx', 'xlsx', '11548', '0cd7c7b0d09eec10398b92598d663567ba993464', 'teacher', '2', 'chengji\\20200915\\f25add50f2920f6219056b94995bfe82.xlsx', '1600169561', '1600169561', '');
INSERT INTO `cj_fields` VALUES ('36', '11103', '考试一成绩采集表200910194722.xlsx', '1600169665', '285be0b4f4b5a4b05b3ee4eb5c1b86df.xlsx', 'xlsx', '9729', 'b11b43187aa3d425fd6a854b62d5cd0793b990d9', 'admin', '4', 'chengji\\20200915\\285be0b4f4b5a4b05b3ee4eb5c1b86df.xlsx', '1600169666', '1600169666', '');
INSERT INTO `cj_fields` VALUES ('37', '11103', '考试八(学生测试)成绩采集表200915201253.xlsx', '1600172505', '764afd816d8d53e2fdadd3b626f3eb9d.xlsx', 'xlsx', '10622', 'fa8b0cd3aa86ed3d1d35a351662a79bf74b8ccf3', 'admin', '4', 'chengji\\20200915\\764afd816d8d53e2fdadd3b626f3eb9d.xlsx', '1600172505', '1600172505', '');

-- -----------------------------
-- Table structure for `cj_js_rongyu`
-- -----------------------------
DROP TABLE IF EXISTS `cj_js_rongyu`;
CREATE TABLE `cj_js_rongyu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT 'a' COMMENT '荣誉册名称',
  `fzschool_id` int(11) NOT NULL DEFAULT '0' COMMENT '发证单位',
  `fzshijian` int(11) NOT NULL DEFAULT '1539158918' COMMENT '发证时间',
  `category_id` int(11) NOT NULL DEFAULT '0' COMMENT '类型',
  `create_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '更新时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0=禁用，1=正常',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- -----------------------------
-- Table structure for `cj_js_rongyu_canyu`
-- -----------------------------
DROP TABLE IF EXISTS `cj_js_rongyu_canyu`;
CREATE TABLE `cj_js_rongyu_canyu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL DEFAULT '0' COMMENT '获奖人或参与人',
  `rongyu_id` int(11) NOT NULL DEFAULT '0' COMMENT '荣誉id',
  `teacher_id` int(11) NOT NULL DEFAULT '0' COMMENT '教师id',
  `create_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '更新时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- -----------------------------
-- Table structure for `cj_js_rongyu_info`
-- -----------------------------
DROP TABLE IF EXISTS `cj_js_rongyu_info`;
CREATE TABLE `cj_js_rongyu_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT 'a' COMMENT '获奖内容标题',
  `rongyuce_id` int(11) NOT NULL DEFAULT '0' COMMENT '荣誉册',
  `bianhao` varchar(15) DEFAULT NULL COMMENT '证书编号',
  `hjschool_id` int(11) DEFAULT NULL COMMENT '证书所属单位',
  `subject_id` int(11) DEFAULT NULL COMMENT '所属学科',
  `jiangxiang_id` int(11) DEFAULT NULL COMMENT '荣誉奖项',
  `pic` varchar(100) DEFAULT NULL COMMENT '证书图片',
  `hjshijian` int(11) DEFAULT NULL COMMENT '获奖时间',
  `create_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '更新时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0=禁用，1=正常',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- -----------------------------
-- Table structure for `cj_kaohao`
-- -----------------------------
DROP TABLE IF EXISTS `cj_kaohao`;
CREATE TABLE `cj_kaohao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kaoshi_id` int(11) NOT NULL DEFAULT '0' COMMENT '考试',
  `school_id` int(11) NOT NULL DEFAULT '0' COMMENT '学校',
  `ruxuenian` int(4) NOT NULL DEFAULT '0' COMMENT '入学年',
  `nianji` varchar(4) NOT NULL DEFAULT 'a' COMMENT '年级',
  `banji_id` int(11) NOT NULL DEFAULT '0' COMMENT '班级',
  `paixu` int(11) NOT NULL DEFAULT '0' COMMENT '班级排序',
  `student_id` int(11) NOT NULL DEFAULT '0' COMMENT '学生',
  `create_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '更新时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0=禁用，1=正常',
  PRIMARY KEY (`id`),
  UNIQUE KEY `kaoshi_id` (`kaoshi_id`,`student_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1241 DEFAULT CHARSET=utf8;

-- -----------------------------
-- Records of `cj_kaohao`
-- -----------------------------
INSERT INTO `cj_kaohao` VALUES ('1', '1', '2', '2020', '一年级', '1', '1', '1', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('2', '1', '2', '2020', '一年级', '1', '1', '2', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('3', '1', '2', '2020', '一年级', '1', '1', '3', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('4', '1', '2', '2020', '一年级', '1', '1', '4', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('5', '1', '2', '2020', '一年级', '1', '1', '5', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('6', '1', '2', '2020', '一年级', '1', '1', '6', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('7', '1', '2', '2020', '一年级', '1', '1', '7', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('8', '1', '2', '2020', '一年级', '1', '1', '8', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('9', '1', '2', '2020', '一年级', '1', '1', '9', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('10', '1', '2', '2020', '一年级', '1', '1', '10', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('11', '1', '2', '2020', '一年级', '1', '1', '11', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('12', '1', '2', '2020', '一年级', '1', '1', '12', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('13', '1', '2', '2020', '一年级', '1', '1', '13', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('14', '1', '2', '2020', '一年级', '1', '1', '14', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('15', '1', '2', '2020', '一年级', '1', '1', '15', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('16', '1', '2', '2020', '一年级', '1', '1', '16', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('17', '1', '2', '2020', '一年级', '1', '1', '17', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('18', '1', '2', '2020', '一年级', '1', '1', '18', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('19', '1', '2', '2020', '一年级', '1', '1', '19', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('20', '1', '2', '2020', '一年级', '1', '1', '20', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('21', '1', '2', '2020', '一年级', '1', '1', '21', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('22', '1', '2', '2020', '一年级', '1', '1', '22', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('23', '1', '2', '2020', '一年级', '2', '2', '23', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('24', '1', '2', '2020', '一年级', '2', '2', '24', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('25', '1', '2', '2020', '一年级', '2', '2', '25', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('26', '1', '2', '2020', '一年级', '2', '2', '26', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('27', '1', '2', '2020', '一年级', '2', '2', '27', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('28', '1', '2', '2020', '一年级', '2', '2', '28', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('29', '1', '2', '2020', '一年级', '2', '2', '29', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('30', '1', '2', '2020', '一年级', '2', '2', '30', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('31', '1', '2', '2020', '一年级', '2', '2', '31', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('32', '1', '2', '2020', '一年级', '2', '2', '32', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('33', '1', '2', '2020', '一年级', '2', '2', '33', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('34', '1', '2', '2020', '一年级', '2', '2', '34', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('35', '1', '2', '2020', '一年级', '2', '2', '35', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('36', '1', '2', '2020', '一年级', '2', '2', '36', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('37', '1', '2', '2020', '一年级', '2', '2', '37', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('38', '1', '2', '2020', '一年级', '2', '2', '38', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('39', '1', '2', '2020', '一年级', '3', '3', '39', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('40', '1', '2', '2020', '一年级', '3', '3', '40', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('41', '1', '2', '2020', '一年级', '3', '3', '41', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('42', '1', '2', '2020', '一年级', '3', '3', '42', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('43', '1', '2', '2020', '一年级', '3', '3', '43', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('44', '1', '2', '2020', '一年级', '3', '3', '44', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('45', '1', '2', '2020', '一年级', '3', '3', '45', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('46', '1', '2', '2020', '一年级', '3', '3', '46', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('47', '1', '2', '2020', '一年级', '3', '3', '47', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('48', '1', '2', '2020', '一年级', '3', '3', '48', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('49', '1', '2', '2020', '一年级', '3', '3', '49', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('50', '1', '2', '2020', '一年级', '3', '3', '50', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('51', '1', '2', '2020', '一年级', '3', '3', '51', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('52', '1', '2', '2020', '一年级', '3', '3', '52', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('53', '1', '2', '2020', '一年级', '3', '3', '53', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('54', '1', '2', '2020', '一年级', '3', '3', '54', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('55', '1', '2', '2020', '一年级', '3', '3', '55', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('56', '1', '2', '2020', '一年级', '3', '3', '56', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('57', '1', '2', '2020', '一年级', '3', '3', '57', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('58', '1', '2', '2020', '一年级', '3', '3', '58', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('59', '1', '2', '2020', '一年级', '3', '3', '59', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('60', '1', '2', '2020', '一年级', '3', '3', '60', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('61', '1', '2', '2020', '一年级', '3', '3', '61', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('62', '1', '2', '2020', '一年级', '3', '3', '62', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('63', '1', '2', '2020', '一年级', '3', '3', '63', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('64', '1', '2', '2020', '一年级', '3', '3', '64', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('65', '1', '2', '2020', '一年级', '3', '3', '65', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('66', '1', '2', '2020', '一年级', '3', '3', '66', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('67', '1', '2', '2020', '一年级', '3', '3', '67', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('68', '1', '2', '2020', '一年级', '3', '3', '68', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('69', '1', '2', '2020', '一年级', '3', '3', '69', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('70', '1', '2', '2020', '一年级', '3', '3', '70', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('71', '1', '2', '2020', '一年级', '3', '3', '71', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('72', '1', '2', '2020', '一年级', '3', '3', '72', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('73', '1', '2', '2019', '二年级', '6', '1', '73', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('74', '1', '2', '2019', '二年级', '6', '1', '74', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('75', '1', '2', '2019', '二年级', '6', '1', '75', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('76', '1', '2', '2019', '二年级', '6', '1', '76', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('77', '1', '2', '2019', '二年级', '6', '1', '77', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('78', '1', '2', '2019', '二年级', '6', '1', '78', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('79', '1', '2', '2019', '二年级', '6', '1', '79', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('80', '1', '2', '2019', '二年级', '6', '1', '80', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('81', '1', '2', '2019', '二年级', '6', '1', '81', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('82', '1', '2', '2019', '二年级', '6', '1', '82', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('83', '1', '2', '2019', '二年级', '6', '1', '83', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('84', '1', '2', '2019', '二年级', '6', '1', '84', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('85', '1', '2', '2019', '二年级', '6', '1', '85', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('86', '1', '2', '2019', '二年级', '6', '1', '86', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('87', '1', '2', '2019', '二年级', '6', '1', '87', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('88', '1', '2', '2019', '二年级', '6', '1', '88', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('89', '1', '2', '2019', '二年级', '6', '1', '89', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('90', '1', '2', '2019', '二年级', '6', '1', '90', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('91', '1', '2', '2019', '二年级', '6', '1', '91', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('92', '1', '2', '2019', '二年级', '6', '1', '92', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('93', '1', '2', '2019', '二年级', '6', '1', '93', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('94', '1', '2', '2019', '二年级', '6', '1', '94', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('95', '1', '2', '2019', '二年级', '6', '1', '95', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('96', '1', '2', '2019', '二年级', '6', '1', '96', '1599024843', '1599024843', '', '1');
INSERT INTO `cj_kaohao` VALUES ('97', '1', '3', '2020', '一年级', '4', '1', '97', '1599024851', '1599024851', '', '1');
INSERT INTO `cj_kaohao` VALUES ('98', '1', '3', '2020', '一年级', '4', '1', '98', '1599024851', '1599024851', '', '1');
INSERT INTO `cj_kaohao` VALUES ('99', '1', '3', '2020', '一年级', '4', '1', '99', '1599024851', '1599024851', '', '1');
INSERT INTO `cj_kaohao` VALUES ('100', '1', '3', '2020', '一年级', '4', '1', '100', '1599024851', '1599024851', '', '1');
INSERT INTO `cj_kaohao` VALUES ('101', '1', '3', '2020', '一年级', '4', '1', '101', '1599024851', '1599024851', '', '1');
INSERT INTO `cj_kaohao` VALUES ('102', '1', '3', '2020', '一年级', '4', '1', '102', '1599024851', '1599024851', '', '1');
INSERT INTO `cj_kaohao` VALUES ('103', '1', '3', '2020', '一年级', '4', '1', '103', '1599024851', '1599024851', '', '1');
INSERT INTO `cj_kaohao` VALUES ('104', '1', '3', '2020', '一年级', '4', '1', '104', '1599024851', '1599024851', '', '1');
INSERT INTO `cj_kaohao` VALUES ('105', '1', '3', '2020', '一年级', '4', '1', '105', '1599024851', '1599024851', '', '1');
INSERT INTO `cj_kaohao` VALUES ('106', '1', '3', '2020', '一年级', '4', '1', '106', '1599024851', '1599024851', '', '1');
INSERT INTO `cj_kaohao` VALUES ('107', '1', '3', '2020', '一年级', '4', '1', '107', '1599024851', '1599024851', '', '1');
INSERT INTO `cj_kaohao` VALUES ('108', '1', '3', '2020', '一年级', '4', '1', '108', '1599024851', '1599024851', '', '1');
INSERT INTO `cj_kaohao` VALUES ('109', '1', '3', '2020', '一年级', '4', '1', '109', '1599024851', '1599024851', '', '1');
INSERT INTO `cj_kaohao` VALUES ('110', '1', '3', '2020', '一年级', '4', '1', '110', '1599024851', '1599024851', '', '1');
INSERT INTO `cj_kaohao` VALUES ('111', '1', '3', '2020', '一年级', '4', '1', '111', '1599024851', '1599024851', '', '1');
INSERT INTO `cj_kaohao` VALUES ('112', '1', '3', '2020', '一年级', '4', '1', '112', '1599024851', '1599024851', '', '1');
INSERT INTO `cj_kaohao` VALUES ('113', '1', '3', '2020', '一年级', '4', '1', '113', '1599024851', '1599024851', '', '1');
INSERT INTO `cj_kaohao` VALUES ('114', '1', '3', '2020', '一年级', '4', '1', '114', '1599024851', '1599024851', '', '1');
INSERT INTO `cj_kaohao` VALUES ('115', '1', '3', '2020', '一年级', '4', '1', '115', '1599024851', '1599024851', '', '1');
INSERT INTO `cj_kaohao` VALUES ('116', '1', '3', '2020', '一年级', '4', '1', '116', '1599024851', '1599024851', '', '1');
INSERT INTO `cj_kaohao` VALUES ('117', '1', '3', '2020', '一年级', '4', '1', '117', '1599024851', '1599024851', '', '1');
INSERT INTO `cj_kaohao` VALUES ('118', '1', '3', '2020', '一年级', '4', '1', '118', '1599024851', '1599024851', '', '1');
INSERT INTO `cj_kaohao` VALUES ('119', '1', '3', '2020', '一年级', '5', '2', '119', '1599024851', '1599024851', '', '1');
INSERT INTO `cj_kaohao` VALUES ('120', '1', '3', '2020', '一年级', '5', '2', '120', '1599024851', '1599024851', '', '1');
INSERT INTO `cj_kaohao` VALUES ('121', '1', '3', '2020', '一年级', '5', '2', '121', '1599024851', '1599024851', '', '1');
INSERT INTO `cj_kaohao` VALUES ('122', '1', '3', '2020', '一年级', '5', '2', '122', '1599024851', '1599024851', '', '1');
INSERT INTO `cj_kaohao` VALUES ('123', '1', '3', '2020', '一年级', '5', '2', '123', '1599024851', '1599024851', '', '1');
INSERT INTO `cj_kaohao` VALUES ('124', '1', '3', '2020', '一年级', '5', '2', '124', '1599024851', '1599024851', '', '1');
INSERT INTO `cj_kaohao` VALUES ('125', '1', '3', '2020', '一年级', '5', '2', '125', '1599024851', '1599024851', '', '1');
INSERT INTO `cj_kaohao` VALUES ('126', '1', '3', '2020', '一年级', '5', '2', '126', '1599024851', '1599024851', '', '1');
INSERT INTO `cj_kaohao` VALUES ('127', '1', '3', '2020', '一年级', '5', '2', '127', '1599024851', '1599024851', '', '1');
INSERT INTO `cj_kaohao` VALUES ('128', '1', '3', '2020', '一年级', '5', '2', '128', '1599024851', '1599024851', '', '1');
INSERT INTO `cj_kaohao` VALUES ('129', '1', '3', '2020', '一年级', '5', '2', '129', '1599024851', '1599024851', '', '1');
INSERT INTO `cj_kaohao` VALUES ('130', '1', '3', '2020', '一年级', '5', '2', '130', '1599024851', '1599024851', '', '1');
INSERT INTO `cj_kaohao` VALUES ('131', '1', '3', '2020', '一年级', '5', '2', '131', '1599024851', '1599024851', '', '1');
INSERT INTO `cj_kaohao` VALUES ('132', '1', '3', '2020', '一年级', '5', '2', '132', '1599024851', '1599024851', '', '1');
INSERT INTO `cj_kaohao` VALUES ('133', '1', '3', '2020', '一年级', '5', '2', '133', '1599024851', '1599024851', '', '1');
INSERT INTO `cj_kaohao` VALUES ('134', '1', '3', '2020', '一年级', '5', '2', '134', '1599024851', '1599024851', '', '1');
INSERT INTO `cj_kaohao` VALUES ('135', '1', '3', '2019', '二年级', '7', '1', '135', '1599024851', '1599024851', '', '1');
INSERT INTO `cj_kaohao` VALUES ('136', '1', '3', '2019', '二年级', '7', '1', '136', '1599024851', '1599024851', '', '1');
INSERT INTO `cj_kaohao` VALUES ('137', '1', '3', '2019', '二年级', '7', '1', '137', '1599024851', '1599024851', '', '1');
INSERT INTO `cj_kaohao` VALUES ('138', '1', '3', '2019', '二年级', '7', '1', '138', '1599024851', '1599024851', '', '1');
INSERT INTO `cj_kaohao` VALUES ('139', '1', '3', '2019', '二年级', '7', '1', '139', '1599024851', '1599024851', '', '1');
INSERT INTO `cj_kaohao` VALUES ('140', '1', '3', '2019', '二年级', '7', '1', '140', '1599024851', '1599024851', '', '1');
INSERT INTO `cj_kaohao` VALUES ('141', '1', '3', '2019', '二年级', '7', '1', '141', '1599024851', '1599024851', '', '1');
INSERT INTO `cj_kaohao` VALUES ('142', '1', '3', '2019', '二年级', '7', '1', '142', '1599024851', '1599024851', '', '1');
INSERT INTO `cj_kaohao` VALUES ('143', '1', '3', '2019', '二年级', '7', '1', '143', '1599024851', '1599024851', '', '1');
INSERT INTO `cj_kaohao` VALUES ('144', '1', '3', '2019', '二年级', '7', '1', '144', '1599024851', '1599024851', '', '1');
INSERT INTO `cj_kaohao` VALUES ('145', '2', '2', '2020', '一年级', '1', '1', '1', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('146', '2', '2', '2020', '一年级', '1', '1', '2', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('147', '2', '2', '2020', '一年级', '1', '1', '3', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('148', '2', '2', '2020', '一年级', '1', '1', '4', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('149', '2', '2', '2020', '一年级', '1', '1', '5', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('150', '2', '2', '2020', '一年级', '1', '1', '6', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('151', '2', '2', '2020', '一年级', '1', '1', '7', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('152', '2', '2', '2020', '一年级', '1', '1', '8', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('153', '2', '2', '2020', '一年级', '1', '1', '9', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('154', '2', '2', '2020', '一年级', '1', '1', '10', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('155', '2', '2', '2020', '一年级', '1', '1', '11', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('156', '2', '2', '2020', '一年级', '1', '1', '12', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('157', '2', '2', '2020', '一年级', '1', '1', '13', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('158', '2', '2', '2020', '一年级', '1', '1', '14', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('159', '2', '2', '2020', '一年级', '1', '1', '15', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('160', '2', '2', '2020', '一年级', '1', '1', '16', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('161', '2', '2', '2020', '一年级', '1', '1', '17', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('162', '2', '2', '2020', '一年级', '1', '1', '18', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('163', '2', '2', '2020', '一年级', '1', '1', '19', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('164', '2', '2', '2020', '一年级', '1', '1', '20', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('165', '2', '2', '2020', '一年级', '1', '1', '21', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('166', '2', '2', '2020', '一年级', '1', '1', '22', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('167', '2', '2', '2020', '一年级', '2', '2', '23', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('168', '2', '2', '2020', '一年级', '2', '2', '24', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('169', '2', '2', '2020', '一年级', '2', '2', '25', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('170', '2', '2', '2020', '一年级', '2', '2', '26', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('171', '2', '2', '2020', '一年级', '2', '2', '27', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('172', '2', '2', '2020', '一年级', '2', '2', '28', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('173', '2', '2', '2020', '一年级', '2', '2', '29', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('174', '2', '2', '2020', '一年级', '2', '2', '30', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('175', '2', '2', '2020', '一年级', '2', '2', '31', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('176', '2', '2', '2020', '一年级', '2', '2', '32', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('177', '2', '2', '2020', '一年级', '2', '2', '33', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('178', '2', '2', '2020', '一年级', '2', '2', '34', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('179', '2', '2', '2020', '一年级', '2', '2', '35', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('180', '2', '2', '2020', '一年级', '2', '2', '36', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('181', '2', '2', '2020', '一年级', '2', '2', '37', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('182', '2', '2', '2020', '一年级', '2', '2', '38', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('183', '2', '2', '2020', '一年级', '3', '3', '39', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('184', '2', '2', '2020', '一年级', '3', '3', '40', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('185', '2', '2', '2020', '一年级', '3', '3', '41', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('186', '2', '2', '2020', '一年级', '3', '3', '42', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('187', '2', '2', '2020', '一年级', '3', '3', '43', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('188', '2', '2', '2020', '一年级', '3', '3', '44', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('189', '2', '2', '2020', '一年级', '3', '3', '45', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('190', '2', '2', '2020', '一年级', '3', '3', '46', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('191', '2', '2', '2020', '一年级', '3', '3', '47', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('192', '2', '2', '2020', '一年级', '3', '3', '48', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('193', '2', '2', '2020', '一年级', '3', '3', '49', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('194', '2', '2', '2020', '一年级', '3', '3', '50', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('195', '2', '2', '2020', '一年级', '3', '3', '51', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('196', '2', '2', '2020', '一年级', '3', '3', '52', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('197', '2', '2', '2020', '一年级', '3', '3', '53', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('198', '2', '2', '2020', '一年级', '3', '3', '54', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('199', '2', '2', '2020', '一年级', '3', '3', '55', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('200', '2', '2', '2020', '一年级', '3', '3', '56', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('201', '2', '2', '2020', '一年级', '3', '3', '57', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('202', '2', '2', '2020', '一年级', '3', '3', '58', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('203', '2', '2', '2020', '一年级', '3', '3', '59', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('204', '2', '2', '2020', '一年级', '3', '3', '60', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('205', '2', '2', '2020', '一年级', '3', '3', '61', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('206', '2', '2', '2020', '一年级', '3', '3', '62', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('207', '2', '2', '2020', '一年级', '3', '3', '63', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('208', '2', '2', '2020', '一年级', '3', '3', '64', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('209', '2', '2', '2020', '一年级', '3', '3', '65', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('210', '2', '2', '2020', '一年级', '3', '3', '66', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('211', '2', '2', '2020', '一年级', '3', '3', '67', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('212', '2', '2', '2020', '一年级', '3', '3', '68', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('213', '2', '2', '2020', '一年级', '3', '3', '69', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('214', '2', '2', '2020', '一年级', '3', '3', '70', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('215', '2', '2', '2020', '一年级', '3', '3', '71', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('216', '2', '2', '2020', '一年级', '3', '3', '72', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('217', '2', '2', '2019', '二年级', '6', '1', '73', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('218', '2', '2', '2019', '二年级', '6', '1', '74', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('219', '2', '2', '2019', '二年级', '6', '1', '75', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('220', '2', '2', '2019', '二年级', '6', '1', '76', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('221', '2', '2', '2019', '二年级', '6', '1', '77', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('222', '2', '2', '2019', '二年级', '6', '1', '78', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('223', '2', '2', '2019', '二年级', '6', '1', '79', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('224', '2', '2', '2019', '二年级', '6', '1', '80', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('225', '2', '2', '2019', '二年级', '6', '1', '81', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('226', '2', '2', '2019', '二年级', '6', '1', '82', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('227', '2', '2', '2019', '二年级', '6', '1', '83', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('228', '2', '2', '2019', '二年级', '6', '1', '84', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('229', '2', '2', '2019', '二年级', '6', '1', '85', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('230', '2', '2', '2019', '二年级', '6', '1', '86', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('231', '2', '2', '2019', '二年级', '6', '1', '87', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('232', '2', '2', '2019', '二年级', '6', '1', '88', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('233', '2', '2', '2019', '二年级', '6', '1', '89', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('234', '2', '2', '2019', '二年级', '6', '1', '90', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('235', '2', '2', '2019', '二年级', '6', '1', '91', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('236', '2', '2', '2019', '二年级', '6', '1', '92', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('237', '2', '2', '2019', '二年级', '6', '1', '93', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('238', '2', '2', '2019', '二年级', '6', '1', '94', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('239', '2', '2', '2019', '二年级', '6', '1', '95', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('240', '2', '2', '2019', '二年级', '6', '1', '96', '1599024863', '1599024863', '', '1');
INSERT INTO `cj_kaohao` VALUES ('241', '2', '3', '2020', '一年级', '4', '1', '97', '1599024871', '1599024871', '', '1');
INSERT INTO `cj_kaohao` VALUES ('242', '2', '3', '2020', '一年级', '4', '1', '98', '1599024871', '1599024871', '', '1');
INSERT INTO `cj_kaohao` VALUES ('243', '2', '3', '2020', '一年级', '4', '1', '99', '1599024871', '1599024871', '', '1');
INSERT INTO `cj_kaohao` VALUES ('244', '2', '3', '2020', '一年级', '4', '1', '100', '1599024871', '1599024871', '', '1');
INSERT INTO `cj_kaohao` VALUES ('245', '2', '3', '2020', '一年级', '4', '1', '101', '1599024871', '1599024871', '', '1');
INSERT INTO `cj_kaohao` VALUES ('246', '2', '3', '2020', '一年级', '4', '1', '102', '1599024871', '1599024871', '', '1');
INSERT INTO `cj_kaohao` VALUES ('247', '2', '3', '2020', '一年级', '4', '1', '103', '1599024871', '1599024871', '', '1');
INSERT INTO `cj_kaohao` VALUES ('248', '2', '3', '2020', '一年级', '4', '1', '104', '1599024871', '1599024871', '', '1');
INSERT INTO `cj_kaohao` VALUES ('249', '2', '3', '2020', '一年级', '4', '1', '105', '1599024871', '1599024871', '', '1');
INSERT INTO `cj_kaohao` VALUES ('250', '2', '3', '2020', '一年级', '4', '1', '106', '1599024871', '1599024871', '', '1');
INSERT INTO `cj_kaohao` VALUES ('251', '2', '3', '2020', '一年级', '4', '1', '107', '1599024871', '1599024871', '', '1');
INSERT INTO `cj_kaohao` VALUES ('252', '2', '3', '2020', '一年级', '4', '1', '108', '1599024871', '1599024871', '', '1');
INSERT INTO `cj_kaohao` VALUES ('253', '2', '3', '2020', '一年级', '4', '1', '109', '1599024871', '1599024871', '', '1');
INSERT INTO `cj_kaohao` VALUES ('254', '2', '3', '2020', '一年级', '4', '1', '110', '1599024871', '1599024871', '', '1');
INSERT INTO `cj_kaohao` VALUES ('255', '2', '3', '2020', '一年级', '4', '1', '111', '1599024871', '1599024871', '', '1');
INSERT INTO `cj_kaohao` VALUES ('256', '2', '3', '2020', '一年级', '4', '1', '112', '1599024871', '1599024871', '', '1');
INSERT INTO `cj_kaohao` VALUES ('257', '2', '3', '2020', '一年级', '4', '1', '113', '1599024871', '1599024871', '', '1');
INSERT INTO `cj_kaohao` VALUES ('258', '2', '3', '2020', '一年级', '4', '1', '114', '1599024871', '1599024871', '', '1');
INSERT INTO `cj_kaohao` VALUES ('259', '2', '3', '2020', '一年级', '4', '1', '115', '1599024871', '1599024871', '', '1');
INSERT INTO `cj_kaohao` VALUES ('260', '2', '3', '2020', '一年级', '4', '1', '116', '1599024871', '1599024871', '', '1');
INSERT INTO `cj_kaohao` VALUES ('261', '2', '3', '2020', '一年级', '4', '1', '117', '1599024871', '1599024871', '', '1');
INSERT INTO `cj_kaohao` VALUES ('262', '2', '3', '2020', '一年级', '4', '1', '118', '1599024871', '1599024871', '', '1');
INSERT INTO `cj_kaohao` VALUES ('263', '2', '3', '2020', '一年级', '5', '2', '119', '1599024871', '1599024871', '', '1');
INSERT INTO `cj_kaohao` VALUES ('264', '2', '3', '2020', '一年级', '5', '2', '120', '1599024871', '1599024871', '', '1');
INSERT INTO `cj_kaohao` VALUES ('265', '2', '3', '2020', '一年级', '5', '2', '121', '1599024871', '1599024871', '', '1');
INSERT INTO `cj_kaohao` VALUES ('266', '2', '3', '2020', '一年级', '5', '2', '122', '1599024871', '1599024871', '', '1');
INSERT INTO `cj_kaohao` VALUES ('267', '2', '3', '2020', '一年级', '5', '2', '123', '1599024871', '1599024871', '', '1');
INSERT INTO `cj_kaohao` VALUES ('268', '2', '3', '2020', '一年级', '5', '2', '124', '1599024871', '1599024871', '', '1');
INSERT INTO `cj_kaohao` VALUES ('269', '2', '3', '2020', '一年级', '5', '2', '125', '1599024871', '1599024871', '', '1');
INSERT INTO `cj_kaohao` VALUES ('270', '2', '3', '2020', '一年级', '5', '2', '126', '1599024871', '1599024871', '', '1');
INSERT INTO `cj_kaohao` VALUES ('271', '2', '3', '2020', '一年级', '5', '2', '127', '1599024871', '1599024871', '', '1');
INSERT INTO `cj_kaohao` VALUES ('272', '2', '3', '2020', '一年级', '5', '2', '128', '1599024871', '1599024871', '', '1');
INSERT INTO `cj_kaohao` VALUES ('273', '2', '3', '2020', '一年级', '5', '2', '129', '1599024871', '1599024871', '', '1');
INSERT INTO `cj_kaohao` VALUES ('274', '2', '3', '2020', '一年级', '5', '2', '130', '1599024871', '1599024871', '', '1');
INSERT INTO `cj_kaohao` VALUES ('275', '2', '3', '2020', '一年级', '5', '2', '131', '1599024871', '1599024871', '', '1');
INSERT INTO `cj_kaohao` VALUES ('276', '2', '3', '2020', '一年级', '5', '2', '132', '1599024871', '1599024871', '', '1');
INSERT INTO `cj_kaohao` VALUES ('277', '2', '3', '2020', '一年级', '5', '2', '133', '1599024871', '1599024871', '', '1');
INSERT INTO `cj_kaohao` VALUES ('278', '2', '3', '2020', '一年级', '5', '2', '134', '1599024871', '1599024871', '', '1');
INSERT INTO `cj_kaohao` VALUES ('279', '2', '3', '2019', '二年级', '7', '1', '135', '1599024871', '1599024871', '', '1');
INSERT INTO `cj_kaohao` VALUES ('280', '2', '3', '2019', '二年级', '7', '1', '136', '1599024871', '1599024871', '', '1');
INSERT INTO `cj_kaohao` VALUES ('281', '2', '3', '2019', '二年级', '7', '1', '137', '1599024871', '1599024871', '', '1');
INSERT INTO `cj_kaohao` VALUES ('282', '2', '3', '2019', '二年级', '7', '1', '138', '1599024871', '1599024871', '', '1');
INSERT INTO `cj_kaohao` VALUES ('283', '2', '3', '2019', '二年级', '7', '1', '139', '1599024871', '1599024871', '', '1');
INSERT INTO `cj_kaohao` VALUES ('284', '2', '3', '2019', '二年级', '7', '1', '140', '1599024871', '1599024871', '', '1');
INSERT INTO `cj_kaohao` VALUES ('285', '2', '3', '2019', '二年级', '7', '1', '141', '1599024871', '1599024871', '', '1');
INSERT INTO `cj_kaohao` VALUES ('286', '2', '3', '2019', '二年级', '7', '1', '142', '1599024871', '1599024871', '', '1');
INSERT INTO `cj_kaohao` VALUES ('287', '2', '3', '2019', '二年级', '7', '1', '143', '1599024871', '1599024871', '', '1');
INSERT INTO `cj_kaohao` VALUES ('288', '2', '3', '2019', '二年级', '7', '1', '144', '1599024871', '1599024871', '', '1');
INSERT INTO `cj_kaohao` VALUES ('289', '3', '2', '2020', '一年级', '1', '1', '1', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('290', '3', '2', '2020', '一年级', '1', '1', '2', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('291', '3', '2', '2020', '一年级', '1', '1', '3', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('292', '3', '2', '2020', '一年级', '1', '1', '4', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('293', '3', '2', '2020', '一年级', '1', '1', '5', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('294', '3', '2', '2020', '一年级', '1', '1', '6', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('295', '3', '2', '2020', '一年级', '1', '1', '7', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('296', '3', '2', '2020', '一年级', '1', '1', '8', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('297', '3', '2', '2020', '一年级', '1', '1', '9', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('298', '3', '2', '2020', '一年级', '1', '1', '10', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('299', '3', '2', '2020', '一年级', '1', '1', '11', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('300', '3', '2', '2020', '一年级', '1', '1', '12', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('301', '3', '2', '2020', '一年级', '1', '1', '13', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('302', '3', '2', '2020', '一年级', '1', '1', '14', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('303', '3', '2', '2020', '一年级', '1', '1', '15', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('304', '3', '2', '2020', '一年级', '1', '1', '16', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('305', '3', '2', '2020', '一年级', '1', '1', '17', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('306', '3', '2', '2020', '一年级', '1', '1', '18', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('307', '3', '2', '2020', '一年级', '1', '1', '19', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('308', '3', '2', '2020', '一年级', '1', '1', '20', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('309', '3', '2', '2020', '一年级', '1', '1', '21', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('310', '3', '2', '2020', '一年级', '1', '1', '22', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('311', '3', '2', '2020', '一年级', '2', '2', '23', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('312', '3', '2', '2020', '一年级', '2', '2', '24', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('313', '3', '2', '2020', '一年级', '2', '2', '25', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('314', '3', '2', '2020', '一年级', '2', '2', '26', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('315', '3', '2', '2020', '一年级', '2', '2', '27', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('316', '3', '2', '2020', '一年级', '2', '2', '28', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('317', '3', '2', '2020', '一年级', '2', '2', '29', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('318', '3', '2', '2020', '一年级', '2', '2', '30', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('319', '3', '2', '2020', '一年级', '2', '2', '31', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('320', '3', '2', '2020', '一年级', '2', '2', '32', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('321', '3', '2', '2020', '一年级', '2', '2', '33', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('322', '3', '2', '2020', '一年级', '2', '2', '34', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('323', '3', '2', '2020', '一年级', '2', '2', '35', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('324', '3', '2', '2020', '一年级', '2', '2', '36', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('325', '3', '2', '2020', '一年级', '2', '2', '37', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('326', '3', '2', '2020', '一年级', '2', '2', '38', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('327', '3', '2', '2020', '一年级', '3', '3', '39', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('328', '3', '2', '2020', '一年级', '3', '3', '40', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('329', '3', '2', '2020', '一年级', '3', '3', '41', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('330', '3', '2', '2020', '一年级', '3', '3', '42', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('331', '3', '2', '2020', '一年级', '3', '3', '43', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('332', '3', '2', '2020', '一年级', '3', '3', '44', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('333', '3', '2', '2020', '一年级', '3', '3', '45', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('334', '3', '2', '2020', '一年级', '3', '3', '46', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('335', '3', '2', '2020', '一年级', '3', '3', '47', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('336', '3', '2', '2020', '一年级', '3', '3', '48', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('337', '3', '2', '2020', '一年级', '3', '3', '49', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('338', '3', '2', '2020', '一年级', '3', '3', '50', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('339', '3', '2', '2020', '一年级', '3', '3', '51', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('340', '3', '2', '2020', '一年级', '3', '3', '52', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('341', '3', '2', '2020', '一年级', '3', '3', '53', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('342', '3', '2', '2020', '一年级', '3', '3', '54', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('343', '3', '2', '2020', '一年级', '3', '3', '55', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('344', '3', '2', '2020', '一年级', '3', '3', '56', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('345', '3', '2', '2020', '一年级', '3', '3', '57', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('346', '3', '2', '2020', '一年级', '3', '3', '58', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('347', '3', '2', '2020', '一年级', '3', '3', '59', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('348', '3', '2', '2020', '一年级', '3', '3', '60', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('349', '3', '2', '2020', '一年级', '3', '3', '61', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('350', '3', '2', '2020', '一年级', '3', '3', '62', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('351', '3', '2', '2020', '一年级', '3', '3', '63', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('352', '3', '2', '2020', '一年级', '3', '3', '64', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('353', '3', '2', '2020', '一年级', '3', '3', '65', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('354', '3', '2', '2020', '一年级', '3', '3', '66', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('355', '3', '2', '2020', '一年级', '3', '3', '67', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('356', '3', '2', '2020', '一年级', '3', '3', '68', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('357', '3', '2', '2020', '一年级', '3', '3', '69', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('358', '3', '2', '2020', '一年级', '3', '3', '70', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('359', '3', '2', '2020', '一年级', '3', '3', '71', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('360', '3', '2', '2020', '一年级', '3', '3', '72', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('361', '3', '2', '2019', '二年级', '6', '1', '73', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('362', '3', '2', '2019', '二年级', '6', '1', '74', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('363', '3', '2', '2019', '二年级', '6', '1', '75', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('364', '3', '2', '2019', '二年级', '6', '1', '76', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('365', '3', '2', '2019', '二年级', '6', '1', '77', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('366', '3', '2', '2019', '二年级', '6', '1', '78', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('367', '3', '2', '2019', '二年级', '6', '1', '79', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('368', '3', '2', '2019', '二年级', '6', '1', '80', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('369', '3', '2', '2019', '二年级', '6', '1', '81', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('370', '3', '2', '2019', '二年级', '6', '1', '82', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('371', '3', '2', '2019', '二年级', '6', '1', '83', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('372', '3', '2', '2019', '二年级', '6', '1', '84', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('373', '3', '2', '2019', '二年级', '6', '1', '85', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('374', '3', '2', '2019', '二年级', '6', '1', '86', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('375', '3', '2', '2019', '二年级', '6', '1', '87', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('376', '3', '2', '2019', '二年级', '6', '1', '88', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('377', '3', '2', '2019', '二年级', '6', '1', '89', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('378', '3', '2', '2019', '二年级', '6', '1', '90', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('379', '3', '2', '2019', '二年级', '6', '1', '91', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('380', '3', '2', '2019', '二年级', '6', '1', '92', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('381', '3', '2', '2019', '二年级', '6', '1', '93', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('382', '3', '2', '2019', '二年级', '6', '1', '94', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('383', '3', '2', '2019', '二年级', '6', '1', '95', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('384', '3', '2', '2019', '二年级', '6', '1', '96', '1599024881', '1599024881', '', '1');
INSERT INTO `cj_kaohao` VALUES ('385', '3', '3', '2020', '一年级', '4', '1', '97', '1599024887', '1599024887', '', '1');
INSERT INTO `cj_kaohao` VALUES ('386', '3', '3', '2020', '一年级', '4', '1', '98', '1599024887', '1599024887', '', '1');
INSERT INTO `cj_kaohao` VALUES ('387', '3', '3', '2020', '一年级', '4', '1', '99', '1599024887', '1599024887', '', '1');
INSERT INTO `cj_kaohao` VALUES ('388', '3', '3', '2020', '一年级', '4', '1', '100', '1599024887', '1599024887', '', '1');
INSERT INTO `cj_kaohao` VALUES ('389', '3', '3', '2020', '一年级', '4', '1', '101', '1599024887', '1599024887', '', '1');
INSERT INTO `cj_kaohao` VALUES ('390', '3', '3', '2020', '一年级', '4', '1', '102', '1599024887', '1599024887', '', '1');
INSERT INTO `cj_kaohao` VALUES ('391', '3', '3', '2020', '一年级', '4', '1', '103', '1599024887', '1599024887', '', '1');
INSERT INTO `cj_kaohao` VALUES ('392', '3', '3', '2020', '一年级', '4', '1', '104', '1599024887', '1599024887', '', '1');
INSERT INTO `cj_kaohao` VALUES ('393', '3', '3', '2020', '一年级', '4', '1', '105', '1599024887', '1599024887', '', '1');
INSERT INTO `cj_kaohao` VALUES ('394', '3', '3', '2020', '一年级', '4', '1', '106', '1599024887', '1599024887', '', '1');
INSERT INTO `cj_kaohao` VALUES ('395', '3', '3', '2020', '一年级', '4', '1', '107', '1599024887', '1599024887', '', '1');
INSERT INTO `cj_kaohao` VALUES ('396', '3', '3', '2020', '一年级', '4', '1', '108', '1599024887', '1599024887', '', '1');
INSERT INTO `cj_kaohao` VALUES ('397', '3', '3', '2020', '一年级', '4', '1', '109', '1599024887', '1599024887', '', '1');
INSERT INTO `cj_kaohao` VALUES ('398', '3', '3', '2020', '一年级', '4', '1', '110', '1599024887', '1599024887', '', '1');
INSERT INTO `cj_kaohao` VALUES ('399', '3', '3', '2020', '一年级', '4', '1', '111', '1599024887', '1599024887', '', '1');
INSERT INTO `cj_kaohao` VALUES ('400', '3', '3', '2020', '一年级', '4', '1', '112', '1599024887', '1599024887', '', '1');
INSERT INTO `cj_kaohao` VALUES ('401', '3', '3', '2020', '一年级', '4', '1', '113', '1599024887', '1599024887', '', '1');
INSERT INTO `cj_kaohao` VALUES ('402', '3', '3', '2020', '一年级', '4', '1', '114', '1599024887', '1599024887', '', '1');
INSERT INTO `cj_kaohao` VALUES ('403', '3', '3', '2020', '一年级', '4', '1', '115', '1599024887', '1599024887', '', '1');
INSERT INTO `cj_kaohao` VALUES ('404', '3', '3', '2020', '一年级', '4', '1', '116', '1599024887', '1599024887', '', '1');
INSERT INTO `cj_kaohao` VALUES ('405', '3', '3', '2020', '一年级', '4', '1', '117', '1599024887', '1599024887', '', '1');
INSERT INTO `cj_kaohao` VALUES ('406', '3', '3', '2020', '一年级', '4', '1', '118', '1599024887', '1599024887', '', '1');
INSERT INTO `cj_kaohao` VALUES ('407', '3', '3', '2020', '一年级', '5', '2', '119', '1599024887', '1599024887', '', '1');
INSERT INTO `cj_kaohao` VALUES ('408', '3', '3', '2020', '一年级', '5', '2', '120', '1599024887', '1599024887', '', '1');
INSERT INTO `cj_kaohao` VALUES ('409', '3', '3', '2020', '一年级', '5', '2', '121', '1599024887', '1599024887', '', '1');
INSERT INTO `cj_kaohao` VALUES ('410', '3', '3', '2020', '一年级', '5', '2', '122', '1599024887', '1599024887', '', '1');
INSERT INTO `cj_kaohao` VALUES ('411', '3', '3', '2020', '一年级', '5', '2', '123', '1599024887', '1599024887', '', '1');
INSERT INTO `cj_kaohao` VALUES ('412', '3', '3', '2020', '一年级', '5', '2', '124', '1599024887', '1599024887', '', '1');
INSERT INTO `cj_kaohao` VALUES ('413', '3', '3', '2020', '一年级', '5', '2', '125', '1599024887', '1599024887', '', '1');
INSERT INTO `cj_kaohao` VALUES ('414', '3', '3', '2020', '一年级', '5', '2', '126', '1599024887', '1599024887', '', '1');
INSERT INTO `cj_kaohao` VALUES ('415', '3', '3', '2020', '一年级', '5', '2', '127', '1599024887', '1599024887', '', '1');
INSERT INTO `cj_kaohao` VALUES ('416', '3', '3', '2020', '一年级', '5', '2', '128', '1599024887', '1599024887', '', '1');
INSERT INTO `cj_kaohao` VALUES ('417', '3', '3', '2020', '一年级', '5', '2', '129', '1599024887', '1599024887', '', '1');
INSERT INTO `cj_kaohao` VALUES ('418', '3', '3', '2020', '一年级', '5', '2', '130', '1599024887', '1599024887', '', '1');
INSERT INTO `cj_kaohao` VALUES ('419', '3', '3', '2020', '一年级', '5', '2', '131', '1599024887', '1599024887', '', '1');
INSERT INTO `cj_kaohao` VALUES ('420', '3', '3', '2020', '一年级', '5', '2', '132', '1599024887', '1599024887', '', '1');
INSERT INTO `cj_kaohao` VALUES ('421', '3', '3', '2020', '一年级', '5', '2', '133', '1599024887', '1599024887', '', '1');
INSERT INTO `cj_kaohao` VALUES ('422', '3', '3', '2020', '一年级', '5', '2', '134', '1599024887', '1599024887', '', '1');
INSERT INTO `cj_kaohao` VALUES ('423', '3', '3', '2019', '二年级', '7', '1', '135', '1599024887', '1599024887', '', '1');
INSERT INTO `cj_kaohao` VALUES ('424', '3', '3', '2019', '二年级', '7', '1', '136', '1599024887', '1599024887', '', '1');
INSERT INTO `cj_kaohao` VALUES ('425', '3', '3', '2019', '二年级', '7', '1', '137', '1599024887', '1599024887', '', '1');
INSERT INTO `cj_kaohao` VALUES ('426', '3', '3', '2019', '二年级', '7', '1', '138', '1599024887', '1599024887', '', '1');
INSERT INTO `cj_kaohao` VALUES ('427', '3', '3', '2019', '二年级', '7', '1', '139', '1599024887', '1599024887', '', '1');
INSERT INTO `cj_kaohao` VALUES ('428', '3', '3', '2019', '二年级', '7', '1', '140', '1599024887', '1599024887', '', '1');
INSERT INTO `cj_kaohao` VALUES ('429', '3', '3', '2019', '二年级', '7', '1', '141', '1599024887', '1599024887', '', '1');
INSERT INTO `cj_kaohao` VALUES ('430', '3', '3', '2019', '二年级', '7', '1', '142', '1599024887', '1599024887', '', '1');
INSERT INTO `cj_kaohao` VALUES ('431', '3', '3', '2019', '二年级', '7', '1', '143', '1599024887', '1599024887', '', '1');
INSERT INTO `cj_kaohao` VALUES ('432', '3', '3', '2019', '二年级', '7', '1', '144', '1599024887', '1599024887', '', '1');
INSERT INTO `cj_kaohao` VALUES ('433', '4', '2', '2020', '一年级', '1', '1', '1', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('434', '4', '2', '2020', '一年级', '1', '1', '2', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('435', '4', '2', '2020', '一年级', '1', '1', '3', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('436', '4', '2', '2020', '一年级', '1', '1', '4', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('437', '4', '2', '2020', '一年级', '1', '1', '5', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('438', '4', '2', '2020', '一年级', '1', '1', '6', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('439', '4', '2', '2020', '一年级', '1', '1', '7', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('440', '4', '2', '2020', '一年级', '1', '1', '8', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('441', '4', '2', '2020', '一年级', '1', '1', '9', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('442', '4', '2', '2020', '一年级', '1', '1', '10', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('443', '4', '2', '2020', '一年级', '1', '1', '11', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('444', '4', '2', '2020', '一年级', '1', '1', '12', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('445', '4', '2', '2020', '一年级', '1', '1', '13', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('446', '4', '2', '2020', '一年级', '1', '1', '14', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('447', '4', '2', '2020', '一年级', '1', '1', '15', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('448', '4', '2', '2020', '一年级', '1', '1', '16', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('449', '4', '2', '2020', '一年级', '1', '1', '17', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('450', '4', '2', '2020', '一年级', '1', '1', '18', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('451', '4', '2', '2020', '一年级', '1', '1', '19', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('452', '4', '2', '2020', '一年级', '1', '1', '20', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('453', '4', '2', '2020', '一年级', '1', '1', '21', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('454', '4', '2', '2020', '一年级', '1', '1', '22', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('455', '4', '2', '2020', '一年级', '2', '2', '23', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('456', '4', '2', '2020', '一年级', '2', '2', '24', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('457', '4', '2', '2020', '一年级', '2', '2', '25', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('458', '4', '2', '2020', '一年级', '2', '2', '26', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('459', '4', '2', '2020', '一年级', '2', '2', '27', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('460', '4', '2', '2020', '一年级', '2', '2', '28', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('461', '4', '2', '2020', '一年级', '2', '2', '29', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('462', '4', '2', '2020', '一年级', '2', '2', '30', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('463', '4', '2', '2020', '一年级', '2', '2', '31', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('464', '4', '2', '2020', '一年级', '2', '2', '32', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('465', '4', '2', '2020', '一年级', '2', '2', '33', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('466', '4', '2', '2020', '一年级', '2', '2', '34', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('467', '4', '2', '2020', '一年级', '2', '2', '35', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('468', '4', '2', '2020', '一年级', '2', '2', '36', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('469', '4', '2', '2020', '一年级', '2', '2', '37', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('470', '4', '2', '2020', '一年级', '2', '2', '38', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('471', '4', '2', '2020', '一年级', '3', '3', '39', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('472', '4', '2', '2020', '一年级', '3', '3', '40', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('473', '4', '2', '2020', '一年级', '3', '3', '41', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('474', '4', '2', '2020', '一年级', '3', '3', '42', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('475', '4', '2', '2020', '一年级', '3', '3', '43', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('476', '4', '2', '2020', '一年级', '3', '3', '44', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('477', '4', '2', '2020', '一年级', '3', '3', '45', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('478', '4', '2', '2020', '一年级', '3', '3', '46', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('479', '4', '2', '2020', '一年级', '3', '3', '47', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('480', '4', '2', '2020', '一年级', '3', '3', '48', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('481', '4', '2', '2020', '一年级', '3', '3', '49', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('482', '4', '2', '2020', '一年级', '3', '3', '50', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('483', '4', '2', '2020', '一年级', '3', '3', '51', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('484', '4', '2', '2020', '一年级', '3', '3', '52', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('485', '4', '2', '2020', '一年级', '3', '3', '53', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('486', '4', '2', '2020', '一年级', '3', '3', '54', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('487', '4', '2', '2020', '一年级', '3', '3', '55', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('488', '4', '2', '2020', '一年级', '3', '3', '56', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('489', '4', '2', '2020', '一年级', '3', '3', '57', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('490', '4', '2', '2020', '一年级', '3', '3', '58', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('491', '4', '2', '2020', '一年级', '3', '3', '59', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('492', '4', '2', '2020', '一年级', '3', '3', '60', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('493', '4', '2', '2020', '一年级', '3', '3', '61', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('494', '4', '2', '2020', '一年级', '3', '3', '62', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('495', '4', '2', '2020', '一年级', '3', '3', '63', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('496', '4', '2', '2020', '一年级', '3', '3', '64', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('497', '4', '2', '2020', '一年级', '3', '3', '65', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('498', '4', '2', '2020', '一年级', '3', '3', '66', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('499', '4', '2', '2020', '一年级', '3', '3', '67', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('500', '4', '2', '2020', '一年级', '3', '3', '68', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('501', '4', '2', '2020', '一年级', '3', '3', '69', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('502', '4', '2', '2020', '一年级', '3', '3', '70', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('503', '4', '2', '2020', '一年级', '3', '3', '71', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('504', '4', '2', '2020', '一年级', '3', '3', '72', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('505', '4', '2', '2019', '二年级', '6', '1', '73', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('506', '4', '2', '2019', '二年级', '6', '1', '74', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('507', '4', '2', '2019', '二年级', '6', '1', '75', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('508', '4', '2', '2019', '二年级', '6', '1', '76', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('509', '4', '2', '2019', '二年级', '6', '1', '77', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('510', '4', '2', '2019', '二年级', '6', '1', '78', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('511', '4', '2', '2019', '二年级', '6', '1', '79', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('512', '4', '2', '2019', '二年级', '6', '1', '80', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('513', '4', '2', '2019', '二年级', '6', '1', '81', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('514', '4', '2', '2019', '二年级', '6', '1', '82', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('515', '4', '2', '2019', '二年级', '6', '1', '83', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('516', '4', '2', '2019', '二年级', '6', '1', '84', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('517', '4', '2', '2019', '二年级', '6', '1', '85', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('518', '4', '2', '2019', '二年级', '6', '1', '86', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('519', '4', '2', '2019', '二年级', '6', '1', '87', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('520', '4', '2', '2019', '二年级', '6', '1', '88', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('521', '4', '2', '2019', '二年级', '6', '1', '89', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('522', '4', '2', '2019', '二年级', '6', '1', '90', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('523', '4', '2', '2019', '二年级', '6', '1', '91', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('524', '4', '2', '2019', '二年级', '6', '1', '92', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('525', '4', '2', '2019', '二年级', '6', '1', '93', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('526', '4', '2', '2019', '二年级', '6', '1', '94', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('527', '4', '2', '2019', '二年级', '6', '1', '95', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('528', '4', '2', '2019', '二年级', '6', '1', '96', '1599024899', '1599024899', '', '1');
INSERT INTO `cj_kaohao` VALUES ('529', '4', '3', '2020', '一年级', '4', '1', '97', '1599024905', '1599024905', '', '1');
INSERT INTO `cj_kaohao` VALUES ('530', '4', '3', '2020', '一年级', '4', '1', '98', '1599024905', '1599024905', '', '1');
INSERT INTO `cj_kaohao` VALUES ('531', '4', '3', '2020', '一年级', '4', '1', '99', '1599024905', '1599024905', '', '1');
INSERT INTO `cj_kaohao` VALUES ('532', '4', '3', '2020', '一年级', '4', '1', '100', '1599024905', '1599024905', '', '1');
INSERT INTO `cj_kaohao` VALUES ('533', '4', '3', '2020', '一年级', '4', '1', '101', '1599024905', '1599024905', '', '1');
INSERT INTO `cj_kaohao` VALUES ('534', '4', '3', '2020', '一年级', '4', '1', '102', '1599024905', '1599024905', '', '1');
INSERT INTO `cj_kaohao` VALUES ('535', '4', '3', '2020', '一年级', '4', '1', '103', '1599024905', '1599024905', '', '1');
INSERT INTO `cj_kaohao` VALUES ('536', '4', '3', '2020', '一年级', '4', '1', '104', '1599024905', '1599024905', '', '1');
INSERT INTO `cj_kaohao` VALUES ('537', '4', '3', '2020', '一年级', '4', '1', '105', '1599024905', '1599024905', '', '1');
INSERT INTO `cj_kaohao` VALUES ('538', '4', '3', '2020', '一年级', '4', '1', '106', '1599024905', '1599024905', '', '1');
INSERT INTO `cj_kaohao` VALUES ('539', '4', '3', '2020', '一年级', '4', '1', '107', '1599024905', '1599024905', '', '1');
INSERT INTO `cj_kaohao` VALUES ('540', '4', '3', '2020', '一年级', '4', '1', '108', '1599024905', '1599024905', '', '1');
INSERT INTO `cj_kaohao` VALUES ('541', '4', '3', '2020', '一年级', '4', '1', '109', '1599024905', '1599024905', '', '1');
INSERT INTO `cj_kaohao` VALUES ('542', '4', '3', '2020', '一年级', '4', '1', '110', '1599024905', '1599024905', '', '1');
INSERT INTO `cj_kaohao` VALUES ('543', '4', '3', '2020', '一年级', '4', '1', '111', '1599024905', '1599024905', '', '1');
INSERT INTO `cj_kaohao` VALUES ('544', '4', '3', '2020', '一年级', '4', '1', '112', '1599024905', '1599024905', '', '1');
INSERT INTO `cj_kaohao` VALUES ('545', '4', '3', '2020', '一年级', '4', '1', '113', '1599024905', '1599024905', '', '1');
INSERT INTO `cj_kaohao` VALUES ('546', '4', '3', '2020', '一年级', '4', '1', '114', '1599024905', '1599024905', '', '1');
INSERT INTO `cj_kaohao` VALUES ('547', '4', '3', '2020', '一年级', '4', '1', '115', '1599024905', '1599024905', '', '1');
INSERT INTO `cj_kaohao` VALUES ('548', '4', '3', '2020', '一年级', '4', '1', '116', '1599024905', '1599024905', '', '1');
INSERT INTO `cj_kaohao` VALUES ('549', '4', '3', '2020', '一年级', '4', '1', '117', '1599024905', '1599024905', '', '1');
INSERT INTO `cj_kaohao` VALUES ('550', '4', '3', '2020', '一年级', '4', '1', '118', '1599024905', '1599024905', '', '1');
INSERT INTO `cj_kaohao` VALUES ('551', '4', '3', '2020', '一年级', '5', '2', '119', '1599024905', '1599024905', '', '1');
INSERT INTO `cj_kaohao` VALUES ('552', '4', '3', '2020', '一年级', '5', '2', '120', '1599024905', '1599024905', '', '1');
INSERT INTO `cj_kaohao` VALUES ('553', '4', '3', '2020', '一年级', '5', '2', '121', '1599024905', '1599024905', '', '1');
INSERT INTO `cj_kaohao` VALUES ('554', '4', '3', '2020', '一年级', '5', '2', '122', '1599024905', '1599024905', '', '1');
INSERT INTO `cj_kaohao` VALUES ('555', '4', '3', '2020', '一年级', '5', '2', '123', '1599024905', '1599024905', '', '1');
INSERT INTO `cj_kaohao` VALUES ('556', '4', '3', '2020', '一年级', '5', '2', '124', '1599024905', '1599024905', '', '1');
INSERT INTO `cj_kaohao` VALUES ('557', '4', '3', '2020', '一年级', '5', '2', '125', '1599024905', '1599024905', '', '1');
INSERT INTO `cj_kaohao` VALUES ('558', '4', '3', '2020', '一年级', '5', '2', '126', '1599024905', '1599024905', '', '1');
INSERT INTO `cj_kaohao` VALUES ('559', '4', '3', '2020', '一年级', '5', '2', '127', '1599024905', '1599024905', '', '1');
INSERT INTO `cj_kaohao` VALUES ('560', '4', '3', '2020', '一年级', '5', '2', '128', '1599024905', '1599024905', '', '1');
INSERT INTO `cj_kaohao` VALUES ('561', '4', '3', '2020', '一年级', '5', '2', '129', '1599024905', '1599024905', '', '1');
INSERT INTO `cj_kaohao` VALUES ('562', '4', '3', '2020', '一年级', '5', '2', '130', '1599024905', '1599024905', '', '1');
INSERT INTO `cj_kaohao` VALUES ('563', '4', '3', '2020', '一年级', '5', '2', '131', '1599024905', '1599024905', '', '1');
INSERT INTO `cj_kaohao` VALUES ('564', '4', '3', '2020', '一年级', '5', '2', '132', '1599024905', '1599024905', '', '1');
INSERT INTO `cj_kaohao` VALUES ('565', '4', '3', '2020', '一年级', '5', '2', '133', '1599024905', '1599024905', '', '1');
INSERT INTO `cj_kaohao` VALUES ('566', '4', '3', '2020', '一年级', '5', '2', '134', '1599024905', '1599024905', '', '1');
INSERT INTO `cj_kaohao` VALUES ('567', '4', '3', '2019', '二年级', '7', '1', '135', '1599024905', '1599024905', '', '1');
INSERT INTO `cj_kaohao` VALUES ('568', '4', '3', '2019', '二年级', '7', '1', '136', '1599024905', '1599024905', '', '1');
INSERT INTO `cj_kaohao` VALUES ('569', '4', '3', '2019', '二年级', '7', '1', '137', '1599024905', '1599024905', '', '1');
INSERT INTO `cj_kaohao` VALUES ('570', '4', '3', '2019', '二年级', '7', '1', '138', '1599024905', '1599024905', '', '1');
INSERT INTO `cj_kaohao` VALUES ('571', '4', '3', '2019', '二年级', '7', '1', '139', '1599024905', '1599024905', '', '1');
INSERT INTO `cj_kaohao` VALUES ('572', '4', '3', '2019', '二年级', '7', '1', '140', '1599024905', '1599024905', '', '1');
INSERT INTO `cj_kaohao` VALUES ('573', '4', '3', '2019', '二年级', '7', '1', '141', '1599024905', '1599024905', '', '1');
INSERT INTO `cj_kaohao` VALUES ('574', '4', '3', '2019', '二年级', '7', '1', '142', '1599024905', '1599024905', '', '1');
INSERT INTO `cj_kaohao` VALUES ('575', '4', '3', '2019', '二年级', '7', '1', '143', '1599024905', '1599024905', '', '1');
INSERT INTO `cj_kaohao` VALUES ('576', '4', '3', '2019', '二年级', '7', '1', '144', '1599024905', '1599024905', '', '1');
INSERT INTO `cj_kaohao` VALUES ('577', '5', '2', '2020', '一年级', '1', '1', '1', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('578', '5', '2', '2020', '一年级', '1', '1', '2', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('579', '5', '2', '2020', '一年级', '1', '1', '3', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('580', '5', '2', '2020', '一年级', '1', '1', '4', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('581', '5', '2', '2020', '一年级', '1', '1', '5', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('582', '5', '2', '2020', '一年级', '1', '1', '6', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('583', '5', '2', '2020', '一年级', '1', '1', '7', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('584', '5', '2', '2020', '一年级', '1', '1', '8', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('585', '5', '2', '2020', '一年级', '1', '1', '9', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('586', '5', '2', '2020', '一年级', '1', '1', '10', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('587', '5', '2', '2020', '一年级', '1', '1', '11', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('588', '5', '2', '2020', '一年级', '1', '1', '12', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('589', '5', '2', '2020', '一年级', '1', '1', '13', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('590', '5', '2', '2020', '一年级', '1', '1', '14', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('591', '5', '2', '2020', '一年级', '1', '1', '15', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('592', '5', '2', '2020', '一年级', '1', '1', '16', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('593', '5', '2', '2020', '一年级', '1', '1', '17', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('594', '5', '2', '2020', '一年级', '1', '1', '18', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('595', '5', '2', '2020', '一年级', '1', '1', '19', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('596', '5', '2', '2020', '一年级', '1', '1', '20', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('597', '5', '2', '2020', '一年级', '1', '1', '21', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('598', '5', '2', '2020', '一年级', '1', '1', '22', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('599', '5', '2', '2020', '一年级', '2', '2', '23', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('600', '5', '2', '2020', '一年级', '2', '2', '24', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('601', '5', '2', '2020', '一年级', '2', '2', '25', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('602', '5', '2', '2020', '一年级', '2', '2', '26', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('603', '5', '2', '2020', '一年级', '2', '2', '27', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('604', '5', '2', '2020', '一年级', '2', '2', '28', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('605', '5', '2', '2020', '一年级', '2', '2', '29', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('606', '5', '2', '2020', '一年级', '2', '2', '30', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('607', '5', '2', '2020', '一年级', '2', '2', '31', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('608', '5', '2', '2020', '一年级', '2', '2', '32', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('609', '5', '2', '2020', '一年级', '2', '2', '33', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('610', '5', '2', '2020', '一年级', '2', '2', '34', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('611', '5', '2', '2020', '一年级', '2', '2', '35', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('612', '5', '2', '2020', '一年级', '2', '2', '36', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('613', '5', '2', '2020', '一年级', '2', '2', '37', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('614', '5', '2', '2020', '一年级', '2', '2', '38', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('615', '5', '2', '2020', '一年级', '3', '3', '39', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('616', '5', '2', '2020', '一年级', '3', '3', '40', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('617', '5', '2', '2020', '一年级', '3', '3', '41', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('618', '5', '2', '2020', '一年级', '3', '3', '42', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('619', '5', '2', '2020', '一年级', '3', '3', '43', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('620', '5', '2', '2020', '一年级', '3', '3', '44', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('621', '5', '2', '2020', '一年级', '3', '3', '45', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('622', '5', '2', '2020', '一年级', '3', '3', '46', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('623', '5', '2', '2020', '一年级', '3', '3', '47', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('624', '5', '2', '2020', '一年级', '3', '3', '48', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('625', '5', '2', '2020', '一年级', '3', '3', '49', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('626', '5', '2', '2020', '一年级', '3', '3', '50', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('627', '5', '2', '2020', '一年级', '3', '3', '51', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('628', '5', '2', '2020', '一年级', '3', '3', '52', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('629', '5', '2', '2020', '一年级', '3', '3', '53', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('630', '5', '2', '2020', '一年级', '3', '3', '54', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('631', '5', '2', '2020', '一年级', '3', '3', '55', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('632', '5', '2', '2020', '一年级', '3', '3', '56', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('633', '5', '2', '2020', '一年级', '3', '3', '57', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('634', '5', '2', '2020', '一年级', '3', '3', '58', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('635', '5', '2', '2020', '一年级', '3', '3', '59', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('636', '5', '2', '2020', '一年级', '3', '3', '60', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('637', '5', '2', '2020', '一年级', '3', '3', '61', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('638', '5', '2', '2020', '一年级', '3', '3', '62', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('639', '5', '2', '2020', '一年级', '3', '3', '63', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('640', '5', '2', '2020', '一年级', '3', '3', '64', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('641', '5', '2', '2020', '一年级', '3', '3', '65', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('642', '5', '2', '2020', '一年级', '3', '3', '66', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('643', '5', '2', '2020', '一年级', '3', '3', '67', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('644', '5', '2', '2020', '一年级', '3', '3', '68', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('645', '5', '2', '2020', '一年级', '3', '3', '69', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('646', '5', '2', '2020', '一年级', '3', '3', '70', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('647', '5', '2', '2020', '一年级', '3', '3', '71', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('648', '5', '2', '2020', '一年级', '3', '3', '72', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('649', '5', '2', '2019', '二年级', '6', '1', '73', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('650', '5', '2', '2019', '二年级', '6', '1', '74', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('651', '5', '2', '2019', '二年级', '6', '1', '75', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('652', '5', '2', '2019', '二年级', '6', '1', '76', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('653', '5', '2', '2019', '二年级', '6', '1', '77', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('654', '5', '2', '2019', '二年级', '6', '1', '78', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('655', '5', '2', '2019', '二年级', '6', '1', '79', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('656', '5', '2', '2019', '二年级', '6', '1', '80', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('657', '5', '2', '2019', '二年级', '6', '1', '81', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('658', '5', '2', '2019', '二年级', '6', '1', '82', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('659', '5', '2', '2019', '二年级', '6', '1', '83', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('660', '5', '2', '2019', '二年级', '6', '1', '84', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('661', '5', '2', '2019', '二年级', '6', '1', '85', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('662', '5', '2', '2019', '二年级', '6', '1', '86', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('663', '5', '2', '2019', '二年级', '6', '1', '87', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('664', '5', '2', '2019', '二年级', '6', '1', '88', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('665', '5', '2', '2019', '二年级', '6', '1', '89', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('666', '5', '2', '2019', '二年级', '6', '1', '90', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('667', '5', '2', '2019', '二年级', '6', '1', '91', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('668', '5', '2', '2019', '二年级', '6', '1', '92', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('669', '5', '2', '2019', '二年级', '6', '1', '93', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('670', '5', '2', '2019', '二年级', '6', '1', '94', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('671', '5', '2', '2019', '二年级', '6', '1', '95', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('672', '5', '2', '2019', '二年级', '6', '1', '96', '1599024915', '1599024915', '', '1');
INSERT INTO `cj_kaohao` VALUES ('673', '5', '3', '2020', '一年级', '4', '1', '97', '1599024921', '1599024921', '', '1');
INSERT INTO `cj_kaohao` VALUES ('674', '5', '3', '2020', '一年级', '4', '1', '98', '1599024921', '1599024921', '', '1');
INSERT INTO `cj_kaohao` VALUES ('675', '5', '3', '2020', '一年级', '4', '1', '99', '1599024921', '1599024921', '', '1');
INSERT INTO `cj_kaohao` VALUES ('676', '5', '3', '2020', '一年级', '4', '1', '100', '1599024921', '1599024921', '', '1');
INSERT INTO `cj_kaohao` VALUES ('677', '5', '3', '2020', '一年级', '4', '1', '101', '1599024921', '1599024921', '', '1');
INSERT INTO `cj_kaohao` VALUES ('678', '5', '3', '2020', '一年级', '4', '1', '102', '1599024921', '1599024921', '', '1');
INSERT INTO `cj_kaohao` VALUES ('679', '5', '3', '2020', '一年级', '4', '1', '103', '1599024921', '1599024921', '', '1');
INSERT INTO `cj_kaohao` VALUES ('680', '5', '3', '2020', '一年级', '4', '1', '104', '1599024921', '1599024921', '', '1');
INSERT INTO `cj_kaohao` VALUES ('681', '5', '3', '2020', '一年级', '4', '1', '105', '1599024921', '1599024921', '', '1');
INSERT INTO `cj_kaohao` VALUES ('682', '5', '3', '2020', '一年级', '4', '1', '106', '1599024921', '1599024921', '', '1');
INSERT INTO `cj_kaohao` VALUES ('683', '5', '3', '2020', '一年级', '4', '1', '107', '1599024921', '1599024921', '', '1');
INSERT INTO `cj_kaohao` VALUES ('684', '5', '3', '2020', '一年级', '4', '1', '108', '1599024921', '1599024921', '', '1');
INSERT INTO `cj_kaohao` VALUES ('685', '5', '3', '2020', '一年级', '4', '1', '109', '1599024921', '1599024921', '', '1');
INSERT INTO `cj_kaohao` VALUES ('686', '5', '3', '2020', '一年级', '4', '1', '110', '1599024921', '1599024921', '', '1');
INSERT INTO `cj_kaohao` VALUES ('687', '5', '3', '2020', '一年级', '4', '1', '111', '1599024921', '1599024921', '', '1');
INSERT INTO `cj_kaohao` VALUES ('688', '5', '3', '2020', '一年级', '4', '1', '112', '1599024921', '1599024921', '', '1');
INSERT INTO `cj_kaohao` VALUES ('689', '5', '3', '2020', '一年级', '4', '1', '113', '1599024921', '1599024921', '', '1');
INSERT INTO `cj_kaohao` VALUES ('690', '5', '3', '2020', '一年级', '4', '1', '114', '1599024921', '1599024921', '', '1');
INSERT INTO `cj_kaohao` VALUES ('691', '5', '3', '2020', '一年级', '4', '1', '115', '1599024921', '1599024921', '', '1');
INSERT INTO `cj_kaohao` VALUES ('692', '5', '3', '2020', '一年级', '4', '1', '116', '1599024921', '1599024921', '', '1');
INSERT INTO `cj_kaohao` VALUES ('693', '5', '3', '2020', '一年级', '4', '1', '117', '1599024921', '1599024921', '', '1');
INSERT INTO `cj_kaohao` VALUES ('694', '5', '3', '2020', '一年级', '4', '1', '118', '1599024921', '1599024921', '', '1');
INSERT INTO `cj_kaohao` VALUES ('695', '5', '3', '2020', '一年级', '5', '2', '119', '1599024921', '1599024921', '', '1');
INSERT INTO `cj_kaohao` VALUES ('696', '5', '3', '2020', '一年级', '5', '2', '120', '1599024921', '1599024921', '', '1');
INSERT INTO `cj_kaohao` VALUES ('697', '5', '3', '2020', '一年级', '5', '2', '121', '1599024921', '1599024921', '', '1');
INSERT INTO `cj_kaohao` VALUES ('698', '5', '3', '2020', '一年级', '5', '2', '122', '1599024921', '1599024921', '', '1');
INSERT INTO `cj_kaohao` VALUES ('699', '5', '3', '2020', '一年级', '5', '2', '123', '1599024921', '1599024921', '', '1');
INSERT INTO `cj_kaohao` VALUES ('700', '5', '3', '2020', '一年级', '5', '2', '124', '1599024921', '1599024921', '', '1');
INSERT INTO `cj_kaohao` VALUES ('701', '5', '3', '2020', '一年级', '5', '2', '125', '1599024921', '1599024921', '', '1');
INSERT INTO `cj_kaohao` VALUES ('702', '5', '3', '2020', '一年级', '5', '2', '126', '1599024921', '1599024921', '', '1');
INSERT INTO `cj_kaohao` VALUES ('703', '5', '3', '2020', '一年级', '5', '2', '127', '1599024921', '1599024921', '', '1');
INSERT INTO `cj_kaohao` VALUES ('704', '5', '3', '2020', '一年级', '5', '2', '128', '1599024921', '1599024921', '', '1');
INSERT INTO `cj_kaohao` VALUES ('705', '5', '3', '2020', '一年级', '5', '2', '129', '1599024921', '1599024921', '', '1');
INSERT INTO `cj_kaohao` VALUES ('706', '5', '3', '2020', '一年级', '5', '2', '130', '1599024921', '1599024921', '', '1');
INSERT INTO `cj_kaohao` VALUES ('707', '5', '3', '2020', '一年级', '5', '2', '131', '1599024921', '1599024921', '', '1');
INSERT INTO `cj_kaohao` VALUES ('708', '5', '3', '2020', '一年级', '5', '2', '132', '1599024921', '1599024921', '', '1');
INSERT INTO `cj_kaohao` VALUES ('709', '5', '3', '2020', '一年级', '5', '2', '133', '1599024921', '1599024921', '', '1');
INSERT INTO `cj_kaohao` VALUES ('710', '5', '3', '2020', '一年级', '5', '2', '134', '1599024921', '1599024921', '', '1');
INSERT INTO `cj_kaohao` VALUES ('711', '5', '3', '2019', '二年级', '7', '1', '135', '1599024921', '1599024921', '', '1');
INSERT INTO `cj_kaohao` VALUES ('712', '5', '3', '2019', '二年级', '7', '1', '136', '1599024921', '1599024921', '', '1');
INSERT INTO `cj_kaohao` VALUES ('713', '5', '3', '2019', '二年级', '7', '1', '137', '1599024921', '1599024921', '', '1');
INSERT INTO `cj_kaohao` VALUES ('714', '5', '3', '2019', '二年级', '7', '1', '138', '1599024921', '1599024921', '', '1');
INSERT INTO `cj_kaohao` VALUES ('715', '5', '3', '2019', '二年级', '7', '1', '139', '1599024921', '1599024921', '', '1');
INSERT INTO `cj_kaohao` VALUES ('716', '5', '3', '2019', '二年级', '7', '1', '140', '1599024921', '1599024921', '', '1');
INSERT INTO `cj_kaohao` VALUES ('717', '5', '3', '2019', '二年级', '7', '1', '141', '1599024921', '1599024921', '', '1');
INSERT INTO `cj_kaohao` VALUES ('718', '5', '3', '2019', '二年级', '7', '1', '142', '1599024921', '1599024921', '', '1');
INSERT INTO `cj_kaohao` VALUES ('719', '5', '3', '2019', '二年级', '7', '1', '143', '1599024921', '1599024921', '', '1');
INSERT INTO `cj_kaohao` VALUES ('720', '5', '3', '2019', '二年级', '7', '1', '144', '1599024921', '1599024921', '', '1');
INSERT INTO `cj_kaohao` VALUES ('721', '6', '2', '2020', '一年级', '1', '1', '1', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('722', '6', '2', '2020', '一年级', '1', '1', '2', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('723', '6', '2', '2020', '一年级', '1', '1', '3', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('724', '6', '2', '2020', '一年级', '1', '1', '4', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('725', '6', '2', '2020', '一年级', '1', '1', '5', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('726', '6', '2', '2020', '一年级', '1', '1', '6', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('727', '6', '2', '2020', '一年级', '1', '1', '7', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('728', '6', '2', '2020', '一年级', '1', '1', '8', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('729', '6', '2', '2020', '一年级', '1', '1', '9', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('730', '6', '2', '2020', '一年级', '1', '1', '10', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('731', '6', '2', '2020', '一年级', '1', '1', '11', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('732', '6', '2', '2020', '一年级', '1', '1', '12', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('733', '6', '2', '2020', '一年级', '1', '1', '13', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('734', '6', '2', '2020', '一年级', '1', '1', '14', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('735', '6', '2', '2020', '一年级', '1', '1', '15', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('736', '6', '2', '2020', '一年级', '1', '1', '16', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('737', '6', '2', '2020', '一年级', '1', '1', '17', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('738', '6', '2', '2020', '一年级', '1', '1', '18', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('739', '6', '2', '2020', '一年级', '1', '1', '19', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('740', '6', '2', '2020', '一年级', '1', '1', '20', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('741', '6', '2', '2020', '一年级', '1', '1', '21', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('742', '6', '2', '2020', '一年级', '1', '1', '22', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('743', '6', '2', '2020', '一年级', '2', '2', '23', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('744', '6', '2', '2020', '一年级', '2', '2', '24', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('745', '6', '2', '2020', '一年级', '2', '2', '25', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('746', '6', '2', '2020', '一年级', '2', '2', '26', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('747', '6', '2', '2020', '一年级', '2', '2', '27', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('748', '6', '2', '2020', '一年级', '2', '2', '28', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('749', '6', '2', '2020', '一年级', '2', '2', '29', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('750', '6', '2', '2020', '一年级', '2', '2', '30', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('751', '6', '2', '2020', '一年级', '2', '2', '31', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('752', '6', '2', '2020', '一年级', '2', '2', '32', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('753', '6', '2', '2020', '一年级', '2', '2', '33', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('754', '6', '2', '2020', '一年级', '2', '2', '34', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('755', '6', '2', '2020', '一年级', '2', '2', '35', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('756', '6', '2', '2020', '一年级', '2', '2', '36', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('757', '6', '2', '2020', '一年级', '2', '2', '37', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('758', '6', '2', '2020', '一年级', '2', '2', '38', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('759', '6', '2', '2020', '一年级', '3', '3', '39', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('760', '6', '2', '2020', '一年级', '3', '3', '40', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('761', '6', '2', '2020', '一年级', '3', '3', '41', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('762', '6', '2', '2020', '一年级', '3', '3', '42', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('763', '6', '2', '2020', '一年级', '3', '3', '43', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('764', '6', '2', '2020', '一年级', '3', '3', '44', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('765', '6', '2', '2020', '一年级', '3', '3', '45', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('766', '6', '2', '2020', '一年级', '3', '3', '46', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('767', '6', '2', '2020', '一年级', '3', '3', '47', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('768', '6', '2', '2020', '一年级', '3', '3', '48', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('769', '6', '2', '2020', '一年级', '3', '3', '49', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('770', '6', '2', '2020', '一年级', '3', '3', '50', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('771', '6', '2', '2020', '一年级', '3', '3', '51', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('772', '6', '2', '2020', '一年级', '3', '3', '52', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('773', '6', '2', '2020', '一年级', '3', '3', '53', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('774', '6', '2', '2020', '一年级', '3', '3', '54', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('775', '6', '2', '2020', '一年级', '3', '3', '55', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('776', '6', '2', '2020', '一年级', '3', '3', '56', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('777', '6', '2', '2020', '一年级', '3', '3', '57', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('778', '6', '2', '2020', '一年级', '3', '3', '58', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('779', '6', '2', '2020', '一年级', '3', '3', '59', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('780', '6', '2', '2020', '一年级', '3', '3', '60', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('781', '6', '2', '2020', '一年级', '3', '3', '61', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('782', '6', '2', '2020', '一年级', '3', '3', '62', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('783', '6', '2', '2020', '一年级', '3', '3', '63', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('784', '6', '2', '2020', '一年级', '3', '3', '64', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('785', '6', '2', '2020', '一年级', '3', '3', '65', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('786', '6', '2', '2020', '一年级', '3', '3', '66', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('787', '6', '2', '2020', '一年级', '3', '3', '67', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('788', '6', '2', '2020', '一年级', '3', '3', '68', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('789', '6', '2', '2020', '一年级', '3', '3', '69', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('790', '6', '2', '2020', '一年级', '3', '3', '70', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('791', '6', '2', '2020', '一年级', '3', '3', '71', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('792', '6', '2', '2020', '一年级', '3', '3', '72', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('793', '6', '2', '2019', '二年级', '6', '1', '73', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('794', '6', '2', '2019', '二年级', '6', '1', '74', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('795', '6', '2', '2019', '二年级', '6', '1', '75', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('796', '6', '2', '2019', '二年级', '6', '1', '76', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('797', '6', '2', '2019', '二年级', '6', '1', '77', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('798', '6', '2', '2019', '二年级', '6', '1', '78', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('799', '6', '2', '2019', '二年级', '6', '1', '79', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('800', '6', '2', '2019', '二年级', '6', '1', '80', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('801', '6', '2', '2019', '二年级', '6', '1', '81', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('802', '6', '2', '2019', '二年级', '6', '1', '82', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('803', '6', '2', '2019', '二年级', '6', '1', '83', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('804', '6', '2', '2019', '二年级', '6', '1', '84', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('805', '6', '2', '2019', '二年级', '6', '1', '85', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('806', '6', '2', '2019', '二年级', '6', '1', '86', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('807', '6', '2', '2019', '二年级', '6', '1', '87', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('808', '6', '2', '2019', '二年级', '6', '1', '88', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('809', '6', '2', '2019', '二年级', '6', '1', '89', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('810', '6', '2', '2019', '二年级', '6', '1', '90', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('811', '6', '2', '2019', '二年级', '6', '1', '91', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('812', '6', '2', '2019', '二年级', '6', '1', '92', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('813', '6', '2', '2019', '二年级', '6', '1', '93', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('814', '6', '2', '2019', '二年级', '6', '1', '94', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('815', '6', '2', '2019', '二年级', '6', '1', '95', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('816', '6', '2', '2019', '二年级', '6', '1', '96', '1599024932', '1599024932', '', '1');
INSERT INTO `cj_kaohao` VALUES ('817', '6', '3', '2020', '一年级', '4', '1', '97', '1599024938', '1599024938', '', '1');
INSERT INTO `cj_kaohao` VALUES ('818', '6', '3', '2020', '一年级', '4', '1', '98', '1599024938', '1599024938', '', '1');
INSERT INTO `cj_kaohao` VALUES ('819', '6', '3', '2020', '一年级', '4', '1', '99', '1599024938', '1599024938', '', '1');
INSERT INTO `cj_kaohao` VALUES ('820', '6', '3', '2020', '一年级', '4', '1', '100', '1599024938', '1599024938', '', '1');
INSERT INTO `cj_kaohao` VALUES ('821', '6', '3', '2020', '一年级', '4', '1', '101', '1599024938', '1599024938', '', '1');
INSERT INTO `cj_kaohao` VALUES ('822', '6', '3', '2020', '一年级', '4', '1', '102', '1599024938', '1599024938', '', '1');
INSERT INTO `cj_kaohao` VALUES ('823', '6', '3', '2020', '一年级', '4', '1', '103', '1599024938', '1599024938', '', '1');
INSERT INTO `cj_kaohao` VALUES ('824', '6', '3', '2020', '一年级', '4', '1', '104', '1599024938', '1599024938', '', '1');
INSERT INTO `cj_kaohao` VALUES ('825', '6', '3', '2020', '一年级', '4', '1', '105', '1599024938', '1599024938', '', '1');
INSERT INTO `cj_kaohao` VALUES ('826', '6', '3', '2020', '一年级', '4', '1', '106', '1599024938', '1599024938', '', '1');
INSERT INTO `cj_kaohao` VALUES ('827', '6', '3', '2020', '一年级', '4', '1', '107', '1599024938', '1599024938', '', '1');
INSERT INTO `cj_kaohao` VALUES ('828', '6', '3', '2020', '一年级', '4', '1', '108', '1599024938', '1599024938', '', '1');
INSERT INTO `cj_kaohao` VALUES ('829', '6', '3', '2020', '一年级', '4', '1', '109', '1599024938', '1599024938', '', '1');
INSERT INTO `cj_kaohao` VALUES ('830', '6', '3', '2020', '一年级', '4', '1', '110', '1599024938', '1599024938', '', '1');
INSERT INTO `cj_kaohao` VALUES ('831', '6', '3', '2020', '一年级', '4', '1', '111', '1599024938', '1599024938', '', '1');
INSERT INTO `cj_kaohao` VALUES ('832', '6', '3', '2020', '一年级', '4', '1', '112', '1599024938', '1599024938', '', '1');
INSERT INTO `cj_kaohao` VALUES ('833', '6', '3', '2020', '一年级', '4', '1', '113', '1599024938', '1599024938', '', '1');
INSERT INTO `cj_kaohao` VALUES ('834', '6', '3', '2020', '一年级', '4', '1', '114', '1599024938', '1599024938', '', '1');
INSERT INTO `cj_kaohao` VALUES ('835', '6', '3', '2020', '一年级', '4', '1', '115', '1599024938', '1599024938', '', '1');
INSERT INTO `cj_kaohao` VALUES ('836', '6', '3', '2020', '一年级', '4', '1', '116', '1599024938', '1599024938', '', '1');
INSERT INTO `cj_kaohao` VALUES ('837', '6', '3', '2020', '一年级', '4', '1', '117', '1599024938', '1599024938', '', '1');
INSERT INTO `cj_kaohao` VALUES ('838', '6', '3', '2020', '一年级', '4', '1', '118', '1599024938', '1599024938', '', '1');
INSERT INTO `cj_kaohao` VALUES ('839', '6', '3', '2020', '一年级', '5', '2', '119', '1599024938', '1599024938', '', '1');
INSERT INTO `cj_kaohao` VALUES ('840', '6', '3', '2020', '一年级', '5', '2', '120', '1599024938', '1599024938', '', '1');
INSERT INTO `cj_kaohao` VALUES ('841', '6', '3', '2020', '一年级', '5', '2', '121', '1599024938', '1599024938', '', '1');
INSERT INTO `cj_kaohao` VALUES ('842', '6', '3', '2020', '一年级', '5', '2', '122', '1599024938', '1599024938', '', '1');
INSERT INTO `cj_kaohao` VALUES ('843', '6', '3', '2020', '一年级', '5', '2', '123', '1599024938', '1599024938', '', '1');
INSERT INTO `cj_kaohao` VALUES ('844', '6', '3', '2020', '一年级', '5', '2', '124', '1599024938', '1599024938', '', '1');
INSERT INTO `cj_kaohao` VALUES ('845', '6', '3', '2020', '一年级', '5', '2', '125', '1599024938', '1599024938', '', '1');
INSERT INTO `cj_kaohao` VALUES ('846', '6', '3', '2020', '一年级', '5', '2', '126', '1599024938', '1599024938', '', '1');
INSERT INTO `cj_kaohao` VALUES ('847', '6', '3', '2020', '一年级', '5', '2', '127', '1599024938', '1599024938', '', '1');
INSERT INTO `cj_kaohao` VALUES ('848', '6', '3', '2020', '一年级', '5', '2', '128', '1599024938', '1599024938', '', '1');
INSERT INTO `cj_kaohao` VALUES ('849', '6', '3', '2020', '一年级', '5', '2', '129', '1599024938', '1599024938', '', '1');
INSERT INTO `cj_kaohao` VALUES ('850', '6', '3', '2020', '一年级', '5', '2', '130', '1599024938', '1599024938', '', '1');
INSERT INTO `cj_kaohao` VALUES ('851', '6', '3', '2020', '一年级', '5', '2', '131', '1599024938', '1599024938', '', '1');
INSERT INTO `cj_kaohao` VALUES ('852', '6', '3', '2020', '一年级', '5', '2', '132', '1599024938', '1599024938', '', '1');
INSERT INTO `cj_kaohao` VALUES ('853', '6', '3', '2020', '一年级', '5', '2', '133', '1599024938', '1599024938', '', '1');
INSERT INTO `cj_kaohao` VALUES ('854', '6', '3', '2020', '一年级', '5', '2', '134', '1599024938', '1599024938', '', '1');
INSERT INTO `cj_kaohao` VALUES ('855', '6', '3', '2019', '二年级', '7', '1', '135', '1599024938', '1599024938', '', '1');
INSERT INTO `cj_kaohao` VALUES ('856', '6', '3', '2019', '二年级', '7', '1', '136', '1599024938', '1599024938', '', '1');
INSERT INTO `cj_kaohao` VALUES ('857', '6', '3', '2019', '二年级', '7', '1', '137', '1599024938', '1599024938', '', '1');
INSERT INTO `cj_kaohao` VALUES ('858', '6', '3', '2019', '二年级', '7', '1', '138', '1599024938', '1599024938', '', '1');
INSERT INTO `cj_kaohao` VALUES ('859', '6', '3', '2019', '二年级', '7', '1', '139', '1599024938', '1599024938', '', '1');
INSERT INTO `cj_kaohao` VALUES ('860', '6', '3', '2019', '二年级', '7', '1', '140', '1599024938', '1599024938', '', '1');
INSERT INTO `cj_kaohao` VALUES ('861', '6', '3', '2019', '二年级', '7', '1', '141', '1599024938', '1599024938', '', '1');
INSERT INTO `cj_kaohao` VALUES ('862', '6', '3', '2019', '二年级', '7', '1', '142', '1599024938', '1599024938', '', '1');
INSERT INTO `cj_kaohao` VALUES ('863', '6', '3', '2019', '二年级', '7', '1', '143', '1599024938', '1599024938', '', '1');
INSERT INTO `cj_kaohao` VALUES ('864', '6', '3', '2019', '二年级', '7', '1', '144', '1599024938', '1599024938', '', '1');
INSERT INTO `cj_kaohao` VALUES ('865', '7', '2', '2020', '一年级', '1', '1', '1', '1599026028', '1599026062', '1599026062', '1');
INSERT INTO `cj_kaohao` VALUES ('866', '7', '2', '2020', '一年级', '1', '1', '2', '1599026028', '1599026062', '1599026062', '1');
INSERT INTO `cj_kaohao` VALUES ('867', '7', '2', '2020', '一年级', '1', '1', '3', '1599026028', '1599026062', '1599026062', '1');
INSERT INTO `cj_kaohao` VALUES ('868', '7', '2', '2020', '一年级', '1', '1', '4', '1599026028', '1599026062', '1599026062', '1');
INSERT INTO `cj_kaohao` VALUES ('869', '7', '2', '2020', '一年级', '1', '1', '5', '1599026028', '1599026062', '1599026062', '1');
INSERT INTO `cj_kaohao` VALUES ('870', '7', '2', '2020', '一年级', '1', '1', '6', '1599026028', '1599026062', '1599026062', '1');
INSERT INTO `cj_kaohao` VALUES ('871', '7', '2', '2020', '一年级', '1', '1', '7', '1599026028', '1599026062', '1599026062', '1');
INSERT INTO `cj_kaohao` VALUES ('872', '7', '2', '2020', '一年级', '1', '1', '8', '1599026028', '1599026062', '1599026062', '1');
INSERT INTO `cj_kaohao` VALUES ('873', '7', '2', '2020', '一年级', '1', '1', '9', '1599026028', '1599026062', '1599026062', '1');
INSERT INTO `cj_kaohao` VALUES ('874', '7', '2', '2020', '一年级', '1', '1', '10', '1599026028', '1599026062', '1599026062', '1');
INSERT INTO `cj_kaohao` VALUES ('875', '7', '2', '2020', '一年级', '1', '1', '11', '1599026028', '1599026095', '1599026095', '1');
INSERT INTO `cj_kaohao` VALUES ('876', '7', '2', '2020', '一年级', '1', '1', '12', '1599026028', '1599026095', '1599026095', '1');
INSERT INTO `cj_kaohao` VALUES ('877', '7', '2', '2020', '一年级', '1', '1', '13', '1599026028', '1599026095', '1599026095', '1');
INSERT INTO `cj_kaohao` VALUES ('878', '7', '2', '2020', '一年级', '1', '1', '14', '1599026028', '1599026095', '1599026095', '1');
INSERT INTO `cj_kaohao` VALUES ('879', '7', '2', '2020', '一年级', '1', '1', '15', '1599026028', '1599026095', '1599026095', '1');
INSERT INTO `cj_kaohao` VALUES ('880', '7', '2', '2020', '一年级', '1', '1', '16', '1599026028', '1599026095', '1599026095', '1');
INSERT INTO `cj_kaohao` VALUES ('881', '7', '2', '2020', '一年级', '1', '1', '17', '1599026028', '1599026095', '1599026095', '1');
INSERT INTO `cj_kaohao` VALUES ('882', '7', '2', '2020', '一年级', '1', '1', '18', '1599026028', '1599026095', '1599026095', '1');
INSERT INTO `cj_kaohao` VALUES ('883', '7', '2', '2020', '一年级', '1', '1', '19', '1599026028', '1599026095', '1599026095', '1');
INSERT INTO `cj_kaohao` VALUES ('884', '7', '2', '2020', '一年级', '1', '1', '20', '1599026028', '1599026095', '1599026095', '1');
INSERT INTO `cj_kaohao` VALUES ('885', '7', '2', '2020', '一年级', '1', '1', '21', '1599026028', '1599026645', '1599026645', '1');
INSERT INTO `cj_kaohao` VALUES ('886', '7', '2', '2020', '一年级', '1', '1', '22', '1599026028', '1599026645', '1599026645', '1');
INSERT INTO `cj_kaohao` VALUES ('887', '7', '2', '2020', '一年级', '3', '3', '39', '1599026028', '1599026028', '', '1');
INSERT INTO `cj_kaohao` VALUES ('888', '7', '2', '2020', '一年级', '3', '3', '40', '1599026028', '1599026028', '', '1');
INSERT INTO `cj_kaohao` VALUES ('889', '7', '2', '2020', '一年级', '3', '3', '41', '1599026028', '1599026028', '', '1');
INSERT INTO `cj_kaohao` VALUES ('890', '7', '2', '2020', '一年级', '3', '3', '42', '1599026028', '1599026028', '', '1');
INSERT INTO `cj_kaohao` VALUES ('891', '7', '2', '2020', '一年级', '3', '3', '43', '1599026028', '1599026028', '', '1');
INSERT INTO `cj_kaohao` VALUES ('892', '7', '2', '2020', '一年级', '3', '3', '44', '1599026028', '1599026028', '', '1');
INSERT INTO `cj_kaohao` VALUES ('893', '7', '2', '2020', '一年级', '3', '3', '45', '1599026028', '1599026028', '', '1');
INSERT INTO `cj_kaohao` VALUES ('894', '7', '2', '2020', '一年级', '3', '3', '46', '1599026028', '1599026028', '', '1');
INSERT INTO `cj_kaohao` VALUES ('895', '7', '2', '2020', '一年级', '3', '3', '47', '1599026028', '1599026028', '', '1');
INSERT INTO `cj_kaohao` VALUES ('896', '7', '2', '2020', '一年级', '3', '3', '48', '1599026028', '1599026028', '', '1');
INSERT INTO `cj_kaohao` VALUES ('897', '7', '2', '2020', '一年级', '3', '3', '49', '1599026028', '1599026028', '', '1');
INSERT INTO `cj_kaohao` VALUES ('898', '7', '2', '2020', '一年级', '3', '3', '50', '1599026028', '1599026028', '', '1');
INSERT INTO `cj_kaohao` VALUES ('899', '7', '2', '2020', '一年级', '3', '3', '51', '1599026028', '1599026028', '', '1');
INSERT INTO `cj_kaohao` VALUES ('900', '7', '2', '2020', '一年级', '3', '3', '52', '1599026028', '1599026028', '', '1');
INSERT INTO `cj_kaohao` VALUES ('901', '7', '2', '2020', '一年级', '3', '3', '53', '1599026028', '1599026028', '', '1');
INSERT INTO `cj_kaohao` VALUES ('902', '7', '2', '2020', '一年级', '3', '3', '54', '1599026028', '1599026028', '', '1');
INSERT INTO `cj_kaohao` VALUES ('903', '7', '2', '2020', '一年级', '3', '3', '55', '1599026028', '1599026028', '', '1');
INSERT INTO `cj_kaohao` VALUES ('904', '7', '2', '2020', '一年级', '3', '3', '56', '1599026028', '1599026028', '', '1');
INSERT INTO `cj_kaohao` VALUES ('905', '7', '2', '2020', '一年级', '3', '3', '57', '1599026028', '1599026028', '', '1');
INSERT INTO `cj_kaohao` VALUES ('906', '7', '2', '2020', '一年级', '3', '3', '58', '1599026028', '1599026028', '', '1');
INSERT INTO `cj_kaohao` VALUES ('907', '7', '2', '2020', '一年级', '3', '3', '59', '1599026028', '1599026028', '', '1');
INSERT INTO `cj_kaohao` VALUES ('908', '7', '2', '2020', '一年级', '3', '3', '60', '1599026028', '1599026028', '', '1');
INSERT INTO `cj_kaohao` VALUES ('909', '7', '2', '2020', '一年级', '3', '3', '61', '1599026028', '1599026028', '', '1');
INSERT INTO `cj_kaohao` VALUES ('910', '7', '2', '2020', '一年级', '3', '3', '62', '1599026028', '1599026028', '', '1');
INSERT INTO `cj_kaohao` VALUES ('911', '7', '2', '2020', '一年级', '3', '3', '63', '1599026028', '1599026028', '', '1');
INSERT INTO `cj_kaohao` VALUES ('912', '7', '2', '2020', '一年级', '3', '3', '64', '1599026028', '1599026028', '', '1');
INSERT INTO `cj_kaohao` VALUES ('913', '7', '2', '2020', '一年级', '3', '3', '65', '1599026028', '1599026028', '', '1');
INSERT INTO `cj_kaohao` VALUES ('914', '7', '2', '2020', '一年级', '3', '3', '66', '1599026028', '1599026028', '', '1');
INSERT INTO `cj_kaohao` VALUES ('915', '7', '2', '2020', '一年级', '3', '3', '67', '1599026028', '1599026028', '', '1');
INSERT INTO `cj_kaohao` VALUES ('916', '7', '2', '2020', '一年级', '3', '3', '68', '1599026028', '1599026028', '', '1');
INSERT INTO `cj_kaohao` VALUES ('917', '7', '2', '2020', '一年级', '3', '3', '69', '1599026028', '1599026028', '', '1');
INSERT INTO `cj_kaohao` VALUES ('918', '7', '2', '2020', '一年级', '3', '3', '70', '1599026028', '1599026028', '', '1');
INSERT INTO `cj_kaohao` VALUES ('919', '7', '2', '2020', '一年级', '3', '3', '71', '1599026028', '1599026028', '', '1');
INSERT INTO `cj_kaohao` VALUES ('920', '7', '2', '2020', '一年级', '3', '3', '72', '1599026028', '1599026028', '', '1');
INSERT INTO `cj_kaohao` VALUES ('921', '7', '3', '2020', '一年级', '5', '2', '119', '1599026037', '1599026037', '', '1');
INSERT INTO `cj_kaohao` VALUES ('922', '7', '3', '2020', '一年级', '5', '2', '120', '1599026037', '1599026037', '', '1');
INSERT INTO `cj_kaohao` VALUES ('923', '7', '3', '2020', '一年级', '5', '2', '121', '1599026037', '1599026037', '', '1');
INSERT INTO `cj_kaohao` VALUES ('924', '7', '3', '2020', '一年级', '5', '2', '122', '1599026037', '1599026037', '', '1');
INSERT INTO `cj_kaohao` VALUES ('925', '7', '3', '2020', '一年级', '5', '2', '123', '1599026037', '1599026037', '', '1');
INSERT INTO `cj_kaohao` VALUES ('926', '7', '3', '2020', '一年级', '5', '2', '124', '1599026037', '1599026037', '', '1');
INSERT INTO `cj_kaohao` VALUES ('927', '7', '3', '2020', '一年级', '5', '2', '125', '1599026037', '1599026037', '', '1');
INSERT INTO `cj_kaohao` VALUES ('928', '7', '3', '2020', '一年级', '5', '2', '126', '1599026037', '1599026037', '', '1');
INSERT INTO `cj_kaohao` VALUES ('929', '7', '3', '2020', '一年级', '5', '2', '127', '1599026037', '1599026037', '', '1');
INSERT INTO `cj_kaohao` VALUES ('930', '7', '3', '2020', '一年级', '5', '2', '128', '1599026037', '1599026037', '', '1');
INSERT INTO `cj_kaohao` VALUES ('931', '7', '3', '2020', '一年级', '5', '2', '129', '1599026037', '1599026037', '', '1');
INSERT INTO `cj_kaohao` VALUES ('932', '7', '3', '2020', '一年级', '5', '2', '130', '1599026037', '1599026037', '', '1');
INSERT INTO `cj_kaohao` VALUES ('933', '7', '3', '2020', '一年级', '5', '2', '131', '1599026037', '1599026037', '', '1');
INSERT INTO `cj_kaohao` VALUES ('934', '7', '3', '2020', '一年级', '5', '2', '132', '1599026037', '1599026037', '', '1');
INSERT INTO `cj_kaohao` VALUES ('935', '7', '3', '2020', '一年级', '5', '2', '133', '1599026037', '1599026037', '', '1');
INSERT INTO `cj_kaohao` VALUES ('936', '7', '3', '2020', '一年级', '5', '2', '134', '1599026037', '1599026037', '', '1');
INSERT INTO `cj_kaohao` VALUES ('937', '7', '2', '2020', '一年级', '2', '2', '23', '1599026729', '1599026729', '', '1');
INSERT INTO `cj_kaohao` VALUES ('938', '7', '2', '2020', '一年级', '2', '2', '24', '1599026729', '1599026729', '', '1');
INSERT INTO `cj_kaohao` VALUES ('939', '7', '2', '2020', '一年级', '2', '2', '25', '1599026729', '1599026729', '', '1');
INSERT INTO `cj_kaohao` VALUES ('940', '7', '2', '2020', '一年级', '2', '2', '26', '1599026729', '1599026729', '', '1');
INSERT INTO `cj_kaohao` VALUES ('941', '7', '2', '2020', '一年级', '2', '2', '27', '1599026729', '1599026729', '', '1');
INSERT INTO `cj_kaohao` VALUES ('942', '7', '2', '2020', '一年级', '2', '2', '28', '1599026729', '1599026729', '', '1');
INSERT INTO `cj_kaohao` VALUES ('943', '7', '2', '2020', '一年级', '2', '2', '29', '1599026729', '1599026729', '', '1');
INSERT INTO `cj_kaohao` VALUES ('944', '7', '2', '2020', '一年级', '2', '2', '30', '1599026729', '1599026729', '', '1');
INSERT INTO `cj_kaohao` VALUES ('945', '7', '2', '2020', '一年级', '2', '2', '31', '1599026729', '1599026729', '', '1');
INSERT INTO `cj_kaohao` VALUES ('946', '7', '2', '2020', '一年级', '2', '2', '32', '1599026729', '1599026729', '', '1');
INSERT INTO `cj_kaohao` VALUES ('947', '7', '2', '2020', '一年级', '2', '2', '33', '1599026729', '1599026729', '', '1');
INSERT INTO `cj_kaohao` VALUES ('948', '7', '2', '2020', '一年级', '2', '2', '34', '1599026729', '1599026729', '', '1');
INSERT INTO `cj_kaohao` VALUES ('949', '7', '2', '2020', '一年级', '2', '2', '35', '1599026729', '1599026729', '', '1');
INSERT INTO `cj_kaohao` VALUES ('950', '7', '2', '2020', '一年级', '2', '2', '36', '1599026729', '1599026729', '', '1');
INSERT INTO `cj_kaohao` VALUES ('951', '7', '2', '2020', '一年级', '2', '2', '37', '1599026729', '1599026729', '', '1');
INSERT INTO `cj_kaohao` VALUES ('952', '7', '2', '2020', '一年级', '2', '2', '38', '1599026729', '1599026729', '', '1');
INSERT INTO `cj_kaohao` VALUES ('953', '8', '2', '2020', '一年级', '1', '1', '1', '1599032181', '1599032181', '', '1');
INSERT INTO `cj_kaohao` VALUES ('954', '8', '2', '2020', '一年级', '1', '1', '2', '1599032181', '1599032181', '', '1');
INSERT INTO `cj_kaohao` VALUES ('955', '8', '2', '2020', '一年级', '1', '1', '3', '1599032181', '1599032181', '', '1');
INSERT INTO `cj_kaohao` VALUES ('956', '8', '2', '2020', '一年级', '1', '1', '4', '1599032181', '1599032181', '', '1');
INSERT INTO `cj_kaohao` VALUES ('957', '8', '2', '2020', '一年级', '1', '1', '5', '1599032181', '1599032181', '', '1');
INSERT INTO `cj_kaohao` VALUES ('958', '8', '2', '2020', '一年级', '1', '1', '6', '1599032181', '1599032181', '', '1');
INSERT INTO `cj_kaohao` VALUES ('959', '8', '2', '2020', '一年级', '1', '1', '7', '1599032181', '1599032181', '', '1');
INSERT INTO `cj_kaohao` VALUES ('960', '8', '2', '2020', '一年级', '1', '1', '8', '1599032181', '1599032181', '', '1');
INSERT INTO `cj_kaohao` VALUES ('961', '8', '2', '2020', '一年级', '1', '1', '9', '1599032181', '1599032181', '', '1');
INSERT INTO `cj_kaohao` VALUES ('962', '8', '2', '2020', '一年级', '1', '1', '10', '1599032181', '1599032181', '', '1');
INSERT INTO `cj_kaohao` VALUES ('963', '8', '2', '2020', '一年级', '1', '1', '11', '1599032181', '1599032181', '', '1');
INSERT INTO `cj_kaohao` VALUES ('964', '8', '2', '2020', '一年级', '1', '1', '12', '1599032181', '1599032181', '', '1');
INSERT INTO `cj_kaohao` VALUES ('965', '8', '2', '2020', '一年级', '1', '1', '13', '1599032181', '1599032181', '', '1');
INSERT INTO `cj_kaohao` VALUES ('966', '8', '2', '2020', '一年级', '1', '1', '14', '1599032181', '1599032181', '', '1');
INSERT INTO `cj_kaohao` VALUES ('967', '8', '2', '2020', '一年级', '1', '1', '15', '1599032181', '1599032181', '', '1');
INSERT INTO `cj_kaohao` VALUES ('968', '8', '2', '2020', '一年级', '1', '1', '16', '1599032181', '1599032181', '', '1');
INSERT INTO `cj_kaohao` VALUES ('969', '8', '2', '2020', '一年级', '1', '1', '17', '1599032181', '1599032181', '', '1');
INSERT INTO `cj_kaohao` VALUES ('970', '8', '2', '2020', '一年级', '1', '1', '18', '1599032181', '1599032181', '', '1');
INSERT INTO `cj_kaohao` VALUES ('971', '8', '2', '2020', '一年级', '1', '1', '19', '1599032181', '1599032181', '', '1');
INSERT INTO `cj_kaohao` VALUES ('972', '8', '2', '2020', '一年级', '1', '1', '20', '1599032181', '1599032181', '', '1');
INSERT INTO `cj_kaohao` VALUES ('973', '8', '2', '2020', '一年级', '1', '1', '21', '1599032181', '1599032181', '', '1');
INSERT INTO `cj_kaohao` VALUES ('974', '8', '2', '2020', '一年级', '1', '1', '22', '1599032181', '1599032181', '', '1');
INSERT INTO `cj_kaohao` VALUES ('975', '8', '2', '2020', '一年级', '2', '2', '23', '1599032181', '1599032181', '', '1');
INSERT INTO `cj_kaohao` VALUES ('976', '8', '2', '2020', '一年级', '2', '2', '24', '1599032181', '1599032181', '', '1');
INSERT INTO `cj_kaohao` VALUES ('977', '8', '2', '2020', '一年级', '2', '2', '25', '1599032181', '1599032181', '', '1');
INSERT INTO `cj_kaohao` VALUES ('978', '8', '2', '2020', '一年级', '2', '2', '26', '1599032181', '1599032181', '', '1');
INSERT INTO `cj_kaohao` VALUES ('979', '8', '2', '2020', '一年级', '2', '2', '27', '1599032181', '1599032181', '', '1');
INSERT INTO `cj_kaohao` VALUES ('980', '8', '2', '2020', '一年级', '2', '2', '28', '1599032181', '1599032181', '', '1');
INSERT INTO `cj_kaohao` VALUES ('981', '8', '2', '2020', '一年级', '2', '2', '29', '1599032181', '1599032181', '', '1');
INSERT INTO `cj_kaohao` VALUES ('982', '8', '2', '2020', '一年级', '2', '2', '30', '1599032181', '1599032181', '', '1');
INSERT INTO `cj_kaohao` VALUES ('983', '8', '2', '2020', '一年级', '2', '2', '31', '1599032181', '1599032181', '', '1');
INSERT INTO `cj_kaohao` VALUES ('984', '8', '2', '2020', '一年级', '2', '2', '32', '1599032181', '1599032181', '', '1');
INSERT INTO `cj_kaohao` VALUES ('985', '8', '2', '2020', '一年级', '2', '2', '33', '1599032181', '1599032181', '', '1');
INSERT INTO `cj_kaohao` VALUES ('986', '8', '2', '2020', '一年级', '2', '2', '34', '1599032181', '1599032181', '', '1');
INSERT INTO `cj_kaohao` VALUES ('987', '8', '2', '2020', '一年级', '2', '2', '35', '1599032181', '1599032181', '', '1');
INSERT INTO `cj_kaohao` VALUES ('988', '8', '2', '2020', '一年级', '2', '2', '36', '1599032181', '1599032181', '', '1');
INSERT INTO `cj_kaohao` VALUES ('989', '8', '2', '2020', '一年级', '2', '2', '37', '1599032181', '1599032181', '', '1');
INSERT INTO `cj_kaohao` VALUES ('990', '8', '2', '2020', '一年级', '2', '2', '38', '1599032181', '1599032181', '', '1');
INSERT INTO `cj_kaohao` VALUES ('991', '8', '2', '2020', '一年级', '3', '3', '39', '1599032181', '1599032181', '', '1');
INSERT INTO `cj_kaohao` VALUES ('992', '8', '2', '2020', '一年级', '3', '3', '40', '1599032181', '1599032181', '', '1');
INSERT INTO `cj_kaohao` VALUES ('993', '8', '2', '2020', '一年级', '3', '3', '41', '1599032181', '1599032181', '', '1');
INSERT INTO `cj_kaohao` VALUES ('994', '8', '2', '2020', '一年级', '3', '3', '42', '1599032181', '1599032181', '', '1');
INSERT INTO `cj_kaohao` VALUES ('995', '8', '2', '2020', '一年级', '3', '3', '43', '1599032181', '1599032181', '', '1');
INSERT INTO `cj_kaohao` VALUES ('996', '8', '2', '2020', '一年级', '3', '3', '44', '1599032181', '1599032181', '', '1');
INSERT INTO `cj_kaohao` VALUES ('997', '8', '2', '2020', '一年级', '3', '3', '45', '1599032181', '1599032181', '', '1');
INSERT INTO `cj_kaohao` VALUES ('998', '8', '2', '2020', '一年级', '3', '3', '46', '1599032181', '1599032181', '', '1');
INSERT INTO `cj_kaohao` VALUES ('999', '8', '2', '2020', '一年级', '3', '3', '47', '1599032181', '1599032181', '', '1');
INSERT INTO `cj_kaohao` VALUES ('1000', '8', '2', '2020', '一年级', '3', '3', '48', '1599032181', '1599032181', '', '1');

-- -----------------------------
-- Table structure for `cj_kaoshi`
-- -----------------------------
DROP TABLE IF EXISTS `cj_kaoshi`;
CREATE TABLE `cj_kaoshi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(25) NOT NULL DEFAULT 'a' COMMENT '考试名称',
  `zuzhi_id` int(11) NOT NULL DEFAULT '0' COMMENT '组织考试单位',
  `xueqi_id` int(11) NOT NULL DEFAULT '0' COMMENT '学期',
  `category_id` int(11) NOT NULL DEFAULT '0' COMMENT '类别',
  `bfdate` int(11) NOT NULL DEFAULT '1539158918' COMMENT '开始日期',
  `enddate` int(11) NOT NULL DEFAULT '1539158918' COMMENT '结束日期',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0=禁用，1=正常',
  `luru` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0=不允许，1=允许',
  `create_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '更新时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  `beizhu` varchar(80) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- -----------------------------
-- Records of `cj_kaoshi`
-- -----------------------------
INSERT INTO `cj_kaoshi` VALUES ('1', '考试一（全参加考试）', '1', '2', '10901', '1598976000', '1599062399', '0', '0', '1599024297', '1599024347', '', '');
INSERT INTO `cj_kaoshi` VALUES ('2', '考试二（全参加考试）', '2', '2', '10903', '1599148800', '1599235199', '0', '0', '1599024381', '1599025043', '', '');
INSERT INTO `cj_kaoshi` VALUES ('3', '考试三（全参加考试）', '1', '2', '10902', '1599235200', '1599321599', '0', '0', '1599024484', '1599025037', '', '');
INSERT INTO `cj_kaoshi` VALUES ('4', '考试四（全部参加考试）', '1', '2', '10903', '1599321600', '1599407999', '0', '0', '1599024532', '1599024570', '', '');
INSERT INTO `cj_kaoshi` VALUES ('5', '考试五（部分学科参加考试）', '1', '1', '10902', '1599408000', '1599494399', '0', '0', '1599024599', '1599024599', '', '');
INSERT INTO `cj_kaoshi` VALUES ('6', '考试六（全部参加考试但满分不同）', '1', '2', '10901', '1599667200', '1599753599', '0', '0', '1599024672', '1599024672', '', '');
INSERT INTO `cj_kaoshi` VALUES ('7', '考试七（所有学科部分班级参加考试）', '2', '1', '10902', '1598976000', '1599062399', '0', '0', '1599024974', '1599024974', '', '');
INSERT INTO `cj_kaoshi` VALUES ('8', '考试八(学生测试)', '1', '2', '10902', '1599667200', '1599753599', '1', '1', '1599032029', '1599032051', '', '');
INSERT INTO `cj_kaoshi` VALUES ('9', '考试九(统计成绩测试)', '2', '2', '10901', '1599667200', '1599753599', '1', '0', '1599032084', '1599032084', '', '');

-- -----------------------------
-- Table structure for `cj_kaoshi_set`
-- -----------------------------
DROP TABLE IF EXISTS `cj_kaoshi_set`;
CREATE TABLE `cj_kaoshi_set` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kaoshi_id` int(11) NOT NULL DEFAULT '0' COMMENT '考试id',
  `ruxuenian` int(80) NOT NULL DEFAULT '0' COMMENT '年级',
  `nianjiname` varchar(10) NOT NULL DEFAULT 'a' COMMENT '年级名',
  `subject_id` int(11) NOT NULL DEFAULT '0' COMMENT '学科id',
  `manfen` int(3) NOT NULL DEFAULT '100' COMMENT '满分',
  `youxiu` int(3) NOT NULL DEFAULT '90' COMMENT '优秀',
  `jige` int(3) NOT NULL DEFAULT '0' COMMENT '及格',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `create_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '更新时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=utf8;

-- -----------------------------
-- Records of `cj_kaoshi_set`
-- -----------------------------
INSERT INTO `cj_kaoshi_set` VALUES ('50', '9', '2020', '一年级', '101', '100', '90', '60', '1', '1599441676', '1599441676', '');
INSERT INTO `cj_kaoshi_set` VALUES ('51', '9', '2020', '一年级', '102', '100', '90', '60', '1', '1599441676', '1599441676', '');
INSERT INTO `cj_kaoshi_set` VALUES ('52', '9', '2020', '一年级', '103', '100', '90', '60', '1', '1599441676', '1599441676', '');
INSERT INTO `cj_kaoshi_set` VALUES ('53', '9', '2019', '二年级', '101', '100', '90', '60', '1', '1599441685', '1599441685', '');
INSERT INTO `cj_kaoshi_set` VALUES ('54', '9', '2019', '二年级', '102', '100', '90', '60', '1', '1599441685', '1599441685', '');
INSERT INTO `cj_kaoshi_set` VALUES ('55', '9', '2019', '二年级', '103', '100', '90', '60', '1', '1599441685', '1599441685', '');
INSERT INTO `cj_kaoshi_set` VALUES ('56', '8', '2020', '一年级', '101', '100', '90', '60', '1', '1599442648', '1599442648', '');
INSERT INTO `cj_kaoshi_set` VALUES ('57', '8', '2020', '一年级', '102', '100', '90', '60', '1', '1599442648', '1599442648', '');
INSERT INTO `cj_kaoshi_set` VALUES ('58', '8', '2020', '一年级', '103', '100', '90', '60', '1', '1599442648', '1599442648', '');
INSERT INTO `cj_kaoshi_set` VALUES ('59', '8', '2019', '二年级', '101', '100', '90', '60', '1', '1599442656', '1599442656', '');
INSERT INTO `cj_kaoshi_set` VALUES ('60', '8', '2019', '二年级', '102', '100', '90', '60', '1', '1599442656', '1599442656', '');
INSERT INTO `cj_kaoshi_set` VALUES ('61', '8', '2019', '二年级', '103', '100', '90', '60', '1', '1599442656', '1599442656', '');
INSERT INTO `cj_kaoshi_set` VALUES ('62', '7', '2020', '一年级', '101', '100', '90', '60', '1', '1599442700', '1599442700', '');
INSERT INTO `cj_kaoshi_set` VALUES ('63', '7', '2020', '一年级', '102', '100', '90', '60', '1', '1599442700', '1599442700', '');
INSERT INTO `cj_kaoshi_set` VALUES ('64', '7', '2020', '一年级', '103', '100', '90', '60', '1', '1599442700', '1599442700', '');
INSERT INTO `cj_kaoshi_set` VALUES ('65', '6', '2020', '一年级', '101', '108', '97', '65', '1', '1599442783', '1599442783', '');
INSERT INTO `cj_kaoshi_set` VALUES ('66', '6', '2020', '一年级', '102', '120', '108', '72', '1', '1599442783', '1599442783', '');
INSERT INTO `cj_kaoshi_set` VALUES ('67', '6', '2020', '一年级', '103', '130', '117', '78', '1', '1599442783', '1599442783', '');
INSERT INTO `cj_kaoshi_set` VALUES ('68', '6', '2019', '二年级', '101', '60', '54', '36', '1', '1599442798', '1599442798', '');
INSERT INTO `cj_kaoshi_set` VALUES ('69', '6', '2019', '二年级', '102', '65', '59', '39', '1', '1599442798', '1599442798', '');
INSERT INTO `cj_kaoshi_set` VALUES ('70', '6', '2019', '二年级', '103', '88', '79', '53', '1', '1599442798', '1599442798', '');
INSERT INTO `cj_kaoshi_set` VALUES ('71', '5', '2020', '一年级', '101', '100', '90', '60', '1', '1599442857', '1599442857', '');
INSERT INTO `cj_kaoshi_set` VALUES ('72', '5', '2020', '一年级', '103', '100', '90', '60', '1', '1599442857', '1599442857', '');
INSERT INTO `cj_kaoshi_set` VALUES ('73', '5', '2019', '二年级', '101', '100', '90', '60', '1', '1599442863', '1599442863', '');
INSERT INTO `cj_kaoshi_set` VALUES ('74', '5', '2019', '二年级', '103', '100', '90', '60', '1', '1599442863', '1599442863', '');
INSERT INTO `cj_kaoshi_set` VALUES ('75', '4', '2020', '一年级', '101', '100', '90', '60', '1', '1599442890', '1599442890', '');
INSERT INTO `cj_kaoshi_set` VALUES ('76', '4', '2020', '一年级', '102', '100', '90', '60', '1', '1599442890', '1599442890', '');
INSERT INTO `cj_kaoshi_set` VALUES ('77', '4', '2020', '一年级', '103', '100', '90', '60', '1', '1599442890', '1599442890', '');
INSERT INTO `cj_kaoshi_set` VALUES ('78', '4', '2019', '二年级', '101', '100', '90', '60', '1', '1599442900', '1599442900', '');
INSERT INTO `cj_kaoshi_set` VALUES ('79', '4', '2019', '二年级', '102', '100', '90', '60', '1', '1599442900', '1599442900', '');
INSERT INTO `cj_kaoshi_set` VALUES ('80', '4', '2019', '二年级', '103', '100', '90', '60', '1', '1599442900', '1599442900', '');
INSERT INTO `cj_kaoshi_set` VALUES ('81', '3', '2020', '一年级', '101', '100', '90', '60', '1', '1599442931', '1599442931', '');
INSERT INTO `cj_kaoshi_set` VALUES ('82', '3', '2020', '一年级', '102', '100', '90', '60', '1', '1599442931', '1599442931', '');
INSERT INTO `cj_kaoshi_set` VALUES ('83', '3', '2020', '一年级', '103', '100', '90', '60', '1', '1599442931', '1599442931', '');
INSERT INTO `cj_kaoshi_set` VALUES ('84', '3', '2019', '二年级', '101', '100', '90', '60', '1', '1599442938', '1599442938', '');
INSERT INTO `cj_kaoshi_set` VALUES ('85', '3', '2019', '二年级', '102', '100', '90', '60', '1', '1599442938', '1599442938', '');
INSERT INTO `cj_kaoshi_set` VALUES ('86', '3', '2019', '二年级', '103', '100', '90', '60', '1', '1599442938', '1599442938', '');
INSERT INTO `cj_kaoshi_set` VALUES ('87', '2', '2020', '一年级', '101', '100', '90', '60', '1', '1599442960', '1599442960', '');
INSERT INTO `cj_kaoshi_set` VALUES ('88', '2', '2020', '一年级', '102', '100', '90', '60', '1', '1599442960', '1599442960', '');
INSERT INTO `cj_kaoshi_set` VALUES ('89', '2', '2020', '一年级', '103', '100', '90', '60', '1', '1599442960', '1599442960', '');
INSERT INTO `cj_kaoshi_set` VALUES ('90', '2', '2019', '二年级', '101', '100', '90', '60', '1', '1599442966', '1599442966', '');
INSERT INTO `cj_kaoshi_set` VALUES ('91', '2', '2019', '二年级', '102', '100', '90', '60', '1', '1599442966', '1599442966', '');
INSERT INTO `cj_kaoshi_set` VALUES ('92', '2', '2019', '二年级', '103', '100', '90', '60', '1', '1599442966', '1599442966', '');
INSERT INTO `cj_kaoshi_set` VALUES ('93', '1', '2020', '一年级', '101', '100', '90', '60', '1', '1599442990', '1599442990', '');
INSERT INTO `cj_kaoshi_set` VALUES ('94', '1', '2020', '一年级', '102', '100', '90', '60', '1', '1599442990', '1599442990', '');
INSERT INTO `cj_kaoshi_set` VALUES ('95', '1', '2020', '一年级', '103', '100', '90', '60', '1', '1599442990', '1599442990', '');
INSERT INTO `cj_kaoshi_set` VALUES ('96', '1', '2019', '二年级', '101', '100', '90', '60', '1', '1599442996', '1599442996', '');
INSERT INTO `cj_kaoshi_set` VALUES ('97', '1', '2019', '二年级', '102', '100', '90', '60', '1', '1599442996', '1599442996', '');
INSERT INTO `cj_kaoshi_set` VALUES ('98', '1', '2019', '二年级', '103', '100', '90', '60', '1', '1599442996', '1599442996', '');

-- -----------------------------
-- Table structure for `cj_keti`
-- -----------------------------
DROP TABLE IF EXISTS `cj_keti`;
CREATE TABLE `cj_keti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '0' COMMENT '课题册名称',
  `lxshijian` int(11) NOT NULL DEFAULT '1539158918' COMMENT '立项时间',
  `lxdanwei_id` int(11) NOT NULL DEFAULT '0' COMMENT '立项单位id',
  `category_id` int(11) NOT NULL DEFAULT '0' COMMENT '课题类型',
  `create_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '更新时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  `beizhu` varchar(80) DEFAULT NULL COMMENT '备注',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0=禁用，1=正常',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- -----------------------------
-- Table structure for `cj_keti_canyu`
-- -----------------------------
DROP TABLE IF EXISTS `cj_keti_canyu`;
CREATE TABLE `cj_keti_canyu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL DEFAULT '0' COMMENT '课题主持人或课题参与人',
  `ketiinfo_id` int(11) NOT NULL DEFAULT '0' COMMENT '课题信息id',
  `teacher_id` int(11) NOT NULL DEFAULT '0' COMMENT '教师id',
  `create_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '更新时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- -----------------------------
-- Table structure for `cj_keti_info`
-- -----------------------------
DROP TABLE IF EXISTS `cj_keti_info`;
CREATE TABLE `cj_keti_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '无标题' COMMENT '课题名称',
  `ketice_id` int(11) NOT NULL DEFAULT '0' COMMENT '课题册id',
  `bianhao` varchar(50) DEFAULT NULL COMMENT '课题编号',
  `lxpic` varchar(100) DEFAULT NULL COMMENT '立项证书图片',
  `subject_id` int(11) DEFAULT NULL COMMENT '学科分类',
  `fzdanwei_id` int(11) DEFAULT NULL COMMENT '负责单位id',
  `category_id` int(11) DEFAULT NULL COMMENT '研究类型',
  `jhjtshijian` int(11) DEFAULT NULL COMMENT '计划结题时间',
  `jtshijian` int(11) DEFAULT NULL COMMENT '结题时间',
  `jddengji_id` int(11) NOT NULL DEFAULT '11801' COMMENT '鉴定等级',
  `jtpic` varchar(100) DEFAULT NULL COMMENT '结题证书图片',
  `create_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '更新时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0=禁用，1=正常',
  `beizhu` varchar(200) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- -----------------------------
-- Table structure for `cj_migrations`
-- -----------------------------
DROP TABLE IF EXISTS `cj_migrations`;
CREATE TABLE `cj_migrations` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `end_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `breakpoint` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -----------------------------
-- Records of `cj_migrations`
-- -----------------------------
INSERT INTO `cj_migrations` VALUES ('202001132733', 'KaoshiSet', '2020-09-02 12:47:48', '2020-09-02 12:47:48', '0');
INSERT INTO `cj_migrations` VALUES ('20181010035225', 'SystemBase', '2020-09-02 12:47:48', '2020-09-02 12:47:48', '0');
INSERT INTO `cj_migrations` VALUES ('20181010075304', 'AuthGroup', '2020-09-02 12:47:48', '2020-09-02 12:47:48', '0');
INSERT INTO `cj_migrations` VALUES ('20181010075517', 'AuthGroupAccess', '2020-09-02 12:47:48', '2020-09-02 12:47:48', '0');
INSERT INTO `cj_migrations` VALUES ('20181010075553', 'AuthRule', '2020-09-02 12:47:48', '2020-09-02 12:47:48', '0');
INSERT INTO `cj_migrations` VALUES ('20181012140355', 'Member', '2020-09-02 12:47:48', '2020-09-02 12:47:48', '0');
INSERT INTO `cj_migrations` VALUES ('20181025041505', 'Category', '2020-09-02 12:47:48', '2020-09-02 12:47:48', '0');
INSERT INTO `cj_migrations` VALUES ('20181026002455', 'School', '2020-09-02 12:47:48', '2020-09-02 12:47:48', '0');
INSERT INTO `cj_migrations` VALUES ('20181028023517', 'Teacher', '2020-09-02 12:47:48', '2020-09-02 12:47:48', '0');
INSERT INTO `cj_migrations` VALUES ('20181028024920', 'Xueqi', '2020-09-02 12:47:48', '2020-09-02 12:47:48', '0');
INSERT INTO `cj_migrations` VALUES ('20181028025648', 'Kaoshi', '2020-09-02 12:47:48', '2020-09-02 12:47:49', '0');
INSERT INTO `cj_migrations` VALUES ('20181030024954', 'Subject', '2020-09-02 12:47:49', '2020-09-02 12:47:49', '0');
INSERT INTO `cj_migrations` VALUES ('20181101040801', 'Fields', '2020-09-02 12:47:49', '2020-09-02 12:47:49', '0');
INSERT INTO `cj_migrations` VALUES ('20181102003411', 'Student', '2020-09-02 12:47:49', '2020-09-02 12:47:49', '0');
INSERT INTO `cj_migrations` VALUES ('20181102004156', 'Banji', '2020-09-02 12:47:49', '2020-09-02 12:47:49', '0');
INSERT INTO `cj_migrations` VALUES ('20181114055804', 'Kaohao', '2020-09-02 12:47:49', '2020-09-02 12:47:49', '0');
INSERT INTO `cj_migrations` VALUES ('20181218041034', 'DwRongyu', '2020-09-02 12:47:49', '2020-09-02 12:47:49', '0');
INSERT INTO `cj_migrations` VALUES ('20181221041509', 'JsRongyu', '2020-09-02 12:47:49', '2020-09-02 12:47:49', '0');
INSERT INTO `cj_migrations` VALUES ('20181221041523', 'JsRongyuInfo', '2020-09-02 12:47:49', '2020-09-02 12:47:49', '0');
INSERT INTO `cj_migrations` VALUES ('20181227061353', 'DwRongyuCanyu', '2020-09-02 12:47:49', '2020-09-02 12:47:49', '0');
INSERT INTO `cj_migrations` VALUES ('20190214052203', 'JsRongyuCanyu', '2020-09-02 12:47:49', '2020-09-02 12:47:49', '0');
INSERT INTO `cj_migrations` VALUES ('20190218055858', 'Keti', '2020-09-02 12:47:49', '2020-09-02 12:47:49', '0');
INSERT INTO `cj_migrations` VALUES ('20190222040223', 'KetiInfo', '2020-09-02 12:47:49', '2020-09-02 12:47:49', '0');
INSERT INTO `cj_migrations` VALUES ('20190222041040', 'KetiCanyu', '2020-09-02 12:47:49', '2020-09-02 12:47:49', '0');
INSERT INTO `cj_migrations` VALUES ('20190430034853', 'Chengji', '2020-09-02 12:47:49', '2020-09-02 12:47:49', '0');
INSERT INTO `cj_migrations` VALUES ('20200106012240', 'TongjiNj', '2020-09-02 12:47:49', '2020-09-02 12:47:49', '0');
INSERT INTO `cj_migrations` VALUES ('20200106013922', 'TongjiBj', '2020-09-02 12:47:49', '2020-09-02 12:47:49', '0');
INSERT INTO `cj_migrations` VALUES ('20200107045207', 'TongjiSch', '2020-09-02 12:47:49', '2020-09-02 12:47:49', '0');
INSERT INTO `cj_migrations` VALUES ('20200309035912', 'TongjiLog', '2020-09-02 12:47:49', '2020-09-02 12:47:49', '0');
INSERT INTO `cj_migrations` VALUES ('20200616052125', 'TeacherZhiwu', '2020-09-02 12:47:49', '2020-09-02 12:47:49', '0');

-- -----------------------------
-- Table structure for `cj_school`
-- -----------------------------
DROP TABLE IF EXISTS `cj_school`;
CREATE TABLE `cj_school` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(25) NOT NULL DEFAULT 'a' COMMENT '单位名称',
  `jiancheng` varchar(6) NOT NULL DEFAULT 'a' COMMENT '单位简称',
  `biaoshi` varchar(11) DEFAULT NULL COMMENT '单位标识',
  `xingzhi_id` int(11) DEFAULT NULL COMMENT '单位性质',
  `jibie_id` int(11) DEFAULT NULL COMMENT '单位级别',
  `xueduan_id` int(11) DEFAULT NULL COMMENT '学段',
  `kaoshi` tinyint(1) NOT NULL DEFAULT '0' COMMENT '能不能组织考试，0=不用，1=能',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0=禁用，1=正常',
  `paixu` int(4) NOT NULL DEFAULT '999' COMMENT '排序',
  `create_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '更新时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  `beizhu` varchar(80) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  UNIQUE KEY `jiancheng` (`jiancheng`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- -----------------------------
-- Records of `cj_school`
-- -----------------------------
INSERT INTO `cj_school` VALUES ('1', '大连长岛经济区文教中心', '文教中心', '', '10107', '10204', '10303', '1', '1', '10', '1539158918', '1539158918', '', '');
INSERT INTO `cj_school` VALUES ('2', '大连长兴岛经济区前山小学', '前山', '', '10102', '10203', '10302', '1', '1', '1', '1599022713', '1599022713', '', '');
INSERT INTO `cj_school` VALUES ('3', '大连长兴岛经济区后海小学', '后海', '', '10102', '10203', '10302', '0', '1', '2', '1599022735', '1599022735', '', '');

-- -----------------------------
-- Table structure for `cj_student`
-- -----------------------------
DROP TABLE IF EXISTS `cj_student`;
CREATE TABLE `cj_student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `xingming` varchar(5) NOT NULL DEFAULT 'a' COMMENT '姓名',
  `sex` tinyint(1) NOT NULL DEFAULT '1' COMMENT '性别',
  `shengri` int(11) NOT NULL DEFAULT '1539158918' COMMENT '生日',
  `shenfenzhenghao` varchar(18) NOT NULL DEFAULT 'N1539158918' COMMENT '身份证号',
  `password` varchar(137) NOT NULL DEFAULT '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1' COMMENT '登录密码',
  `denglucishu` int(5) NOT NULL DEFAULT '0' COMMENT '登录次数',
  `lastip` varchar(55) NOT NULL DEFAULT '127.0.0.1' COMMENT '最后一次登录IP',
  `ip` varchar(55) NOT NULL DEFAULT '127.0.0.1' COMMENT '登录IP',
  `lasttime` int(11) NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `thistime` int(11) NOT NULL DEFAULT '0' COMMENT '本次登录时间',
  `banji_id` int(11) NOT NULL DEFAULT '1' COMMENT '班级',
  `kaoshi` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否参加考试',
  `quanpin` varchar(30) NOT NULL DEFAULT 'a' COMMENT '全拼',
  `shoupin` varchar(5) NOT NULL DEFAULT 'a' COMMENT '简拼',
  `create_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '更新时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0=禁用，1=正常',
  PRIMARY KEY (`id`),
  UNIQUE KEY `shenfenzhenghao` (`shenfenzhenghao`)
) ENGINE=InnoDB AUTO_INCREMENT=145 DEFAULT CHARSET=utf8;

-- -----------------------------
-- Records of `cj_student`
-- -----------------------------
INSERT INTO `cj_student` VALUES ('1', '霍去病', '1', '1349020800', '210202201210018213', '$apr1$yAwA2a5a$M0AR2xVeBsOLvi1PhwrhF0', '15', '127.0.0.1', '127.0.0.1', '1600172883', '1600172883', '1', '1', 'huoqubing', 'hqb', '1599023981', '1600172883', '', '1');
INSERT INTO `cj_student` VALUES ('2', '李睦豪', '1', '1420128000', '210283201501028211', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '1', '1', 'limuhao', 'lmh', '1599023981', '1599023981', '', '1');
INSERT INTO `cj_student` VALUES ('3', '王文迪', '1', '1420128000', '210284201501028212', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '1', '1', 'wangwendi', 'wwd', '1599023981', '1599023981', '', '1');
INSERT INTO `cj_student` VALUES ('4', '周宝仕', '1', '1420128000', '210285201501028213', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '1', '1', 'zhoubaoshi', 'zbs', '1599023981', '1599023981', '', '1');
INSERT INTO `cj_student` VALUES ('5', '由如彬', '1', '1420128000', '210286201501028214', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '1', '1', 'yourubin', 'yrb', '1599023981', '1599023981', '', '1');
INSERT INTO `cj_student` VALUES ('6', '李盛楠', '1', '1420128000', '210287201501028215', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '1', '1', 'lishengnan', 'lsn', '1599023981', '1599023981', '', '1');
INSERT INTO `cj_student` VALUES ('7', '林天宇', '1', '1420128000', '210288201501028216', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '1', '1', 'lintianyu', 'lty', '1599023981', '1599023981', '', '1');
INSERT INTO `cj_student` VALUES ('8', '张圣洁', '1', '1420128000', '210289201501028217', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '1', '1', 'zhangshengjie', 'zsj', '1599023981', '1599023981', '', '1');
INSERT INTO `cj_student` VALUES ('9', '邵国栋', '1', '1420128000', '210290201501028218', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '1', '1', 'shaoguodong', 'sgd', '1599023981', '1599023981', '', '1');
INSERT INTO `cj_student` VALUES ('10', '石心平', '1', '1420128000', '210291201501028219', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '1', '1', 'shixinping', 'sxp', '1599023981', '1599023981', '', '1');
INSERT INTO `cj_student` VALUES ('11', '郭日升', '0', '1420128000', '210292201501028220', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '1', '1', 'guorisheng', 'grs', '1599023981', '1599023981', '', '1');
INSERT INTO `cj_student` VALUES ('12', '何子博', '0', '1420128000', '210293201501028221', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '1', '1', 'hezibo', 'hzb', '1599023981', '1599023981', '', '1');
INSERT INTO `cj_student` VALUES ('13', '方忠伟', '0', '1420128000', '210294201501028222', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '1', '1', 'fangzhongwei', 'fzw', '1599023981', '1599023981', '', '1');
INSERT INTO `cj_student` VALUES ('14', '王高志', '0', '1420128000', '210295201501028223', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '1', '1', 'wanggaozhi', 'wgz', '1599023981', '1599023981', '', '1');
INSERT INTO `cj_student` VALUES ('15', '刘兴野', '0', '1420128000', '210296201501028224', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '1', '1', 'liuxingye', 'lxy', '1599023981', '1599023981', '', '1');
INSERT INTO `cj_student` VALUES ('16', '孙宇曦', '0', '1420128000', '210297201501028225', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '1', '1', 'sunyuxi', 'syx', '1599023981', '1599023981', '', '1');
INSERT INTO `cj_student` VALUES ('17', '史义程', '0', '1420128000', '210298201501028226', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '1', '1', 'shiyicheng', 'syc', '1599023981', '1599023981', '', '1');
INSERT INTO `cj_student` VALUES ('18', '殷钏君', '0', '1420128000', '210299201501028227', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '1', '1', 'yinchuanjun', 'ycj', '1599023981', '1599023981', '', '1');
INSERT INTO `cj_student` VALUES ('19', '张蒙恩', '0', '1420128000', '210300201501028228', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '1', '1', 'zhangmengen', 'zme', '1599023981', '1599023981', '', '1');
INSERT INTO `cj_student` VALUES ('20', '姚海然', '0', '1420128000', '210301201501028229', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '1', '1', 'yaohairan', 'yhr', '1599023981', '1599023981', '', '1');
INSERT INTO `cj_student` VALUES ('21', '庄荣华', '1', '1420128000', '210302201501028230', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '1', '1', 'zhuangronghua', 'zrh', '1599023981', '1599023981', '', '1');
INSERT INTO `cj_student` VALUES ('22', '刘子龙', '1', '1420128000', '210303201501028231', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '1', '1', 'liuzilong', 'lzl', '1599023981', '1599023981', '', '1');
INSERT INTO `cj_student` VALUES ('23', '王健宇', '1', '1420128000', '210304201501028232', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '2', '1', 'wangjianyu', 'wjy', '1599023982', '1599023982', '', '1');
INSERT INTO `cj_student` VALUES ('24', '李涵功', '1', '1420128000', '210305201501028233', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '2', '1', 'lihangong', 'lhg', '1599023982', '1599023982', '', '1');
INSERT INTO `cj_student` VALUES ('25', '孙承霏', '1', '1420128000', '210306201501028234', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '2', '1', 'sunchengfei', 'scf', '1599023982', '1599023982', '', '1');
INSERT INTO `cj_student` VALUES ('26', '王铖广', '1', '1420128000', '210307201501028235', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '2', '1', 'wangchengguang', 'wcg', '1599023982', '1599023982', '', '1');
INSERT INTO `cj_student` VALUES ('27', '徐民和', '1', '1420128000', '210308201501028236', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '2', '1', 'xuminhe', 'xmh', '1599023982', '1599023982', '', '1');
INSERT INTO `cj_student` VALUES ('28', '刘廷熠', '1', '1420128000', '210309201501028237', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '2', '1', 'liutingyi', 'lty', '1599023982', '1599023982', '', '1');
INSERT INTO `cj_student` VALUES ('29', '迟忠旭', '1', '1420128000', '210310201501028238', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '2', '1', 'chizhongxu', 'czx', '1599023982', '1599023982', '', '1');
INSERT INTO `cj_student` VALUES ('30', '田延宇', '1', '1420128000', '210311201501028239', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '2', '1', 'tianyanyu', 'tyy', '1599023982', '1599023982', '', '1');
INSERT INTO `cj_student` VALUES ('31', '王永灿', '0', '1420128000', '210312201501028240', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '2', '1', 'wangyongcan', 'wyc', '1599023982', '1599023982', '', '1');
INSERT INTO `cj_student` VALUES ('32', '贾修奥', '0', '1420128000', '210313201501028241', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '2', '1', 'jiaxiuao', 'jxa', '1599023982', '1599023982', '', '1');
INSERT INTO `cj_student` VALUES ('33', '张晓龙', '0', '1420128000', '210314201501028242', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '2', '1', 'zhangxiaolong', 'zxl', '1599023982', '1599023982', '', '1');
INSERT INTO `cj_student` VALUES ('34', '刘文磊', '0', '1420128000', '210315201501028243', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '2', '1', 'liuwenlei', 'lwl', '1599023982', '1599023982', '', '1');
INSERT INTO `cj_student` VALUES ('35', '王思睿', '0', '1420128000', '210316201501028244', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '2', '1', 'wangsirui', 'wsr', '1599023982', '1599023982', '', '1');
INSERT INTO `cj_student` VALUES ('36', '于婕', '0', '1420128000', '210317201501028245', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '2', '1', 'yujie', 'yj', '1599023982', '1599023982', '', '1');
INSERT INTO `cj_student` VALUES ('37', '唐越', '0', '1420128000', '210318201501028246', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '2', '1', 'tangyue', 'ty', '1599023982', '1599023982', '', '1');
INSERT INTO `cj_student` VALUES ('38', '陈铭柳', '0', '1420128000', '210319201501028247', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '2', '1', 'chenmingliu', 'cml', '1599023982', '1599023982', '', '1');
INSERT INTO `cj_student` VALUES ('39', '狄沫亦', '0', '1420128000', '210320201501028248', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '3', '1', 'dimoyi', 'dmy', '1599023983', '1599023983', '', '1');
INSERT INTO `cj_student` VALUES ('40', '王昕蒙', '0', '1420128000', '210321201501028249', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '3', '1', 'wangxinmeng', 'wxm', '1599023983', '1599023983', '', '1');
INSERT INTO `cj_student` VALUES ('41', '孙艺霏', '1', '1420128000', '210322201501028250', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '3', '1', 'sunyifei', 'syf', '1599023983', '1599023983', '', '1');
INSERT INTO `cj_student` VALUES ('42', '张熙衡', '1', '1420128000', '210323201501028251', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '3', '1', 'zhangxiheng', 'zxh', '1599023983', '1599023983', '', '1');
INSERT INTO `cj_student` VALUES ('43', '姜帆', '1', '1420128000', '210324201501028252', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '3', '1', 'jiangfan', 'jf', '1599023983', '1599023983', '', '1');
INSERT INTO `cj_student` VALUES ('44', '温华', '1', '1420128000', '210325201501028253', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '3', '1', 'wenhua', 'wh', '1599023983', '1599023983', '', '1');
INSERT INTO `cj_student` VALUES ('45', '宁惠钰', '1', '1420128000', '210326201501028254', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '3', '1', 'ninghuiyu', 'nhy', '1599023983', '1599023983', '', '1');
INSERT INTO `cj_student` VALUES ('46', '葛夏', '1', '1420128000', '210327201501028255', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '3', '1', 'gexia', 'gx', '1599023983', '1599023983', '', '1');
INSERT INTO `cj_student` VALUES ('47', '曲馥铭', '1', '1420128000', '210328201501028256', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '3', '1', 'qufuming', 'qfm', '1599023983', '1599023983', '', '1');
INSERT INTO `cj_student` VALUES ('48', '赵博雅', '1', '1420128000', '210329201501028257', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '3', '1', 'zhaoboya', 'zby', '1599023983', '1599023983', '', '1');
INSERT INTO `cj_student` VALUES ('49', '赵诗凝', '1', '1420128000', '210330201501028258', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '3', '1', 'zhaoshining', 'zsn', '1599023983', '1599023983', '', '1');
INSERT INTO `cj_student` VALUES ('50', '高子琪', '1', '1420128000', '210331201501028259', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '3', '1', 'gaoziqi', 'gzq', '1599023983', '1599023983', '', '1');
INSERT INTO `cj_student` VALUES ('51', '梁华嵘', '0', '1420128000', '210332201501028260', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '3', '1', 'lianghuarong', 'lhr', '1599023983', '1599023983', '', '1');
INSERT INTO `cj_student` VALUES ('52', '唐珈琪', '0', '1420128000', '210333201501028261', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '3', '1', 'tangjiaqi', 'tjq', '1599023983', '1599023983', '', '1');
INSERT INTO `cj_student` VALUES ('53', '张湉', '0', '1420128000', '210334201501028262', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '3', '1', 'zhangtian', 'zt', '1599023983', '1599023983', '', '1');
INSERT INTO `cj_student` VALUES ('54', '沙高雅', '0', '1420128000', '210335201501028263', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '3', '1', 'shagaoya', 'sgy', '1599023983', '1599023983', '', '1');
INSERT INTO `cj_student` VALUES ('55', '刘明哲', '0', '1420128000', '210336201501028264', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '3', '1', 'liumingzhe', 'lmz', '1599023983', '1599023983', '', '1');
INSERT INTO `cj_student` VALUES ('56', '崔熙航', '0', '1420128000', '210337201501028265', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '3', '1', 'cuixihang', 'cxh', '1599023983', '1599023983', '', '1');
INSERT INTO `cj_student` VALUES ('57', '胡传鑫', '0', '1420128000', '210338201501028266', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '3', '1', 'huchuanxin', 'hcx', '1599023983', '1599023983', '', '1');
INSERT INTO `cj_student` VALUES ('58', '邹金硕', '0', '1420128000', '210339201501028267', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '3', '1', 'zoujinshuo', 'zjs', '1599023983', '1599023983', '', '1');
INSERT INTO `cj_student` VALUES ('59', '周德威', '0', '1420128000', '210340201501028268', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '3', '1', 'zhoudewei', 'zdw', '1599023983', '1599023983', '', '1');
INSERT INTO `cj_student` VALUES ('60', '葛入渲', '0', '1420128000', '210341201501028269', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '3', '1', 'geruxuan', 'grx', '1599023983', '1599023983', '', '1');
INSERT INTO `cj_student` VALUES ('61', '孙陪邀', '1', '1420128000', '210342201501028270', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '3', '1', 'sunpeiyao', 'spy', '1599023983', '1599023983', '', '1');
INSERT INTO `cj_student` VALUES ('62', '韩忠凯', '1', '1420128000', '210343201501028271', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '3', '1', 'hanzhongkai', 'hzk', '1599023983', '1599023983', '', '1');
INSERT INTO `cj_student` VALUES ('63', '高威', '1', '1420128000', '210344201501028272', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '3', '1', 'gaowei', 'gw', '1599023983', '1599023983', '', '1');
INSERT INTO `cj_student` VALUES ('64', '王明方', '1', '1420128000', '210345201501028273', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '3', '1', 'wangmingfang', 'wmf', '1599023983', '1599023983', '', '1');
INSERT INTO `cj_student` VALUES ('65', '王权', '1', '1420128000', '210346201501028274', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '3', '1', 'wangquan', 'wq', '1599023983', '1599023983', '', '1');
INSERT INTO `cj_student` VALUES ('66', '鲁昭斌', '1', '1420128000', '210347201501028275', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '3', '1', 'luzhaobin', 'lzb', '1599023983', '1599023983', '', '1');
INSERT INTO `cj_student` VALUES ('67', '吴广彬', '1', '1420128000', '210348201501028276', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '3', '1', 'wuguangbin', 'wgb', '1599023983', '1599023983', '', '1');
INSERT INTO `cj_student` VALUES ('68', '王荣航', '1', '1420128000', '210349201501028277', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '3', '1', 'wangronghang', 'wrh', '1599023983', '1599023983', '', '1');
INSERT INTO `cj_student` VALUES ('69', '徐梓霁', '1', '1420128000', '210350201501028278', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '3', '1', 'xuziji', 'xzj', '1599023983', '1599023983', '', '1');
INSERT INTO `cj_student` VALUES ('70', '潘日兵', '1', '1420128000', '210351201501028279', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '3', '1', 'panribing', 'prb', '1599023983', '1599023983', '', '1');
INSERT INTO `cj_student` VALUES ('71', '王顺顺', '0', '1420128000', '210352201501028280', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '3', '1', 'wangshunshun', 'wss', '1599023983', '1599023983', '', '1');
INSERT INTO `cj_student` VALUES ('72', '迟京泽', '0', '1420128000', '210353201501028281', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '3', '1', 'chijingze', 'cjz', '1599023983', '1599023983', '', '1');
INSERT INTO `cj_student` VALUES ('73', '王家昊', '0', '1420128000', '210354201501028282', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '6', '1', 'wangjiahao', 'wjh', '1599023984', '1599023984', '', '1');
INSERT INTO `cj_student` VALUES ('74', '贾祥旭', '0', '1420128000', '210355201501028283', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '6', '1', 'jiaxiangxu', 'jxx', '1599023984', '1599023984', '', '1');
INSERT INTO `cj_student` VALUES ('75', '谷博', '0', '1420128000', '210356201501028284', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '6', '1', 'gubo', 'gb', '1599023984', '1599023984', '', '1');
INSERT INTO `cj_student` VALUES ('76', '马依民', '0', '1420128000', '210357201501028285', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '6', '1', 'mayimin', 'mym', '1599023984', '1599023984', '', '1');
INSERT INTO `cj_student` VALUES ('77', '宋铭桐', '0', '1420128000', '210358201501028286', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '6', '1', 'songmingtong', 'smt', '1599023984', '1599023984', '', '1');
INSERT INTO `cj_student` VALUES ('78', '王民垚', '0', '1420128000', '210359201501028287', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '6', '1', 'wangminyao', 'wmy', '1599023984', '1599023984', '', '1');
INSERT INTO `cj_student` VALUES ('79', '闫佳林', '0', '1420128000', '210360201501028288', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '6', '1', 'yanjialin', 'yjl', '1599023984', '1599023984', '', '1');
INSERT INTO `cj_student` VALUES ('80', '厉东旭', '0', '1420128000', '210361201501028289', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '6', '1', 'lidongxu', 'ldx', '1599023984', '1599023984', '', '1');
INSERT INTO `cj_student` VALUES ('81', '杨文泽', '1', '1420128000', '210362201501028290', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '6', '1', 'yangwenze', 'ywz', '1599023984', '1599023984', '', '1');
INSERT INTO `cj_student` VALUES ('82', '王群', '1', '1420128000', '210363201501028291', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '6', '1', 'wangqun', 'wq', '1599023984', '1599023984', '', '1');
INSERT INTO `cj_student` VALUES ('83', '尚风锦', '1', '1420128000', '210364201501028292', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '6', '1', 'shangfengjin', 'sfj', '1599023984', '1599023984', '', '1');
INSERT INTO `cj_student` VALUES ('84', '王尔康', '1', '1420128000', '210365201501028293', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '6', '1', 'wangerkang', 'wek', '1599023984', '1599023984', '', '1');
INSERT INTO `cj_student` VALUES ('85', '张垣懿', '1', '1420128000', '210366201501028294', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '6', '1', 'zhangyuanyi', 'zyy', '1599023984', '1599023984', '', '1');
INSERT INTO `cj_student` VALUES ('86', '王鑫鹏', '1', '1420128000', '210367201501028295', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '6', '1', 'wangxinpeng', 'wxp', '1599023984', '1599023984', '', '1');
INSERT INTO `cj_student` VALUES ('87', '胡旭', '1', '1420128000', '210368201501028296', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '6', '1', 'huxu', 'hx', '1599023984', '1599023984', '', '1');
INSERT INTO `cj_student` VALUES ('88', '崔馨文', '1', '1420128000', '210369201501028297', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '6', '1', 'cuixinwen', 'cxw', '1599023984', '1599023984', '', '1');
INSERT INTO `cj_student` VALUES ('89', '赵艳琪', '1', '1420128000', '210370201501028298', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '6', '1', 'zhaoyanqi', 'zyq', '1599023984', '1599023984', '', '1');
INSERT INTO `cj_student` VALUES ('90', '厉忻怡', '1', '1420128000', '210371201501028299', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '6', '1', 'lixinyi', 'lxy', '1599023984', '1599023984', '', '1');
INSERT INTO `cj_student` VALUES ('91', '王薪茹', '0', '1420128000', '210372201501028300', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '6', '1', 'wangxinru', 'wxr', '1599023984', '1599023984', '', '1');
INSERT INTO `cj_student` VALUES ('92', '张家妮', '0', '1420128000', '210373201501028301', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '6', '1', 'zhangjiani', 'zjn', '1599023984', '1599023984', '', '1');
INSERT INTO `cj_student` VALUES ('93', '孙鑫慧', '0', '1420128000', '210374201501028302', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '6', '1', 'sunxinhui', 'sxh', '1599023984', '1599023984', '', '1');
INSERT INTO `cj_student` VALUES ('94', '厉湘瑜', '0', '1420128000', '210375201501028303', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '6', '1', 'lixiangyu', 'lxy', '1599023984', '1599023984', '', '1');
INSERT INTO `cj_student` VALUES ('95', '赫禹萱', '0', '1420128000', '210376201501028304', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '6', '1', 'heyuxuan', 'hyx', '1599023984', '1599023984', '', '1');
INSERT INTO `cj_student` VALUES ('96', '刘悦彤', '0', '1420128000', '210377201501028305', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '6', '1', 'liuyuetong', 'lyt', '1599023984', '1599023984', '', '1');
INSERT INTO `cj_student` VALUES ('97', '霍去病', '1', '1433088000', '232125201506013456', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '4', '1', 'huoqubing', 'hqb', '1599024231', '1599024231', '', '1');
INSERT INTO `cj_student` VALUES ('98', '姜赛楠', '1', '1433088000', '232125201506013457', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '4', '1', 'jiangsainan', 'jsn', '1599024231', '1599024231', '', '1');
INSERT INTO `cj_student` VALUES ('99', '卢子涵', '1', '1433088000', '232125201506013458', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '4', '1', 'luzihan', 'lzh', '1599024231', '1599024231', '', '1');
INSERT INTO `cj_student` VALUES ('100', '都姗', '1', '1433088000', '232125201506013459', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '4', '1', 'doushan', 'ds', '1599024231', '1599024231', '', '1');
INSERT INTO `cj_student` VALUES ('101', '韩晓文', '0', '1433088000', '232125201506013460', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '4', '1', 'hanxiaowen', 'hxw', '1599024231', '1599024231', '', '1');
INSERT INTO `cj_student` VALUES ('102', '汪羽茜', '0', '1433088000', '232125201506013461', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '4', '1', 'wangyuqian', 'wyq', '1599024231', '1599024231', '', '1');
INSERT INTO `cj_student` VALUES ('103', '赵鑫怡', '0', '1433088000', '232125201506013462', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '4', '1', 'zhaoxinyi', 'zxy', '1599024231', '1599024231', '', '1');
INSERT INTO `cj_student` VALUES ('104', '姜子琪', '0', '1433088000', '232125201506013463', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '4', '1', 'jiangziqi', 'jzq', '1599024231', '1599024231', '', '1');
INSERT INTO `cj_student` VALUES ('105', '徐昕岳', '0', '1433088000', '232125201506013464', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '4', '1', 'xuxinyue', 'xxy', '1599024231', '1599024231', '', '1');
INSERT INTO `cj_student` VALUES ('106', '付瑞阳', '0', '1433088000', '232125201506013465', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '4', '1', 'furuiyang', 'fry', '1599024231', '1599024231', '', '1');
INSERT INTO `cj_student` VALUES ('107', '李悦格', '0', '1433088000', '232125201506013466', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '4', '1', 'liyuege', 'lyg', '1599024231', '1599024231', '', '1');
INSERT INTO `cj_student` VALUES ('108', '刘卓奚', '0', '1433088000', '232125201506013467', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '4', '1', 'liuzhuoxi', 'lzx', '1599024231', '1599024231', '', '1');
INSERT INTO `cj_student` VALUES ('109', '高安业', '0', '1433088000', '232125201506013468', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '4', '1', 'gaoanye', 'gay', '1599024231', '1599024231', '', '1');
INSERT INTO `cj_student` VALUES ('110', '马佳豪', '0', '1433088000', '232125201506013469', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '4', '1', 'majiahao', 'mjh', '1599024231', '1599024231', '', '1');
INSERT INTO `cj_student` VALUES ('111', '邵玉粮', '1', '1433088000', '232125201506013470', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '4', '1', 'shaoyuliang', 'syl', '1599024231', '1599024231', '', '1');
INSERT INTO `cj_student` VALUES ('112', '李天奇', '1', '1433088000', '232125201506013471', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '4', '1', 'litianqi', 'ltq', '1599024231', '1599024231', '', '1');
INSERT INTO `cj_student` VALUES ('113', '初伟杰', '1', '1433088000', '232125201506013472', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '4', '1', 'chuweijie', 'cwj', '1599024231', '1599024231', '', '1');
INSERT INTO `cj_student` VALUES ('114', '唐国溦', '1', '1433088000', '232125201506013473', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '4', '1', 'tangguowei', 'tgw', '1599024231', '1599024231', '', '1');
INSERT INTO `cj_student` VALUES ('115', '赵浩天', '1', '1433088000', '232125201506013474', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '4', '1', 'zhaohaotian', 'zht', '1599024231', '1599024231', '', '1');
INSERT INTO `cj_student` VALUES ('116', '张建斌', '1', '1433088000', '232125201506013475', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '4', '1', 'zhangjianbin', 'zjb', '1599024231', '1599024231', '', '1');
INSERT INTO `cj_student` VALUES ('117', '李俊楠', '1', '1433088000', '232125201506013476', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '4', '1', 'lijunnan', 'ljn', '1599024231', '1599024231', '', '1');
INSERT INTO `cj_student` VALUES ('118', '贾旺芝', '1', '1433088000', '232125201506013477', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '4', '1', 'jiawangzhi', 'jwz', '1599024231', '1599024231', '', '1');
INSERT INTO `cj_student` VALUES ('119', '毕吉栋', '1', '1433088000', '232125201506013478', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '5', '1', 'bijidong', 'bjd', '1599024231', '1599024231', '', '1');
INSERT INTO `cj_student` VALUES ('120', '葛家豪', '1', '1433088000', '232125201506013479', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '5', '1', 'gejiahao', 'gjh', '1599024231', '1599024231', '', '1');
INSERT INTO `cj_student` VALUES ('121', '张树仁', '0', '1433088000', '232125201506013480', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '5', '1', 'zhangshuren', 'zsr', '1599024231', '1599024231', '', '1');
INSERT INTO `cj_student` VALUES ('122', '刘家瑞', '0', '1433088000', '232125201506013481', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '5', '1', 'liujiarui', 'ljr', '1599024231', '1599024231', '', '1');
INSERT INTO `cj_student` VALUES ('123', '董传宇', '0', '1433088000', '232125201506013482', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '5', '1', 'dongchuanyu', 'dcy', '1599024231', '1599024231', '', '1');
INSERT INTO `cj_student` VALUES ('124', '于曜瑄', '0', '1433088000', '232125201506013483', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '5', '1', 'yuyaoxuan', 'yyx', '1599024231', '1599024231', '', '1');
INSERT INTO `cj_student` VALUES ('125', '张慧祥', '0', '1433088000', '232125201506013484', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '5', '1', 'zhanghuixiang', 'zhx', '1599024231', '1599024231', '', '1');
INSERT INTO `cj_student` VALUES ('126', '唐天赐', '0', '1433088000', '232125201506013485', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '5', '1', 'tangtianci', 'ttc', '1599024231', '1599024231', '', '1');
INSERT INTO `cj_student` VALUES ('127', '邹福金', '0', '1433088000', '232125201506013486', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '5', '1', 'zoufujin', 'zfj', '1599024231', '1599024231', '', '1');
INSERT INTO `cj_student` VALUES ('128', '陈福成', '0', '1433088000', '232125201506013487', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '5', '1', 'chenfucheng', 'cfc', '1599024231', '1599024231', '', '1');
INSERT INTO `cj_student` VALUES ('129', '李昊', '0', '1433088000', '232125201506013488', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '5', '1', 'lihao', 'lh', '1599024231', '1599024231', '', '1');
INSERT INTO `cj_student` VALUES ('130', '曲子豫', '0', '1433088000', '232125201506013489', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '5', '1', 'quziyu', 'qzy', '1599024231', '1599024231', '', '1');
INSERT INTO `cj_student` VALUES ('131', '曲圣烁', '1', '1433088000', '232125201506013490', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '5', '1', 'qushengshuo', 'qss', '1599024231', '1599024231', '', '1');
INSERT INTO `cj_student` VALUES ('132', '周子铭', '1', '1433088000', '232125201506013491', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '5', '1', 'zhouziming', 'zzm', '1599024231', '1599024231', '', '1');
INSERT INTO `cj_student` VALUES ('133', '张其霖', '1', '1433088000', '232125201506013492', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '5', '1', 'zhangqilin', 'zql', '1599024231', '1599024231', '', '1');
INSERT INTO `cj_student` VALUES ('134', '马国哲', '1', '1433088000', '232125201506013493', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '5', '1', 'maguozhe', 'mgz', '1599024231', '1599024231', '', '1');
INSERT INTO `cj_student` VALUES ('135', '邹梦瑶', '1', '1433088000', '232125201506013510', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '7', '1', 'zoumengyao', 'zmy', '1599024232', '1599024232', '', '1');
INSERT INTO `cj_student` VALUES ('136', '王羽', '1', '1433088000', '232125201506013511', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '7', '1', 'wangyu', 'wy', '1599024232', '1599024232', '', '1');
INSERT INTO `cj_student` VALUES ('137', '都小焓', '1', '1433088000', '232125201506013512', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '7', '1', 'douxiaohan', 'dxh', '1599024232', '1599024232', '', '1');
INSERT INTO `cj_student` VALUES ('138', '曲禹彤', '1', '1433088000', '232125201506013513', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '7', '1', 'quyutong', 'qyt', '1599024232', '1599024232', '', '1');
INSERT INTO `cj_student` VALUES ('139', '杨桂夷', '1', '1433088000', '232125201506013514', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '7', '1', 'yangguiyi', 'ygy', '1599024232', '1599024232', '', '1');
INSERT INTO `cj_student` VALUES ('140', '王恩慧', '1', '1433088000', '232125201506013515', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '7', '1', 'wangenhui', 'weh', '1599024232', '1599024232', '', '1');
INSERT INTO `cj_student` VALUES ('141', '邹菲', '1', '1433088000', '232125201506013516', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '7', '1', 'zoufei', 'zf', '1599024232', '1599024232', '', '1');
INSERT INTO `cj_student` VALUES ('142', '刘晓彤', '1', '1433088000', '232125201506013517', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '7', '1', 'liuxiaotong', 'lxt', '1599024232', '1599024232', '', '1');
INSERT INTO `cj_student` VALUES ('143', '岳笑言', '1', '1433088000', '232125201506013518', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '7', '1', 'yuexiaoyan', 'yxy', '1599024232', '1599024232', '', '1');
INSERT INTO `cj_student` VALUES ('144', '牟明晔', '1', '1433088000', '232125201506013519', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '0', '127.0.0.1', '127.0.0.1', '0', '0', '7', '1', 'moumingye', 'mmy', '1599024232', '1599024232', '', '1');

-- -----------------------------
-- Table structure for `cj_subject`
-- -----------------------------
DROP TABLE IF EXISTS `cj_subject`;
CREATE TABLE `cj_subject` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(25) NOT NULL DEFAULT 'a' COMMENT '学科名称',
  `jiancheng` varchar(6) NOT NULL DEFAULT 'a' COMMENT '简称',
  `lieming` varchar(46) NOT NULL DEFAULT 'a' COMMENT '列名',
  `category_id` int(11) NOT NULL DEFAULT '0' COMMENT '大学科类别',
  `kaoshi` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否参与考试',
  `paixu` int(4) NOT NULL DEFAULT '999' COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0=禁用，1=正常',
  `beizhu` varchar(80) DEFAULT NULL COMMENT '备注',
  `create_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '更新时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `lieming` (`lieming`),
  UNIQUE KEY `title` (`title`),
  UNIQUE KEY `jiancheng` (`jiancheng`)
) ENGINE=InnoDB AUTO_INCREMENT=125 DEFAULT CHARSET=utf8;

-- -----------------------------
-- Records of `cj_subject`
-- -----------------------------
INSERT INTO `cj_subject` VALUES ('101', '语文', '语', 'yuwen', '11001', '1', '1', '1', '', '1539158918', '1539158918', '');
INSERT INTO `cj_subject` VALUES ('102', '数学', '数', 'shuxue', '11002', '1', '2', '1', '', '1539158918', '1539158918', '');
INSERT INTO `cj_subject` VALUES ('103', '外语', '外', 'waiyu', '11003', '1', '3', '1', '', '1539158918', '1539158918', '');
INSERT INTO `cj_subject` VALUES ('104', '体育与健康', '体', 'tiyu', '11007', '0', '4', '1', '', '1539158918', '1539158918', '');
INSERT INTO `cj_subject` VALUES ('105', '科学', '科', 'kexue', '11006', '0', '5', '1', '', '1539158918', '1539158918', '');
INSERT INTO `cj_subject` VALUES ('106', '生物', '生', 'shengwu', '11006', '0', '6', '1', '', '1539158918', '1539158918', '');
INSERT INTO `cj_subject` VALUES ('107', '物理', '理', 'wuli', '11006', '0', '7', '1', '', '1539158918', '1539158918', '');
INSERT INTO `cj_subject` VALUES ('108', '化学', '化', 'huaxue', '11006', '0', '8', '1', '', '1539158918', '1539158918', '');
INSERT INTO `cj_subject` VALUES ('109', '音乐', '音', 'yinyue', '11008', '0', '9', '1', '', '1539158918', '1539158918', '');
INSERT INTO `cj_subject` VALUES ('110', '美术', '美', 'meishu', '11008', '0', '10', '1', '', '1539158918', '1539158918', '');
INSERT INTO `cj_subject` VALUES ('111', '信息技术', '信息', 'xinxi', '11009', '0', '11', '1', '', '1539158918', '1539158918', '');
INSERT INTO `cj_subject` VALUES ('112', '研究性学习/社区服务、实践', '社区', 'shequ', '11009', '0', '12', '1', '', '1539158918', '1539158918', '');
INSERT INTO `cj_subject` VALUES ('113', '劳动与技术', '劳动', 'laodong', '11009', '0', '13', '1', '', '1539158918', '1539158918', '');
INSERT INTO `cj_subject` VALUES ('114', '品德与生活/社会', '品德', 'pinshe', '11004', '0', '14', '1', '', '1539158918', '1539158918', '');
INSERT INTO `cj_subject` VALUES ('115', '思想品德', '品社', 'sixiang', '11004', '0', '15', '1', '', '1539158918', '1539158918', '');
INSERT INTO `cj_subject` VALUES ('116', '历史', '史', 'lishi', '11005', '0', '16', '1', '', '1539158918', '1539158918', '');
INSERT INTO `cj_subject` VALUES ('117', '地理', '地理', 'dili', '11005', '0', '17', '1', '', '1539158918', '1539158918', '');
INSERT INTO `cj_subject` VALUES ('118', '地方课程', '地方', 'difang', '11010', '0', '18', '1', '', '1539158918', '1539158918', '');
INSERT INTO `cj_subject` VALUES ('119', '校本课程', '校本', 'xiaoben', '11010', '0', '19', '1', '', '1539158918', '1539158918', '');
INSERT INTO `cj_subject` VALUES ('120', '幼儿园全科', '幼儿园', 'youeryuan', '11011', '0', '20', '1', '', '1539158918', '1539158918', '');
INSERT INTO `cj_subject` VALUES ('121', '德育', '德', 'deyu', '11010', '0', '21', '1', '', '1539158918', '1539158918', '');
INSERT INTO `cj_subject` VALUES ('122', '心理健康', '心', 'xinli', '11010', '0', '22', '1', '', '1539158918', '1539158918', '');
INSERT INTO `cj_subject` VALUES ('123', '写字', '写', 'xiezi', '11010', '0', '23', '1', '', '1539158918', '1539158918', '');
INSERT INTO `cj_subject` VALUES ('124', '其他', '其他', 'qita', '11012', '0', '100', '1', '', '1539158918', '1539158918', '');

-- -----------------------------
-- Table structure for `cj_system_base`
-- -----------------------------
DROP TABLE IF EXISTS `cj_system_base`;
CREATE TABLE `cj_system_base` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `keywords` varchar(60) NOT NULL DEFAULT '尚码成绩管理,录入,统计,查询,管理' COMMENT '关键词',
  `description` varchar(100) NOT NULL DEFAULT '尚码成绩统计系统，包含成绩采集、成绩统计、成绩查询等功能。适合一线的成绩统计系统才是好系统。' COMMENT '网站说明',
  `thinks` varchar(80) NOT NULL DEFAULT 'ThinkPHP,X-admin,百度Echarts,jquery' COMMENT '网站感谢',
  `danwei` varchar(20) NOT NULL DEFAULT '大连长兴岛' COMMENT '使用单位',
  `gradelist` varchar(200) NOT NULL DEFAULT '一年级|二年级|三年级|四年级|五年级|六年级' COMMENT '年级名称列表',
  `classmax` int(2) NOT NULL DEFAULT '30' COMMENT '最大班级数',
  `xuenian` int(11) NOT NULL DEFAULT '523206000' COMMENT '划分学年节点',
  `xueqishang` int(11) NOT NULL DEFAULT '523206000' COMMENT '划分上学期节点',
  `xueqixia` int(11) NOT NULL DEFAULT '523206000' COMMENT '划分下学期节点',
  `classalias` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否开启班级另名',
  `teacherrongyu` tinyint(1) NOT NULL DEFAULT '0' COMMENT '教师查看个人荣誉',
  `teacherketi` tinyint(1) NOT NULL DEFAULT '0' COMMENT '教师查看个人课题',
  `create_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '更新时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- -----------------------------
-- Records of `cj_system_base`
-- -----------------------------
INSERT INTO `cj_system_base` VALUES ('1', '码蚁成绩,成绩统计,成绩管理,成绩分析,成绩查询', '前端采用X-admin，后端采用Thinkphp。寻找最方便的录入成绩方法，提供最丰富的统计项目。', 'ThinkPHP,X-admin,百度Echarts,jquwery', '大连长岛经济区', '一年级|二年级|三年级|四年级|五年级|六年级', '5', '523206000', '523206000', '523206000', '1', '0', '0', '1599022077', '1599022673', '');

-- -----------------------------
-- Table structure for `cj_teacher`
-- -----------------------------
DROP TABLE IF EXISTS `cj_teacher`;
CREATE TABLE `cj_teacher` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `xingming` varchar(8) NOT NULL DEFAULT 'a' COMMENT '姓名',
  `sex` tinyint(1) NOT NULL DEFAULT '1' COMMENT '性别',
  `shengri` int(11) DEFAULT NULL COMMENT '生日',
  `worktime` int(11) DEFAULT NULL COMMENT '工作时间',
  `zhiwu_id` int(11) DEFAULT NULL COMMENT '职务',
  `zhicheng_id` int(11) DEFAULT NULL COMMENT '职称',
  `danwei_id` int(11) NOT NULL DEFAULT '1' COMMENT '现工作单位',
  `biye` varchar(50) DEFAULT NULL COMMENT '毕业学校',
  `zhuanye` varchar(20) DEFAULT NULL COMMENT '专业',
  `xueli_id` int(11) DEFAULT NULL COMMENT '学历',
  `subject_id` int(11) DEFAULT NULL COMMENT '学科',
  `quanpin` varchar(30) NOT NULL DEFAULT 'a' COMMENT '全拼',
  `shoupin` varchar(5) NOT NULL DEFAULT 'a' COMMENT '简拼',
  `tuixiu` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已经退休',
  `phone` varchar(11) NOT NULL DEFAULT '0' COMMENT '手机号',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `password` varchar(137) NOT NULL DEFAULT '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1' COMMENT '登录密码',
  `denglucishu` int(5) NOT NULL DEFAULT '0' COMMENT '登录次数',
  `lastip` varchar(55) NOT NULL DEFAULT '127.0.0.1' COMMENT '最后一次登录IP',
  `ip` varchar(55) NOT NULL DEFAULT '127.0.0.1' COMMENT '登录IP',
  `lasttime` int(11) NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `thistime` int(11) NOT NULL DEFAULT '0' COMMENT '本次登录时间',
  `create_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '更新时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  `beizhu` varchar(80) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`),
  UNIQUE KEY `phone` (`phone`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- -----------------------------
-- Records of `cj_teacher`
-- -----------------------------
INSERT INTO `cj_teacher` VALUES ('1', '李永乐', '1', '432921600', '0', '10706', '10602', '3', '', '', '10501', '', 'liyongle', 'lyl', '0', '123456', '1', '$apr1$RSUodBwI$zOhVq9RQWfQDOW2sbeCDS1', '19', '119.178.52.189', '113.201.135.80', '1599573048', '1599619445', '1599022560', '1599619445', '', '');
INSERT INTO `cj_teacher` VALUES ('2', '巴掌', '1', '533491200', '1598976000', '10708', '10603', '2', '', '', '10506', '', 'bazhang', 'bz', '0', '13190180350', '1', '$apr1$lq9lQM1w$dBLmzbXflKKUtR.Da4MVe/', '7', '127.0.0.1', '127.0.0.1', '1600169561', '1600169563', '1599022850', '1600169563', '', '');

-- -----------------------------
-- Table structure for `cj_teacher_zhiwu`
-- -----------------------------
DROP TABLE IF EXISTS `cj_teacher_zhiwu`;
CREATE TABLE `cj_teacher_zhiwu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `teacherid` int(11) NOT NULL DEFAULT '0' COMMENT '教师ID',
  `zhiwu_id` int(11) DEFAULT NULL COMMENT '职务',
  `create_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '更新时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  `beizhu` varchar(80) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- -----------------------------
-- Table structure for `cj_tongji_bj`
-- -----------------------------
DROP TABLE IF EXISTS `cj_tongji_bj`;
CREATE TABLE `cj_tongji_bj` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kaoshi_id` int(11) NOT NULL DEFAULT '0' COMMENT '考试',
  `teacher_id` int(11) DEFAULT NULL COMMENT '任课教师',
  `banji_id` int(11) NOT NULL DEFAULT '0' COMMENT '班级',
  `subject_id` int(11) NOT NULL DEFAULT '0' COMMENT '学科',
  `stu_cnt` int(11) DEFAULT NULL COMMENT '参加考试人数',
  `chengji_cnt` int(11) DEFAULT NULL COMMENT '有成绩数',
  `sum` decimal(10,1) DEFAULT NULL COMMENT '总分',
  `avg` decimal(6,2) DEFAULT NULL COMMENT '平均分',
  `defenlv` decimal(6,2) DEFAULT NULL COMMENT '得分率',
  `biaozhuncha` decimal(6,2) DEFAULT NULL COMMENT '标准差',
  `youxiu` decimal(6,2) DEFAULT NULL COMMENT '优秀',
  `jige` decimal(6,2) DEFAULT NULL COMMENT '及格',
  `max` decimal(5,1) DEFAULT NULL COMMENT '最大',
  `min` decimal(5,1) DEFAULT NULL COMMENT '最小',
  `q1` decimal(6,2) DEFAULT NULL COMMENT '下25%',
  `q2` decimal(6,2) DEFAULT NULL COMMENT '中间%25',
  `q3` decimal(6,2) DEFAULT NULL COMMENT '上面25%',
  `zhongshu` varchar(100) DEFAULT NULL COMMENT '众数',
  `zhongweishu` decimal(10,0) DEFAULT NULL COMMENT '中位数',
  `create_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '更新时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0=禁用，1=正常',
  PRIMARY KEY (`id`),
  UNIQUE KEY `kaoshi_id` (`kaoshi_id`,`subject_id`,`banji_id`)
) ENGINE=InnoDB AUTO_INCREMENT=202 DEFAULT CHARSET=utf8;

-- -----------------------------
-- Records of `cj_tongji_bj`
-- -----------------------------
INSERT INTO `cj_tongji_bj` VALUES ('1', '1', '1', '6', '101', '24', '24', '1378.0', '57.42', '57.42', '27.26', '16.67', '45.83', '100.0', '1.0', '43.00', '56.50', '78.75', '', '100', '1599030232', '1599030232', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('2', '1', '1', '6', '102', '24', '24', '1365.0', '56.88', '56.88', '31.05', '20.83', '54.17', '98.0', '1.0', '34.50', '62.50', '79.75', '98', '98', '1599030232', '1599030232', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('3', '1', '1', '6', '103', '24', '24', '1371.0', '57.13', '57.13', '30.65', '16.67', '58.33', '100.0', '0.0', '40.25', '62.00', '72.00', '', '100', '1599030232', '1599030232', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('4', '1', '', '6', '0', '24', '24', '4114.0', '171.42', '57.14', '52.75', '', '8.33', '243.0', '31.0', '147.75', '189.50', '205.75', '', '243', '1599030232', '1599030232', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('5', '1', '1', '7', '101', '10', '10', '467.0', '46.70', '46.70', '30.04', '20.00', '30.00', '93.0', '3.0', '23.75', '44.50', '60.25', '', '93', '1599030232', '1599030232', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('6', '1', '', '7', '102', '10', '10', '512.0', '51.20', '51.20', '31.37', '10.00', '50.00', '92.0', '3.0', '29.00', '62.50', '70.50', '', '92', '1599030232', '1599030232', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('7', '1', '1', '7', '103', '10', '10', '377.0', '37.70', '37.70', '23.27', '0.00', '20.00', '79.0', '9.0', '16.25', '40.00', '51.00', '', '79', '1599030232', '1599030232', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('8', '1', '', '7', '0', '10', '10', '1356.0', '135.60', '45.20', '58.57', '', '0.00', '212.0', '43.0', '95.00', '144.00', '176.75', '', '212', '1599030232', '1599030232', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('9', '1', '', '1', '101', '22', '22', '942.0', '42.82', '42.82', '33.54', '9.09', '31.82', '98.0', '3.0', '14.25', '32.00', '74.00', '', '98', '1599030233', '1599030233', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('10', '1', '1', '1', '102', '22', '22', '1179.0', '53.59', '53.59', '32.83', '13.64', '54.55', '99.0', '2.0', '21.25', '62.00', '84.00', '', '99', '1599030233', '1599030233', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('11', '1', '1', '1', '103', '22', '22', '1002.0', '45.55', '45.55', '28.82', '4.55', '36.36', '95.0', '5.0', '14.00', '49.00', '70.25', '', '95', '1599030233', '1599030233', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('12', '1', '', '1', '0', '22', '22', '3123.0', '141.95', '47.32', '60.99', '', '9.09', '238.0', '38.0', '101.50', '147.50', '189.50', '', '238', '1599030233', '1599030233', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('13', '1', '', '2', '101', '16', '16', '802.0', '50.13', '50.13', '30.82', '6.25', '43.75', '93.0', '3.0', '27.50', '54.00', '75.00', '', '93', '1599030233', '1599030233', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('14', '1', '1', '2', '102', '16', '16', '601.0', '37.56', '37.56', '22.86', '0.00', '25.00', '73.0', '1.0', '23.25', '38.50', '54.25', '', '73', '1599030233', '1599030233', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('15', '1', '1', '2', '103', '16', '16', '821.0', '51.31', '51.31', '25.68', '0.00', '43.75', '88.0', '15.0', '31.50', '51.00', '74.50', '', '88', '1599030233', '1599030233', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('16', '1', '', '2', '0', '16', '16', '2224.0', '139.00', '46.33', '50.66', '', '6.25', '238.0', '40.0', '106.75', '130.00', '170.50', '', '238', '1599030233', '1599030233', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('17', '1', '1', '3', '101', '34', '34', '1658.0', '48.76', '48.76', '28.68', '8.82', '38.24', '100.0', '1.0', '25.50', '48.00', '70.75', '', '100', '1599030233', '1599030233', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('18', '1', '1', '3', '102', '34', '34', '1599.0', '47.03', '47.03', '26.59', '2.94', '32.35', '91.0', '6.0', '23.25', '44.50', '72.50', '', '91', '1599030233', '1599030233', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('19', '1', '', '3', '103', '34', '34', '1705.0', '50.15', '50.15', '29.55', '14.71', '29.41', '98.0', '0.0', '29.00', '43.50', '75.75', '', '98', '1599030233', '1599030233', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('20', '1', '', '3', '0', '34', '34', '4962.0', '145.94', '48.65', '42.95', '', '2.94', '241.0', '63.0', '111.00', '147.50', '179.50', '', '241', '1599030233', '1599030233', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('21', '1', '', '4', '101', '22', '22', '912.0', '41.45', '41.45', '30.31', '9.09', '36.36', '97.0', '2.0', '13.75', '31.00', '65.75', '', '97', '1599030233', '1599030233', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('22', '1', '1', '4', '102', '22', '22', '1124.0', '51.09', '51.09', '29.48', '9.09', '40.91', '99.0', '6.0', '28.00', '46.00', '77.75', '', '99', '1599030233', '1599030233', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('23', '1', '1', '4', '103', '22', '22', '929.0', '42.23', '42.23', '22.07', '0.00', '18.18', '83.0', '8.0', '24.50', '44.50', '56.50', '', '83', '1599030233', '1599030233', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('24', '1', '', '4', '0', '22', '22', '2965.0', '134.77', '44.92', '51.27', '', '4.55', '239.0', '29.0', '101.25', '137.50', '172.50', '', '239', '1599030233', '1599030233', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('25', '1', '1', '5', '101', '16', '16', '859.0', '53.69', '53.69', '29.33', '12.50', '43.75', '96.0', '10.0', '30.75', '51.50', '76.50', '', '96', '1599030233', '1599030233', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('26', '1', '1', '5', '102', '16', '16', '767.0', '47.94', '47.94', '24.62', '0.00', '37.50', '81.0', '7.0', '25.00', '52.50', '67.50', '', '81', '1599030233', '1599030233', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('27', '1', '', '5', '103', '16', '16', '739.0', '46.19', '46.19', '28.67', '6.25', '37.50', '96.0', '3.0', '25.25', '50.50', '71.50', '', '96', '1599030233', '1599030233', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('28', '1', '', '5', '0', '16', '16', '2365.0', '147.81', '49.27', '38.32', '', '6.25', '208.0', '68.0', '127.25', '147.00', '174.25', '', '208', '1599030233', '1599030233', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('29', '2', '1', '6', '101', '24', '24', '1506.0', '62.75', '62.75', '24.34', '16.67', '58.33', '97.0', '13.0', '50.50', '64.00', '80.25', '', '97', '1599030247', '1599030247', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('30', '2', '2', '6', '102', '24', '24', '1261.0', '52.54', '52.54', '28.93', '8.33', '50.00', '98.0', '3.0', '23.00', '58.00', '75.50', '', '98', '1599030247', '1599030247', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('31', '2', '', '6', '103', '24', '24', '1092.0', '45.50', '45.50', '29.57', '8.33', '25.00', '98.0', '0.0', '23.50', '48.50', '62.25', '59', '98', '1599030247', '1599030247', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('32', '2', '', '6', '0', '24', '24', '3859.0', '160.79', '53.60', '43.47', '', '8.33', '235.0', '88.0', '129.50', '158.50', '184.00', '', '235', '1599030247', '1599030247', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('33', '2', '', '7', '101', '10', '10', '415.0', '41.50', '41.50', '29.73', '10.00', '40.00', '92.0', '6.0', '17.25', '33.50', '67.25', '', '92', '1599030247', '1599030247', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('34', '2', '', '7', '102', '10', '10', '496.0', '49.60', '49.60', '33.20', '10.00', '40.00', '94.0', '1.0', '27.25', '48.50', '80.50', '', '94', '1599030247', '1599030247', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('35', '2', '', '7', '103', '10', '10', '423.0', '42.30', '42.30', '31.17', '10.00', '30.00', '90.0', '4.0', '17.50', '33.00', '61.75', '', '90', '1599030247', '1599030247', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('36', '2', '', '7', '0', '10', '10', '1334.0', '133.40', '44.47', '34.05', '', '0.00', '213.0', '98.0', '112.50', '122.50', '147.00', '', '213', '1599030247', '1599030247', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('37', '2', '', '1', '101', '22', '22', '898.0', '40.82', '40.82', '26.28', '9.09', '27.27', '99.0', '2.0', '24.50', '34.50', '59.00', '', '99', '1599030248', '1599030248', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('38', '2', '', '1', '102', '22', '22', '1025.0', '46.59', '46.59', '31.75', '9.09', '40.91', '100.0', '1.0', '26.50', '46.00', '74.50', '', '100', '1599030248', '1599030248', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('39', '2', '', '1', '103', '22', '22', '955.0', '43.41', '43.41', '26.70', '0.00', '27.27', '87.0', '0.0', '24.50', '41.50', '65.00', '', '87', '1599030248', '1599030248', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('40', '2', '', '1', '0', '22', '22', '2878.0', '130.82', '43.61', '52.19', '', '4.55', '229.0', '32.0', '88.75', '140.00', '164.25', '', '229', '1599030248', '1599030248', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('41', '2', '', '2', '101', '16', '16', '753.0', '47.06', '47.06', '31.07', '12.50', '31.25', '99.0', '1.0', '29.50', '42.00', '74.25', '', '99', '1599030248', '1599030248', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('42', '2', '', '2', '102', '16', '16', '756.0', '47.25', '47.25', '28.79', '12.50', '31.25', '100.0', '3.0', '30.25', '42.00', '66.75', '', '100', '1599030248', '1599030248', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('43', '2', '', '2', '103', '16', '16', '929.0', '58.06', '58.06', '28.85', '25.00', '50.00', '97.0', '14.0', '32.75', '61.50', '76.50', '', '97', '1599030248', '1599030248', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('44', '2', '', '2', '0', '16', '16', '2438.0', '152.38', '50.79', '54.33', '', '12.50', '268.0', '36.0', '123.75', '143.00', '182.00', '', '268', '1599030248', '1599030248', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('45', '2', '', '3', '101', '34', '34', '2029.0', '59.68', '59.68', '26.70', '17.65', '52.94', '98.0', '3.0', '38.75', '64.00', '81.00', '', '98', '1599030248', '1599030248', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('46', '2', '', '3', '102', '34', '34', '1712.0', '50.35', '50.35', '25.86', '5.88', '44.12', '95.0', '1.0', '28.25', '55.50', '70.25', '60', '95', '1599030248', '1599030248', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('47', '2', '', '3', '103', '34', '34', '1881.0', '55.32', '55.32', '30.71', '11.76', '44.12', '99.0', '0.0', '29.50', '57.50', '86.75', '', '99', '1599030248', '1599030248', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('48', '2', '', '3', '0', '34', '34', '5622.0', '165.35', '55.12', '50.52', '', '5.88', '267.0', '53.0', '137.75', '171.00', '194.25', '', '267', '1599030248', '1599030248', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('49', '2', '', '4', '101', '22', '22', '1025.0', '46.59', '46.59', '27.79', '4.55', '31.82', '100.0', '8.0', '19.00', '53.50', '63.00', '', '100', '1599030248', '1599030248', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('50', '2', '', '4', '102', '22', '22', '1063.0', '48.32', '48.32', '30.67', '9.09', '40.91', '97.0', '5.0', '23.50', '50.00', '73.25', '', '97', '1599030248', '1599030248', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('51', '2', '', '4', '103', '22', '22', '1036.0', '47.09', '47.09', '29.34', '9.09', '36.36', '95.0', '3.0', '21.75', '45.50', '69.75', '', '95', '1599030248', '1599030248', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('52', '2', '', '4', '0', '22', '22', '3124.0', '142.00', '47.33', '47.35', '', '4.55', '246.0', '53.0', '111.25', '139.50', '165.50', '', '246', '1599030248', '1599030248', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('53', '2', '', '5', '101', '16', '16', '607.0', '37.94', '37.94', '23.79', '0.00', '25.00', '81.0', '6.0', '18.00', '37.50', '55.75', '', '81', '1599030248', '1599030248', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('54', '2', '', '5', '102', '16', '16', '789.0', '49.31', '49.31', '27.98', '12.50', '31.25', '100.0', '1.0', '35.50', '49.00', '60.00', '', '100', '1599030248', '1599030248', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('55', '2', '', '5', '103', '16', '16', '664.0', '41.50', '41.50', '32.06', '12.50', '31.25', '100.0', '2.0', '14.50', '36.50', '66.25', '', '100', '1599030248', '1599030248', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('56', '2', '', '5', '0', '16', '16', '2060.0', '128.75', '42.92', '61.83', '', '6.25', '238.0', '29.0', '83.50', '126.50', '177.75', '', '238', '1599030248', '1599030248', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('57', '3', '', '6', '101', '24', '22', '1298.0', '59.00', '59.00', '29.28', '22.73', '54.55', '99.0', '9.0', '36.25', '67.50', '86.25', '', '99', '1599030261', '1599030261', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('58', '3', '', '6', '102', '24', '20', '936.0', '46.80', '46.80', '29.89', '15.00', '35.00', '96.0', '1.0', '23.75', '43.50', '68.25', '', '96', '1599030261', '1599030261', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('59', '3', '', '6', '103', '24', '17', '720.0', '42.35', '42.35', '19.81', '0.00', '17.65', '78.0', '6.0', '31.00', '44.00', '52.00', '31、51', '78', '1599030261', '1599030261', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('60', '3', '', '6', '0', '24', '22', '2954.0', '134.27', '44.76', '52.33', '', '0.00', '226.0', '43.0', '96.75', '133.50', '176.75', '', '226', '1599030261', '1599030261', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('61', '3', '', '7', '101', '10', '10', '468.0', '46.80', '46.80', '32.02', '0.00', '40.00', '87.0', '1.0', '18.50', '48.00', '75.50', '', '87', '1599030261', '1599030261', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('62', '3', '', '7', '102', '10', '10', '560.0', '56.00', '56.00', '32.71', '20.00', '60.00', '92.0', '0.0', '31.25', '70.00', '75.50', '', '92', '1599030261', '1599030261', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('63', '3', '', '7', '103', '10', '10', '384.0', '38.40', '38.40', '34.27', '10.00', '40.00', '97.0', '0.0', '11.25', '31.00', '66.25', '', '97', '1599030261', '1599030261', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('64', '3', '', '7', '0', '10', '10', '1412.0', '141.20', '47.07', '46.71', '', '10.00', '224.0', '92.0', '107.25', '131.50', '154.25', '', '224', '1599030261', '1599030261', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('65', '3', '', '1', '101', '22', '20', '883.0', '44.15', '44.15', '23.69', '5.00', '35.00', '93.0', '6.0', '30.50', '38.50', '63.00', '', '93', '1599030261', '1599030261', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('66', '3', '', '1', '102', '22', '19', '915.0', '48.16', '48.16', '27.82', '10.53', '36.84', '99.0', '8.0', '25.50', '46.00', '65.50', '', '99', '1599030261', '1599030261', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('67', '3', '', '1', '103', '22', '20', '932.0', '46.60', '46.60', '34.34', '15.00', '45.00', '99.0', '0.0', '14.00', '48.50', '74.00', '', '99', '1599030261', '1599030261', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('68', '3', '', '1', '0', '22', '22', '2730.0', '124.09', '41.36', '59.42', '', '9.09', '234.0', '13.0', '95.25', '118.50', '150.25', '', '234', '1599030261', '1599030261', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('69', '3', '', '2', '101', '16', '16', '744.0', '46.50', '46.50', '31.94', '6.25', '37.50', '99.0', '2.0', '22.00', '38.50', '74.00', '', '99', '1599030261', '1599030261', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('70', '3', '', '2', '102', '16', '16', '824.0', '51.50', '51.50', '36.59', '31.25', '37.50', '99.0', '3.0', '24.75', '38.50', '96.00', '', '99', '1599030261', '1599030261', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('71', '3', '', '2', '103', '16', '16', '694.0', '43.38', '43.38', '29.85', '0.00', '31.25', '87.0', '1.0', '13.75', '49.00', '72.25', '', '87', '1599030261', '1599030261', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('72', '3', '', '2', '0', '16', '16', '2262.0', '141.38', '47.13', '39.88', '', '0.00', '207.0', '68.0', '116.75', '137.50', '175.00', '', '207', '1599030261', '1599030261', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('73', '3', '', '3', '101', '34', '34', '1795.0', '52.79', '52.79', '27.26', '8.82', '35.29', '97.0', '4.0', '40.50', '53.00', '71.75', '', '97', '1599030261', '1599030261', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('74', '3', '', '3', '102', '34', '34', '1665.0', '48.97', '48.97', '28.59', '8.82', '44.12', '100.0', '3.0', '32.25', '50.00', '70.75', '', '100', '1599030261', '1599030261', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('75', '3', '', '3', '103', '34', '34', '1437.0', '42.26', '42.26', '29.55', '5.88', '29.41', '97.0', '1.0', '17.25', '37.00', '63.00', '', '97', '1599030261', '1599030261', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('76', '3', '', '3', '0', '34', '34', '4897.0', '144.03', '48.01', '48.28', '', '2.94', '232.0', '54.0', '106.50', '140.00', '189.00', '', '232', '1599030261', '1599030261', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('77', '3', '', '4', '101', '22', '22', '1193.0', '54.23', '54.23', '31.03', '13.64', '45.45', '100.0', '1.0', '34.00', '53.00', '80.25', '', '100', '1599030261', '1599030261', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('78', '3', '', '4', '102', '22', '22', '1138.0', '51.73', '51.73', '31.21', '9.09', '54.55', '100.0', '1.0', '21.50', '60.00', '72.00', '', '100', '1599030261', '1599030261', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('79', '3', '', '4', '103', '22', '22', '1092.0', '49.64', '49.64', '27.04', '9.09', '40.91', '98.0', '5.0', '29.50', '53.50', '63.25', '', '98', '1599030261', '1599030261', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('80', '3', '', '4', '0', '22', '22', '3423.0', '155.59', '51.86', '34.71', '', '9.09', '255.0', '92.0', '140.00', '154.50', '165.50', '', '255', '1599030261', '1599030261', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('81', '3', '', '5', '101', '16', '16', '753.0', '47.06', '47.06', '25.86', '6.25', '25.00', '95.0', '10.0', '24.50', '48.00', '59.75', '', '95', '1599030261', '1599030261', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('82', '3', '', '5', '102', '16', '16', '595.0', '37.19', '37.19', '26.52', '6.25', '25.00', '91.0', '3.0', '15.75', '31.00', '56.25', '', '91', '1599030261', '1599030261', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('83', '3', '', '5', '103', '16', '16', '736.0', '46.00', '46.00', '25.57', '0.00', '43.75', '83.0', '5.0', '24.50', '46.00', '64.50', '61', '83', '1599030261', '1599030261', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('84', '3', '', '5', '0', '16', '16', '2084.0', '130.25', '43.42', '42.14', '', '6.25', '230.0', '81.0', '100.25', '125.00', '140.25', '', '230', '1599030261', '1599030261', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('85', '4', '', '6', '101', '24', '24', '1122.0', '46.75', '46.75', '29.41', '12.50', '29.17', '98.0', '2.0', '25.50', '44.00', '63.00', '', '98', '1599030274', '1599030274', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('86', '4', '', '6', '102', '24', '24', '978.0', '40.75', '40.75', '27.98', '8.33', '20.83', '100.0', '0.0', '21.75', '35.00', '50.25', '', '100', '1599030274', '1599030274', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('87', '4', '', '6', '103', '24', '24', '1004.0', '41.83', '41.83', '27.27', '4.17', '33.33', '90.0', '1.0', '20.75', '34.50', '67.25', '', '90', '1599030274', '1599030274', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('88', '4', '', '6', '0', '24', '24', '3104.0', '129.33', '43.11', '51.60', '', '0.00', '229.0', '25.0', '99.50', '125.00', '164.00', '', '229', '1599030274', '1599030274', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('89', '4', '', '7', '101', '10', '10', '541.0', '54.10', '54.10', '33.99', '20.00', '50.00', '99.0', '1.0', '27.25', '59.50', '80.25', '', '99', '1599030274', '1599030274', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('90', '4', '', '7', '102', '10', '10', '591.0', '59.10', '59.10', '27.34', '20.00', '40.00', '98.0', '23.0', '37.00', '52.50', '84.50', '', '98', '1599030274', '1599030274', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('91', '4', '', '7', '103', '10', '10', '505.0', '50.50', '50.50', '36.57', '10.00', '50.00', '91.0', '2.0', '17.25', '53.00', '86.00', '', '91', '1599030274', '1599030274', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('92', '4', '', '7', '0', '10', '10', '1637.0', '163.70', '54.57', '35.91', '', '0.00', '222.0', '122.0', '132.50', '159.50', '185.50', '', '222', '1599030274', '1599030274', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('93', '4', '', '1', '101', '22', '22', '1205.0', '54.77', '54.77', '28.71', '9.09', '50.00', '100.0', '4.0', '28.50', '60.00', '76.75', '', '100', '1599030274', '1599030274', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('94', '4', '', '1', '102', '22', '22', '978.0', '44.45', '44.45', '27.02', '9.09', '31.82', '92.0', '4.0', '23.00', '37.00', '64.50', '', '92', '1599030274', '1599030274', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('95', '4', '', '1', '103', '22', '22', '935.0', '42.50', '42.50', '26.07', '4.55', '31.82', '95.0', '4.0', '23.00', '38.50', '62.75', '', '95', '1599030274', '1599030274', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('96', '4', '', '1', '0', '22', '22', '3118.0', '141.73', '47.24', '39.76', '', '0.00', '205.0', '60.0', '118.50', '149.50', '168.75', '', '205', '1599030274', '1599030274', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('97', '4', '', '2', '101', '16', '16', '763.0', '47.69', '47.69', '29.85', '0.00', '37.50', '89.0', '8.0', '21.75', '46.50', '76.75', '', '89', '1599030274', '1599030274', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('98', '4', '', '2', '102', '16', '16', '856.0', '53.50', '53.50', '34.50', '18.75', '43.75', '97.0', '2.0', '15.25', '55.00', '83.50', '', '97', '1599030274', '1599030274', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('99', '4', '', '2', '103', '16', '16', '682.0', '42.63', '42.63', '31.04', '6.25', '37.50', '96.0', '1.0', '13.00', '40.50', '66.75', '', '96', '1599030274', '1599030274', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('100', '4', '', '2', '0', '16', '16', '2301.0', '143.81', '47.94', '57.41', '', '6.25', '243.0', '34.0', '101.50', '150.50', '189.00', '', '243', '1599030274', '1599030274', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('101', '4', '', '3', '101', '34', '34', '1962.0', '57.71', '57.71', '28.60', '17.65', '47.06', '96.0', '3.0', '33.25', '58.00', '82.25', '', '96', '1599030274', '1599030274', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('102', '4', '', '3', '102', '34', '34', '1947.0', '57.26', '57.26', '29.75', '20.59', '50.00', '98.0', '6.0', '39.25', '59.00', '82.00', '', '98', '1599030274', '1599030274', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('103', '4', '', '3', '103', '34', '34', '1276.0', '37.53', '37.53', '28.36', '5.88', '23.53', '93.0', '1.0', '14.75', '27.00', '54.00', '8', '93', '1599030274', '1599030274', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('104', '4', '', '3', '0', '34', '34', '5185.0', '152.50', '50.83', '52.96', '', '8.82', '276.0', '42.0', '119.50', '152.50', '169.75', '', '276', '1599030274', '1599030274', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('105', '4', '', '4', '101', '22', '22', '1011.0', '45.95', '45.95', '30.49', '18.18', '27.27', '99.0', '0.0', '28.00', '38.00', '70.50', '', '99', '1599030274', '1599030274', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('106', '4', '', '4', '102', '22', '22', '1100.0', '50.00', '50.00', '28.15', '4.55', '40.91', '99.0', '0.0', '31.75', '52.50', '73.50', '', '99', '1599030274', '1599030274', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('107', '4', '', '4', '103', '22', '22', '1097.0', '49.86', '49.86', '33.58', '18.18', '50.00', '97.0', '0.0', '17.25', '53.50', '75.00', '', '97', '1599030274', '1599030274', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('108', '4', '', '4', '0', '22', '22', '3208.0', '145.82', '48.61', '49.08', '', '0.00', '227.0', '47.0', '116.50', '133.50', '181.75', '', '227', '1599030274', '1599030274', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('109', '4', '', '5', '101', '16', '16', '652.0', '40.75', '40.75', '27.32', '0.00', '31.25', '88.0', '5.0', '15.75', '35.50', '64.25', '', '88', '1599030274', '1599030274', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('110', '4', '', '5', '102', '16', '16', '659.0', '41.19', '41.19', '24.92', '0.00', '37.50', '84.0', '10.0', '18.75', '35.00', '61.00', '61', '84', '1599030274', '1599030274', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('111', '4', '', '5', '103', '16', '16', '779.0', '48.69', '48.69', '27.15', '6.25', '43.75', '96.0', '14.0', '28.75', '39.50', '67.50', '', '96', '1599030274', '1599030274', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('112', '4', '', '5', '0', '16', '16', '2090.0', '130.63', '43.54', '50.60', '', '12.50', '220.0', '36.0', '106.50', '128.50', '148.00', '', '220', '1599030274', '1599030274', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('113', '5', '2', '6', '101', '24', '24', '1473.0', '61.38', '61.38', '30.43', '25.00', '62.50', '98.0', '8.0', '40.25', '63.00', '87.00', '', '98', '1599030288', '1599031713', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('114', '5', '2', '6', '103', '24', '24', '1246.0', '51.92', '51.92', '23.00', '12.50', '33.33', '93.0', '7.0', '41.00', '48.50', '65.00', '46', '93', '1599030288', '1599031713', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('115', '5', '', '6', '0', '24', '24', '2719.0', '113.29', '56.65', '39.32', '', '29.17', '175.0', '35.0', '82.00', '118.00', '138.75', '', '175', '1599030288', '1599030288', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('116', '5', '1', '7', '101', '10', '10', '520.0', '52.00', '52.00', '36.37', '10.00', '60.00', '96.0', '1.0', '16.50', '61.50', '83.00', '', '96', '1599030288', '1599031927', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('117', '5', '1', '7', '103', '10', '10', '553.0', '55.30', '55.30', '29.86', '10.00', '50.00', '95.0', '5.0', '32.75', '62.50', '71.75', '', '95', '1599030288', '1599031927', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('118', '5', '', '7', '0', '10', '10', '1073.0', '107.30', '53.65', '48.80', '', '20.00', '182.0', '14.0', '81.00', '110.00', '142.75', '', '182', '1599030288', '1599030288', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('119', '5', '', '1', '101', '22', '22', '1142.0', '51.91', '51.91', '28.17', '18.18', '36.36', '100.0', '18.0', '25.75', '41.50', '76.25', '', '100', '1599030288', '1599030288', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('120', '5', '', '1', '103', '22', '22', '1112.0', '50.55', '50.55', '33.67', '13.64', '50.00', '100.0', '2.0', '21.75', '57.00', '78.25', '', '100', '1599030288', '1599030288', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('121', '5', '', '1', '0', '22', '22', '2254.0', '102.45', '51.23', '45.41', '', '22.73', '184.0', '37.0', '67.50', '93.00', '146.25', '', '184', '1599030288', '1599030288', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('122', '5', '', '2', '101', '16', '16', '776.0', '48.50', '48.50', '33.83', '12.50', '43.75', '98.0', '2.0', '16.25', '53.00', '77.25', '', '98', '1599030288', '1599030288', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('123', '5', '', '2', '103', '16', '16', '641.0', '40.06', '40.06', '24.41', '0.00', '12.50', '87.0', '5.0', '23.75', '41.50', '55.50', '', '87', '1599030288', '1599030288', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('124', '5', '', '2', '0', '16', '16', '1417.0', '88.56', '44.28', '40.42', '', '6.25', '157.0', '8.0', '61.75', '85.50', '107.00', '', '157', '1599030288', '1599030288', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('125', '5', '', '3', '101', '34', '34', '1696.0', '49.88', '49.88', '29.57', '17.65', '29.41', '100.0', '3.0', '30.25', '46.00', '75.00', '', '100', '1599030289', '1599030289', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('126', '5', '', '3', '103', '34', '34', '1980.0', '58.24', '58.24', '30.20', '20.59', '52.94', '94.0', '7.0', '29.25', '66.00', '87.00', '91', '94', '1599030289', '1599030289', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('127', '5', '', '3', '0', '34', '34', '3676.0', '108.12', '54.06', '40.48', '', '14.71', '187.0', '37.0', '69.25', '107.50', '136.00', '', '187', '1599030289', '1599030289', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('128', '5', '', '4', '101', '22', '22', '1019.0', '46.32', '46.32', '33.54', '9.09', '45.45', '99.0', '0.0', '14.75', '52.50', '69.25', '', '99', '1599030289', '1599030289', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('129', '5', '', '4', '103', '22', '22', '896.0', '40.73', '40.73', '30.80', '9.09', '31.82', '96.0', '4.0', '14.00', '33.00', '67.75', '', '96', '1599030289', '1599030289', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('130', '5', '', '4', '0', '22', '22', '1915.0', '87.05', '43.52', '33.70', '', '9.09', '159.0', '19.0', '62.50', '87.00', '112.50', '87', '159', '1599030289', '1599030289', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('131', '5', '', '5', '101', '16', '16', '786.0', '49.13', '49.13', '30.42', '12.50', '43.75', '92.0', '5.0', '25.25', '51.50', '72.25', '', '92', '1599030289', '1599030289', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('132', '5', '', '5', '103', '16', '16', '767.0', '47.94', '47.94', '23.79', '6.25', '31.25', '99.0', '13.0', '30.00', '46.00', '64.75', '', '99', '1599030289', '1599030289', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('133', '5', '', '5', '0', '16', '16', '1553.0', '97.06', '48.53', '37.89', '', '12.50', '171.0', '19.0', '70.75', '100.50', '122.00', '', '171', '1599030289', '1599030289', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('134', '6', '', '6', '101', '24', '24', '964.0', '40.17', '37.19', '12.08', '0.00', '0.00', '58.0', '20.0', '31.00', '38.00', '51.00', '', '58', '1599031949', '1599031949', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('135', '6', '', '6', '102', '24', '24', '1056.0', '44.00', '36.67', '13.40', '0.00', '0.00', '64.0', '23.0', '31.25', '48.00', '53.75', '53', '64', '1599031949', '1599031949', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('136', '6', '', '6', '103', '24', '24', '1233.0', '51.38', '39.52', '19.27', '0.00', '16.67', '86.0', '20.0', '38.75', '48.00', '64.50', '', '86', '1599031949', '1599031949', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('137', '6', '', '6', '0', '24', '24', '3253.0', '135.54', '37.86', '27.63', '', '0.00', '179.0', '75.0', '127.25', '137.00', '152.25', '', '179', '1599031949', '1599031949', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('138', '6', '', '7', '101', '10', '10', '496.0', '49.60', '45.93', '6.60', '0.00', '0.00', '60.0', '41.0', '45.50', '49.50', '53.00', '', '60', '1599031949', '1599031949', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('139', '6', '', '7', '102', '10', '10', '517.0', '51.70', '43.08', '7.80', '0.00', '0.00', '65.0', '43.0', '45.00', '50.50', '57.00', '', '65', '1599031949', '1599031949', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('140', '6', '', '7', '103', '10', '10', '653.0', '65.30', '50.23', '13.73', '0.00', '30.00', '86.0', '41.0', '59.00', '61.50', '76.75', '', '86', '1599031949', '1599031949', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('141', '6', '', '7', '0', '10', '10', '1666.0', '166.60', '46.54', '14.70', '', '0.00', '188.0', '135.0', '159.75', '167.50', '176.00', '', '188', '1599031949', '1599031949', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('142', '6', '', '1', '101', '22', '22', '1257.0', '57.14', '52.90', '32.57', '9.09', '54.55', '98.0', '3.0', '29.25', '67.00', '85.75', '', '98', '1599031949', '1599031949', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('143', '6', '', '1', '102', '22', '22', '1579.0', '71.77', '59.81', '32.39', '13.64', '45.45', '119.0', '5.0', '45.75', '67.00', '102.50', '', '119', '1599031949', '1599031949', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('144', '6', '', '1', '103', '22', '22', '1589.0', '72.23', '55.56', '35.80', '13.64', '36.36', '125.0', '2.0', '42.75', '76.00', '101.25', '', '125', '1599031949', '1599031949', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('145', '6', '', '1', '0', '22', '22', '4425.0', '201.14', '56.18', '44.74', '', '4.55', '305.0', '131.0', '167.25', '205.50', '223.25', '', '305', '1599031949', '1599031949', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('146', '6', '', '2', '101', '16', '16', '568.0', '35.50', '32.87', '28.54', '0.00', '18.75', '94.0', '0.0', '19.75', '26.50', '37.50', '', '94', '1599031949', '1599031949', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('147', '6', '', '2', '102', '16', '16', '740.0', '46.25', '38.54', '33.64', '6.25', '25.00', '115.0', '3.0', '21.25', '46.00', '66.75', '', '115', '1599031949', '1599031949', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('148', '6', '', '2', '103', '16', '16', '1299.0', '81.19', '62.45', '39.77', '12.50', '62.50', '126.0', '7.0', '50.00', '98.50', '112.25', '', '126', '1599031949', '1599031949', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('149', '6', '', '2', '0', '16', '16', '2607.0', '162.94', '45.51', '58.83', '', '6.25', '260.0', '65.0', '121.25', '162.50', '202.75', '', '260', '1599031949', '1599031949', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('150', '6', '', '3', '101', '34', '34', '1751.0', '51.50', '47.69', '31.34', '5.88', '44.12', '107.0', '5.0', '22.25', '51.50', '81.25', '', '107', '1599031949', '1599031949', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('151', '6', '', '3', '102', '34', '34', '2233.0', '65.68', '54.73', '38.31', '14.71', '50.00', '119.0', '0.0', '37.25', '71.00', '99.25', '', '119', '1599031949', '1599031949', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('152', '6', '', '3', '103', '34', '34', '1774.0', '52.18', '40.14', '36.22', '5.88', '17.65', '129.0', '3.0', '20.25', '49.00', '72.75', '', '129', '1599031949', '1599031949', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('153', '6', '', '3', '0', '34', '34', '5758.0', '169.35', '47.31', '51.74', '', '0.00', '253.0', '76.0', '124.25', '163.50', '215.75', '', '253', '1599031949', '1599031949', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('154', '6', '', '4', '101', '22', '22', '1290.0', '58.64', '54.29', '25.67', '13.64', '45.45', '101.0', '19.0', '39.00', '59.00', '75.50', '', '101', '1599031949', '1599031949', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('155', '6', '', '4', '102', '22', '22', '1780.0', '80.91', '67.42', '22.64', '18.18', '63.64', '120.0', '46.0', '61.50', '81.00', '100.25', '', '120', '1599031949', '1599031949', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('156', '6', '', '4', '103', '22', '22', '2043.0', '92.86', '71.43', '22.45', '18.18', '68.18', '126.0', '53.0', '74.25', '94.00', '109.75', '', '126', '1599031949', '1599031949', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('157', '6', '', '4', '0', '22', '22', '5113.0', '232.41', '64.92', '39.74', '', '18.18', '315.0', '171.0', '202.25', '221.50', '255.75', '201', '315', '1599031949', '1599031949', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('158', '6', '', '5', '101', '16', '16', '747.0', '46.69', '43.23', '28.58', '6.25', '25.00', '101.0', '10.0', '24.00', '43.00', '64.75', '24', '101', '1599031949', '1599031949', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('159', '6', '', '5', '102', '16', '16', '1283.0', '80.19', '66.82', '27.70', '25.00', '56.25', '114.0', '43.0', '51.00', '77.50', '105.75', '114', '114', '1599031949', '1599031949', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('160', '6', '', '5', '103', '16', '16', '1291.0', '80.69', '62.07', '25.06', '6.25', '50.00', '130.0', '52.0', '62.50', '75.50', '102.00', '', '130', '1599031949', '1599031949', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('161', '6', '', '5', '0', '16', '16', '3321.0', '207.56', '57.98', '49.70', '', '18.75', '295.0', '131.0', '178.50', '198.50', '255.75', '', '295', '1599031949', '1599031949', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('162', '7', '', '2', '101', '16', '16', '882.0', '55.13', '55.13', '28.35', '12.50', '50.00', '96.0', '12.0', '28.75', '53.00', '83.00', '', '96', '1599031965', '1599031965', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('163', '7', '', '2', '102', '16', '16', '878.0', '54.88', '54.88', '28.53', '12.50', '56.25', '97.0', '4.0', '34.75', '60.00', '71.75', '', '97', '1599031965', '1599031965', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('164', '7', '', '2', '103', '16', '16', '1078.0', '67.38', '67.38', '23.53', '18.75', '68.75', '95.0', '19.0', '51.75', '72.00', '87.25', '', '95', '1599031965', '1599031965', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('165', '7', '', '2', '0', '16', '16', '2838.0', '177.38', '59.13', '54.19', '', '25.00', '269.0', '74.0', '143.75', '159.50', '215.00', '', '269', '1599031965', '1599031965', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('166', '7', '', '3', '101', '34', '34', '1716.0', '50.47', '50.47', '24.76', '2.94', '38.24', '95.0', '0.0', '32.25', '48.00', '72.75', '', '95', '1599031965', '1599031965', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('167', '7', '', '3', '102', '34', '34', '1620.0', '47.65', '47.65', '29.99', '11.76', '35.29', '98.0', '0.0', '18.50', '49.00', '70.00', '17', '98', '1599031965', '1599031965', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('168', '7', '', '3', '103', '34', '34', '1925.0', '56.62', '56.62', '30.66', '17.65', '47.06', '100.0', '1.0', '33.00', '58.00', '83.50', '97', '100', '1599031965', '1599031965', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('169', '7', '', '3', '0', '34', '34', '5261.0', '154.74', '51.58', '50.08', '', '5.88', '238.0', '53.0', '120.25', '162.00', '196.75', '', '238', '1599031965', '1599031965', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('170', '7', '', '5', '101', '16', '16', '812.0', '50.75', '50.75', '29.94', '12.50', '50.00', '95.0', '9.0', '24.75', '50.00', '74.25', '', '95', '1599031966', '1599031966', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('171', '7', '', '5', '102', '16', '16', '721.0', '45.06', '45.06', '26.12', '12.50', '25.00', '94.0', '12.0', '28.00', '40.00', '55.25', '', '94', '1599031966', '1599031966', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('172', '7', '', '5', '103', '16', '16', '853.0', '53.31', '53.31', '31.92', '18.75', '37.50', '99.0', '3.0', '33.50', '53.00', '73.25', '', '99', '1599031966', '1599031966', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('173', '7', '', '5', '0', '16', '16', '2386.0', '149.13', '49.71', '44.00', '', '0.00', '236.0', '55.0', '125.00', '147.50', '177.00', '', '236', '1599031966', '1599031966', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('174', '9', '2', '6', '101', '24', '24', '1244.0', '51.83', '51.83', '32.12', '16.67', '45.83', '99.0', '2.0', '29.25', '53.00', '76.50', '', '99', '1599032471', '1599032492', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('175', '9', '2', '6', '102', '24', '24', '1022.0', '42.58', '42.58', '33.97', '8.33', '37.50', '97.0', '0.0', '14.00', '33.50', '76.75', '', '97', '1599032471', '1599032492', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('176', '9', '2', '6', '103', '24', '24', '1029.0', '42.88', '42.88', '31.58', '12.50', '33.33', '96.0', '0.0', '19.75', '34.00', '65.50', '', '96', '1599032471', '1599032492', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('177', '9', '', '6', '0', '24', '24', '3295.0', '137.29', '45.76', '61.18', '', '4.17', '247.0', '19.0', '105.00', '130.00', '185.75', '', '247', '1599032471', '1599032471', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('178', '9', '1', '7', '101', '10', '10', '514.0', '51.40', '51.40', '31.43', '10.00', '50.00', '90.0', '6.0', '26.50', '50.00', '81.75', '', '90', '1599032471', '1599032507', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('179', '9', '1', '7', '102', '10', '10', '542.0', '54.20', '54.20', '32.66', '20.00', '40.00', '100.0', '6.0', '31.75', '44.00', '83.75', '', '100', '1599032471', '1599032507', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('180', '9', '1', '7', '103', '10', '10', '473.0', '47.30', '47.30', '21.89', '0.00', '20.00', '85.0', '24.0', '34.25', '40.00', '52.75', '', '85', '1599032471', '1599032507', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('181', '9', '', '7', '0', '10', '10', '1529.0', '152.90', '50.97', '58.62', '', '10.00', '261.0', '82.0', '105.00', '142.50', '194.00', '', '261', '1599032471', '1599032471', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('182', '9', '', '1', '101', '22', '22', '1008.0', '45.82', '45.82', '28.18', '4.55', '36.36', '93.0', '0.0', '25.75', '46.00', '65.00', '', '93', '1599032471', '1599032471', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('183', '9', '', '1', '102', '22', '22', '1195.0', '54.32', '54.32', '28.48', '9.09', '54.55', '93.0', '0.0', '28.75', '61.00', '77.50', '', '93', '1599032471', '1599032471', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('184', '9', '', '1', '103', '22', '22', '880.0', '40.00', '40.00', '30.15', '9.09', '36.36', '98.0', '2.0', '14.75', '29.00', '67.25', '', '98', '1599032471', '1599032471', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('185', '9', '', '1', '0', '22', '22', '3083.0', '140.14', '46.71', '41.76', '', '0.00', '215.0', '58.0', '121.75', '142.00', '162.75', '', '215', '1599032471', '1599032471', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('186', '9', '', '2', '101', '16', '16', '862.0', '53.88', '53.88', '30.05', '12.50', '43.75', '97.0', '4.0', '30.00', '58.00', '80.25', '', '97', '1599032471', '1599032471', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('187', '9', '', '2', '102', '16', '16', '781.0', '48.81', '48.81', '27.95', '6.25', '37.50', '98.0', '6.0', '21.75', '53.00', '68.75', '', '98', '1599032471', '1599032471', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('188', '9', '', '2', '103', '16', '16', '855.0', '53.44', '53.44', '23.53', '12.50', '37.50', '96.0', '20.0', '35.75', '46.50', '71.25', '', '96', '1599032471', '1599032471', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('189', '9', '', '2', '0', '16', '16', '2498.0', '156.13', '52.04', '43.59', '', '6.25', '256.0', '75.0', '131.75', '156.00', '178.25', '', '256', '1599032471', '1599032471', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('190', '9', '', '3', '101', '34', '34', '1765.0', '51.91', '51.91', '26.53', '5.88', '44.12', '97.0', '1.0', '34.00', '54.50', '72.75', '', '97', '1599032471', '1599032471', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('191', '9', '', '3', '102', '34', '34', '1445.0', '42.50', '42.50', '28.43', '5.88', '29.41', '99.0', '6.0', '17.25', '35.00', '65.75', '14', '99', '1599032471', '1599032471', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('192', '9', '', '3', '103', '34', '34', '1674.0', '49.24', '49.24', '29.18', '5.88', '41.18', '95.0', '2.0', '24.25', '47.50', '80.50', '81', '95', '1599032471', '1599032471', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('193', '9', '', '3', '0', '34', '34', '4884.0', '143.65', '47.88', '43.25', '', '2.94', '253.0', '68.0', '118.00', '132.50', '173.75', '124', '253', '1599032471', '1599032471', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('194', '9', '', '4', '101', '22', '22', '1078.0', '49.00', '49.00', '26.33', '9.09', '36.36', '95.0', '2.0', '30.50', '45.50', '65.75', '', '95', '1599032471', '1599032471', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('195', '9', '', '4', '102', '22', '22', '883.0', '40.14', '40.14', '29.19', '9.09', '22.73', '98.0', '2.0', '19.75', '30.50', '56.50', '', '98', '1599032471', '1599032471', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('196', '9', '', '4', '103', '22', '22', '1029.0', '46.77', '46.77', '21.29', '0.00', '22.73', '79.0', '3.0', '31.00', '49.50', '58.00', '', '79', '1599032471', '1599032471', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('197', '9', '', '4', '0', '22', '22', '2990.0', '135.91', '45.30', '39.98', '', '0.00', '240.0', '56.0', '114.25', '130.50', '161.50', '', '240', '1599032471', '1599032471', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('198', '9', '', '5', '101', '16', '16', '763.0', '47.69', '47.69', '28.04', '6.25', '37.50', '96.0', '1.0', '28.50', '48.50', '71.00', '', '96', '1599032471', '1599032471', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('199', '9', '', '5', '102', '16', '16', '860.0', '53.75', '53.75', '34.51', '18.75', '43.75', '97.0', '0.0', '23.75', '57.00', '84.75', '', '97', '1599032471', '1599032471', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('200', '9', '', '5', '103', '16', '16', '700.0', '43.75', '43.75', '29.54', '6.25', '25.00', '97.0', '7.0', '20.75', '42.00', '62.75', '', '97', '1599032471', '1599032471', '', '1');
INSERT INTO `cj_tongji_bj` VALUES ('201', '9', '', '5', '0', '16', '16', '2323.0', '145.19', '48.40', '53.89', '', '6.25', '250.0', '75.0', '107.00', '131.00', '188.50', '', '250', '1599032471', '1599032471', '', '1');

-- -----------------------------
-- Table structure for `cj_tongji_log`
-- -----------------------------
DROP TABLE IF EXISTS `cj_tongji_log`;
CREATE TABLE `cj_tongji_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kaoshi_id` int(11) NOT NULL DEFAULT '0' COMMENT '考试ID',
  `category_id` int(11) NOT NULL DEFAULT '0' COMMENT '统计项目',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '统计人ID',
  `create_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '更新时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;

-- -----------------------------
-- Records of `cj_tongji_log`
-- -----------------------------
INSERT INTO `cj_tongji_log` VALUES ('1', '1', '12002', '4', '1599030229', '1599030229', '');
INSERT INTO `cj_tongji_log` VALUES ('2', '1', '12004', '4', '1599030230', '1599030230', '');
INSERT INTO `cj_tongji_log` VALUES ('3', '1', '12006', '4', '1599030232', '1599030232', '');
INSERT INTO `cj_tongji_log` VALUES ('4', '1', '12001', '4', '1599030233', '1599030233', '');
INSERT INTO `cj_tongji_log` VALUES ('5', '1', '12003', '4', '1599030234', '1599030234', '');
INSERT INTO `cj_tongji_log` VALUES ('6', '1', '12005', '4', '1599030235', '1599030235', '');
INSERT INTO `cj_tongji_log` VALUES ('7', '2', '12002', '4', '1599030244', '1599030244', '');
INSERT INTO `cj_tongji_log` VALUES ('8', '2', '12004', '4', '1599030245', '1599030245', '');
INSERT INTO `cj_tongji_log` VALUES ('9', '2', '12006', '4', '1599030246', '1599030246', '');
INSERT INTO `cj_tongji_log` VALUES ('10', '2', '12001', '4', '1599030248', '1599030248', '');
INSERT INTO `cj_tongji_log` VALUES ('11', '2', '12003', '4', '1599030250', '1599030250', '');
INSERT INTO `cj_tongji_log` VALUES ('12', '2', '12005', '4', '1599030251', '1599030251', '');
INSERT INTO `cj_tongji_log` VALUES ('13', '3', '12002', '4', '1599030257', '1599030257', '');
INSERT INTO `cj_tongji_log` VALUES ('14', '3', '12004', '4', '1599030259', '1599030259', '');
INSERT INTO `cj_tongji_log` VALUES ('15', '3', '12006', '4', '1599030260', '1599030260', '');
INSERT INTO `cj_tongji_log` VALUES ('16', '3', '12001', '4', '1599030261', '1599030261', '');
INSERT INTO `cj_tongji_log` VALUES ('17', '3', '12003', '4', '1599030262', '1599030262', '');
INSERT INTO `cj_tongji_log` VALUES ('18', '3', '12005', '4', '1599030264', '1599030264', '');
INSERT INTO `cj_tongji_log` VALUES ('19', '4', '12002', '4', '1599030271', '1599030271', '');
INSERT INTO `cj_tongji_log` VALUES ('20', '4', '12004', '4', '1599030272', '1599030272', '');
INSERT INTO `cj_tongji_log` VALUES ('21', '4', '12006', '4', '1599030273', '1599030273', '');
INSERT INTO `cj_tongji_log` VALUES ('22', '4', '12001', '4', '1599030274', '1599030274', '');
INSERT INTO `cj_tongji_log` VALUES ('23', '4', '12003', '4', '1599030276', '1599030276', '');
INSERT INTO `cj_tongji_log` VALUES ('24', '4', '12005', '4', '1599030277', '1599030277', '');
INSERT INTO `cj_tongji_log` VALUES ('25', '5', '12002', '4', '1599030285', '1599030285', '');
INSERT INTO `cj_tongji_log` VALUES ('26', '5', '12004', '4', '1599030286', '1599030286', '');
INSERT INTO `cj_tongji_log` VALUES ('27', '5', '12006', '4', '1599030287', '1599030287', '');
INSERT INTO `cj_tongji_log` VALUES ('28', '5', '12001', '4', '1599030289', '1599030289', '');
INSERT INTO `cj_tongji_log` VALUES ('29', '5', '12003', '4', '1599030290', '1599030290', '');
INSERT INTO `cj_tongji_log` VALUES ('30', '5', '12005', '4', '1599030291', '1599030291', '');
INSERT INTO `cj_tongji_log` VALUES ('31', '6', '12002', '4', '1599031946', '1599031946', '');
INSERT INTO `cj_tongji_log` VALUES ('32', '6', '12004', '4', '1599031947', '1599031947', '');
INSERT INTO `cj_tongji_log` VALUES ('33', '6', '12006', '4', '1599031948', '1599031948', '');
INSERT INTO `cj_tongji_log` VALUES ('34', '6', '12001', '4', '1599031949', '1599031949', '');
INSERT INTO `cj_tongji_log` VALUES ('35', '6', '12003', '4', '1599031950', '1599031950', '');
INSERT INTO `cj_tongji_log` VALUES ('36', '6', '12005', '4', '1599031951', '1599031951', '');
INSERT INTO `cj_tongji_log` VALUES ('37', '7', '12002', '4', '1599031962', '1599031962', '');
INSERT INTO `cj_tongji_log` VALUES ('38', '7', '12004', '4', '1599031963', '1599031963', '');
INSERT INTO `cj_tongji_log` VALUES ('39', '7', '12006', '4', '1599031964', '1599031964', '');
INSERT INTO `cj_tongji_log` VALUES ('40', '7', '12001', '4', '1599031966', '1599031966', '');
INSERT INTO `cj_tongji_log` VALUES ('41', '7', '12003', '4', '1599031966', '1599031966', '');
INSERT INTO `cj_tongji_log` VALUES ('42', '7', '12005', '4', '1599031967', '1599031967', '');
INSERT INTO `cj_tongji_log` VALUES ('43', '9', '12002', '3', '1599032467', '1599032467', '');
INSERT INTO `cj_tongji_log` VALUES ('44', '9', '12004', '3', '1599032468', '1599032468', '');
INSERT INTO `cj_tongji_log` VALUES ('45', '9', '12006', '3', '1599032470', '1599032470', '');
INSERT INTO `cj_tongji_log` VALUES ('46', '9', '12001', '3', '1599032471', '1599032471', '');
INSERT INTO `cj_tongji_log` VALUES ('47', '9', '12003', '3', '1599032473', '1599032473', '');
INSERT INTO `cj_tongji_log` VALUES ('48', '9', '12005', '3', '1599032474', '1599032474', '');

-- -----------------------------
-- Table structure for `cj_tongji_nj`
-- -----------------------------
DROP TABLE IF EXISTS `cj_tongji_nj`;
CREATE TABLE `cj_tongji_nj` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `school_id` int(11) NOT NULL DEFAULT '0' COMMENT '学校',
  `kaoshi_id` int(11) NOT NULL DEFAULT '0' COMMENT '考试',
  `ruxuenian` int(11) NOT NULL DEFAULT '0' COMMENT '入学年',
  `subject_id` int(11) NOT NULL DEFAULT '0' COMMENT '学科',
  `stu_cnt` int(11) DEFAULT NULL COMMENT '参加考试人数',
  `chengji_cnt` int(11) DEFAULT NULL COMMENT '有成绩数',
  `sum` decimal(10,1) DEFAULT NULL COMMENT '总分',
  `avg` decimal(6,2) DEFAULT NULL COMMENT '平均分',
  `defenlv` decimal(6,2) DEFAULT NULL COMMENT '得分率',
  `biaozhuncha` decimal(6,2) DEFAULT NULL COMMENT '标准差',
  `youxiu` decimal(6,2) DEFAULT NULL COMMENT '优秀',
  `jige` decimal(6,2) DEFAULT NULL COMMENT '及格',
  `max` decimal(5,1) DEFAULT NULL COMMENT '最大',
  `min` decimal(5,1) DEFAULT NULL COMMENT '最小',
  `q1` decimal(6,2) DEFAULT NULL COMMENT '下25%',
  `q2` decimal(6,2) DEFAULT NULL COMMENT '中间%25',
  `q3` decimal(6,2) DEFAULT NULL COMMENT '上面25%',
  `zhongshu` varchar(100) DEFAULT NULL COMMENT '众数',
  `zhongweishu` decimal(10,0) DEFAULT NULL COMMENT '中位数',
  `create_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '更新时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0=禁用，1=正常',
  PRIMARY KEY (`id`),
  UNIQUE KEY `kaoshi_id` (`kaoshi_id`,`ruxuenian`,`subject_id`,`school_id`)
) ENGINE=InnoDB AUTO_INCREMENT=117 DEFAULT CHARSET=utf8;

-- -----------------------------
-- Records of `cj_tongji_nj`
-- -----------------------------
INSERT INTO `cj_tongji_nj` VALUES ('1', '2', '1', '2019', '101', '24', '24', '1378.0', '57.42', '57.42', '27.26', '16.67', '45.83', '100.0', '1.0', '43.00', '56.50', '78.75', '', '', '1599030234', '1599030234', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('2', '2', '1', '2019', '102', '24', '24', '1365.0', '56.88', '56.88', '31.05', '20.83', '54.17', '98.0', '1.0', '34.50', '62.50', '79.75', '98', '', '1599030234', '1599030234', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('3', '2', '1', '2019', '103', '24', '24', '1371.0', '57.13', '57.13', '30.65', '16.67', '58.33', '100.0', '0.0', '40.25', '62.00', '72.00', '', '', '1599030234', '1599030234', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('4', '2', '1', '2019', '0', '24', '24', '4114.0', '171.42', '57.14', '52.75', '', '8.33', '243.0', '31.0', '147.75', '189.50', '205.75', '', '', '1599030234', '1599030234', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('5', '2', '1', '2020', '101', '72', '72', '3402.0', '47.25', '47.25', '30.41', '8.33', '37.50', '100.0', '1.0', '17.75', '48.00', '74.00', '14', '', '1599030234', '1599030234', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('6', '2', '1', '2020', '102', '72', '72', '3379.0', '46.93', '46.93', '28.13', '5.56', '37.50', '99.0', '1.0', '22.00', '44.50', '72.25', '14、85', '', '1599030234', '1599030234', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('7', '2', '1', '2020', '103', '72', '72', '3528.0', '49.00', '49.00', '28.22', '8.33', '34.72', '98.0', '0.0', '26.50', '48.00', '74.25', '', '', '1599030234', '1599030234', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('8', '2', '1', '2020', '0', '72', '72', '10309.0', '143.18', '47.73', '50.08', '', '5.56', '241.0', '38.0', '106.75', '145.50', '182.00', '', '', '1599030234', '1599030234', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('9', '3', '1', '2019', '101', '10', '10', '467.0', '46.70', '46.70', '30.04', '20.00', '30.00', '93.0', '3.0', '23.75', '44.50', '60.25', '', '', '1599030234', '1599030234', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('10', '3', '1', '2019', '102', '10', '10', '512.0', '51.20', '51.20', '31.37', '10.00', '50.00', '92.0', '3.0', '29.00', '62.50', '70.50', '', '', '1599030234', '1599030234', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('11', '3', '1', '2019', '103', '10', '10', '377.0', '37.70', '37.70', '23.27', '0.00', '20.00', '79.0', '9.0', '16.25', '40.00', '51.00', '', '', '1599030234', '1599030234', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('12', '3', '1', '2019', '0', '10', '10', '1356.0', '135.60', '45.20', '58.57', '', '0.00', '212.0', '43.0', '95.00', '144.00', '176.75', '', '', '1599030234', '1599030234', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('13', '3', '1', '2020', '101', '38', '38', '1771.0', '46.61', '46.61', '30.12', '10.53', '39.47', '97.0', '2.0', '23.25', '45.00', '70.00', '', '', '1599030234', '1599030234', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('14', '3', '1', '2020', '102', '38', '38', '1891.0', '49.76', '49.76', '27.23', '5.26', '39.47', '99.0', '6.0', '27.00', '48.00', '73.50', '18', '', '1599030234', '1599030234', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('15', '3', '1', '2020', '103', '38', '38', '1668.0', '43.89', '43.89', '24.77', '2.63', '26.32', '96.0', '3.0', '24.50', '47.50', '60.50', '', '', '1599030234', '1599030234', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('16', '3', '1', '2020', '0', '38', '38', '5330.0', '140.26', '46.75', '46.15', '', '5.26', '239.0', '29.0', '105.75', '142.00', '173.50', '', '', '1599030234', '1599030234', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('17', '2', '2', '2019', '101', '24', '24', '1506.0', '62.75', '62.75', '24.34', '16.67', '58.33', '97.0', '13.0', '50.50', '64.00', '80.25', '', '', '1599030249', '1599030249', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('18', '2', '2', '2019', '102', '24', '24', '1261.0', '52.54', '52.54', '28.93', '8.33', '50.00', '98.0', '3.0', '23.00', '58.00', '75.50', '', '', '1599030249', '1599030249', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('19', '2', '2', '2019', '103', '24', '24', '1092.0', '45.50', '45.50', '29.57', '8.33', '25.00', '98.0', '0.0', '23.50', '48.50', '62.25', '59', '', '1599030249', '1599030249', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('20', '2', '2', '2019', '0', '24', '24', '3859.0', '160.79', '53.60', '43.47', '', '8.33', '235.0', '88.0', '129.50', '158.50', '184.00', '', '', '1599030249', '1599030249', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('21', '2', '2', '2020', '101', '72', '72', '3680.0', '51.11', '51.11', '28.48', '13.89', '40.28', '99.0', '1.0', '32.25', '49.50', '74.25', '42', '', '1599030249', '1599030249', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('22', '2', '2', '2020', '102', '72', '72', '3493.0', '48.51', '48.51', '28.06', '8.33', '40.28', '100.0', '1.0', '26.00', '49.00', '72.00', '3、49、60', '', '1599030249', '1599030249', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('23', '2', '2', '2020', '103', '72', '72', '3765.0', '52.29', '52.29', '29.35', '11.11', '40.28', '99.0', '0.0', '26.75', '53.50', '78.50', '', '', '1599030249', '1599030249', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('24', '2', '2', '2020', '0', '72', '72', '10938.0', '151.92', '50.64', '53.29', '', '6.94', '268.0', '32.0', '123.75', '157.00', '183.75', '', '', '1599030249', '1599030249', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('25', '3', '2', '2019', '101', '10', '10', '415.0', '41.50', '41.50', '29.73', '10.00', '40.00', '92.0', '6.0', '17.25', '33.50', '67.25', '', '', '1599030249', '1599030249', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('26', '3', '2', '2019', '102', '10', '10', '496.0', '49.60', '49.60', '33.20', '10.00', '40.00', '94.0', '1.0', '27.25', '48.50', '80.50', '', '', '1599030249', '1599030249', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('27', '3', '2', '2019', '103', '10', '10', '423.0', '42.30', '42.30', '31.17', '10.00', '30.00', '90.0', '4.0', '17.50', '33.00', '61.75', '', '', '1599030249', '1599030249', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('28', '3', '2', '2019', '0', '10', '10', '1334.0', '133.40', '44.47', '34.05', '', '0.00', '213.0', '98.0', '112.50', '122.50', '147.00', '', '', '1599030249', '1599030249', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('29', '3', '2', '2020', '101', '38', '38', '1632.0', '42.95', '42.95', '26.20', '2.63', '28.95', '100.0', '6.0', '18.00', '47.50', '61.75', '9', '', '1599030250', '1599030250', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('30', '3', '2', '2020', '102', '38', '38', '1852.0', '48.74', '48.74', '29.18', '10.53', '36.84', '100.0', '1.0', '26.00', '49.50', '70.75', '', '', '1599030250', '1599030250', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('31', '3', '2', '2020', '103', '38', '38', '1700.0', '44.74', '44.74', '30.22', '10.53', '34.21', '100.0', '2.0', '18.25', '38.00', '69.75', '', '', '1599030250', '1599030250', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('32', '3', '2', '2020', '0', '38', '38', '5184.0', '136.42', '45.47', '53.54', '', '5.26', '246.0', '29.0', '102.25', '138.00', '176.25', '', '', '1599030250', '1599030250', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('33', '2', '3', '2019', '101', '24', '22', '1298.0', '59.00', '59.00', '29.28', '22.73', '54.55', '99.0', '9.0', '36.25', '67.50', '86.25', '', '', '1599030262', '1599030262', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('34', '2', '3', '2019', '102', '24', '20', '936.0', '46.80', '46.80', '29.89', '15.00', '35.00', '96.0', '1.0', '23.75', '43.50', '68.25', '', '', '1599030262', '1599030262', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('35', '2', '3', '2019', '103', '24', '17', '720.0', '42.35', '42.35', '19.81', '0.00', '17.65', '78.0', '6.0', '31.00', '44.00', '52.00', '31、51', '', '1599030262', '1599030262', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('36', '2', '3', '2019', '0', '24', '22', '2954.0', '134.27', '44.76', '52.33', '', '0.00', '226.0', '43.0', '96.75', '133.50', '176.75', '', '', '1599030262', '1599030262', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('37', '2', '3', '2020', '101', '72', '70', '3422.0', '48.89', '48.89', '27.33', '7.14', '35.71', '99.0', '2.0', '29.50', '50.00', '69.25', '4', '', '1599030262', '1599030262', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('38', '2', '3', '2020', '102', '72', '69', '3404.0', '49.33', '49.33', '29.97', '14.49', '40.58', '100.0', '3.0', '26.00', '46.00', '71.00', '13', '', '1599030262', '1599030262', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('39', '2', '3', '2020', '103', '72', '70', '3063.0', '43.76', '43.76', '30.65', '7.14', '34.29', '99.0', '0.0', '16.00', '45.00', '70.75', '1', '', '1599030262', '1599030262', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('40', '2', '3', '2020', '0', '72', '72', '9889.0', '137.35', '45.78', '50.43', '', '4.17', '234.0', '13.0', '105.75', '131.00', '177.00', '142', '', '1599030262', '1599030262', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('41', '3', '3', '2019', '101', '10', '10', '468.0', '46.80', '46.80', '32.02', '0.00', '40.00', '87.0', '1.0', '18.50', '48.00', '75.50', '', '', '1599030262', '1599030262', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('42', '3', '3', '2019', '102', '10', '10', '560.0', '56.00', '56.00', '32.71', '20.00', '60.00', '92.0', '0.0', '31.25', '70.00', '75.50', '', '', '1599030262', '1599030262', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('43', '3', '3', '2019', '103', '10', '10', '384.0', '38.40', '38.40', '34.27', '10.00', '40.00', '97.0', '0.0', '11.25', '31.00', '66.25', '', '', '1599030262', '1599030262', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('44', '3', '3', '2019', '0', '10', '10', '1412.0', '141.20', '47.07', '46.71', '', '10.00', '224.0', '92.0', '107.25', '131.50', '154.25', '', '', '1599030262', '1599030262', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('45', '3', '3', '2020', '101', '38', '38', '1946.0', '51.21', '51.21', '28.82', '10.53', '36.84', '100.0', '1.0', '31.75', '51.00', '77.00', '17', '', '1599030262', '1599030262', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('46', '3', '3', '2020', '102', '38', '38', '1733.0', '45.61', '45.61', '29.85', '7.89', '42.11', '100.0', '1.0', '18.00', '48.50', '69.00', '66', '', '1599030262', '1599030262', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('47', '3', '3', '2020', '103', '38', '38', '1828.0', '48.11', '48.11', '26.14', '5.26', '42.11', '98.0', '5.0', '26.75', '53.50', '63.25', '61', '', '1599030262', '1599030262', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('48', '3', '3', '2020', '0', '38', '38', '5507.0', '144.92', '48.31', '39.56', '', '7.89', '255.0', '81.0', '119.00', '141.50', '160.00', '', '', '1599030262', '1599030262', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('49', '2', '4', '2019', '101', '24', '24', '1122.0', '46.75', '46.75', '29.41', '12.50', '29.17', '98.0', '2.0', '25.50', '44.00', '63.00', '', '', '1599030275', '1599030275', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('50', '2', '4', '2019', '102', '24', '24', '978.0', '40.75', '40.75', '27.98', '8.33', '20.83', '100.0', '0.0', '21.75', '35.00', '50.25', '', '', '1599030275', '1599030275', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('51', '2', '4', '2019', '103', '24', '24', '1004.0', '41.83', '41.83', '27.27', '4.17', '33.33', '90.0', '1.0', '20.75', '34.50', '67.25', '', '', '1599030275', '1599030275', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('52', '2', '4', '2019', '0', '24', '24', '3104.0', '129.33', '43.11', '51.60', '', '0.00', '229.0', '25.0', '99.50', '125.00', '164.00', '', '', '1599030275', '1599030275', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('53', '2', '4', '2020', '101', '72', '72', '3930.0', '54.58', '54.58', '28.77', '11.11', '45.83', '100.0', '3.0', '29.50', '56.00', '79.25', '89', '', '1599030275', '1599030275', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('54', '2', '4', '2020', '102', '72', '72', '3781.0', '52.51', '52.51', '30.16', '16.67', '43.06', '98.0', '2.0', '28.75', '50.50', '81.25', '43、82、97', '', '1599030275', '1599030275', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('55', '2', '4', '2020', '103', '72', '72', '2893.0', '40.18', '40.18', '28.01', '5.56', '29.17', '96.0', '1.0', '16.25', '35.00', '63.00', '8、14', '', '1599030275', '1599030275', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('56', '2', '4', '2020', '0', '72', '72', '10604.0', '147.28', '49.09', '49.93', '', '5.56', '276.0', '34.0', '116.00', '151.00', '172.75', '72、151', '', '1599030275', '1599030275', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('57', '3', '4', '2019', '101', '10', '10', '541.0', '54.10', '54.10', '33.99', '20.00', '50.00', '99.0', '1.0', '27.25', '59.50', '80.25', '', '', '1599030276', '1599030276', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('58', '3', '4', '2019', '102', '10', '10', '591.0', '59.10', '59.10', '27.34', '20.00', '40.00', '98.0', '23.0', '37.00', '52.50', '84.50', '', '', '1599030276', '1599030276', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('59', '3', '4', '2019', '103', '10', '10', '505.0', '50.50', '50.50', '36.57', '10.00', '50.00', '91.0', '2.0', '17.25', '53.00', '86.00', '', '', '1599030276', '1599030276', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('60', '3', '4', '2019', '0', '10', '10', '1637.0', '163.70', '54.57', '35.91', '', '0.00', '222.0', '122.0', '132.50', '159.50', '185.50', '', '', '1599030276', '1599030276', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('61', '3', '4', '2020', '101', '38', '38', '1663.0', '43.76', '43.76', '28.93', '10.53', '28.95', '99.0', '0.0', '24.00', '38.00', '66.75', '31', '', '1599030276', '1599030276', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('62', '3', '4', '2020', '102', '38', '38', '1759.0', '46.29', '46.29', '26.85', '2.63', '39.47', '99.0', '0.0', '23.75', '47.50', '67.50', '61', '', '1599030276', '1599030276', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('63', '3', '4', '2020', '103', '38', '38', '1876.0', '49.37', '49.37', '30.65', '13.16', '47.37', '97.0', '0.0', '19.00', '46.00', '74.50', '18', '', '1599030276', '1599030276', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('64', '3', '4', '2020', '0', '38', '38', '5298.0', '139.42', '46.47', '49.63', '', '5.26', '227.0', '36.0', '110.75', '130.00', '178.00', '129', '', '1599030276', '1599030276', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('65', '2', '5', '2019', '101', '24', '24', '1473.0', '61.38', '61.38', '30.43', '25.00', '62.50', '98.0', '8.0', '40.25', '63.00', '87.00', '', '', '1599030289', '1599030289', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('66', '2', '5', '2019', '103', '24', '24', '1246.0', '51.92', '51.92', '23.00', '12.50', '33.33', '93.0', '7.0', '41.00', '48.50', '65.00', '46', '', '1599030289', '1599030289', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('67', '2', '5', '2019', '0', '24', '24', '2719.0', '113.29', '56.65', '39.32', '', '29.17', '175.0', '35.0', '82.00', '118.00', '138.75', '', '', '1599030289', '1599030289', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('68', '2', '5', '2020', '101', '72', '72', '3614.0', '50.19', '50.19', '29.74', '16.67', '34.72', '100.0', '2.0', '23.00', '46.00', '77.25', '37、56、94', '', '1599030290', '1599030290', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('69', '2', '5', '2020', '103', '72', '72', '3733.0', '51.85', '51.85', '30.60', '13.89', '43.06', '100.0', '2.0', '24.75', '52.50', '80.00', '87、91、94', '', '1599030290', '1599030290', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('70', '2', '5', '2020', '0', '72', '72', '7347.0', '102.04', '51.02', '42.13', '', '15.28', '187.0', '8.0', '66.00', '97.00', '136.00', '58、66、165', '', '1599030290', '1599030290', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('71', '3', '5', '2019', '101', '10', '10', '520.0', '52.00', '52.00', '36.37', '10.00', '60.00', '96.0', '1.0', '16.50', '61.50', '83.00', '', '', '1599030290', '1599030290', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('72', '3', '5', '2019', '103', '10', '10', '553.0', '55.30', '55.30', '29.86', '10.00', '50.00', '95.0', '5.0', '32.75', '62.50', '71.75', '', '', '1599030290', '1599030290', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('73', '3', '5', '2019', '0', '10', '10', '1073.0', '107.30', '53.65', '48.80', '', '20.00', '182.0', '14.0', '81.00', '110.00', '142.75', '', '', '1599030290', '1599030290', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('74', '3', '5', '2020', '101', '38', '38', '1805.0', '47.50', '47.50', '31.87', '10.53', '44.74', '99.0', '0.0', '20.00', '51.50', '72.00', '61', '', '1599030290', '1599030290', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('75', '3', '5', '2020', '103', '38', '38', '1663.0', '43.76', '43.76', '27.95', '7.89', '31.58', '99.0', '4.0', '18.00', '41.50', '66.25', '46', '', '1599030290', '1599030290', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('76', '3', '5', '2020', '0', '38', '38', '3468.0', '91.26', '45.63', '35.38', '', '10.53', '171.0', '19.0', '64.75', '95.00', '115.50', '87、116', '', '1599030290', '1599030290', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('77', '2', '6', '2019', '101', '24', '24', '964.0', '40.17', '37.19', '12.08', '0.00', '0.00', '58.0', '20.0', '31.00', '38.00', '51.00', '', '', '1599031950', '1599031950', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('78', '2', '6', '2019', '102', '24', '24', '1056.0', '44.00', '36.67', '13.40', '0.00', '0.00', '64.0', '23.0', '31.25', '48.00', '53.75', '53', '', '1599031950', '1599031950', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('79', '2', '6', '2019', '103', '24', '24', '1233.0', '51.38', '39.52', '19.27', '0.00', '16.67', '86.0', '20.0', '38.75', '48.00', '64.50', '', '', '1599031950', '1599031950', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('80', '2', '6', '2019', '0', '24', '24', '3253.0', '135.54', '37.86', '27.63', '', '0.00', '179.0', '75.0', '127.25', '137.00', '152.25', '', '', '1599031950', '1599031950', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('81', '2', '6', '2020', '101', '72', '72', '3576.0', '49.67', '45.99', '31.73', '5.56', '41.67', '107.0', '0.0', '22.75', '44.00', '80.25', '28', '', '1599031950', '1599031950', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('82', '2', '6', '2020', '102', '72', '72', '4552.0', '63.22', '52.69', '36.36', '12.50', '43.06', '119.0', '0.0', '37.75', '64.00', '97.00', '43', '', '1599031950', '1599031950', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('83', '2', '6', '2020', '103', '72', '72', '4662.0', '64.75', '49.81', '38.43', '9.72', '33.33', '129.0', '2.0', '30.25', '64.00', '101.25', '76、77', '', '1599031950', '1599031950', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('84', '2', '6', '2020', '0', '72', '72', '12790.0', '177.64', '49.62', '53.11', '', '2.78', '305.0', '65.0', '131.75', '168.00', '221.50', '97、158、168', '', '1599031950', '1599031950', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('85', '3', '6', '2019', '101', '10', '10', '496.0', '49.60', '45.93', '6.60', '0.00', '0.00', '60.0', '41.0', '45.50', '49.50', '53.00', '', '', '1599031950', '1599031950', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('86', '3', '6', '2019', '102', '10', '10', '517.0', '51.70', '43.08', '7.80', '0.00', '0.00', '65.0', '43.0', '45.00', '50.50', '57.00', '', '', '1599031950', '1599031950', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('87', '3', '6', '2019', '103', '10', '10', '653.0', '65.30', '50.23', '13.73', '0.00', '30.00', '86.0', '41.0', '59.00', '61.50', '76.75', '', '', '1599031950', '1599031950', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('88', '3', '6', '2019', '0', '10', '10', '1666.0', '166.60', '46.54', '14.70', '', '0.00', '188.0', '135.0', '159.75', '167.50', '176.00', '', '', '1599031950', '1599031950', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('89', '3', '6', '2020', '101', '38', '38', '2037.0', '53.61', '49.63', '27.22', '10.53', '36.84', '101.0', '10.0', '29.00', '55.50', '72.75', '24、39', '', '1599031950', '1599031950', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('90', '3', '6', '2020', '102', '38', '38', '3063.0', '80.61', '67.17', '24.54', '21.05', '60.53', '120.0', '43.0', '60.25', '80.50', '103.75', '114', '', '1599031950', '1599031950', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('91', '3', '6', '2020', '103', '38', '38', '3334.0', '87.74', '67.49', '24.04', '13.16', '60.53', '130.0', '52.0', '67.75', '83.00', '109.75', '73', '', '1599031950', '1599031950', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('92', '3', '6', '2020', '0', '38', '38', '8434.0', '221.95', '62.00', '45.30', '', '18.42', '315.0', '131.0', '195.25', '212.00', '255.75', '201', '', '1599031950', '1599031950', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('93', '2', '7', '2020', '101', '50', '50', '2598.0', '51.96', '51.96', '25.76', '6.00', '42.00', '96.0', '0.0', '29.75', '48.00', '75.25', '', '', '1599031966', '1599031966', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('94', '2', '7', '2020', '102', '50', '50', '2498.0', '49.96', '49.96', '29.44', '12.00', '42.00', '98.0', '0.0', '24.00', '52.50', '70.25', '17', '', '1599031966', '1599031966', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('95', '2', '7', '2020', '103', '50', '50', '3003.0', '60.06', '60.06', '28.78', '18.00', '54.00', '100.0', '1.0', '38.25', '63.00', '84.75', '97', '', '1599031966', '1599031966', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('96', '2', '7', '2020', '0', '50', '50', '8099.0', '161.98', '53.99', '51.98', '', '12.00', '269.0', '53.0', '133.00', '159.50', '202.75', '', '', '1599031966', '1599031966', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('97', '3', '7', '2020', '101', '16', '16', '812.0', '50.75', '50.75', '29.94', '12.50', '50.00', '95.0', '9.0', '24.75', '50.00', '74.25', '', '', '1599031966', '1599031966', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('98', '3', '7', '2020', '102', '16', '16', '721.0', '45.06', '45.06', '26.12', '12.50', '25.00', '94.0', '12.0', '28.00', '40.00', '55.25', '', '', '1599031966', '1599031966', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('99', '3', '7', '2020', '103', '16', '16', '853.0', '53.31', '53.31', '31.92', '18.75', '37.50', '99.0', '3.0', '33.50', '53.00', '73.25', '', '', '1599031966', '1599031966', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('100', '3', '7', '2020', '0', '16', '16', '2386.0', '149.13', '49.71', '44.00', '', '0.00', '236.0', '55.0', '125.00', '147.50', '177.00', '', '', '1599031966', '1599031966', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('101', '2', '9', '2019', '101', '24', '24', '1244.0', '51.83', '51.83', '32.12', '16.67', '45.83', '99.0', '2.0', '29.25', '53.00', '76.50', '', '', '1599032472', '1599032472', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('102', '2', '9', '2019', '102', '24', '24', '1022.0', '42.58', '42.58', '33.97', '8.33', '37.50', '97.0', '0.0', '14.00', '33.50', '76.75', '', '', '1599032472', '1599032472', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('103', '2', '9', '2019', '103', '24', '24', '1029.0', '42.88', '42.88', '31.58', '12.50', '33.33', '96.0', '0.0', '19.75', '34.00', '65.50', '', '', '1599032472', '1599032472', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('104', '2', '9', '2019', '0', '24', '24', '3295.0', '137.29', '45.76', '61.18', '', '4.17', '247.0', '19.0', '105.00', '130.00', '185.75', '', '', '1599032472', '1599032472', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('105', '2', '9', '2020', '101', '72', '72', '3635.0', '50.49', '50.49', '27.62', '6.94', '41.67', '97.0', '0.0', '30.00', '54.50', '72.25', '30、39、41、78、97', '', '1599032472', '1599032472', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('106', '2', '9', '2020', '102', '72', '72', '3421.0', '47.51', '47.51', '28.42', '6.94', '38.89', '99.0', '0.0', '20.25', '51.00', '70.00', '14、18、31、62', '', '1599032472', '1599032472', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('107', '2', '9', '2020', '103', '72', '72', '3409.0', '47.35', '47.35', '28.43', '8.33', '38.89', '98.0', '2.0', '23.50', '43.00', '72.00', '81', '', '1599032472', '1599032472', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('108', '2', '9', '2020', '0', '72', '72', '10465.0', '145.35', '48.45', '42.69', '', '2.78', '256.0', '58.0', '122.50', '145.00', '174.50', '156', '', '1599032472', '1599032472', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('109', '3', '9', '2019', '101', '10', '10', '514.0', '51.40', '51.40', '31.43', '10.00', '50.00', '90.0', '6.0', '26.50', '50.00', '81.75', '', '', '1599032473', '1599032473', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('110', '3', '9', '2019', '102', '10', '10', '542.0', '54.20', '54.20', '32.66', '20.00', '40.00', '100.0', '6.0', '31.75', '44.00', '83.75', '', '', '1599032473', '1599032473', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('111', '3', '9', '2019', '103', '10', '10', '473.0', '47.30', '47.30', '21.89', '0.00', '20.00', '85.0', '24.0', '34.25', '40.00', '52.75', '', '', '1599032473', '1599032473', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('112', '3', '9', '2019', '0', '10', '10', '1529.0', '152.90', '50.97', '58.62', '', '10.00', '261.0', '82.0', '105.00', '142.50', '194.00', '', '', '1599032473', '1599032473', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('113', '3', '9', '2020', '101', '38', '38', '1841.0', '48.45', '48.45', '26.70', '7.89', '36.84', '96.0', '1.0', '28.50', '45.50', '69.00', '74', '', '1599032473', '1599032473', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('114', '3', '9', '2020', '102', '38', '38', '1743.0', '45.87', '45.87', '31.83', '13.16', '31.58', '98.0', '0.0', '20.50', '36.50', '78.75', '15', '', '1599032473', '1599032473', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('115', '3', '9', '2020', '103', '38', '38', '1729.0', '45.50', '45.50', '24.77', '2.63', '23.68', '97.0', '3.0', '27.25', '46.00', '58.00', '58', '', '1599032473', '1599032473', '', '1');
INSERT INTO `cj_tongji_nj` VALUES ('116', '3', '9', '2020', '0', '38', '38', '5313.0', '139.82', '46.61', '45.89', '', '2.63', '250.0', '56.0', '109.75', '130.50', '166.00', '', '', '1599032473', '1599032473', '', '1');

-- -----------------------------
-- Table structure for `cj_tongji_sch`
-- -----------------------------
DROP TABLE IF EXISTS `cj_tongji_sch`;
CREATE TABLE `cj_tongji_sch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kaoshi_id` int(11) NOT NULL DEFAULT '0' COMMENT '考试',
  `ruxuenian` int(11) NOT NULL DEFAULT '0' COMMENT '入学年',
  `subject_id` int(11) NOT NULL DEFAULT '0' COMMENT '学科',
  `stu_cnt` int(11) DEFAULT NULL COMMENT '参加考试人数',
  `chengji_cnt` int(11) DEFAULT NULL COMMENT '有成绩数',
  `sum` decimal(10,1) DEFAULT NULL COMMENT '总分',
  `avg` decimal(6,2) DEFAULT NULL COMMENT '平均分',
  `defenlv` decimal(6,2) DEFAULT NULL COMMENT '得分率',
  `biaozhuncha` decimal(6,2) DEFAULT NULL COMMENT '标准差',
  `youxiu` decimal(6,2) DEFAULT NULL COMMENT '优秀',
  `jige` decimal(6,2) DEFAULT NULL COMMENT '及格',
  `max` decimal(5,1) DEFAULT NULL COMMENT '最大',
  `min` decimal(5,1) DEFAULT NULL COMMENT '最小',
  `q1` decimal(6,2) DEFAULT NULL COMMENT '下25%',
  `q2` decimal(6,2) DEFAULT NULL COMMENT '中间%25',
  `q3` decimal(6,2) DEFAULT NULL COMMENT '上面25%',
  `zhongshu` varchar(100) DEFAULT NULL COMMENT '众数',
  `zhongweishu` decimal(10,0) DEFAULT NULL COMMENT '中位数',
  `create_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '更新时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0=禁用，1=正常',
  PRIMARY KEY (`id`),
  UNIQUE KEY `kaoshi_id` (`kaoshi_id`,`subject_id`,`ruxuenian`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;

-- -----------------------------
-- Records of `cj_tongji_sch`
-- -----------------------------
INSERT INTO `cj_tongji_sch` VALUES ('1', '1', '2019', '101', '34', '34', '1845.0', '54.26', '54.26', '28.08', '17.65', '41.18', '100.0', '1.0', '33.25', '56.00', '75.00', '', '100', '1599030235', '1599030235', '', '1');
INSERT INTO `cj_tongji_sch` VALUES ('2', '1', '2019', '102', '34', '34', '1877.0', '55.21', '55.21', '30.78', '17.65', '52.94', '98.0', '1.0', '31.50', '62.50', '77.00', '77、98', '98', '1599030235', '1599030235', '', '1');
INSERT INTO `cj_tongji_sch` VALUES ('3', '1', '2019', '103', '34', '34', '1748.0', '51.41', '51.41', '29.71', '11.76', '47.06', '100.0', '0.0', '23.00', '58.00', '70.00', '', '100', '1599030235', '1599030235', '', '1');
INSERT INTO `cj_tongji_sch` VALUES ('4', '1', '2019', '0', '34', '34', '5470.0', '160.88', '53.63', '56.12', '', '5.88', '243.0', '31.0', '127.75', '172.50', '204.50', '', '243', '1599030235', '1599030235', '', '1');
INSERT INTO `cj_tongji_sch` VALUES ('5', '1', '2020', '101', '110', '110', '5173.0', '47.03', '47.03', '30.17', '9.09', '38.18', '100.0', '1.0', '18.25', '48.00', '72.75', '14', '100', '1599030235', '1599030235', '', '1');
INSERT INTO `cj_tongji_sch` VALUES ('6', '1', '2020', '102', '110', '110', '5270.0', '47.91', '47.91', '27.73', '5.45', '38.18', '99.0', '1.0', '22.25', '45.50', '72.75', '85', '99', '1599030235', '1599030235', '', '1');
INSERT INTO `cj_tongji_sch` VALUES ('7', '1', '2020', '103', '110', '110', '5196.0', '47.24', '47.24', '27.07', '6.36', '31.82', '98.0', '0.0', '25.25', '48.00', '70.75', '39、42、48、51、58、59、74', '98', '1599030235', '1599030235', '', '1');
INSERT INTO `cj_tongji_sch` VALUES ('8', '1', '2020', '0', '110', '110', '15639.0', '142.17', '47.39', '48.56', '', '5.45', '241.0', '29.0', '106.25', '143.50', '179.50', '147、151、169、175、181', '241', '1599030235', '1599030235', '', '1');
INSERT INTO `cj_tongji_sch` VALUES ('9', '2', '2019', '101', '34', '34', '1921.0', '56.50', '56.50', '27.40', '14.71', '52.94', '97.0', '6.0', '31.25', '61.50', '75.75', '', '97', '1599030250', '1599030250', '', '1');
INSERT INTO `cj_tongji_sch` VALUES ('10', '2', '2019', '102', '34', '34', '1757.0', '51.68', '51.68', '29.76', '8.82', '47.06', '98.0', '1.0', '23.50', '54.00', '76.50', '', '98', '1599030250', '1599030250', '', '1');
INSERT INTO `cj_tongji_sch` VALUES ('11', '2', '2019', '103', '34', '34', '1515.0', '44.56', '44.56', '29.61', '8.82', '26.47', '98.0', '0.0', '22.50', '46.00', '62.00', '4、59', '98', '1599030250', '1599030250', '', '1');
INSERT INTO `cj_tongji_sch` VALUES ('12', '2', '2019', '0', '34', '34', '5193.0', '152.74', '50.91', '42.35', '', '5.88', '235.0', '88.0', '121.25', '149.00', '181.50', '', '235', '1599030250', '1599030250', '', '1');
INSERT INTO `cj_tongji_sch` VALUES ('13', '2', '2020', '101', '110', '110', '5312.0', '48.29', '48.29', '27.87', '10.00', '36.36', '100.0', '1.0', '27.50', '48.50', '69.50', '9', '100', '1599030251', '1599030251', '', '1');
INSERT INTO `cj_tongji_sch` VALUES ('14', '2', '2020', '102', '110', '110', '5345.0', '48.59', '48.59', '28.32', '9.09', '39.09', '100.0', '1.0', '26.00', '49.00', '71.75', '60', '100', '1599030251', '1599030251', '', '1');
INSERT INTO `cj_tongji_sch` VALUES ('15', '2', '2020', '103', '110', '110', '5465.0', '49.68', '49.68', '29.73', '10.91', '38.18', '100.0', '0.0', '23.25', '50.00', '74.00', '36、38、70、88', '100', '1599030251', '1599030251', '', '1');
INSERT INTO `cj_tongji_sch` VALUES ('16', '2', '2020', '0', '110', '110', '16122.0', '146.56', '48.85', '53.64', '', '6.36', '268.0', '29.0', '108.50', '149.50', '180.00', '127、142、174、180', '268', '1599030251', '1599030251', '', '1');
INSERT INTO `cj_tongji_sch` VALUES ('17', '3', '2019', '101', '34', '32', '1766.0', '55.19', '55.19', '30.19', '15.63', '50.00', '99.0', '1.0', '35.50', '57.00', '83.25', '', '99', '1599030263', '1599030263', '', '1');
INSERT INTO `cj_tongji_sch` VALUES ('18', '3', '2019', '102', '34', '30', '1496.0', '49.87', '49.87', '30.61', '16.67', '43.33', '96.0', '0.0', '24.25', '49.00', '70.75', '92', '96', '1599030263', '1599030263', '', '1');
INSERT INTO `cj_tongji_sch` VALUES ('19', '3', '2019', '103', '34', '27', '1104.0', '40.89', '40.89', '25.53', '3.70', '25.93', '97.0', '0.0', '20.50', '44.00', '59.50', '31、51', '97', '1599030263', '1599030263', '', '1');
INSERT INTO `cj_tongji_sch` VALUES ('20', '3', '2019', '0', '34', '32', '4366.0', '136.44', '45.48', '49.99', '', '2.94', '226.0', '43.0', '98.25', '133.50', '176.25', '', '226', '1599030263', '1599030263', '', '1');
INSERT INTO `cj_tongji_sch` VALUES ('21', '3', '2020', '101', '110', '108', '5368.0', '49.70', '49.70', '27.75', '8.33', '36.11', '100.0', '1.0', '30.50', '50.00', '71.00', '53', '100', '1599030263', '1599030263', '', '1');
INSERT INTO `cj_tongji_sch` VALUES ('22', '3', '2020', '102', '110', '107', '5137.0', '48.01', '48.01', '29.84', '12.15', '41.12', '100.0', '1.0', '21.00', '47.00', '71.00', '66', '100', '1599030263', '1599030263', '', '1');
INSERT INTO `cj_tongji_sch` VALUES ('23', '3', '2020', '103', '110', '108', '4891.0', '45.29', '45.29', '29.10', '6.48', '37.04', '99.0', '0.0', '17.75', '49.50', '70.25', '61', '99', '1599030263', '1599030263', '', '1');
INSERT INTO `cj_tongji_sch` VALUES ('24', '3', '2020', '0', '110', '110', '15396.0', '139.96', '46.65', '46.91', '', '5.45', '255.0', '13.0', '109.25', '137.00', '172.00', '84、101、122、133、142、153、198', '255', '1599030264', '1599030264', '', '1');
INSERT INTO `cj_tongji_sch` VALUES ('25', '4', '2019', '101', '34', '34', '1663.0', '48.91', '48.91', '30.49', '14.71', '35.29', '99.0', '1.0', '24.50', '45.50', '68.25', '', '99', '1599030276', '1599030276', '', '1');
INSERT INTO `cj_tongji_sch` VALUES ('26', '4', '2019', '102', '34', '34', '1569.0', '46.15', '46.15', '28.66', '11.76', '26.47', '100.0', '0.0', '25.00', '41.00', '65.25', '', '100', '1599030276', '1599030276', '', '1');
INSERT INTO `cj_tongji_sch` VALUES ('27', '4', '2019', '103', '34', '34', '1509.0', '44.38', '44.38', '29.99', '5.88', '38.24', '91.0', '1.0', '20.25', '38.00', '71.75', '', '91', '1599030276', '1599030276', '', '1');
INSERT INTO `cj_tongji_sch` VALUES ('28', '4', '2019', '0', '34', '34', '4741.0', '139.44', '46.48', '49.60', '', '0.00', '229.0', '25.0', '117.00', '139.00', '166.75', '', '229', '1599030276', '1599030276', '', '1');
INSERT INTO `cj_tongji_sch` VALUES ('29', '4', '2020', '101', '110', '110', '5593.0', '50.85', '50.85', '29.15', '10.91', '40.00', '100.0', '0.0', '27.00', '49.00', '77.00', '11、31、55、76、89', '100', '1599030277', '1599030277', '', '1');
INSERT INTO `cj_tongji_sch` VALUES ('30', '4', '2020', '102', '110', '110', '5540.0', '50.36', '50.36', '29.09', '11.82', '41.82', '99.0', '0.0', '26.50', '50.50', '74.00', '38、61', '99', '1599030277', '1599030277', '', '1');
INSERT INTO `cj_tongji_sch` VALUES ('31', '4', '2020', '103', '110', '110', '4769.0', '43.35', '43.35', '29.14', '8.18', '35.45', '97.0', '0.0', '18.00', '38.50', '67.50', '14', '97', '1599030277', '1599030277', '', '1');
INSERT INTO `cj_tongji_sch` VALUES ('32', '4', '2020', '0', '110', '110', '15902.0', '144.56', '48.19', '49.74', '', '5.45', '276.0', '34.0', '116.00', '147.50', '177.75', '72、116、118、129、151、165、189', '276', '1599030277', '1599030277', '', '1');
INSERT INTO `cj_tongji_sch` VALUES ('33', '5', '2019', '101', '34', '34', '1993.0', '58.62', '58.62', '32.01', '20.59', '61.76', '98.0', '1.0', '38.25', '63.00', '86.75', '63', '98', '1599030291', '1599030291', '', '1');
INSERT INTO `cj_tongji_sch` VALUES ('34', '5', '2019', '103', '34', '34', '1799.0', '52.91', '52.91', '24.78', '11.76', '38.24', '95.0', '5.0', '41.00', '52.50', '68.00', '46', '95', '1599030291', '1599030291', '', '1');
INSERT INTO `cj_tongji_sch` VALUES ('35', '5', '2019', '0', '34', '34', '3792.0', '111.53', '55.76', '41.65', '', '26.47', '182.0', '14.0', '80.00', '115.00', '140.25', '', '182', '1599030291', '1599030291', '', '1');
INSERT INTO `cj_tongji_sch` VALUES ('36', '5', '2020', '101', '110', '110', '5419.0', '49.26', '49.26', '30.37', '14.55', '38.18', '100.0', '0.0', '22.25', '47.50', '76.25', '6、61', '100', '1599030291', '1599030291', '', '1');
INSERT INTO `cj_tongji_sch` VALUES ('37', '5', '2020', '103', '110', '110', '5396.0', '49.05', '49.05', '29.83', '11.82', '39.09', '100.0', '2.0', '23.25', '46.50', '76.00', '46、94', '100', '1599030291', '1599030291', '', '1');
INSERT INTO `cj_tongji_sch` VALUES ('38', '5', '2020', '0', '110', '110', '10815.0', '98.32', '49.16', '40.10', '', '13.64', '187.0', '8.0', '66.00', '96.00', '124.25', '52、58、61、66、67、73、87、96、105、113、116、165', '187', '1599030291', '1599030291', '', '1');
INSERT INTO `cj_tongji_sch` VALUES ('39', '6', '2019', '101', '34', '34', '1460.0', '42.94', '39.76', '11.52', '0.00', '0.00', '60.0', '20.0', '32.25', '46.00', '51.00', '41、49', '60', '1599031951', '1599031951', '', '1');
INSERT INTO `cj_tongji_sch` VALUES ('40', '6', '2019', '102', '34', '34', '1573.0', '46.26', '38.55', '12.43', '0.00', '0.00', '65.0', '23.0', '36.00', '49.00', '55.50', '53', '65', '1599031951', '1599031951', '', '1');
INSERT INTO `cj_tongji_sch` VALUES ('41', '6', '2019', '103', '34', '34', '1886.0', '55.47', '42.67', '18.76', '0.00', '20.59', '86.0', '20.0', '41.50', '53.50', '72.75', '59、80', '86', '1599031951', '1599031951', '', '1');
INSERT INTO `cj_tongji_sch` VALUES ('42', '6', '2019', '0', '34', '34', '4919.0', '144.68', '40.41', '28.24', '', '0.00', '188.0', '75.0', '131.25', '151.50', '165.00', '165、176', '188', '1599031951', '1599031951', '', '1');
INSERT INTO `cj_tongji_sch` VALUES ('43', '6', '2020', '101', '110', '110', '5613.0', '51.03', '47.25', '30.18', '7.27', '40.00', '107.0', '0.0', '24.00', '48.00', '77.50', '28', '107', '1599031951', '1599031951', '', '1');
INSERT INTO `cj_tongji_sch` VALUES ('44', '6', '2020', '102', '110', '110', '7615.0', '69.23', '57.69', '33.68', '15.45', '49.09', '120.0', '0.0', '46.00', '70.50', '100.00', '43、73', '120', '1599031951', '1599031951', '', '1');
INSERT INTO `cj_tongji_sch` VALUES ('45', '6', '2020', '103', '110', '110', '7996.0', '72.69', '55.92', '35.76', '10.91', '42.73', '130.0', '2.0', '49.00', '74.00', '106.75', '53、64、73、76、77、99、111', '130', '1599031951', '1599031951', '', '1');
INSERT INTO `cj_tongji_sch` VALUES ('46', '6', '2020', '0', '110', '110', '21224.0', '192.95', '53.90', '54.60', '', '8.18', '315.0', '65.0', '158.00', '198.50', '232.00', '201', '315', '1599031951', '1599031951', '', '1');
INSERT INTO `cj_tongji_sch` VALUES ('47', '7', '2020', '101', '66', '66', '3410.0', '51.67', '51.67', '26.60', '7.58', '43.94', '96.0', '0.0', '29.00', '48.00', '74.75', '86、95', '96', '1599031967', '1599031967', '', '1');
INSERT INTO `cj_tongji_sch` VALUES ('48', '7', '2020', '102', '66', '66', '3219.0', '48.77', '48.77', '28.55', '12.12', '37.88', '98.0', '0.0', '24.25', '47.50', '67.75', '17', '98', '1599031967', '1599031967', '', '1');
INSERT INTO `cj_tongji_sch` VALUES ('49', '7', '2020', '103', '66', '66', '3856.0', '58.42', '58.42', '29.47', '18.18', '50.00', '100.0', '1.0', '38.25', '59.50', '84.75', '39、97', '100', '1599031967', '1599031967', '', '1');
INSERT INTO `cj_tongji_sch` VALUES ('50', '7', '2020', '0', '66', '66', '10485.0', '158.86', '52.95', '50.14', '', '9.09', '269.0', '53.0', '130.75', '159.00', '193.75', '', '269', '1599031967', '1599031967', '', '1');
INSERT INTO `cj_tongji_sch` VALUES ('51', '9', '2019', '101', '34', '34', '1758.0', '51.71', '51.71', '31.44', '14.71', '47.06', '99.0', '2.0', '26.00', '53.00', '77.50', '', '99', '1599032473', '1599032473', '', '1');
INSERT INTO `cj_tongji_sch` VALUES ('52', '9', '2019', '102', '34', '34', '1564.0', '46.00', '46.00', '33.53', '11.76', '38.24', '100.0', '0.0', '16.25', '41.50', '78.25', '', '100', '1599032473', '1599032473', '', '1');
INSERT INTO `cj_tongji_sch` VALUES ('53', '9', '2019', '103', '34', '34', '1502.0', '44.18', '44.18', '28.81', '8.82', '29.41', '96.0', '0.0', '24.00', '35.50', '62.75', '', '96', '1599032473', '1599032473', '', '1');
INSERT INTO `cj_tongji_sch` VALUES ('54', '9', '2019', '0', '34', '34', '4824.0', '141.88', '47.29', '59.99', '', '5.88', '261.0', '19.0', '103.00', '139.50', '191.25', '', '261', '1599032473', '1599032473', '', '1');
INSERT INTO `cj_tongji_sch` VALUES ('55', '9', '2020', '101', '110', '110', '5476.0', '49.78', '49.78', '27.20', '7.27', '40.00', '97.0', '0.0', '30.00', '50.00', '71.75', '30、39、41', '97', '1599032474', '1599032474', '', '1');
INSERT INTO `cj_tongji_sch` VALUES ('56', '9', '2020', '102', '110', '110', '5164.0', '46.95', '46.95', '29.50', '9.09', '36.36', '99.0', '0.0', '20.25', '46.00', '74.00', '15', '99', '1599032474', '1599032474', '', '1');
INSERT INTO `cj_tongji_sch` VALUES ('57', '9', '2020', '103', '110', '110', '5138.0', '46.71', '46.71', '27.12', '6.36', '33.64', '98.0', '2.0', '24.25', '44.00', '71.00', '81', '98', '1599032474', '1599032474', '', '1');
INSERT INTO `cj_tongji_sch` VALUES ('58', '9', '2020', '0', '110', '110', '15778.0', '143.44', '47.81', '43.69', '', '2.73', '256.0', '56.0', '115.25', '139.00', '173.00', '156、188', '256', '1599032474', '1599032474', '', '1');

-- -----------------------------
-- Table structure for `cj_xueqi`
-- -----------------------------
DROP TABLE IF EXISTS `cj_xueqi`;
CREATE TABLE `cj_xueqi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(25) NOT NULL DEFAULT 'a' COMMENT '学期标题',
  `xuenian` varchar(15) NOT NULL DEFAULT 'a' COMMENT '学年标题',
  `category_id` int(11) NOT NULL DEFAULT '0' COMMENT '学期分类',
  `bfdate` int(11) NOT NULL DEFAULT '1539158918' COMMENT '开始日期',
  `enddate` int(11) NOT NULL DEFAULT '1539158918' COMMENT '结束日期',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0=禁用，1=正常',
  `create_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '1539158918' COMMENT '更新时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  `beizhu` varchar(80) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- -----------------------------
-- Records of `cj_xueqi`
-- -----------------------------
INSERT INTO `cj_xueqi` VALUES ('1', '2019~2020学年度第一学期', '2019~2020学年度', '10801', '1564588800', '1580486400', '1', '1599023154', '1599023154', '', '');
INSERT INTO `cj_xueqi` VALUES ('2', '2019~2020学年度第二学期', '2019~2020学年度', '10802', '1580486400', '1596211200', '1', '1599023190', '1599025012', '', '');
