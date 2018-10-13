DROP TABLE IF EXISTS `php4world_auth_group`;
CREATE TABLE `php4world_auth_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '用户组中文名称',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态：1正常，0禁用',
  `rules` varchar(500) NOT NULL DEFAULT '' COMMENT '用户组拥有的规则ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户组表';


DROP TABLE IF EXISTS `php4world_auth_group_access`;
CREATE TABLE `php4world_auth_group_access` (
  `uid` int(10) unsigned NOT NULL COMMENT '用户ID',
  `group_id` int(10) unsigned NOT NULL COMMENT '用户组ID',
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户组关系表';


DROP TABLE IF EXISTS `php4world_auth_rule`;
CREATE TABLE `php4world_auth_rule` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '规则中文名称',
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '规则唯一标识',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态：1正常，0禁用',
  `condition` varchar(200) NOT NULL DEFAULT '' COMMENT '规则表达式，为空表示存在就验证，不为空表示按照条件验证',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='规则表';
